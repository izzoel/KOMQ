<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KOMQ - Undian Kategori Kuis Tapin Expo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&family=Bungee&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold-gradient: linear-gradient(135deg, #ffe066 0%, #f59f00 50%, #d97706 100%);
            --gold-shadow: 0 10px 25px rgba(245, 159, 0, 0.45);
        }

        * {
            box-sizing: border-box;
            user-select: none;
        }

        body {
            background-color: #0b0f19;
            background-image: radial-gradient(circle at 50% 30%, rgba(30, 58, 138, 0.35) 0%, rgba(11, 15, 25, 0.95) 70%), url('{{ asset('images/quiz-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient rotating rings */
        .ambient-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 0;
        }

        .ring-1 {
            height: 75vmin;
            opacity: 0.18;
            animation: rotateCw 35s linear infinite;
        }

        .ring-2 {
            height: 88vmin;
            opacity: 0.12;
            animation: rotateCcw 45s linear infinite;
        }

        @keyframes rotateCw {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }

        @keyframes rotateCcw {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(-360deg); }
        }

        /* Top Header Card */
        .expo-badge {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 215, 0, 0.3);
            border-radius: 50px;
            padding: 8px 24px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }

        .title-gold {
            font-family: 'Bungee', cursive;
            background: linear-gradient(180deg, #fff 0%, #ffd43b 55%, #f59f00 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 4px 20px rgba(245, 159, 0, 0.35);
            letter-spacing: 1px;
        }

        /* Stock Status Pill */
        .stock-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 22px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .stock-pill.available {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: #fff;
            border: 1px solid rgba(167, 243, 208, 0.4);
        }

        .stock-pill.empty {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: #fff;
            animation: pulseAlert 1.5s infinite;
        }

        @keyframes pulseAlert {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.85; transform: scale(1.03); }
        }

        /* Wheel Stage Container */
        .wheel-container {
            position: relative;
            width: min(85vw, 480px);
            height: min(85vw, 480px);
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        /* Outer Glow Rim */
        .wheel-glow-rim {
            position: absolute;
            inset: -14px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(245, 159, 0, 0.3) 0%, rgba(245, 159, 0, 0) 70%);
            box-shadow: 0 0 50px rgba(245, 159, 0, 0.35), inset 0 0 25px rgba(255, 215, 0, 0.2);
            pointer-events: none;
            animation: pulseGlow 3s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            from { transform: scale(0.98); opacity: 0.7; }
            to { transform: scale(1.02); opacity: 1; }
        }

        /* The Pointer / Ticker Arrow */
        .wheel-pointer {
            position: absolute;
            top: -24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 30;
            width: 48px;
            height: 58px;
            filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.65));
            transform-origin: 50% 18px;
            transition: transform 0.08s ease-out;
        }

        .wheel-pointer svg {
            width: 100%;
            height: 100%;
        }

        /* Center Spin Button (Hub) */
        .wheel-center-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 25;
            width: 96px;
            height: 96px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffe066 0%, #f59f00 45%, #b45309 100%);
            border: 4px solid #fff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.6), inset 0 3px 6px rgba(255, 255, 255, 0.8), inset 0 -4px 8px rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            outline: none;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .wheel-center-btn:hover {
            transform: translate(-50%, -50%) scale(1.06);
            box-shadow: 0 12px 30px rgba(245, 159, 0, 0.6), inset 0 3px 6px rgba(255, 255, 255, 0.9);
        }

        .wheel-center-btn:active {
            transform: translate(-50%, -50%) scale(0.96);
        }

        .wheel-center-btn span.spin-text {
            font-family: 'Bungee', cursive;
            font-size: 1.15rem;
            color: #451a03;
            line-height: 1;
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.6);
        }

        .wheel-center-btn span.spin-sub {
            font-size: 0.65rem;
            font-weight: 800;
            color: #78350f;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Bottom Action Button */
        .btn-spin-action {
            background: linear-gradient(180deg, #ffd43b 0%, #f59f00 50%, #d97706 100%);
            border: none;
            border-radius: 50px;
            padding: 16px 54px;
            font-size: 1.35rem;
            font-weight: 900;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #3f1a00;
            cursor: pointer;
            box-shadow: 0 8px 0 #92400e, 0 15px 25px rgba(245, 159, 0, 0.4);
            position: relative;
            outline: none;
            transition: all 0.15s ease;
            z-index: 10;
        }

        .btn-spin-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 0 #92400e, 0 20px 30px rgba(245, 159, 0, 0.55);
            filter: brightness(1.05);
        }

        .btn-spin-action:active {
            transform: translateY(4px);
            box-shadow: 0 4px 0 #92400e, 0 8px 15px rgba(245, 159, 0, 0.3);
        }

        .btn-spin-action:disabled {
            opacity: 0.65;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: 0 4px 0 #92400e;
        }

        /* Sound Control Floating Button */
        .btn-sound-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 50;
            transition: all 0.2s;
        }

        .btn-sound-toggle:hover {
            background: rgba(245, 159, 0, 0.3);
            border-color: #f59f00;
            transform: scale(1.08);
        }

        /* Marquee Light Bulbs around Wheel */
        #wheelCanvas {
            border-radius: 50%;
            display: block;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
        }

        /* Winner Popup Modal Customization */
        .modal-category-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border: 2px solid rgba(245, 159, 0, 0.6);
            border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.7);
            padding: 35px 25px;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Sound Toggle -->
    <button class="btn-sound-toggle" id="btnSound" title="Aktif/Nonaktifkan Suara">
        <i class="bi bi-volume-up-fill" id="soundIcon"></i>
    </button>

    <!-- Background Ambient SVGs -->
    <img src="{{ asset('images/c3.svg') }}" class="ambient-ring ring-1" alt="">
    <img src="{{ asset('images/c2.svg') }}" class="ambient-ring ring-2" alt="">

    <div class="container d-flex flex-column align-items-center justify-content-between min-vh-100 py-4 position-relative" style="z-index: 5;">

        <!-- Header Brand & Doorprize Info -->
        <header class="text-center">
            <div class="expo-badge mb-3">
                <img src="{{ asset('images/diskominfo.png') }}" alt="Diskominfo" style="height: 38px;">
                <div class="text-start">
                    <div style="font-size: 0.75rem; letter-spacing: 1px; color: #cbd5e1; text-transform: uppercase; font-weight: 600;">
                        Dinas Kominfo Kab. Tapin
                    </div>
                    <div style="font-size: 0.95rem; font-weight: 700; color: #ffd43b;">
                        TAPIN EXPO 2025
                    </div>
                </div>
            </div>

            <h1 class="title-gold display-6 mb-2">KOMQ - KUIS INTERAKTIF</h1>
            <p class="text-light text-opacity-75 mb-3" style="font-size: 0.95rem;">
                Putar roda untuk mengacak kategori soal & uji wawasan Anda!
            </p>

            <!-- Status Doorprize -->
            @if ($totalStok > 0)
                <div class="stock-pill available">
                    <i class="bi bi-gift-fill fs-5"></i>
                    <span>DOORPRIZE TERSEDIA: <strong>{{ $totalStok }} HADIAH</strong></span>
                </div>
            @else
                <div class="stock-pill empty">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <span>MOHON MAAF, DOORPRIZE HARI INI SUDAH HABIS</span>
                </div>
            @endif
        </header>

        <!-- Main Wheel Stage -->
        <main class="my-auto py-2">
            <div class="wheel-container">
                <!-- Outer Glow -->
                <div class="wheel-glow-rim"></div>

                <!-- Pointer Arrow -->
                <div class="wheel-pointer" id="wheelPointer">
                    <svg viewBox="0 0 50 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Drop Shadow Shape -->
                        <path d="M25 58 L5 12 C3 8 6 3 11 3 L39 3 C44 3 47 8 45 12 Z" fill="#92400e" opacity="0.5" transform="translate(0, 3)"/>
                        <!-- Gold Outer Body -->
                        <path d="M25 56 L5 12 C3 8 6 3 11 3 L39 3 C44 3 47 8 45 12 Z" fill="url(#pointerGold)" stroke="#fff" stroke-width="2"/>
                        <!-- Inner Accent Gem -->
                        <circle cx="25" cy="18" r="7" fill="#ef4444" stroke="#fff" stroke-width="2"/>
                        <circle cx="23" cy="16" r="2.5" fill="#fff" opacity="0.8"/>
                        <!-- Gradient Definition -->
                        <defs>
                            <linearGradient id="pointerGold" x1="5" y1="3" x2="45" y2="56" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#fffbeb"/>
                                <stop offset="40%" stop-color="#fbbf24"/>
                                <stop offset="100%" stop-color="#b45309"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>

                <!-- Wheel Canvas -->
                <canvas id="wheelCanvas" width="480" height="480"></canvas>

                <!-- Center Hub Button -->
                <button type="button" class="wheel-center-btn" id="centerSpinBtn" title="Klik untuk memutar!">
                    <span class="spin-text">SPIN</span>
                    <span class="spin-sub">KOMQ</span>
                </button>
            </div>
        </main>

        <!-- Footer Control Button -->
        <footer class="text-center mt-3">
            <button id="spinBtn" class="btn-spin-action">
                <i class="bi bi-play-circle-fill me-2"></i> PUTAR SEKARANG
            </button>
            <div class="mt-2 text-white-50" style="font-size: 0.8rem;">
                Tekan tombol atau klik poros roda untuk mengundi kategori
            </div>
        </footer>

    </div>

    <!-- Modal Winner Kategori -->
    <div class="modal fade" id="winnerModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-category-card">
                <div class="mb-3">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase" style="letter-spacing: 1px;">
                        🎯 Kategori Terpilih!
                    </span>
                </div>
                <h2 id="winnerCategoryName" class="display-6 fw-bold text-white mb-3" style="text-shadow: 0 0 20px rgba(245, 159, 0, 0.6);">
                    -
                </h2>
                <p class="text-light text-opacity-75 mb-4">
                    Bersiaplah menjawab pertanyaan kuis seputar kategori ini!
                </p>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <div class="spinner-grow text-warning spinner-grow-sm" role="status"></div>
                    <span class="text-warning fw-semibold" id="countdownRedirect">Memulai kuis dalam 3 detik...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts: Bootstrap, SweetAlert, Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>

    <script>
        // Kategori dinamis dari database (fallback ke default jika kosong)
        const categories = @json($categories);

        // Palet Warna Sektor (Segar, Elegan, Kontras)
        const sectorColors = [
            { bg1: '#ef4444', bg2: '#b91c1c', text: '#ffffff' }, // Merah Api
            { bg1: '#3b82f6', bg2: '#1d4ed8', text: '#ffffff' }, // Biru Elektrik
            { bg1: '#10b981', bg2: '#047857', text: '#ffffff' }, // Hijau Zamrud
            { bg1: '#f59e0b', bg2: '#b45309', text: '#ffffff' }, // Emas / Amber
            { bg1: '#8b5cf6', bg2: '#6d28d9', text: '#ffffff' }, // Ungu Cyber
            { bg1: '#06b6d4', bg2: '#0e7490', text: '#ffffff' }, // Biru Cyan
            { bg1: '#ec4899', bg2: '#be185d', text: '#ffffff' }, // Merah Muda
            { bg1: '#14b8a6', bg2: '#0f766e', text: '#ffffff' }, // Toska
        ];

        // Canvas & Konteks
        const canvas = document.getElementById('wheelCanvas');
        const ctx = canvas.getContext('2d');
        const numSectors = categories.length;
        const arc = (2 * Math.PI) / numSectors;

        const size = canvas.width;
        const center = size / 2;
        const outerRadius = center - 16;
        const innerRadius = 48; // Poros tombol tengah

        let currentAngle = 0;       // Sudut rotasi saat ini
        let isSpinning = false;     // Status putaran
        let soundEnabled = true;    // Audio toggle

        // Audio Synthesis (Web Audio API - Suara Ticker & Fanfare Tanpa File Eksternal)
        let audioCtx = null;
        function initAudio() {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
        }

        // Suara 'Click' / 'Tick' jarum penunjuk
        function playTickSound() {
            if (!soundEnabled) return;
            try {
                initAudio();
                if (audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();

                osc.type = 'triangle';
                osc.frequency.setValueAtTime(650, audioCtx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(120, audioCtx.currentTime + 0.04);

                gain.gain.setValueAtTime(0.18, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.04);

                osc.connect(gain);
                gain.connect(audioCtx.destination);

                osc.start();
                osc.stop(audioCtx.currentTime + 0.04);
            } catch (e) {
                // Ignore audio restriction
            }
        }

        // Suara Fanfare Kemenangan saat berhenti
        function playFanfareSound() {
            if (!soundEnabled) return;
            try {
                initAudio();
                const notes = [523.25, 659.25, 783.99, 1046.50]; // Chord C - E - G - C tinggi
                notes.forEach((freq, idx) => {
                    const osc = audioCtx.createOscillator();
                    const gain = audioCtx.createGain();

                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(freq, audioCtx.currentTime + (idx * 0.09));

                    gain.gain.setValueAtTime(0, audioCtx.currentTime + (idx * 0.09));
                    gain.gain.linearRampToValueAtTime(0.22, audioCtx.currentTime + (idx * 0.09) + 0.02);
                    gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + (idx * 0.09) + 0.5);

                    osc.connect(gain);
                    gain.connect(audioCtx.destination);

                    osc.start(audioCtx.currentTime + (idx * 0.09));
                    osc.stop(audioCtx.currentTime + (idx * 0.09) + 0.55);
                });
            } catch (e) {}
        }

        // Efek kedip lampu LED luar roda
        let lightBulbTick = 0;

        // Render Roda
        function drawWheel() {
            ctx.clearRect(0, 0, size, size);

            // 1. Bingkai Luar Roda (Gold Metallic Rim)
            ctx.save();
            ctx.beginPath();
            ctx.arc(center, center, center - 2, 0, 2 * Math.PI);
            ctx.fillStyle = '#b45309';
            ctx.fill();

            ctx.beginPath();
            ctx.arc(center, center, center - 5, 0, 2 * Math.PI);
            const rimGradient = ctx.createLinearGradient(0, 0, size, size);
            rimGradient.addColorStop(0, '#fffbeb');
            rimGradient.addColorStop(0.3, '#f59e0b');
            rimGradient.addColorStop(0.7, '#78350f');
            rimGradient.addColorStop(1, '#fde68a');
            ctx.fillStyle = rimGradient;
            ctx.fill();

            // Lapisan Hitam Pinggiran Lampu LED
            ctx.beginPath();
            ctx.arc(center, center, outerRadius + 8, 0, 2 * Math.PI);
            ctx.fillStyle = '#1e1b18';
            ctx.fill();
            ctx.restore();

            // 2. Lampu LED Berkedip Bergantian (Marquee Bulbs)
            const numBulbs = 24;
            const bulbAngle = (2 * Math.PI) / numBulbs;
            lightBulbTick += 0.05;

            for (let i = 0; i < numBulbs; i++) {
                const angle = i * bulbAngle;
                const bx = center + (outerRadius + 3) * Math.cos(angle);
                const by = center + (outerRadius + 3) * Math.sin(angle);
                const isLit = (Math.floor(i + lightBulbTick) % 2 === 0);

                ctx.save();
                ctx.beginPath();
                ctx.arc(bx, by, 4.5, 0, 2 * Math.PI);
                ctx.fillStyle = isLit ? '#fef08a' : '#451a03';
                if (isLit) {
                    ctx.shadowColor = '#facc15';
                    ctx.shadowBlur = 8;
                }
                ctx.fill();
                ctx.restore();
            }

            // 3. Sektor-Sektor Roda Kategori
            ctx.save();
            ctx.translate(center, center);
            ctx.rotate(currentAngle);

            for (let i = 0; i < numSectors; i++) {
                const startAngle = i * arc;
                const endAngle = startAngle + arc;
                const colorSet = sectorColors[i % sectorColors.length];

                // Gambar irisan pie
                ctx.beginPath();
                ctx.moveTo(0, 0);
                ctx.arc(0, 0, outerRadius - 4, startAngle, endAngle);
                ctx.closePath();

                // Gradasi radial sektor
                const grad = ctx.createRadialGradient(0, 0, innerRadius, 0, 0, outerRadius);
                grad.addColorStop(0, colorSet.bg1);
                grad.addColorStop(1, colorSet.bg2);
                ctx.fillStyle = grad;
                ctx.fill();

                // Garis pembatas emas halus
                ctx.lineWidth = 2.5;
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.35)';
                ctx.stroke();

                // Pasak pembatas perak (Pegs)
                const pegX = (outerRadius - 6) * Math.cos(startAngle);
                const pegY = (outerRadius - 6) * Math.sin(startAngle);
                ctx.beginPath();
                ctx.arc(pegX, pegY, 3, 0, 2 * Math.PI);
                ctx.fillStyle = '#ffffff';
                ctx.shadowColor = 'rgba(0,0,0,0.4)';
                ctx.shadowBlur = 3;
                ctx.fill();

                // Teks Nama Kategori
                ctx.save();
                ctx.rotate(startAngle + arc / 2);
                ctx.textAlign = 'right';
                ctx.textBaseline = 'middle';
                ctx.fillStyle = colorSet.text;
                ctx.shadowColor = 'rgba(0, 0, 0, 0.7)';
                ctx.shadowBlur = 4;
                ctx.font = 'bold 15px Poppins, sans-serif';

                // Pemotongan jika teks terlalu panjang
                let text = categories[i];
                if (text.length > 18) {
                    text = text.substring(0, 16) + '..';
                }

                ctx.fillText(text, outerRadius - 20, 0);
                ctx.restore();
            }

            ctx.restore();
        }

        // Gambar roda pertama kali
        drawWheel();

        // Animasi jarum lentur (Pointer Flipper Bounce)
        const pointerEl = document.getElementById('wheelPointer');
        let lastPassedSector = -1;

        function updatePointerPhysics() {
            // Jarum berada di posisi atas (270 derajat atau 1.5 * PI)
            const normalizedAngle = (1.5 * Math.PI - (currentAngle % (2 * Math.PI)) + 2 * Math.PI) % (2 * Math.PI);
            const currentSector = Math.floor(normalizedAngle / arc);

            if (currentSector !== lastPassedSector) {
                lastPassedSector = currentSector;
                playTickSound();

                // Animasi sentakan jarum
                pointerEl.style.transform = 'translateX(-50%) rotate(-18deg)';
                setTimeout(() => {
                    pointerEl.style.transform = 'translateX(-50%) rotate(0deg)';
                }, 60);
            }
        }

        // Fungsi Memutar Roda (Spinning)
        function spinWheel() {
            if (isSpinning) return;

            initAudio();
            isSpinning = true;
            document.getElementById('spinBtn').disabled = true;
            document.getElementById('centerSpinBtn').disabled = true;

            // Tentukan sektor pemenang secara acak
            const targetSector = Math.floor(Math.random() * numSectors);

            // Hitung sudut akhir yang tepat agar mendarat di tengah sektor pemenang
            // Posisi pointer ada di atas (-PI/2)
            const sectorMiddle = (targetSector * arc) + (arc / 2);
            const extraRounds = 5 + Math.floor(Math.random() * 3); // 5 sampai 7 putaran penuh

            // Target sudut akhir
            const targetRotation = (extraRounds * 2 * Math.PI) + (1.5 * Math.PI - sectorMiddle);
            const totalRotation = targetRotation - (currentAngle % (2 * Math.PI)) + (targetRotation < (currentAngle % (2 * Math.PI)) ? 2 * Math.PI : 0);

            const startAngle = currentAngle;
            const finalAngle = startAngle + totalRotation;
            const duration = 4800; // 4.8 detik putaran
            const startTime = performance.now();

            function animate(now) {
                const elapsed = now - startTime;
                const progress = Math.min(elapsed / duration, 1);

                // Easing cubic-bezier deselerasi halus (ease-out-cubic / quart)
                const ease = 1 - Math.pow(1 - progress, 3.8);

                currentAngle = startAngle + (totalRotation * ease);
                drawWheel();
                updatePointerPhysics();

                if (progress < 1) {
                    requestAnimationFrame(animate);
                } else {
                    // Selesai memutar
                    isSpinning = false;
                    document.getElementById('spinBtn').disabled = false;
                    document.getElementById('centerSpinBtn').disabled = false;

                    const winningCategory = categories[targetSector];
                    onWinnerSelected(winningCategory);
                }
            }

            requestAnimationFrame(animate);
        }

        // Aksi Ketika Kategori Terpilih
        function onWinnerSelected(category) {
            playFanfareSound();

            // Efek Ledakan Confetti
            try {
                confetti({
                    particleCount: 80,
                    spread: 70,
                    origin: { y: 0.6 }
                });
                setTimeout(() => {
                    confetti({
                        particleCount: 50,
                        angle: 60,
                        spread: 55,
                        origin: { x: 0 }
                    });
                    confetti({
                        particleCount: 50,
                        angle: 120,
                        spread: 55,
                        origin: { x: 1 }
                    });
                }, 250);
            } catch (e) {}

            // Tampilkan Modal Winner
            const modalEl = document.getElementById('winnerModal');
            const winnerModal = new bootstrap.Modal(modalEl);
            document.getElementById('winnerCategoryName').textContent = category;
            winnerModal.show();

            // Countdown Redirect
            let count = 3;
            const countEl = document.getElementById('countdownRedirect');
            const interval = setInterval(() => {
                count--;
                if (count > 0) {
                    countEl.textContent = `Memulai kuis dalam ${count} detik...`;
                } else {
                    clearInterval(interval);
                    countEl.textContent = `Membuka soal...`;
                    window.location.href = `/quiz/${encodeURIComponent(category)}`;
                }
            }, 1000);
        }

        // Event Listener Tombol Spin
        document.getElementById('spinBtn').addEventListener('click', spinWheel);
        document.getElementById('centerSpinBtn').addEventListener('click', spinWheel);

        // Sound Toggle Listener
        const soundBtn = document.getElementById('btnSound');
        const soundIcon = document.getElementById('soundIcon');
        soundBtn.addEventListener('click', () => {
            soundEnabled = !soundEnabled;
            if (soundEnabled) {
                soundIcon.className = 'bi bi-volume-up-fill';
                soundBtn.title = 'Suara Aktif';
            } else {
                soundIcon.className = 'bi bi-volume-mute-fill';
                soundBtn.title = 'Suara Nonaktif';
            }
        });
    </script>
</body>

</html>
