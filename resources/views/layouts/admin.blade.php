<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KOMQ Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0284c7;
            background-image: url('{{ asset('images/quiz-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .admin-wrapper {
            max-width: 1120px;
            width: 92%;
            margin: 0 auto;
            padding: 28px 0 48px 0;
        }

        .admin-navbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            margin-bottom: 26px;
        }

        .btn-3d {
            background: linear-gradient(to bottom, #ffd131 0%, #e3a600 70%);
            border: none;
            border-radius: 24px;
            padding: 9px 22px;
            font-size: 15px;
            font-weight: 700;
            color: #5a3e00;
            cursor: pointer;
            box-shadow: 0px 6px 0px #b78100, 0px 8px 14px rgba(0, 0, 0, 0.25);
            position: relative;
            outline: none;
            transition: transform 0.1s, filter 0.12s, box-shadow 0.1s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-3d::after {
            content: "";
            position: absolute;
            top: 5px;
            left: 12px;
            right: 12px;
            height: 36%;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.45);
        }

        .btn-3d:hover {
            transform: translateY(-1px);
            filter: brightness(0.95);
        }

        .btn-3d:active {
            transform: translateY(3px);
            box-shadow: 0px 3px 0px #b78100, 0px 5px 10px rgba(0, 0, 0, 0.25);
        }

        /* Indikator tombol halaman aktif */
        .btn-3d.active-nav {
            background: linear-gradient(to bottom, #ffffff 0%, #f1f5f9 80%);
            color: #0369a1;
            box-shadow: 0px 6px 0px #cbd5e1, 0px 8px 16px rgba(0, 0, 0, 0.25);
        }

        .btn-3d.active-nav:active {
            box-shadow: 0px 3px 0px #cbd5e1, 0px 5px 10px rgba(0, 0, 0, 0.25);
        }

        .btn-3d.btn-logout {
            background: linear-gradient(to bottom, #f87171 0%, #dc2626 80%);
            color: #ffffff;
            box-shadow: 0px 6px 0px #991b1b, 0px 8px 14px rgba(0, 0, 0, 0.25);
        }

        .btn-3d.btn-logout::after {
            background: rgba(255, 255, 255, 0.28);
        }

        .btn-3d.btn-logout:active {
            box-shadow: 0px 3px 0px #991b1b, 0px 5px 10px rgba(0, 0, 0, 0.25);
        }

        .admin-card {
            width: 100%;
            border: none;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.18);
            overflow: hidden;
            background: #ffffff;
        }

        .admin-card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .admin-card-body {
            padding: 24px;
        }
    </style>

    @yield('styles')
</head>

<body>

    <div class="admin-wrapper">
        <!-- Bar Navigasi Seragam Admin -->
        <nav class="admin-navbar">
            <a href="{{ route('admin.index') }}" class="text-decoration-none">
                <button type="button" class="btn-3d {{ request()->routeIs('admin.index') ? 'active-nav' : '' }}">
                    <i class="bi bi-gift-fill"></i>
                    <span>Reward</span>
                </button>
            </a>

            <a href="{{ route('admin.quiz.index') }}" class="text-decoration-none">
                <button type="button" class="btn-3d {{ request()->routeIs('admin.quiz.*') ? 'active-nav' : '' }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Kelola Soal Kuis</span>
                </button>
            </a>

            <a href="{{ route('admin.participants.index') }}" class="text-decoration-none">
                <button type="button" class="btn-3d {{ request()->routeIs('admin.participants.*') ? 'active-nav' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Peserta ({{ \App\Models\Participant::count() }})</span>
                </button>
            </a>

            <a href="{{ route('admin.features.index') }}" class="text-decoration-none">
                <button type="button" class="btn-3d {{ request()->routeIs('admin.features.*') ? 'active-nav' : '' }}">
                    <i class="bi bi-sliders"></i>
                    <span>Fitur</span>
                </button>
            </a>

            <a href="/logout" class="text-decoration-none ms-auto">
                <button type="button" class="btn-3d btn-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </a>
        </nav>

        <!-- Konten Utama Halaman Admin -->
        @yield('content')
    </div>

    @yield('modals')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>

</html>

