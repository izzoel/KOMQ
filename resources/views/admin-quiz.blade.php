<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Soal Kuis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
          crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="p-4">

<h2 class="mb-4">Manajemen Soal Kuis</h2>

{{-- Filter kategori + tombol Tambah --}}
<form method="GET" class="mb-3">
    <select name="kategori" class="form-select w-auto d-inline">
        <option value="">-- Semua Kategori --</option>
        @foreach($kategoriList as $kt)
            <option value="{{ $kt }}" {{ $kt == $kategori ? 'selected' : '' }}>{{ $kt }}</option>
        @endforeach
    </select>
    <button class="btn btn-primary btn-sm">Filter</button>
    <button type="button" class="btn btn-success btn-sm ms-2"
            data-bs-toggle="modal" data-bs-target="#quizModal" id="addQuizBtn">
        Tambah Soal
    </button>
</form>

{{-- Tabel soal --}}
<table class="table table-hover">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Kategori</th>
            <th>Soal (ringkas)</th>
            <th>Jawaban</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($quizzes as $quiz)
            <tr data-id="{{ $quiz->id }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $quiz->kategori }}</td>
                <td>{{ \Illuminate\Support\Str::limit($quiz->soal, 50) }}</td>
                <td>{{ strtoupper($quiz->jawaban) }}</td>
                <td>
                    <button class="btn btn-sm btn-primary editQuizBtn" data-id="{{ $quiz->id }}">Edit</button>
                    <button class="btn btn-sm btn-danger deleteQuizBtn" data-id="{{ $quiz->id }}">Hapus</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- Modal Tambah / Edit Soal --}}
<div class="modal fade" id="quizModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="quizForm">
            @csrf
            <input type="hidden" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah / Edit Soal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><label>Kategori</label>
                        <input type="text" name="kategori" class="form-control" required></div>
                    <div class="mb-2"><label>Soal</label>
                        <textarea name="soal" rows="3" class="form-control" required></textarea></div>
                    <div class="row g-2">
                        <div class="col"><label>Pilihan A</label>
                            <input type="text" name="pilihanA" class="form-control" required></div>
                        <div class="col"><label>Pilihan B</label>
                            <input type="text" name="pilihanB" class="form-control" required></div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col"><label>Pilihan C</label>
                            <input type="text" name="pilihanC" class="form-control" required></div>
                        <div class="col"><label>Pilihan D</label>
                            <input type="text" name="pilihanD" class="form-control" required></div>
                    </div>
                    <div class="mt-3"><label>Jawaban benar (a/b/c/d)</label>
                        <input type="text" name="jawaban" maxlength="1" class="form-control w-25" required></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- JS (jQuery + Bootstrap) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
<script>
    const csrf = $('meta[name="csrf-token"]').attr('content');

    // Buka modal Tambah
    $('#addQuizBtn').on('click', () => {
        $('#quizForm')[0].reset();
        $('#quizForm input[name="id"]').val('');
        $('#quizModal .modal-title').text('Tambah Soal');
    });

    // Edit
    $('.editQuizBtn').on('click', function () {
        const id = $(this).data('id');
        $.get(`/admin/quiz/${id}/edit`, {_token: csrf}, data => {
            $('#quizForm input[name="id"]').val(data.id);
            $('#quizForm input[name="kategori"]').val(data.kategori);
            $('#quizForm textarea[name="soal"]').val(data.soal);
            $('#quizForm input[name="pilihanA"]').val(data.pilihanA);
            $('#quizForm input[name="pilihanB"]').val(data.pilihanB);
            $('#quizForm input[name="pilihanC"]').val(data.pilihanC);
            $('#quizForm input[name="pilihanD"]').val(data.pilihanD);
            $('#quizForm input[name="jawaban"]').val(data.jawaban);
            $('#quizModal .modal-title').text('Edit Soal');
            $('#quizModal').modal('show');
        });
    });

    // Simpan (store atau update)
    $('#quizForm').on('submit', function (e) {
        e.preventDefault();
        const id  = $('#quizForm input[name="id"]').val();
        const url = id ? '/admin/quiz/update' : '/admin/quiz/store';
        $.post(url, $(this).serialize() + `&_token=${csrf}`, () => location.reload());
    });

    // Hapus
    $('.deleteQuizBtn').on('click', function () {
        if (!confirm('Yakin menghapus soal ini?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: `/admin/quiz/${id}`,
            method: 'DELETE',
            data: {_token: csrf},
            success: () => location.reload()
        });
    });
</script>
</body>
</html>

