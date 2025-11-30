<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon-32x32.png') }}">
    <title>@yield('title', 'منطقه هیجان')</title>

    <!-- فونت وزیر -->
    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Vazir', sans-serif; }

        :root {
            --c-primary: #ff004d;
            --c-secondary: #a10035;
            --c-accent: #ff6f00;
            --c-panel: rgba(255, 255, 255, 0.03);
            --c-border: rgba(255, 255, 255, 0.08);
            --c-text-muted: rgba(255, 255, 255, 0.75);
        }

        body {
            background:
                radial-gradient(circle at 20% 20%, rgba(255, 0, 77, 0.13), transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(161, 0, 53, 0.15), transparent 55%),
                radial-gradient(circle at 50% 50%, rgba(255, 111, 0, 0.08), transparent 60%),
                #000;
            color: #fff; min-height: 100vh; position: relative;
        }
        .dashboard-container { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, rgba(13, 13, 13, 0.95), rgba(25, 3, 21, 0.92));
            backdrop-filter: blur(30px);
            border-left: 2px solid transparent;
            border-image: linear-gradient(180deg, rgba(255,0,77,0.8), rgba(161,0,53,0.6)) 1;
            padding: 1.5rem 1rem; box-shadow: 10px 0 40px rgba(0, 0, 0, 0.55);
            position: fixed; height: 100vh; transition: all 0.4s; z-index: 1000;
        }
        .sidebar-header { padding-bottom: 1.5rem; border-bottom: 1px solid rgba(255, 0, 77, 0.2); margin-bottom: 1.5rem; }
        .sidebar-title {
            font-size: 1.5rem; font-weight: bold;
            background: linear-gradient(135deg, var(--c-primary), var(--c-secondary));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            text-align: center;
        }
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-link {
            display: flex; align-items: center; padding: 0.8rem 1rem;
            color: var(--c-text-muted); text-decoration: none; border-radius: 10px;
            transition: all 0.3s; position: relative;
        }
        .sidebar-link i { margin-left: 0.8rem; font-size: 1.2rem; }
        .sidebar-link:hover {
            background: linear-gradient(135deg, rgba(255, 0, 77, 0.18), rgba(161, 0, 53, 0.15));
            color: #fff; transform: translateX(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.35);
        }
        .sidebar-link.active {
            background: linear-gradient(135deg, rgba(255, 0, 77, 0.3), rgba(255, 111, 0, 0.25));
            color: #fff;
            border: 1px solid rgba(255, 111, 0, 0.3);
        }

        /* Main */
        .main-content { flex: 1; margin-right: 280px; padding: 2rem; position: relative; }
        .dashboard-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(255, 0, 77, 0.2);
        }
        .user-avatar {
            width: 50px; height: 50px; border-radius: 50%;
            background: linear-gradient(135deg, var(--c-primary), var(--c-secondary));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; box-shadow: 0 10px 30px rgba(255, 0, 77, 0.4);
        }
        .btn-neon {
            background: linear-gradient(135deg, var(--c-primary), var(--c-secondary));
            color: #000; border: none; border-radius: 12px;
            padding: .6rem 1rem; font-weight: 700;
            box-shadow: 0 8px 30px rgba(255, 0, 77, 0.35);
            transition: all .25s;
        }
        .btn-neon:hover { transform: translateY(-2px); filter: brightness(1.05); }

        /* Responsive */
        @media (max-width: 992px) { .sidebar { width: 240px; } .main-content { margin-right: 240px; } }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-right: 0; padding: 1rem; }
            .mobile-menu-btn { display: flex !important; }
        }
        .mobile-menu-btn {
            display: none;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--c-primary), var(--c-secondary));
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            color: #fff;
            font-size: 1.5rem;
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            z-index: 1000;
            box-shadow: 0 5px 25px rgba(255, 0, 77, 0.4);
        }

        .whatsapp-float {
            position: fixed;
            bottom: 24px;
            left: 24px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff004d 0%, #a10035 100%);
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 30px rgba(255, 0, 77, 0.4);
            z-index: 1200;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .whatsapp-float:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 35px rgba(255, 0, 77, 0.6);
        }

        .whatsapp-float svg {
            width: 26px;
            height: 26px;
            fill: currentColor;
        }
    </style>

    @yield('extra-styles')
</head>

<body>
<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2 class="sidebar-title">منطقه هیجان</h2>
        </div>

        <ul class="sidebar-menu">
            <li><a href="{{ route('user.dashboard') }}" class="sidebar-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> داشبورد</a></li>
            <li><a href="{{ route('user.subscriptions.index') }}" class="sidebar-link {{ request()->routeIs('user.subscriptions.*') ? 'active' : '' }}"><i class="bi bi-grid-3x3-gap"></i> اشتراک‌های من</a></li>
            <li><a href="{{ route('user.transactions') }}" class="sidebar-link {{ request()->routeIs('user.transactions') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> تراکنش‌ها</a></li>
            <li><a href="{{ route('user.games') }}" class="sidebar-link {{ request()->routeIs('user.games') ? 'active' : '' }}"><i class="bi bi-controller"></i> لیست بازی ها</a></li>
            <li class="mt-3">
                <form action="{{ route('user.logout') }}" method="POST">
                    @csrf
                    <button class="sidebar-link w-100 text-start border-0 bg-transparent text-danger">
                        <i class="bi bi-box-arrow-left"></i> خروج
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>
</div>

<!-- Mobile Button -->
<button class="mobile-menu-btn" id="sidebarToggle"><i class="bi bi-list"></i></button>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    sidebarToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
</script>

@stack('modals')
@yield('scripts')
@stack('scripts')

<a href="https://wa.me/989051401029" class="whatsapp-float" target="_blank" rel="noopener" aria-label="چت واتس‌اپ">
    <svg viewBox="0 0 32 32" aria-hidden="true">
        <path d="M16 2.7c-6.97 0-12.63 5.66-12.63 12.63 0 2.22.58 4.39 1.69 6.31L3 29l7.57-1.98c1.85 1 3.94 1.52 6.06 1.52 6.97 0 12.63-5.66 12.63-12.63S22.97 2.7 16 2.7zm0 22.9c-1.86 0-3.7-.5-5.3-1.44l-.38-.23-3.84 1 1.03-3.74-.25-.39A9.85 9.85 0 0 1 6.16 15C6.16 9.97 10.97 5.7 16 5.7s9.84 4.27 9.84 9.3-4.81 9.3-9.84 9.3zm5.27-6.93c-.29-.15-1.71-.85-1.98-.95-.27-.1-.47-.15-.67.15-.2.29-.77.95-.94 1.14-.17.19-.35.22-.64.07-.29-.15-1.23-.45-2.35-1.43-.87-.78-1.46-1.74-1.63-2.03-.17-.29-.02-.45.13-.6.13-.13.29-.35.44-.52.15-.17.2-.29.3-.48.1-.19.05-.36-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.5-.5-.67-.5-.17 0-.36 0-.55.02-.19.02-.52.08-.79.36-.27.29-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.19 2.11 3.22 5.1 4.38.71.31 1.26.5 1.69.64.71.23 1.36.2 1.87.12.57-.08 1.71-.7 1.95-1.37.24-.67.24-1.24.17-1.37-.07-.13-.26-.21-.55-.36z"/>
    </svg>
</a>
</body>
</html>
