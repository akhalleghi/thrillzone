@extends('user.layouts.app')

@section('title', 'داشبورد کاربری')

@section('extra-styles')
<style>
    :root {
        --c-cyan: #3df5ff;
        --c-pink: #ff5ce8;
        --c-bg-dark: #121638;
        --c-bg-light: rgba(255, 255, 255, 0.05);
        --c-text-soft: rgba(255, 255, 255, 0.9);
    }

    body {
        background: linear-gradient(135deg, #121638 0%, #1d225a 60%, #231b4d 100%);
        color: var(--c-text-soft);
    }

    /* === Header === */
    .dashboard-header {
        display:flex; justify-content:space-between; align-items:center;
        flex-wrap:wrap; gap:1rem;
        border-bottom:1px solid rgba(255,255,255,.15);
        padding-bottom:1.2rem;
    }

    .user-profile { display:flex; align-items:center; gap:1rem; }
    .user-avatar {
        width:65px; height:65px; border-radius:50%;
        background:linear-gradient(135deg,var(--c-cyan),var(--c-pink));
        display:flex; justify-content:center; align-items:center;
        box-shadow:0 0 25px rgba(255,255,255,.25);
    }
    .welcome-text {
        font-size:1.2rem; font-weight:600;
        background:linear-gradient(135deg,var(--c-cyan),var(--c-pink));
        -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    }

    /* === Buttons === */
    .btn-neon {
        background:linear-gradient(135deg,var(--c-cyan),var(--c-pink));
        color:#0b0f2b; border:none; border-radius:12px; font-weight:700;
        padding:.65rem 1.5rem; font-size:1rem;
        box-shadow:0 5px 20px rgba(61,245,255,.3);
        transition:all .25s ease;
    }
    .btn-neon:hover { transform:translateY(-2px); filter:brightness(1.15); }
    .btn-neon:active { transform:scale(.96); }

    /* === Stats Cards === */
    .stats-grid {
        display:grid; gap:1.5rem;
        grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
        margin-top:2rem;
    }
    .stat-card {
        background:linear-gradient(135deg,rgba(255,255,255,.06),rgba(255,255,255,.1));
        border-radius:18px;
        padding:1.5rem;
        border:2px solid rgba(255,255,255,.1);
        transition:all .3s ease;
        position:relative; overflow:hidden;
    }
    .stat-card:hover {
        transform:translateY(-5px);
        border-color:rgba(255,255,255,.25);
        box-shadow:0 12px 30px rgba(61,245,255,.25);
    }
    .stat-title { font-size:1rem; color:var(--c-cyan); margin-bottom:.5rem; }
    .stat-value {
        font-size:1.9rem; font-weight:700;
        background:linear-gradient(135deg,var(--c-cyan),var(--c-pink));
        -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    }

    /* === CTA Section === */
    .cta-section {
        background:linear-gradient(135deg,rgba(61,245,255,.15),rgba(255,92,232,.15));
        border:2px solid rgba(255,255,255,.1);
        border-radius:25px; padding:2.5rem; margin-top:3rem;
        text-align:center; box-shadow:0 0 35px rgba(255,255,255,.1);
        animation:fadeInUp .7s ease;
    }
    .cta-section h4 {
        font-weight:700; margin-bottom:1rem;
        background:linear-gradient(135deg,var(--c-cyan),var(--c-pink));
        -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    }
    .cta-section p {
        color:#f1f1f1; margin-bottom:1.5rem;
        font-size:1.05rem;
    }

    /* === Responsive === */
    @media (max-width:768px){
        .dashboard-header { flex-direction:column; align-items:flex-start; }
        .dashboard-header .d-flex { width:100%; justify-content:center; }
        .btn-neon { flex:1; text-align:center; font-size:1rem; }
        .mobile-menu-btn { display:flex !important; }
    }
    @media (min-width:769px){
        .mobile-menu-btn { display:none !important; } /* 🔥 مخفی در دسکتاپ */
    }

    /* === Modal Fix === */
    .modal {
        z-index: 1060 !important;
    }
    .modal-backdrop {
        z-index: 1050 !important;
        opacity: 0.55 !important;
    }
    .modal-content {
        z-index: 1065 !important;
        background: linear-gradient(135deg, #161b3d, #1e235a);
        border-radius: 18px;
        border: 1px solid rgba(61,245,255,.3);
        box-shadow: 0 0 30px rgba(255,255,255,.15);
    }
    .modal.show { opacity:1 !important; }

    /* === Mobile Menu Button (Fixed Position + Centered Icon) === */
    .mobile-menu-btn {
        position: fixed;
        bottom: 1.2rem;
        right: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg,var(--c-cyan),var(--c-pink));
        border: none;
        border-radius: 14px;
        color: #fff;
        font-size: 1.6rem;
        box-shadow: 0 0 20px rgba(255,255,255,.25);
        z-index: 1055;
    }

    @keyframes fadeInUp {
        from { opacity:0; transform:translateY(30px); }
        to { opacity:1; transform:translateY(0); }
    }
</style>
@endsection


@section('content')
<!-- Header -->
<header class="dashboard-header">
    <div class="user-profile">
        <div class="user-avatar"><i class="bi bi-person fs-3"></i></div>
        <div>
            <h5 class="mb-0">{{ auth()->user()->name ?? 'کاربر عزیز' }}</h5>
            <div class="welcome-text">خوش آمدید به منطقه هیجان 🎮</div>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2">
        <button class="btn btn-neon" data-bs-toggle="modal" data-bs-target="#purchaseModal">
            <i class="bi bi-cart4"></i> خرید اشتراک
        </button>
    </div>
</header>

<!-- Stats Section -->
<div class="stats-grid">
    <div class="stat-card">
    <div class="stat-title">پلن‌های فعال</div>
    <div class="stat-value">
        {{ \Morilog\Jalali\CalendarUtils::convertNumbers($activePlansCount) }} پلن
    </div>
    <div class="small text-light">
        {{ $activePlansCount > 0 ? 'در حال استفاده از اشتراک فعال' : 'بدون اشتراک فعال' }}
    </div>
</div>



    <div class="stat-card">
    <div class="stat-title">سابقه عضویت</div>
    <div class="stat-value">{{ \Morilog\Jalali\CalendarUtils::convertNumbers($membershipDays) }} روز
</div>
    <div class="small text-light">
    از {{ \Morilog\Jalali\CalendarUtils::convertNumbers(
        jdate(auth()->user()->created_at)->format('Y/m/d')
    ) }}
</div>


</div>



   <div class="stat-card">
    <div class="stat-title">وضعیت اشتراک</div>
    <div class="stat-value {{ $activePlansCount ? 'text-success' : 'text-warning' }}">
        {{ $activePlansCount ? 'فعال' : 'غیرفعال' }}
    </div>
    <div class="small text-light">
        تمدید بعدی:
        @if($nextRenewAt)
            {{ \Morilog\Jalali\CalendarUtils::convertNumbers(
                jdate($nextRenewAt)->format('Y/m/d')
            ) }}
        @else
            —
        @endif
    </div>
</div>



    <div class="stat-card">
    <div class="stat-title">تراکنش‌های موفق</div>
    <div class="stat-value">{{ \Morilog\Jalali\CalendarUtils::convertNumbers( number_format($successfulTransactions) ) }} تومان
</div>
    {{-- اگر ستون amount به ریاله/تومنه برحسب نیاز تغییر بده --}}
    <div class="small text-light">مجموع پرداخت‌های موفق شما</div>
</div>

</div>

<!-- CTA: خرید اشتراک -->
<section class="cta-section">
    <h4>خرید اشتراک 🎮</h4>
    <p>با خرید اشتراک، به جدیدترین بازی‌ها، تخفیف‌های ویژه و امکانات نامحدود دسترسی خواهید داشت.</p>
    <button class="btn btn-neon px-4 py-2" data-bs-toggle="modal" data-bs-target="#purchaseModal">
        <i class="bi bi-cart-check"></i> مشاهده پلن‌ها و خرید
    </button>
</section>

<!-- Purchase Modal -->
<div class="modal fade" id="purchaseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title">خرید اشتراک جدید</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">انتخاب پلن</label>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="w-100 p-3 rounded-3 border border-info" style="background:rgba(61,245,255,.08); cursor:pointer;">
                            <input type="radio" name="plan" checked> Thrill Silver
                            <div class="small mt-1 text-info">۳ بازی • تعویض هر ۳۰ روز</div>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="w-100 p-3 rounded-3 border border-pink" style="background:rgba(255,92,232,.08); cursor:pointer;">
                            <input type="radio" name="plan"> Thrill Max
                            <div class="small mt-1 text-info">۷ بازی • تعویض هر ۱۵ روز</div>
                        </label>
                    </div>
                </div>

                <label class="form-label">مدت زمان</label>
                <select class="form-select mb-3">
                    <option>۳ ماهه</option>
                    <option selected>۶ ماهه</option>
                    <option>۱۲ ماهه</option>
                </select>

                <label class="form-label">بازی‌های انتخابی</label>
                <div class="row g-2">
                    <div class="col-md-6"><input type="text" class="form-control" placeholder="نام بازی ۱"></div>
                    <div class="col-md-6"><input type="text" class="form-control" placeholder="نام بازی ۲"></div>
                    <div class="col-md-6"><input type="text" class="form-control" placeholder="نام بازی ۳"></div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                <button class="btn btn-neon"><i class="bi bi-check2-circle"></i> تایید خرید</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // اطمینان از فعال بودن کلیک روی مدال‌ها
    document.addEventListener('show.bs.modal', (e) => {
        document.body.classList.add('modal-open');
        document.querySelectorAll('.modal-backdrop').forEach(el => el.style.pointerEvents = 'none');
    });
</script>
@endsection

