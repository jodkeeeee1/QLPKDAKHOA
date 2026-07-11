<?php

namespace App\Http\Controllers\Client;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Booking\BookingRequest;
use App\Models\Book;
use App\Models\Patient;
use App\Models\Specialty;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Mail\BookingConfirmation;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;
use Infobip\Api\SmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;
use Illuminate\Support\Facades\Log;
use Infobip\ApiException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
class BookController extends Controller
{
    // Hiển thị popup booking và chuyên khoa
    public function booking()
    {
        $showPopup = 'booking';
        $doctor = User::join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
            ->where('role', 2)
            ->select('users.*', 'specialties.specialty_id', 'specialties.name as specialtyName')
            ->limit(6)
            ->get();

        $patientInfo = Patient::where('phone', auth()->user()->phone)->first();

    if (!$patientInfo) {
        return redirect()->route('client.profile.index')
            ->with('error', 'Vui lòng tạo hồ sơ khám bệnh trước khi đặt lịch');
    }

    $requiredFields = [
        'first_name',
        'last_name',
        'gender',
        'birthday',
        'cccd',
        'address',
        'phone',
        'occupation',
        'national'
    ];

    foreach ($requiredFields as $field) {
        if (blank($patientInfo->$field)) {
            return redirect()->route('client.profile.index')
                ->with('error', 'Vui lòng nhập đầy đủ thông tin khám bệnh trước khi đặt lịch');
        }
    }

    return view('client.index', [
        'showPopup' => $showPopup,
        'doctor' => $doctor,
        'patientInfo' => $patientInfo
    ]);
        
    }
public function getDoctorsBySpecialty(Request $request)
{
    
    $specialtyId = $request->specialty_id;

    $day = $request->day;

    $doctors = \App\Models\User::join(
            'schedules',
            'schedules.user_id',
            '=',
            'users.user_id'
        )
        ->where('users.role', 2)

        ->where('schedules.specialty_id', $specialtyId)

        ->whereDate('schedules.day', $day)

        ->where('schedules.status', 0)

        ->select(
            'users.user_id',
            'users.firstname',
            'users.lastname'
        )
        ->distinct()
        ->get();

    return response()->json($doctors);
}
   public function handleBooking(Request  $request)
{
    
    $email = $request->email;

    // reCAPTCHA
    $recaptchaSecret = config('recaptcha.secret_key');

    $recaptchaResponse = $request->input('g-recaptcha-response');

    $recaptchaVerifyResponse = Http::asForm()->post(
        'https://www.google.com/recaptcha/api/siteverify',
        [
            'secret' => $recaptchaSecret,
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip(),
        ]
    );

    $recaptchaResult = $recaptchaVerifyResponse->json();

    if (!$recaptchaResult['success']) {

        return redirect()->back()
            ->withErrors([
                'g-recaptcha-response' => 'Vui lòng xác minh reCAPTCHA.'
            ])
            ->withInput();
    }

    // lấy ca khám
    $schedule = \App\Models\Schedule::where(
        'row_id',
        $request->schedule_id
    )->first();

    if (!$schedule) {

        return redirect()->back()
            ->with('error', 'Ca khám không tồn tại.')
            ->withInput();
    }

    // lấy thông tin ca làm
    $shift = \App\Models\TableShift::where(
        'shift_id',
        $schedule->shift_id
    )->first();

    if (!$shift) {

        return redirect()->back()
            ->with('error', 'Không tìm thấy ca làm.')
            ->withInput();
    }

    // tạo lịch khám
    $book = new Book();

    $book->book_id = $this->generateUserId();

    $book->name = $request->name;

    $book->phone = $request->phone;

    $book->email = $email;

    $book->symptoms = $request->symptoms;

    // dữ liệu lấy từ schedule
    $book->day = $schedule->day;

    $book->hour = $shift->start_time;

    $book->shift_id = $schedule->shift_id;

    $book->specialty_id = $schedule->specialty_id;

    $book->user_id = $schedule->user_id;

    // mặc định khám trực tiếp
    $book->role = 0;

    // kiểm tra chuyên khoa
    $specialty = Specialty::where(
        'specialty_id',
        $schedule->specialty_id
    )
    ->where('status', 1)
    ->first();

    if (!$specialty) {

        return redirect()->back()
            ->with('error', 'Chuyên khoa không tồn tại hoặc đã bị khóa.');
    }

    // STT khám
    $lastStt = Book::where('day', $schedule->day)
        ->where('shift_id', $schedule->shift_id)
        ->where('user_id', $schedule->user_id)
        ->max('stt');

    $newStt = $lastStt ? $lastStt + 1 : 1;

    $book->stt = $newStt;

    $book->save();

    // bác sĩ
    $doctor = User::where(
        'user_id',
        $schedule->user_id
    )->first();

    // gửi mail
    Mail::to($book->email)->send(
        new BookingConfirmation(
            $book,
            $specialty,
            $doctor
        )
    );
    

    return redirect()->back()
        ->with('success', 'Đặt lịch thành công');
}


    public function cancelBooking($book_id)
    {

        $book = Book::where('book_id', $book_id)->first();

        if (!$book) {
            return redirect()->back()->with('error', 'Lịch khám không tồn tại.');
        }

        if ($book->status == 4) {
            return redirect()->back()->with('error', 'Lịch khám đã bị hủy.');
        }

        $book->status = 4;
        $book->save();

        return redirect()->back()->with('success', 'Lịch khám đã được hủy.');
    }
    protected function generateUserId()
    {
        return strtoupper(Str::random(10));
    }
    public function getSchedulesByDoctor(Request $request)
{
    $doctorId = $request->doctor_id;
    $day = Carbon::parse($request->day)->format('Y-m-d');

    $now = Carbon::now();

    $isToday = Carbon::parse($day)->isSameDay($now);

    $schedules = \App\Models\Schedule::join(
            'table_shifts',
            'table_shifts.shift_id',
            '=',
            'schedules.shift_id'
        )
        ->where('schedules.user_id', $doctorId)
        ->whereDate('schedules.day', $day)
        ->where('schedules.status', 0)

        // ->when($isToday, function ($q) use ($now) {
        //     $q->where('table_shifts.end_time', '>', $now->format('H:i:s'));
        // })

        ->select(
            'schedules.row_id',
            'table_shifts.name as shift_name',
            'table_shifts.start_time',
            'table_shifts.end_time'
        )
        ->get();

    return response()->json($schedules);
}
}