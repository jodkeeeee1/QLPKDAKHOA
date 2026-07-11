@extends('layouts.client.master')

@section('meta_title', 'Bệnh viện')
<style>
    .hover-text-white:hover {
        color: #ffffff !important;
        transition: color 0.3s ease;
    }
</style>
@section('content')
    <div class="main-body">
        <div class="section box box-head">
            <div class="bg box-head__bg">
                <img src="{{ asset('frontend/assets/image/banner.png') }}" alt="Background">
            </div>
            <div class="box box-head__frame">
                <div class="container">
                    <div class="">
                        <div class="col l-12 mc-12 c-12">
                            <div class="box-head__image">
                                <!-- <img src="{{ asset('frontend/assets/image/banner-2.png') }}" alt="Image"> -->
                            </div>
                        </div>
                        <div class="col l-12 mc-12 c-12">
                            <div class="box-head__service">
                                <div class=">
                                    <div class="col l-12 mc-12 c-12 mt-5">
                               <h2 class="box-title">CAM KẾT ĐIỀU TRỊ <span class="highlight">DỨT ĐIỂM</span> CÁC BỆNH LÝ</h2>
                                    </div>
                                    <div class="col l-12 mc-12 c-12 mt-5">
                                        <div class="service__featured">
                                            <div class="row gap-y-20">
                                                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                                                    <div class="item">
                                                        <a href="" class="item__frame">
                                                            <div class="item__image">
                                                                <img src="{{ asset('frontend/assets/image/icon-index/eye.png') }}"
                                                                    alt="Viêm mũi" />
                                                            </div>
                                                            <h3 class="item__title title">Bệnh về mắt</h3>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                                                    <div class="item">
                                                        <a href="" class="item__frame">
                                                            <div class="item__image">
                                                                <img src="{{ asset('frontend/assets/image/icon-index/heartt.png') }}"
                                                                    alt="Tim mạch" />
                                                            </div>
                                                            <h3 class="item__title title">Tim mạch</h3>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                                                    <div class="item">
                                                        <a href="" class="item__frame">
                                                            <div class="item__image">
                                                                <img src="{{ asset('frontend/assets/image/icon-index/ear.png') }}"
                                                                    alt="Tai mũi họng" />
                                                            </div>
                                                            <h3 class="item__title title">Tai mũi họng</h3>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-4 col-sm-6 p-3">
                                                    <div class="item">
                                                        <a href="" class="item__frame">
                                                            <div class="item__image">
                                                                <img src="{{ asset('frontend/assets/image/icon-index/body.png') }}"
                                                                    alt="Xương khớp" />
                                                            </div>
                                                            <h3 class="item__title title">Xương khớp</h3>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section box box-commit">
            <div class="container">
                <div class="box-commit__frame">
                    <div class="row gap-y-40">
                        <div class="col l-5 mc-12 c-12">
                            <div class="box-commit__image">
                                <img src="{{ asset('frontend/assets/image/bg.png') }}" alt="Cam kết" />
                            </div>
                        </div>
                        <div class="col l-7 mc-12 c-12">
                            <div class="box-commit__main">
                                <div class=" gap-y-40">
                                    <div class="col l-12 mc-12 c-12">
                                        <h2 class="box-title highlight">
                                            <p>Các con số <span>Ấn tượng</span></p>
                                            TẠI Phòng khám Đa Khoa <p>Nhật Minh</p>
                                        </h2>
                                    </div>
                                    <div class="col l-12 mc-12 c-12">
                                        <div class="box-count">
                                            <div class="row gap-y-20">
                                                <div class="col l-4 mc-4 c-12">
                                                    <div class="item">
                                                        <div class="item__frame">
                                                            <div class="item__image">
                                                                <img src="{{ asset('frontend/assets/image/icon_commit_1 1.png') }}"
                                                                    alt="Khách hàng đang điều trị" />
                                                            </div>
                                                            <div class="item__body">
                                                                <div class="item__number" data-count="100">
                                                                    <span>0</span>+
                                                                </div>
                                                                <div class="item__title">
                                                                    Khách hàng đang điều trị
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-4 mc-4 c-12">
                                                    <div class="item">
                                                        <div class="item__frame">
                                                            <div class="item__image">
                                                                <img src="{{ asset('frontend/assets/image/icon_commit_2 1.png') }}"
                                                                    alt="Khách hàng hồi phục" />
                                                            </div>
                                                            <div class="item__body">
                                                                <div class="item__number" data-count="500">
                                                                    <span>0</span>+
                                                                </div>
                                                                <div class="item__title">
                                                                    Khách hàng hồi phục
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-4 mc-4 c-12">
                                                    <div class="item">
                                                        <div class="item__frame">
                                                            <div class="item__image">
                                                                <img src=" {{ asset('frontend/assets/image/icon_commit_3 1.png') }}"
                                                                    alt="Khách hàng hài lòng về dịch vụ" />
                                                            </div>
                                                            <div class="item__body">
                                                                <div class="item__number" data-count="99">
                                                                    <span>0</span>%
                                                                </div>
                                                                <div class="item__title">
                                                                    Khách hàng hài lòng về dịch vụ
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                let a = 0;
                                                const boxNumberWrap = $(".box-count .item__number");
                                                let boxNumberWrapCount = boxNumberWrap.length;
                                                const oTop =
                                                    $(".box-count").offset().top - window.innerHeight;
                                                let animationFinished = false;

                                                function animateNumbers() {
                                                    boxNumberWrap.each(function() {
                                                        const $this = $(this);
                                                        const countTo = $this.attr("data-count");

                                                        $({
                                                            countNum: $this.find("span").text(),
                                                        }).animate({
                                                            countNum: countTo,
                                                        }, {
                                                            duration: 2000,
                                                            easing: "swing",
                                                            step: function() {
                                                                $this
                                                                    .find("span")
                                                                    .text(
                                                                        Math.floor(
                                                                            this.countNum
                                                                        ).toLocaleString("vi-VN")
                                                                    );
                                                            },
                                                            complete: function() {
                                                                $this
                                                                    .find("span")
                                                                    .text(
                                                                        this.countNum.toLocaleString("vi-VN")
                                                                    );

                                                                if (--boxNumberWrapCount === 0) {
                                                                    animationFinished = true;
                                                                }
                                                            },
                                                        });
                                                    });
                                                }

                                                $(window).scroll(function() {
                                                    if (animationFinished) {
                                                        return;
                                                    }

                                                    if (a === 0 && $(window).scrollTop() > oTop) {
                                                        a = 1;
                                                        requestAnimationFrame(animateNumbers);
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="section box box-process">
                <div class="container">
                    <div class="box-process__frame">
                        <div class="">
                            <div class="col l-12 mc-12 c-12">
                                <h2 class="box-title text-center">
                                    QUY TRÌNH ĐIỀU TRỊ <span>TẠI Nhật Minh</span>
                                </h2>
                                <div class="box-description">
                                    Phòng khám Đa Khoa Nhật Minh cam kết mang đến trải nghiệm chăm sóc sức khỏe cơ
                                    xương khớp toàn diện với sự kết hợp giữa Chiropractic, Trị liệu cơ
                                    chuyên sâu và Vật lý trị liệu công nghệ cao, giúp khách hàng giải
                                    quyết các vấn đề cơ xương khớp từ gốc rễ và cảm nhận được sự chữa
                                    lành từ sâu bên trong.
                                </div>
                            </div>
                            <div class="col l-12 mc-12 c-12 mt-3">
                                <div class="box-process__main nav-tabs-custom">
                                    <div class="process__tab tab__list">
                                        <div class="tab active" data-pane="#pane_1">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="{{ asset('frontend/assets/image/icon-index/phone-check.png') }}"
                                                        alt="Thăm khám" />
                                                </div>
                                                <div class="tab__title">Đặt lịch khám</div>
                                            </div>
                                        </div>
                                        <div class="tab" data-pane="#pane_2">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="{{ asset('frontend/assets/image/icon-index/stethoscope.png') }}"
                                                        alt="Tiếp nhận" />
                                                </div>
                                                <div class="tab__title">Tiếp nhận</div>
                                            </div>
                                        </div>
                                        <div class="tab" data-pane="#pane_3">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="{{ asset('frontend/assets/image/icon-index/heart-handshake.png') }}"
                                                        alt="Thăm khám" />
                                                </div>
                                                <div class="tab__title">Thăm khám</div>
                                            </div>
                                        </div>
                                        <div class="tab" data-pane="#pane_4">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="{{ asset('frontend/assets/image/icon-index/heart-rate-monitor.png') }}"
                                                        alt="Xét nghiệm" />
                                                </div>
                                                <div class="tab__title">Xét nghiệm</div>
                                            </div>
                                        </div>
                                        <div class="tab" data-pane="#pane_5">
                                            <div class="tab__frame">
                                                <div class="tab__image">
                                                    <img src="{{ asset('frontend/assets/image/icon-index/building-hospital.png') }}"
                                                        alt="Kê đơn & thanh toán" />
                                                </div>
                                                <div class="tab__title">Kê đơn & thanh toán</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="process__pane pane__list">
                                        <div id="pane_1" class="pane active">
                                            <div class="row gap-y-20">
                                                <div class="col l-7 mc-12 c-12">
                                                    <div class="pane__content">
                                                        <div class="box-header">
                                                            <h3 class="pane__title">Đặt lịch khám</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                   Bệnh nhân có thể đặt lịch khám trực tiếp tại phòng khám hoặc thông qua hệ thống đặt lịch trực tuyến. Người bệnh được lựa chọn chuyên khoa, bác sĩ và thời gian khám phù hợp nhằm tiết kiệm thời gian chờ đợi và chủ động trong việc chăm sóc sức khỏe.

                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="{{ asset('frontend/assets/image/tham_kham.jpg') }}"
                                                            alt="Thăm khám" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pane_2" class="pane">
                                            <div class="row gap-y-20">
                                                <div class="col l-7 mc-12 c-12">
                                                    <div class="pane__content">
                                                        <div class="box-header">
                                                            <h3 class="pane__title">Tiếp nhận bệnh nhân</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                  Sau khi đến phòng khám, nhân viên tiếp nhận sẽ xác nhận thông tin cá nhân, kiểm tra lịch hẹn và hỗ trợ tạo hồ sơ khám bệnh. Quá trình tiếp nhận được thực hiện nhanh chóng nhằm đảm bảo thuận tiện cho bệnh nhân trong quá trình khám chữa bệnh.

                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="{{ asset('frontend/assets/image/cham_soc.jpg') }}"
                                                            alt="Xả cơ" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pane_3" class="pane">
                                            <div class="row gap-y-20">
                                                <div class="col l-7 mc-12 c-12">
                                                    <div class="pane__content">
                                                        <div class="box-header">
                                                            <h3 class="pane__title">Thăm khám bệnh nhân</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                   Bác sĩ sẽ tiến hành kiểm tra tình trạng sức khỏe, lắng nghe triệu chứng và trao đổi với bệnh nhân về tiền sử bệnh lý. Dựa trên kết quả thăm khám ban đầu, bác sĩ sẽ đưa ra chẩn đoán và tư vấn phương pháp điều trị phù hợp.

                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="{{ asset('frontend/assets/image/an_can.jpg') }}"
                                                            alt="Điều trị bằng máy" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pane_4" class="pane">
                                            <div class="row gap-y-20">
                                                <div class="col l-7 mc-12 c-12">
                                                    <div class="pane__content">
                                                        <div class="box-header">
                                                            <h3 class="pane__title">Xét nghiệm</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                    Trong trường hợp cần thiết, bác sĩ sẽ chỉ định thực hiện các xét nghiệm hoặc chẩn đoán hình ảnh để hỗ trợ đánh giá chính xác tình trạng sức khỏe của bệnh nhân. Kết quả xét nghiệm là cơ sở quan trọng giúp quá trình chẩn đoán và điều trị đạt hiệu quả cao hơn.

                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="{{ asset('frontend/assets/image/tien_loi.jpg') }}"
                                                            alt="Nắn chỉnh bằng tay" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pane_5" class="pane">
                                            <div class="row gap-y-20">
                                                <div class="col l-7 mc-12 c-12">
                                                    <div class="pane__content">
                                                        <div class="box-header">
                                                            <h3 class="pane__title">Kê đơn và thanh toán</h3>
                                                        </div>
                                                        <div class="content-detail">
                                                            <p>
                                                                    Sau khi hoàn tất quá trình khám bệnh, bác sĩ sẽ kê đơn thuốc hoặc đưa ra phác đồ điều trị phù hợp. Nhân viên sẽ hỗ trợ bệnh nhân thực hiện thanh toán, nhận hóa đơn và hướng dẫn các thông tin cần thiết trước khi kết thúc quá trình khám.

                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col l-5 mc-12 c-12">
                                                    <div class="pane__image">
                                                        <img src="{{ asset('frontend/assets/image/nhan_luc.jpg') }}"
                                                            alt="Hướng dẫn bài tập tại nhà" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

        <div class="section box box-doctor">
            <div class="box-doctor__bg bg">
                <img src="https://phongkhamtuean.com.vn/frontend/home/images/bg_doctor.png" alt="Background" />
            </div>
            <div class="container">
                <div class="box box-doctor__frame">
                    <div class="row gap-y-20">
                        <div class="col l-12 mc-12 c-12">
                            <h2 class="box-title highlight text-center">
                                ĐỘI NGŨ BÁC SĨ
                            </h2>
                            <div class="box-description">
                                Các bác sĩ trực tiếp thăm khám, điều trị cho khách hàng có
                                trình độ chuyên môn cao và nhiều năm kinh nghiệm.
                            </div>
                        </div>
                        <div class="col l-12 mc-12 c-12">
                            <div class="box-doctor__slider">
                                @foreach ($doctor as $item)
                                    <div class="item">
                                        <div class="item__frame">
                                            <div class="item__image">
                                                <img src="{{ asset('storage/uploads/avatars/' . $item->avatar) }}"
                                                    alt="Dũng" />
                                            </div>
                                            <div class="item__body">
                                                <div class="item__name title">
                                                    <a href="{{ route('client.ho-so', $item->user_id) }}"
                                                        class="text-dark text-decoration-none hover-text-white">
                                                        Bác sĩ {{ $item->lastname }} {{ $item->firstname }}
                                                    </a>
                                                </div>
                                                <div class="item__position">{{ $item->specialtyName }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(".box-doctor__slider").slick({
                slidesToShow: 4,
                slidesToScroll: 4,
                autoplay: true,
                infinite: true,
                arrows: true,
                responsive: [{
                        breakpoint: 1023,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        },
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        </script>

        <!-- <div class="section box box-contact ">
            <div class="box-contact__bg bg">
                <img src="https://phongkhamtuean.com.vn/frontend/home/images/bg_contact.png" alt="Background" />
            </div>
            <div class="container">
                <div class="box box-contact__frame">
                    <div class="row no-gutters gap-y-40">
                        <div class="col l-7 mc-12 c-12">
                            <div class="box-contact__image">
                                <img src="{{ asset('frontend/assets/image/benh-tai-mui-hong-o-tre(1).jpg') }}"
                                    alt="Hình minh hoạ" />
                            </div>
                        </div>
                        <div class="col l-5 mc-12 c-12">
                            <div class="box-contact__form">
                                <div class=" no-gutters gap-y-20">
                                    <div class="col l-12 mc-12 c-12">
                                        <div class="box-title text-center">
                                            NHẬN TƯ VẤN <span class="highlight">MIỄN PHÍ</span>
                                        </div>
                                    </div>
                                    <div class="col l-12 mc-12 c-12">
                                        <div class="form contact">
                                            <div id="loading">
                                                <img src="https://phongkhamtuean.com.vn/frontend/home/images/loading.gif"
                                                    alt="Background" />
                                            </div>
                                            <div class="form__notice">
                                                <div class="notice success">
                                                    Thông tin đã gửi thành công!
                                                </div>
                                                <div class="notice error">
                                                    Lỗi! Không gửi được thông tin!
                                                </div>
                                                <div class="notice warning">
                                                    Vui lòng nhập đúng định dạng!
                                                </div>
                                            </div>
                                            <div class="form__frame">
                                                <div class="form__group">
                                                    <input id="text" type="text" name="text"
                                                        placeholder="Vấn đề" />
                                                </div>
                                                <div class="form__group">
                                                    <input id="fullname" type="text" name="fullname"
                                                        placeholder="Họ tên" />
                                                </div>
                                                <div class="form__flex">
                                                    <div class="form__group">
                                                        <input id="phone" type="text" name="phone"
                                                            placeholder="Số điện thoại" />
                                                    </div>
                                                    <div class="form__group form__email">
                                                        <input id="email" type="text" name="email"
                                                            placeholder="Email (nếu có)" />
                                                    </div>
                                                </div>
                                                <div class="form__group form__content">
                                                    <textarea id="content" name="content" rows="3" placeholder="Chi tiết (nếu có)"></textarea>
                                                    <input id="webiste" type="text" name="website"
                                                        style="display: none" />
                                                </div>
                                                <div class="form__action">
                                                    <div class="button btn-send btn-flex">
                                                        <i class="fa-solid fa-paper-plane"></i> Gửi
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

    @endsection
