<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hóa Đơn Mua Hàng</title>

    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }

        .invoice-container {
            width: 100%;
            padding: 20px;
        }

        .header {
            border-bottom: 2px solid #ddd;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }

        .info p {
            margin: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background: #f2f2f2;
            padding: 8px;
        }

        td {
            padding: 8px;
        }

        .footer {
            margin-top: 20px;
        }

        .total {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .box {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>

<div class="invoice-container">

    {{-- HEADER --}}
    <div class="header">
        <p><b>Bệnh viện Đa Khoa Nhật Minh</b></p>
        <p>Địa chỉ: 315 Nguyễn Văn Linh, An Khánh, Ninh Kiều</p>
        <p>SĐT: 0292.xxx.xxx</p>
    </div>

    <div class="title">HÓA ĐƠN MUA HÀNG</div>

    <div class="subtitle">
        {{ \Carbon\Carbon::parse($order->created_at)->format('H:i:s d/m/Y') }}
    </div>

    {{-- INFO --}}
    <div class="info">
        <p><b>Mã hóa đơn:</b> {{ $order->order_id }}</p>
        <p><b>Khách hàng:</b> {{ $order->order_username }}</p>
        <p><b>SĐT:</b> {{ $order->order_phone }}</p>
        <p><b>Email:</b> {{ $order->email }}</p>
        <p><b>Địa chỉ:</b> {{ $order->order_address }}</p>
    </div>

    {{-- PAYMENT INFO --}}
    <div class="box">
        <p><b>Hình thức thanh toán:</b>
            @if($order->payment_method == 0)
                Tiền mặt
            @elseif($order->payment_method == 1)
                Momo
            @elseif($order->payment_method == 2)
                VNPay
            @elseif($order->payment_method == 3)
                ZaloPay
            @else
                Không xác định
            @endif
        </p>

        <p><b>Số lượng:</b> {{ $order->total_quantity }}</p>

        <p><b>Phí ship:</b>
            {{ number_format($order->price_old ? ($order->price_sale - $order->price_old) : 0, 0, ',', '.') }} VND
        </p>

        @if(!empty($order->percent))
        <p><b>Giảm giá:</b> {{ $order->percent }}%</p>
        @endif
    </div>

    {{-- PRODUCTS --}}
    <h4>Danh sách sản phẩm</h4>

    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Tên sản phẩm</th>
        </tr>
        </thead>
        <tbody>
        @php
            $products = explode(';', $order->product_names);
        @endphp

        @foreach($products as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ trim($item) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- TOTAL --}}
    <div class="footer">
        <div class="total">
            <p><span class="bold">Tổng tiền:</span>
                {{ number_format($order->price_sale, 0, ',', '.') }} VND
            </p>
        </div>
    </div>

</div>

</body>
</html>