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
    .modal-xxl {
  max-width: 1400px;
}

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
}

.plan-features {
  list-style: none;
  padding: 0;
  margin: 0 0 0.5rem 0;
  font-size: 0.9rem;
  color: #bcd;
}

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
{{-- <div class="modal fade" id="purchaseModal" tabindex="-1" aria-hidden="true">
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
</div> --}}
<div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xxl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content modal-subscribe text-white">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold text-info">
          <i class="bi bi-bag-plus me-2"></i> خرید اشتراک
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- راهنمای مراحل -->
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
        <div id="invoiceBox" class="invoice-box d-none">
          <div>پلن انتخابی: <span id="inv-plan">—</span></div>
          <div>مدت زمان: <span id="inv-months">—</span></div>
          <div>مبلغ قابل پرداخت: <span id="inv-price">—</span></div>
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
    // اطمینان از فعال بودن کلیک روی مدال‌ها
    document.addEventListener('show.bs.modal', (e) => {
        document.body.classList.add('modal-open');
        document.querySelectorAll('.modal-backdrop').forEach(el => el.style.pointerEvents = 'none');
    });
</script>
<script>
  const plans = @json($plans);
  let selected = { planId: null, months: null, price: 0 };
  const toFa = n => new Intl.NumberFormat('fa-IR').format(Number(n || 0));

  function selectPlan(planId) {
    selected.planId = planId;
    selected.months = null;
    document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('active'));
    document.getElementById(`plan-card-${planId}`).classList.add('active');
    document.getElementById('confirmPlanBtn').disabled = true;
    document.getElementById('invoiceBox').classList.add('d-none');
  }

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
    document.getElementById(`price-${planId}`).textContent = `${toFa(price)} تومان`;

    selected = { planId, months, price };
    updateInvoice(plan.name, months, price);
    document.getElementById('confirmPlanBtn').disabled = false;
  });

  function updateInvoice(planName, months, price) {
    document.getElementById('invoiceBox').classList.remove('d-none');
    document.getElementById('inv-plan').textContent = planName;
    document.getElementById('inv-months').textContent = toFa(months) + ' ماه';
    document.getElementById('inv-price').textContent = toFa(price) + ' تومان';
  }
</script>





@endsection

