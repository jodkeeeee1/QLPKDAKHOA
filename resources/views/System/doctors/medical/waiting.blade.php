<div class="card w-100">
    <div class="card-body p-4">

        <div class="table-responsive">

            {{-- Pagination --}}
            <div class="mb-3">
                {!! $medicalWaiting->links() !!}
            </div>

            <table class="table table-bordered text-nowrap mb-0 align-middle mb-3">
                <thead class="text-dark fs-4">
                    <tr class="text-center">

                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Bệnh nhân</h6>
                        </th>

                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">SĐT Bệnh nhân</h6>
                        </th>

                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Chuẩn đoán</h6>
                        </th>

                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Ngày tạo</h6>
                        </th>

                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Trạng thái</h6>
                        </th>

                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Thao tác</h6>
                        </th>

                    </tr>
                </thead>

                <tbody id="myTable">
                    @foreach ($medicalWaiting as $item)
                        <tr class="text-center">

                            {{-- Bệnh nhân --}}
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">
                                    {{ $item->patientForeignKey->last_name . ' ' . $item->patientForeignKey->first_name }}
                                </p>
                            </td>

                            {{-- SĐT --}}
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">
                                    {{ $item->patientForeignKey->phone }}
                                </p>
                            </td>

                            {{-- Chuẩn đoán --}}
                            <td class="border-bottom-0">
                                @if (empty($item->diaginsis))
                                    <span class="text-muted">Chưa có chuẩn đoán</span>
                                @else
                                    {{ $item->diaginsis }}
                                @endif
                            </td>

                            {{-- Ngày tạo --}}
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('H:i d/m/Y') }}
                                </p>
                            </td>

                            {{-- Trạng thái --}}
                            <td class="border-bottom-0">
                                <span class="badge bg-secondary">
                                    Chờ khám
                                </span>
                            </td>

                            {{-- Thao tác --}}
                            <td class="border-bottom-0 d-flex justify-content-center">

                                <a href="{{ route('system.recordDoctors.record', $item->medical_id) }}"
                                   class="btn btn-warning btn-sm">
                                    Tiếp nhận khám
                                </a>

                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {!! $medicalWaiting->links() !!}
            </div>

        </div>

    </div>
</div>