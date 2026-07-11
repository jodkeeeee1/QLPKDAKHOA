<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khôi phục mật khẩu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: #4361ee;
            color: white;
            padding: 25px 30px;
            text-align: center;
        }

        .logo {
            margin-bottom: 15px;
        }

        .header-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .header-subtitle {
            font-size: 16px;
            opacity: 0.9;
        }

        .email-body {
            padding: 30px;
            color: #444;
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .message {
            margin-bottom: 25px;
            font-size: 16px;
        }

        .action-container {
            text-align: center;
            margin: 35px 0;
        }

        .btn-reset {
            display: inline-block;
            padding: 12px 30px;
            background-color: #4361ee;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 3px 6px rgba(67, 97, 238, 0.3);
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            background-color: #3a56d4;
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(67, 97, 238, 0.4);
        }

        .expiry-warning {
            margin: 20px 0;
            font-size: 14px;
            color: #666;
            text-align: center;
        }

        .security-notice {
            background-color: #f8f9fa;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 25px 0;
            font-size: 14px;
        }

        .security-notice-title {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }

        .link-fallback {
            word-break: break-all;
            font-size: 14px;
            color: #666;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin-top: 20px;
        }

        .email-footer {
            background-color: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            font-size: 14px;
            color: #666;
            border-top: 1px solid #eee;
        }

        .footer-links {
            margin: 15px 0;
        }

        .footer-links a {
            color: #4361ee;
            text-decoration: none;
            margin: 0 10px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .social-icons {
            margin: 15px 0;
        }

        .social-icon {
            display: inline-block;
            width: 32px;
            height: 32px;
            background-color: #4361ee;
            border-radius: 50%;
            margin: 0 5px;
            color: white;
            line-height: 32px;
            text-align: center;
            text-decoration: none;
        }

        .copyright {
            margin-top: 15px;
            font-size: 13px;
            color: #888;
        }

        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100%;
                border-radius: 0;
            }

            .email-header {
                padding: 20px 15px;
            }

            .email-body {
                padding: 20px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <div class="logo">
                <!-- Placeholder for logo -->
                <svg width="50" height="50" viewBox="0 0 50 50" fill="none">
                    <rect width="50" height="50" rx="10" fill="#FFF" opacity="0.2" />
                    <path d="M15 25L22 32L35 18" stroke="#FFF" stroke-width="3" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <h1 class="header-title">Khôi phục mật khẩu</h1>
            <p class="header-subtitle">Hoàn tất việc đặt lại mật khẩu của bạn</p>
        </div>

        <div class="email-body">
            <p class="greeting">Xin chào!</p>

            <p class="message">Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Để hoàn tất quá trình
                này, vui lòng nhấn vào nút bên dưới.</p>

            <div class="action-container">
                <a href="{{ $resetLink }}" target="_blank" class="btn-reset">
                    Đặt lại mật khẩu
                </a>
            </div>

            <p class="expiry-warning">Liên kết này sẽ hết hạn sau 24 giờ. Sau thời gian này, bạn sẽ cần yêu cầu đặt lại
                mật khẩu mới.</p>

            <div class="security-notice">
                <p class="security-notice-title">⚠️ Lưu ý bảo mật quan trọng:</p>
                <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này hoặc liên hệ với bộ phận hỗ trợ của
                    chúng tôi ngay lập tức.</p>
            </div>

            <p>Nếu bạn gặp vấn đề khi nhấn vào nút trên, hãy sao chép và dán liên kết dưới đây vào trình duyệt của bạn:
            </p>

            <div class="link-fallback">
                <a href="{{ $resetLink }}" target="_blank">
                    {{ $resetLink }}
                </a>
            </div>
        </div>

        <div class="email-footer">
            <p>Trân trọng,<br><strong>Đội ngũ hỗ trợ</strong></p>

            <div class="footer-links">
                <a href="#">Trung tâm trợ giúp</a> |
                <a href="#">Liên hệ</a> |
                <a href="#">Chính sách bảo mật</a>
            </div>

            <div class="social-icons">
                <a href="#" class="social-icon">f</a>
                <a href="#" class="social-icon">in</a>
                <a href="#" class="social-icon">t</a>
            </div>

            <p class="copyright">
                © 2025 Công ty của bạn. Tất cả các quyền được bảo lưu.
            </p>
        </div>
    </div>
</body>

</html>
