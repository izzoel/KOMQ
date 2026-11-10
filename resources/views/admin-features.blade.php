@extends('layouts.admin')

@section('title', 'Pengaturan Fitur - KOMQ Admin Panel')

@section('content')
    <div class="card admin-card">
        <div class="admin-card-header">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-sliders text-primary fs-5"></i>
                <h5 class="mb-0 fw-bold text-dark">Pengaturan Fitur Aplikasi</h5>
            </div>
            <div>
                <span id="phoneStatusBadge" class="badge {{ $requirePhone ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3 py-2">
                    {{ $requirePhone ? 'Verifikasi Nomor HP: AKTIF' : 'Verifikasi Nomor HP: NONAKTIF' }}
                </span>
            </div>
        </div>

        <div class="admin-card-body">
            <div class="card border rounded-3 bg-light bg-opacity-50">
                <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div style="max-width: 720px;">
                        <h6 class="mb-2 fw-bold text-dark fs-5">
                            <i class="bi bi-phone-vibrate text-primary me-2"></i>Verifikasi Peserta Kuis (Wajib Input Nomor HP)
                        </h6>
                        <p class="text-muted mb-2" style="line-height: 1.6;">
                            Mengatur apakah pengunjung diwajibkan memasukkan nomor HP/WhatsApp sebelum dapat memutar soal kuis di halaman utama.
                        </p>
                        <ul class="text-muted small mb-0 ps-3">
                            <li class="mb-1"><strong>Status Aktif:</strong> Pengunjung wajib menginputkan nomor HP yang valid sebelum memutar kuis. Nomor yang sudah pernah terdaftar di database tidak diperbolehkan memutar kembali.</li>
                            <li><strong>Status Nonaktif:</strong> Pengunjung dapat langsung memutar kuis secara bebas tanpa perlu memasukkan nomor HP.</li>
                        </ul>
                    </div>

                    <div class="d-flex flex-column align-items-center gap-2 px-3">
                        <div class="form-check form-switch fs-2 m-0">
                            <input class="form-check-input" type="checkbox" id="togglePhoneRequire" role="switch"
                                {{ $requirePhone ? 'checked' : '' }} style="cursor: pointer;">
                        </div>
                        <span class="small fw-semibold text-muted" id="toggleLabel">
                            {{ $requirePhone ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on("change", "#togglePhoneRequire", function() {
            const isChecked = $(this).is(":checked");
            const badge = $("#phoneStatusBadge");
            const label = $("#toggleLabel");

            $.ajax({
                url: "{{ route('admin.settings.toggle-phone') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.is_required) {
                        badge.removeClass("bg-secondary").addClass("bg-success").text("Verifikasi Nomor HP: AKTIF");
                        label.text("Aktif");
                    } else {
                        badge.removeClass("bg-success").addClass("bg-secondary").text("Verifikasi Nomor HP: NONAKTIF");
                        label.text("Nonaktif");
                    }
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                },
                error: function() {
                    $("#togglePhoneRequire").prop("checked", !isChecked);
                    Swal.fire("Gagal", "Tidak dapat memperbarui pengaturan fitur.", "error");
                }
            });
        });
    </script>
@endsection

