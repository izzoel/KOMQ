@extends('layouts.admin')

@section('title', 'Manajemen Soal Kuis - KOMQ Admin Panel')

@section('content')
    <div class="card admin-card">
        <div class="admin-card-header">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <i class="bi bi-journal-text text-primary fs-5"></i>
                <h5 class="mb-0 fw-bold text-dark">Manajemen Soal Kuis</h5>
                <span class="badge bg-primary rounded-pill px-3 py-1">
                    {{ $quizzes->count() }} Soal
                </span>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <form method="GET" class="d-flex align-items-center gap-2">
                    <select name="kategori" class="form-select form-select-sm w-auto">
                        <option value="">-- Semua Kategori --</option>
                        @foreach ($kategoriList as $kt)
                            <option value="{{ $kt }}" {{ $kt == $kategori ? 'selected' : '' }}>{{ $kt }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-outline-primary btn-sm fw-semibold">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                </form>

                <button type="button" class="btn btn-success btn-sm fw-semibold px-3" data-bs-toggle="modal"
                    data-bs-target="#quizModal" id="addQuizBtn">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Soal
                </button>
            </div>
        </div>

        <div class="admin-card-body">
            @if ($quizzes->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-journal-x fs-1 d-block mb-2 text-secondary"></i>
                    <p class="mb-0 fw-semibold">Belum ada data soal kuis pada kategori ini.</p>
                </div>
            @else
                <div class="table-responsive" style="max-height: 550px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th style="width: 60px;" class="text-center">No</th>
                                <th style="width: 200px;">Kategori</th>
                                <th>Pertanyaan Soal</th>
                                <th style="width: 100px;" class="text-center">Jawaban</th>
                                <th style="width: 170px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quizzes as $quiz)
                                <tr data-id="{{ $quiz->id }}">
                                    <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-primary border border-info border-opacity-25 px-3 py-1">
                                            {{ $quiz->kategori }}
                                        </span>
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($quiz->soal, 70) }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success rounded-pill px-3">{{ strtoupper($quiz->jawaban) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary editQuizBtn me-1" data-id="{{ $quiz->id }}">
                                            <i class="bi bi-pencil me-1"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger deleteQuizBtn" data-id="{{ $quiz->id }}">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
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

@section('modals')
    <!-- Modal Tambah / Edit Soal -->
    <div class="modal fade" id="quizModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="quizForm">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah / Edit Soal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <input type="text" name="kategori" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Soal</label>
                            <textarea name="soal" rows="3" class="form-control" required></textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Pilihan A</label>
                                <input type="text" name="pilihanA" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Pilihan B</label>
                                <input type="text" name="pilihanB" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Pilihan C</label>
                                <input type="text" name="pilihanC" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Pilihan D</label>
                                <input type="text" name="pilihanD" class="form-control" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label fw-semibold">Jawaban Benar</label>
                            <select name="jawaban" class="form-select w-auto" required>
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-semibold px-4">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const csrf = $('meta[name="csrf-token"]').attr('content');

        // Buka modal Tambah
        $(document).on('click', '#addQuizBtn', () => {
            $('#quizForm')[0].reset();
            $('#quizForm input[name="id"]').val('');
            $('#quizModal .modal-title').text('Tambah Soal Baru');
        });

        // Edit Soal
        $(document).on('click', '.editQuizBtn', function() {
            const id = $(this).data('id');
            $.get(`/admin/quiz/${id}/edit`, { _token: csrf }, data => {
                $('#quizForm input[name="id"]').val(data.id);
                $('#quizForm input[name="kategori"]').val(data.kategori);
                $('#quizForm textarea[name="soal"]').val(data.soal);
                $('#quizForm input[name="pilihanA"]').val(data.pilihanA);
                $('#quizForm input[name="pilihanB"]').val(data.pilihanB);
                $('#quizForm input[name="pilihanC"]').val(data.pilihanC);
                $('#quizForm input[name="pilihanD"]').val(data.pilihanD);
                $('#quizForm select[name="jawaban"]').val(data.jawaban.toLowerCase());
                $('#quizModal .modal-title').text('Edit Soal Kuis');
                $('#quizModal').modal('show');
            });
        });

        // Simpan (store atau update)
        $('#quizForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#quizForm input[name="id"]').val();
            const url = id ? '/admin/quiz/update' : '/admin/quiz/store';

            $.ajax({
                url: url,
                type: 'POST',
                data: $(this).serialize() + `&_token=${csrf}`,
                success: function(res) {
                    $('#quizModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message || 'Data soal berhasil disimpan.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                },
                error: function(err) {
                    const msg = err.responseJSON?.message || 'Gagal menyimpan data soal.';
                    Swal.fire('Gagal', msg, 'error');
                }
            });
        });

        // Hapus Soal
        $(document).on('click', '.deleteQuizBtn', function() {
            const id = $(this).data('id');

            Swal.fire({
                title: 'Hapus Soal Kuis?',
                text: 'Soal yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/quiz/${id}`,
                        method: 'DELETE',
                        data: { _token: csrf },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus',
                                text: res.message || 'Soal berhasil dihapus.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        },
                        error: function() {
                            Swal.fire('Gagal', 'Tidak dapat menghapus soal.', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endsection
