<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Specialty;
use App\Models\TableShift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ScheduleController extends Controller
{
    public function index()
    {
        $specialties = Specialty::all();
        $shifts = TableShift::where('status', 1)->get();

        return view('System.schedules.index', compact('specialties', 'shifts'));
    }

    public function getDoctors(Request $request)
    {
        $users = User::where('role', 2)
            ->where('specialty_id', $request->specialty_id)
            ->get();

        return response()->json([
            'users' => $users
        ]);
    }
public function getData(Request $request)
{
    $query = Schedule::join('users', 'users.user_id', '=', 'schedules.user_id')
        ->join('specialties', 'specialties.specialty_id', '=', 'schedules.specialty_id')

        // ✅ JOIN SHIFT
        ->join('table_shifts', 'table_shifts.shift_id', '=', 'schedules.shift_id')

        ->select(
            'schedules.*',
            'users.lastname',
            'users.firstname',
            'users.phone',
            'specialties.name as specialty_name',

            
            'table_shifts.name as shift_name'
        )
        ->where('users.role', 2);

    if ($request->specialty_id) {
        $query->where('schedules.specialty_id', $request->specialty_id);
    }

    $schedule = $query->get();

    $events = [];

    foreach ($schedule as $item) {

        $events[] = [
            'id' => $item->row_id,

          
            'title' => $item->lastname . ' ' .
                       $item->firstname . ' - ' .
                       $item->shift_name,

            'start' => $item->day,

            'user_id' => $item->user_id,

            'shift_id' => $item->shift_id,

            
            'shift_name' => $item->shift_name,

            'specialty_id' => $item->specialty_id,
            'note' => $item->note,
            'status' => $item->status,
            
        ];
    }

    return response()->json($events);
}

    public function store(Request $request)
{
    $userId = $request->user_id;
    $specialtyId = $request->specialty_id;
    $shiftId = $request->shift_id;

    $day = Carbon::parse($request->day)->toDateString();

    if (Carbon::parse($day)->lt(now()->toDateString())) {
        return response()->json([
            'error' => true,
            'message' => 'Không thể tạo lịch trong quá khứ'
        ]);
    }

    // ❌ 1 ca tối đa 3 bác sĩ
    $shiftCount = Schedule::where('shift_id', $shiftId)
        ->where('day', $day)
        ->count();

    if ($shiftCount >= 3) {
        return response()->json([
            'error' => true,
            'message' => 'Ca này đã đủ 3 bác sĩ'
        ]);
    }

    // ❌ 1 bác sĩ tối đa 3 ca/ngày
    $totalShift = Schedule::where('user_id', $userId)
        ->where('day', $day)
        ->count();

    if ($totalShift >= 3) {
        return response()->json([
            'error' => true,
            'message' => 'Bác sĩ đã đủ 3 ca trong ngày'
        ]);
    }

    // ❌ không trùng ca của bác sĩ
    $exists = Schedule::where('user_id', $userId)
        ->where('day', $day)
        ->where('shift_id', $shiftId)
        ->exists();

    if ($exists) {
        return response()->json([
            'error' => true,
            'message' => 'Bác sĩ đã có lịch ca này'
        ]);
    }

    Schedule::create([
        'shift_id' => $shiftId,
        'specialty_id' => $specialtyId,
        'user_id' => $userId,
        'day' => $day,
        'note' => $request->note,
        'status' => $request->status
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Thêm lịch thành công'
    ]);
}

    public function edit($id)
    {
        $schedule = Schedule::join('users', 'users.user_id', '=', 'schedules.user_id')
            ->select(
                'schedules.*',
                'users.lastname',
                'users.firstname'
            )
            ->where('schedules.row_id', $id)
            ->first();

        return response()->json([
            'schedule' => $schedule
        ]);
    }

   public function update(Request $request, $id)
{
    $schedule = Schedule::where('row_id', $id)->firstOrFail();

    $day = Carbon::parse($request->day)->toDateString();
$shiftCount = Schedule::where('day', $day)
    ->where('shift_id', $request->shift_id)
    ->where('row_id', '!=', $id)
    ->count();

if ($shiftCount >= 3) {
    return response()->json([
        'error' => true,
        'message' => 'Ca này đã đủ 3 bác sĩ'
    ]);
}
    
    $totalShift = Schedule::where('user_id', $request->user_id)
        ->where('day', $day)
        ->where('row_id', '!=', $id)
        ->count();

    if ($totalShift >= 3) {
        return response()->json([
            'error' => true,
            'message' => 'Bác sĩ đã đủ 3 ca trong ngày'
        ]);
    }
    $exists = Schedule::where('user_id', $request->user_id)
        ->where('day', $day)
        ->where('shift_id', $request->shift_id)
        ->where('row_id', '!=', $id)
        ->exists();

    if ($exists) {
        return response()->json([
            'error' => true,
            'message' => 'Bác sĩ đã có lịch ca này'
        ]);
    }

    $schedule->day = $day;
    $schedule->user_id = $request->user_id;
    $schedule->note = $request->note;
    $schedule->shift_id = $request->shift_id;

    $schedule->save();

    return response()->json([
        'success' => true,
        'message' => 'Cập nhật thành công'
    ]);
}
    public function delete($id)
    {
        Schedule::where('row_id', $id)->firstOrFail()->delete();

        return response()->json([
            'success' => true
        ]);
    }
    
}