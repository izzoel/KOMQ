<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quiz Doorprize Expo Tapin 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <style>
        .btn-kembali {
            background: linear-gradient(to bottom, #ffd131 0%, #e3a600 70%);
            border: none;
            border-radius: 24px;
            padding: 8px 22px;
            font-size: 16px;
            font-weight: bold;
            color: #5a3e00;
            cursor: pointer;
            box-shadow: 0px 5px 0px #b78100, 0px 6px 10px rgba(0, 0, 0, 0.35);
            position: absolute;
            /* posisi absolut */
            top: 20px;
            /* jarak dari atas */
            left: 20px;
            /* jarak dari kiri */
            outline: none;
            z-index: 9999;
            /* pastikan selalu di atas elemen lain */
        }

        .btn-kembali::after {
            content: "";
            position: absolute;
            top: 4px;
            left: 6px;
            right: 6px;
            height: 20%;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.45);
        }

        .btn-kembali:active {
            transform: translateY(3px);
            box-shadow: 0px 2px 0px #b78100, 0px 4px 7px rgba(0, 0, 0, 0.35);
        }


        .timer-bar-container {
            width: 100%;
            height: 6px;
            background: rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 6px;
            position: relative;
        }

        .timer-bar {
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #ff4d00, #cf5306);
            transform-origin: center;
            transition: transform 1s linear;
        }

        .countdown-warning {
            color: red;
            animation: blink 0.6s infinite;
        }

        .disabled-link {
            pointer-events: none;
            opacity: 0.8;
        }

        .quiz-option-right {
            border-radius: 0 1rem 1rem 0 !important;
        }

        .quiz-option-left {
            border-radius: 1rem 0 0 1rem !important;
        }

        .quiz-link {
            display: block;
            border-radius: 14px;
        }

        .quiz-link.disabled {
            pointer-events: none;
            opacity: .85;
        }

        .pilih {
            transition: transform 0.12s, filter 0.12s;
        }

        .pilih:active {
            filter: brightness(0.75);
            transform: scale(0.98);
            transition: filter 0.05s, transform 0.05s;
        }

        .pilih:hover .quiz-option-right {
            background-color: #ffc107;
            transform: translateY(-1px);
            filter: brightness(0.9);
            transition: box-shadow .1s, transform .1s, filter .12s;
        }

        .quiz-option-right.benar {
            /* background-color: #28a745 !important; */
            border-color: #198754;
            color: white !important;
            transform: none !important;
            filter: none !important;
            animation: blinkYellow 0.45s ease-in-out infinite;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: .25;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes blinkYellow {
            0% {
                background-color: #ffc107;
                color: black;
            }

            /* kuning */
            50% {
                background-color: #28a745;
                color: white;
            }

            /* hijau */
            100% {
                background-color: #ffc107;
                color: black;
            }

            /* kuning */
        }

        .quiz-option-right.salah {
            background-color: #dc3545 !important;
            /* merah bootstrap */
            border-color: #dc3545 !important;
            color: white !important;
            transform: none !important;
            filter: none !important;
        }

        /* Jika salah, hover tidak aktif */
        .quiz-option-right.salah:hover {
            background-color: #dc3545 !important;
            transform: none !important;
            filter: none !important;
        }

        .quiz-locked {
            pointer-events: none !important;
            cursor: default !important;
        }

        @keyframes rotateCircle {
            from {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        #spinBtn {
            will-change: transform;
            transition: box-shadow .1s, transform .1s;
        }

        #spinBtn:hover {
            animation-play-state: paused;
            transform: translateY(-1px);
            filter: brightness(0.9);
            transition: box-shadow .1s, transform .1s, filter .12s;
        }
    </style>

</head>

<body style="background-image: url('{{ asset('images/quiz-bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 100vh;">
    <div class="m-4 mb-0">
        <a href="/">
            <button id="spinBtn" class="btn-kembali m-3">Kembali</button>
        </a>
    </div>

    <div class="d-flex justify-content-center align-items-center flex-column" style="min-height: 100vh;">
        <div class="mb-5" style="width:18rem;">
            <a href="/">

                <img src="{{ asset('images/diskominfo.png') }}" class="card-img-top" alt="...">
            </a>
        </div>
        <div class="card shadow rounded-4" style="width: 75rem;">
            <div class="card-header text-center position-relative p-3">
                <div id="countdown" class="fw-bold fs-3">20</div>
                <div class="timer-bar-container">
                    <div class="timer-bar" id="timerBar"></div>
                </div>
            </div>

            <div class="card-body p-4">
                <blockquote class="blockquote mb-0">
                    <p class="fs-1">{{ $quiz->soal }}</p>
                    <footer class="blockquote-footer fs-5 mt-1">Kategori <span class="badge text-bg-secondary">{{ $quiz->kategori }}</span></footer>
                </blockquote>
            </div>
        </div>

        <div class="mt-3" style="width: 75rem;">
            <div class="row g-2">
                @foreach ($pilihan as $label => $isi)
                    <div class="col-6 pilih">
                        <a class="btn-jawab text-decoration-none w-100" data-kategori="{{ $kategori }}" data-id="{{ $quiz->id }}" data-jawab="{{ strtolower($label) }}">

                            <div class="input-group">
                                <div class="input-group-text fs-2 quiz-option-left">{{ $label }}</div>
                                <div class="btn btn-light btn-lg form-control text-start fs-3 quiz-option-right" data-jawab="{{ strtolower($label) }}">
                                    {{ $isi }}
                                </div>
                            </div>

                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let duration = 20;
        let timeLeft = duration;
        const countdown = document.getElementById("countdown");
        const timerBar = document.getElementById("timerBar");
        let interval = null;
        let timerStopped = false;

        // Simpan kategori dan id soal global
        let currentKategori = '{{ $kategori }}';
        let currentId = '{{ $quiz->id }}';

        // Start timer
        function startTimer() {
            interval = setInterval(() => {
                if (timerStopped) return;

                timeLeft -= 0.1; // update setiap 100ms untuk smooth
                if (timeLeft < 0) timeLeft = 0;

                countdown.textContent = "Sisa waktu: " + Math.ceil(timeLeft) + " detik";

                // update bar
                let scale = timeLeft / duration;
                timerBar.style.transform = `scaleX(${scale})`;

                // warning
                if (timeLeft <= 5) countdown.classList.add("countdown-warning");

                // waktu habis
                if (timeLeft <= 0 && !timerStopped) { // <-- cek flag
                    stopTimer(); // hentikan interval
                    setTimeout(() => {
                        waktuHabis(); // auto salah
                        Swal.fire({
                            title: "Waktu Habis!",
                            text: "Maaf anda belum beruntung",
                            icon: "warning",
                            timer: 5000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            allowOutsideClick: false, // tidak bisa klik luar untuk menutup
                            didClose: () => {
                                window.location.href = "/";
                            }
                        });

                    }, 2000);
                }
            }, 100);
        }

        // hentikan timer
        function stopTimer() {
            timerStopped = true;
            clearInterval(interval);
        }

        // panggil jika waktu habis
        function waktuHabis() {
            countdown.textContent = "0";
            timerBar.style.transform = "scaleX(0)";

            // Kita tidak tahu jawaban user, set jawaban kosong
            let dummyJawab = 'e';

            $.ajax({
                method: "POST",
                url: `/quiz/${currentKategori}/${currentId}/${dummyJawab}`,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    let allPilihan = $('.quiz-option-right');

                    // Reset style
                    allPilihan.removeClass("benar salah");

                    allPilihan.each(function() {
                        let label = $(this).data("jawab");

                        if (label === res.kunci.toLowerCase()) {
                            $(this).addClass("benar"); // jawaban benar
                        } else {
                            $(this).addClass("salah"); // jawaban salah
                        }
                    });

                    // Nonaktifkan hover
                    $('.pilih').off('mouseenter mouseleave');


                }
            });




        }


        // Mulai timer
        startTimer();
    </script>
    <script>
        $('.btn-jawab').on('click', function(e) {
            e.preventDefault();
            stopTimer();
            let kategori = $(this).data('kategori');
            let id = $(this).data('id');
            let jawab = $(this).data('jawab');

            $.ajax({
                method: "POST",
                url: `/quiz/${kategori}/${id}/${jawab}`,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    // Semua opsi quiz
                    let allPilihan = $('.quiz-option-right');

                    // Reset dulu semua style
                    allPilihan.removeClass("benar salah");
                    allPilihan.closest('a').addClass('disabled-link');

                    if (res.status === "benar") {
                        // Tandai jawaban benar
                        allPilihan.each(function() {
                            if ($(this).data("jawab") === res.kunci.toLowerCase()) {
                                $(this).addClass("benar");
                            } else {
                                $(this).addClass("salah");
                            }
                        });

                        // SweetAlert sekali
                        Swal.fire({
                            title: "Selamat!",
                            text: "Jawaban anda benar",
                            icon: "success",
                            timer: 5000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });

                    } else {
                        // Tandai jawaban salah
                        allPilihan.each(function() {
                            if ($(this).data("jawab") === res.kunci.toLowerCase()) {
                                $(this).addClass("benar"); // jawaban yang benar tetap ditandai
                            } else {
                                $(this).addClass("salah");
                            }
                        });

                        Swal.fire({
                            title: "Jawaban salah!",
                            text: "Maaf anda belum beruntung",
                            icon: "error",
                            timer: 5000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                    }

                    // Nonaktifkan hover semua pilihan
                    $('.pilih').off('mouseenter mouseleave');
                }

            });
        });
    </script>



</body>

</html>
