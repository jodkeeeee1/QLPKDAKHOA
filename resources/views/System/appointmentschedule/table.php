<div class="table-responsive">

    <div class="mt-3">
        {!! $book->links() !!}
    </div>

    <table class="table table-bordered align-middle text-center">

        <thead class="table-light">

            <tr>

                <th>STT khám</th>

                <th>Họ tên</th>

                <th>SĐT</th>

                <th>Bác sĩ</th>

                <th>Ngày khám</th>

                <th>Giờ khám</th>

                <th>Ca khám</th>

                <th>Chuyên khoa</th>

                <th>Hình thức</th>

                <th>Trạng thái</th>

                <th width="180">Thao tác</th>

            </tr>

        </thead>

        <tbody>

            @forelse ($book as $item)

                <tr>

                    <!-- STT -->
                    <td>
                        <span class="fw-bold">
                            {{ $item->stt }}
                        </span>
                    </td>

                    <!-- HỌ TÊN -->
                    <td>
                        {{ $item->name }}
                    </td>

                    <!-- SĐT -->
                    <td>
                        {{ $item->phone }}
                    </td>

                    <!-- BÁC SĨ -->
                    <td>
                        {{ $item->lastname }}
                        {{ $item->firstname }}
                    </td>

                    <!-- NGÀY KHÁM -->
                    <td>
                        {{ \Carbon\Carbon::parse($item->day)->format('d/m/Y') }}
                    </td>

                    <!-- GIỜ KHÁM -->
                    <td>

                        {{ \Carbon\Carbon::parse($item->hour)->format('H:i') }}

                    </td>

                    <!-- CA KHÁM -->
                    <td>

                        {{ $item->shiftName ?? '---' }}

                    </td>

                    <!-- CHUYÊN KHOA -->
                    <td>

                        {{ $item->specialtyName ?? '---' }}

                    </td>

                    <!-- HÌNH THỨC -->
                    <td>

                        @if ($item->role == 1)

                            <span class="badge bg-info">
                                Online
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                Offline
                            </span>

                        @endif

                    </td>

                    <!-- TRẠNG THÁI -->
                    <td>

                        @if ($item->status == 0)

                            <span class="badge bg-danger">
                                Đã đặt
                            </span>

                        @elseif ($item->status == 1)

                            <span class="badge bg-success">
                                Xác nhận
                            </span>

                        @elseif ($item->status == 2)

                            <span class="badge bg-primary">
                                Đã khám
                            </span>

                        @elseif ($item->status == 3)

                            <span class="badge bg-dark">
                                Hoàn tất
                            </span>

                        @else

                            <span class="badge bg-warning text-dark">
                                Đã hủy
                            </span>

                        @endif

                    </td>

                    <!-- THAO TÁC -->
                    <td>

                        <div class="d-flex justify-content-center gap-1">

                            <!-- XÁC NHẬN -->
                            <button
                                class="btn btn-primary btn-sm"
                                onclick="openModal('{{ $item->book_id }}')">

                                <i class="ti ti-edit"></i>

                            </button>

                            <!-- XÓA -->
                            <form
                                action="{{ route('system.deleteAppointmentSchedule', $item->book_id) }}"
                                method="POST"
                                id="form-delete{{ $item->book_id }}">

                                @csrf
                                @method('DELETE')

                            </form>

                            <button
                                type="button"
                                class="btn btn-danger btn-sm btn-delete"
                                data-id="{{ $item->book_id }}">

                                <i class="ti ti-trash"></i>

                            </button>

                            <!-- CHI TIẾT -->
                            <button
                                class="btn btn-warning btn-sm"
                                data-bs-toggle="collapse"
                                data-bs-target="#detail{{ $item->book_id }}">

                                Chi tiết

                            </button>

                        </div>

                    </td>

                </tr>

                <!-- CHI TIẾT -->
                <tr class="collapse bg-light" id="detail{{ $item->book_id }}">

                    <td colspan="11">

                        <div class="p-3 text-start">

                            <div class="row">

                                <!-- ẢNH -->
                                <div class="col-md-3 text-center">

                                    <img
                                        src="{{ $item->avatar
                                            ? asset('storage/uploads/avatars/' . $item->avatar)
                                            : asset('backend/assets/images/profile/user-1.jpg') }}"
                                        class="rounded-circle border"
                                        width="120"
                                        height="120"
                                        style="object-fit: cover;">

                                </div>

                                <!-- THÔNG TIN -->
                                <div class="col-md-9">

                                    <div class="row">

                                        <div class="col-md-6 mb-2">

                                            <strong>Mã lịch:</strong>

                                            {{ $item->book_id }}

                                        </div>

                                        <div class="col-md-6 mb-2">

                                            <strong>Email:</strong>

                                            {{ $item->email ?? '---' }}

                                        </div>

                                        <div class="col-md-6 mb-2">

                                            <strong>Bác sĩ:</strong>

                                            {{ $item->lastname }}
                                            {{ $item->firstname }}

                                        </div>

                                        <div class="col-md-6 mb-2">

                                            <strong>Chuyên khoa:</strong>

                                            {{ $item->specialtyName }}

                                        </div>

                                        <div class="col-md-6 mb-2">

                                            <strong>Ngày khám:</strong>

                                            {{ \Carbon\Carbon::parse($item->day)->format('d/m/Y') }}

                                        </div>

                                        <div class="col-md-6 mb-2">

                                            <strong>Giờ khám:</strong>

                                            {{ \Carbon\Carbon::parse($item->hour)->format('H:i') }}

                                        </div>

                                        <div class="col-md-6 mb-2">

                                            <strong>Ca khám:</strong>

                                            {{ $item->shiftName ?? '---' }}

                                        </div>

                                        <div class="col-md-6 mb-2">

                                            <strong>Hình thức:</strong>

                                            @if ($item->role == 1)

                                                Online

                                            @else

                                                Offline

                                            @endif

                                        </div>

                                        <div class="col-12 mt-2">

                                            <strong>Triệu chứng:</strong>

                                            <div class="border rounded p-2 mt-1 bg-white">

                                                {{ $item->symptoms ?? 'Không có triệu chứng' }}

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="11">

                        <div class="alert alert-warning mb-0">

                            Không có dữ liệu.

                        </div>

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    <div class="mt-3">
        {!! $book->links() !!}
    </div>

</div>