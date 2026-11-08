<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KOMQ - Acak Kategori Kuis Tapin Expo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&family=Bungee&display=swap" rel="stylesheet">

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
            background-color: #080c16;
            /* Perpaduan background gambar dengan spotlight panggung dan ambient cyber glow */
            background-image: 
                radial-gradient(circle at 50% 50%, rgba(49, 46, 129, 0.42) 0%, rgba(15, 23, 42, 0.85) 55%, rgba(6, 9, 18, 0.98) 95%),
                url('{{ asset('images/quiz-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Ambient Stage Lighting Glow */
        .stage-spotlight {
            position: absolute;
            top: 52%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 720px;
            height: 720px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(245, 159, 0, 0.16) 0%, rgba(99, 102, 241, 0.10) 40%, rgba(6, 9, 18, 0) 70%);
            pointer-events: none;
            z-index: 1;
            animation: pulseAura 4s ease-in-out infinite alternate;
        }

        @keyframes pulseAura {
            from { transform: translate(-50%, -50%) scale(0.92); opacity: 0.7; }
            to { transform: translate(-50%, -50%) scale(1.08); opacity: 1; }
        }

        /* =======================================================
           FUTURISTIC HOLOGRAPHIC QUANTUM RINGS (BACKGROUND ANIMASI)
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

        /* Base SVG Ring Styling */
        .holo-svg-ring {
            position: absolute;
            width: 100%;
            height: 100%;
            transform-origin: center center;
            will-change: transform, filter;
            transition: filter 0.8s ease;
        }

        /* 1. Ring Terluar: Cyber Compass & Tech Arcs */
        .ring-outer-hud {
            animation: rotateCw 50s linear infinite;
            filter: drop-shadow(0 0 12px rgba(245, 159, 0, 0.35));
            opacity: 0.85;
        }

        /* 2. Ring Tengah: Circuit & Tech Nodes */
        .ring-middle-circuit {
            width: 82%;
            height: 82%;
            animation: rotateCcw 32s linear infinite;
            filter: drop-shadow(0 0 16px rgba(56, 189, 248, 0.4));
            opacity: 0.75;
        }

        /* 3. Ring Dalam: Dashed Radar Orbit */
        .ring-inner-orbit {
            width: 66%;
            height: 66%;
            animation: rotateCw 18s linear infinite;
            filter: drop-shadow(0 0 14px rgba(251, 191, 36, 0.45));
            opacity: 0.8;
        }

        /* 4. Gyroscope Planetary Orbit (3D Tilt Effect yang Mengitari Bola) */
        .ring-gyro-3d {
            position: absolute;
            width: 90%;
            height: 90%;
            border-radius: 50%;
            border: 2px dashed rgba(245, 159, 0, 0.35);
            box-shadow: 0 0 30px rgba(245, 159, 0, 0.2), inset 0 0 20px rgba(99, 102, 241, 0.15);
            transform: rotateX(68deg) rotateY(15deg) rotateZ(0deg);
            animation: rotateGyro 20s linear infinite;
        }

        .ring-gyro-3d-reverse {
            position: absolute;
            width: 86%;
            height: 86%;
            border-radius: 50%;
            border: 1.5px solid rgba(56, 189, 248, 0.3);
            box-shadow: 0 0 25px rgba(56, 189, 248, 0.25);
            transform: rotateX(-65deg) rotateY(20deg) rotateZ(0deg);
            animation: rotateGyroRev 26s linear infinite;
        }

        /* Energy Pulse Core */
        .energy-pulse-core {
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(245, 159, 0, 0.15) 0%, rgba(99, 102, 241, 0.08) 50%, transparent 75%);
            animation: coreBreath 3s ease-in-out infinite alternate;
        }

        @keyframes coreBreath {
            0% { transform: scale(0.85); opacity: 0.5; }
            100% { transform: scale(1.15); opacity: 0.9; filter: drop-shadow(0 0 25px rgba(245, 159, 0, 0.4)); }
        }

        /* Keyframes Rotasi */
        @keyframes rotateCw {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes rotateCcw {
            from { transform: rotate(0deg); }
            to { transform: rotate(-360deg); }
        }

        @keyframes rotateGyro {
            from { transform: rotateX(68deg) rotateY(15deg) rotateZ(0deg); }
            to { transform: rotateX(68deg) rotateY(15deg) rotateZ(360deg); }
        }

        @keyframes rotateGyroRev {
            from { transform: rotateX(-65deg) rotateY(20deg) rotateZ(0deg); }
            to { transform: rotateX(-65deg) rotateY(20deg) rotateZ(-360deg); }
        }

        /* ========================================================
           OVERDRIVE BOOST EFFECT (KETIKA TOMBOL ACAK DI-SPIN)
           ======================================================== */
        .hologram-rings-container.spinning-boost .ring-outer-hud {
            animation-duration: 6s !important;
            filter: drop-shadow(0 0 30px rgba(245, 159, 0, 0.9)) !important;
            opacity: 1 !important;
        }

        .hologram-rings-container.spinning-boost .ring-middle-circuit {
            animation-duration: 4s !important;
            filter: drop-shadow(0 0 35px rgba(56, 189, 248, 0.9)) !important;
            opacity: 1 !important;
        }

        .hologram-rings-container.spinning-boost .ring-inner-orbit {
            animation-duration: 2.5s !important;
            filter: drop-shadow(0 0 25px rgba(251, 191, 36, 0.95)) !important;
            opacity: 1 !important;
        }

        .hologram-rings-container.spinning-boost .ring-gyro-3d {
            animation-duration: 3s !important;
            box-shadow: 0 0 45px rgba(245, 159, 0, 0.6) !important;
        }

        .hologram-rings-container.spinning-boost .ring-gyro-3d-reverse {
            animation-duration: 3.5s !important;
            box-shadow: 0 0 40px rgba(56, 189, 248, 0.6) !important;
        }

        /* Top Brand Header Bar */
        .top-header {
            position: relative;
            z-index: 20;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 15px;
        }

        .brand-pill {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 215, 0, 0.35);
            border-radius: 40px;
            padding: 8px 24px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.15);
        }

        .header-title-gold {
            font-family: 'Bungee', cursive;
            background: linear-gradient(180deg, #ffffff 0%, #ffd43b 60%, #f59f00 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.15rem;
            letter-spacing: 1px;
            margin: 0;
            line-height: 1.2;
        }

        .header-subtitle {
            font-size: 0.72rem;
            color: #cbd5e1;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* Status Badge Doorprize */
        .doorprize-badge {
            margin-top: 10px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 20px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 0.88rem;
            letter-spacing: 0.5px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
        }

        .doorprize-badge.available {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.9) 0%, rgba(16, 185, 129, 0.9) 100%);
            border: 1px solid rgba(167, 243, 208, 0.5);
            color: #fff;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        }

        .doorprize-badge.empty {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.9) 0%, rgba(239, 68, 68, 0.9) 100%);
            border: 1px solid rgba(254, 202, 202, 0.5);
            color: #fff;
            animation: alertBlink 1.4s infinite ease-in-out;
        }

        @keyframes alertBlink {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.82; transform: scale(1.04); }
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

        /* Bentuk Baru: Holographic Cyber Pod Card */
        .tag {
            --x: 0px;
            --y: 0px;
            --z: 0px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform-style: preserve-3d;
            transform: translate3d(var(--x), var(--y), var(--z)) translate(-50%, -50%);
            padding: 10px 22px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.88) 0%, rgba(15, 23, 42, 0.94) 100%);
            backdrop-filter: blur(12px);
            border: 1.5px solid rgba(255, 215, 0, 0.45);
            color: #ffffff;
            font-weight: 700;
            white-space: nowrap;
            cursor: pointer;
            user-select: none;
            transition: transform 250ms cubic-bezier(.2, .9, .2, 1), background 250ms, box-shadow 250ms, border 250ms;
            font-size: 17px;
            text-align: center;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.65), 0 0 15px rgba(245, 159, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.2);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .tag .tag-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: rgba(245, 159, 0, 0.2);
            border: 1px solid rgba(255, 215, 0, 0.5);
            color: #ffd43b;
            font-size: 14px;
            transition: all 0.25s;
        }

        .tag .tag-text {
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
        }

        .tag .tag-status-light {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 8px #10b981;
            margin-left: 2px;
        }

        /* Hover Effect pada Tag */
        .tag:hover {
            border-color: #ffd43b;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.7), 0 0 25px rgba(245, 159, 0, 0.5);
            transform: translate3d(var(--x), var(--y), var(--z)) translate(-50%, -50%) scale(1.08);
        }

        /* Tag Terpilih (Selected / Winner) */
        .tag.selected {
            font-size: 2rem !important;
            font-weight: 800;
            color: #ffffff !important;
            opacity: 1 !important;
            padding: 16px 36px !important;
            border-radius: 20px !important;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 60%, #92400e 100%) !important;
            border: 3px solid #fef08a !important;
            box-shadow: 0 0 50px rgba(245, 159, 0, 0.95), 0 20px 45px rgba(0, 0, 0, 0.8) !important;
            z-index: 99999 !important;
            animation: selectedPulse 1.2s infinite alternate ease-in-out;
        }

        @keyframes selectedPulse {
            from { filter: drop-shadow(0 0 25px rgba(245, 159, 0, 0.8)); }
            to { filter: drop-shadow(0 0 45px rgba(254, 240, 138, 1)); }
        }

        .tag.selected .tag-icon {
            width: 38px !important;
            height: 38px !important;
            font-size: 20px !important;
            background: rgba(255, 255, 255, 0.3) !important;
            border-color: #ffffff !important;
            color: #ffffff !important;
        }

        .tag.selected .tag-status-light {
            width: 10px !important;
            height: 10px !important;
            background: #ffffff !important;
            box-shadow: 0 0 12px #ffffff !important;
        }

        .tag.dim {
            opacity: 0.20 !important;
            transform: scale(.50) !important;
            filter: blur(1.5px);
        }

        /* Tombol 3D Acak (Sesuai Konsep Asli tapi Lebih Glowing) */
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
    </style>
</head>

<body>

    <!-- Stage Spotlight Glow -->
    <div class="stage-spotlight"></div>

    <!-- Holographic Quantum Gyroscope Rings (Latar Animasi Berputar Futuristik) -->
    <div class="hologram-rings-container" id="hologramRings">
        <!-- Energy Pulse Core Glow -->
        <div class="energy-pulse-core"></div>

        <!-- 3D Gyroscope Orbital Rings (Memeluk Bola 3D) -->
        <div class="ring-gyro-3d"></div>
        <div class="ring-gyro-3d-reverse"></div>

        <!-- Ring 1: Terluar - Tech HUD Compass & Segmented Arcs (Gold & Amber Glow) -->
        <svg class="holo-svg-ring ring-outer-hud" viewBox="0 0 800 800" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="400" cy="400" r="370" stroke="rgba(245, 159, 0, 0.25)" stroke-width="1.5" stroke-dasharray="8 6"/>
            <circle cx="400" cy="400" r="355" stroke="rgba(255, 215, 0, 0.45)" stroke-width="2.5" stroke-dasharray="140 30 40 30"/>
            <circle cx="400" cy="400" r="338" stroke="rgba(245, 159, 0, 0.2)" stroke-width="1"/>

            <!-- Segmen Busur Tebal Bergaya Sci-Fi HUD -->
            <path d="M 400 30 A 370 370 0 0 1 661 138" stroke="#fbbf24" stroke-width="5" stroke-linecap="round"/>
            <path d="M 400 770 A 370 370 0 0 1 139 662" stroke="#f59e0b" stroke-width="5" stroke-linecap="round"/>

            <!-- 4 Simpul Data Sudut Kompas -->
            <circle cx="400" cy="30" r="6" fill="#ffd43b" filter="drop-shadow(0 0 8px #ffd43b)"/>
            <circle cx="770" cy="400" r="6" fill="#ffd43b" filter="drop-shadow(0 0 8px #ffd43b)"/>
            <circle cx="400" cy="770" r="6" fill="#ffd43b" filter="drop-shadow(0 0 8px #ffd43b)"/>
            <circle cx="30" cy="400" r="6" fill="#ffd43b" filter="drop-shadow(0 0 8px #ffd43b)"/>

            <!-- Tick Garis-Garis Radial -->
            <g stroke="rgba(255, 215, 0, 0.35)" stroke-width="2">
                <line x1="400" y1="15" x2="400" y2="30"/>
                <line x1="400" y1="770" x2="400" y2="785"/>
                <line x1="15" y1="400" x2="30" y2="400"/>
                <line x1="770" y1="400" x2="785" y2="400"/>
                <line x1="138" y1="138" x2="150" y2="150"/>
                <line x1="662" y1="138" x2="650" y2="150"/>
                <line x1="138" y1="662" x2="150" y2="650"/>
                <line x1="662" y1="662" x2="650" y2="650"/>
            </g>
        </svg>

        <!-- Ring 2: Tengah - Cyber Circuit & Data Waves (Cyan & Electric Blue) -->
        <svg class="holo-svg-ring ring-middle-circuit" viewBox="0 0 650 650" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="325" cy="325" r="300" stroke="rgba(56, 189, 248, 0.3)" stroke-width="2" stroke-dasharray="16 12"/>
            <circle cx="325" cy="325" r="285" stroke="rgba(14, 165, 233, 0.5)" stroke-width="3" stroke-dasharray="80 40 20 40"/>
            <circle cx="325" cy="325" r="270" stroke="rgba(56, 189, 248, 0.2)" stroke-width="1.5"/>

            <!-- Segmen Sirkuit Busur Ganda Cyan -->
            <path d="M 112 112 A 300 300 0 0 1 538 112" stroke="#38bdf8" stroke-width="4.5" stroke-linecap="round"/>
            <path d="M 538 538 A 300 300 0 0 1 112 538" stroke="#0ea5e9" stroke-width="4.5" stroke-linecap="round"/>

            <!-- Titik Orbit Node -->
            <circle cx="325" cy="25" r="5" fill="#38bdf8" filter="drop-shadow(0 0 6px #38bdf8)"/>
            <circle cx="625" cy="325" r="5" fill="#38bdf8" filter="drop-shadow(0 0 6px #38bdf8)"/>
            <circle cx="325" cy="625" r="5" fill="#38bdf8" filter="drop-shadow(0 0 6px #38bdf8)"/>
            <circle cx="25" cy="325" r="5" fill="#38bdf8" filter="drop-shadow(0 0 6px #38bdf8)"/>
        </svg>

        <!-- Ring 3: Dalam - Radar Astrolabe & Golden Glyphs -->
        <svg class="holo-svg-ring ring-inner-orbit" viewBox="0 0 500 500" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="250" cy="250" r="230" stroke="rgba(245, 159, 0, 0.45)" stroke-width="2" stroke-dasharray="30 15 10 15"/>
            <circle cx="250" cy="250" r="215" stroke="rgba(255, 215, 0, 0.3)" stroke-width="1.5" stroke-dasharray="6 6"/>
            <!-- Triangle Accents -->
            <polygon points="250,20 244,32 256,32" fill="#ffd43b"/>
            <polygon points="250,480 244,468 256,468" fill="#ffd43b"/>
            <polygon points="20,250 32,244 32,256" fill="#ffd43b"/>
            <polygon points="480,250 468,244 468,256" fill="#ffd43b"/>
        </svg>
    </div>

    <!-- Main Container -->
    <div class="d-flex justify-content-between align-items-center flex-column min-vh-100 py-3 position-relative">

        <!-- Top Header & Doorprize Status -->
        <div class="top-header">
            <div class="brand-pill">
                <img src="{{ asset('images/diskominfo.png') }}" alt="Diskominfo" style="height: 36px;">
                <div class="text-start">
                    <div class="header-subtitle">Dinas Kominfo Kab. Tapin</div>
                    <h1 class="header-title-gold">TAPIN EXPO 2025</h1>
                </div>
            </div>

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
            <button id="spinBtn" class="btn-3d">Acak</button>
            <div class="text-white-50 mt-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                Tekan tombol untuk mengundi kategori soal secara acak
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>

    <script>
        // Kategori dinamis dari database (fallback ke kategori default jika DB kosong)
        const categories = @json($categories);

        // Helper fungsi pemilihan ikon dinamis per kategori
        function getCategoryIcon(name) {
            const lower = name.toLowerCase();
            if (lower.includes('program') || lower.includes('code') || lower.includes('dev')) return 'bi-code-slash';
            if (lower.includes('ai') || lower.includes('artificial') || lower.includes('intel') || lower.includes('data')) return 'bi-cpu-fill';
            if (lower.includes('internet') || lower.includes('cyber') || lower.includes('web') || lower.includes('jaring')) return 'bi-globe2';
            if (lower.includes('app') || lower.includes('super')) return 'bi-grid-1x2-fill';
            if (lower.includes('govem') || lower.includes('spbe') || lower.includes('tapin') || lower.includes('layanan')) return 'bi-building-fill-check';
            if (lower.includes('lapor') || lower.includes('aduan')) return 'bi-megaphone-fill';
            if (lower.includes('keamanan') || lower.includes('sehat')) return 'bi-shield-lock-fill';
            return 'bi-patch-question-fill';
        }

        const sphere = document.getElementById('sphere');
        const spinBtn = document.getElementById('spinBtn');
        const tags = [];
        const R = (parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--size')) || 540) / 2 - 80;

        function createTags() {
            const n = categories.length;
            for (let i = 0; i < n; i++) {
                const el = document.createElement('div');
                el.className = 'tag';
                el.setAttribute('data-kategori', categories[i]);
                
                const iconClass = getCategoryIcon(categories[i]);
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
            const cx = sphere.clientWidth / 2;
            const cy = sphere.clientHeight / 2;

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
                if (isDim) scaleBase = 0.50;

                t.el.style.transform = `translate3d(${tx}px,${ty}px,${tz}px) translate(-50%,-50%) scale(${scaleBase})`;
                t.el.style.opacity = Math.max(.40, .70 + z2 / (R * 2));
                t.el.style.zIndex = Math.round(z2 + R);
            });
        }

        let rotX = 0.4,
            rotY = 0.6,
            velX = 0.0015,
            velY = 0.0018,
            animating = true;
        let last = performance.now();

        function raf(now) {
            const dt = now - last;
            last = now;
            if (animating) {
                rotX += velX * dt;
                rotY += velY * dt;
            }
            placeTags(rotX, rotY);
            requestAnimationFrame(raf);
        }

        createTags();
        requestAnimationFrame(raf);

        function spinAndPick(duration = 2400) {
            spinBtn.disabled = true;

            const ringsContainer = document.getElementById('hologramRings');
            if (ringsContainer) ringsContainer.classList.add('spinning-boost');

            // Reset highlight ketika spin dimulai
            if (lastSelected !== null) {
                tags[lastSelected].el.classList.remove('selected');
                lastSelected = null;
            }

            // Hilangkan dim pada semua tag
            tags.forEach(tag => tag.el.classList.remove('dim'));

            const startVX = velX,
                startVY = velY;
            velX = (Math.random() * 0.014 + 0.009) * (Math.random() < 0.5 ? -1 : 1);
            velY = (Math.random() * 0.014 + 0.009) * (Math.random() < 0.5 ? -1 : 1);
            animating = true;
            const t0 = performance.now();

            function step(now) {
                const t = now - t0;
                if (t < duration) {
                    velX *= 0.995;
                    velY *= 0.995;
                    requestAnimationFrame(step);
                } else {
                    animating = false;
                    velX = startVX;
                    velY = startVY;
                    if (ringsContainer) ringsContainer.classList.remove('spinning-boost');
                    const idx = Math.floor(Math.random() * tags.length);
                    highlight(idx);
                }
            }
            requestAnimationFrame(step);
        }

        let lastSelected = null;

        function highlight(index) {
            if (lastSelected !== null) tags[lastSelected].el.classList.remove('selected');

            tags.forEach((tg, i) => {
                if (i !== index) tg.el.classList.add('dim');
                else tg.el.classList.remove('dim');
            });

            const t = tags[index];
            t.el.classList.add('selected');
            lastSelected = index;
            moveToFront(t);

            // Ledakan Confetti Perayaan saat Terpilih
            try {
                confetti({
                    particleCount: 75,
                    spread: 65,
                    origin: { y: 0.55 }
                });
            } catch (e) {}

            setTimeout(() => {
                tags.forEach(tag => tag.el.classList.remove('dim'));

                const kategori = t.el.getAttribute('data-kategori') || t.el.textContent.trim();
                window.location.href = `/quiz/${encodeURIComponent(kategori)}`;
            }, 1900);
        }

        function moveToFront(tag) {
            const targetRotX = Math.PI / 2 - tag.phi;
            const targetRotY = -tag.theta;
            const duration = 1200;
            const startX = rotX,
                startY = rotY;
            const start = performance.now();

            function anim(now) {
                const t = (now - start) / duration;
                if (t < 1) {
                    const ease = 1 - Math.pow(1 - t, 500);
                    rotX = startX + (targetRotX - startX) * ease;
                    rotY = startY + (targetRotY - startY) * ease;
                    placeTags(rotX, rotY);
                    requestAnimationFrame(anim);
                } else {
                    rotX = targetRotX;
                    rotY = targetRotY;
                    placeTags(rotX, rotY);
                }
            }
            requestAnimationFrame(anim);
        }

        spinBtn.addEventListener('click', () => spinAndPick());
    </script>
</body>

</html>
