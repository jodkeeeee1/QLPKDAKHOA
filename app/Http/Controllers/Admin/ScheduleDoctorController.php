<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleDoctorController extends Controller
{
  public function index()
{
    Carbon::setLocale('vi');

    $now = Carbon::now();

    $user = auth()->user();

    $schedules = Schedule::join(
            'users',
            'users.user_id',
            '=',
            'schedules.user_id'
        )
        ->join(
            'specialties',
            'specialties.specialty_id',
            '=',
            'schedules.specialty_id'
        )
        ->join(
            'table_shifts',
            'table_shifts.shift_id',
            '=',
            'schedules.shift_id'
        )
        ->where('schedules.user_id', $user->user_id)

        ->whereMonth('schedules.day', $now->month)

        ->whereYear('schedules.day', $now->year)

        ->select(
            'schedules.*',

            'users.firstname',
            'users.lastname',

            'specialties.name as specialty_name',

            'table_shifts.name as shift_name',
            'table_shifts.start_time',
            'table_shifts.end_time'
        )

        ->orderBy('schedules.day')

        ->get();

    return view(
        'System.doctors.schedules.index',
        compact('schedules', 'now')
    );
}
}
