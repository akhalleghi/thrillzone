<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'پنل مدیریت | منطقه هیجان')</title>

    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        :root {
            --bg-1:#0a0e27; --bg-2:#1a1a2e; --bg-3:#16213e;
            --panel:rgba(255,255,255,.06);
            --border:rgba(255,255,255,.14);
            --muted:rgba(255,255,255,.7);
            --grad:linear-gradient(135deg,#00ffff,#ff00ff);
            --text:#fff; --placeholder:rgba(255,255,255,.85);
        }

        [data-theme="light"] {
            --bg-1:#f8faff; --bg-2:#eef3fb; --bg-3:#dee8f3;
            --panel:#fff; --border:#e4e7ec;
            --muted:#4b5563; --text:#0f172a;
            --placeholder:rgba(15,23,42,.6);
        }

        body {
            background:linear-gradient(135deg,var(--bg-1),var(--bg-2) 50%,var(--bg-3));
            color:var(--text);
            font-family:"Vazir",sans-serif;
            direction:rtl;
            overflow-x:hidden;
        }

        .admin-shell {
            display:flex;
            min-height:100vh;
            position:relative;
        }

        /* ================= Sidebar ================= */
        .sidebar {
            width:260px;
            position:fixed;
            top:0;
            right:0;
            height:100vh;
            background:rgba(10,14,39,.95);
            backdrop-filter:blur(16px);
            border-left:2px solid transparent;
            border-image:linear-gradient(180deg,#00ffff,#ff00ff) 1;
            padding:1rem;
            overflow-y:auto;
            z-index:1050;
            transition:transform .35s ease;
            transform:translateX(0);
        }

        [data-theme="light"] .sidebar {background:#fff;}

        .brand {
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:.75rem 0 1rem;
            border-bottom:1px solid var(--border);
        }

        .brand-title {
            font-weight:800;
            font-size:1.1rem;
            background:var(--grad);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }

        .sidebar .nav-link {
            display:flex;
            align-items:center;
            gap:.6rem;
            color:var(--muted);
            border-radius:10px;
            padding:.55rem .8rem;
            transition:.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background:linear-gradient(135deg,rgba(0,255,255,.15),rgba(255,0,255,.15));
            color:var(--text);
        }

        /* ================= Main ================= */
        .main {
            flex:1;
            margin-right:260px;
            transition:margin .35s ease;
        }

        .topbar {
            position:sticky;
            top:0;
            z-index:1000;
            background:rgba(0,0,0,.2);
            backdrop-filter:blur(10px);
            border-bottom:1px solid var(--border);
            padding:.6rem 1rem;
        }

        [data-theme="light"] .topbar {background:#fff;}

        .search-input {
            background:var(--panel);
            border:1px solid var(--border);
            color:var(--text);
        }

        .search-input::placeholder {color:var(--placeholder);}

        .card-glass {
            background:var(--panel);
            border:1px solid var(--border);
            border-radius:14px;
            padding:1rem;
        }

        .section-title {
            background:var(--grad);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            font-weight:800;
        }

        .neon-btn {
            background:var(--grad);
            border:none;
            border-radius:12px;
            color:#0a0e27;
            font-weight:700;
            padding:.55rem 1rem;
            box-shadow:0 0 20px rgba(0,255,255,.25);
            transition:.2s;
        }

        .neon-btn:hover {
            box-shadow:0 0 35px rgba(255,0,255,.4);
            transform:translateY(-1px);
        }

        /* ================= Overlay ================= */
        #overlay {
            position:fixed;
            inset:0;
            background:rgba(0,0,0,0.45);
            z-index:1040;
            animation:fadeIn .3s ease forwards;
        }

        @keyframes fadeIn {
            from {opacity:0;}
            to {opacity:1;}
        }

        /* ================= Responsive ================= */
        @media (max-width: 992px) {
            .sidebar {
                transform:translateX(100%);
            }
            .sidebar.active {
                transform:translateX(0);
                box-shadow:-5px 0 30px rgba(0,0,0,.3);
            }
            .main {
                margin-right:0;
            }
        }

        .modal-content {
  max-height: 90vh;
  overflow-y: auto;
  border-radius: 16px;
}

.modal-body {
  max-height: 70vh;
  overflow-y: auto;
  padding-right: 0.75rem;
}

@media (max-width: 768px) {
  .modal-dialog {
    width: 95% !important;
    margin: 0 auto;
  }
  .modal-body {
    max-height: 65vh;
  }
}
/* ===== حالت کارت در موبایل ===== */
.plan-card {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 14px;
  padding: 1rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.25);
  backdrop-filter: blur(12px);
}

[data-theme="light"] .plan-card {
  background: #fff;
  border-color: #e4e7ec;
}

.plan-card b {
  color: var(--text);
}

.plan-card .badge {
  font-size: 0.75rem;
  padding: 0.35rem 0.5rem;
}

/* فاصله مناسب در موبایل */
@media (max-width: 576px) {
  .plan-card {
    padding: 0.85rem;
    font-size: 0.85rem;
  }
}
.text-muted {
  --bs-text-opacity: 1;
  color: rgba(249, 252, 255, 0.75) !important;
}



    </style>

</head>

<body>
<div class="admin-shell">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-title">مدیریت منطقه هیجان</div>
            <button class="btn btn-sm btn-outline-light d-lg-none" id="closeSidebar"><i class="bi bi-x"></i></button>
        </div>
        <nav class="mt-3 d-grid gap-1">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> داشبورد</a>
            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="bi bi-people"></i> کاربران
            </a>

            <a href="{{ route('admin.games.index') }}"
               class="nav-link {{ request()->routeIs('admin.games.*') ? 'active' : '' }}">
                <i class="bi bi-controller"></i> بازی‌ها
            </a>

            <a href="{{ route('admin.plans') }}" class="nav-link {{ request()->routeIs('admin.plans') ? 'active' : '' }}">
            <i class="bi bi-box"></i> پلن‌ها
            </a>

            <a href="{{ route('admin.subscriptions') }}" class="nav-link {{ request()->routeIs('admin.subscriptions') ? 'active' : '' }}">
            <i class="bi bi-box"></i> اشتراک ها
            </a>

            <a href="{{ route('admin.swap_requests.index') }}" class="nav-link {{ request()->routeIs('admin.swap_requests.index') ? 'active' : '' }}">
            <i class="bi bi-shuffle me-1"></i> درخواست های تعویض
            </a>

            <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.index') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> مدیریت نوبت دهی
            </a>

            <a href="{{ route('admin.finance') }}" class="nav-link {{ request()->routeIs('admin.finance') ? 'active' : '' }}"><i class="bi bi-cash-stack"></i> مالی</a>
            <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="bi bi-gear"></i> تنظیمات</a>
        </nav>
        <div class="mt-4 p-3 card-glass">
            <div class="d-flex align-items-center justify-content-between">
                <span class="fw-bold">حالت نمایش</span>
                <div class="form-check form-switch m-0">
                    <input class="form-check-input" type="checkbox" id="themeSwitch">
                    <label class="form-check-label" for="themeSwitch">روشن</label>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main -->
    <div class="main">
        <header class="topbar">
            <div class="d-flex align-items-center gap-2">
                <button id="openSidebar" class="btn btn-outline-light d-lg-none"><i class="bi bi-list"></i></button>
                <div class="flex-grow-1">
                    <input class="form-control search-input" placeholder="جستجو..." />
                </div>
                <div class="dropdown">
                    <button class="btn btn-link text-light dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-person-circle fs-4"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">مدیر سیستم</h6></li>
                        <li><a class="dropdown-item" href="{{ route('admin.settings') }}">تنظیمات</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#"
                               onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                خروج
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="container-fluid py-3">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById("sidebar");
    const openBtn = document.getElementById("openSidebar");
    const closeBtn = document.getElementById("closeSidebar");

    // باز کردن منو در موبایل
    openBtn?.addEventListener("click", () => {
        sidebar.classList.add("active");
        if (!document.getElementById("overlay")) {
            const overlay = document.createElement("div");
            overlay.id = "overlay";
            document.body.appendChild(overlay);
        }
    });

    // بستن منو با دکمه ×
    closeBtn?.addEventListener("click", closeSidebar);

    // بستن با کلیک روی فضای تیره
    document.addEventListener("click", (e) => {
        if (e.target.id === "overlay") closeSidebar();
    });

    function closeSidebar() {
        sidebar.classList.remove("active");
        document.getElementById("overlay")?.remove();
    }

    // تغییر تم (روشن / تیره)
    const themeSwitch = document.getElementById("themeSwitch");
    const savedTheme = localStorage.getItem("theme") || "dark";
    if (savedTheme === "light") {
        document.documentElement.setAttribute("data-theme", "light");
        themeSwitch.checked = true;
    }
    themeSwitch?.addEventListener("change", () => {
        const mode = themeSwitch.checked ? "light" : "dark";
        document.documentElement.setAttribute("data-theme", mode);
        localStorage.setItem("theme", mode);
    });
</script>

<form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
    @csrf
</form>

@stack('scripts')
</body>
</html>
