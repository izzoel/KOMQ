@extends('layouts.admin')

@section('title', 'Data Peserta - KOMQ Admin Panel')

@section('content')
    <div class="card admin-card">
        <div class="admin-card-header">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <i class="bi bi-people-fill text-primary fs-5 p-1" id="secretResetIcon"
                    style="user-select: none; -webkit-user-select: none; -webkit-touch-callout: none;"></i>
                <h5 class="mb-0 fw-bold text-dark">Data Nomor HP Peserta Terdaftar</h5>
                <span class="badge bg-primary rounded-pill px-3 py-1" id="totalParticipantsBadge">
                    {{ $totalParticipants }} Peserta
                </span>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="badge {{ $requirePhone ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3 py-2">
                    {{ $requirePhone ? 'Verifikasi HP: Aktif' : 'Verifikasi HP: Nonaktif' }}
                </span>
            </div>
        </div>

        <div class="admin-card-body">
            @if ($participants->isEmpty())
                <div class="text-center text-muted py-5" id="emptyParticipantsState">
                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                    <p class="mb-0 fw-semibold">Belum ada nomor HP peserta yang terdaftar di database.</p>
                </div>
            @else
                <div class="row mb-3">
                    <div class="col-md-5 ms-auto">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" id="searchPhone" class="form-control" placeholder="Cari nomor HP, soal, atau doorprize...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive" style="max-height: 550px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0" id="tableParticipants">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th style="width: 55px;" class="text-center">No</th>
                                <th style="width: 170px;">Nomor HP Peserta</th>
                                <th>Soal yang Dikerjakan</th>
                                <th style="width: 220px;">Jawaban Peserta</th>
                                <th style="width: 165px;">Doorprize</th>
                                <th style="width: 150px;">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($participants as $index => $p)
                                <tr id="row-participant-{{ $p->id }}" class="participant-row">
                                    <td class="text-center text-muted">{{ $index + 1 }}</td>

                                    <td class="searchable-cell">
                                        <span class="badge bg-light text-dark border fs-6 font-monospace px-2 py-1">
                                            {{ $p->phone_number }}
                                        </span>
                                    </td>

                                    <td class="searchable-cell">
                                        @if ($p->soal)
                                            @if ($p->kategori)
                                                <span class="badge bg-info bg-opacity-10 text-primary border border-info border-opacity-25 mb-1">
                                                    {{ $p->kategori }}
                                                </span>
                                            @endif
                                            <div class="small text-dark fw-medium" style="line-height: 1.4;">
                                                {{ $p->soal }}
                                            </div>
                                        @else
                                            <span class="text-muted small fst-italic">Belum mengerjakan soal</span>
                                        @endif
                                    </td>

                                    <td class="searchable-cell">
                                        @if ($p->jawaban_peserta)
                                            <div class="small text-dark mb-1">{{ $p->jawaban_peserta }}</div>
                                            @if ($p->status_jawaban === 'benar')
                                                <span class="badge bg-success rounded-pill px-2">
                                                    <i class="bi bi-check-circle me-1"></i>Benar
                                                </span>
                                            @elseif ($p->status_jawaban === 'salah')
                                                <span class="badge bg-danger rounded-pill px-2">
                                                    <i class="bi bi-x-circle me-1"></i>Salah
                                                </span>
                                            @elseif ($p->status_jawaban === 'waktu_habis')
                                                <span class="badge bg-warning text-dark rounded-pill px-2">
                                                    <i class="bi bi-clock me-1"></i>Waktu Habis
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>

                                    <td class="searchable-cell">
                                        @if ($p->doorprize)
                                            <span class="badge bg-warning text-dark border border-warning px-2 py-1 fw-bold">
                                                <i class="bi bi-gift-fill me-1"></i>{{ $p->doorprize }}
                                            </span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>

                                    <td class="text-muted small">
                                        {{ $p->created_at ? $p->created_at->translatedFormat('d M Y, H:i') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Pencarian real-time nomor HP, soal, atau doorprize
        $("#searchPhone").on("keyup", function() {
            const query = $(this).val().toLowerCase().trim();
            $(".participant-row").each(function() {
                const rowText = $(this).find(".searchable-cell").text().toLowerCase();
                $(this).toggle(rowText.includes(query));
            });
        });

        // Fitur Tersembunyi: Tahan klik/sentuh ikon bi-people-fill selama 3 detik untuk membuka popup Reset Semua Peserta
        const secretResetIcon = document.getElementById("secretResetIcon");
        const totalParticipants = {{ $totalParticipants }};
        let holdTimer = null;

        function openResetParticipantsModal() {
            if (totalParticipants <= 0) {
                Swal.fire({
                    icon: "info",
                    title: "Data Kosong",
                    text: "Belum ada data peserta yang dapat di-reset.",
                    timer: 1800,
                    showConfirmButton: false
                });
                return;
            }

            Swal.fire({
                title: "Reset Seluruh Data Peserta?",
                text: "Semua nomor HP peserta beserta log pengerjaannya akan dihapus. Pengunjung akan diizinkan mengikuti kuis kembali.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Reset Semua",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.participants.reset') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil",
                                text: res.message,
                                timer: 1800,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire("Gagal", "Terjadi kesalahan saat mereset data peserta.", "error");
                        }
                    });
                }
            });
        }

        if (secretResetIcon) {
            const startHold = (e) => {
                if (e.type === "mousedown" && e.button !== 0) return;
                clearTimeout(holdTimer);
                holdTimer = setTimeout(() => {
                    openResetParticipantsModal();
                }, 3000);
            };

            const cancelHold = () => {
                clearTimeout(holdTimer);
            };

            secretResetIcon.addEventListener("mousedown", startHold);
            secretResetIcon.addEventListener("touchstart", startHold, { passive: true });
            secretResetIcon.addEventListener("mouseup", cancelHold);
            secretResetIcon.addEventListener("mouseleave", cancelHold);
            secretResetIcon.addEventListener("touchend", cancelHold);
            secretResetIcon.addEventListener("touchcancel", cancelHold);
            secretResetIcon.addEventListener("contextmenu", (e) => e.preventDefault());
        }
    </script>
@endsection
