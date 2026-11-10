<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KOMQ - Pengundian Doorprize Tapin Expo 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Bungee&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --size: 540px;
            --gold-gradient: linear-gradient(to bottom, #ffd131 0%, #e3a600 70%);
        }

        * {
            box-sizing: border-box;
            user-select: none;
        }

        body {
            background-color: #0284c7;
            /* Latar biru langit cerah, ramah mata, nyaman dilihat orang dewasa & lansia */
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
            overflow: hidden;
            position: relative;
        }

        /* Ambient Stage Lighting Glow Cerah */
        .stage-spotlight {
            position: absolute;
            top: 52%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 740px;
            height: 740px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.42) 0%, rgba(253, 224, 71, 0.22) 42%, rgba(255, 255, 255, 0) 72%);
            pointer-events: none;
            z-index: 1;
            animation: pulseAura 4s ease-in-out infinite alternate;
        }

        @keyframes pulseAura {
            from {
                transform: translate(-50%, -50%) scale(0.92);
                opacity: 0.75;
            }

            to {
                transform: translate(-50%, -50%) scale(1.08);
                opacity: 1;
            }
        }

        /* =======================================================
           CINCIN ORBIT CERAH BERCAHAYA (BRIGHT ORBIT RINGS)
           ======================================================= */
        .hologram-rings-container {
            position: absolute;
            top: 52%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 760px;
            height: 760px;
            max-width: 95vmin;
            max-height: 95vmin;
            pointer-events: none;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            perspective: 1200px;
        }

        .holo-svg-ring {
            position: absolute;
            width: 100%;
            height: 100%;
            transform-origin: center center;
            will-change: transform, filter;
            pointer-events: none;
        }

        .ring-outer-hud {
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.55));
            opacity: 0.75;
        }

        .ring-middle-circuit {
            width: 82%;
            height: 82%;
            filter: drop-shadow(0 0 12px rgba(253, 224, 71, 0.55));
            opacity: 0.70;
        }

        .ring-inner-orbit {
            width: 66%;
            height: 66%;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.65));
            opacity: 0.80;
        }

        .ring-gyro-3d {
            position: absolute;
            width: 90%;
            height: 90%;
            border-radius: 50%;
            border: 2px dashed rgba(255, 255, 255, 0.55);
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.25);
            transform-origin: center center;
            will-change: transform;
        }

        .ring-gyro-3d-reverse {
            position: absolute;
            width: 86%;
            height: 86%;
            border-radius: 50%;
            border: 1.5px solid rgba(254, 240, 138, 0.55);
            box-shadow: 0 0 20px rgba(254, 240, 138, 0.25);
            transform-origin: center center;
            will-change: transform;
        }

        .energy-pulse-core {
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.35) 0%, rgba(254, 240, 138, 0.15) 50%, transparent 75%);
            animation: coreBreath 3s ease-in-out infinite alternate;
        }

        @keyframes coreBreath {
            0% {
                transform: scale(0.88);
                opacity: 0.6;
            }

            100% {
                transform: scale(1.12);
                opacity: 0.95;
            }
        }

        /* Top Brand Header Bar (Putih Bersih & Kontras Tinggi) */
        .top-header {
            position: relative;
            z-index: 20;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 15px;
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
            box-shadow: 0 12px 30px rgba(3, 105, 161, 0.28);
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

        /* Reward Banner Celebration Pill (Putih Hangat / Kuning Lembut Cerah) */
        .reward-banner-pill {
            margin-top: 10px;
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 2px solid #fde68a;
            border-radius: 30px;
            padding: 7px 24px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #92400e;
            font-weight: 800;
            font-size: 0.96rem;
            letter-spacing: 0.4px;
            box-shadow: 0 8px 20px rgba(3, 105, 161, 0.2);
        }

        .doorprize-badge {
            margin-top: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 18px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 0.82rem;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35);
        }

        .doorprize-badge.available {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.9) 0%, rgba(16, 185, 129, 0.9) 100%);
            border: 1px solid rgba(167, 243, 208, 0.5);
            color: #fff;
        }

        .doorprize-badge.empty {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.9) 0%, rgba(239, 68, 68, 0.9) 100%);
            border: 1px solid rgba(254, 202, 202, 0.5);
            color: #fff;
            animation: alertBlink 1.4s infinite ease-in-out;
        }

        @keyframes alertBlink {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.82;
                transform: scale(1.04);
            }
        }

        /* 3D Sphere Stage */
        .stage {
            width: var(--size);
            height: var(--size);
            position: relative;
            z-index: 15;
            margin: -10px auto 0 auto;
        }

        .sphere {
            width: 100%;
            height: 100%;
            position: relative;
        }

        /* Kartu Doorprize Cerah & Kontras Tinggi (Ramah Mata Orang Tua) */
        .tag {
            --x: 0px;
            --y: 0px;
            --z: 0px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform-style: preserve-3d;
            transform: translate3d(var(--x), var(--y), var(--z)) translate(-50%, -50%);
            padding: 12px 24px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border: 2px solid #ffffff;
            color: #0f172a;
            font-weight: 700;
            white-space: nowrap;
            cursor: pointer;
            user-select: none;
            transition: transform 250ms cubic-bezier(.2, .9, .2, 1), background 250ms, box-shadow 250ms, border 250ms;
            font-size: 18px;
            text-align: center;
            box-shadow: 0 10px 26px rgba(3, 105, 161, 0.25), 0 4px 10px rgba(0, 0, 0, 0.12);
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }

        .tag .tag-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: #fef3c7;
            border: 1px solid #fde68a;
            color: #d97706;
            font-size: 16px;
            transition: all 0.25s;
        }

        .tag .tag-text {
            letter-spacing: 0.3px;
        }

        .tag .tag-status-light {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 6px rgba(16, 185, 129, 0.6);
            margin-left: 2px;
        }

        .tag:hover {
            border-color: #f59e0b;
            background: #fffbeb;
            box-shadow: 0 12px 28px rgba(245, 159, 0, 0.35);
            transform: translate3d(var(--x), var(--y), var(--z)) translate(-50%, -50%) scale(1.08);
        }

        /* Tag Terpilih (Winner Doorprize) */
        .tag.selected {
            font-size: 2rem !important;
            font-weight: 800;
            color: #ffffff !important;
            opacity: 1 !important;
            padding: 16px 36px !important;
            border-radius: 20px !important;
            background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%) !important;
            border: 3px solid #ffffff !important;
            box-shadow: 0 0 45px rgba(251, 191, 36, 0.9), 0 18px 40px rgba(0, 0, 0, 0.35) !important;
            z-index: 99999 !important;
            animation: selectedPulse 1.2s infinite alternate ease-in-out;
        }

        @keyframes selectedPulse {
            from {
                filter: drop-shadow(0 0 18px rgba(251, 191, 36, 0.8));
            }

            to {
                filter: drop-shadow(0 0 36px rgba(255, 255, 255, 0.95));
            }
        }

        .tag.selected .tag-icon {
            width: 40px !important;
            height: 40px !important;
            font-size: 22px !important;
            background: rgba(255, 255, 255, 0.28) !important;
            border-color: #ffffff !important;
            color: #ffffff !important;
        }

        .tag.selected .tag-status-light {
            width: 10px !important;
            height: 10px !important;
            background: #ffffff !important;
            box-shadow: 0 0 10px #ffffff !important;
        }

        .tag.dim {
            opacity: 0.30 !important;
            transform: scale(.55) !important;
            filter: blur(1px);
        }

        /* Controls Button */
        .controls {
            position: relative;
            z-index: 20;
            margin-top: -25px;
            text-align: center;
        }

        .btn-3d {
            background: var(--gold-gradient);
            border: none;
            border-radius: 50px;
            padding: 16px 65px;
            font-size: 24px;
            font-weight: 800;
            color: #5a3e00;
            cursor: pointer;
            box-shadow: 0px 8px 0px #b78100, 0px 14px 25px rgba(245, 159, 0, 0.4);
            position: relative;
            outline: none;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            transition: box-shadow .12s, transform .12s, filter .12s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-3d::after {
            content: "";
            position: absolute;
            top: 5px;
            left: 14px;
            right: 14px;
            height: 38%;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.5);
        }

        .btn-3d:hover {
            transform: translateY(-2px);
            filter: brightness(1.05);
            box-shadow: 0px 10px 0px #b78100, 0px 18px 30px rgba(245, 159, 0, 0.55);
            color: #5a3e00;
        }

        .btn-3d:active {
            transform: translateY(4px);
            box-shadow: 0px 4px 0px #b78100, 0px 8px 14px rgba(0, 0, 0, 0.35);
        }

        .btn-3d:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Tombol Navigasi Kembali di Kiri Atas (Putih Cerah) */
        .btn-back {
            position: absolute;
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

        /* Sound Control Floating Button (Putih Cerah) */
        .btn-sound-toggle {
            position: absolute;
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
    </style>
</head>

<body>

    <!-- Tombol Kembali ke Beranda -->
    <a href="/" class="btn-back" title="Kembali ke Beranda">
        <i class="bi bi-arrow-left-circle-fill"></i>
        <span>Kembali</span>
    </a>

    <!-- Sound Control Toggle Button -->
    <button type="button" class="btn-sound-toggle" id="btnSound" title="Aktif/Nonaktifkan Suara Doorprize">
        <i class="bi bi-volume-up-fill" id="soundIcon"></i>
    </button>

    <!-- Stage Spotlight Glow -->
    <div class="stage-spotlight"></div>

    <!-- Bright Orbit Rings -->
    <div class="hologram-rings-container" id="hologramRings">
        <div class="energy-pulse-core"></div>

        <div class="ring-gyro-3d" id="ringGyro1"></div>
        <div class="ring-gyro-3d-reverse" id="ringGyro2"></div>

        <!-- Ring 1: Terluar -->
        <svg class="holo-svg-ring ring-outer-hud" id="ringOuter" viewBox="0 0 800 800" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <circle cx="400" cy="400" r="370" stroke="rgba(255, 255, 255, 0.40)" stroke-width="1.5"
                stroke-dasharray="8 6" />
            <circle cx="400" cy="400" r="355" stroke="rgba(254, 240, 138, 0.65)" stroke-width="2.5"
                stroke-dasharray="140 30 40 30" />
            <circle cx="400" cy="400" r="338" stroke="rgba(255, 255, 255, 0.30)" stroke-width="1" />

            <path d="M 400 30 A 370 370 0 0 1 661 138" stroke="#ffffff" stroke-width="5" stroke-linecap="round" />
            <path d="M 400 770 A 370 370 0 0 1 139 662" stroke="#fde047" stroke-width="5" stroke-linecap="round" />

            <circle cx="400" cy="30" r="6" fill="#ffffff" filter="drop-shadow(0 0 6px #ffffff)" />
            <circle cx="770" cy="400" r="6" fill="#ffffff" filter="drop-shadow(0 0 6px #ffffff)" />
            <circle cx="400" cy="770" r="6" fill="#ffffff" filter="drop-shadow(0 0 6px #ffffff)" />
            <circle cx="30" cy="400" r="6" fill="#ffffff" filter="drop-shadow(0 0 6px #ffffff)" />

            <g stroke="rgba(255, 255, 255, 0.45)" stroke-width="2">
                <line x1="400" y1="15" x2="400" y2="30" />
                <line x1="400" y1="770" x2="400" y2="785" />
                <line x1="15" y1="400" x2="30" y2="400" />
                <line x1="770" y1="400" x2="785" y2="400" />
                <line x1="138" y1="138" x2="150" y2="150" />
                <line x1="662" y1="138" x2="650" y2="150" />
                <line x1="138" y1="662" x2="150" y2="650" />
                <line x1="662" y1="662" x2="650" y2="650" />
            </g>
        </svg>

        <!-- Ring 2: Tengah -->
        <svg class="holo-svg-ring ring-middle-circuit" id="ringMiddle" viewBox="0 0 650 650" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <circle cx="325" cy="325" r="300" stroke="rgba(224, 242, 254, 0.45)" stroke-width="2"
                stroke-dasharray="16 12" />
            <circle cx="325" cy="325" r="285" stroke="rgba(255, 255, 255, 0.55)" stroke-width="3"
                stroke-dasharray="80 40 20 40" />
            <circle cx="325" cy="325" r="270" stroke="rgba(224, 242, 254, 0.30)" stroke-width="1.5" />

            <path d="M 112 112 A 300 300 0 0 1 538 112" stroke="#bae6fd" stroke-width="4.5" stroke-linecap="round" />
            <path d="M 538 538 A 300 300 0 0 1 112 538" stroke="#ffffff" stroke-width="4.5" stroke-linecap="round" />

            <circle cx="325" cy="25" r="5" fill="#ffffff" filter="drop-shadow(0 0 6px #ffffff)" />
            <circle cx="625" cy="325" r="5" fill="#ffffff" filter="drop-shadow(0 0 6px #ffffff)" />
            <circle cx="325" cy="625" r="5" fill="#ffffff" filter="drop-shadow(0 0 6px #ffffff)" />
            <circle cx="25" cy="325" r="5" fill="#ffffff" filter="drop-shadow(0 0 6px #ffffff)" />
        </svg>

        <!-- Ring 3: Dalam -->
        <svg class="holo-svg-ring ring-inner-orbit" id="ringInner" viewBox="0 0 500 500" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <circle cx="250" cy="250" r="230" stroke="rgba(254, 240, 138, 0.65)" stroke-width="2"
                stroke-dasharray="30 15 10 15" />
            <circle cx="250" cy="250" r="215" stroke="rgba(255, 255, 255, 0.45)" stroke-width="1.5"
                stroke-dasharray="6 6" />
            <polygon points="250,20 244,32 256,32" fill="#ffffff" />
            <polygon points="250,480 244,468 256,468" fill="#ffffff" />
            <polygon points="20,250 32,244 32,256" fill="#ffffff" />
            <polygon points="480,250 468,244 468,256" fill="#ffffff" />
        </svg>
    </div>

    <!-- Main Container -->
    <div class="d-flex justify-content-between align-items-center flex-column min-vh-100 py-3 position-relative">

        <!-- Top Header & Brand Bar -->
        <div class="top-header">
            <div class="brand-pill">
                <img src="{{ asset('images/diskominfo.png') }}" alt="Diskominfo Tapin" style="height: 38px;">
                <div style="height: 28px; width: 1.5px; background: rgba(148, 163, 184, 0.45);"></div>
                <img src="{{ asset('images/Tapin 69.svg') }}" alt="HUT Tapin 69"
                    style="height: 38px; max-width: 110px; object-fit: contain;">
                <div class="text-start">
                    <div class="header-subtitle">Dinas Kominfo Kab. Tapin</div>
                    <h1 class="header-title-gold">TAPIN EXPO 2026</h1>
                </div>
            </div>

            <!-- Celebration Banner -->
            <div class="reward-banner-pill">
                <i class="bi bi-trophy-fill" style="color: #d97706; font-size: 1.2rem;"></i>
                <span>SELAMAT! ANDA BERHAK MENDAPATKAN DOORPRIZE</span>
            </div>

            <!-- Sisa Stok Doorprize -->
            @if ($totalStok > 0)
                <div class="doorprize-badge available">
                    <i class="bi bi-gift-fill"></i>
                    <span>SISA DOORPRIZE: <strong>{{ $totalStok }}</strong></span>
                </div>
            @else
                <div class="doorprize-badge empty">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>MOHON MAAF, DOORPRIZE HARI INI SUDAH HABIS</span>
                </div>
            @endif
        </div>

        <!-- 3D Sphere Tag Stage -->
        <div class="stage">
            <div id="sphere" class="sphere"></div>
        </div>

        <!-- Controls -->
        <div class="controls mb-4">
            @if ($totalStok > 0)
                <button id="spinBtn" class="btn-3d">Putar Undian</button>
                <div class="text-white fw-semibold mt-2"
                    style="font-size: 0.9rem; letter-spacing: 0.4px; text-shadow: 0 1px 4px rgba(0,0,0,0.4);">
                    Tekan tombol mengambil doorprize Anda secara acak
                </div>
            @else
                <a href="/" class="btn-3d">Kembali ke Beranda</a>
                <div class="text-white fw-semibold mt-2"
                    style="font-size: 0.9rem; letter-spacing: 0.4px; text-shadow: 0 1px 4px rgba(0,0,0,0.4);">
                    Stok doorprize telah habis, silakan ikuti kuis kembali esok hari
                </div>
            @endif
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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

        // 1. Suara Launch / Power-Up saat Mulai Putaran
        function playLaunchSound() {
            if (!soundEnabled) return;
            try {
                const ctx = getAudioContext();
                const now = ctx.currentTime;
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();

                osc.type = 'sawtooth';
                osc.frequency.setValueAtTime(160, now);
                osc.frequency.exponentialRampToValueAtTime(750, now + 0.38);

                const filter = ctx.createBiquadFilter();
                filter.type = 'lowpass';
                filter.frequency.setValueAtTime(360, now);
                filter.frequency.exponentialRampToValueAtTime(2600, now + 0.38);

                gain.gain.setValueAtTime(0.01, now);
                gain.gain.linearRampToValueAtTime(0.24, now + 0.12);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.42);

                osc.connect(filter);
                filter.connect(gain);
                gain.connect(ctx.destination);

                osc.start(now);
                osc.stop(now + 0.45);
            } catch (e) {}
        }

        // 2. Suara Ritmik Cyber Whir / Ticker saat Berputar
        function playSpinTick(pitch = 540) {
            if (!soundEnabled) return;
            try {
                const ctx = getAudioContext();
                const now = ctx.currentTime;
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();

                osc.type = 'sine';
                osc.frequency.setValueAtTime(pitch, now);
                osc.frequency.exponentialRampToValueAtTime(180, now + 0.032);

                gain.gain.setValueAtTime(0.08, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.032);

                osc.connect(gain);
                gain.connect(ctx.destination);

                osc.start(now);
                osc.stop(now + 0.035);
            } catch (e) {}
        }

        // 3. Suara Fanfare Perayaan saat Doorprize Terpilih
        function playWinnerFanfare() {
            if (!soundEnabled) return;
            try {
                const ctx = getAudioContext();
                const now = ctx.currentTime;
                // Akord Mayor berkilau C5, E5, G5, C6
                const notes = [523.25, 659.25, 783.99, 1046.50];
                notes.forEach((freq, idx) => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();

                    osc.type = 'triangle';
                    osc.frequency.setValueAtTime(freq, now + (idx * 0.09));

                    gain.gain.setValueAtTime(0, now + (idx * 0.09));
                    gain.gain.linearRampToValueAtTime(0.28, now + (idx * 0.09) + 0.02);
                    gain.gain.exponentialRampToValueAtTime(0.001, now + (idx * 0.09) + 0.6);

                    osc.connect(gain);
                    gain.connect(ctx.destination);

                    osc.start(now + (idx * 0.09));
                    osc.stop(now + (idx * 0.09) + 0.65);
                });
            } catch (e) {}
        }

        // Toggle Sound Mute/Unmute
        const soundBtn = document.getElementById('btnSound');
        const soundIcon = document.getElementById('soundIcon');
        soundBtn.addEventListener('click', () => {
            getAudioContext();
            soundEnabled = !soundEnabled;
            if (soundEnabled) {
                soundIcon.className = 'bi bi-volume-up-fill';
                soundBtn.title = 'Suara Doorprize Aktif';
                soundBtn.style.color = '#0284c7';
                playSpinTick(660);
            } else {
                soundIcon.className = 'bi bi-volume-mute-fill';
                soundBtn.title = 'Suara Doorprize Dinonaktifkan';
                soundBtn.style.color = '#94a3b8';
            }
        });

        // ========================================================
        // 3D SPHERE TAG CLOUD & HOLOGRAPHIC GYROSCOPE RINGS
        // ========================================================
        let categories = [];
        const sphere = document.getElementById('sphere');
        const spinBtn = document.getElementById('spinBtn');
        const tags = [];
        const R = (parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--size')) || 540) / 2 - 80;

        // Pemilihan Ikon Doorprize Dinamis
        function getRewardIcon(name) {
            const lower = name.toLowerCase();
            if (lower.includes('payung')) return 'bi-umbrella-fill';
            if (lower.includes('indomie') || lower.includes('mie') || lower.includes('snack')) return 'bi-box-seam-fill';
            if (lower.includes('minyak') || lower.includes('gula') || lower.includes('sembako')) return 'bi-bag-heart-fill';
            if (lower.includes('gantungan') || lower.includes('kunci')) return 'bi-key-fill';
            if (lower.includes('tumbler') || lower.includes('botol') || lower.includes('mug') || lower.includes('cangkir'))
                return 'bi-cup-straw';
            if (lower.includes('buku') || lower.includes('pulpen') || lower.includes('notes'))
            return 'bi-journal-bookmark-fill';
            if (lower.includes('kaos') || lower.includes('baju')) return 'bi-person-badge-fill';
            if (lower.includes('uang') || lower.includes('voucher') || lower.includes('saldo')) return 'bi-cash-coin';
            return 'bi-gift-fill';
        }

        function createTags() {
            sphere.innerHTML = '';
            tags.length = 0;
            const n = categories.length;
            if (n === 0) return;

            for (let i = 0; i < n; i++) {
                const el = document.createElement('div');
                el.className = 'tag';
                el.setAttribute('data-reward', categories[i]);

                const iconClass = getRewardIcon(categories[i]);
                el.innerHTML = `
                    <span class="tag-icon"><i class="bi ${iconClass}"></i></span>
                    <span class="tag-text">${categories[i]}</span>
                    <span class="tag-status-light"></span>
                `;

                sphere.appendChild(el);

                const idx = i + 0.5;
                const phi = Math.acos(1 - 2 * idx / n);
                const theta = Math.PI * (1 + Math.sqrt(5)) * idx;
                tags.push({
                    el,
                    phi,
                    theta
                });
            }
        }

        function placeTags(rotX = 0, rotY = 0) {
            tags.forEach(t => {
                const x0 = R * Math.sin(t.phi) * Math.cos(t.theta);
                const y0 = R * Math.cos(t.phi);
                const z0 = R * Math.sin(t.phi) * Math.sin(t.theta);

                const cosX = Math.cos(rotX),
                    sinX = Math.sin(rotX);
                const y1 = y0 * cosX - z0 * sinX;
                const z1 = y0 * sinX + z0 * cosX;

                const cosY = Math.cos(rotY),
                    sinY = Math.sin(rotY);
                const x2 = x0 * cosY + z1 * sinY;
                const z2 = -x0 * sinY + z1 * cosY;

                const perspective = 1200;
                const scale = (perspective + z2) / (perspective + R);

                const tx = x2 * scale;
                const ty = y1 * scale;
                const tz = z2 * 0.9;

                const isSelected = t.el.classList.contains('selected');
                const isDim = t.el.classList.contains('dim');

                let scaleBase = 0.9 + (z2 / R) * 0.2;
                if (isSelected) scaleBase = 2.1;
                if (isDim) scaleBase = 0.48;

                t.el.style.transform =
                    `translate3d(${tx}px,${ty}px,${tz}px) translate(-50%,-50%) scale(${scaleBase})`;
                t.el.style.opacity = Math.max(.40, .70 + z2 / (R * 2));
                t.el.style.zIndex = Math.round(z2 + R);
            });
        }

        // Elemen Cincin Hologram
        const elRingOuter = document.getElementById('ringOuter');
        const elRingMiddle = document.getElementById('ringMiddle');
        const elRingInner = document.getElementById('ringInner');
        const elRingGyro1 = document.getElementById('ringGyro1');
        const elRingGyro2 = document.getElementById('ringGyro2');

        // Sudut & Kecepatan Putaran Cincin (Continuous Smooth Physics)
        let ringAngleOuter = 0,
            ringAngleMiddle = 0,
            ringAngleInner = 0,
            ringAngleGyro1 = 0,
            ringAngleGyro2 = 0;

        let currentRingSpeed = 1.0;
        let targetRingSpeed = 1.0;

        let rotX = 0.4,
            rotY = 0.6,
            velX = 0.0015,
            velY = 0.0018,
            animating = true;
        let last = performance.now();

        function raf(now) {
            const dt = Math.min(now - last, 100);
            last = now;

            // Interpolasi LERP Kecepatan Cincin Mulus
            currentRingSpeed += (targetRingSpeed - currentRingSpeed) * 0.045;

            // Update Sudut Cincin
            ringAngleOuter += (0.00040 * currentRingSpeed) * dt;
            ringAngleMiddle -= (0.00070 * currentRingSpeed) * dt;
            ringAngleInner += (0.00105 * currentRingSpeed) * dt;
            ringAngleGyro1 += (0.00085 * currentRingSpeed) * dt;
            ringAngleGyro2 -= (0.00065 * currentRingSpeed) * dt;

            if (elRingOuter) elRingOuter.style.transform = `rotate(${ringAngleOuter}rad)`;
            if (elRingMiddle) elRingMiddle.style.transform = `rotate(${ringAngleMiddle}rad)`;
            if (elRingInner) elRingInner.style.transform = `rotate(${ringAngleInner}rad)`;
            if (elRingGyro1) elRingGyro1.style.transform = `rotateX(68deg) rotateY(15deg) rotateZ(${ringAngleGyro1}rad)`;
            if (elRingGyro2) elRingGyro2.style.transform = `rotateX(-65deg) rotateY(20deg) rotateZ(${ringAngleGyro2}rad)`;

            // Update Bola Tag 3D
            if (animating) {
                rotX += velX * dt;
                rotY += velY * dt;
            }
            placeTags(rotX, rotY);
            requestAnimationFrame(raf);
        }

        // Ambil Data Doorprize yang Tersedia
        $.ajax({
            url: '/reward/list',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                categories = res;
                if (categories.length > 0) {
                    createTags();
                    requestAnimationFrame(raf);
                }
            },
            error: function() {
                console.error("Gagal memuat rewards");
            }
        });

        // ========================================================
        // LOGIKA PUTARAN & PEMILIHAN DOORPRIZE
        // ========================================================
        function spinAndPick(duration = 2600) {
            if (!categories.length || !tags.length) return;
            if (spinBtn) spinBtn.disabled = true;

            // Bunyikan Suara Launch / Power Up
            playLaunchSound();

            // Akselerasi Kecepatan Cincin Mulus
            targetRingSpeed = 5.5;

            // Reset highlight ketika spin dimulai
            if (lastSelected !== null) {
                tags[lastSelected].el.classList.remove('selected');
                lastSelected = null;
            }

            // Hilangkan dim pada semua tag
            tags.forEach(tag => tag.el.classList.remove('dim'));

            const baseVX = 0.0015;
            const baseVY = 0.0018;
            const signX = Math.random() < 0.5 ? -1 : 1;
            const signY = Math.random() < 0.5 ? -1 : 1;
            const peakVX = (Math.random() * 0.010 + 0.012) * signX;
            const peakVY = (Math.random() * 0.010 + 0.012) * signY;

            animating = true;
            const t0 = performance.now();
            let lastStepTime = t0;
            const accelDuration = 450;
            let tickAccumulator = 0;

            function step(now) {
                const elapsed = now - t0;
                const dtStep = now - lastStepTime;
                lastStepTime = now;

                if (elapsed < duration) {
                    if (elapsed < accelDuration) {
                        // Fase 1: Akselerasi Mulus (Ease-In)
                        const tAccel = elapsed / accelDuration;
                        const easeIn = tAccel * tAccel;
                        velX = baseVX + (peakVX - baseVX) * easeIn;
                        velY = baseVY + (peakVY - baseVY) * easeIn;
                    } else {
                        // Fase 2: Deselerasi Mulus
                        velX *= 0.993;
                        velY *= 0.993;

                        if (elapsed > duration * 0.45) {
                            targetRingSpeed = 1.0;
                        }
                    }

                    // Suara Ticker Berputar Adaptif
                    const speed = Math.hypot(velX, velY);
                    tickAccumulator += speed * dtStep;
                    if (tickAccumulator > 0.40) {
                        tickAccumulator = 0;
                        const pitch = 440 + Math.min(380, speed * 22000);
                        playSpinTick(pitch);
                    }

                    requestAnimationFrame(step);
                } else {
                    // Berhenti secara mulus dan pilih pemenang
                    animating = false;
                    velX = baseVX;
                    velY = baseVY;
                    targetRingSpeed = 1.0;

                    const idx = Math.floor(Math.random() * tags.length);
                    highlight(idx);
                }
            }
            requestAnimationFrame(step);
        }

        let lastSelected = null;

        function highlight(index) {
            // Mainkan Suara Kemenangan Fanfare
            playWinnerFanfare();

            if (lastSelected !== null) tags[lastSelected].el.classList.remove('selected');

            tags.forEach((tg, i) => {
                if (i !== index) tg.el.classList.add('dim');
                else tg.el.classList.remove('dim');
            });

            const t = tags[index];
            t.el.classList.add('selected');
            lastSelected = index;
            moveToFront(t);

            // Ledakan Confetti Perayaan saat Hadiah Terpilih
            try {
                confetti({
                    particleCount: 110,
                    spread: 80,
                    origin: {
                        y: 0.55
                    }
                });
            } catch (e) {}

            setTimeout(() => {
                const hadiah = t.el.getAttribute('data-reward') || t.el.querySelector('.tag-text')?.textContent
                    .trim() || t.el.textContent.trim();

                Swal.fire({
                    title: "Selamat! Anda Mendapatkan Doorprize",
                    html: `
                        <div class="my-3">
                            <span class="badge bg-warning text-dark py-3 px-4 shadow" style="font-size: 1.6rem; font-weight: 800; border-radius: 16px; border: 2px solid #ffd43b;">
                                <i class="bi bi-gift-fill me-2"></i> ${hadiah}
                            </span>
                        </div>
                        <p class="text-muted mt-2" style="font-size: 0.95rem;">
                            Silakan tunjukkan layar ini kepada petugas stand Diskominfo untuk klaim hadiah Anda.
                        </p>
                    `,
                    icon: "success",
                    confirmButtonText: "Klaim Hadiah & Selesai",
                    confirmButtonColor: "#f59e0b",
                    allowOutsideClick: false,
                    backdrop: `rgba(3, 105, 161, 0.35)`
                }).then(() => {
                    // Kurangi stok reward lewat AJAX
                    $.ajax({
                        url: "/reward/used",
                        type: "POST",
                        data: {
                            reward: hadiah,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            window.location.href = "/";
                        },
                        error: function() {
                            window.location.href = "/";
                        }
                    });
                });
            }, 1200);
        }

        function moveToFront(tag) {
            const targetRotX = Math.PI / 2 - tag.phi;
            const targetRotY = -tag.theta;
            const duration = 1300;
            const startX = rotX,
                startY = rotY;
            const start = performance.now();

            function anim(now) {
                const t = Math.min((now - start) / duration, 1);
                // Cubic-Quartic ease-out mulus dan elegan
                const ease = 1 - Math.pow(1 - t, 3.5);

                rotX = startX + (targetRotX - startX) * ease;
                rotY = startY + (targetRotY - startY) * ease;
                placeTags(rotX, rotY);

                if (t < 1) {
                    requestAnimationFrame(anim);
                } else {
                    rotX = targetRotX;
                    rotY = targetRotY;
                    placeTags(rotX, rotY);
                }
            }
            requestAnimationFrame(anim);
        }

        if (spinBtn) {
            spinBtn.addEventListener('click', () => spinAndPick());
        }
    </script>
</body>

</html>
