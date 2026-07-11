<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Phiếu Chỉ Định Cận Lâm Sàng</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ storage_path('fonts/DejaVuSans.ttf') }}');
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            width: 100%;
            height: 600px;
        }

        .header {
    width: 100%;
    margin-bottom: 30px;
}

        .header img {
            width: 100px;
            height: auto;
            margin-right: 10px;
        }

       .hospital-info {
    display: inline-block;
    vertical-align: top;
    margin-left: 10px;
}
        .header h4,
        .header p {
            margin: 2px 0;
        }

        .header h4 {
            font-size: 18px;
            text-transform: uppercase;
        }

        h2 {
    clear: both;
    text-align: center;
    margin-top: 30px;
    margin-bottom: 20px;
    font-size: 22px;
}

        .patient-info p,
        .footer p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .note {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

      .total_price {
    position: absolute;
    right: 0;
}

        .footer {
            position: absolute;
            right: 0;
            text-align: right;
        }

      
.codeService {
    float: right;
    text-align: center;
}

    </style>
</head>

<body>
   <div class="header">
    <img src="{{ base_path('public/backend/assets/images/logos/NhatMinh.png') }}"
        alt="Hospital Logo" width="80">

    <div class="hospital-info">
        <h4>BỆNH VIỆN ĐA KHOA NHẬT MINH</h4>
        <p>Địa chỉ: 54 Đản Dị - Uy Nỗ - Đông Anh - Hà Nội</p>
        <p>SĐT: 0978.658.099</p>
    </div>

    <div class="codeService">
        {!! $barcode !!}
        <div>{{ $data['order_id'] }}</div>
    </div>
</div>

<h2>PHIẾU CHỈ ĐỊNH CẬN LÂM SÀNG</h2>
    <div class="patient-info">
      <p>
    <strong>Họ tên người bệnh:</strong>
    @if($data['medical'] && $data['medical']->patient)
    {{ $data['medical']->patient->first_name }}
@endif
</p>

<p>
    <strong>Ngày sinh:</strong>
    {{ $data['medical']->patient->birthday ?? '' }}
</p>

<p>
    <strong>Địa chỉ:</strong>
    {{ $data['medical']->patient->address ?? '' }}
</p>

@if (($data['medical']->patient->gender ?? 0) == 1)
    <p><strong>Giới tính:</strong> Nam</p>
@else
    <p><strong>Giới tính:</strong> Nữ</p>
@endif
        <p><strong>Khoa khám bệnh:</strong> {{ $data['specialty']->name }}</p>
    </div>

    <h3>Nội Dung Chỉ Định</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tên cận lâm sàng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @php $count = 1; @endphp
            @foreach ($data['services'] as $item)
                @php $int = $count++ @endphp
                <tr>
                    <td>{{ $int }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach
           
        </tbody>
    </table>
    <div class="note">
        <p class="total_price">Tổng cộng: {{ number_format($data['total'], 0, ',', '.') }} VNĐ</p>
        <p class="notes"><strong>Ghi chú:</strong> </p>
    </div>

    <div class="footer">
        <p><strong>Ngày:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        <p><strong>Bác sĩ điều trị:</strong> {{ $data['doctor']->lastname ?? '' }} {{ $data['doctor']->firstname ?? '' }}
        </p>

    </div>
</body>

</html>
