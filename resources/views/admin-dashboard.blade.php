<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>پنل مدیریت - منطقه هیجان</title>

    <!-- Fonts & CSS -->
    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        :root{
            --bg-1:#0a0e27; --bg-2:#1a1a2e; --bg-3:#16213e; --panel:rgba(255,255,255,.06);
            --border:rgba(255,255,255,.14); --muted:rgba(255,255,255,.6);
            --grad:linear-gradient(135deg,#00ffff,#ff00ff);
            --text:#fff;
        }
        [data-theme="light"]{
            --bg-1:#f7f9fc; --bg-2:#eef2f8; --bg-3:#e7eef6; --panel:#fff; --border:#e5e7eb; --muted:#4b5563; --text:#0f172a;
        }
        html,body{height:100%}
        body{background:linear-gradient(135deg,var(--bg-1) 0%,var(--bg-2) 50%,var(--bg-3) 100%);color:var(--text);font-family:'Vazir',sans-serif}

        .admin-shell{display:flex;min-height:100vh}

        /* Sidebar */
        .sidebar{width:280px;position:fixed;inset-block:0;inset-inline-end:0;background:rgba(10,14,39,.9);backdrop-filter:blur(24px);border-left:2px solid transparent;border-image:linear-gradient(180deg,#00ffff,#ff00ff) 1;padding:1rem 1rem;overflow-y:auto;z-index:1050}
        [data-theme="light"] .sidebar{background:#fff}
        .brand{display:flex;align-items:center;justify-content:space-between;padding:0.75rem 0 1rem;border-bottom:1px solid var(--border)}
        .brand-title{font-weight:800;font-size:1.2rem;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .sidebar .nav-link{display:flex;align-items:center;gap:.6rem;color:#8be9ff;border-radius:12px;padding:.65rem .8rem}
        .sidebar .nav-link i{font-size:1.15rem}
        .sidebar .nav-link:hover,.sidebar .nav-link.active{background:linear-gradient(135deg,rgba(0,255,255,.15),rgba(255,0,255,.15));color:var(--text)}

        /* Header */
        .main{flex:1;margin-inline-end:280px}
        .topbar{position:sticky;top:0;z-index:1030;background:rgba(0,0,0,.2);backdrop-filter:blur(10px);border-bottom:1px solid var(--border)}
        [data-theme="light"] .topbar{background:#fff}
        .search-input{background:var(--panel);border:1px solid var(--border);color:var(--text)}

        /* Cards */
        .card-glass{background:var(--panel);border:1px solid var(--border);border-radius:16px;padding:1.1rem}
        .card-soft{background:linear-gradient(135deg,rgba(15,25,50,.95),rgba(30,20,60,.95));border:1px solid var(--border);border-radius:16px;padding:1.1rem}
        [data-theme="light"] .card-soft{background:#fff}
        .section-title{background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-weight:800}
        .neon-btn{background:var(--grad);border:none;border-radius:12px;color:#0b0f2b;font-weight:800;padding:.6rem 1rem;box-shadow:0 10px 24px rgba(0,255,255,.25)}
        .badge-soft{background:rgba(0,255,255,.15);border:1px solid rgba(0,255,255,.35);color:#aef;border-radius:999px}

        /* Tables */
        .table-dark{background:transparent}
        .table thead th{border-bottom:1px solid var(--border)}
        .table td,.table th{border-color:var(--border)}

        /* Utilities */
        .muted{color:var(--muted)}
        .divider{height:1px;background:linear-gradient(90deg,rgba(0,255,255,.12),rgba(255,0,255,.12));margin:1rem 0}

        /* Responsive */
        @media (max-width:992px){
            .sidebar{transform:translateX(100%)}
            .sidebar.active{transform:translateX(0)}
            .main{margin-inline-end:0}
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
            <a href="#" class="nav-link active" data-section="dashboard"><i class="bi bi-speedometer2"></i> داشبورد</a>
            <a href="#" class="nav-link" data-section="plans"><i class="bi bi-box"></i> پلن‌ها</a>
            <a href="#" class="nav-link" data-section="users"><i class="bi bi-people"></i> کاربران</a>
            <a href="#" class="nav-link" data-section="subs"><i class="bi bi-card-checklist"></i> اشتراک‌ها</a>
            <a href="#" class="nav-link" data-section="games"><i class="bi bi-controller"></i> بازی‌ها</a>
            <a href="#" class="nav-link" data-section="swaps"><i class="bi bi-arrow-repeat"></i> تعویض‌ها</a>
            <a href="#" class="nav-link" data-section="finance"><i class="bi bi-cash-stack"></i> مالی</a>
            <a href="#" class="nav-link" data-section="notifications"><i class="bi bi-bell"></i> اعلان‌ها</a>
            <a href="#" class="nav-link" data-section="roles"><i class="bi bi-shield-lock"></i> نقش‌ها و دسترسی</a>
            <a href="#" class="nav-link" data-section="settings"><i class="bi bi-gear"></i> تنظیمات</a>
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
        <!-- Topbar -->
        <header class="topbar">
            <div class="container-fluid py-2">
                <div class="d-flex align-items-center gap-2">
                    <button id="openSidebar" class="btn btn-outline-light d-lg-none"><i class="bi bi-list"></i></button>
                    <div class="flex-grow-1">
                        <input class="form-control search-input" placeholder="جستجو در کاربران/پلن‌ها/بازی‌ها..." />
                    </div>
                    <button class="btn btn-link text-light position-relative" data-section="notifications">
                        <i class="bi bi-bell fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-link text-light dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-4"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">مدیر سیستم</h6></li>
                            <li><a class="dropdown-item" href="#" data-section="settings">تنظیمات</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#">خروج</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="container-fluid py-3">
            <!-- Dashboard -->
            <section id="section-dashboard">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="card-glass text-center">
                            <i class="bi bi-people fs-3 text-info"></i>
                            <div class="mt-1 muted">کاربران کل</div>
                            <div class="fs-3 fw-bold">۲۴۵</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card-glass text-center">
                            <i class="bi bi-box fs-3 text-info"></i>
                            <div class="mt-1 muted">تعداد پلن‌ها</div>
                            <div class="fs-3 fw-bold">۴</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card-glass text-center">
                            <i class="bi bi-activity fs-3 text-info"></i>
                            <div class="mt-1 muted">اشتراک‌های فعال</div>
                            <div class="fs-3 fw-bold">۱۶۸</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card-glass text-center">
                            <i class="bi bi-cash-coin fs-3 text-info"></i>
                            <div class="mt-1 muted">درآمد ماه جاری</div>
                            <div class="fs-3 fw-bold">۴,۲۵۰,۰۰۰</div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-lg-8">
                        <div class="card-glass">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="section-title m-0">نمودار درآمد ماهانه</h5>
                                <div class="d-flex gap-2">
                                    <select id="revenueRange" class="form-select form-select-sm w-auto">
                                        <option value="6">۶ ماه اخیر</option>
                                        <option value="12" selected>۱۲ ماه اخیر</option>
                                    </select>
                                </div>
                            </div>
                            <canvas id="revenueChart" height="120"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card-glass h-100">
                            <h5 class="section-title">آخرین درخواست‌های تعویض</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center">
                                    <span>امیر حسینی – Pro</span>
                                    <span class="badge bg-warning text-dark">در انتظار</span>
                                </li>
                                <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center">
                                    <span>نازنین توکلی – Silver</span>
                                    <span class="badge bg-success">تایید شد</span>
                                </li>
                                <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center">
                                    <span>مهدی کاظمی – Lite</span>
                                    <span class="badge bg-danger">رد شد</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-lg-6">
                        <div class="card-glass">
                            <h5 class="section-title">کاربران جدید</h5>
                            <table class="table table-dark align-middle mb-0">
                                <thead><tr><th>نام</th><th>موبایل</th><th>پلن</th><th>تاریخ</th></tr></thead>
                                <tbody>
                                <tr><td>طاها تیموری</td><td>09xx xxx xxxx</td><td>Silver</td><td>امروز</td></tr>
                                <tr><td>الهام سادات</td><td>09xx xxx xxxx</td><td>Lite</td><td>دیروز</td></tr>
                                <tr><td>کاوه خسروی</td><td>09xx xxx xxxx</td><td>Pro</td><td>۳ روز پیش</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-glass">
                            <h5 class="section-title">ترکیب پلن‌های فعال</h5>
                            <canvas id="plansPie" height="140"></canvas>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Plans -->
            <section id="section-plans" class="d-none">
                <div class="card-glass mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="section-title m-0">مدیریت پلن‌ها</h5>
                        <button class="neon-btn" data-bs-toggle="modal" data-bs-target="#planModal"><i class="bi bi-plus-lg"></i> پلن جدید</button>
                    </div>
                </div>
                <div class="card-glass">
                    <table class="table table-dark align-middle">
                        <thead><tr><th>نام پلن</th><th>مدت‌ها</th><th>قیمت‌ها (تومان)</th><th>تعداد بازی</th><th>تعویض</th><th>وضعیت</th><th>عملیات</th></tr></thead>
                        <tbody id="plansTableBody">
                        <!-- Filled by JS -->
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Users -->
            <section id="section-users" class="d-none">
                <div class="card-glass mb-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3"><label class="form-label">جستجو</label><input class="form-control" id="userSearch" placeholder="نام یا موبایل"></div>
                        <div class="col-md-3"><label class="form-label">پلن</label><select class="form-select" id="userPlanFilter"><option value="">همه</option><option>Lite</option><option>Silver</option><option>Pro</option><option>Max</option></select></div>
                        <div class="col-md-3"><label class="form-label">وضعیت</label><select class="form-select" id="userStatusFilter"><option value="">همه</option><option>فعال</option><option>مسدود</option><option>منقضی</option></select></div>
                        <div class="col-md-3 text-end"><button class="neon-btn w-100"><i class="bi bi-download"></i> خروجی CSV</button></div>
                    </div>
                </div>
                <div class="card-glass">
                    <table class="table table-dark align-middle">
                        <thead><tr><th>نام</th><th>موبایل</th><th>پلن</th><th>وضعیت</th><th>ثبت‌نام</th><th>عملیات</th></tr></thead>
                        <tbody id="usersTableBody">
                        <!-- Filled by JS -->
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Subscriptions -->
            <section id="section-subs" class="d-none">
                <div class="card-glass mb-3 d-flex justify-content-between align-items-center">
                    <h5 class="section-title m-0">اشتراک‌ها</h5>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm"><option>همه</option><option>فعال</option><option>منقضی</option></select>
                        <button class="neon-btn"><i class="bi bi-arrow-repeat"></i> بروزرسانی</button>
                    </div>
                </div>
                <div class="card-glass">
                    <table class="table table-dark align-middle">
                        <thead><tr><th>کاربر</th><th>پلن</th><th>شروع</th><th>پایان</th><th>بازی‌ها</th><th>عملیات</th></tr></thead>
                        <tbody>
                        <tr>
                            <td>امین احمدی</td><td>Silver (۶ ماه)</td><td>۱۴۰۴/۰۵/۳۰</td><td>۱۴۰۵/۰۱/۳۰</td><td>3</td>
                            <td><button class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></button> <button class="btn btn-sm btn-outline-danger"><i class="bi bi-x"></i></button></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Games -->
            <section id="section-games" class="d-none">
                <div class="card-glass mb-3 d-flex justify-content-between align-items-center">
                    <h5 class="section-title m-0">مدیریت بازی‌ها</h5>
                    <button class="neon-btn" data-bs-toggle="modal" data-bs-target="#gameModal"><i class="bi bi-plus-lg"></i> بازی جدید</button>
                </div>
                <div class="card-glass">
                    <div class="row g-2 mb-3">
                        <div class="col-md-4"><input class="form-control" placeholder="جستجوی بازی..."></div>
                        <div class="col-md-4"><input class="form-control" placeholder="ژانر (اکشن، ورزشی...)" /></div>
                        <div class="col-md-4"><select class="form-select"><option>همه وضعیت‌ها</option><option>فعال</option><option>غیرفعال</option></select></div>
                    </div>
                    <table class="table table-dark align-middle">
                        <thead><tr><th>کاور</th><th>نام بازی</th><th>ژانر</th><th>تاریخ افزودن</th><th>وضعیت</th><th>عملیات</th></tr></thead>
                        <tbody id="gamesTableBody">
                        <!-- Filled by JS -->
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Swaps -->
            <section id="section-swaps" class="d-none">
                <div class="card-glass">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="section-title m-0">درخواست‌های تعویض بازی</h5>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm"><option>همه</option><option>در انتظار</option><option>تایید</option><option>رد</option></select>
                            <button class="neon-btn"><i class="bi bi-arrow-repeat"></i></button>
                        </div>
                    </div>
                    <table class="table table-dark align-middle">
                        <thead><tr><th>کاربر</th><th>پلن</th><th>لیست قبلی</th><th>لیست جدید</th><th>تاریخ</th><th>وضعیت</th><th>عملیات</th></tr></thead>
                        <tbody id="swapsTableBody">
                        <!-- Filled by JS -->
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Finance -->
            <section id="section-finance" class="d-none">
                <div class="card-glass mb-3 d-flex justify-content-between align-items-center">
                    <h5 class="section-title m-0">گزارش مالی</h5>
                    <div class="d-flex gap-2">
                        <input type="date" class="form-control form-control-sm" />
                        <input type="date" class="form-control form-control-sm" />
                        <button class="neon-btn"><i class="bi bi-filter"></i> اعمال فیلتر</button>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card-glass">
                            <h6 class="section-title">نمودار تراکنش‌ها</h6>
                            <canvas id="txChart" height="120"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card-glass h-100">
                            <h6 class="section-title">خلاصه</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-transparent text-white d-flex justify-content-between"><span>درآمد کل</span><b>۳۲,۴۵۰,۰۰۰</b></li>
                                <li class="list-group-item bg-transparent text-white d-flex justify-content-between"><span>تعداد تراکنش</span><b>۴۸۰</b></li>
                                <li class="list-group-item bg-transparent text-white d-flex justify-content-between"><span>میانگین سبد</span><b>۶۷,۵۰۰</b></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-glass mt-3">
                    <table class="table table-dark align-middle">
                        <thead><tr><th>کاربر</th><th>مبلغ</th><th>تاریخ</th><th>نوع</th><th>وضعیت</th><th>رسید</th></tr></thead>
                        <tbody>
                        <tr><td>علی رضایی</td><td>۳۰۰,۰۰۰</td><td>۱۴۰۳/۰۷/۰۱</td><td>تمدید پلن</td><td><span class="badge bg-success">موفق</span></td><td><button class="btn btn-sm btn-outline-info"><i class="bi bi-receipt"></i></button></td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Notifications -->
            <section id="section-notifications" class="d-none">
                <div class="card-glass">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="section-title m-0">اعلان‌ها</h5>
                        <button class="btn btn-sm btn-outline-light">علامت‌گذاری همه به‌عنوان خوانده‌شده</button>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-transparent text-white"><i class="bi bi-info-circle text-info ms-2"></i> کاربر جدید ثبت‌نام کرد.</li>
                        <li class="list-group-item bg-transparent text-white"><i class="bi bi-exclamation-triangle text-warning ms-2"></i> ۳ درخواست تعویض در انتظار.</li>
                        <li class="list-group-item bg-transparent text-white"><i class="bi bi-check2-circle text-success ms-2"></i> پرداخت با موفقیت انجام شد.</li>
                    </ul>
                </div>
            </section>

            <!-- Roles & Permissions -->
            <section id="section-roles" class="d-none">
                <div class="card-glass mb-3 d-flex justify-content-between align-items-center">
                    <h5 class="section-title m-0">نقش‌ها و دسترسی‌ها</h5>
                    <button class="neon-btn" data-bs-toggle="modal" data-bs-target="#roleModal"><i class="bi bi-plus-lg"></i> ایجاد نقش</button>
                </div>
                <div class="card-glass">
                    <table class="table table-dark align-middle">
                        <thead><tr><th>نقش</th><th>توضیح</th><th>اعمال</th></tr></thead>
                        <tbody>
                        <tr>
                            <td>مدیر کل</td>
                            <td>دسترسی کامل به همه بخش‌ها</td>
                            <td>
                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#roleModal"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>پشتیبان</td>
                            <td>مشاهده کاربران، پاسخ به درخواست‌ها</td>
                            <td>
                                <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#roleModal"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Settings -->
            <section id="section-settings" class="d-none">
                <div class="card-glass">
                    <h5 class="section-title">تنظیمات سیستم</h5>
                    <form class="row g-3">
                        <div class="col-md-4"><label class="form-label">نام سایت</label><input class="form-control" value="منطقه هیجان" /></div>
                        <div class="col-md-4"><label class="form-label">لوگو</label><input type="file" class="form-control" /></div>
                        <div class="col-md-4"><label class="form-label">رنگ اصلی</label><input type="color" class="form-control form-control-color" value="#00ffff" /></div>
                        <div class="col-md-6"><label class="form-label">درگاه پرداخت</label><select class="form-select"><option>زرین‌پال</option><option>Pay.ir</option></select></div>
                        <div class="col-md-6"><label class="form-label">SMS API Key</label><input class="form-control" placeholder="کلید پیامک" /></div>
                        <div class="col-md-6"><label class="form-label">Email SMTP</label><input class="form-control" placeholder="smtp.example.com" /></div>
                        <div class="col-md-6"><label class="form-label">شماره پشتیبانی</label><input class="form-control" placeholder="0912xxxxxxx" /></div>
                        <div class="col-12"><button class="neon-btn" type="button"><i class="bi bi-save"></i> ذخیره تغییرات</button></div>
                    </form>
                </div>
            </section>
        </main>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="planModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title">افزودن / ویرایش پلن</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">نام پلن</label><input id="planName" class="form-control" placeholder="Thrill Pro" /></div>
                    <div class="col-md-6"><label class="form-label">فعال</label><select id="planActive" class="form-select"><option value="1">بله</option><option value="0">خیر</option></select></div>
                    <div class="col-md-4"><label class="form-label">مدت‌ها (ماهه)</label><input id="planDurations" class="form-control" placeholder="3,6,12" /></div>
                    <div class="col-md-4"><label class="form-label">تعویض (روز)</label><input id="planSwap" type="number" class="form-control" value="30" /></div>
                    <div class="col-md-4"><label class="form-label">حداکثر بازی</label><input id="planMax" type="number" class="form-control" value="3" /></div>
                    <div class="col-md-4"><label class="form-label">قیمت ۳ ماهه</label><input id="price3" type="number" class="form-control" placeholder="مثلاً 300000" /></div>
                    <div class="col-md-4"><label class="form-label">قیمت ۶ ماهه</label><input id="price6" type="number" class="form-control" placeholder="مثلاً 550000" /></div>
                    <div class="col-md-4"><label class="form-label">قیمت ۱۲ ماهه</label><input id="price12" type="number" class="form-control" placeholder="مثلاً 950000" /></div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                <button class="neon-btn" id="savePlanBtn">ذخیره پلن</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="gameModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0"><h5 class="modal-title">افزودن بازی جدید</h5><button class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">نام بازی</label><input class="form-control" id="gameName" /></div>
                <div class="mb-3"><label class="form-label">ژانر</label><input class="form-control" id="gameGenre" placeholder="اکشن، ورزشی..." /></div>
                <div class="mb-3"><label class="form-label">کاور</label><input type="file" class="form-control" /></div>
            </div>
            <div class="modal-footer border-0"><button class="btn btn-secondary" data-bs-dismiss="modal">بستن</button><button class="neon-btn" id="saveGameBtn">افزودن</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="roleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-0"><h5 class="modal-title">ایجاد/ویرایش نقش</h5><button class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">نام نقش</label><input class="form-control" id="roleName" placeholder="Support" /></div>
                    <div class="col-md-6"><label class="form-label">توضیح</label><input class="form-control" id="roleDesc" placeholder="دسترسی به درخواست‌ها" /></div>
                    <div class="col-12">
                        <label class="form-label">دسترسی‌ها</label>
                        <div class="row g-2">
                            <div class="col-md-3"><div class="form-check"><input class="form-check-input" type="checkbox" id="permUsers" checked><label class="form-check-label" for="permUsers">کاربران</label></div></div>
                            <div class="col-md-3"><div class="form-check"><input class="form-check-input" type="checkbox" id="permPlans" checked><label class="form-check-label" for="permPlans">پلن‌ها</label></div></div>
                            <div class="col-md-3"><div class="form-check"><input class="form-check-input" type="checkbox" id="permSwaps"><label class="form-check-label" for="permSwaps">تعویض‌ها</label></div></div>
                            <div class="col-md-3"><div class="form-check"><input class="form-check-input" type="checkbox" id="permFinance"><label class="form-check-label" for="permFinance">مالی</label></div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0"><button class="btn btn-secondary" data-bs-dismiss="modal">بستن</button><button class="neon-btn">ذخیره نقش</button></div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // ======= Dark / Light Toggle =======
    const themeSwitch = document.getElementById('themeSwitch');
    const savedTheme = localStorage.getItem('tz-theme') || 'dark';
    if(savedTheme==='light'){document.documentElement.setAttribute('data-theme','light'); themeSwitch.checked=true;}
    themeSwitch?.addEventListener('change',()=>{
        const mode = themeSwitch.checked ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', mode);
        localStorage.setItem('tz-theme', mode);
    });

    // ======= Sidebar mobile =======
    document.getElementById('openSidebar')?.addEventListener('click',()=>document.getElementById('sidebar').classList.add('active'));
    document.getElementById('closeSidebar')?.addEventListener('click',()=>document.getElementById('sidebar').classList.remove('active'));

    // ======= Nav routing =======
    const sections = ['dashboard','plans','users','subs','games','swaps','finance','notifications','roles','settings'];
    document.querySelectorAll('.sidebar .nav-link[data-section], .dropdown-item[data-section], .topbar [data-section]')
        .forEach(el=>el.addEventListener('click', (e)=>{ e.preventDefault();
            const target = el.getAttribute('data-section');
            sections.forEach(s=>document.getElementById('section-'+s)?.classList.toggle('d-none', s!==target));
            document.querySelectorAll('.sidebar .nav-link').forEach(a=>a.classList.remove('active'));
            document.querySelector('.sidebar .nav-link[data-section="'+target+'"]')?.classList.add('active');
            // close mobile sidebar
            document.getElementById('sidebar').classList.remove('active');
        }));

    // ======= Mock Data =======
    const plans = [
        { id:1, name:'Thrill Lite', durations:[3,6,12], prices:{3:150000,6:280000,12:520000}, maxGames:2, swapEvery:30, active:true},
        { id:2, name:'Thrill Silver', durations:[3,6,12], prices:{3:220000,6:390000,12:740000}, maxGames:3, swapEvery:30, active:true},
        { id:3, name:'Thrill Pro', durations:[3,6,12], prices:{3:300000,6:560000,12:990000}, maxGames:5, swapEvery:30, active:true},
        { id:4, name:'Thrill Max', durations:[6,12], prices:{6:900000,12:1650000}, maxGames:7, swapEvery:15, active:true},
    ];
    const users = [
        {id:1,name:'امین احمدی',phone:'09xx xxx xxxx',plan:'Silver',status:'فعال',joined:'۱۴۰۳/۰۶/۲۱'},
        {id:2,name:'نازنین توکلی',phone:'09xx xxx xxxx',plan:'Lite',status:'فعال',joined:'۱۴۰۳/۰۶/۲۲'},
        {id:3,name:'کاوه خسروی',phone:'09xx xxx xxxx',plan:'Pro',status:'منقضی',joined:'۱۴۰۳/۰۵/۰۱'},
        {id:4,name:'مهسا بحرینی',phone:'09xx xxx xxxx',plan:'Max',status:'مسدود',joined:'۱۴۰۳/۰۴/۱۵'},
    ];
    const games = [
        {id:1,name:'Call of Duty',genre:'اکشن',date:'۱۴۰۳/۰۶/۲۱',status:'فعال',cover:'https://picsum.photos/seed/cod/64/40'},
        {id:2,name:'FIFA 24',genre:'ورزشی',date:'۱۴۰۳/۰۴/۱۲',status:'فعال',cover:'https://picsum.photos/seed/fifa/64/40'},
        {id:3,name:'The Last of Us',genre:'ماجراجویی',date:'۱۴۰۳/۰۲/۱۰',status:'غیرفعال',cover:'https://picsum.photos/seed/tlou/64/40'},
    ];
    const swaps = [
        {id:1,user:'امیر حسینی',plan:'Pro',old:['FIFA','COD'],next:['eFootball','COD'],date:'۱۴۰۳/۰۷/۰۲',status:'در انتظار'},
        {id:2,user:'نازنین توکلی',plan:'Silver',old:['Hades','NFS'],next:['Hades','Forza'],date:'۱۴۰۳/۰۷/۰۱',status:'تایید'},
    ];

    // ======= Renderers =======
    function toFa(n){return typeof n==='number'? n.toLocaleString('fa-IR'):n}

    function renderPlans(){
        const tbody = document.getElementById('plansTableBody');
        tbody.innerHTML = '';
        plans.forEach(p=>{
            const durations = p.durations.map(d=>toFa(d)).join(' / ');
            const prices = p.durations.map(d=>`${toFa(d)}م: ${toFa(p.prices[d]||0)}`).join('، ');
            const tr = document.createElement('tr');
            tr.innerHTML = `
          <td>${p.name}</td>
          <td>${durations}</td>
          <td>${prices}</td>
          <td>${toFa(p.maxGames)}</td>
          <td>هر ${toFa(p.swapEvery)} روز</td>
          <td>${p.active?'<span class="badge bg-success">فعال</span>':'<span class="badge bg-secondary">غیرفعال</span>'}</td>
          <td>
            <button class="btn btn-sm btn-outline-info me-1"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
          </td>`;
            tbody.appendChild(tr);
        });
    }

    function renderUsers(){
        const tbody = document.getElementById('usersTableBody');
        tbody.innerHTML = '';
        users.forEach(u=>{
            const tr = document.createElement('tr');
            tr.innerHTML = `
          <td>${u.name}</td><td>${u.phone}</td><td>${u.plan}</td>
          <td><span class="badge ${u.status==='فعال'?'bg-success':u.status==='مسدود'?'bg-danger':'bg-secondary'}">${u.status}</span></td>
          <td>${u.joined}</td>
          <td>
            <button class="btn btn-sm btn-outline-info me-1"><i class="bi bi-eye"></i></button>
            <button class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-lock"></i></button>
            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
          </td>`;
            tbody.appendChild(tr);
        });
    }

    function renderGames(){
        const tbody = document.getElementById('gamesTableBody');
        tbody.innerHTML='';
        games.forEach(g=>{
            const tr=document.createElement('tr');
            tr.innerHTML=`
          <td><img src="${g.cover}" class="rounded" alt="cover"></td>
          <td>${g.name}</td><td>${g.genre}</td><td>${g.date}</td>
          <td>${g.status==='فعال'?'<span class="badge bg-success">فعال</span>':'<span class="badge bg-secondary">غیرفعال</span>'}</td>
          <td>
            <button class="btn btn-sm btn-outline-info me-1"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
          </td>`;
            tbody.appendChild(tr);
        })
    }

    function renderSwaps(){
        const tbody = document.getElementById('swapsTableBody');
        tbody.innerHTML = '';
        swaps.forEach(s=>{
            const tr=document.createElement('tr');
            tr.innerHTML = `
          <td>${s.user}</td><td>${s.plan}</td>
          <td>${s.old.join('، ')}</td>
          <td>${s.next.join('، ')}</td>
          <td>${s.date}</td>
          <td>${s.status==='در انتظار'?'<span class="badge bg-warning text-dark">در انتظار</span>':s.status==='تایید'?'<span class="badge bg-success">تایید</span>':'<span class="badge bg-danger">رد</span>'}</td>
          <td>
            <button class="btn btn-sm btn-outline-success me-1"><i class="bi bi-check2"></i></button>
            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-x"></i></button>
          </td>`;
            tbody.appendChild(tr);
        })
    }

    // ======= Charts =======
    let revenueChart, plansPieChart, txChart;
    function initCharts(){
        const rc = document.getElementById('revenueChart');
        revenueChart = new Chart(rc,{type:'line', data:{labels:['فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند'], datasets:[{label:'درآمد (تومان)', data:[12,19,11,15,22,28,25,30,27,34,31,38], tension:.35, fill:true}]}, options:{plugins:{legend:{display:false}}, scales:{y:{ticks:{callback:v=>v.toLocaleString('fa-IR')}}}}});

        const pc = document.getElementById('plansPie');
        plansPieChart = new Chart(pc,{type:'doughnut', data:{labels:['Lite','Silver','Pro','Max'], datasets:[{data:[35,30,22,13]}]}, options:{plugins:{legend:{position:'bottom'}}}});

        const tx = document.getElementById('txChart');
        txChart = new Chart(tx,{type:'bar', data:{labels:['هفته ۱','هفته ۲','هفته ۳','هفته ۴'], datasets:[{label:'تراکنش موفق', data:[120,150,180,130]}, {label:'ناموفق', data:[10,12,8,9]}]}, options:{plugins:{legend:{position:'bottom'}}, scales:{y:{ticks:{callback:v=>v.toLocaleString('fa-IR')}}}}});
    }

    // ======= Init =======
    document.addEventListener('DOMContentLoaded', ()=>{
        renderPlans(); renderUsers(); renderGames(); renderSwaps(); initCharts();
    });

    // ======= Save plan (mock) =======
    document.getElementById('savePlanBtn')?.addEventListener('click',()=>{
        const name = document.getElementById('planName').value || 'New Plan';
        const active = document.getElementById('planActive').value==='1';
        const durs = (document.getElementById('planDurations').value||'3,6,12').split(',').map(x=>parseInt(x.trim(),10)).filter(Boolean);
        const swap = parseInt(document.getElementById('planSwap').value,10)||30;
        const max = parseInt(document.getElementById('planMax').value,10)||3;
        const p3 = parseInt(document.getElementById('price3').value,10)||0;
        const p6 = parseInt(document.getElementById('price6').value,10)||0;
        const p12 = parseInt(document.getElementById('price12').value,10)||0;
        const prices = {3:p3,6:p6,12:p12};
        plans.push({id:Date.now(), name, durations:durs, prices, maxGames:max, swapEvery:swap, active});
        renderPlans();
        bootstrap.Modal.getInstance(document.getElementById('planModal')).hide();
    });

    // ======= Save game (mock) =======
    document.getElementById('saveGameBtn')?.addEventListener('click',()=>{
        const name = document.getElementById('gameName').value||'New Game';
        const genre = document.getElementById('gameGenre').value||'سایر';
        games.unshift({id:Date.now(), name, genre, date:'امروز', status:'فعال', cover:'https://picsum.photos/seed/'+Math.random().toString(36).slice(2,7)+'/64/40'});
        renderGames();
        bootstrap.Modal.getInstance(document.getElementById('gameModal')).hide();
    });
</script>
</body>
</html>
