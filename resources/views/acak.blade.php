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
            width: 700px;
            height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(245, 159, 0, 0.12) 0%, rgba(99, 102, 241, 0.08) 45%, transparent 70%);
            pointer-events: none;
            z-index: 1;
            animation: pulseAura 4s ease-in-out infinite alternate;
        }

        @keyframes pulseAura {
            from { transform: translate(-50%, -50%) scale(0.92); opacity: 0.7; }
            to { transform: translate(-50%, -50%) scale(1.08); opacity: 1; }
        }

        /* Lingkaran Gyroscope Cyber (c1, c2, c3) dengan filter glow */
        .ambient-rings-wrapper {
            position: absolute;
            top: 52%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .ring-c3 {
            position: absolute;
            height: 68vh;
            opacity: 0.38;
            filter: drop-shadow(0 0 25px rgba(245, 159, 0, 0.3));
            animation: rotateCircleCC 22s linear infinite;
        }

        .ring-c2 {
            position: absolute;
            height: 62vh;
            opacity: 0.28;
            filter: drop-shadow(0 0 20px rgba(59, 130, 246, 0.25));
            animation: rotateCircle 16s linear infinite;
        }

        .ring-c1 {
            position: absolute;
            height: 54vh;
            opacity: 0.22;
            filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.2));
            animation: rotateCircleCC 8s linear infinite;
        }

        @keyframes rotateCircle {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes rotateCircleCC {
            from { transform: rotate(0deg); }
            to { transform: rotate(-360deg); }
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

        /* Tag 3D Kategori Berputar */
        .tag {
            --x: 0px;
            --y: 0px;
            --z: 0px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform-style: preserve-3d;
            transform: translate3d(var(--x), var(--y), var(--z)) translate(-50%, -50%);
            padding: 10px 20px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            color: #1e293b;
            font-weight: 700;
            white-space: nowrap;
            cursor: pointer;
            user-select: none;
            transition: transform 250ms cubic-bezier(.2, .9, .2, 1), background 250ms, box-shadow 250ms, color 250ms;
            font-size: 19px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }

        /* Tag Terpilih (Selected / Winner) */
        .tag.selected {
            font-size: 1.85rem !important;
            font-weight: 800;
            color: #ffffff !important;
            opacity: 1 !important;
            padding: 12px 28px;
            border-radius: 16px;
            background: linear-gradient(135deg, #f59f00 0%, #d97706 100%) !important;
            border: 2px solid #ffd43b !important;
            box-shadow: 0 0 35px rgba(245, 159, 0, 0.8), 0 12px 30px rgba(0, 0, 0, 0.6) !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            z-index: 9999 !important;
        }

        .tag.dim {
            opacity: 0.22 !important;
            transform: scale(.52) !important;
            filter: blur(1px);
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

    <!-- Lingkaran Gyroscope Cyber Berputar (c1, c2, c3) -->
    <div class="ambient-rings-wrapper">
        <img src="{{ asset('images/c3.svg') }}" class="ring-c3" alt="">
        <img src="{{ asset('images/c2.svg') }}" class="ring-c2" alt="">
        <img src="{{ asset('images/c1.svg') }}" class="ring-c1" alt="">
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

    <script>
        // Kategori dinamis dari database (fallback ke kategori default jika DB kosong)
        const categories = @json($categories);

        const sphere = document.getElementById('sphere');
        const spinBtn = document.getElementById('spinBtn');
        const tags = [];
        const R = (parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--size')) || 540) / 2 - 80;

        function createTags() {
            const n = categories.length;
            for (let i = 0; i < n; i++) {
                const el = document.createElement('div');
                el.className = 'tag';
                el.textContent = categories[i];
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
                if (isSelected) scaleBase = 1.8;
                if (isDim) scaleBase = 0.52;

                t.el.style.transform = `translate3d(${tx}px,${ty}px,${tz}px) translate(-50%,-50%) scale(${scaleBase})`;
                t.el.style.opacity = Math.max(.45, .65 + z2 / (R * 2));
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

            setTimeout(() => {
                tags.forEach(tag => tag.el.classList.remove('dim'));

                const kategori = t.el.textContent;
                window.location.href = `/quiz/${encodeURIComponent(kategori)}`;
            }, 1800);
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
