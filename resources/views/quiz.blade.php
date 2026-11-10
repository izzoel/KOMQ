<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KOMQ - Kuis {{ $kategori }} | Tapin Expo 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Bungee&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold: #ffd43b;
            --amber: #f59f00;
            --cyan: #38bdf8;
            --emerald: #10b981;
            --danger: #ef4444;
        }

        * {
            box-sizing: border-box;
            user-select: none;
        }

        body {
            background-color: #0284c7;
            background-image:
                radial-gradient(circle at 50% 35%, rgba(255, 255, 255, 0.22) 0%, rgba(14, 165, 233, 0.12) 55%, rgba(3, 105, 161, 0.30) 100%),
                url('{{ asset('images/quiz-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #1e293b;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Stage Lighting Glow Cerah */
        .stage-spotlight {
            position: fixed;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 850px;
            height: 850px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.35) 0%, rgba(254, 240, 138, 0.15) 40%, rgba(255, 255, 255, 0) 70%);
            pointer-events: none;
            z-index: 0;
            animation: pulseGlow 5s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            from { transform: translate(-50%, -50%) scale(0.95); opacity: 0.75; }
            to { transform: translate(-50%, -50%) scale(1.06); opacity: 1; }
        }

        /* Floating Navigation & Controls (Putih Bersih & Mudah Terbaca) */
        .btn-back {
            position: fixed;
            top: 20px;
            left: 25px;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid #ffffff;
            color: #0369a1;
            border-radius: 30px;
            padding: 8px 20px;
            font-size: 0.95rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            z-index: 100;
            box-shadow: 0 8px 20px rgba(3, 105, 161, 0.25);
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background: #fffbeb;
            border-color: #f59e0b;
            color: #b45309;
            transform: translateX(-2px);
        }

        .btn-sound-toggle {
            position: fixed;
            top: 20px;
            right: 25px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid #ffffff;
            color: #0284c7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            cursor: pointer;
            z-index: 100;
            box-shadow: 0 8px 20px rgba(3, 105, 161, 0.25);
            transition: all 0.2s ease;
            outline: none;
        }

        .btn-sound-toggle:hover {
            background: #fffbeb;
            border-color: #f59e0b;
            transform: scale(1.1);
            color: #d97706;
        }

        /* Header Brand Pill (Putih Bersih & Kontras Tinggi) */
        .top-header {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 18px;
        }

        .brand-pill {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(14px);
            border: 2px solid #ffffff;
            border-radius: 40px;
            padding: 8px 26px;
            display: inline-flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 12px 30px rgba(3, 105, 161, 0.25);
        }

        .header-title-gold {
            font-family: 'Bungee', cursive;
            background: linear-gradient(180deg, #0369a1 0%, #1d4ed8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.15rem;
            letter-spacing: 1px;
            margin: 0;
            line-height: 1.2;
        }

        .header-subtitle {
            font-size: 0.72rem;
            color: #475569;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            font-weight: 700;
        }

        /* Main Quiz Container */
        .quiz-arena {
            position: relative;
            z-index: 10;
            max-width: 960px;
            width: 100%;
            margin: 0 auto;
            padding: 20px 16px 40px 16px;
        }

        /* Kartu Pertanyaan Cerah & Ramah Mata (Putih Bersih Kontras Tinggi) */
        .question-pod {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(18px);
            border: 2px solid #ffffff;
            border-radius: 26px;
            box-shadow: 0 20px 45px rgba(3, 105, 161, 0.28), 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: cardEntrance 0.55s cubic-bezier(0.2, 0.9, 0.3, 1);
        }

        @keyframes cardEntrance {
            from { opacity: 0; transform: translateY(20px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Timer Header Section */
        .question-header {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 16px 26px;
        }

        .category-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #e0f2fe;
            border: 1.5px solid #bae6fd;
            color: #0369a1;
            padding: 6px 18px;
            border-radius: 30px;
            font-size: 0.92rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .timer-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fef3c7;
            border: 1.5px solid #fde68a;
            color: #b45309;
            padding: 6px 20px;
            border-radius: 30px;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: 0.4px;
            transition: all 0.25s ease;
        }

        .timer-badge.warning {
            background: #fee2e2;
            border-color: #f87171;
            color: #b91c1c;
            box-shadow: 0 0 14px rgba(239, 68, 68, 0.35);
            animation: urgentPulse 0.55s infinite alternate;
        }

        @keyframes urgentPulse {
            from { transform: scale(1); }
            to { transform: scale(1.06); }
        }

        /* Neon Timer Bar */
        .timer-bar-track {
            width: 100%;
            height: 9px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 12px;
        }

        .timer-bar-fill {
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #0284c7 0%, #f59e0b 100%);
            border-radius: 10px;
            transform-origin: left center;
            transition: background 0.3s ease;
        }

        .timer-bar-fill.warning {
            background: linear-gradient(90deg, #ef4444 0%, #f97316 100%);
        }

        /* Question Body */
        .question-body {
            padding: 36px 34px;
            text-align: center;
        }

        .question-text {
            font-size: clamp(1.35rem, 2.5vw, 2.05rem);
            font-weight: 700;
            line-height: 1.5;
            color: #0f172a;
            margin: 0;
        }

        /* Option Cards (Putih Bersih, Font Besar & Tegas) */
        .options-grid {
            margin-top: 22px;
        }

        .option-card {
            display: flex;
            align-items: center;
            gap: 16px;
            width: 100%;
            background: rgba(255, 255, 255, 0.97);
            border: 2px solid #ffffff;
            border-radius: 18px;
            padding: 15px 22px;
            color: #0f172a;
            text-align: left;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.2, 0.8, 0.2, 1);
            box-shadow: 0 10px 24px rgba(3, 105, 161, 0.22), 0 3px 8px rgba(0, 0, 0, 0.08);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .option-card:hover:not(.locked) {
            border-color: #f59e0b;
            background: #fffbeb;
            transform: translateY(-3px);
            box-shadow: 0 14px 28px rgba(245, 159, 0, 0.35);
        }

        .option-card:active:not(.locked) {
            transform: scale(0.98);
        }

        .option-letter {
            flex-shrink: 0;
            width: 50px;
            height: 50px;
            border-radius: 14px;
            background: #e0f2fe;
            border: 1.5px solid #bae6fd;
            color: #0369a1;
            font-family: 'Bungee', cursive;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .option-card:hover:not(.locked) .option-letter {
            background: #f59e0b;
            color: #ffffff;
            border-color: #d97706;
        }

        .option-label {
            font-size: clamp(1.08rem, 1.55vw, 1.32rem);
            font-weight: 700;
            line-height: 1.4;
            flex-grow: 1;
            color: #0f172a;
        }

        .option-indicator {
            font-size: 1.45rem;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        /* State Jawaban Benar */
        .option-card.benar {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            border: 2px solid #ffffff !important;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.75), 0 12px 25px rgba(0, 0, 0, 0.2) !important;
            color: #ffffff !important;
            animation: winnerPulse 0.65s ease-in-out infinite alternate;
        }

        .option-card.benar .option-label {
            color: #ffffff !important;
        }

        .option-card.benar .option-letter {
            background: #ffffff !important;
            color: #059669 !important;
            border-color: #ffffff !important;
        }

        .option-card.benar .option-indicator {
            opacity: 1;
            color: #ffffff;
        }

        @keyframes winnerPulse {
            from { transform: scale(1); }
            to { transform: scale(1.02); }
        }

        /* State Jawaban Salah */
        .option-card.salah {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            border: 2px solid #ffffff !important;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.5) !important;
            color: #ffffff !important;
        }

        .option-card.salah .option-label {
            color: #ffffff !important;
        }

        .option-card.salah .option-letter {
            background: rgba(255, 255, 255, 0.25) !important;
            color: #ffffff !important;
            border-color: #ffffff !important;
        }

        .option-card.salah .option-indicator {
            opacity: 1;
            color: #ffffff;
        }

        .option-card.salah.shake {
            animation: shakeAnim 0.45s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shakeAnim {
            10%, 90% { transform: translateX(-3px); }
            20%, 80% { transform: translateX(5px); }
            30%, 50%, 70% { transform: translateX(-6px); }
            40%, 60% { transform: translateX(6px); }
        }

        .option-card.dimmed {
            opacity: 0.55;
            filter: grayscale(0.25);
        }

        .option-card.locked {
            pointer-events: none;
            cursor: default;
        }

        /* Bright SweetAlert2 Styling */
        .swal2-popup.cyber-swal {
            background: #ffffff !important;
            border: 2px solid #bae6fd !important;
            border-radius: 24px !important;
            box-shadow: 0 25px 50px rgba(3, 105, 161, 0.3) !important;
            color: #1e293b !important;
            font-family: 'Poppins', sans-serif !important;
            padding: 28px !important;
        }

        .cyber-swal .swal2-title {
            color: #0f172a !important;
            font-weight: 800 !important;
        }

        .cyber-swal .swal2-html-container {
            color: #475569 !important;
            font-size: 1.02rem !important;
        }

        /* Responsive Mobile Tweaks */
        @media (max-width: 768px) {
            .btn-back {
                top: 12px;
                left: 12px;
                padding: 6px 12px;
                font-size: 0.78rem;
            }
            .btn-sound-toggle {
                top: 12px;
                right: 12px;
                width: 40px;
                height: 40px;
                font-size: 1.05rem;
            }
            .brand-pill {
                padding: 6px 14px;
                gap: 8px;
                margin-top: 42px;
            }
            .brand-pill img {
                height: 28px !important;
            }
            .header-title-gold {
                font-size: 0.9rem;
            }
            .question-header {
                padding: 12px 16px;
            }
            .question-body {
                padding: 22px 18px;
            }
            .option-card {
                padding: 12px 14px;
                gap: 12px;
            }
            .option-letter {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>

    <!-- Ambient Stage Spotlight -->
    <div class="stage-spotlight"></div>

    <!-- Tombol Kembali -->
    <a href="/" class="btn-back" title="Kembali ke Beranda">
        <i class="bi bi-arrow-left-circle-fill"></i>
        <span>Kembali</span>
    </a>

    <!-- Sound Control Toggle Button -->
    <button type="button" class="btn-sound-toggle" id="btnSound" title="Aktif/Nonaktifkan Suara Kuis">
        <i class="bi bi-volume-up-fill" id="soundIcon"></i>
    </button>

    <!-- Main Layout -->
    <div class="d-flex flex-column justify-content-between min-vh-100">

        <!-- Header Brand Pill -->
        <div class="top-header">
            <div class="brand-pill">
                <img src="{{ asset('images/diskominfo.png') }}" alt="Diskominfo Tapin" style="height: 36px;">
                <div style="height: 26px; width: 1.5px; background: rgba(148, 163, 184, 0.45);"></div>
                <img src="{{ asset('images/Tapin 69.svg') }}" alt="HUT Tapin 69" style="height: 36px; max-width: 105px; object-fit: contain;">
                <div class="text-start">
                    <div class="header-subtitle">Dinas Kominfo Kab. Tapin</div>
                    <h1 class="header-title-gold">TAPIN EXPO 2026</h1>
                </div>
            </div>
        </div>

        <!-- Quiz Arena -->
        <div class="quiz-arena my-auto">

            <!-- Question Pod Card -->
            <div class="question-pod">
                <div class="question-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="category-chip">
                            <i class="bi bi-tags-fill"></i>
                            <span>{{ $quiz->kategori }}</span>
                        </div>

                        <div class="timer-badge" id="timerBadge">
                            <i class="bi bi-stopwatch-fill"></i>
                            <span id="countdown">20 detik</span>
                        </div>
                    </div>

                    <div class="timer-bar-track">
                        <div class="timer-bar-fill" id="timerBar"></div>
                    </div>
                </div>

                <div class="question-body">
                    <p class="question-text">{{ $quiz->soal }}</p>
                </div>
            </div>

            <!-- Options Grid -->
            <div class="options-grid">
                <div class="row g-3">
                    @foreach ($pilihan as $label => $isi)
                        <div class="col-12 col-lg-6">
                            <button type="button"
                                class="option-card btn-jawab"
                                data-kategori="{{ $kategori }}"
                                data-id="{{ $quiz->id }}"
                                data-jawab="{{ strtolower($label) }}">
                                <span class="option-letter">{{ $label }}</span>
                                <span class="option-label">{{ $isi }}</span>
                                <span class="option-indicator">
                                    <i class="bi bi-check-circle-fill"></i>
                                </span>
                            </button>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-3 text-white fw-semibold" style="font-size: 0.9rem; letter-spacing: 0.3px; text-shadow: 0 1px 4px rgba(0,0,0,0.4);">
                    <i class="bi bi-lightbulb-fill text-warning me-1"></i>
                    Pilih jawaban paling tepat sebelum waktu habis untuk memenangkan doorprize!
                </div>
            </div>

        </div>

        <div class="pb-3"></div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>

    <script>
        // ========================================================
        // WEB AUDIO SYNTHESIZER (SOUND EFFECTS)
        // ========================================================
        let audioCtx = null;
        let soundEnabled = true;

        function getAudioContext() {
            if (!audioCtx) {
                const AudioContext = window.AudioContext || window.webkitAudioContext;
                audioCtx = new AudioContext();
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            return audioCtx;
        }

        function playTickSound(isUrgent = false) {
            if (!soundEnabled) return;
            try {
                const ctx = getAudioContext();
                const now = ctx.currentTime;
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();

                osc.type = isUrgent ? 'triangle' : 'sine';
                osc.frequency.setValueAtTime(isUrgent ? 880 : 620, now);
                osc.frequency.exponentialRampToValueAtTime(isUrgent ? 440 : 300, now + 0.04);

                gain.gain.setValueAtTime(isUrgent ? 0.09 : 0.04, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.045);

                osc.connect(gain);
                gain.connect(ctx.destination);

                osc.start(now);
                osc.stop(now + 0.05);
            } catch (e) {}
        }

        function playCorrectSound() {
            if (!soundEnabled) return;
            try {
                const ctx = getAudioContext();
                const now = ctx.currentTime;
                const notes = [523.25, 659.25, 783.99, 1046.50]; // C5 E5 G5 C6
                notes.forEach((freq, idx) => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'triangle';
                    osc.frequency.setValueAtTime(freq, now + idx * 0.08);
                    gain.gain.setValueAtTime(0, now + idx * 0.08);
                    gain.gain.linearRampToValueAtTime(0.24, now + idx * 0.08 + 0.02);
                    gain.gain.exponentialRampToValueAtTime(0.001, now + idx * 0.08 + 0.45);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start(now + idx * 0.08);
                    osc.stop(now + idx * 0.08 + 0.5);
                });
            } catch (e) {}
        }

        function playWrongSound() {
            if (!soundEnabled) return;
            try {
                const ctx = getAudioContext();
                const now = ctx.currentTime;
                const notes = [320, 240];
                notes.forEach((freq, idx) => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'sawtooth';
                    osc.frequency.setValueAtTime(freq, now + idx * 0.16);
                    osc.frequency.linearRampToValueAtTime(freq * 0.75, now + idx * 0.16 + 0.15);
                    gain.gain.setValueAtTime(0.18, now + idx * 0.16);
                    gain.gain.exponentialRampToValueAtTime(0.001, now + idx * 0.16 + 0.25);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start(now + idx * 0.16);
                    osc.stop(now + idx * 0.16 + 0.28);
                });
            } catch (e) {}
        }

        // Toggle Sound Button
        const soundBtn = document.getElementById('btnSound');
        const soundIcon = document.getElementById('soundIcon');
        soundBtn.addEventListener('click', () => {
            getAudioContext();
            soundEnabled = !soundEnabled;
            if (soundEnabled) {
                soundIcon.className = 'bi bi-volume-up-fill';
                soundBtn.style.color = '#0284c7';
                playTickSound(false);
            } else {
                soundIcon.className = 'bi bi-volume-mute-fill';
                soundBtn.style.color = '#94a3b8';
            }
        });

        // ========================================================
        // LOGIKA TIMER & PENILAIAN JAWABAN KUIS
        // ========================================================
        const duration = 20;
        let timeLeft = duration;
        let lastWholeSecond = duration;
        let timerStopped = false;
        let isAnswered = false;
        let timerInterval = null;

        const countdownEl = document.getElementById('countdown');
        const timerBadgeEl = document.getElementById('timerBadge');
        const timerBarEl = document.getElementById('timerBar');

        const currentKategori = @json($kategori);
        const currentId = @json($quiz->id);

        function startTimer() {
            const startTime = performance.now();

            function tick(now) {
                if (timerStopped) return;

                const elapsed = (now - startTime) / 1000;
                timeLeft = Math.max(0, duration - elapsed);

                const ceilSec = Math.ceil(timeLeft);
                countdownEl.textContent = ceilSec + " detik";

                // Update bar scale smoothly
                const ratio = timeLeft / duration;
                timerBarEl.style.transform = `scaleX(${ratio})`;

                // Peringatan 5 detik terakhir
                if (ceilSec <= 5 && ceilSec > 0) {
                    timerBadgeEl.classList.add('warning');
                    timerBarEl.classList.add('warning');
                }

                // Bunyi detak setiap pergantian detik
                if (ceilSec < lastWholeSecond && ceilSec > 0) {
                    lastWholeSecond = ceilSec;
                    playTickSound(ceilSec <= 5);
                }

                if (timeLeft <= 0) {
                    stopTimer();
                    handleTimeUp();
                } else {
                    requestAnimationFrame(tick);
                }
            }

            requestAnimationFrame(tick);
        }

        function stopTimer() {
            timerStopped = true;
        }

        function lockAllOptions() {
            $('.btn-jawab').addClass('locked');
        }

        function handleTimeUp() {
            if (isAnswered) return;
            isAnswered = true;
            lockAllOptions();
            playWrongSound();

            countdownEl.textContent = "Waktu Habis!";
            timerBarEl.style.transform = "scaleX(0)";

            // Ambil kunci jawaban dari server tanpa memberi poin
            $.ajax({
                method: "POST",
                url: `/quiz/${encodeURIComponent(currentKategori)}/${currentId}/e`,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    const kunci = res.kunci.toLowerCase();
                    $('.btn-jawab').each(function() {
                        const opsi = $(this).data('jawab');
                        if (opsi === kunci) {
                            $(this).addClass('benar');
                            $(this).find('.option-indicator i').attr('class', 'bi bi-check-circle-fill');
                        } else {
                            $(this).addClass('dimmed');
                        }
                    });
                },
                complete: function() {
                    setTimeout(() => {
                        Swal.fire({
                            customClass: {
                                popup: 'cyber-swal',
                                confirmButton: 'btn btn-warning px-4 py-2 fw-bold text-dark rounded-pill'
                            },
                            buttonsStyling: false,
                            title: "Waktu Habis!",
                            html: "Maaf, waktu menjawab telah berakhir.<br>Anda belum beruntung kali ini.",
                            icon: "warning",
                            confirmButtonText: "Kembali ke Beranda",
                            timer: 4500,
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            didClose: () => {
                                window.location.href = "/";
                            }
                        });
                    }, 900);
                }
            });
        }

        // Handle Klik Pilihan Jawaban
        $('.btn-jawab').on('click', function(e) {
            e.preventDefault();
            if (isAnswered) return;

            isAnswered = true;
            stopTimer();
            lockAllOptions();

            const clickedBtn = $(this);
            const kategori = clickedBtn.data('kategori');
            const id = clickedBtn.data('id');
            const jawab = clickedBtn.data('jawab');

            $.ajax({
                method: "POST",
                url: `/quiz/${encodeURIComponent(kategori)}/${id}/${jawab}`,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    const kunci = res.kunci.toLowerCase();
                    const allOptions = $('.btn-jawab');

                    if (res.status === "benar") {
                        playCorrectSound();

                        // Sorot jawaban benar, redupkan opsi lainnya
                        allOptions.each(function() {
                            const opsi = $(this).data('jawab');
                            if (opsi === kunci) {
                                $(this).addClass('benar');
                                $(this).find('.option-indicator i').attr('class', 'bi bi-check-circle-fill');
                            } else {
                                $(this).addClass('dimmed');
                            }
                        });

                        // Ledakan Confetti
                        try {
                            confetti({
                                particleCount: 100,
                                spread: 75,
                                origin: { y: 0.6 }
                            });
                        } catch (err) {}

                        setTimeout(() => {
                            Swal.fire({
                                customClass: {
                                    popup: 'cyber-swal',
                                    confirmButton: 'btn btn-warning px-4 py-2 fw-bold text-dark rounded-pill shadow'
                                },
                                buttonsStyling: false,
                                title: "Luar Biasa! Jawaban Benar!",
                                html: "Selamat! Anda berhak memutar undian doorprize.<br><span style='color: #0369a1; font-weight: 700;' class='small d-inline-block mt-1'>Mengarahkan ke panggung doorprize...</span>",
                                icon: "success",
                                confirmButtonText: '<i class="bi bi-gift-fill me-1"></i> Putar Doorprize Sekarang',
                                timer: 4000,
                                timerProgressBar: true,
                                allowOutsideClick: false,
                                didClose: () => {
                                    window.location.href = "/reward";
                                }
                            });
                        }, 800);

                    } else {
                        playWrongSound();

                        // Tandai jawaban user salah (merah + shake) dan tunjukkan jawaban benar (hijau)
                        allOptions.each(function() {
                            const opsi = $(this).data('jawab');
                            if (opsi === kunci) {
                                $(this).addClass('benar');
                                $(this).find('.option-indicator i').attr('class', 'bi bi-check-circle-fill');
                            } else if (opsi === jawab) {
                                $(this).addClass('salah shake');
                                $(this).find('.option-indicator i').attr('class', 'bi bi-x-circle-fill');
                            } else {
                                $(this).addClass('dimmed');
                            }
                        });

                        setTimeout(() => {
                            Swal.fire({
                                customClass: {
                                    popup: 'cyber-swal',
                                    confirmButton: 'btn btn-secondary px-4 py-2 fw-bold rounded-pill'
                                },
                                buttonsStyling: false,
                                title: "Jawaban Kurang Tepat!",
                                html: "Sayang sekali, jawaban Anda belum benar.<br>Terima kasih telah berpartisipasi di Tapin Expo 2026!",
                                icon: "error",
                                confirmButtonText: "Kembali ke Beranda",
                                timer: 4500,
                                timerProgressBar: true,
                                allowOutsideClick: false,
                                didClose: () => {
                                    window.location.href = "/";
                                }
                            });
                        }, 1100);
                    }
                },
                error: function() {
                    isAnswered = false;
                    $('.btn-jawab').removeClass('locked');
                    Swal.fire({
                        customClass: { popup: 'cyber-swal' },
                        title: "Terjadi Kesalahan",
                        text: "Gagal memeriksa jawaban ke server. Silakan coba lagi.",
                        icon: "error"
                    });
                }
            });
        });

        // Shortcut Keyboard A, B, C, D untuk memudahkan operator stand
        document.addEventListener('keydown', function(e) {
            if (isAnswered) return;
            const key = e.key.toLowerCase();
            if (['a', 'b', 'c', 'd'].includes(key)) {
                const targetBtn = $(`.btn-jawab[data-jawab="${key}"]`);
                if (targetBtn.length) {
                    targetBtn.trigger('click');
                }
            }
        });

        // Mulai Timer Saat Halaman Selesai Dimuat
        startTimer();
    </script>

</body>

</html>
