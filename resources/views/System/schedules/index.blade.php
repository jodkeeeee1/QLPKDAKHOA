@extends('layouts.admin.master')
@section('content')
    <style>
        .fc-event-title {
    display: none;
}
        .fc .fc-daygrid-day-frame {
    height: 120px !important;
    overflow: hidden !important;
    display: flex;
    flex-direction: column;
}

/* QUAN TRỌNG: đây mới là vùng chứa event */
.fc .fc-daygrid-day-events {
    flex: 1;
    overflow-y: auto !important;
    max-height: 90px;
    padding-right: 2px;
}

/* scrollbar đẹp hơn */
.fc .fc-daygrid-day-events::-webkit-scrollbar {
    width: 4px;
}

.fc .fc-daygrid-day-events::-webkit-scrollbar-thumb {
    background: #bbb;
    border-radius: 10px;
}
        #calendar {
            font-family: Arial, sans-serif;
        }

        /* Định dạng toolbar (thanh công cụ) */
        .fc-toolbar {
            background-color: #ffffff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .fc-left,
        .fc-center,
        .fc-right {
            font-size: 14px;
            color: #333;
        }

        /* Nút trên thanh công cụ */
        .fc-button {
            padding: 8px 16px;
            margin: 0 5px;
            background-color: #1a252f;
            /* Màu nền nút chính */
            color: white;
            /* Màu chữ trắng */
            border: none;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .fc-button:hover {
            background-color: #94e5be;
            /* Màu nền khi hover (xanh nhạt) */
        }

        .fc-button.fc-state-active {
            background-color: #048647;
            /* Màu active */
            color: white;
        }

        /* Định dạng tiêu đề tháng */
        .fc-center h2 {
            font-size: 20px;
            color: #333;
            font-weight: bold;
        }

        /* Các ngày trong tháng */
        .fc-day-header {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            color: #333;
        }

        /* Các ngày trong tuần */
        .fc-day-header span {
            font-size: 14px;
            color: #333;
        }

        /* Các ngày trong lịch */
       

        .fc-day:hover {
            background-color: #e8f9f1;
            /* Màu nền khi hover */
        }

        .fc-day.fc-other-month {
            background-color: #EEEEEE !important;
            color: #aaa !important;
        }

        .fc-day.fc-future {
            background-color: #ffffff;
        }

        .fc-day.fc-today {
            background-color: #048647;
            /* Màu nền cho ngày hôm nay */
            font-weight: bold;
            color: white;
            /* Màu chữ trắng cho ngày hôm nay */
        }

        /* Chỉnh sửa chiều cao của các hàng */
      
        .fc-content-skeleton table td {
            padding: 5px;
        }

        .fc-button-active {
            background-color: #048647 !important;
        }

        .fc-button-primary:disabled {
            background-color: #048647 !important;
        }

        .fc-view-container {
            overflow-x: auto;
            /* Cho phép cuộn ngang */
            -webkit-overflow-scrolling: touch;
            /* Cải thiện cuộn trên thiết bị di động */
        }

        /* Điều chỉnh khi màn hình nhỏ hơn */
        @media (max-width: 768px) {


            .fc-toolbar {
                flex-direction: column;
                text-align: center;
            }

            .fc-view-container {
                overflow-x: auto !important;
            }

            .fc-left,
            .fc-center,
            .fc-right {
                float: none;
                width: 100%;
            }

            .fc-button-group {
                display: flex;
                justify-content: center;
            }

            .fc-button {
                margin: 5px;
            }

            .fc-day-number {
                font-size: 12px;
            }
        }
        .fc-event {
    overflow: visible !important;
}


    </style>

  <div class="card w-100">
    <div class="card-body p-4">

        <h5 class="card-title fw-semibold mb-4">
            Quản lý lịch làm việc bác sĩ
        </h5>

        {{-- FILTER CHUYÊN KHOA --}}
        <div class="mb-4">
            <select id="specialty-filter" name="specialty_id" class="form-control">
                <option value="">Chọn chuyên khoa</option>
                @foreach ($specialties as $specialty)
                    <option value="{{ $specialty->specialty_id }}">
                        {{ $specialty->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- CALENDAR --}}
        <div class="table-responsive">
            <div id="calendar"></div>
        </div>

        {{-- ================= ADD MODAL ================= --}}
        <div class="modal fade" id="addEventModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Thêm lịch bác sĩ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Ngày khám</label>
                            <input type="date" class="form-control" id="daySelect">
                        </div>
                        {{-- BÁC SĨ --}}
                        <div class="mb-3">
                            <label>Bác sĩ</label>
                            <select class="form-control" id="username"></select>
                        </div>

                        {{-- CA LÀM VIỆC (SHIFT) --}}
                        <div class="mb-3">
                            <label>Ca làm việc</label>
                            <select class="form-control" id="shift_id">
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->shift_id }}">
                                        {{ $shift->name }} ({{ $shift->start_time }} - {{ $shift->end_time }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- GHI CHÚ --}}
                        <div class="mb-3">
                            <label>Ghi chú</label>
                            <textarea class="form-control" id="note"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button class="btn btn-primary" id="btn-save">Lưu</button>
                    </div>

                </div>
            </div>
        </div>

        {{-- ================= EDIT MODAL ================= --}}
        <div class="modal fade" id="editEventModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Sửa lịch bác sĩ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Ngày khám</label>
                            <input type="date" class="form-control" id="daySelectEdit">
                            <input type="hidden" id="schedule_id">
                        </div>

                        <div class="mb-3">
                            <label>Bác sĩ</label>
                            <select class="form-control" id="usernameEdit"></select>
                        </div>

                        {{-- SHIFT --}}
                        <div class="mb-3">
                            <label>Ca làm việc</label>
                            <select class="form-control" id="shift_id_edit">
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->shift_id }}">
                                        {{ $shift->name }} ({{ $shift->start_time }} - {{ $shift->end_time }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Ghi chú</label>
                            <textarea class="form-control" id="noteEdit"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button class="btn btn-primary" id="btn-edit">Lưu</button>
                           <button class="btn btn-danger me-auto" id="btn-delete">
        Xóa
    </button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

    <script>
let doctorColors = {};

function getDoctorColor(userId) {
    if (doctorColors[userId]) {
        return doctorColors[userId];
    }

    // danh sách màu
    const colors = [
        '#0d6efd', '#198754', '#dc3545',
        '#fd7e14', '#6f42c1', '#20c997',
        '#6610f2', '#0dcaf0'
    ];

    let index = Object.keys(doctorColors).length % colors.length;

    doctorColors[userId] = colors[index];

    return doctorColors[userId];
}
        let calendar;

/* =========================
   FORMAT DATE
========================= */
function formatDate(date) {
    let d = new Date(date);
    d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
    return d.toISOString().split('T')[0];
}

/* =========================
   LOAD DOCTORS
========================= */
function loadDoctor(specialty_id, selectedId = null) {
    if (!specialty_id) return;

    $.ajax({
        url: '/admin/schedules/doctor',
        type: 'GET',
        data: { specialty_id },
        success: function (res) {

            // ✅ clear cả 2 dropdown
            $('#username').empty();
            $('#usernameEdit').empty();

            res.users.forEach(u => {

                let option = `
                    <option value="${u.user_id}">
                        ${u.lastname} ${u.firstname}
                    </option>
                `;

                $('#username').append(option);
                $('#usernameEdit').append(option);
            });

            // chỉ set cho EDIT
            if (selectedId) {
                $('#usernameEdit').val(selectedId);
            }
        }
    });
}

/* =========================
   READY
========================= */
$(document).ready(function () {

    /* FILTER SPECIALTY */
    $('#specialty-filter').on('change', function () {
        let specialtyId = $(this).val();
        loadDoctor(specialtyId);
        calendar.refetchEvents();
    });

    /* =========================
       INIT CALENDAR
    ========================= */
    let calendarEl = document.getElementById('calendar');

    calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'vi',
        plugins: ['dayGrid', 'interaction'],

        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek'
        },

        buttonText: {
            today: 'Hôm nay',
            month: 'Tháng',
            week: 'Tuần',
            day: 'Ngày'
        },

        /* =========================
           EVENTS LOAD
        ========================= */
        events: function (fetchInfo, successCallback) {

            let specialtyId = $('#specialty-filter').val();

            if (!specialtyId) {
                successCallback([]);
                return;
            }

            $.ajax({
                url: '/admin/schedules/data',
                data: { specialty_id: specialtyId },
                success: function (res) {
                    successCallback(res);
                }
            });
        },

        /* =========================
           CLICK EVENT
        ========================= */
        eventClick: function (info) {
            let e = info.event;

            showEditPopup(
                e.id,
                formatDate(e.start),
                e.extendedProps.user_id,
                e.extendedProps.specialty_id,
                e.extendedProps.note,
                e.extendedProps.status,
                    e.extendedProps.shift_id
            );
        },

        /* =========================
           DRAG DROP
        ========================= */
        eventDrop: function (info) {

            $.ajax({
                url: '/admin/schedules/' + info.event.id,
                type: 'PATCH',
                data: {
                    day: formatDate(info.event.start),
                    note: info.event.extendedProps.note,
                    status: info.event.extendedProps.status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    calendar.refetchEvents();
                }
            });
        },

        /* =========================
           RENDER EVENT
        ========================= */
eventRender: function(info) {

    let userId = info.event.extendedProps.user_id;
    let color = getDoctorColor(userId);

    // tô màu background event
    info.el.style.backgroundColor = color;
    info.el.style.borderColor = color;
    info.el.style.color = '#fff';

    // giữ logic cũ của bạn
    function formatName(name) {
        if (!name) return '';

        let parts = name.trim().split(' ');
        if (parts.length <= 2) return name;

        let initials = parts
            .slice(0, 2)
            .map(p => p.charAt(0).toUpperCase())
            .join('.');

        let rest = parts.slice(2).join(' ');

        return initials + ' ' + rest;
    }

    let titleEl = info.el.querySelector('.fc-title');
    if (titleEl) {
        titleEl.innerText = formatName(info.event.title);
    }

    return info.el;
},
        /* =========================
           CLICK DATE (CREATE)
        ========================= */
        dateClick: function (info) {

            const selectedDate = new Date(info.dateStr);

const today = new Date();
today.setHours(0, 0, 0, 0);

if (selectedDate <= today) {
    alert('Không thể chọn ngày hiện tại hoặc quá khứ');
    return;
}

          let specialtyId = $('#specialty-filter').val();

if (!specialtyId) {
    alert('Vui lòng chọn chuyên khoa trước');
    return;
}

loadDoctor(specialtyId);

$('#addEventModal').modal('show');

$('#daySelect').val(info.dateStr);
        }
    });

    calendar.render();
});

/* =========================
   SHOW EDIT MODAL
========================= */
function showEditPopup(id, day, userId, specialtyId, note, status, shiftId) {

    $('#editEventModal').modal('show');

    $('#schedule_id').val(id);
    $('#daySelectEdit').val(day);
    $('#noteEdit').val(note);
    $('#shift_id_edit').val(shiftId);
    loadDoctor(specialtyId, userId); // ✅ truyền luôn userId

    $('#statusEdit').prop('checked', status == 1);
}

/* =========================
   CREATE
========================= */
$('#btn-save').on('click', function () {

    $.ajax({
        url: '/admin/schedules/create',
        type: 'POST',
        data: {
            day: $('#daySelect').val(),
            specialty_id: $('#specialty-filter').val(),
            user_id: $('#username').val(),
            shift_id: $('#shift_id').val(),
            note: $('#note').val(),
            status: $('#status').is(':checked') ? 1 : 0,
            _token: $('meta[name="csrf-token"]').attr('content')
        },

        success: function (res) {

            // ❌ có lỗi
            if (res.error) {
                alert(res.message);
                return;
            }

            // ✅ thành công
            $('#addEventModal').modal('hide');
            calendar.refetchEvents();

            alert(res.message);
        },

        error: function (err) {
            console.log(err.responseText);
            alert('Thêm thất bại!');
        }
    });
});
/* =========================
   UPDATE
========================= */
$('#btn-edit').on('click', function () {

    $.ajax({
        url: '/admin/schedules/' + $('#schedule_id').val(),
        type: 'PATCH',

        data: {
            day: $('#daySelectEdit').val(),

            user_id: $('#usernameEdit').val(),

            note: $('#noteEdit').val(),

            shift_id: $('#shift_id_edit').val(),

            _token: $('meta[name="csrf-token"]').attr('content')
        },

        success: function (res) {

            if (res.error) {
                alert(res.message);
                return;
            }

            $('#editEventModal').modal('hide');

            calendar.refetchEvents();

            alert(res.message);
        },

        error: function (err) {

            console.log(err.responseText);

            alert('Cập nhật thất bại');
        }
    });

});
$('#btn-delete').on('click', function () {

    let id = $('#schedule_id').val();

    if (!confirm('Xóa lịch này?')) return;

    $.ajax({
        url: '/admin/schedules/' + id,
        type: 'DELETE',

        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },

        success: function () {

            $('#editEventModal').modal('hide');

            calendar.refetchEvents();

            alert('Xóa thành công');
        },

        error: function () {

            alert('Xóa thất bại');
        }
    });

});

    </script>

@endsection
