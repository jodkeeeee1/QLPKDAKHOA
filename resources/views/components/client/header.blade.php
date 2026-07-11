<header class="header">
    <div class="container">
        <div class="header__frame">
            <a href="{{ route('client.home') }}" class="header__logo">
                <img src="{{ asset('frontend/shop/img/NhatMinh.png')}}" alt="" />
            </a>
            <div class="header__wrap">
                <ul class="header__menu mt-3">
                    <li class="item">
                        <a class="item__link" href="/">
    Trang chủ
</a>
                    </li>

                    <li class="item">
                        <a class="item__link" href="{{ route('shop.shop') }}">Cửa Hàng</a>
                    </li>
                    <li class="item">
                        <a class="item__link" href="{{ route('client.news') }}">Tin tức</a>
                    </li>

                    <!-- <li class="item">
                        <a class="item__link" href="{{ route('client.contact') }}">Liên hệ</a>
                    </li> -->
<!-- 
                    <li class="item">
                        <a class="item__link" href="{{ route('client.meeting') }}">Cuộc họp</a>
                    </li> -->
                    @if(auth()->check() && (auth()->user()->role == 1 || auth()->user()->role == 2))
    <li class="item">
        <a class="item__link" href="http://127.0.0.1:8000/admin">
            Quản lý
        </a>
    </li>
@endif
                </ul>

            </div>
           @if (auth()->check())
    <div class="header__login" onclick="toggleMenu()">
        <img
            src="{{ auth()->user()->avatar
                ? asset('storage/uploads/avatars/' . auth()->user()->avatar)
                : 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png' }}"
            alt="{{ auth()->user()->name }}"
            style="
                width:70px;
                height:50px;
                border-radius:50%;
                object-fit:cover;
                border:1px solid #048647;
            ">

        <div id="dropdownMenu" class="dropdown-menu" style="display:none;">
            <ul>
                <a href="{{ route('client.profile.index') }}">
                    <li><i class="fa-regular fa-user"></i> Thông tin tài khoản</li>
                </a>
                <a href="{{ route('client.logout') }}">
                    <li><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</li>
                </a>
            </ul>
        </div>
    </div>
@else
    <div class="header__login">
        <div class="login-container">
            <div class="button btn-small btn-cta openPopup">
                Đăng nhập
            </div>

            <div id="dropdownMenu" class="dropdown-menu" style="display:none;">
                <ul>
                    <a href="{{ route('client.login') }}">
                        <li><i class="fa-regular fa-user"></i> Đăng nhập người dùng</li>
                    </a>
                    <a href="{{ route('system.auth.login') }}">
                        <li><i class="fa-solid fa-user-doctor"></i> Đăng nhập bác sĩ</li>
                    </a>
                </ul>
            </div>
        </div>
    </div>
    <script>
    const loginContainer = document.querySelector('.login-container');
    const loginOptions = document.querySelector('.dropdown-menu');
    const loginButton = loginContainer.querySelector('.openPopup');

    loginButton.addEventListener('click', function(event) {
        event.stopPropagation();
        loginOptions.style.display =
            loginOptions.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function() {
        loginOptions.style.display = 'none';
    });
</script>
@endif

          <div class="header__booking">

    @if(auth()->check())
        <a href="{{ route('client.booking') }}">
            <div style="background-color: #ffbc11" class="button btn-small btn-cta">
                <i class="fa-regular fa-calendar-check"></i> Đặt lịch
            </div>
        </a>
    @else
        <a href="javascript:void(0)" onclick="showLoginAlert()">
            <div style="background-color: #ffbc11" class="button btn-small btn-cta">
                <i class="fa-regular fa-calendar-check"></i> Đặt lịch
            </div>
        </a>
    @endif

</div>
<script>
    function showLoginAlert() {
        alert('Bạn cần đăng nhập mới có thể đặt lịch!');
        window.location.href = "{{ route('client.login') }}";
    }
</script>
                </a>

            </div>
        </div>
    </div>
</header>

<div class="rd-panel">
    <div class="rd-panel__wrap">
        <button class="toggle"><span></span></button>
        <div class="logo">
            <a href="{{ route('client.home') }}"><img src="{{ asset('frontend/assets/image/logo2.png') }}" /></a>
        </div>
    </div>
    <div class="rd-panel__btn">
        <a href="{{ route('client.booking') }}">
            <div class="button btn-flex openPopup" data-popup="#popupBooking">
                <i class="fa-regular fa-calendar-check"></i> Đặt lịch
            </div>
        </a>
    </div>
    @if (auth()->check())
        <div style="width: 200px" class="header__login">
            <a href="{{ route('client.profile.index') }}" class="">{{ auth()->user()->name }}</a>
        </div>
    @else
        <div class="rd-panel__btn">
            <a href="{{ route('client.login') }}">
                <div class="button btn-flex openPopup">
                    Đăng nhập
                </div>
            </a>

        </div>
    @endif


</div>

<div class="rd-menu">
    <ul>
        <li class="active">
            <a href="{{ route('client.home') }}">Trang chủ</a>
        </li>
        <li class="">
            <a href="{{ route('client.introduce') }}">Giới thiệu</a>
        </li>
        <li class="">
            <a href="#">Sản phẩm</a>
        </li>
        <li class="">
            <a href="{{ route('client.news') }}">Tin tức</a>
        </li>
        <li class="">
            <a href="{{ route('client.contact') }}">Liên hệ</a>
        </li>
    </ul>
</div>
