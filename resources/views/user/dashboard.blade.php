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
        border:2px solid rgba(255,255,255,.08);
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

    /* ====== Modal (Subscribe) & Cards ====== */
    .modal-xxl { max-width: 1400px; }

    .modal-subscribe {
      background: linear-gradient(135deg, #0b1035, #1a1f47);
      border-radius: 20px;
      border: 1px solid rgba(61,245,255,0.25);
    }

    .step-guide {
      background: rgba(255,255,255,0.05);
      border-radius: 10px;
      padding: 6px 12px;
      display: inline-block;
    }

    .plan-card {
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(61,245,255,0.25);
      border-radius: 12px;
      padding: 1rem;
      transition: 0.3s;
    }
    .plan-card:hover {
      border-color: #00ffff;
      transform: translateY(-3px);
      box-shadow: 0 0 15px rgba(0,255,255,0.1);
    }
    .plan-card.active {
      border: 2px solid #00ffff;
      background: rgba(0,255,255,0.05);
    }

    .plan-header {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      margin-bottom: 0.5rem;
    }
    .plan-header img {
      width: 55px;
      height: 55px;
      border-radius: 10px;
      border: 1px solid rgba(0,255,255,0.3);
      object-fit: cover;
    }

    .plan-features {
      list-style: none;
      padding: 0;
      margin: 0 0 0.5rem 0;
      font-size: 0.9rem;
      color: #bcd;
      line-height: 1.6;
    }
    .plan-features i { margin-left: 6px; }

    .duration-box {
      background: rgba(0,255,255,0.07);
      border: 1px dashed rgba(0,255,255,0.3);
      border-radius: 10px;
      padding: 8px;
      text-align: center;
    }
    .duration-box label {
      display: block;
      color: #00ffff;
      font-weight: bold;
      margin-bottom: 8px;
      font-size: 0.95rem;
    }

    .duration-buttons {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 0.5rem;
    }
    .duration-btn {
      background: transparent;
      border: 1px solid rgba(61,245,255,0.4);
      color: #00ffff;
      border-radius: 999px;
      padding: 4px 14px;
      transition: 0.2s;
      font-size: 0.9rem;
    }
    .duration-btn:hover {
      background: rgba(0,255,255,0.2);
      color: #fff;
    }
    .duration-btn.active {
      background: #00ffff;
      color: #0b1035;
      font-weight: 600;
    }

    .plan-price {
      text-align: center;
      margin-top: 0.8rem;
      font-size: 1rem;
      color: #00ffff;
      font-weight: bold;
    }

    .invoice-box {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(61,245,255,0.3);
      border-radius: 10px;
      padding: 0.75rem;
      text-align: center;
      font-size: 0.95rem;
      width: 100%;
    }
    .invoice-box span {
      color: #00ffff;
      font-weight: bold;
    }

    /* === Coupon Box === */
    .coupon-box {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(61,245,255,0.3);
      border-radius: 12px;
    }
    .coupon-box input::placeholder {
      color: rgba(255,255,255,0.8); /* روشن‌تر */
    }
    #couponMessage { min-height: 20px; }
    #couponMessage.text-success { color: #00ffae !important; }
    #couponMessage.text-danger { color: #ff6b6b !important; }

    .rules-confirm-box {
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(61,245,255,0.3);
      border-radius: 12px;
      width: 100%;
      padding: 0.85rem 1rem !important;
      color: rgba(255,255,255,0.85);
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: 0.65rem;
      text-align: right;
      direction: rtl;
    }
    .rules-confirm-box .form-check-input {
      width: 20px;
      height: 20px;
      margin: 0;
    }
    .rules-confirm-box .form-check-label {
      margin: 0;
      flex: 1;
      text-align: right;
    }
    .rules-confirm-box a {
      color: var(--c-cyan);
      text-decoration: none;
      font-weight: 600;
    }
    .rules-confirm-box a:hover {
      text-decoration: underline;
    }

    /* تنظیم جای دکمه بستن مدال در حالت راست‌به‌چپ */
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  direction: rtl; /* جهت درست برای چینش عنوان و دکمه */
}

.modal-header .modal-title {
  flex: 1;
  text-align: right; /* عنوان در سمت راست */
}

.modal-header .btn-close {
  margin-left: auto; /* هل دادن دکمه به چپ */
  margin-right: 0;
  filter: invert(1); /* سفیدتر برای تم تاریک */
  opacity: 0.9;
}
.modal-header .btn-close:hover {
  opacity: 1;
  transform: scale(1.1);
}

</style>
@endsection


@section('content')


@if(session('success'))
<div class="alert alert-success text-center rounded-3 mt-3 shadow">
  <i class="bi bi-check-circle-fill me-1"></i>
  {{ session('success') }}
  @if(session('track_id'))
    <div class="mt-1 small text-info">
      <i class="bi bi-receipt-cutoff"></i>
      کد پیگیری: <strong>{{ session('track_id') }}</strong>
    </div>
  @endif
</div>
@endif

@if(session('error'))
<div class="alert alert-danger text-center rounded-3 mt-3 shadow">
  <i class="bi bi-x-circle-fill me-1"></i>
  {{ session('error') }}
  @if(session('track_id'))
    <div class="mt-1 small text-light">
      <i class="bi bi-receipt"></i>
      کد پیگیری: <strong>{{ session('track_id') }}</strong>
    </div>
  @endif
</div>
@endif



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
        <div class="stat-value">
            {{ \Morilog\Jalali\CalendarUtils::convertNumbers($membershipDays) }} روز
        </div>
        <div class="small text-light">
            از {{ \Morilog\Jalali\CalendarUtils::convertNumbers( jdate(auth()->user()->created_at)->format('Y/m/d') ) }}
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
                {{ \Morilog\Jalali\CalendarUtils::convertNumbers( jdate($nextRenewAt)->format('Y/m/d') ) }}
            @else
                —
            @endif
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-title">تراکنش‌های موفق</div>
        <div class="stat-value">
            {{ \Morilog\Jalali\CalendarUtils::convertNumbers( number_format($successfulTransactions) ) }} تومان
        </div>
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
<div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xxl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content modal-subscribe text-white">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold text-info">
          <i class="bi bi-bag-plus me-2"></i> خرید اشتراک
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- راهنمای مراحل (فلش راست‌به‌چپ) -->
      <div class="step-guide text-center text-light small mb-3">
        <span class="badge bg-info text-dark ms-2">۱</span> انتخاب پلن
        <span class="mx-1">←</span>
        <span class="badge bg-info text-dark ms-2">۲</span> انتخاب مدت زمان
        <span class="mx-1">←</span>
        <span class="badge bg-info text-dark ms-2">۳</span> پرداخت و فعال‌سازی
      </div>

      <div class="modal-body pb-0">
        <div class="row g-3">
          @foreach($plans as $plan)
            @php
              $swap = $plan->swap_limit;
              $num = (int) preg_replace('/\D/', '', $swap);
              $unit = str_ends_with($swap, 'm') ? 'ماه' : 'روز';
              $swapText = $swap ? \Morilog\Jalali\CalendarUtils::convertNumbers($num) . " {$unit} یک‌بار" : '—';

              $installText = collect($plan->install_options ?? [])->map(function($opt){
                  return $opt === 'inperson' ? 'به‌صورت حضوری در محل فروشگاه' :
                         ($opt === 'online' ? 'آنلاین توسط خود کاربر' : $opt);
              })->all();

              $gamesText = $plan->all_ps_store
                ? 'دسترسی به تمام بازی‌های PlayStation Store'
                : 'انتخاب از لیست بازی‌های تعریف‌شده توسط مجموعه';

              $firstDuration = $plan->durations[0] ?? null;
              $firstPrice = $firstDuration ? ($plan->prices[$firstDuration] ?? 0) : 0;
            @endphp

            <div class="col-12 col-md-6 col-xl-4">
              <div class="plan-card" id="plan-card-{{ $plan->id }}" onclick="selectPlan('{{ $plan->id }}')">

                <div class="plan-header">
                  <img src="{{ $plan->image_url }}" alt="{{ $plan->name }}">
                  <div>
                    <h5 class="fw-bold text-info mb-1">{{ $plan->name }}</h5>
                    <small class="text-white-50">{{ $plan->description ?? 'بدون توضیح' }}</small>
                  </div>
                </div>

                <hr class="text-info my-2">

                <ul class="plan-features">
                  <li><i class="bi bi-controller text-info"></i> نوع بازی: <span class="text-light">{{ $plan->game_type ?? '—' }}</span></li>
                  <li><i class="bi bi-joystick text-info"></i> بازی‌های همزمان مجاز: <span class="text-light">{{ \Morilog\Jalali\CalendarUtils::convertNumbers($plan->concurrent_games) }}</span></li>
                  <li><i class="bi bi-grid-3x3-gap text-info"></i> تعداد بازی قابل انتخاب سطح ۱: <span class="text-light">{{ \Morilog\Jalali\CalendarUtils::convertNumbers($plan->level1_selection) }}</span></li>
                  <li><i class="bi bi-collection text-info"></i> لیست بازی‌ها: <span class="text-light">{{ $gamesText }}</span></li>
                  <li><i class="bi bi-arrow-repeat text-info"></i> محدودیت تعویض رایگان: <span class="text-light">هر {{ $swapText }}</span></li>
                  <li><i class="bi bi-hdd-network text-info"></i> نحوه نصب دیتا:
                    @forelse($installText as $txt)
                      <span class="badge bg-info bg-opacity-10 text-info me-1">{{ $txt }}</span>
                    @empty
                      <span class="text-muted">—</span>
                    @endforelse
                  </li>
                  <li><i class="bi bi-percent text-info"></i> تخفیف خرید از سایت و فروشگاه:
                    @if($plan->has_discount)
                      <span class="text-success fw-bold">دارد ({{ \Morilog\Jalali\CalendarUtils::convertNumbers($plan->discount_percent) }}%)</span>
                    @else
                      <span class="text-danger">ندارد</span>
                    @endif
                  </li>
                  <li><i class="bi bi-gift text-info"></i> بازی رایگان ماهانه:
                    @if($plan->has_free_games)
                      <span class="text-light">{{ \Morilog\Jalali\CalendarUtils::convertNumbers($plan->free_games_count) }} عدد</span>
                    @else
                      <span class="text-muted">ندارد</span>
                    @endif
                  </li>
                  <li><i class="bi bi-cpu text-info"></i> پلتفرم‌ها:
                    @foreach($plan->platforms ?? [] as $p)
                      <span class="badge bg-transparent border border-info text-info me-1">{{ $p }}</span>
                    @endforeach
                  </li>
                </ul>

                <div class="duration-box">
                  <label>مدت زمان اشتراک:</label>
                  <div class="duration-buttons" data-plan="{{ $plan->id }}">
                    @foreach($plan->durations ?? [] as $duration)
                      <button type="button" class="duration-btn" data-plan="{{ $plan->id }}" data-months="{{ $duration }}">
                        {{ \Morilog\Jalali\CalendarUtils::convertNumbers($duration) }} ماه
                      </button>
                    @endforeach
                  </div>
                </div>

                <div class="plan-price" id="price-{{ $plan->id }}">
                  {{ \Morilog\Jalali\CalendarUtils::convertNumbers(number_format($firstPrice)) }} تومان
                </div>

              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="modal-footer border-0 flex-column">
        <!-- 🏷 بخش کد تخفیف -->
        <div class="coupon-box w-100 mt-3 p-3 rounded-3 text-center">
          <div class="input-group input-group-sm flex-nowrap">
            <input type="text" id="couponCode" class="form-control bg-transparent text-white border-info"
                   placeholder="کد تخفیف را وارد کنید...">
            <button class="btn btn-outline-info" type="button" id="applyCouponBtn">
              <i class="bi bi-check2-circle me-1"></i> اعمال
            </button>
          </div>
          <div id="couponMessage" class="mt-2 small"></div>
        </div>

        <div id="invoiceBox" class="invoice-box d-none mt-3">
          <div>پلن انتخابی: <span id="inv-plan">—</span></div>
          <div>مدت زمان: <span id="inv-months">—</span></div>
          <div>مبلغ قابل پرداخت: <span id="inv-price">—</span></div>
          <div id="inv-discount" class="text-success mt-1 d-none">
            تخفیف: <span id="inv-discount-amount">۰</span> تومان
          </div>
          <div id="inv-final" class="fw-bold text-info mt-1 d-none">
            مبلغ نهایی: <span id="inv-final-price">۰</span> تومان
          </div>
        </div>

        <div class="rules-confirm-box form-check text-start mt-3">
          <input class="form-check-input" type="checkbox" id="rulesAgree">
          <label dir="rtl" class="form-check-label small" for="rulesAgree">
            با <a href="{{ route('rules') }}" target="_blank" rel="noopener">قوانین و مقررات</a> موافقم.
          </label>
        </div>

        <button class="btn btn-neon mt-3" id="confirmPlanBtn" disabled>
          <i class="bi bi-wallet2 me-1"></i> پرداخت و فعال‌سازی
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
/* --- رفع مشکل لایه تار روی مدال --- */
document.addEventListener('show.bs.modal', () => {
  document.body.classList.add('modal-open');
  document.querySelectorAll('.modal-backdrop').forEach(el => el.style.pointerEvents = 'none');
});
</script>

<script>
/* --- متغیرهای اصلی --- */
const plans = @json($plans);
let selected = { planId: null, months: null, price: 0, discount: 0, final: 0 };
const toFa = n => new Intl.NumberFormat('fa-IR').format(Number(n || 0));
const confirmBtn = document.getElementById('confirmPlanBtn');
const rulesCheckbox = document.getElementById('rulesAgree');

function updateConfirmButtonState() {
  const ready = selected.planId && selected.months && rulesCheckbox.checked;
  confirmBtn.disabled = !ready;
}

rulesCheckbox.addEventListener('change', updateConfirmButtonState);

/* --- انتخاب پلن --- */
function selectPlan(planId) {
  selected = { planId, months: null, price: 0, discount: 0, final: 0 };
  document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('active'));
  document.getElementById(`plan-card-${planId}`).classList.add('active');

  confirmBtn.disabled = true;
  document.getElementById('invoiceBox').classList.add('d-none');
  document.getElementById('inv-discount').classList.add('d-none');
  document.getElementById('inv-final').classList.add('d-none');
  const msg = document.getElementById('couponMessage');
  msg.textContent = '';
  msg.className = 'small';
  rulesCheckbox.checked = false;
  updateConfirmButtonState();
}

/* --- انتخاب مدت‌زمان --- */
document.addEventListener('click', e => {
  const btn = e.target.closest('.duration-btn');
  if (!btn) return;
  const planId = btn.dataset.plan;
  const months = btn.dataset.months;

  btn.closest('.duration-buttons').querySelectorAll('.duration-btn')
      .forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  const plan = plans.find(p => String(p.id) === String(planId));
  const price = plan?.prices?.[months] || 0;

  selected.planId = planId;
  selected.months = months;
  selected.price = price;
  selected.final = price;
  selected.discount = 0;

  document.getElementById(`price-${planId}`).textContent = `${toFa(price)} تومان`;
  updateInvoice(plan.name, months, price);

  updateConfirmButtonState();

  // پاک‌سازی پیام کوپن
  const msg = document.getElementById('couponMessage');
  msg.textContent = '';
  msg.className = 'small';
  document.getElementById('inv-discount').classList.add('d-none');
  document.getElementById('inv-final').classList.add('d-none');
});

/* --- به‌روزرسانی فاکتور --- */
function updateInvoice(planName, months, price) {
  document.getElementById('invoiceBox').classList.remove('d-none');
  document.getElementById('inv-plan').textContent = planName;
  document.getElementById('inv-months').textContent = toFa(months) + ' ماه';
  document.getElementById('inv-price').textContent = toFa(price) + ' تومان';
}

/* --- اعمال کد تخفیف --- */
document.getElementById('applyCouponBtn').addEventListener('click', async () => {
  const code = document.getElementById('couponCode').value.trim();
  const msg = document.getElementById('couponMessage');
  msg.textContent = '';
  msg.className = 'small';

  if (!code) {
    msg.textContent = 'کد تخفیف را وارد کنید.';
    msg.classList.add('text-danger');
    return;
  }

  if (!selected.price || selected.price <= 0) {
    msg.textContent = 'ابتدا پلن و مدت زمان را انتخاب کنید.';
    msg.classList.add('text-warning');
    return;
  }

  try {
    const res = await fetch('{{ route("user.apply_coupon") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ code, price: selected.price })
    });

    const data = await res.json();

    if (data.status === 'success') {
      msg.textContent = data.message;
      msg.classList.add('text-success');

      selected.discount = data.discountAmount;
      selected.final = data.finalPrice;

      document.getElementById('inv-discount').classList.remove('d-none');
      document.getElementById('inv-final').classList.remove('d-none');
      document.getElementById('inv-discount-amount').textContent = toFa(data.discountAmount);
      document.getElementById('inv-final-price').textContent = toFa(data.finalPrice);
    } else {
      msg.textContent = data.message;
      msg.classList.add('text-danger');
    }
  } catch (err) {
    console.error('Coupon Error:', err);
    msg.textContent = 'خطا در ارتباط با سرور.';
    msg.classList.add('text-danger');
  }
});

/* --- ارسال امن به درگاه پرداخت --- */
confirmBtn.addEventListener('click', () => {
  confirmBtn.disabled = true;
  confirmBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> در حال انتقال...';

  // اعتبارسنجی نهایی قبل از ارسال
  if (!selected.planId || !selected.months) {
    alert('لطفاً پلن و مدت زمان اشتراک را انتخاب کنید.');
    confirmBtn.disabled = false;
    confirmBtn.innerHTML = '<i class="bi bi-wallet2 me-1"></i> پرداخت و فعال‌سازی';
    return;
  }

  // ارسال از طریق فرم مخفی برای محافظت CSRF
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = '{{ route("user.payment.start") }}';
  form.innerHTML = `
    @csrf
    <input type="hidden" name="plan_id" value="${selected.planId}">
    <input type="hidden" name="months" value="${selected.months}">
    <input type="hidden" name="coupon_code" value="${document.getElementById('couponCode').value.trim()}">
  `;
  document.body.appendChild(form);
  form.submit();
});
</script>

@endsection
