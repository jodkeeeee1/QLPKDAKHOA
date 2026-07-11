<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\TreatmentDetail;
use App\Models\TreatmentService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    public function getDashboard()
    {
        return view('System.index', [
            'patientData' => $this->getDashboardColumnChart(),
            'priceData' => $this->getDashboardPieChart(),
            'serviceTop' => $this->getServiceTop(),
            'transactions' => $this->getRecentTransactions(),
            'transactionsMonthData' => $this->getDashboardLineChart()
        ]);
    }

    public function getDashboardColumnChart()
    {
        Carbon::setLocale('vi');
        $now = Carbon::now();

        $patientData = [];

        for ($i = 0; $i < 6; $i++) {
            $date = $now->copy()->subMonths($i);

            $totalPatient = Patient::whereMonth('created_at', $date->format('m'))
                ->whereYear('created_at', $date->format('Y'))
                ->whereNull('deleted_at')
                ->count();

            $patientData[] = [
                'date_month' => $date->format('M'),
                'total_patient' => $totalPatient
            ];
        }

        return array_reverse($patientData);
    }

    public function getDashboardPieChart()
    {
        Carbon::setLocale('vi');
        $now = Carbon::now();

        $priceData = [];

        for ($i = 0; $i < 3; $i++) {
            $date = $now->copy()->subMonths($i);

            $totalPrice = TreatmentDetail::join('treatment_services', 'treatment_services.treatment_id', '=', 'treatment_details.treatment_id')
                ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
                ->whereMonth('treatment_details.created_at', $date->format('m'))
                ->whereYear('treatment_details.created_at', $date->format('Y'))
                ->sum('services.price');

            $priceData[] = [
                'data_months' => $date->format('M'),
                'total_price' => $totalPrice
            ];
        }

        return array_reverse($priceData);
    }

    public function getDashboardLineChart()
    {
        $now = Carbon::now();

        return TreatmentDetail::join('treatment_services', 'treatment_services.treatment_id', '=', 'treatment_details.treatment_id')
            ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
            ->select(
                DB::raw('DATE(treatment_details.created_at) as day'),
                DB::raw('SUM(services.price) as total_price')
            )
            ->whereMonth('treatment_details.created_at', $now->format('m'))
            ->whereYear('treatment_details.created_at', $now->format('Y'))
            ->groupBy(DB::raw('DATE(treatment_details.created_at)'))
            ->orderBy(DB::raw('DATE(treatment_details.created_at)'))
            ->get();
    }

    public function getServiceTop()
    {
        $serviceTop = TreatmentDetail::join('treatment_services', 'treatment_services.treatment_id', '=', 'treatment_details.treatment_id')
            ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
            ->select(
                'services.name',
                DB::raw('COUNT(treatment_services.service_id) as usage_count')
            )
            ->groupBy('services.name')
            ->orderByDesc('usage_count')
            ->limit(6)
            ->get();

        $total = $serviceTop->sum('usage_count');

        foreach ($serviceTop as $item) {
            $item->percentage = $total > 0
                ? round(($item->usage_count / $total) * 100, 2)
                : 0;
        }

        return $serviceTop;
    }

    public function getRecentTransactions()
    {
        return TreatmentDetail::join('treatment_services', 'treatment_services.treatment_id', '=', 'treatment_details.treatment_id')
            ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
            ->select('treatment_details.*', 'services.name', 'services.price')
            ->orderByDesc('treatment_details.treatment_id')
            ->limit(6)
            ->get();
    }
}