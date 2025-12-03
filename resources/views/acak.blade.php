<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Acak Kategori</title>
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

        .ketReward {
            position: absolute;
            top: 17px;
            left: 50%;
            transform: translateX(-50%);
            font-weight: 700;
            color: red;
            text-shadow: 0 0 1px white;
            white-space: nowrap;
            z-index: 10;
        }

        .ketAnimasi {
            animation: kelapKelip .6s ease-in-out infinite;
        }

        @keyframes kelapKelip {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body
    style="background-image: url('{{ asset('images/quiz-bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 100vh; position: relative;">

    <div style="text-align: center;">
        <img src="{{ asset('images/c3.svg') }}"
            style="height: 60vh; position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);z-index: 0;opacity: 0.55;animation: rotateCircleCC 15s linear infinite;">
        <img src="{{ asset('images/c2.svg') }}"
            style="height: 60vh; position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);z-index: 0;opacity: 0.35;animation: rotateCircle 12s linear infinite;">
        <img src="{{ asset('images/c1.svg') }}"
            style="height: 60vh; position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);z-index: 0;opacity: 0.25;animation: rotateCircleCC 4s linear infinite;">
    </div>

    <div class="d-flex justify-content-center align-items-center flex-column" style="min-height: 100vh;">
        <div class="" style="width:18rem;">
            <img src="{{ asset('images/diskominfo.png') }}" class="card-img-top" alt="...">
            @if ($totalStok > 0)
                <span class="fs-2 ketReward" style="color: rgb(20, 4, 4);">
                    SISA DOORPRIZE: {{ $totalStok }}
                </span>
            @elseif ($totalStok == 0)
                <span class="fs-2 ketReward ketAnimasi">
                    MOHON MAAF DOORPRIZE SUDAH HABIS
                </span>
            @endif

        </div>

        <br>
        <div class="stage">
            <div id="sphere" class="sphere mt-5"></div>
        </div>
        <br>
        <div class="controls">
            <button id="spinBtn" class="btn-3d mt-5">Acak</button>
        </div>

        <div id="result" class="result-badge"> </div>
    </div>


    <script>
        const categories = ['Pemrograman', 'Artificial Intelligence', 'SuperApps', 'Internet Sehat', 'GOVEM', 'LAPOR!'];
        const sphere = document.getElementById('sphere');
        const spinBtn = document.getElementById('spinBtn');
        const tags = [];
        const R = (parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--size')) || 520) / 2 - 80;

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
                if (isSelected) scaleBase = 1.6;
                if (isDim) scaleBase = 0.55;

                t.el.style.transform = `translate3d(${tx}px,${ty}px,${tz}px) translate(-50%,-50%) scale(${scaleBase})`;
                t.el.style.opacity = Math.max(.45, .6 + z2 / (R * 2));
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

        function spinAndPick(duration = 2200) {
            // reset highlight ketika spin dimulai
            if (lastSelected !== null) {
                tags[lastSelected].el.classList.remove('selected');
                lastSelected = null;
            }

            // hilangkan dim pada semua tag
            tags.forEach(tag => tag.el.classList.remove('dim'));

            const startVX = velX,
                startVY = velY;
            velX = (Math.random() * 0.012 + 0.008) * (Math.random() < 0.5 ? -1 : 1);
            velY = (Math.random() * 0.012 + 0.008) * (Math.random() < 0.5 ? -1 : 1);
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
            }, 1600);



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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>
