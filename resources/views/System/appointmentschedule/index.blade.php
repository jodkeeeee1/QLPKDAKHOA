@extends('layouts.admin.master')

@section('content')
<div class="card w-100">
    <div class="card-body p-4">
        <div class="col-md-4">
            <h5 class="card-title fw-semibold mb-4">Quản lý lịch khám</h5>
        </div>

        <!-- Tab Navigation -->
        <nav class="mb-3">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link {{ $activeTab == 'nav-home' ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"
                    data-tab="nav-home">Lịch khám
                </button>
                <!-- <button class="nav-link {{ $activeTab == 'nav-contact' ? 'active' : '' }}" id="nav-contact-tab"
                    data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                    aria-selected="false" data-tab="nav-contact">Khám Online
                </button> -->
                 <button class="nav-link {{ $activeTab == 'nav-statistic' ? 'active' : '' }}"
            id="nav-statistic-tab"
            data-bs-toggle="tab"
            data-bs-target="#nav-statistic"
            type="button"
            role="tab"
            aria-controls="nav-statistic"
            aria-selected="false"
            data-tab="nav-statistic">

            Thống kê
        </button>
            </div>
        </nav>

       <!-- Tab Content -->
<div class="tab-content" id="nav-tabContent">

    <!-- TAB OFFLINE -->
    <div class="tab-pane fade show {{ $activeTab == 'nav-home' ? 'show active' : '' }}"
        id="nav-home"
        role="tabpanel"
        aria-labelledby="nav-home-tab">

     <form id="searchFormOffline" method="GET" class="row gx-3 gy-3 align-items-center mb-3">

            <input type="hidden" name="tab" value="nav-home">

            <!-- Họ tên và SĐT -->
            <div class="col-lg-5 col-md-6">
                <div class="row g-2">

                    <div class="col-sm-12 col-md-6">
                        <input type="text"
                            class="form-control"
                            placeholder="Họ tên"
                            name="name"
                            value="{{ request('name') }}">
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <input type="text"
                            class="form-control"
                            placeholder="SĐT"
                            name="phone"
                            value="{{ request('phone') }}">
                    </div>

                </div>
            </div>

            <!-- Trạng thái và ngày -->
            <div class="col-lg-5 col-md-6">
                <div class="row g-2">

                    <div class="col-sm-12 col-md-4">
                        <select class="form-select" name="status">

                            <option value="">Trạng thái</option>

                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                Đã đặt
                            </option>

                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                Xác nhận
                            </option>

                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>
                                Đang xử lý
                            </option>

                            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>
                                Hoàn tất
                            </option>

                            <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>
                                Hủy
                            </option>

                        </select>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <input type="date"
                            class="form-control"
                            name="date_from"
                            value="{{ request('date_from') }}">
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <input type="date"
                            class="form-control"
                            name="date_to"
                            value="{{ request('date_to') }}">
                    </div>

                </div>
            </div>

            <!-- Nút tìm kiếm -->
            <div class="col-lg-2 col-md-12">
                <button type="submit" class="btn btn-primary w-100">
                    Tìm kiếm
                </button>
            </div>

        </form>
       

      <div id="offline-wrapper">
        @include('System.appointmentschedule.offline', ['book' => $booksOffline])
    </div>

    </div>



    <!-- TAB ONLINE -->
    <div class="tab-pane fade {{ $activeTab == 'nav-contact' ? 'show active' : '' }}"
        id="nav-contact"
        role="tabpanel"
        aria-labelledby="nav-contact-tab">

        <!-- FORM TÌM KIẾM -->
         <form id="searchFormOnline" method="GET" class="row gx-3 gy-3 align-items-center mb-3">

            <input type="hidden" name="tab" value="nav-contact">

            <!-- Họ tên và SĐT -->
            <div class="col-lg-5 col-md-6">
                <div class="row g-2">

                    <div class="col-sm-12 col-md-6">
                        <input type="text"
                            class="form-control"
                            placeholder="Họ tên"
                            name="name"
                            value="{{ request('name') }}">
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <input type="text"
                            class="form-control"
                            placeholder="SĐT"
                            name="phone"
                            value="{{ request('phone') }}">
                    </div>

                </div>
            </div>

            <!-- Trạng thái và ngày -->
            <div class="col-lg-5 col-md-6">
                <div class="row g-2">

                    <div class="col-sm-12 col-md-4">
                        <select class="form-select" name="status">

                            <option value="">Trạng thái</option>

                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                Đã đặt
                            </option>

                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                Xác nhận
                            </option>

                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>
                                Đang xử lý
                            </option>

                            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>
                                Hoàn tất
                            </option>

                            <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>
                                Hủy
                            </option>

                        </select>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <input type="date"
                            class="form-control"
                            name="date_from"
                            value="{{ request('date_from') }}">
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <input type="date"
                            class="form-control"
                            name="date_to"
                            value="{{ request('date_to') }}">
                    </div>

                </div>
            </div>

            <!-- Nút tìm kiếm -->
            <div class="col-lg-2 col-md-12">
                <button type="submit" class="btn btn-primary w-100">
                    Tìm kiếm
                </button>
            </div>

        </form>

        <div id="online-wrapper">
            @include('System.appointmentschedule.online', ['book' => $booksOnline])
        </div>

    </div>



   <!-- TAB THỐNG KÊ -->
<div class="tab-pane fade {{ $activeTab == 'nav-statistic' ? 'show active' : '' }}"
    id="nav-statistic"
    role="tabpanel"
    aria-labelledby="nav-statistic-tab">

    <div class="card mt-3">

        <div class="card-body">

            <h5 class="card-title mb-3">
                Thống kê số người đặt lịch theo tuần
            </h5>

            <!-- CHỌN NGÀY -->
            <form method="GET" class="mb-4">

                <input type="hidden" name="tab" value="nav-statistic">

                <div class="row align-items-center">

                    <div class="col-md-3">
                        <input type="date"
                            name="week_date"
                            class="form-control"
                            value="{{ request('week_date', now()->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">
                            Xem thống kê
                        </button>
                    </div>

                </div>

            </form>

            <!-- BIỂU ĐỒ -->
            <canvas id="patientChart"></canvas>

        </div>

    </div>

</div>

</div>
  <div class="modal fade" id="exampleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Xác nhận lịch khám</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">

                <p>Bạn muốn xác nhận hay hủy lịch khám này?</p>

                <div class="d-flex justify-content-center gap-3 mt-4">

                    <button type="button"
                        class="btn btn-success"
                        id="confirm-btn">
                        Xác nhận
                    </button>

                    <button type="button"
                        class="btn btn-danger"
                        id="cancel-btn">
                        Hủy lịch
                    </button>

                </div>

            </div>

        </div>
    </div>
</div>

    <script>
       function openModal(id) {

    $('#exampleModal').data('id', id);

    $('#exampleModal').modal('show');
}

       // XÁC NHẬN
$(document).on('click', '#confirm-btn', function (e) {

    e.preventDefault();

    let id = $('#exampleModal').data('id');

    $.ajax({

        url: '/admin/appointmentSchedules/update/' + id,
        type: 'PATCH',

        data: {
            status: 1,
            _token: '{{ csrf_token() }}'
        },

        success: function(response) {

            $('#exampleModal').modal('hide');

            toastr.success(response.message);

            setTimeout(function () {
                location.reload();
            }, 1000);
        },

        error: function(err) {
            console.log(err);
        }

    });

});


// HỦY
$(document).on('click', '#cancel-btn', function (e) {

    e.preventDefault();

    let id = $('#exampleModal').data('id');

    $.ajax({

        url: '/admin/appointmentSchedules/update/' + id,
        type: 'PATCH',

        data: {
            status: 4,
            _token: '{{ csrf_token() }}'
        },

        success: function(response) {

            $('#exampleModal').modal('hide');

            toastr.success(response.message);

            setTimeout(function () {
                location.reload();
            }, 1000);
        },

        error: function(err) {
            console.log(err);
        }

    });

});
    </script>

    <!-- AJAX Script -->
   <script>
$(document).on('submit', '#searchFormOffline', function (e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('system.appointmentSchedule') }}",
        type: "GET",
        data: $(this).serialize(),

        success: function (res) {
            $('#offline-wrapper').html(res.navHome);
        }
    });
});


$(document).on('submit', '#searchFormOnline', function (e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('system.appointmentSchedule') }}",
        type: "GET",
        data: $(this).serialize(),

        success: function (res) {
            $('#online-wrapper').html(res.navContact);
        }
    });
});
</script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.20.0/dist/axios.min.js"></script>
    <script src="https://cdn.stringee.com/sdk/web/2.2.1/stringee-web-sdk.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = @json($dates);

const totals = @json($totals);

const ctx = document.getElementById('patientChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: labels,

        datasets: [{

            label: 'Số người đặt lịch',

            data: totals,

            borderWidth: 1

        }]
    },

    options: {

        responsive: true,

      scales: {
    y: {
        beginAtZero: true,
        ticks: {
            stepSize: 1,
            callback: function(value) {
                return Number.isInteger(value) ? value : null;
            }
        }
    }
}

    }

});

</script>
    @endsection