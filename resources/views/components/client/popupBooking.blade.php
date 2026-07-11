<style>
.form__flex{
    display: flex;
    gap: 10px;
}

.form__flex .form__group{
    flex: 1;
}
.form__group{
    margin-bottom: 15px;
}

.form__group select,
.form__group input,
.form__group textarea{

    width: 100%;
    height: 45px;

    border: 1px solid #ddd;

    border-radius: 8px;

    padding: 0 15px;

    font-size: 15px;

    transition: all .3s ease;
}

.form__group textarea{

    height: 100px;

    padding-top: 12px;

    resize: none;
}

.form__group select:focus,
.form__group input:focus,
.form__group textarea:focus{

    border-color: #0d6efd;

    box-shadow: 0 0 5px rgba(13,110,253,.2);

    outline: none;
}

.text-danger{

    color: red;

    font-size: 13px;

    margin-top: 5px;

    display: block;
}
</style>
<div id="popupBooking" class="popup booking">
    <div class="popup__container">
        <div class="popup__frame">
            <div class="popup__image">
                <img src="{{ asset('frontend/assets/image/benh-tai-mui-hong-o-tre(1).jpg') }}" alt="Hình ảnh" />
            </div>
            <div class="popup__form">
                <div class="popup__close closePopup">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div class="popup__form--frame">
                    <div class="box-header">
                        <div class="box-title text-center highlight">Đặt lịch hẹn</div>
                    </div>
                    <div class="form booking">
                        <div id="loading">
                            <img src="https://phongkhamtuean.com.vn/frontend/home/images/loading.gif"
                                alt="Background" />
                        </div>
                        <div class="form__notice">
                            <div class="notice success">Thông tin đã gửi thành công!</div>
                            <div class="notice error">Lỗi! Không gửi được thông tin!</div>
                            <div class="notice warning">
                                Vui lòng nhập đúng định dạng!
                            </div>
                        </div>
                        <form action="{{ route('client.booking') }}" method="POST">
                            @csrf
                            <div class="form__frame">
                                <div class="form__flex">
                                    
                                </div>

                              @if (Auth::check())

    <div class="form__group">
        <input
            id="name"
            type="text"
            name="name"
            value="{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}"
            placeholder="Họ tên"
            readonly
        >

        @if ($errors->has('name'))
            <span class="text-danger">
                {{ $errors->first('name') }}
            </span>
        @endif
    </div>

    <div class="form__group">
        <input
            id="phone"
            type="text"
            name="phone"
            value="{{ auth()->user()->phone }}"
            placeholder="Số điện thoại"
            readonly
        >

        @if ($errors->has('phone'))
            <span class="text-danger">
                {{ $errors->first('phone') }}
            </span>
        @endif
    </div>

    <div class="form__group">
        <input
            id="email"
            type="text"
            name="email"
            value="{{ auth()->user()->email }}"
            placeholder="Email"
            readonly
        >

        @if ($errors->has('email'))
            <span class="text-danger">
                {{ $errors->first('email') }}
            </span>
        @endif
    </div>

@else
                                    <div class="form__group">
                                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                                            placeholder="Họ tên" />
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form__group">
                                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                                            placeholder="Số điện thoại" />
                                        @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>

                                    <div class="form__group">
                                        <input id="email" type="text" name="email"
                                            value="{{ old('email') }}" placeholder="Email (nếu có)" />
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>


                                @endif
                              <div class="form__group">

    <select style="width:100%" id="specialty" name="specialty_id">

        <option value="" disabled
            {{ old('specialty_id') == '' ? 'selected' : '' }}>
            --Chọn chuyên khoa--
        </option>

        @foreach ($specialties as $specialty)

            <option value="{{ $specialty->specialty_id }}"
                {{ old('specialty_id') == $specialty->specialty_id ? 'selected' : '' }}>

                {{ $specialty->name }}

            </option>

        @endforeach

    </select>

    @if ($errors->has('specialty_id'))

        <span class="text-danger">

            {{ $errors->first('specialty_id') }}

        </span>

    @endif

</div>

<!-- NGÀY KHÁM -->
<div class="form__group">

    <input
        type="date"
        id="day"
        name="day"
        min="{{ date('Y-m-d') }}"
        value="{{ old('day') }}"
    >

    @if ($errors->has('day'))

        <span class="text-danger">

            {{ $errors->first('day') }}

        </span>

    @endif

</div>

<!-- BÁC SĨ -->
<div class="form__group">

    <select style="width:100%" id="doctor" name="user_id">

        <option value="">
            --Chọn bác sĩ--
        </option>

    </select>

    @if ($errors->has('user_id'))

        <span class="text-danger">

            {{ $errors->first('user_id') }}

        </span>

    @endif

</div>

<!-- CA KHÁM -->
<div class="form__group">

    <select style="width:100%" id="schedule" name="schedule_id">

        <option value="">
            --Chọn ca khám--
        </option>

    </select>

    @if ($errors->has('schedule_id'))

        <span class="text-danger">

            {{ $errors->first('schedule_id') }}

        </span>

    @endif

</div>
</div>

                                <div class="form__group">
                                    <textarea id="symptoms" name="symptoms" value="" placeholder="Triệu chứng (nếu có)">{{ old('symptoms') }}</textarea>
                                    @if ($errors->has('symptoms'))
                                        <span class="text-danger">{{ $errors->first('symptoms') }}</span>
                                    @endif
                                </div>

                                <!-- Hiển thị reCAPTCHA -->
                                <div class="recaptcha-container">
                                    <div class="g-recaptcha" data-sitekey="{{ config('recaptcha.site_key') }}"></div>
                                    <!-- Hiển thị lỗi -->
                                </div>

                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                @endif


                                <div class="form__action">
                                    <button type="submit" class="button btn-booking btn-flex">
                                        <i class="fa-regular fa-calendar-check"></i> Đặt lịch
                                    </button>
                                    <div class="button btn-secondary btn-cancel btn-flex closePopup">Huỷ</div>
                                </div>
                            </div>
                        </form>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {

    // chọn chuyên khoa hoặc ngày
    $('#specialty, #day').change(function () {

        loadDoctors();

    });

    // chọn bác sĩ
    $('#doctor').change(function () {

        loadSchedules();

    });

    // load bác sĩ
    function loadDoctors()
    {
        let specialtyId = $('#specialty').val();

        let day = $('#day').val();

        $('#doctor').html(
            '<option value="">--Chọn bác sĩ--</option>'
        );

        $('#schedule').html(
            '<option value="">--Chọn ca khám--</option>'
        );

        if (!specialtyId || !day) {

            return;
        }

        $.ajax({

            url: '/get-doctors-by-specialty',

            type: 'GET',

            data: {
                specialty_id: specialtyId,
                day: day
            },

            success: function (data) {

                let html =
                    '<option value="">--Chọn bác sĩ--</option>';

                data.forEach(function (doctor) {

                    html += `
                        <option value="${doctor.user_id}">
                            ${doctor.firstname} ${doctor.lastname}
                        </option>
                    `;
                });

                $('#doctor').html(html);
            }
        });
    }

    // load ca khám
    function loadSchedules()
    {
        let doctorId = $('#doctor').val();

        let day = $('#day').val();

        if (!doctorId || !day) {

            return;
        }

        $.ajax({

            url: '/get-schedules-by-doctor',

            type: 'GET',

            data: {
                doctor_id: doctorId,
                day: day
            },

            success: function (data) {

                let html =
                    '<option value="">--Chọn ca khám--</option>';

                data.forEach(function (item) {

                    html += `
    <option value="${item.row_id}">
        ${item.shift_name}
        (${item.start_time.slice(0,5)} - ${item.end_time.slice(0,5)})
    </option>
`;
                });

                $('#schedule').html(html);
            }
        });
    }

});
</script>