@extends('layouts.admin.master')
@section('Quản lí cận lâm sàng')
@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center m-1 mb-4">
                <a href="{{ route('system.borderline-result') }}" class="card-title">
                    <h3>Quản lý Cận lâm sàng</h3>
                </a>
            </div>
            <form action="{{ route('system.borderline-result') }}" method="GET" class="row mb-3 g-2 align-items-center">
                <!-- Tìm kiếm -->
                <div class="col-md-9 col-lg-10">
                    <div class="row g-2">                
                        <div class="col-md-3">
                            <input type="text" id="inputPriceFrom" class="form-control" placeholder="Mã bệnh án"
                                name="MedicalRecord" value="{{ request('MedicalRecord') }}">
                        </div>

                        <div class="col-md-3">
                            <input type="text" id="inputName" class="form-control" placeholder="Họ tên bệnh nhân"
                                name="name" value="{{ request('name') }}">
                        </div>

                        <div class="col-md-3">
                            <input type="text" id="inputPriceTo" class="form-control" placeholder="Khoa"
                                name="specialty" value="{{ request('specialty') }}">
                        </div>
                    
                        <div class="col-md-3">
                            <input type="text" id="inputCode" class="form-control" placeholder="Bác sĩ"
                                name="doctor" value="{{ request('doctor') }}">
                        </div>
                    </div>
                </div>

                <!-- Nút tìm kiếm và thêm sản phẩm -->
                <div class="col-md-3 col-lg-2">
                    <div class="row g-2">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
            </form>


            <div class="table-responsive ">
                <table class="table table-bordered text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr class="text-center">
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Mã bệnh án</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Tên bệnh nhân</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Khoa</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Bác sĩ</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Dịch vụ</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Thao tác</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="activeTable">
                        @if ($MedicalRecord->isEmpty())
                            <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                        @else
                            @foreach ($MedicalRecord as $data)

    {{-- Dòng hiển thị chính --}}
    <tr class="order-row text-center">

        <td class="border-bottom-0">
            <p class="fw-semibold mb-0">{{ $data->medical_id }}</p>
        </td>

        <td class="border-bottom-0">
            <p class="mb-0 fw-semibold">
                {{ $data->last_name }} {{ $data->first_name }}
            </p>
        </td>

        <td class="border-bottom-0">
            <p class="mb-0 fw-semibold">
                {{ $data->specialty_name }}
            </p>
        </td>

        <td class="border-bottom-0">
            <p class="mb-0 fw-semibold">
                {{ $data->user_firstname }} {{ $data->user_lastname }}
            </p>
        </td>

        <td class="border-bottom-0">
            <p class="mb-0 fw-semibold">
                {{ $data->service_name }}
            </p>
        </td>

        <td class="border-bottom-0 d-flex justify-content-center align-items-center">

            {{-- sửa --}}
            <a href="{{ route('system.borderline-result.details', [
                'treatment_id' => $data->treatment_id,
                'service_id' => $data->service_id
            ]) }}"
                class="btn btn-primary me-1">
                <i class="ti ti-pencil"></i>
            </a>

            {{-- chi tiết --}}
            <a class="btn btn-warning me-1"
                data-bs-toggle="collapse"
                href="#collapse{{ $data->treatment_id }}{{ $data->service_id }}"
                role="button">

                Chi tiết
            </a>

            {{-- xóa --}}
            <a data-id="{{ $data->medical_id }}" class="btn btn-danger me-1">
                <i class="ti ti-trash"></i>
            </a>

        </td>
    </tr>

    {{-- DÒNG CHI TIẾT --}}
    <tr>
        <td colspan="100" class="p-0">

            <div class="collapse"
                id="collapse{{ $data->treatment_id }}{{ $data->service_id }}">

                <div class="card card-body m-2">

                    <div class="row">

                        <div class="col-md-6">

                            <h6 class="fw-bold mb-3">
                                Thông tin cận lâm sàng
                            </h6>

                            <p>
                                <strong>Mã bệnh án:</strong>
                                {{ $data->medical_id }}
                            </p>

                            <p>
                                <strong>Bệnh nhân:</strong>
                                {{ $data->last_name }}
                                {{ $data->first_name }}
                            </p>

                            <p>
                                <strong>Bác sĩ:</strong>
                                {{ $data->user_firstname }}
                                {{ $data->user_lastname }}
                            </p>

                            <p>
                                <strong>Khoa:</strong>
                                {{ $data->specialty_name }}
                            </p>

                            <p>
                                <strong>Dịch vụ:</strong>
                                {{ $data->service_name }}
                            </p>

                        </div>

                        <div class="col-md-6">

                            <h6 class="fw-bold mb-3">
                                Nội dung
                            </h6>

                            <p>
                                <strong>Mô tả:</strong>
                            </p>

                            <div class="border rounded p-2 mb-3">
                                {!! $data->note ?? 'Chưa có mô tả' !!}
                            </div>

                            <p>
                                <strong>Kết quả:</strong>
                            </p>

                            <div class="border rounded p-2">
                                {!! $data->result ?? 'Chưa có kết quả' !!}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </td>
    </tr>

@endforeach
                        @endif
                    </tbody>
                </table>

                <div class="mt-3 d-flex justify-content-center">
                    {{ $MedicalRecord->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('click', function(e) {
                const deleteButton = e.target.closest('.btn-danger');

                // Bỏ qua nếu nút là nút "Xóa nhiều"
                if (deleteButton && !deleteButton.classList.contains('multiple-delete')) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn xóa?',
                        text: "Hành động này không thể hoàn tác!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const rowId = deleteButton.getAttribute('data-id');
                            const deleteUrl = '/system/borderline-result/delete/' + rowId;
                            window.location.href = deleteUrl;
                        }
                    });
                }
            });
        </script>
        
    @endpush
@endsection
