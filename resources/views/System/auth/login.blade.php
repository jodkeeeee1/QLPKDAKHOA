<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin</title>

    <link rel="stylesheet" href="{{ asset('backend/assets/css/styles.admin.css') }}" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

      body {
    font-family: Arial, sans-serif;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;

    /* Background bệnh viện */
    background:
        linear-gradient(rgba(255,255,255,0.75),
            rgba(255,255,255,0.75)),
        url('https://images.unsplash.com/photo-1586773860418-d37222d8fce3?q=80&w=1600&auto=format&fit=crop');

    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

        .login-wrapper {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .ibox-content {
            background: #fff;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .title {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-size: 28px;
            font-weight: bold;
        }

        .tabs {
            display: flex;
            margin-bottom: 25px;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #ddd;
        }

        .tab-btn {
            flex: 1;
            padding: 12px;
            border: none;
            background: #f5f5f5;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .tab-btn.active {
            background: #4e73df;
            color: white;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            transition: 0.3s;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 5px rgba(78, 115, 223, 0.4);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #4e73df;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #2e59d9;
        }

        .forgot-password {
            display: block;
            margin-top: 15px;
            text-align: center;
            text-decoration: none;
            color: #666;
            font-size: 14px;
        }

        .forgot-password:hover {
            color: #4e73df;
        }

        .error-danger {
            color: red;
            margin-top: 5px;
            font-size: 14px;
        }

        .role-title {
            text-align: center;
            margin-bottom: 20px;
            color: #4e73df;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <div class="ibox-content">

            <h2 class="title">Đăng Nhập Hệ Thống</h2>

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab-btn active" onclick="changeRole(event, 'admin')">
                    Admin
                </button>

                <button class="tab-btn" onclick="changeRole(event, 'doctor')">
                    Bác sĩ
                </button>

                <button class="tab-btn" onclick="changeRole(event, 'staff')">
                    Nhân viên
                </button>
            </div>

            <!-- Form -->
            <form class="m-t" role="form" action="" method="post">
                @csrf

                <input type="hidden" name="role" id="role" value="admin">

                <div class="role-title" id="roleTitle">
                    Đăng nhập Admin
                </div>

                <div class="form-group">
                    <input type="text"
                        class="form-control"
                        placeholder="Email"
                        name="email"
                        value="{{ old('email') }}">

                    @error('email')
                        <div class="error-danger">* {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password"
                        class="form-control"
                        placeholder="Mật khẩu"
                        name="password">

                    @error('password')
                        <div class="error-danger">* {{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    Đăng nhập
                </button>

            </form>

        </div>
    </div>

    <script>
        function changeRole(event, role) {

            // Remove active
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active
            event.target.classList.add('active');

            // Change hidden input
            document.getElementById('role').value = role;

            // Change title
            let title = '';

            if (role === 'admin') {
                title = 'Đăng nhập Admin';
            } else if (role === 'doctor') {
                title = 'Đăng nhập Bác sĩ';
            } else {
                title = 'Đăng nhập Nhân viên';
            }

            document.getElementById('roleTitle').innerText = title;
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <x-message.message></x-message.message>

</body>

</html>