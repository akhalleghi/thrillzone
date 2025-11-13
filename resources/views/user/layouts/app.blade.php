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
        body {
            background: linear-gradient(135deg, #0a0e27 0%, #1a1a2e 50%, #16213e 100%);
            color: #fff; min-height: 100vh; position: relative;
        }
        .dashboard-container { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95), rgba(26, 26, 46, 0.95));
            backdrop-filter: blur(30px);
            border-left: 2px solid transparent;
            border-image: linear-gradient(180deg, #00ffff, #ff00ff) 1;
            padding: 1.5rem 1rem; box-shadow: 10px 0 40px rgba(0, 255, 255, 0.1);
            position: fixed; height: 100vh; transition: all 0.4s; z-index: 1000;
        }
        .sidebar-header { padding-bottom: 1.5rem; border-bottom: 1px solid rgba(0, 255, 255, 0.2); margin-bottom: 1.5rem; }
        .sidebar-title {
            font-size: 1.5rem; font-weight: bold;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            text-align: center;
        }
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-link {
            display: flex; align-items: center; padding: 0.8rem 1rem;
            color: #00ffff; text-decoration: none; border-radius: 10px;
            transition: all 0.3s; position: relative;
        }
        .sidebar-link i { margin-left: 0.8rem; font-size: 1.2rem; }
        .sidebar-link:hover {
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.15), rgba(255, 0, 255, 0.15));
            color: #ff00ff; transform: translateX(-5px);
        }
        .sidebar-link.active {
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.25), rgba(255, 0, 255, 0.25));
            color: #fff;
        }

        /* Main */
        .main-content { flex: 1; margin-right: 280px; padding: 2rem; position: relative; }
        .dashboard-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(0, 255, 255, 0.2);
        }
        .user-avatar {
            width: 50px; height: 50px; border-radius: 50%;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; box-shadow: 0 5px 20px rgba(0, 255, 255, 0.4);
        }
        .btn-neon {
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            color: #0b0f2b; border: none; border-radius: 12px;
            padding: .6rem 1rem; font-weight: 700;
            box-shadow: 0 8px 24px rgba(0, 255, 255, 0.25);
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
            background: linear-gradient(135deg, #00ffff, #ff00ff);
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
            box-shadow: 0 5px 20px rgba(0, 255, 255, 0.4);
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
</body>
</html>
