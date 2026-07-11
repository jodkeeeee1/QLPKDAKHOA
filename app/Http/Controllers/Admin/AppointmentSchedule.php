<?php

namespace App\Http\Controllers\Admin;

use App\Events\Admin\BookingUpdated;
use App\Http\Controllers\Controller;
use App\Jobs\SendBookingConfirmation;
use App\Mail\BookingConfirmationLink;
use App\Models\Book;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\Sclinic;
use App\Models\TableShift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AppointmentSchedule extends Controller
{
    public function index(Request $request)
    {
        $query = Book::leftJoin('specialties', 'specialties.specialty_id', '=', 'books.specialty_id')
            ->leftJoin('schedules', 'schedules.shift_id', '=', 'books.shift_id')
            ->leftJoin('users', 'users.user_id', '=', 'books.user_id')
            ->leftJoin('table_shifts', 'table_shifts.shift_id', '=', 'books.shift_id')
            ->select(
    'books.*',
    DB::raw('MAX(users.lastname) as lastname'),
    DB::raw('MAX(users.firstname) as firstname'),
    DB::raw('MAX(specialties.name) as specialtyName'),
    DB::raw('MAX(table_shifts.name) as shiftName')
)
            ->groupBy(
                'books.row_id',
                'books.book_id',
                'books.name',
                'books.day',
                'books.phone',
                'books.hour',
                'books.email',
                'books.url',
                'books.role',
                'books.status',
                'books.specialty_id',
                'books.user_id',
                'books.shift_id',
                'books.table_shift_id',
                'books.symptoms',
                'books.deleted_at',
                'books.created_at',
                'books.updated_at',
                'books.stt',
            )
            ->orderByRaw('CASE WHEN books.status = 0 THEN 0 ELSE 1 END')
            ->orderBy('books.row_id', 'DESC');

        $activeTab = $request->query('tab', default: 'nav-home'); // Tab mặc định là 'nav-home'

        // Tìm kiếm theo tên, số điện thoại, trạng thái, ngày từ/đến
        if ($request->filled('name')) {
            $query->where('books.name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('phone')) {
            $query->where('books.phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('status')) {
            $query->where('books.status', $request->status);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('books.created_at', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $query->whereDate('books.created_at', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $query->whereDate('books.created_at', '<=', $request->date_to);
        }

        $booksOnline = clone $query;
        $booksOffline = clone $query;


        $booksOnline = $booksOnline->where('books.role', 1)->paginate(10)->appends($request->all());
$booksOffline = $booksOffline
    ->paginate(10)
    ->appends($request->all());      $selectedDate = $request->week_date
    ? Carbon::parse($request->week_date)
    : now();

// lấy đầu tuần và cuối tuần
$startOfWeek = $selectedDate->copy()->startOfWeek(Carbon::MONDAY);
$endOfWeek = $selectedDate->copy()->endOfWeek(Carbon::SUNDAY);

// lấy dữ liệu theo tuần
$chartData = Book::select(
        DB::raw('DATE(day) as booking_date'),
        DB::raw('COUNT(*) as total_patients')
    )
    ->where('status', '!=', 4)
    ->whereBetween('day', [
        $startOfWeek->format('Y-m-d'),
        $endOfWeek->format('Y-m-d')
    ])
    ->groupBy('booking_date')
    ->orderBy('booking_date', 'ASC')
    ->get();

// tạo đủ 7 ngày trong tuần
$dates = [];
$totals = [];

for ($date = $startOfWeek->copy(); $date <= $endOfWeek; $date->addDay()) {

    $formattedDate = $date->format('Y-m-d');

    $dates[] = $date->format('d/m');

    $found = $chartData->firstWhere('booking_date', $formattedDate);

    $totals[] = $found ? $found->total_patients : 0;
}
if ($request->ajax()) {
    return response()->json([
        'navHome' => view('System.appointmentschedule.offline', [
            'book' => $booksOffline
        ])->render(),

        'navContact' => view('System.appointmentschedule.online', [
            'book' => $booksOnline
        ])->render(),
    ]);
}
        return view('System.appointmentschedule.index', [
    'booksOnline' => $booksOnline,
    'booksOffline' => $booksOffline,
    'activeTab' => $activeTab,
    'dates' => $dates,
    'totals' => $totals
]);
    }


    public function edit(Request $request, $id)
    {
        $book = Book::where('book_id', $id)->first();
        $specialty_id = $book->specialty_id;
        $selectedDay = $request->input('appointment_time');
        $date = Carbon::parse($selectedDay, 'Asia/Ho_Chi_Minh')->setTimezone('UTC')->format('Y-m-d');

        // dd($date);

        $schedulesQuery = Schedule::leftJoin('table_shifts', 'table_shifts.shift_id', '=', 'schedules.shift_id')
            ->join('users', 'users.user_id', '=', 'schedules.user_id')
            ->whereDate('schedules.day', $book->day)
            ->where('users.specialty_id', $specialty_id)
            ->select('schedules.*')
            ->groupBy(
                'schedules.shift_id',
                'schedules.user_id',
                'schedules.note',
                'schedules.status',
                'schedules.day',
                'schedules.row_id',
                'schedules.sclinic_id',
                'schedules.created_at',
                'schedules.updated_at',
                'schedules.deleted_at'
            );

        if ($book->role == 1) {
            $schedulesQuery->where('table_shifts.status', 0);
        }

        $schedules = $schedulesQuery->get();
        // dd($schedulesQuery);
        // dd($schedules);

        return response()->json([
            'appointment_time' => $book->day,
            'hour' => $book->hour,
            'schedules' => $schedules,
            'specialty_id' => $specialty_id,
            'status' => $book->status,
            'role' => $book->role,
            'email' => $book->email,
            'url' => $book->url,
            'user_id' => $book->user_id
        ]);
    }

    public function getDoctorsByDate(Request $request)
{
    $date = $request->input('date');
    $specialtyId = $request->input('specialty_id');
    $role = $request->input('role');
    $selectedDoctor = $request->input('selectedDoctor');

    $doctorsQuery = User::join('schedules', 'schedules.user_id', '=', 'users.user_id')
        ->where('users.role', 2)
        ->where('users.specialty_id', $specialtyId)
        ->whereDate('schedules.day', $date)
        ->whereNull('schedules.deleted_at')
        ->select(
            'users.user_id',
            'users.firstname',
            'users.lastname',
            'schedules.shift_id',
            'schedules.status'
        );

    // lấy bác sĩ đang sửa luôn
    $doctorsQuery->where(function ($q) use ($selectedDoctor) {
        $q->whereIn('schedules.status', [0, 1]);

        if ($selectedDoctor) {
            $q->orWhere('users.user_id', $selectedDoctor);
        }
    });

    $doctors = $doctorsQuery
        ->groupBy(
            'users.user_id',
            'users.firstname',
            'users.lastname',
            'schedules.shift_id',
            'schedules.status'
        )
        ->get();

    if ($doctors->isEmpty()) {
        return response()->json([
            'doctors' => [],
            'shifts' => []
        ]);
    }

    $shift_id = $doctors->first()->shift_id;

    $shifts = TableShift::join('schedules', 'schedules.shift_id', '=', 'table_shifts.shift_id')
        ->where('table_shifts.shift_id', $shift_id)
        ->where('table_shifts.status', 0)
        ->select('table_shifts.*')
        ->get();

    return response()->json([
        'doctors' => $doctors,
        'shifts' => $shifts
    ]);
}
  public function update($id, Request $request)
{
    $book = Book::where('book_id', $id)->first();

    if (!$book) {

        return response()->json([
            'error' => true,
            'message' => 'Không tìm thấy lịch khám'
        ]);
    }

    $status = $request->status;

    // cập nhật trạng thái
    $book->status = $status;
    $book->save();

    // XÁC NHẬN
    if ($status == 1) {

        // tạo order nếu chưa có
        $checkOrder = Order::where('book_id', $book->book_id)->first();

        if (!$checkOrder) {

            Order::create([
                'book_id' => $book->book_id,
                'order_id' => strtoupper(Str::random(10)),
                'payment' => 1,
                'status' => 1,
                'total_price' => 200000
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã xác nhận lịch khám'
        ]);
    }

    // HỦY
    if ($status == 4) {

        return response()->json([
            'success' => true,
            'message' => 'Đã hủy lịch khám'
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Cập nhật thành công'
    ]);
}
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('system.appointmentSchedule')->with('success', 'Xóa thành công');
    }
}