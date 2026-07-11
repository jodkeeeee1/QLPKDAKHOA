@extends('layouts.client.app')

@section('meta_title', '')

@section('content')

    <div class="main-body">
        <div class="contact__page">
            <div class="container">
                <div class="contact__page--frame">
                    <div class=" gap-y-40">
                        <div class="col l-12 mc-12 c-12">
                            <div class="box-heading text-center">
                                <h1>
                                    LIÊN HỆ NHẬN TƯ VẤN
                                    <span class="highlight">MIỄN PHÍ</span>
                                </h1>
                                <p class="description">Thường phản hồi sau 5 phút!</p>
                            </div>
                        </div>
                        <div class="col l-12 mc-12 c-12">
                            <div class="contact__form">
                                <div class="row gap-y-40">
                                    <div class="col l-6 mc-12 c-12">
                                        <div class="form contact">
                                            <div id="loading">
                                                <img
                                                    src=""
                                                    alt="Background"/>
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
                                                           placeholder="Vấn đề"/>
                                                </div>
                                                <div class="form__group">
                                                    <input id="fullname" type="text" name="fullname"
                                                           placeholder="Họ tên"/>
                                                </div>
                                                <div class="form__flex">
                                                    <div class="form__group">
                                                        <input id="phone" type="text" name="phone"
                                                               placeholder="Số điện thoại"/>
                                                    </div>
                                                    <div class="form__group form__email">
                                                        <input id="email" type="text" name="email"
                                                               placeholder="Email (nếu có)"/>
                                                    </div>
                                                </div>
                                                <div class="form__group form__content">
                                                <textarea id="content" name="content" rows="3"
                                                          placeholder="Chi tiết (nếu có)"></textarea>
                                                    <input id="webiste" type="text" name="website"
                                                           style="display: none"/>
                                                </div>
                                                <div class="form__action">
                                                    <div class="button btn-send btn-flex btn-left">
                                                        Gửi
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col l-6 mc-12 c-12">
                                        <div class="contact__main">
                                            <div class=" gap-y-20">
                                                <div class="col l-12 mc-12 c-12">
                                                    <h3 class="title">Thông tin địa chỉ cơ sở</h3>
                                                </div>
                                                <div class="col l-12 mc-12 c-12">
                                                    <div class="contact__map">
                                                  <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1860.6505634937453!2d105.8516796!3d21.1404113!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313501001f48ff45%3A0x431732da30293d1e!2zUGjDsm5nIEtow6FtIMSQYSBLaG9hIE5o4bqtdCBNaW5o!5e0!3m2!1svi!2s!4v1774181307274!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                    </div>
                                                </div>
                                                <div class="col l-12 mc-12 c-12">
                                                    <div class="contact__list" style="margin-top: 10px;">
                                                        <div class="item">
                                                            <div class="item__icon">
                                                                <i class="fa-solid fa-phone"></i>
                                                            </div>
                                                            <div class="item__wrap">
                                                                <span class="item__label">Hotline:</span>
                                                                <a href="tel:0978658099"
                                                                   class="item__link">{{ env('PHONE') }}</a>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <div class="item__icon">
                                                                <i class="fa-solid fa-envelope"></i>
                                                            </div>
                                                            <div class="item__wrap">
                                                                <span class="item__label">Email:</span>
                                                                <a href=""
                                                                   class="item__link"><span>{{ env('EMAIL') }}</span></a>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <div class="item__icon">
                                                                <i class="fa-solid fa-location-dot"></i>
                                                            </div>
                                                            <div class="item__wrap">
                                                                <span class="item__label">Địa chỉ:</span>
                                                                <a href="https://maps.app.goo.gl/kjpVxAW2goAAK95g7"
                                                                   class="item__link" target="_blank">{{ env('ADDRESS') }}</a>
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
            </div>
        </div>

    </div>

@endsection
