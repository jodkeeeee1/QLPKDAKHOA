@extends('layouts.client.app')

@section('meta_title', 'Trang hồ sơ')

@section('content')
<style>
    #order .medical-history__table {
        width: 100%;
        table-layout: fixed;
    }

    #order .medical-history__table th,
    #order .medical-history__table td {
        vertical-align: top;
        padding: 10px;
        word-wrap: break-word;
        white-space: normal;
    }

    /* STT */
    #order .medical-history__table th:nth-child(1),
    #order .medical-history__table td:nth-child(1) {
        width: 7%;
    }

    /* Mã đơn */
    #order .medical-history__table th:nth-child(2),
    #order .medical-history__table td:nth-child(2) {
        width: 10%;
    }

    /* Sản phẩm */
    #order .medical-history__table th:nth-child(3),
    #order .medical-history__table td:nth-child(3) {
        width: 28%;
    }

    /* Ngày đặt */
    #order .medical-history__table th:nth-child(4),
    #order .medical-history__table td:nth-child(4) {
        width: 14%;
    }

    /* Giá trị */
    #order .medical-history__table th:nth-child(5),
    #order .medical-history__table td:nth-child(5) {
        width: 14%;
    }

    /* Thanh toán */
    #order .medical-history__table th:nth-child(6),
    #order .medical-history__table td:nth-child(6) {
        width: 12%;
    }

    /* Địa chỉ */
    #order .medical-history__table th:nth-child(7),
    #order .medical-history__table td:nth-child(7) {
        width: 17%;
    }

    /* Trạng thái (cột cuối) */
    #order .medical-history__table th:nth-child(8),
    #order .medical-history__table td:nth-child(8) {
        width: 10%;
        text-align: center;
    }
</style>
<style>
.payment-method-group{
    margin-top:15px;
}

.payment-method-group label{
    display:block;
    font-weight:600;
    margin-bottom:8px;
    color:#444;
}

.select-wrapper{
    position:relative;
}

.select-wrapper select{
    width:100%;
    padding:12px 15px;
    border:2px solid #e5e7eb;
    border-radius:12px;
    font-size:15px;
    background:#fff;
    outline:none;
    cursor:pointer;
    transition:0.3s;
    appearance:none;
}

.select-wrapper select:hover{
    border-color:#4CAF50;
}

.select-wrapper select:focus{
    border-color:#4CAF50;
    box-shadow:0 0 10px rgba(76,175,80,0.2);
}

.select-wrapper::after{
    content:"⌄";
    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    pointer-events:none;
    font-size:18px;
    color:#666;
}
</style>
<style>
    
#order .medical-history__table {
    width: 100%;
    table-layout: fixed; /* chia cột gọn lại */
}
.gender-select{
    width: 50%;
    height: 30px;
    font-size: 16px;
    padding: 0 6px;
}
#order .medical-history__table th,
#order .medical-history__table td {
    white-space: normal;      /* cho xuống dòng */
    word-break: break-word;   /* bẻ chữ dài */
    font-size: 14px;          /* nhỏ lại */
    padding: 6px 8px;         /* gọn hơn */
}
    .status-cancel-action {
        font-weight: 700;
        font-size: 16px;
        color: #e74c3c;
    }
       .status-confirm-action {
    font-weight: 700;
    font-size: 16px;
    color: #28a745;
}
    .medical-history__table {
        width: 100%;
        border-collapse: collapse;
    }

    .medical-history__table th,
    .medical-history__table td {
        white-space: nowrap;
    }
     .btn-secondary {
        background: #ccc;
        color: #666;
        cursor: not-allowed;
        border: none;
    }

    .btn-secondary:disabled {
        opacity: 0.7;
    }
</style>
    <div class="main-body">
        <div class="breadcrumbs">
            <div class="container">
                <div class="breadcrumbs-nav">
                    <div class="item"><a href="" title="Trang chủ">Trang chủ</a>
                    </div>
                    <div class="item sep">/</div>
                    <div class="item">Thông tin cá nhân</div>
                </div>
            </div>
        </div>
        <div class="profile__page">
            <div class="container">
                <div class="profile__page--frame">
                    <div class="row gap-y-40">

                        <div class="col l-4 mc-12 c-12">
                            <div class="profile__info">
                       <div class="profile__avatar">

    @php
        $avatar = auth()->user()->avatar;
    @endphp

    @if(empty($avatar))
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
             alt="Avatar">
    @elseif(filter_var($avatar, FILTER_VALIDATE_URL))
        <img src="{{ $avatar }}" alt="Avatar">
    @else
        <img src="{{ asset('storage/uploads/avatars/' . $avatar) }}"
             alt="Avatar">
    @endif

</div>
                                <script>
                                    function openPopup() {
                                        document.getElementById("uploadPopup").style.display = "flex"; // Hiển thị popup
                                    }

                                    function closePopup() {
                                        document.getElementById("uploadPopup").style.display = "none"; // Ẩn popup
                                        // Xóa preview khi đóng popup
                                        document.getElementById("previewImg").src = "";
                                        document.getElementById("previewImg").style.display = "none";
                                    }


                                    function previewImage(event) {
                                        const input = event.target;
                                        const previewImg = document.getElementById("previewImg");

                                        if (input.files && input.files[0]) {
                                            const reader = new FileReader();

                                            reader.onload = function(e) {
                                                previewImg.src = e.target.result; // Gán đường dẫn cho ảnh preview
                                                previewImg.style.display = "block"; // Hiển thị ảnh
                                            }

                                            reader.readAsDataURL(input.files[0]); // Đọc file hình ảnh
                                        }
                                    }
                                </script>
                                <!-- Popup form upload ảnh -->



                                <h1 class="text-center">Thông tin cá nhân</h1>
                                <div class="profile__details">
                                    <p><strong>Họ tên:</strong> {{ auth()->user()->firstname }}
                                        {{ auth()->user()->lastname }}</p>
                                    <p><strong>Số điện thoại:</strong>
                                        @if (empty(auth()->user()->phone))
                                            Chưa cập nhật
                                        @else
                                            {{ auth()->user()->phone }}
                                        @endif
                                    </p>
                                    <p><strong>Email:</strong>{{ auth()->user()->email }}</p>
                                    <p><strong>Ngày sinh:</strong>
                                        @if (empty(auth()->user()->birthday))
                                            Chưa cập nhật
                                        @else
                                            {{ \Carbon\Carbon::parse(auth()->user()->birthday)->format('d/m/Y') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="button-container">
                                    <a href="{{ route('client.logout') }}" class="button btn-small btn-cta">Đăng xuất</a>
                                    <button class="button btn-small btn-cta" onclick="openTab(event, 'update_info')">Cập
                                        nhật thông tin</button>
                                    <button class="button btn-small btn-cta" onclick="openTab(event, 'change_password')">Đổi
                                        mật khẩu</button>
                                    <a href="{{ route('shop.cart') }}" class="button btn-small btn-cta">Đơn hàng</a>
                                </div>
                            </div>

                        </div>
                        <div class="col l-8 mc-12 c-12">
                            <div class="tabs">
                                 <button class="tab-btn"
        onclick="openTab(event, 'medical_info')">
        Thông tin khám bệnh
    </button>
                                <button
                                    class="tab-btn {{ session('active_tab') === null || session('active_tab') === 'history' ? 'active' : '' }}"
                                    onclick="openTab(event, 'history')">Lịch sử đặt lịch</button>
                                <button class="tab-btn" onclick="openTab(event, 'medical_record')">Lịch sử bệnh
                                    án</button>
                                <button class="tab-btn {{ session('active_tab') === 'order' ? 'active' : '' }}"
                                    onclick="openTab(event, 'order')">Đơn hàng</button>
                            <button class="tab-btn"
onclick="openTab(event, 'invoice')">
    Hóa đơn
</button>

                            </div>
                            
                            <div class="tab-content">
                    <!-- Tab Thông tin khám bệnh -->
<div id="medical_info" class="tab">

    <div class="profile__medical-history">

        <h1 class="text-center">
            Thông tin khám bệnh
        </h1>

        <form action="{{ route('client.profile.updateMedicalInfo') }}"
      method="POST">

    @csrf
    @method('PATCH')

            <div class="form-group">
                <label>Mã bệnh nhân</label>

           <input type="text"
    name="patient_id"
    value="{{ $patientInfo->patient_id ?? strtoupper(Str::random(10)) }}"
    readonly>
            </div>

            <div class="form-group row">

                <div class="col">
                    <label>Họ</label>

                    <input type="text"
                        name="lastname" oninput="checkForm()"
                        value="{{ $patientInfo->lastname ?? auth()->user()->lastname }}">
                </div>

                <div class="col">
                    <label>Tên</label>

                    <input type="text"
                        name="firstname" oninput="checkForm()"
                        value="{{ $patientInfo->firstname ?? auth()->user()->firstname }}">
                </div>

            </div>

            <div class="form-group row">
<div class="col">
    <label>Giới tính</label>

    <select name="gender" class="gender-select" oninput="checkForm()">

        <option value="1"
            {{ ($patientInfo->gender ?? auth()->user()->gender)==1 ? 'selected':'' }}>
            Nam
        </option>

        <option value="0"
            {{ ($patientInfo->gender ?? auth()->user()->gender)==0 ? 'selected':'' }}>
            Nữ
        </option>

    </select>
</div>

                <div class="col">
                    <label>Ngày sinh</label>

                    <input type="date"
                        name="birthday"
                        oninput="checkForm()"
                        value="{{ $patientInfo->birthday ?? auth()->user()->birthday }}">
                </div>

            </div>

            <div class="form-group">

                <label>CCCD/CMND</label>

                <input type="text"
                    name="cccd"
                    oninput="checkForm()"
                    value="{{ $patientInfo->cccd ?? auth()->user()->cccd }}">
            </div>

            <div class="form-group">

                <label>Địa chỉ</label>

                <input type="text"
                    name="address"
                    oninput="checkForm()"
                    value="{{ $patientInfo->address ?? auth()->user()->address }}">
            </div>

            <div class="form-group">

                <label>Số điện thoại</label>

                <input type="text"
                    name="phone"
                    oninput="checkForm()"
                    value="{{ $patientInfo->phone ?? auth()->user()->phone }}">
            </div>

            <div class="form-group">

                <label>Nghề nghiệp</label>

                <input type="text"
                    name="occupation"
                    oninput="checkForm()"
                    value="{{ $patientInfo->occupation ?? auth()->user()->occupation }}">
            </div>

            <div class="form-group">

                <label>Liên hệ khẩn cấp</label>

                <input type="text"
                    name="emergency_contact"
                    oninput="checkForm()"
                    value="{{ $patientInfo->emergency_contact ?? auth()->user()->emergency_contact }}">
            </div>

            <div class="form-group">

                <label>Quốc tịch</label>

                <input type="text"
                    name="national"
                    oninput="checkForm()"
                    value="{{ $patientInfo->national ?? auth()->user()->national }}">
            </div>

          <button type="submit" class="button btn-cta" id="submitBtn" disabled>
    Lưu thông tin khám bệnh
</button>

        </form>

    </div>

</div>
                                <!-- Tab bệnh án -->
                                <div id="medical_record" class="tab">
                                    <div class="profile__medical-history" style="overflow-x: auto;">
                                        <h1 class="text-center">Bệnh án</h1>
                                        <table class="medical-history__table">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Mã bệnh án</th>
                                                    <th>Chẩn đoán</th>
                                                    <th>Ngày tái khám</th>
                                                    <th>Lời khuyên</th>

                                                    <th>Bệnh nhân</th>
                                                    <th>Chi tiết</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($medicalRecordHistory->isEmpty())
                                                    <tr>
                                                        <td colspan="7" class="text-center">Chưa có bệnh án nào</td>
                                                    </tr>
                                                @else
                                                    @foreach ($medicalRecordHistory as $key => $history)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $history->medical_id }}</td>
                                                            <td>{{ $history->diaginsis }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($history->re_examination_date)->format('d/m/Y') }}
                                                            </td>
                                                            <td>{{ $history->advice ?? 'Không có lời khuyên' }}</td>

                                                            <td>{{ $history->first_name }} {{ $history->last_name }}</td>
                                                            <td>
                                                                <button style="border:none" class="button btn-small btn-cta"
                                                                    onclick="openDetailsMediaRecordModal({{ json_encode($history) }})">Chi
                                                                    tiết</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <script>
                                    function openDetailsMediaRecordModal(history) {
                                        document.getElementById("modal-medical-id").textContent = history.medical_id;
                                        document.getElementById("modal-diagnosis").textContent = history.diaginsis;
                                        if (history.re_examination_date) {
                                            const date = new Date(history.re_examination_date);
                                            const day = String(date.getDate()).padStart(2, '0'); // Đảm bảo có 2 chữ số
                                            const month = String(date.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
                                            const year = date.getFullYear();

                                            // Định dạng theo d-m-Y
                                            document.getElementById("modal-re-exam-date").textContent = `${day}/${month}/${year}`;
                                        } else {
                                            document.getElementById("modal-re-exam-date").textContent = 'Không có thông tin';
                                        }
                                        document.getElementById("modal-advice").textContent = history.advice || 'Không có lời khuyên';
                                        document.getElementById("modal-blood-pressure").textContent = history.blood_pressure;
                                        document.getElementById("modal-respiratory-rate").textContent = history.respiratory_rate;
                                        document.getElementById("modal-weight").textContent = history.weight;
                                        document.getElementById("modal-height").textContent = history.height;
                                        document.getElementById("modal-patient-name").textContent = `${history.first_name} ${history.last_name}`;



                                        // Tạo bảng cho danh sách dịch vụ
                                        let servicesList = document.getElementById("modal-services");
                                        servicesList.innerHTML = ""; // Xóa nội dung cũ

                                        let servicesTable = document.createElement("table");
                                        servicesTable.classList.add("table", "table-bordered");

                                        // Tạo tiêu đề cho bảng dịch vụ
                                        let servicesThead = document.createElement("thead");
                                        let servicesHeaderRow = document.createElement("tr");

                                        let servicesHeaders = ["Tên dịch vụ", "Giá"];
                                        servicesHeaders.forEach(headerText => {
                                            let th = document.createElement("th");
                                            th.textContent = headerText;
                                            servicesHeaderRow.appendChild(th);
                                        });
                                        servicesThead.appendChild(servicesHeaderRow);
                                        servicesTable.appendChild(servicesThead);

                                        // Tạo phần thân cho bảng dịch vụ
                                        let servicesTbody = document.createElement("tbody");

                                        history.services.forEach(service => {

    let row = document.createElement("tr");

    // format giá tiền
    let price = parseInt(service.price || 0);

    let serviceData = [
        service.name,
        price.toLocaleString('vi-VN') + ' VNĐ'
    ];

    serviceData.forEach(data => {

        let td = document.createElement("td");
        td.textContent = data;
        row.appendChild(td);

    });

    servicesTbody.appendChild(row);

});

servicesTable.appendChild(servicesTbody);
servicesList.appendChild(servicesTable);


// Format tổng tiền
let totalPrice = parseInt(history.total_price || 0);

document.getElementById(
    "modal-total-price"
).textContent =
    totalPrice.toLocaleString('vi-VN')
    + ' VNĐ';

                                        let medicinesList = document.getElementById("modal-medicines");
                                        medicinesList.innerHTML = ""; // Xóa nội dung cũ

                                        // Tạo tiêu đề cho bảng thuốc
                                        let table = document.createElement("table");
                                        table.classList.add("table", "table-bordered");
                                        let thead = document.createElement("thead");
                                        let headerRow = document.createElement("tr");

                                        let headers = ["Tên thuốc", "Liều dùng", "Số lượng", "Cách dùng", "Lúc uống"];
                                        headers.forEach(headerText => {
                                            let th = document.createElement("th");
                                            th.textContent = headerText;
                                            headerRow.appendChild(th);
                                        });
                                        thead.appendChild(headerRow);
                                        table.appendChild(thead);

                                        // Tạo phần thân cho bảng thuốc
                                        let tbody = document.createElement("tbody");

                                        history.medicines.forEach(medicine => {
                                            let row = document.createElement("tr");

                                            let medicineData = [
                                                medicine.name,
                                                medicine.dosage,
                                                medicine.quantity,
                                                medicine.usage,
                                                medicine.note
                                            ];

                                            medicineData.forEach(data => {
                                                let td = document.createElement("td");
                                                td.textContent = data;
                                                row.appendChild(td);
                                            });

                                            tbody.appendChild(row);
                                        });

                                        table.appendChild(tbody);
                                        medicinesList.appendChild(table);

                                        document.getElementById("detailsMediaRecordModal").style.display = "block";
                                    }
                                </script>



                                <!-- Tab Đơn thuốc -->
                                <div id="order" class="tab">
                                    <div class="profile__medical-history">
                                        <h1 class="text-center">Đơn hàng</h1>
                                        <table class="medical-history__table">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Mã đơn hàng</th>
                                                    <th>Sản phẩm</th>
                                                   
                                                    <th>Ngày đặt hàng</th>
                                                    <th>Giá trị đơn hàng</th>
                                                    <th>Phương thức thanh toán</th>
                                                    <th>Địa chỉ giao hàng</th>
                                                    <th>Trạng thái đơn hàng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $index = 1; @endphp
                                                @foreach ($order_user as $item)
                                                    @php
                                                        // Xác định phương thức thanh toán
                                                        $methodText = match ($item->payment_method) {
                                                            0 => 'Thanh toán khi nhận hàng',
                                                            1 => 'Thanh toán bằng VNPAY',
                                                            2 => 'Thanh toán bằng MOMO',
                                                            default => 'Thanh toán bằng ZaloPay',
                                                        };

                                                     if($item->order_status == 0){
                                                        $orderStatus = 'Đang chờ xử lý';
                                                     }elseif($item->order_status == 1){
                                                        $orderStatus = 'Đang giao';
                                                     }elseif($item->order_status == 2){
                                                        $orderStatus = 'Đã giao';
                                                     }else{
                                                        $orderStatus = 'Đã xác nhận';
                                                     }
                                                         
                                                        

                                                        // Xác định giá trị đơn hàng
                                                        $orderValue =
                                                            number_format($item->total_price) . 'đ';
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $index++ }}</td>
                                                        <td>{{ $item->order_id }}</td>
                                                        <td>{{ $item->product_list }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('H:i d/m/Y') }}</td>
                                                        <td>{{ $orderValue }}</td>
                                                        <td>{{ $methodText }}</td>
                                                        <td>{{ $item->order_address }}</td>
                                                        <td>{{ $orderStatus }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="pagination">
                                            @if (is_object($order_user) && method_exists($order_user, 'count') && $order_user->count() > 0)
                                                {{ $order_user->links() }}
                                            @else
                                                <p>Không có đơn hàng nào.</p>
                                            @endif
                                        </div>
                                    </div>


                                </div>
                              <div id="invoice" class="tab">

    <div class="profile__medical-history">

        <h1 class="text-center">
            Hóa đơn dịch vụ & thuốc
        </h1>

        {{-- ================== HÓA ĐƠN DỊCH VỤ ================== --}}
        <h3 style="margin-top:20px;">Hóa đơn dịch vụ</h3>

        <table class="medical-history__table">

            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã bệnh án</th>
                    <th>Bệnh nhân</th>
                    <th>Tên dịch vụ</th>
                    <th>Đơn giá</th>
                    <th>Tổng tiền</th>
                     <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>

                @forelse($medicalRecordHistory as $key => $item)

                @php
                    $serviceTotal = collect($item->services)->sum('price');
                      $orderStatus = $item->order->status ?? null;
                @endphp

                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->medical_id }}</td>
                    <td>{{ $item->first_name }} {{ $item->last_name }}</td>

                    {{-- Tên dịch vụ --}}
                    <td>
                        @if(!empty($item->services))
                            @foreach($item->services as $service)
                                <div>{{ $service->name }}</div>
                            @endforeach
                        @else
                            Không có
                        @endif
                    </td>
<td>
    @if(!empty($item->services))
        @foreach($item->services as $service)
            <div>{{ number_format($service->price) }}đ</div>
        @endforeach
    @else
        -
    @endif
</td>
                    <td>{{ number_format($serviceTotal) }}đ</td>
                       <td>
                @if($orderStatus == 0)
                    <span class="text-warning">Chưa thanh toán</span>
                @elseif($orderStatus == 3)
                    <span class="text-success">Đã thanh toán</span>
                @else
                    <span class="text-muted">Không xác định</span>
                @endif
            </td>
                <td>
@if($serviceTotal > 0)

    @if($orderStatus == 3)

        <button
            class="button btn-small"
            disabled
            style="background:#ccc;cursor:not-allowed">
            Đã thanh toán
        </button>

    @else

        <button
            type="button"
            class="button btn-small btn-success"
            onclick="openPaymentModal(
                'service',
                '{{ $item->order->order_id ?? '' }}',
                {{ $serviceTotal }}
            )">
            Thanh toán
        </button>

    @endif

@else
    <span>Không có</span>
@endif
</td>
                </tr>

                @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Chưa có hóa đơn dịch vụ
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

        {{-- ================== HÓA ĐƠN THUỐC ================== --}}
        <h3 style="margin-top:40px;">Hóa đơn thuốc</h3>

        <table class="medical-history__table">

            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã bệnh án</th>
                    <th>Bệnh nhân</th>
                    <th>Tên thuốc</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Tổng tiền</th>
                     <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>

                @forelse($medicalRecordHistory as $key => $item)

                @php
                    $medicineTotal = collect($item->medicines)
                        ->sum(function($medicine){
                            return ($medicine->price ?? 0)
                                * ($medicine->quantity ?? 1);
                        });
                         $medicineOrderStatus = $item->orderMedicine->status ?? null;
                @endphp

                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->medical_id }}</td>
                    <td>{{ $item->first_name }} {{ $item->last_name }}</td>

                    {{-- Tên thuốc --}}
                    <td>
                        @if(!empty($item->medicines))
                            @foreach($item->medicines as $medicine)
                                <div>{{ $medicine->name }}</div>
                            @endforeach
                        @else
                            Không có
                        @endif
                    </td>

                    {{-- Số lượng --}}
                    <td>
                        @if(!empty($item->medicines))
                            @foreach($item->medicines as $medicine)
                                <div>{{ $medicine->quantity }}</div>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>

                   <td>
    @if(!empty($item->medicines))
        @foreach($item->medicines as $medicine)
            <div>{{ number_format($medicine->price) }}đ</div>
        @endforeach
    @else
        -
    @endif
</td>

                    <td>{{ number_format($medicineTotal) }}đ</td>
  <td>
                @if($medicineOrderStatus == 0)
                    <span class="text-warning">Chưa thanh toán</span>
                @elseif($medicineOrderStatus == 1)
                    <span class="text-success">Đã thanh toán</span>
                    @elseif($medicineOrderStatus == 2)
                    <span class="text-success">Đã phát thuốc</span>
                @else
                    <span class="text-muted">Không xác định</span>
                @endif
            </td>
                    <td>
@if($medicineTotal > 0)

    @if($medicineOrderStatus == 1 || $medicineOrderStatus == 2)

        <button
            class="button btn-small"
            disabled
            style="background:#ccc;cursor:not-allowed">
            Đã thanh toán
        </button>

    @else

        <button
            type="button"
            class="button btn-small btn-primary"
            onclick="openPaymentModal(
                'medicine',
                '{{ $item->orderMedicine->order_medicine_id ?? '' }}',
                {{ $medicineTotal }}
            )">
            Thanh toán
        </button>

    @endif

@else
    <span>Không có</span>
@endif
</td>
                </tr>

                @empty
                <tr>
                    <td colspan="8" class="text-center">
                        Chưa có hóa đơn thuốc
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>
                                <!-- Form Cập nhật thông tin -->
                             <div id="update_info"
    class="tab {{ $errors->has('firstname') || $errors->has('lastname') || $errors->has('phone') || $errors->has('birthday') || $errors->has('email') || session('info_success') || session('info_error') ? 'active' : '' }}">

    <h1 class="text-center">Cập nhật thông tin</h1>

    <form class="profile__form"
        action="{{ route('client.profile.update') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PATCH')

        <!-- AVATAR -->
        <div class="form-group">
            <label for="avatar">Ảnh đại diện</label>
            <input type="file" id="avatar" name="avatar" accept="image/*">

            @error('avatar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Họ tên -->
        <div class="form-group row">
            <div class="col">
                <label for="firstname">Họ</label>
                <input type="text" id="firstname" name="firstname"
                    value="{{ auth()->user()->firstname }}" />
                @error('firstname')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col">
                <label for="lastname">Tên</label>
                <input type="text" id="lastname" name="lastname"
                    value="{{ auth()->user()->lastname }}" />
                @error('lastname')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Phone + Birthday -->
        <div class="form-group row">
            <div class="col">
                <label for="phone">Số điện thoại</label>
                <input type="text" id="phone" name="phone"
                    value="{{ auth()->user()->phone }}" />
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col">
                <label for="birthday">Ngày sinh</label>
                <input type="date" id="birthday" name="birthday"
                    value="{{ auth()->check() && auth()->user()->birthday ? auth()->user()->birthday->format('Y-m-d') : '' }}" />
                @error('birthday')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                value="{{ auth()->user()->email }}" />
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="button btn-cta">
            Cập nhật
        </button>
      
    </form>
</div>


<div id="history" class="tab active">

    <div class="profile__medical-history" style="overflow-x: auto;">

        <h1 class="text-center">Lịch khám bệnh</h1>

        <table class="medical-history__table">

            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ngày khám</th>
                    <th>Giờ khám</th>
                    <th>Bác sĩ</th>
                    <th>Chuyên khoa</th>
                    <th>Triệu chứng</th>
                    
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>

                @if ($medicalHistory->isEmpty())

                    <tr>
                        <td colspan="8" class="text-center">
                            Không có lịch khám
                        </td>
                    </tr>

                @else

                    @foreach ($medicalHistory as $key => $item)

                        <tr>

                            <td>{{ $key + 1 }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->day)->format('d/m/Y') }}
                            </td>

                            <!-- GIỜ KHÁM -->
                            <td>
                                {{ \Carbon\Carbon::parse($item->hour)->format('H:i') }}
                            </td>

                            <td>
                                {{ $item->lastname }}
                                {{ $item->firstname }}
                            </td>

                            <td>
                                {{ $item->specialtyName }}
                            </td>

                            <td>
                                {{ $item->symptoms ?? 'Không có' }}
                            </td>
 
            </td>

                            <td>

                                @if ($item->status == 0)

                                    <span class="text-primary">
                                        Đã đặt
                                    </span>

                                @elseif ($item->status == 1)

                                    <span class="status-confirm-action">
    Xác nhận
</span>

                                @elseif ($item->status == 2)

                                    <span class="text-warning">
                                        Đã khám
                                    </span>

                                @elseif ($item->status == 3)

                                    <span class="text-info">
                                        Hoàn tất
                                    </span>

                                @else

                                <span class="status-cancel-action">
    Đã hủy
</span>
                                @endif

                            </td>

                            <td>
    @if ($item->status == 1 || $item->status == 4 || $item->status == 2 || $item->status == 3)
        <button type="button"
            class="button btn-small btn-secondary"
            disabled>
            Hủy lịch
        </button>
    @else
        <form action="{{ url('/cancel-booking/' . $item->book_id) }}"
              method="POST"
              onsubmit="return confirm('Bạn có chắc muốn hủy lịch khám?')">

            @csrf

            <button type="submit"
                class="button btn-small btn-danger">
                Hủy lịch
            </button>
        </form>
    @endif
</td>
                        </tr>

                    @endforeach

                @endif

            </tbody>

        </table>

    </div>

</div>
                                <!-- Form Đổi mật khẩu -->
                                <div id="change_password"
                                    class="tab {{ $errors->has('current_password') || $errors->has('new_password') || session('change_password_success') || session('change_password_error') ? 'active' : '' }}">
                                    <h1 class="text-center">Đổi mật khẩu</h1>
                                    <form method="POST" action="{{ route('client.profile.change-password') }}"
                                        class="profile__form">
                                        @csrf
                                        @method('PATCH')

                                        <!-- Mật khẩu hiện tại -->
                                        <div class="form-group">
                                            <label for="current_password">Mật khẩu hiện tại</label>
                                            <input type="password" id="current_password" name="current_password" />
                                            @error('current_password')
                                                <div class="error-message" style="color: red;">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Mật khẩu mới -->
                                        <div class="form-group">
                                            <label for="new_password">Mật khẩu mới</label>
                                            <input type="password" id="new_password" name="new_password" />
                                            @error('new_password')
                                                <div class="error-message" style="color: red;">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Xác nhận mật khẩu mới -->
                                        <div class="form-group">
                                            <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                                            <input type="password" id="new_password_confirmation"
                                                name="new_password_confirmation" />
                                            @error('new_password_confirmation')
                                                <div class="error-message" style="color: red;">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Nút submit -->
                                        <button type="submit" class="button btn-cta">Đổi mật khẩu</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal 1: Chi tiết lịch sử khám bệnh -->
        <div id="detailsModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeDetailsModal()">&times;</span>
                <h2>Chi tiết lịch sử khám bệnh</h2>
                <p><strong>Mã đơn:</strong> <span id="modal-book-id"></span></p>
                <p><strong>Ngày khám:</strong> <span id="modal-day"></span></p>
                <p><strong>Giờ khám:</strong> <span id="modal-hour"></span></p>
                <p><strong>Họ tên:</strong> <span id="modal-name"></span></p>
                <p><strong>Số điện thoại:</strong> <span id="modal-phone"></span></p>
                <p><strong>Email:</strong> <span id="modal-email"></span></p>
                <p><strong>Triệu chứng:</strong> <span id="modal-symptoms"></span></p>
                <p><strong>Chuyên khoa:</strong> <span id="modal-specialty-id"></span></p>
                <p><strong>Hình thức khám:</strong> <span id="modal-role"></span></p>
                <p><strong>Trạng thái:</strong> <span id="modal-status"></span></p>
                <p><strong>Link khám trực tuyến:</strong> <a id="modal-url" href="" target="_blank">Khám trực
                        tuyến</a></p>
            </div>
        </div>

        <!-- Modal 2: Chi tiết bệnh án -->
        <div id="detailsMediaRecordModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closeDetailsMediaRecordModal()">&times;</span>
                <h2>Chi tiết bệnh án</h2>

                <div class="modal-body">
                    <!-- Phần bên trái: Chi tiết bệnh án -->
                    <div class="left-column">
                        <p><strong>Mã bệnh án:</strong> <span id="modal-medical-id"></span></p>
                        <p><strong>Chẩn đoán:</strong> <span id="modal-diagnosis"></span></p>
                        <p><strong>Ngày tái khám:</strong> <span id="modal-re-exam-date"></span></p>
                        <p><strong>Lời khuyên:</strong> <span id="modal-advice"></span></p>
                        <p><strong>Huyết áp:</strong> <span id="modal-blood-pressure"></span></p>
                        <p><strong>Nhịp thở:</strong> <span id="modal-respiratory-rate"></span></p>
                        <p><strong>Cân nặng:</strong> <span id="modal-weight"></span> kg</p>
                        <p><strong>Chiều cao:</strong> <span id="modal-height"></span> cm</p>
                        <p><strong>Bệnh nhân:</strong> <span id="modal-patient-name"></span></p>
                    </div>

                    <!-- Phần bên phải: Dịch vụ -->
                    <div class="right-column">
                        <p><strong>Dịch vụ:</strong></p>
                        <div id="modal-services"></div>
                        <p><strong>Tổng chi phí:</strong> <span id="modal-total-price"></span></p>
                          <!-- Nút thanh toán dịch vụ -->
                
                    </div>
                </div>

                <!-- Bảng thuốc nằm dưới cùng -->
                <div class="medicines-section">
                    <p><strong>Đơn thuốc:</strong></p>
                    <ul id="modal-medicines"></ul>
                     
                </div>
            </div>
        </div>
      <div class="modal_upload" id="uploadPopup" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2>Tải lên ảnh đại diện</h2>
        <div class="modal-body">
            <form id="avatarForm" action="{{ route('client.profile.change-avatar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <input type="file" name="avatar" id="avatarUpload" accept="image/*" required onchange="previewImage(event)">
                    @error('avatar')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div id="imagePreview" style="width: 30%; margin-top: 10px;">
                    <img id="previewImg" src="" alt="Image Preview" style="display: none; max-width: 100%; border-radius: 5px; border: 1px solid #ddd;">
                </div>
                <button type="submit" class="button btn-cta" style="margin-top: 10px;">Tải lên</button>
            </form>
        </div>
    </div>
</div>


        <script>
            // Function to close the details modal for booking history
            function closeDetailsModal() {
                document.getElementById("detailsModal").style.display = "none";
            }

            // Function to close the details modal for medical record
            function closeDetailsMediaRecordModal() {
                document.getElementById("detailsMediaRecordModal").style.display = "none";
            }

            document.addEventListener('DOMContentLoaded', function() {
                const activeTab = "{{ session('active_tab') }}";
                if (activeTab) {
                    openTab(null, activeTab); // Mở tab từ session
                }
            });
            
        </script>
<!-- Modal thanh toán -->
<div id="paymentModal" class="modal" style="display:none">

<div class="modal-content">

<span class="close"
onclick="closePaymentModal()">
&times;
</span>

<h3>Thanh toán hóa đơn</h3>

<form action="{{ url('ho-so/invoice/payment') }}"
      method="POST">

    @csrf

  <input type="hidden"
       id="payment_type"
       name="type">

<input type="hidden"
       id="order_id"
       name="order_id">

    <div class="form-group">

        <label>Tổng tiền</label>

        <input type="text"
               id="payment_total"
               readonly>

    </div>

    <div class="form-group">


        <div class="form-group payment-method-group">
    <label>Phương thức thanh toán</label>

    <div class="select-wrapper">
        <select name="payment_method" required>
            <option value="">💳 Chọn phương thức thanh toán</option>
            <option value="cash">
                💵 Tiền mặt
            </option>

            <option value="momo">
                📱 MOMO
            </option>
        </select>
    </div>
</div>

    </div>

    <button type="submit"
            class="button btn-success">

        Xác nhận thanh toán

    </button>

</form>

</div>
</div>
<script>

function openPaymentModal(
type,
orderId,
total
){

document.getElementById(
"paymentModal"
).style.display="block";

document.getElementById(
"payment_type"
).value = type;

document.getElementById(
"order_id"
).value = orderId;

document.getElementById(
"payment_total"
).value =
new Intl.NumberFormat(
'vi-VN'
).format(total)
+' đ';

}

function closePaymentModal(){

document.getElementById(
"paymentModal"
).style.display="none";

}

</script>
<script>
function checkForm() {
    const requiredFields = [
        'firstname',
        'lastname',
        'gender',
        'birthday',
        'cccd',
        'address',
        'phone',
        'occupation',
        'national'
    ];

    let ok = true;

    requiredFields.forEach(name => {
        const el = document.querySelector(`[name="${name}"]`);
        if (!el || el.value.trim() === '') {
            ok = false;
        }
    });

    document.getElementById('submitBtn').disabled = !ok;
}
</script>
    @endsection
