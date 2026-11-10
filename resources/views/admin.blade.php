@extends('layouts.admin')

@section('title', 'Manajemen Reward - KOMQ Admin Panel')

@section('content')
    <div class="card admin-card">
        <div class="admin-card-header">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <i class="bi bi-gift-fill text-primary fs-5"></i>
                <h5 class="mb-0 fw-bold text-dark">Daftar Hadiah Doorprize</h5>
                @if ($sudahReset && $tanggalReset)
                    <span class="badge bg-success rounded-pill px-3 py-1" title="Terakhir di-reset">
                        Reset Terakhir: {{ $tanggalReset }}
                    </span>
                @endif
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="btn btn-primary btn-sm fw-semibold px-3" data-bs-toggle="modal" data-bs-target="#rewardModal">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Reward
                </button>
                <button type="button" class="btn btn-warning btn-sm fw-semibold px-3" id="btnResetReward">
                    <i class="bi bi-arrow-clockwise me-1"></i> Reset Stok Harian ({{ now()->translatedFormat('d F Y') }})
                </button>
            </div>
        </div>

        <div class="admin-card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 90px;">Status</th>
                            <th class="text-start">Nama Hadiah</th>
                            <th style="width: 140px;">Stok Saat Ini</th>
                            <th style="width: 140px;">Stok Default</th>
                            <th style="width: 160px;">Kelola Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rewards as $reward)
                            <tr class="text-center">
                                <td>
                                    <div class="form-check form-switch d-flex justify-content-center m-0">
                                        <input class="form-check-input toggle-switch" type="checkbox" style="cursor: pointer;"
                                            {{ $reward->stock > 0 ? 'checked' : '' }} data-id="{{ $reward->id }}">
                                    </div>
                                </td>

                                <td class="text-start">
                                    <button type="button" class="btn btn-link p-0 text-decoration-none editRewardBtn"
                                        data-id="{{ $reward->id }}" data-bs-toggle="modal"
                                        data-bs-target="#editRewardModal" {{ $reward->is_aktive ? '' : 'disabled' }}>
                                        <strong>{{ $reward->name }}</strong>
                                        <i class="bi bi-pencil-square ms-1 small text-muted"></i>
                                    </button>
                                </td>

                                <td>
                                    @if ($reward->stock_temp > 0)
                                        <span class="badge bg-secondary rounded-pill px-3">Nonaktif</span>
                                    @elseif ($reward->stock == 0)
                                        <span class="badge bg-danger rounded-pill px-3">Habis</span>
                                    @else
                                        <span class="badge bg-success rounded-pill px-3 fs-6">{{ $reward->stock }}</span>
                                    @endif
                                </td>

                                <td class="text-muted fw-semibold">
                                    {{ $reward->default_stock ?? $reward->stock }}
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-outline-primary btn-sm btn-plus px-3 fw-bold"
                                            data-id="{{ $reward->id }}" {{ $reward->is_aktive ? '' : 'disabled' }}>
                                            <i class="bi bi-plus-lg"></i>
                                        </button>

                                        <button class="btn btn-outline-danger btn-sm btn-minus px-3 fw-bold"
                                            data-id="{{ $reward->id }}" {{ $reward->is_aktive ? '' : 'disabled' }}>
                                            <i class="bi bi-dash-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Modal Tambah Reward Baru -->
    <div class="modal fade" id="rewardModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Reward Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="rewardForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Reward</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Stok Awal</label>
                            <input type="number" class="form-control" name="stock" required min="1">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-semibold">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Reward -->
    <div class="modal fade" id="editRewardModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Reward</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editRewardForm">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Reward</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Stok Saat Ini</label>
                            <input type="number" class="form-control" id="edit_stock" name="stock" required min="0">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Stok Default Harian (Reset)</label>
                            <input type="number" class="form-control" id="edit_default_stock" name="default_stock" required min="0">
                            <small class="text-muted">Jumlah stok yang akan dipulihkan setiap kali tombol reset ditekan.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-semibold">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on("click", ".editRewardBtn", function() {
            const id = $(this).data("id");

            $.get(`/reward/${id}/edit`, function(data) {
                $("#edit_id").val(data.id);
                $("#edit_name").val(data.name);
                $("#edit_stock").val(data.stock);
                $("#edit_default_stock").val(data.default_stock !== undefined ? data.default_stock : data.stock);
            });
        });

        // Reset Stok Hadiah Harian
        $(document).on("click", "#btnResetReward", function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Reset Stok Hadiah?",
                text: "Seluruh stok hadiah aktif akan dikembalikan ke nilai stok harian default tanpa menghapus daftar hadiah.",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Reset Stok",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Mereset stok...",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('reward.set') }}",
                        type: "GET",
                        dataType: "json",
                        success: function(res) {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil",
                                text: res.message || "Stok hadiah harian berhasil di-reset.",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire("Gagal", "Terjadi kesalahan saat mereset stok hadiah.", "error");
                        }
                    });
                }
            });
        });

        $(document).on("change", ".toggle-switch", function() {
            let rewardId = $(this).data("id");
            let status = $(this).is(":checked") ? 1 : 0;

            $.ajax({
                url: "/reward/toggle",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: rewardId,
                    status: status
                },
                success: function() {
                    location.reload();
                },
                error: function() {
                    Swal.fire("Error", "Gagal mengubah status stok.", "error");
                }
            });
        });

        $(document).on("click", ".btn-plus", function() {
            let id = $(this).data("id");
            $.post("/reward/add/" + id, {
                _token: "{{ csrf_token() }}"
            }, function() {
                location.reload();
            });
        });

        $(document).on("click", ".btn-minus", function() {
            let id = $(this).data("id");
            $.post("/reward/minus/" + id, {
                _token: "{{ csrf_token() }}"
            }, function() {
                location.reload();
            });
        });

        $("#editRewardForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "/reward/edit",
                type: "POST",
                data: $(this).serialize(),
                success: function() {
                    $("#editRewardModal").modal("hide");
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Reward berhasil diperbarui.",
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                },
                error: function() {
                    Swal.fire("Gagal", "Tidak dapat memperbarui reward.", "error");
                }
            });
        });

        $("#rewardForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "/reward/store",
                type: "POST",
                data: $(this).serialize(),
                success: function() {
                    $("#rewardModal").modal("hide");
                    $("#rewardForm")[0].reset();
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Reward berhasil ditambahkan.",
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                },
                error: function() {
                    Swal.fire("Error", "Gagal menambahkan reward.", "error");
                }
            });
        });
    </script>
@endsection
