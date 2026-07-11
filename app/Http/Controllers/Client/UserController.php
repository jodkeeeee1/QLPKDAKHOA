<?php

namespace App\Http\Controllers\Client;
use App\Models\Order;
use App\Models\OrderMedicine;
use App\Models\Patient;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\User\RegisterRequest;
use App\Http\Requests\Client\User\LoginRequest;
use App\Http\Requests\Client\User\UpdateProfileRequest;
use App\Http\Requests\Client\User\ChangePasswordRequest;
use App\Models\User;
use App\Models\Book;
use App\Models\Specialty;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Products\OrderProduct;
use App\Models\Products\Product;
use App\Models\Service;
use App\Models\TreatmentService;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    protected UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function register()
    {
        $showPopup = 'register';
        $doctor = User::join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
            ->where('role', 2)
            ->select('users.*', 'specialties.specialty_id', 'specialties.name as specialtyName')
            ->limit(6)
            ->get();
        return view('client.index', ['showPopup' => $showPopup, 'doctor' => $doctor]);
    }

    public function handleRegister(RegisterRequest $request)
    {
        // Validate reCAPTCHA

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $responseBody = $response->json();

        if (!$responseBody['success']) {
            return redirect()->route('client.register')
                ->withErrors(['g-recaptcha-response' => 'Vui lòng xác minh reCAPTCHA.'])
                ->withInput();
        }
        $validatedData = $request->validated();

        $users = $this->userRepository->create([
            'user_id' => $this->generateUserId(),
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'avatar' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png',
            'email_verified_at' => now(),
        ]);

        if ($users) {
            return redirect()->route('client.register')->with('success', 'Đăng ký thành công!');
        } else {
            return redirect()->route('client.register')->with('error', 'Đăng ký thất bại. Vui lòng thử lại.');
        }
    }
    protected function generateUserId()
    {
        return strtoupper(Str::random(10));
    }
    public function login()
    {

        $showPopup = 'login';
        $doctor = User::join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
            ->where('role', 2)
            ->select('users.*', 'specialties.specialty_id', 'specialties.name as specialtyName')
            ->limit(6)
            ->get();
        return view('client.index', ['showPopup' => $showPopup, 'doctor' => $doctor]);
    }

    public function authenticateLogin(LoginRequest $request)
{
    $credentials = [
        'phone' => $request->phone,
        'password' => $request->password,
    ];

    if (Auth::attempt($credentials, $request->rememberMe)) {

        $request->session()->regenerate();

       return redirect('/')
    ->with('success', 'Đăng nhập thành công');
    }

    return back()->with(
        'error',
        'Số điện thoại hoặc mật khẩu không chính xác'
    );
}

    public function logout(Request $request)
    {
        Auth::logout();
       return redirect('/')->with('success', 'Đăng xuất thành công');
    }
    public function index(Request $request)
    {

        $userId = Auth::user()->user_id;
        $userPhone = Auth::user()->phone;
$patientInfo = Patient::where(
    'phone',
    Auth::user()->phone
)->first();
      $userId = Auth::user()->user_id;

$medicalHistory = Book::leftJoin(
        'specialties',
        'specialties.specialty_id',
        '=',
        'books.specialty_id'
    )

    ->leftJoin(
        'schedules',
        'schedules.shift_id',
        '=',
        'books.shift_id'
    )

    ->leftJoin(
        'users',
        'users.user_id',
        '=',
        'books.user_id'
    )

    ->leftJoin(
        'table_shifts',
        'table_shifts.shift_id',
        '=',
        'books.shift_id'
    )

    ->select(
        'books.*',

        DB::raw('MAX(users.lastname) as lastname'),
        DB::raw('MAX(users.firstname) as firstname'),

        DB::raw('MAX(specialties.name) as specialtyName'),

        DB::raw('MAX(table_shifts.name) as shiftName'),

        DB::raw('MAX(schedules.note) as shiftNote'),

        DB::raw('MAX(table_shifts.start_time) as start_time'),

        DB::raw('MAX(table_shifts.end_time) as end_time')
    )

    ->where('books.email', Auth::user()->email)

    ->whereNull('books.deleted_at')

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

    ->orderByDesc('books.created_at')

    ->get();

        $medicalRecordHistory = MedicalRecord::join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
            ->select('medical_records.*', 'patients.first_name', 'patients.last_name', 'patients.gender')
            ->where('patients.phone', $userPhone)
            ->orderBy('medical_records.created_at', 'desc')
            ->paginate(5);


        foreach ($medicalRecordHistory as $record) {
 $record->treatment_details = DB::table('treatment_details')
        ->where('medical_id', $record->medical_id)
        ->get();

    $treatmentId =
        $record->treatment_details[0]->treatment_id ?? null;

    $record->order = DB::table('orders')
        ->where('treatment_id', $treatmentId)
        ->first();

    $record->orderMedicine = DB::table('order_medicines')
        ->where('treatment_id', $treatmentId)
        ->first();


            $record->services = Service::join('treatment_services', 'treatment_services.service_id', '=', 'services.service_id')
                ->where('treatment_services.treatment_id', $record->treatment_details[0]->treatment_id ?? null)
                ->get();


            $record->total_price = TreatmentService::where('treatment_id', $record->treatment_details[0]->treatment_id ?? null)
                ->join('services', 'treatment_services.service_id', '=', 'services.service_id')
                ->sum('services.price');


            $record->medicines = Medicine::join('treatment_medications', 'treatment_medications.medicine_id', '=', 'medicines.medicine_id')
                ->where('treatment_medications.treatment_id', $record->treatment_details[0]->treatment_id ?? null)
                ->get();
        }

        // Lấy tất cả các đơn hàng của người dùng
        $order = OrderProduct::join('payment_products', 'payment_products.order_id', '=', 'order_products.order_id')
            ->join('users', 'users.user_id', '=', 'order_products.user_id')
            ->where('users.user_id', $userId)
            ->whereNull('order_products.deleted_at')
            ->orderBy('order_products.created_at', 'desc')
            ->get(); // Sử dụng get() để lấy tất cả các đơn hàng

        // Kiểm tra nếu có đơn hàng
        if ($order->isNotEmpty()) {
            // Lấy cart_id của đơn hàng đầu tiên (hoặc chọn cách xử lý khác nếu cần)
            $cart_id = $order->first()->cart_id;

            // Truy vấn các sản phẩm trong giỏ hàng
            $product = Product::join('cart_details', 'cart_details.product_id', '=', 'products.product_id')
                ->leftJoin('product_sale', 'product_sale.product_id', '=', 'products.product_id')
                ->leftJoin('coupons', 'coupons.coupon_id', '=', 'product_sale.coupon_id')
                ->join('cart_products', 'cart_products.cart_id', '=', 'cart_details.cart_id')
                ->join('img_products', 'img_products.product_id', '=', 'products.product_id')
                ->where('cart_products.cart_id', $cart_id)
                ->select(
                    'cart_products.*',
                    'cart_details.*',
                    'products.*',
                    'coupons.discount_code',
                    'coupons.percent',
                    'coupons.time_start as dateStartSale',
                    'coupons.time_end as dateEndSale',
                    DB::raw('SUBSTRING_INDEX(GROUP_CONCAT(img_products.img ORDER BY img_products.img SEPARATOR ","), ",", 1) as img_first')
                )
                ->groupBy(
                    'cart_products.cart_id',
                    'cart_products.user_id',
                    'cart_products.deleted_at',
                    'cart_products.updated_at',
                    'cart_products.created_at',
                    'products.product_id',
                    'products.name',
                    'products.code_product',
                    'products.unit_of_measurement',
                    'products.active_ingredient',
                    'products.used',
                    'products.description',
                    'products.price',
                    'products.brand',
                    'products.category_id',
                    'products.manufacture',
                    'products.quantity',
                    'products.registration_number',
                    'products.status',
                    'products.deleted_at',
                    'products.updated_at',
                    'products.created_at',
                    'cart_details.cart_detail_id',
                    'cart_details.product_id',
                    'cart_details.quantity',
                    'cart_details.cart_id',
                    'cart_details.deleted_at',
                    'cart_details.updated_at',
                    'cart_details.created_at',
                    'coupons.discount_code',
                    'coupons.percent',
                    'coupons.time_start',
                    'coupons.time_end'
                )
                ->get(); // Sử dụng get() để lấy tất cả sản phẩm trong giỏ hàng

            // Truy vấn thông tin về đơn hàng người dùng
    $order_user = OrderProduct::join(
        'payment_products',
        'payment_products.order_id',
        '=',
        'order_products.order_id'
    )
    ->leftJoin('cart_details', 'cart_details.cart_id', '=', 'order_products.cart_id')
    ->leftJoin('products', 'products.product_id', '=', 'cart_details.product_id')
    ->where('order_products.user_id', $userId)
    ->whereNull('order_products.deleted_at')
    ->select(
        'order_products.order_id',
        'order_products.order_phone',
        'order_products.order_username',
        'order_products.order_address',
        'order_products.created_at',
        'order_products.order_status',

        DB::raw("
            GROUP_CONCAT(
                CONCAT(products.name, ' x', cart_details.quantity)
                SEPARATOR ', '
            ) as product_list
        "),

        DB::raw('SUM(cart_details.quantity) as total_quantity'),

        // ✅ LẤY THẲNG TỪ DB
        'order_products.price_sale as total_price',

        'payment_products.payment_method'
    )
    ->groupBy(
        'order_products.order_id',
        'order_products.order_phone',
        'order_products.order_username',
        'order_products.order_address',
        'order_products.created_at',
        'order_products.order_status',
        'order_products.price_sale',
        'payment_products.payment_method'
    )
    ->orderByDesc('order_products.created_at')
    ->paginate(5);

        } else {
            // Nếu không có đơn hàng
            $product = [];
            $order_user = [];
        }
$medicineInvoices = DB::table('order_medicines')
    ->join('medical_records', 'medical_records.medical_id', '=', 'order_medicines.treatment_id')
    ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
    ->where('patients.phone', $userPhone)
    ->select(
        'order_medicines.*',
        'medical_records.medical_id',
        'patients.first_name',
        'patients.last_name'
    )
    ->orderByDesc('order_medicines.created_at')
    ->get();
    $serviceInvoices = DB::table('orders')
    ->join('medical_records', 'medical_records.medical_id', '=', 'orders.treatment_id')
    ->join('patients', 'patients.patient_id', '=', 'medical_records.patient_id')
    ->where('patients.phone', $userPhone)
    ->select(
        'orders.*',
        'medical_records.medical_id',
        'patients.first_name',
        'patients.last_name'
    )
    ->orderByDesc('orders.created_at')
    ->get();

        // dd($order_user);
      return view('client.profile', [
    'medicalHistory' => $medicalHistory,
    'medicalRecordHistory' => $medicalRecordHistory,
    'order_user' => $order_user,
    'patientInfo' => $patientInfo,
    'serviceInvoices' => $serviceInvoices,
    'medicineInvoices' => $medicineInvoices,

]);

    }
    public function updateProfile(UpdateProfileRequest $request)
    {
       
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('system.auth.login')->with('error', 'Bạn cần phải đăng nhập để cập nhật hồ sơ.');
        }

        $oldPhone = $user->phone;
$avatarName = $user->avatar;

if ($request->hasFile('avatar')) {

    // Xóa ảnh cũ nếu có
    if (
        $user->avatar &&
        !filter_var($user->avatar, FILTER_VALIDATE_URL)
    ) {
        Storage::disk('public')->delete(
            'uploads/avatars/' . $user->avatar
        );
    }

    $avatarName = time() . '.' .
        $request->file('avatar')->getClientOriginalExtension();

    $request->file('avatar')->storeAs(
        'uploads/avatars',
        $avatarName,
        'public'
    );
}

        $specialty_id = $request->input('specialty_id');


        $updatedUser = $user->update([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'birthday' => $request->input('birthday'),
            'specialty_id' => $specialty_id,
            'avatar' => $avatarName,
        ]);


        if (!$updatedUser) {
            return redirect()->back()->withErrors(['update' => 'Không thể cập nhật thông tin.']);
        }


        if ($oldPhone !== $request->input('phone')) {
            $patient = $user->patient;
            if ($patient) {
                $patient->update(['phone' => $request->input('phone')]);
            }
        }

        return redirect()->route('client.profile.index')->with('success', 'Cập nhật thông tin thành công');
    }
 public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('client.login')->with('error', 'Bạn cần phải đăng nhập để cập nhật hồ sơ.');
        }


        if ($request->hasFile('avatar')) {
            $request->validate(['avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048']);

            // Xóa avatar cũ nếu tồn tại
            if ($user->avatar) {
                Storage::disk('public')->delete('uploads/avatars/' . $user->avatar);
            }

            // Lưu avatar mới vào thư mục 'uploads/avatars'
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('uploads/avatars', $avatarName, 'public');

            // Gán tên file avatar mới vào user
            $user->avatar = $avatarName;

            // Cập nhật avatar trong cơ sở dữ liệu
            $user->save();
        }

        return redirect()->route('client.profile.index')->with('success', 'Cập nhật ảnh đại diện thành công!');
    }


    public function changePassword(ChangePasswordRequest $request)
    {

        $user = Auth::user();


        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }


        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Mật khẩu mới không được giống với mật khẩu cũ.']);
        }


        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('change_password_success', 'Thay đổi mật khẩu thành công')->with('activeTab', 'change_password');
    }
    public function forgotPassword()
    {
        $doctor = User::join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
            ->where('role', 2)
            ->select('users.*', 'specialties.specialty_id', 'specialties.name as specialtyName')
            ->limit(6)
            ->get();
        $showPopup = 'forgot-password';
        return view('client.index', ['showPopup' => $showPopup, 'doctor' => $doctor]);
    }
    /**
     * Gửi email khôi phục mật khẩu với token ngẫu nhiên.
     */

    public function sendResetPasswordEmail(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'required' => 'Trường email là bắt buộc.',
            'email' => 'Trường email phải là một địa chỉ email hợp lệ.',
            'exists' => 'Địa chỉ email không tồn tại trong hệ thống.',
        ]);
        // Validate reCAPTCHA

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $responseBody = $response->json();

        if (!$responseBody['success']) {
            return redirect()->route('client.forgot-password')
                ->withErrors(['g-recaptcha-response' => 'Vui lòng xác minh reCAPTCHA.'])
                ->withInput();
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );


        $resetLink = url("/doi-mat-khau?token={$token}&email={$request->email}");


        Mail::send('emails.password-reset', ['resetLink' => $resetLink], function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Khôi phục mật khẩu');
        });


        return back()->with('success', 'Gửi link khôi phục mật khẩu thành công! Vui lòng kiểm tra email của bạn.');
    }
    public function showResetForm(Request $request)
    {

        $email = $request->query('email');


        $resetRecord = DB::table('password_reset_tokens')

            ->where('email', $email)
            ->first();

        if (!$resetRecord) {
            return redirect()->route('client.login')->with('error', 'Yêu cầu không hợp lệ.');
        }

        $doctor = User::join('specialties', 'specialties.specialty_id', '=', 'users.specialty_id')
            ->where('role', 2)
            ->select('users.*', 'specialties.specialty_id', 'specialties.name as specialtyName')
            ->limit(6)
            ->get();
        // Tiếp tục xử lý nếu token và email hợp lệ
        return view('client.index', [

            'email' => $email,
            'showPopup' => 'reset-password',
            'doctor' => $doctor,
        ]);
    }
    public function resetPassword(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'new_password' => ['required', 'confirmed', 'min:3'],
        ], [
            'email.required' => 'Trường email là bắt buộc.',
            'email.email' => 'Trường email phải là một địa chỉ email hợp lệ.',
            'email.exists' => 'Địa chỉ email không đúng.',
            'token.required' => 'Trường token là bắt buộc.',
            'new_password.required' => 'Trường mật khẩu mới là bắt buộc.',
            'new_password.confirmed' => 'Mật khẩu mới không khớp.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 3 ký tự.',
        ]);

        // Kiểm tra nếu có lỗi
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return back()->with(['error' => 'Yêu cầu không hợp lệ hoặc đã hết hạn.']);
        }

        //token có hiệu lực trong vòng 10 phút
        if (Carbon::parse($passwordReset->created_at)->addMinutes(10)->isPast()) {
            return back()->with(['error' => 'Yêu cầu đã hết hạn.']);
        }


        $updated = User::resetUserPassword($request->email, $request->new_password);
        if ($updated) {

            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            // Thông báo thành công
            return redirect()->route('client.login')->with('success', 'Đổi mật khẩu thành công. Vui lòng đăng nhập.');
        } else {
            return back()->with(['error' => 'Có lỗi xảy ra trong quá trình đặt lại mật khẩu.']);
        }
    }
    public function getSchedulesByDoctor($id)
{
    $schedules = \App\Models\Schedule::join(
            'table_shifts',
            'table_shifts.shift_id',
            '=',
            'schedules.shift_id'
        )

        ->where('schedules.user_id', $id)

        ->select(
            'schedules.row_id',
            'schedules.day',
            'schedules.note',

            'table_shifts.name as shift_name',
            'table_shifts.start_time',
            'table_shifts.end_time'
        )

        ->orderBy('schedules.day')

        ->get();

    return response()->json($schedules);
}
public function updateMedicalInfo(Request $request)
{
    $user = auth()->user();

    $patient = Patient::where(
        'phone',
        $user->phone
    )->first();

    if (!$patient) {

        // Chưa có hồ sơ → tạo mới
        $patient = new Patient();

        $patient->patient_id =
            strtoupper(Str::random(10));

        $patient->phone = $user->phone;
    }

    $patient->first_name = $request->firstname;
    $patient->last_name = $request->lastname;
    $patient->gender = $request->gender;
    $patient->birthday = $request->birthday;

    $patient->cccd = $request->cccd;
    $patient->address = $request->address;

    $patient->occupation =
        $request->occupation;

    $patient->national =
        $request->national;

    $patient->emergency_contact =
        $request->emergency_contact;

    $patient->save();

    return back()->with(
        'success',
        'Cập nhật thông tin khám bệnh thành công'
    );
}
public function payment(Request $request)
{
    $orderId = $request->order_id;
    $type = $request->type;

    $order = null;

    // Hóa đơn dịch vụ
    if($type == 'service'){

        $order = Order::where(
            'order_id',
            $orderId
        )->first();

    }
    // Hóa đơn thuốc
    else{

        $order = OrderMedicine::where(
            'order_medicine_id',
            $orderId
        )->first();

    }

    if(!$order){
        return back()->with(
            'error',
            'Không tìm thấy hóa đơn'
        );
    }

    // ===== TIỀN MẶT =====
if($request->payment_method == 'cash'){

    if($type == 'service'){

        $order->status = 3;

        $order->cash_received = $order->total_price;
        $order->total_amount = $order->total_price;
        $order->change_amount = 0;
         $order->payment = 0; 
    }else{

        $order->status = 1;

        $order->cash_received = $order->total_price;
        $order->change = 0;
    }

    $order->save();

    return redirect('/ho-so')
        ->with(
            'success',
            'Thanh toán thành công'
        );
}

    // ===== MOMO =====
   if($request->payment_method == 'momo'){

    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

    $partnerCode='MOMOBKUN20180529';
    $accessKey='klm05TvNBzhg7h7j';
    $secretKey='at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

    $amount = $order->total_price;

if(!$amount || $amount <= 0){
    return back()->with(
        'error',
        'Hóa đơn chưa có tổng tiền hợp lệ'
    );
}

    // Mã giao dịch MOMO
    $orderId = time().rand(1000,9999);
    $requestId = $orderId;

    $orderInfo = "Thanh toán hóa đơn";

   $redirectUrl = env('APP_URL')."/ho-so/payment/momo/return";
$ipnUrl = env('APP_URL')."/ho-so/payment/momo/return";

    // Gửi thông tin hóa đơn qua callback
   $realOrderId = $type == 'service'
    ? $order->order_id
    : $order->order_medicine_id;

$extraData = base64_encode(json_encode([
    'order_id' => $realOrderId,
    'type' => $type
]));
    $rawHash =
        "accessKey=".$accessKey.
        "&amount=".$amount.
        "&extraData=".$extraData.
        "&ipnUrl=".$ipnUrl.
        "&orderId=".$orderId.
        "&orderInfo=".$orderInfo.
        "&partnerCode=".$partnerCode.
        "&redirectUrl=".$redirectUrl.
        "&requestId=".$requestId.
        "&requestType=payWithATM";

    $signature = hash_hmac(
        "sha256",
        $rawHash,
        $secretKey
    );

    $data = [
        'partnerCode'=>$partnerCode,
        'requestId'=>$requestId,
        'amount'=>$amount,
        'orderId'=>$orderId,
        'orderInfo'=>$orderInfo,
        'redirectUrl'=>$redirectUrl,
        'ipnUrl'=>$ipnUrl,
        'requestType'=>'payWithATM',
        'extraData'=>$extraData,
        'lang'=>'vi',
        'signature'=>$signature
    ];

    $result = $this->execPostRequest(
    $endpoint,
    json_encode($data)
);

$jsonResult = json_decode($result, true);

if (!isset($jsonResult['payUrl'])) {

    return back()->with(
        'error',
        $jsonResult['message'] ?? 'Lỗi tạo thanh toán MOMO'
    );
}

return redirect()->to(
    $jsonResult['payUrl']
);
}
}
public function momoReturn(Request $request)
{
    if($request->resultCode == 0){

        $data = json_decode(
            base64_decode($request->extraData),
            true
        );

        $orderId = $data['order_id'];
        $type = $data['type'];

        if($type=='service'){
            $order = Order::where(
                'order_id',
                $orderId
            )->first();
        }else{
            $order = OrderMedicine::where(
                'order_medicine_id',
                $orderId
            )->first();
        }

   if($order){

    // status giữ nguyên
    if($type == 'service'){
        $order->status = 3;

        // bảng orders
        $order->cash_received = $order->total_price;
        $order->total_amount = $order->total_price;
        $order->change_amount = 0;
         $order->payment = 1; 
    }
    else{
        $order->status = 1;

        // bảng order_medicines
        $order->cash_received = $order->total_price;
        $order->change = 0;
    }

    $order->save();
}

        return redirect('/ho-so')
    ->with(
        'success',
        'Thanh toán MOMO thành công'
    );
    }

    return redirect()
        ->route('profile.index')
        ->with(
            'error',
            'Thanh toán thất bại'
        );
}
public function execPostRequest(
    $url,
    $data
)
{
    $ch = curl_init($url);

    curl_setopt(
        $ch,
        CURLOPT_CUSTOMREQUEST,
        "POST"
    );

    curl_setopt(
        $ch,
        CURLOPT_POSTFIELDS,
        $data
    );

    curl_setopt(
        $ch,
        CURLOPT_RETURNTRANSFER,
        true
    );

    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        [
            'Content-Type: application/json',
            'Content-Length: '.strlen($data)
        ]
    );

    curl_setopt(
        $ch,
        CURLOPT_TIMEOUT,
        5
    );

    curl_setopt(
        $ch,
        CURLOPT_CONNECTTIMEOUT,
        5
    );

    $result = curl_exec($ch);

    curl_close($ch);

    return $result;
}
}
