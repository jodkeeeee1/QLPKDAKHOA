<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\Service;
use App\Models\TreatmentDetail;
use App\Models\TreatmentMedication;
use Illuminate\Support\Facades\DB;
use App\Models\TreatmentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorHTML;

class PDFController extends Controller
{
    public function printService(Request $request, $treatment_id)
    {

        $services = Service::join('treatment_services', 'treatment_services.service_id', '=', 'services.service_id')
            ->join('treatment_details', 'treatment_details.treatment_id', '=', 'treatment_services.treatment_id')
            ->where('treatment_services.treatment_id', $treatment_id)
            ->get();

        $totalprice = TreatmentService::where('treatment_id', $treatment_id)
            ->join('services', 'treatment_services.service_id', '=', 'services.service_id')
            ->select(
                'treatment_services.treatment_id',
                DB::raw('COUNT(services.service_id) AS service_count'),
                DB::raw('SUM(services.price) AS total_price')
            )
            ->groupBy(
                'treatment_services.treatment_id',
                'treatment_services.note',
                'treatment_services.result',
                'treatment_services.service_id',
                'treatment_services.deleted_at',
                'treatment_services.created_at',
                'treatment_services.updated_at',
            )
            ->get();

        $streatment = TreatmentDetail::where('treatment_id', $treatment_id)
    ->latest('created_at')
    ->first();
        $medical_id = $streatment->medical_id;

$medical = MedicalRecord::with('patient')
    ->where('medical_id', $medical_id)
    ->first();

if (!$medical) {
    return back()->with('error', 'Không tìm thấy hồ sơ bệnh án');
}

$specialty = Book::where('book_id', $medical->book_id)
    ->join('specialties', 'specialties.specialty_id', '=', 'books.specialty_id')
    ->select('specialties.name as name')
    ->first();
    $doctor = DB::table('users')
    ->where('user_id', $medical->user_id ?? null)
    ->first();
        $order = Order::where('treatment_id', $treatment_id)->first();

if (!$order) {
    return back()->with('error', 'Không tìm thấy đơn dịch vụ');
}

$order_id = $order->order_id;
       $totalprice = TreatmentService::where('treatment_services.treatment_id', $treatment_id)
    ->join('services', 'services.service_id', '=', 'treatment_services.service_id')
    ->sum('services.price');

$total = $totalprice;
        $data = [
            'services' => $services,
            'total' => $total,
            'medical' => $medical,
            'specialty' => $specialty,
            'order_id' => $order_id,
            'doctor' => $doctor,
        ];



        $generatorHTML = new BarcodeGeneratorHTML();
        $barcode = $generatorHTML->getBarcode($order_id, $generatorHTML::TYPE_CODE_128);
        $pdf = Pdf::loadView('System.doctors.checkupHealth.pdfService', [
            'data' => $data,
            'barcode' => $barcode
        ]);
        $pdf->setPaper('A4', 'landscape');


        $fileName = "Dichvu_{$order_id}.pdf";

        return $pdf->download($fileName);
    }


    public function printMedical($medical_id)
    {

       $medicals = MedicalRecord::select(
    'medical_records.*',

    'patients.first_name',
    'patients.last_name',
    'patients.phone',
    'patients.address',
    'patients.gender',
    'patients.birthday as patient_birthday',

    'users.firstname as doctor_firstname',
    'users.lastname as doctor_lastname',

    'treatment_details.*',
    'specialties.name as specialty'
)
->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
->join('treatment_details', 'treatment_details.medical_id', '=', 'medical_records.medical_id')
->join('users', 'users.user_id', '=', 'medical_records.user_id')
->join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
->where('medical_records.medical_id', $medical_id)
->first();

        $treatment = TreatmentDetail::where('medical_id', $medical_id)->first();

        $treatment_id = $treatment->treatment_id;

        $services = Service::join('treatment_services', 'treatment_services.service_id', '=', 'services.service_id')
            ->where('treatment_services.treatment_id', $treatment_id)
            ->get();

        $totalprice = TreatmentService::where('treatment_id', $treatment_id)
            ->join('services', 'treatment_services.service_id', '=', 'services.service_id')
            ->select(
                'treatment_services.treatment_id',
                DB::raw('COUNT(services.service_id) AS service_count'),
                DB::raw('SUM(services.price) AS total_price')
            )
            ->groupBy(
                'treatment_services.treatment_id',
                'treatment_services.note',
                'treatment_services.result',
                'treatment_services.service_id',
                'treatment_services.deleted_at',
                'treatment_services.created_at',
                'treatment_services.updated_at',
            )
            ->get();

        $medicines = Medicine::join('treatment_medications', 'treatment_medications.medicine_id', '=', 'medicines.medicine_id')
            ->where('treatment_medications.treatment_id', $treatment_id)
            ->get();



        $data = [
            'totalprice' => $totalprice,
            'medicals' => $medicals,
            'medicines' => $medicines,
            'services' => $services,



        ];

        // dd($data['totalprice'][0]->total_price);

        $pdf = Pdf::loadView('System.doctors.medical.pdfMedical', [
            'data' => $data,
        ]);
        $pdf->setPaper('A4', 'portrait');


        $fileName = "Hồ sơ bệnh án_{$medical_id}.pdf";

        return $pdf->download($fileName);
    }
}