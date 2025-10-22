<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد کاربری - منطقه هیجان</title>

    <!-- Vazir Font -->
    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box; font-family: 'Vazir', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #0a0e27 0%, #1a1a2e 50%, #16213e 100%);
            color: #fff; min-height: 100vh; position: relative;
        }

        /* Dashboard Layout */
        .dashboard-container { display: flex; min-height: 100vh; }

        /* Sidebar Styles */
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
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-align: center;
        }
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-item { margin-bottom: 0.8rem; }
        .sidebar-link {
            display: flex; align-items: center; padding: 0.8rem 1rem;
            color: #00ffff; text-decoration: none; border-radius: 10px; transition: all 0.3s; position: relative; overflow: hidden;
        }
        .sidebar-link:hover { background: linear-gradient(135deg, rgba(0, 255, 255, 0.15), rgba(255, 0, 255, 0.15)); color: #ff00ff; transform: translateX(-5px); }
        .sidebar-link.active { background: linear-gradient(135deg, rgba(0, 255, 255, 0.25), rgba(255, 0, 255, 0.25)); color: #fff; }
        .sidebar-link i { margin-left: 0.8rem; font-size: 1.2rem; }

        /* Main Content Area */
        .main-content { flex: 1; margin-right: 280px; padding: 2rem; position: relative; z-index: 1; }

        /* Dashboard Header */
        .dashboard-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(0, 255, 255, 0.2);
        }
        .user-profile { display: flex; align-items: center; gap: 1rem; }
        .user-avatar {
            width: 50px; height: 50px; border-radius: 50%;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 255, 255, 0.4);
        }
        .user-info h3 { margin-bottom: 0.2rem; font-size: 1.2rem; }
        .user-info small { color: rgba(255, 255, 255, 0.6); font-size: 0.9rem; }

        .btn-neon {
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            color: #0b0f2b; border: none; border-radius: 12px; padding: .6rem 1rem; font-weight: 700;
            box-shadow: 0 8px 24px rgba(0, 255, 255, 0.25); transition: all .25s;
        }
        .btn-neon:hover { transform: translateY(-2px); filter: brightness(1.05); }

        /* Stats Cards */
        .stats-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem; margin-bottom: 2rem;
        }
        .stat-card {
            background: linear-gradient(135deg, rgba(15, 25, 50, 0.95), rgba(30, 20, 60, 0.95));
            border-radius: 15px; padding: 1.5rem; border: 2px solid rgba(0, 255, 255, 0.3);
            transition: all 0.3s; position: relative; overflow: hidden;
        }
        .stat-card:hover { transform: translateY(-5px); border-color: rgba(255, 0, 255, 0.5); box-shadow: 0 10px 30px rgba(255, 0, 255, 0.3); }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.1), rgba(255, 0, 255, 0.1)); opacity: 0; transition: opacity 0.3s;
        }
        .stat-card:hover::before { opacity: 1; }
        .stat-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .stat-icon {
            width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #00ffff, #ff00ff);
            display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        }
        .stat-title { font-size: 1.1rem; color: rgba(255, 255, 255, 0.8); }
        .stat-value {
            font-size: 2rem; font-weight: bold; background: linear-gradient(135deg, #00ffff, #ff00ff);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 0.5rem;
        }
        .stat-sub { font-size: .9rem; color: rgba(255,255,255,.75); }

        /* Cards / Sections */
        .card-soft {
            background: linear-gradient(135deg, rgba(15, 25, 50, 0.95), rgba(30, 20, 60, 0.95));
            border-radius: 15px; padding: 1.25rem; border: 2px solid rgba(0, 255, 255, 0.2);
            margin-bottom: 1.5rem;
        }
        .section-title {
            font-size: 1.1rem; font-weight: 800;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .badge-soft {
            background: rgba(0,255,255,.15); border: 1px solid rgba(0,255,255,.35); color: #aef; border-radius: 999px;
        }

        /* Recent Activity */
        .activity-card { background: linear-gradient(135deg, rgba(15, 25, 50, 0.95), rgba(30, 20, 60, 0.95)); border-radius: 15px; padding: 1.5rem; border: 2px solid rgba(0, 255, 255, 0.3); }
        .activity-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .activity-title { font-size: 1.2rem; font-weight: bold; background: linear-gradient(135deg, #00ffff, #ff00ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .activity-list { list-style: none; padding: 0; }
        .activity-item { display: flex; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .activity-item:last-child { border-bottom: none; }
        .activity-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #00ffff, #ff00ff); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .activity-content h4 { font-size: 1rem; margin-bottom: 0.3rem; }
        .activity-content p { color: rgba(255, 255, 255, 0.7); font-size: 0.9rem; margin-bottom: 0; }
        .activity-time { color: #00ffaa; font-size: 0.8rem; }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none; background: linear-gradient(135deg, #00ffff, #ff00ff); border: none;
            width: 50px; height: 50px; border-radius: 12px; color: #fff; font-size: 1.5rem;
            position: fixed; bottom: 1rem; right: 1rem; z-index: 1000; box-shadow: 0 5px 20px rgba(0, 255, 255, 0.4);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { width: 240px; }
            .main-content { margin-right: 240px; }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-right: 0; padding: 1rem; }
            .mobile-menu-btn { display: flex; align-items: center; justify-content: center; }
            .dashboard-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
        }
        @media (max-width: 576px) {
            .stats-grid { grid-template-columns: 1fr; }
            .user-profile { flex-direction: column; align-items: flex-start; }
        }

        /* Forms in modals */
        .form-help { font-size: .85rem; color: #a7f3d0; }
        .divider {
            height: 1px; background: linear-gradient(90deg, rgba(0,255,255,.15), rgba(255,0,255,.15)); margin: 1rem 0;
        }
    </style>
</head>
<body>
<!-- Dashboard Container -->
<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2 class="sidebar-title">منطقه هیجان</h2>
        </div>
        <nav>
            <ul class="sidebar-menu">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link active" data-section="dashboard">
                        <i class="bi bi-speedometer2"></i>
                        داشبورد
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" data-section="my-games">
                        <i class="bi bi-controller"></i>
                        بازی‌های من
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" data-section="wallet">
                        <i class="bi bi-wallet2"></i>
                        کیف پول
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" data-section="transactions">
                        <i class="bi bi-clock-history"></i>
                        تاریخچه تراکنش‌ها
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" data-section="profile">
                        <i class="bi bi-person"></i>
                        پروفایل کاربری
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" data-section="settings">
                        <i class="bi bi-gear"></i>
                        تنظیمات
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-box-arrow-left"></i>
                        خروج
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Dashboard Header -->
        <header class="dashboard-header">
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="bi bi-person"></i>
                </div>
                <div class="user-info">
                    <h3 id="userFullName">امین احمدی</h3>
                    <small>سطح کاربری: <span class="badge badge-soft px-3 py-1">طلایی</span></small>
                </div>
            </div>
            <div class="header-actions d-flex gap-2">
                <button class="btn btn-neon" data-bs-toggle="modal" data-bs-target="#purchaseModal">
                    <i class="bi bi-cart-plus"></i>
                    خرید/تمدید اشتراک
                </button>
                <button class="btn btn-outline-info border-0" id="swapRequestBtnHeader" data-bs-toggle="modal" data-bs-target="#swapModal" disabled>
                    <i class="bi bi-arrow-repeat"></i>
                    ثبت درخواست تعویض
                </button>
            </div>
        </header>

        <!-- Profile completion alert -->
        <div id="profileAlert" class="alert alert-warning border-0 text-dark d-none" role="alert" style="background: #fff7d6;">
            <strong>تکمیل پروفایل:</strong> لطفاً اطلاعات پروفایل خود را کامل کنید تا روند خرید و پشتیبانی سریع‌تر انجام شود.
            <a href="#" class="alert-link" data-section="profile" id="gotoProfileLink">رفتن به پروفایل</a>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">پلن فعال</h3>
                    <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
                </div>
                <div class="stat-value" id="activePlanName">—</div>
                <div class="stat-sub">
                    تعویض مجاز هر <span id="swapIntervalText">—</span> روز • مجاز به انتخاب
                    <span id="maxGamesText">—</span> بازی
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">زمان تا تعویض بعدی</h3>
                    <div class="stat-icon"><i class="bi bi-arrow-repeat"></i></div>
                </div>
                <div class="stat-value" id="swapCountdown">—</div>
                <div class="stat-sub">در تاریخ <span id="nextSwapDateText">—</span> قابل ثبت است</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">زمان تا پایان اشتراک</h3>
                    <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
                </div>
                <div class="stat-value" id="expireCountdown">—</div>
                <div class="stat-sub">تاریخ پایان: <span id="endDateText">—</span></div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <h3 class="stat-title">اعتبار کیف پول</h3>
                    <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
                </div>
                <div class="stat-value" id="walletBalance">۲۵۰,۰۰۰ تومان</div>
                <div class="stat-sub">آخرین تغییر: ۱۰۰,۰۰۰ تومان افزایش</div>
            </div>
        </div>

        <!-- Sections -->
        <section id="section-dashboard">
            <!-- Subscription Summary -->
            <div class="card-soft">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="section-title m-0">خلاصه اشتراک</h3>
                    <span class="badge badge-soft px-3 py-1" id="durationBadge">—</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background: rgba(0,255,255,.07); border: 1px solid rgba(0,255,255,.2)">
                            <div class="mb-1 text-info">بازی‌های انتخابی</div>
                            <ul class="mb-0" id="selectedGamesList"></ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background: rgba(255,0,255,.07); border: 1px solid rgba(255,0,255,.2)">
                            <div class="mb-1 text-info">تاریخ‌ها</div>
                            <div>تاریخ شروع: <span id="startDateText">—</span></div>
                            <div>آخرین تعویض: <span id="lastSwapDateText">—</span></div>
                            <div>تعویض بعدی: <span id="nextSwapDateText2">—</span></div>
                        </div>
                    </div>
                </div>

                <div class="divider"></div>
                <div class="d-flex gap-2">
                    <button class="btn btn-neon" data-bs-toggle="modal" data-bs-target="#swapModal" id="swapRequestBtn" disabled>
                        <i class="bi bi-arrow-repeat"></i> ثبت درخواست تعویض
                    </button>
                    <button class="btn btn-outline-info border-0" data-bs-toggle="modal" data-bs-target="#purchaseModal">
                        <i class="bi bi-cart-plus"></i> تمدید یا ارتقا
                    </button>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="activity-card">
                <div class="activity-header">
                    <h3 class="activity-title">فعالیت‌های اخیر</h3>
                    <a href="#" class="text-light">مشاهده همه</a>
                </div>
                <ul class="activity-list" id="activityList">
                    <!-- نمونه‌های اولیه — می‌تونی با API پر کنی -->
                    <li class="activity-item">
                        <div class="activity-icon"><i class="bi bi-controller"></i></div>
                        <div class="activity-content">
                            <h4>شروع بازی Call of Duty</h4>
                            <p>شما بازی Call of Duty را شروع کردید</p>
                            <div class="activity-time">۲ ساعت پیش</div>
                        </div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon"><i class="bi bi-wallet2"></i></div>
                        <div class="activity-content">
                            <h4>افزایش اعتبار کیف پول</h4>
                            <p>مبلغ ۱۰۰,۰۰۰ تومان به کیف پول شما اضافه شد</p>
                            <div class="activity-time">۱ روز پیش</div>
                        </div>
                    </li>
                    <li class="activity-item">
                        <div class="activity-icon"><i class="bi bi-trophy"></i></div>
                        <div class="activity-content">
                            <h4>کسب امتیاز جدید</h4>
                            <p>۵۰ امتیاز برای تکمیل چالش دریافت کردید</p>
                            <div class="activity-time">۲ روز پیش</div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <!-- My Games Section -->
        <section id="section-my-games" class="d-none">
            <div class="card-soft">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="section-title m-0">بازی‌های من</h3>
                    <button class="btn btn-neon" data-bs-toggle="modal" data-bs-target="#swapModal" id="swapRequestBtn2" disabled>
                        <i class="bi bi-arrow-repeat"></i> تعویض بازی
                    </button>
                </div>
                <div id="gamesCards" class="row g-3"></div>
            </div>
        </section>

        <!-- Wallet Section (placeholder) -->
        <section id="section-wallet" class="d-none">
            <div class="card-soft">
                <h3 class="section-title mb-3">کیف پول</h3>
                <p class="mb-0">این بخش به درگاه پرداخت و API متصل می‌شود.</p>
            </div>
        </section>

        <!-- Transactions Section (placeholder) -->
        <section id="section-transactions" class="d-none">
            <div class="card-soft">
                <h3 class="section-title mb-3">تاریخچه تراکنش‌ها</h3>
                <p class="mb-0">در اینجا لیست تراکنش‌ها نمایش داده می‌شود.</p>
            </div>
        </section>

        <!-- Profile Section (placeholder) -->
        <section id="section-profile" class="d-none">
            <div class="card-soft">
                <h3 class="section-title mb-3">پروفایل کاربری</h3>
                <form class="row g-3" id="profileForm">
                    <div class="col-md-6">
                        <label class="form-label">نام و نام خانوادگی</label>
                        <input type="text" class="form-control" id="profileName" placeholder="مثلاً: امین احمدی">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">شماره موبایل</label>
                        <input type="tel" class="form-control" id="profilePhone" placeholder="09xxxxxxxxx" inputmode="numeric">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">ایمیل</label>
                        <input type="email" class="form-control" id="profileEmail" placeholder="you@example.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">آی‌دی پلی‌استیشن (اختیاری)</label>
                        <input type="text" class="form-control" id="profilePSN" placeholder="PSN ID">
                    </div>
                    <div class="col-12">
                        <button class="btn btn-neon" type="button" id="saveProfileBtn"><i class="bi bi-check2-circle"></i> ذخیره</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Settings Section (placeholder) -->
        <section id="section-settings" class="d-none">
            <div class="card-soft">
                <h3 class="section-title mb-3">تنظیمات</h3>
                <p class="mb-0">تنظیمات اعلان‌ها، تم و …</p>
            </div>
        </section>
    </main>

    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
</div>

<!-- Purchase / Renew Modal -->
<div class="modal fade" id="purchaseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content bg-dark text-white border-0" style="background: #0e1333;">
            <div class="modal-header border-0">
                <h5 class="modal-title">خرید/تمدید اشتراک</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Plan selection -->
                <div class="mb-3">
                    <label class="form-label">انتخاب پلن</label>
                    <div class="row g-2" id="planRadios">
                        <!-- رادیوها با JS تولید می‌شوند -->
                    </div>
                    <div class="form-help mt-1">پلن‌ها و محدودیت‌ها از کانفیگ خوانده می‌شوند.</div>
                </div>
                <!-- Duration -->
                <div class="mb-3">
                    <label class="form-label">مدت زمان</label>
                    <select id="durationSelect" class="form-select"></select>
                </div>
                <!-- Game Inputs -->
                <div class="mb-3">
                    <label class="form-label">بازی‌های انتخابی</label>
                    <div id="gameInputs" class="row g-2">
                        <!-- فیلدها بر اساس پلن/تعداد بازی پویا ایجاد می‌شوند -->
                    </div>
                    <div class="form-help mt-1">بر اساس پلن، تعداد فیلدها به‌صورت خودکار ایجاد می‌شود.</div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                <button class="btn btn-neon" id="confirmPurchaseBtn"><i class="bi bi-check2-circle"></i> تایید خرید/تمدید</button>
            </div>
        </div>
    </div>
</div>

<!-- Swap Modal -->
<div class="modal fade" id="swapModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content bg-dark text-white border-0" style="background: #0e1333;">
            <div class="modal-header border-0">
                <h5 class="modal-title">ثبت درخواست تعویض بازی</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info text-dark" id="swapInfoAlert">
                    می‌توانید تا <strong id="swapMaxGamesText">—</strong> بازی در این پلن داشته باشید. نام بازی‌های جدید را وارد کنید.
                </div>
                <div class="mb-3">
                    <label class="form-label">بازی‌های فعلی</label>
                    <div id="currentGamesBadges"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">لیست جدید بازی‌ها (حداکثر به تعداد مجاز پلن)</label>
                    <div id="swapGameInputs" class="row g-2"></div>
                    <div class="form-help">برای حذف یک بازی، فیلد مربوطه را خالی بگذارید.</div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                <button class="btn btn-neon" id="confirmSwapBtn"><i class="bi bi-arrow-repeat"></i> ثبت درخواست</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* =========================
       CONFIG & MOCKED STATE
       ========================= */
    // پیکربندی پلن‌ها (قابل تغییر)
    const PLANS = {
        lite:   { key:'lite',   label:'Thrill Lite',   maxGames:2, durations:[3,6,12], swapIntervalDays:30 },
        silver: { key:'silver', label:'Thrill Silver', maxGames:3, durations:[3,6,12], swapIntervalDays:30 },
        pro:    { key:'pro',    label:'Thrill Pro',    maxGames:5, durations:[3,6,12], swapIntervalDays:30 },
        max:    { key:'max',    label:'Thrill Max',    maxGames:7, durations:[6,12],   swapIntervalDays:15 } // ← تعداد بازی مجاز را اینجا تغییر بده
    };

    // وضعیت نمونه (در عمل از API بگیر)
    let profileCompleted = false; // اگر پروفایل ناقص باشد، هشدار نشان داده می‌شود
    const user = {
        fullName: 'امین احمدی',
        wallet: 250000
    };

    // اشتراک فعال نمونه
    let activeSubscription = {
        planKey: 'silver',            // lite | silver | pro | max
        durationMonths: 6,            // 3 | 6 | 12 (برای max فقط 6 یا 12)
        startDate: '2025-08-20',      // YYYY-MM-DD
        lastSwapDate: '2025-09-20',   // تاریخ آخرین تعویض (اگر null باشد از startDate محاسبه می‌شود)
        games: ['Call of Duty', 'FIFA 24', 'The Last of Us'] // باید ≤ maxGames پلن باشد
    };

    /* =========================
       HELPERS
       ========================= */
    const toFa = (n) => (typeof n === 'number' ? n.toLocaleString('fa-IR') : n);
    const fmtDateFa = (d) => new Date(d).toLocaleDateString('fa-IR', { year:'numeric', month:'long', day:'numeric' });
    const addDays = (dateStr, days) => {
        const d = new Date(dateStr + 'T00:00:00');
        d.setDate(d.getDate() + days);
        return d.toISOString().slice(0,10);
    };
    const addMonths = (dateStr, months) => {
        const d = new Date(dateStr + 'T00:00:00');
        d.setMonth(d.getMonth() + months);
        return d.toISOString().slice(0,10);
    };
    const diffMs = (a, b) => (new Date(a) - new Date(b));
    const nowISO = () => {
        // زمان کاربر اروپا/برلین — برای فرانت، زمان محلی مرورگر استفاده می‌شود
        const d = new Date();
        return new Date(d.getTime() - d.getMilliseconds()).toISOString();
    };

    const getPlan = (key) => PLANS[key];
    const clamp = (val, min, max) => Math.max(min, Math.min(max, val));

    /* =========================
       RENDER DASHBOARD
       ========================= */
    function renderAll() {
        // پروفایل
        document.getElementById('userFullName').textContent = user.fullName;
        document.getElementById('walletBalance').textContent = toFa(user.wallet) + ' تومان';
        document.getElementById('profileAlert').classList.toggle('d-none', profileCompleted);

        // اشتراک
        const plan = getPlan(activeSubscription.planKey);
        document.getElementById('activePlanName').textContent = plan ? plan.label : '—';
        document.getElementById('swapIntervalText').textContent = plan ? toFa(plan.swapIntervalDays) : '—';
        document.getElementById('maxGamesText').textContent = plan ? toFa(plan.maxGames) : '—';
        document.getElementById('durationBadge').textContent = `مدت ${toFa(activeSubscription.durationMonths)} ماهه`;

        // تاریخ‌ها
        const start = activeSubscription.startDate;
        const end = addMonths(start, activeSubscription.durationMonths);
        const lastSwap = activeSubscription.lastSwapDate || start;
        const nextSwap = addDays(lastSwap, plan.swapIntervalDays);

        document.getElementById('startDateText').textContent = fmtDateFa(start);
        document.getElementById('endDateText').textContent   = fmtDateFa(end);
        document.getElementById('lastSwapDateText').textContent = fmtDateFa(lastSwap);
        document.getElementById('nextSwapDateText').textContent  = fmtDateFa(nextSwap);
        document.getElementById('nextSwapDateText2').textContent = fmtDateFa(nextSwap);

        // بازی‌ها
        const listEl = document.getElementById('selectedGamesList');
        listEl.innerHTML = '';
        activeSubscription.games.forEach(g => {
            const li = document.createElement('li');
            li.textContent = g;
            listEl.appendChild(li);
        });

        // کارت‌های بازی در تب «بازی‌های من»
        renderGameCards();

        // دکمه‌های تعویض
        const eligible = new Date() >= new Date(nextSwap);
        ['swapRequestBtn', 'swapRequestBtn2', 'swapRequestBtnHeader'].forEach(id => {
            const btn = document.getElementById(id);
            if (btn) btn.disabled = !eligible;
        });

        // شمارنده‌ها
        startCountdowns(nextSwap, end);
    }

    function renderGameCards() {
        const container = document.getElementById('gamesCards');
        container.innerHTML = '';
        activeSubscription.games.forEach((g, idx) => {
            const col = document.createElement('div');
            col.className = 'col-sm-6 col-lg-4';
            col.innerHTML = `
                    <div class="p-3 rounded-3 h-100" style="background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.1)">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="fw-bold">${g}</div>
                            <span class="badge badge-soft px-2">بازی #${toFa(idx+1)}</span>
                        </div>
                        <div class="mt-2 small text-white-50">عضو پلن فعلی</div>
                    </div>
                `;
            container.appendChild(col);
        });
    }

    function startCountdowns(nextSwapISO, endISO) {
        const swapEl = document.getElementById('swapCountdown');
        const expEl  = document.getElementById('expireCountdown');

        function renderTimer(targetISO, el) {
            const ms = new Date(targetISO) - new Date();
            if (ms <= 0) { el.textContent = 'اکنون مجاز'; return; }
            const s = Math.floor(ms / 1000);
            const d = Math.floor(s / 86400);
            const h = Math.floor((s % 86400) / 3600);
            const m = Math.floor((s % 3600) / 60);
            const ss = s % 60;
            el.textContent = `${toFa(d)} روز و ${toFa(h)}:${toFa(m.toString().padStart(2,'0'))}:${toFa(ss.toString().padStart(2,'0'))}`;
        }

        renderTimer(nextSwapISO, swapEl);
        renderTimer(endISO, expEl);
        // تکرار
        if (window._countdownInterval) clearInterval(window._countdownInterval);
        window._countdownInterval = setInterval(() => {
            renderTimer(nextSwapISO, swapEl);
            renderTimer(endISO, expEl);
        }, 1000);
    }

    /* =========================
       NAV / TOGGLE SECTIONS
       ========================= */
    const sections = ['dashboard','my-games','wallet','transactions','profile','settings'];
    document.querySelectorAll('.sidebar-link[data-section]').forEach(a => {
        a.addEventListener('click', (e) => {
            e.preventDefault();
            const target = a.getAttribute('data-section');
            sections.forEach(sec => {
                document.getElementById('section-' + sec).classList.toggle('d-none', sec !== target);
            });
            document.querySelectorAll('.sidebar-link').forEach(x => x.classList.remove('active'));
            a.classList.add('active');
            if (target === 'profile') document.getElementById('profileName').focus();
        });
    });
    document.getElementById('gotoProfileLink').addEventListener('click', (e)=>{
        e.preventDefault();
        document.querySelector('.sidebar-link[data-section="profile"]').click();
    });

    /* =========================
       MOBILE SIDEBAR
       ========================= */
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    sidebarToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
    document.addEventListener('click', (e) => {
        if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) sidebar.classList.remove('active');
    });

    /* =========================
       PURCHASE FLOW (DYNAMIC FORM)
       ========================= */
    const planRadiosContainer = document.getElementById('planRadios');
    const durationSelect = document.getElementById('durationSelect');
    const gameInputs = document.getElementById('gameInputs');
    const confirmPurchaseBtn = document.getElementById('confirmPurchaseBtn');

    function buildPlanRadios(selectedKey = activeSubscription.planKey) {
        planRadiosContainer.innerHTML = '';
        Object.values(PLANS).forEach(pl => {
            const col = document.createElement('div');
            col.className = 'col-12 col-md-6';
            col.innerHTML = `
                    <label class="w-100 p-3 rounded-3" style="cursor:pointer; background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.1)">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="planRadio" value="${pl.key}" ${pl.key===selectedKey?'checked':''}>
                            <span class="fw-bold ms-2">${pl.label}</span>
                        </div>
                        <div class="small mt-2 text-white-50">
                            تعویض هر ${toFa(pl.swapIntervalDays)} روز • حداکثر ${toFa(pl.maxGames)} بازی
                        </div>
                        <div class="small mt-1 text-info">مدت‌های مجاز: ${pl.durations.map(d=>toFa(d)).join(' / ')} ماهه</div>
                    </label>
                `;
            planRadiosContainer.appendChild(col);
        });
    }

    function buildDurationOptions(planKey, selected = activeSubscription.durationMonths) {
        const pl = getPlan(planKey);
        durationSelect.innerHTML = '';
        pl.durations.forEach(d => {
            const opt = document.createElement('option');
            opt.value = d; opt.textContent = toFa(d) + ' ماهه';
            if (d === selected) opt.selected = true;
            durationSelect.appendChild(opt);
        });
    }

    function buildGameFields(count, preset = []) {
        gameInputs.innerHTML = '';
        for (let i=0; i<count; i++) {
            const col = document.createElement('div');
            col.className = 'col-12 col-md-6';
            col.innerHTML = `
                    <input type="text" class="form-control" placeholder="نام بازی ${toFa(i+1)}" value="${preset[i] ? preset[i] : ''}">
                `;
            gameInputs.appendChild(col);
        }
    }

    // init modal on show
    const purchaseModal = document.getElementById('purchaseModal');
    purchaseModal.addEventListener('show.bs.modal', () => {
        buildPlanRadios();
        const selectedPlanKey = document.querySelector('input[name="planRadio"]:checked').value;
        buildDurationOptions(selectedPlanKey);
        const maxGames = getPlan(selectedPlanKey).maxGames;
        // پیش‌فرض: اگر خرید جدید است، از بازی‌های فعلی پر می‌کنیم (تا حد مجاز)
        buildGameFields(maxGames, activeSubscription.games.slice(0, maxGames));
    });

    // plan change handlers
    planRadiosContainer.addEventListener('change', (e) => {
        if (e.target.name === 'planRadio') {
            const k = e.target.value;
            buildDurationOptions(k);
            buildGameFields(getPlan(k).maxGames, []);
        }
    });

    confirmPurchaseBtn.addEventListener('click', () => {
        const selectedPlanKey = document.querySelector('input[name="planRadio"]:checked').value;
        const newDuration = parseInt(durationSelect.value, 10);
        const maxGames = getPlan(selectedPlanKey).maxGames;

        const newGames = Array.from(gameInputs.querySelectorAll('input'))
            .map(x => x.value.trim()).filter(Boolean).slice(0, maxGames);

        if (newGames.length === 0) {
            alert('حداقل نام یک بازی را وارد کنید.');
            return;
        }

        // به صورت نمونه: اشتراک فعال را به روز می‌کنیم (در عمل باید API صدا بزنید)
        activeSubscription = {
            planKey: selectedPlanKey,
            durationMonths: newDuration,
            startDate: new Date().toISOString().slice(0,10),
            lastSwapDate: null,
            games: newGames
        };

        renderAll();
        const modal = bootstrap.Modal.getInstance(purchaseModal);
        modal.hide();
    });

    /* =========================
       SWAP FLOW
       ========================= */
    const swapModal = document.getElementById('swapModal');
    const currentGamesBadges = document.getElementById('currentGamesBadges');
    const swapGameInputs = document.getElementById('swapGameInputs');
    const confirmSwapBtn = document.getElementById('confirmSwapBtn');
    const swapMaxGamesText = document.getElementById('swapMaxGamesText');

    swapModal.addEventListener('show.bs.modal', () => {
        const plan = getPlan(activeSubscription.planKey);
        swapMaxGamesText.textContent = toFa(plan.maxGames);

        // نشان دادن بازی‌های فعلی
        currentGamesBadges.innerHTML = '';
        activeSubscription.games.forEach(g => {
            const span = document.createElement('span');
            span.className = 'badge badge-soft me-1 mb-1 px-3 py-2';
            span.textContent = g;
            currentGamesBadges.appendChild(span);
        });

        // فیلدهای جدید (حداکثر به تعداد مجاز پلن)
        swapGameInputs.innerHTML = '';
        for (let i=0; i<plan.maxGames; i++) {
            const col = document.createElement('div');
            col.className = 'col-12 col-md-6';
            const preset = activeSubscription.games[i] || '';
            col.innerHTML = `<input type="text" class="form-control" value="${preset}" placeholder="نام بازی ${toFa(i+1)}">`;
            swapGameInputs.appendChild(col);
        }

        // بررسی مجاز بودن — اگر هنوز زمانش نرسیده، دکمه غیرفعال بماند
        const nextSwap = addDays(activeSubscription.lastSwapDate || activeSubscription.startDate, plan.swapIntervalDays);
        const eligible = new Date() >= new Date(nextSwap);
        confirmSwapBtn.disabled = !eligible;
        document.getElementById('swapInfoAlert').classList.toggle('alert-danger', !eligible);
        document.getElementById('swapInfoAlert').innerHTML = eligible
            ? 'الان مجاز به ثبت درخواست تعویض هستید. لطفاً لیست جدید بازی‌ها را تایید کنید.'
            : `در حال حاضر مجاز به تعویض نیستید. تاریخ مجاز بعدی: <strong>${fmtDateFa(nextSwap)}</strong>`;
    });

    confirmSwapBtn.addEventListener('click', () => {
        const plan = getPlan(activeSubscription.planKey);
        const newGames = Array.from(swapGameInputs.querySelectorAll('input'))
            .map(i => i.value.trim()).filter(Boolean).slice(0, plan.maxGames);

        if (newGames.length === 0) {
            alert('حداقل نام یک بازی را برای لیست جدید وارد کنید.');
            return;
        }

        // به‌روزرسانی محلی (در عمل: ایجاد رکورد Request و تایید ادمین)
        activeSubscription.games = newGames;
        activeSubscription.lastSwapDate = new Date().toISOString().slice(0,10);

        renderAll();
        const modal = bootstrap.Modal.getInstance(swapModal);
        modal.hide();
    });

    /* =========================
       PROFILE SAVE (MOCK)
       ========================= */
    document.getElementById('saveProfileBtn').addEventListener('click', () => {
        const name = document.getElementById('profileName').value.trim();
        if (name) user.fullName = name;
        profileCompleted = true;
        renderAll();
        alert('پروفایل با موفقیت ذخیره شد.');
    });

    /* =========================
       INIT
       ========================= */
    window.addEventListener('DOMContentLoaded', () => {
        renderAll();
    });
</script>
</body>
</html>
