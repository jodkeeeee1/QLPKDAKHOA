<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đặt lịch khám bệnh</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRlBeZHcZl2R77xKpG1gaJ5ppJ6DW2aegeOEP8nMR" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1e88e5;
            --secondary-color: #4caf50;
            --accent-color: #f5f9ff;
            --border-radius: 12px;
            --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #444;
        }

        .confirmation-card {
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: none;
            overflow: hidden;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem;
            border-bottom: none;
        }

        .card-header .success-icon {
            width: 60px;
            height: 60px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .card-header .success-icon i {
            font-size: 30px;
            color: var(--secondary-color);
        }

        .appointment-details {
            background-color: var(--accent-color);
            border-left: 4px solid var(--primary-color);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            padding: 0.75rem 1rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .detail-item i {
            color: var(--primary-color);
            width: 24px;
            margin-right: 12px;
            text-align: center;
        }

        .info-section {
            background-color: #fff;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            padding: 1.25rem;
        }

        .info-section-title {
            border-bottom: 2px solid #eee;
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        .reminder {
            background-color: #e8f5e9;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1.5rem;
        }

        .reminder i {
            color: var(--secondary-color);
        }

        .hospital-logo {
            width: 120px;
            height: auto;
            margin-bottom: 1rem;
        }

        .qr-code {
            text-align: center;
            padding: 1rem;
        }

        .footer-info {
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
            padding: 1.25rem;
            text-align: center;
            font-size: 0.9rem;
            color: #666;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 1rem 0;
        }

        .social-icons i {
            font-size: 20px;
            color: var(--primary-color);
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .contact-info div {
            display: flex;
            align-items: center;
        }

        .contact-info i {
            margin-right: 6px;
            color: var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        .tag-specialty {
            background-color: #e3f2fd;
            color: var(--primary-color);
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 0.85rem;
            display: inline-block;
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="card confirmation-card">
            <div class="card-header text-center">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h1 class="display-6 fw-bold mb-2">Đặt lịch thành công</h1>
                <p class="mb-0">Cảm ơn bạn đã đặt lịch khám tại phòng khám của chúng tôi</p>
            </div>

            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="info-section">
                            <h4 class="info-section-title">
                                <i class="fas fa-user-circle me-2"></i>Thông tin cá nhân
                            </h4>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <i class="fas fa-user"></i>
                                        <div>
                                            <small class="text-muted d-block">Họ và tên</small>
                                            <strong>{{ $book->name }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <i class="fas fa-phone"></i>
                                        <div>
                                            <small class="text-muted d-block">Số điện thoại</small>
                                            <strong>{{ $book->phone }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="detail-item">
                                        <i class="fas fa-envelope"></i>
                                        <div>
                                            <small class="text-muted d-block">Email</small>
                                            <strong>{{ $book->email }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="info-section">
                            <h4 class="info-section-title">
                                <i class="fas fa-stethoscope me-2"></i>Thông tin khám bệnh
                            </h4>

                            <div class="appointment-details">
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar-alt me-2 fs-4 text-primary"></i>
                                            <div>
                                                <small class="text-muted">Ngày khám</small>
                                                <h5 class="mb-0">{{ $book->day }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock me-2 fs-4 text-primary"></i>
                                            <div>
                                                <small class="text-muted">Giờ khám</small>
                                                <h5 class="mb-0">{{ $book->hour }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           <div class="mb-3">
    <h5 class="mb-2">Chuyên khoa</h5>

    @if ($specialty)
        <span class="tag-specialty">
            <i class="fas fa-tag me-1"></i>{{ $specialty->name }}
        </span>
    @else
        <span class="tag-specialty">
            <i class="fas fa-tag me-1"></i>Khám tổng quát
        </span>
    @endif
</div>
<div class="mb-3">
    <h5 class="mb-2">Bác sĩ</h5>

    @isset($doctor)
        <span class="tag-specialty">
            <i class="fas fa-user-md me-1"></i>
            {{ $doctor->lastname ?? '' }}
            {{ $doctor->firstname ?? '' }}
        </span>
    @endisset
</div>
                            <div>
                                <h5 class="mb-2">Triệu chứng</h5>
                                <p class="bg-light p-3 rounded">{{ $book->symptoms }}</p>
                            </div>

                            <div class="reminder mt-4">
                                <div class="d-flex">
                                    <i class="fas fa-info-circle me-2 mt-1"></i>
                                    <div>
                                        <h5 class="mb-1">Lưu ý quan trọng</h5>
                                        <ul class="mb-0">
                                            <li>Vui lòng đến trước giờ hẹn 15 phút để làm thủ tục</li>
                                            <li>Mang theo CMND/CCCD và thẻ BHYT (nếu có)</li>
                                            <li>Mang theo kết quả xét nghiệm và đơn thuốc cũ (nếu có)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>
            </div>

            <div class="footer-info">
                <p class="mb-3">Cảm ơn bạn đã tin tưởng và lựa chọn dịch vụ của chúng tôi</p>

                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                </div>

                <p class="small text-muted">© 2025 Phòng khám đa khoa. Tất cả các quyền được bảo lưu.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-8rbFvFYTZFBwTEQq7kJjS4URCpO7fu95aDqxIw5ElhFtyYPTEFz5vJ4VxF8CAB7S" crossorigin="anonymous">
    </script>
</body>

</html>
