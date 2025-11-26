<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KOMQ Admin Panel</title>
    <style>
        :root {
            --size: 520px;
        }

        body {
            background: #111;
            color: #fff;
            font-family: Arial;
            overflow: hidden;
        }

        .stage {
            width: var(--size);
            height: var(--size);
            position: relative;
        }

        .sphere {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .tag {
            --x: 0px;
            --y: 0px;
            --z: 0px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform-style: preserve-3d;
            transform: translate3d(var(--x), var(--y), var(--z)) translate(-50%, -50%);
            padding: 8px 14px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.907);
            backdrop-filter: blur(4px);
            color: #2d2d2d;
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
            user-select: none;
            transition: transform 250ms cubic-bezier(.2, .9, .2, 1), background 250ms, box-shadow 250ms;
            font-size: 18px;
            min-width: var(--tag-size);
            text-align: center;
            box-shadow: 0 6px 18px rgba(2, 6, 23, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.02);
        }

        .tag.selected {
            font-size: 1.6rem !important;
            font-weight: 700;
            color: #e6e3e3 !important;
            opacity: 1 !important;
            padding: 8px 14px;
            border-radius: 10px;
            background: rgb(218, 131, 0);
        }

        .tag.dim {
            opacity: 0.25 !important;
            transform: scale(.55) !important;
        }

        .result-badge {
            margin-top: 20px;
            font-size: 1.4rem;
        }

        .controls {
            margin-top: 20px;
        }

        .btn-3d {
            background: linear-gradient(to bottom, #ffd131 0%, #e3a600 70%);
            border: none;
            border-radius: 40px;
            padding: 18px 60px;
            font-size: 22px;
            font-weight: bold;
            color: #5a3e00;
            cursor: pointer;
            box-shadow: 0px 8px 0px #b78100, 0px 10px 18px rgba(0, 0, 0, 0.35);
            position: relative;
            outline: none;
        }

        .btn-3d::after {
            content: "";
            position: absolute;
            top: 6px;
            left: 12px;
            right: 12px;
            height: 38%;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.45);
        }

        .btn-3d:active {
            transform: translateY(4px);
            box-shadow: 0px 4px 0px #b78100, 0px 6px 12px rgba(0, 0, 0, 0.35);
        }


        @keyframes floatY {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-4px);
            }

            100% {
                transform: translateY(0);
            }
        }

        @keyframes rotateCircle {
            from {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        @keyframes rotateCircleCC {
            from {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            to {
                transform: translate(-50%, -50%) rotate(-360deg);
            }
        }

        #spinBtn {
            /* animation: floatY 1.2s ease-in-out infinite; */
            will-change: transform;
            transition: box-shadow .1s, transform .1s;
        }

        #spinBtn:hover {
            animation-play-state: paused;
            transform: translateY(-1px);
            filter: brightness(0.9);
            transition: box-shadow .1s, transform .1s, filter .12s;
        }

        .running-bg {
            position: absolute;
            left: 0;
            width: 200%;
            height: 100%;
            pointer-events: none;
            white-space: nowrap;
            opacity: 0.08;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
        }

        .running-bg.row1 {
            top: 28%;
            font-size: 40px;
            animation: runNames1 32s linear infinite;
        }

        .running-bg.row2 {
            top: 33%;
            font-size: 40px;
            animation: runNames2 36s linear infinite;
        }

        @keyframes runNames1 {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        @keyframes runNames2 {
            from {
                transform: translateX(-50%);
            }

            to {
                transform: translateX(0);
            }
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body
    style="background-image: url('{{ asset('images/quiz-bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 100vh; position: relative;">

    <div class="d-flex justify-content-center align-items-center flex-column mt-5">
        <div class="card" style="width: 80%">
            <div class="card-header">
                Admin Panel | {{ now()->translatedFormat('d F Y H:i') }} |
            </div>
            <div class="card-body">
                <h5 class="card-title">Reward List
                    <span>
                        <a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#rewardModal">
                            +
                        </a>
                    </span>
                </h5>
                <table class="table table-hover m-3">
                    <thead class="text-center">
                        <th>#</th>
                        <th class="text-start">Nama</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </thead>
                    @foreach ($rewards as $reward)
                        <tr class="text-center">
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-switch" type="checkbox" {{ $reward->stock > 0 ? 'checked' : '' }} data-id="{{ $reward->id }}">
                                </div>
                            </td>

                            <td class="text-start">
                                <button type="button" class="btn btn-link editRewardBtn" data-id="{{ $reward->id }}" data-bs-toggle="modal" data-bs-target="#editRewardModal"
                                    {{ $reward->is_aktive > 0 ? '' : 'disabled' }}>
                                    {{ $reward->name }}
                                </button>
                            </td>

                            <td>
                                @if ($reward->stock_temp > 0)
                                    <span class="badge bg-secondary">off</span>
                                @elseif ($reward->stock == 0)
                                    <span class="badge bg-danger">habis</span>
                                @else
                                    <span class="badge bg-success">{{ $reward->stock }}</span>
                                @endif
                            </td>

                            <td>
                                <button class="btn btn-primary btn-sm btn-plus" data-id="{{ $reward->id }}" {{ $reward->is_aktive ? '' : 'disabled' }}>
                                    +
                                </button>

                                <button class="btn btn-danger btn-sm btn-minus" data-id="{{ $reward->id }}" {{ $reward->is_aktive ? '' : 'disabled' }}>
                                    −
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rewardModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Reward Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="rewardForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Reward</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stock" required min="1">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editRewardModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Reward</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="editRewardForm">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">

                        <div class="mb-3">
                            <label class="form-label">Nama Reward</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" class="form-control" id="edit_stock" name="stock" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script>
        $(document).on("click", ".editRewardBtn", function() {
            const id = $(this).data("id");

            $.get(`/reward/${id}/edit`, function(data) {
                $("#edit_id").val(data.id);
                $("#edit_name").val(data.name);
                $("#edit_stock").val(data.stock);
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
                success: function(res) {
                    location.reload();
                },
                error: function() {
                    Swal.fire("Error", "Gagal mengubah status stok", "error");
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
    </script>

    <script>
        $("#editRewardForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "/reward/edit",
                type: "POST",
                data: $(this).serialize(),
                success: function() {
                    Swal.fire("Berhasil", "Reward berhasil diperbarui", "success");
                    $("#editRewardModal").modal("hide");
                    location.reload();
                },
                error: function() {
                    Swal.fire("Gagal", "Tidak dapat memperbarui reward", "error");
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
                    Swal.fire("Berhasil", "Reward berhasil ditambahkan", "success");
                    $("#rewardModal").modal("hide");
                    $("#rewardForm")[0].reset();
                    location.reload(); // refresh tabel reward
                },
                error: function() {
                    Swal.fire("Error", "Gagal menambahkan reward", "error");
                }
            });
        });
    </script>
</body>

</html>
