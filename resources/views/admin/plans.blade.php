@extends('admin.layouts.app')

@section('title', 'مدیریت پلن‌ها')

@section('content')
<div class="container-fluid py-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title m-0">مدیریت پلن‌ها</h4>
        <button class="neon-btn" data-bs-toggle="modal" data-bs-target="#createPlanModal">
            <i class="bi bi-plus-lg"></i> پلن جدید
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mb-3">
            @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
        </div>
    @endif

    <div class="card-glass">
    <!-- نسخه دسکتاپ (جدول) -->
    <div class="table-wrapper d-none d-md-block">
        <div class="table-scroll">
            <table class="table table-dark align-middle table-striped table-hover table-sm mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام پلن</th>
                    <th>پلتفرم</th>
                    <th>قابلیت</th>
                    <th>بازی همزمان</th>
                    <th>مدت‌ها/قیمت</th>
                    <th>تخفیف</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($plans as $i => $plan)
                    <tr>
                        <td>{{ $plans->firstItem() + $i }}</td>
                        <td class="fw-bold">{{ $plan->name }}</td>
                        <td>
                            @php $pf = $plan->platforms ?? []; @endphp
                            {{ in_array('ps4',$pf) ? 'PS4' : '' }}
                            {{ (in_array('ps4',$pf) && in_array('ps5',$pf)) ? ' / ' : '' }}
                            {{ in_array('ps5',$pf) ? 'PS5' : '' }}
                        </td>
                        <td>
                            @switch($plan->capability)
                                @case('online') آنلاین @break
                                @case('offline') آفلاین @break
                                @default هردو
                            @endswitch
                        </td>
                        <td>{{ $plan->concurrent_games }}</td>
                        <td>
                            @php $durs=$plan->durations??[]; @endphp
                            @foreach($durs as $d)
                                <span class="badge bg-info me-1">{{ $d }}م: {{ number_format($plan->priceFor($d)) }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if($plan->has_discount)
                                <span class="badge bg-success">{{ $plan->discount_percent }}%</span>
                            @else
                                <span class="badge bg-secondary">ندارد</span>
                            @endif
                        </td>
                        <td>{!! $plan->active ? '<span class="badge bg-success">فعال</span>' : '<span class="badge bg-secondary">غیرفعال</span>' !!}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info me-1"
                                    data-bs-toggle="modal" data-bs-target="#editPlanModal"
                                    data-plan='@json($plan)'>
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form class="d-inline" method="POST" action="{{ route('admin.plans.destroy', $plan) }}"
                                  onsubmit="return confirm('حذف شود؟')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted">پلنی ثبت نشده است.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- نسخه موبایل (کارت‌ها) -->
    <div class="d-md-none">
        @forelse($plans as $i => $plan)
            <div class="plan-card mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0">{{ $plan->name }}</h6>
                    {!! $plan->active ? '<span class="badge bg-success">فعال</span>' : '<span class="badge bg-secondary">غیرفعال</span>' !!}
                </div>
                <div class="small text-muted mb-2">
                    <i class="bi bi-controller me-1"></i> پلتفرم:
                    @php $pf = $plan->platforms ?? []; @endphp
                    {{ in_array('ps4',$pf) ? 'PS4' : '' }}
                    {{ (in_array('ps4',$pf) && in_array('ps5',$pf)) ? ' / ' : '' }}
                    {{ in_array('ps5',$pf) ? 'PS5' : '' }}
                </div>
                <div class="row small">
                    <div class="col-6"><b>قابلیت:</b> 
                        @switch($plan->capability)
                            @case('online') آنلاین @break
                            @case('offline') آفلاین @break
                            @default هردو
                        @endswitch
                    </div>
                    <div class="col-6"><b>بازی همزمان:</b> {{ $plan->concurrent_games }}</div>
                    <div class="col-12 mt-1"><b>مدت‌ها/قیمت:</b>
                        @php $durs=$plan->durations??[]; @endphp
                        @foreach($durs as $d)
                            <span class="badge bg-info me-1">{{ $d }}م: {{ number_format($plan->priceFor($d)) }}</span>
                        @endforeach
                    </div>
                    <div class="col-6 mt-1"><b>تخفیف:</b>
                        @if($plan->has_discount)
                            <span class="badge bg-success">{{ $plan->discount_percent }}%</span>
                        @else
                            <span class="badge bg-secondary">ندارد</span>
                        @endif
                    </div>
                </div>
                <div class="mt-2 text-end">
                    <button class="btn btn-sm btn-outline-info me-1"
                            data-bs-toggle="modal" data-bs-target="#editPlanModal"
                            data-plan='@json($plan)'>
                        <i class="bi bi-pencil"></i> ویرایش
                    </button>
                    <form class="d-inline" method="POST" action="{{ route('admin.plans.destroy', $plan) }}"
                          onsubmit="return confirm('حذف شود؟')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> حذف</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-3">پلنی ثبت نشده است.</div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $plans->links('pagination::bootstrap-5') }}
    </div>
</div>


</div>

{{-- ===== Modal: Create ===== --}}
<div class="modal fade" id="createPlanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" style="max-height: 95vh;">
    <div class="modal-content bg-dark text-white">
      <form method="POST" action="{{ route('admin.plans.store') }}">
        @csrf
        <div class="modal-header border-0">
          <h5 class="modal-title">افزودن پلن جدید</h5>
          <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">نام پلن</label>
              <input name="name" class="form-control" placeholder="مثلاً Thrill Pro" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">پلتفرم</label>
              <div class="d-flex gap-3 mt-2">
                <label class="form-check">
                  <input class="form-check-input" type="checkbox" name="platforms[]" value="ps4">
                  <span class="form-check-label">PS4</span>
                </label>
                <label class="form-check">
                  <input class="form-check-input" type="checkbox" name="platforms[]" value="ps5">
                  <span class="form-check-label">PS5</span>
                </label>
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label">قابلیت اجرا</label>
              <select name="capability" class="form-select">
                <option value="both">هردو</option>
                <option value="online">آنلاین</option>
                <option value="offline">آفلاین</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">تعداد بازی همزمان</label>
              <select name="concurrent_games" class="form-select">
                @for($i=1;$i<=30;$i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">لیست بازی‌ها</label>
              <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" name="all_ps_store" value="1" id="all_ps_store">
                <label class="form-check-label" for="all_ps_store">کلیه بازی‌های استور سونی</label>
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label">تعداد بازی انتخابی سطح 1</label>
              <select name="level1_selection" class="form-select">
                @for($i=1;$i<=30;$i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">محدودیت تعویض بازی</label>
              <select name="swap_limit" class="form-select">
                <option value="10d">۱۰ روزه</option>
                <option value="15d">۱۵ روزه</option>
                <option value="1m">۱ ماهه</option>
                <option value="2m">۲ ماهه</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">نصب دیتا</label>
              <div class="d-flex gap-3 mt-2">
                <label class="form-check">
                  <input class="form-check-input" type="checkbox" name="install_options[]" value="online">
                  <span class="form-check-label">آنلاین توسط کاربر</span>
                </label>
                <label class="form-check">
                  <input class="form-check-input" type="checkbox" name="install_options[]" value="inperson">
                  <span class="form-check-label">حضوری (رایگان)</span>
                </label>
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label">نوع بازی</label>
              <input name="game_type" class="form-control" placeholder="مثلاً اکشن / شوتر ...">
            </div>

            <div class="col-md-4">
              <label class="form-label d-block">تخفیف دارد؟</label>
              <div class="d-flex align-items-center gap-2">
                <div class="form-check">
                  <input class="form-check-input toggle-discount" type="checkbox" name="has_discount" value="1" id="has_discount_create">
                  <label class="form-check-label" for="has_discount_create">بله</label>
                </div>
                <input name="discount_percent" class="form-control w-auto d-none discount-percent-input" placeholder="درصد" inputmode="numeric">
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label d-block">بازی رایگان؟</label>
              <div class="d-flex align-items-center gap-2">
                <div class="form-check">
                  <input class="form-check-input toggle-free" type="checkbox" name="has_free_games" value="1" id="has_free_create">
                  <label class="form-check-label" for="has_free_create">بله</label>
                </div>
                <select name="free_games_count" class="form-select w-auto d-none free-count-input">
                  <option value="">— تعداد —</option>
                  @for($i=1;$i<=30;$i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </div>
            </div>

            <div class="col-12">
              <label class="form-label">توضیحات</label>
              <textarea name="description" class="form-control" rows="3" placeholder="توضیحات پلن..."></textarea>
            </div>

            <div class="col-12"><hr class="divider"></div>

            <div class="col-12">
              <label class="form-label d-block">مدت زمان‌های اشتراک</label>
              <div class="d-flex flex-wrap gap-3">
                <label class="form-check">
                  <input class="form-check-input dur-toggle" type="checkbox" name="dur_3" value="1" data-target="#price3_create">
                  <span class="form-check-label">۳ ماهه</span>
                </label>
                <input id="price3_create" name="price_3" class="form-control w-auto d-none" placeholder="قیمت ۳ ماهه" inputmode="numeric">

                <label class="form-check">
                  <input class="form-check-input dur-toggle" type="checkbox" name="dur_6" value="1" data-target="#price6_create">
                  <span class="form-check-label">۶ ماهه</span>
                </label>
                <input id="price6_create" name="price_6" class="form-control w-auto d-none" placeholder="قیمت ۶ ماهه" inputmode="numeric">

                <label class="form-check">
                  <input class="form-check-input dur-toggle" type="checkbox" name="dur_12" value="1" data-target="#price12_create">
                  <span class="form-check-label">۱۲ ماهه</span>
                </label>
                <input id="price12_create" name="price_12" class="form-control w-auto d-none" placeholder="قیمت ۱۲ ماهه" inputmode="numeric">
              </div>
              <small class="muted d-block mt-2">هر مدت زمانی که تیک می‌خورد، فیلد قیمتش ظاهر می‌شود.</small>
            </div>

            <div class="col-md-4">
              <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" name="active" value="1" id="active_create" checked>
                <label class="form-check-label" for="active_create">فعال باشد</label>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer border-0">
          <button class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
          <button class="neon-btn">ذخیره پلن</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ===== Modal: Edit ===== --}}
<div class="modal fade" id="editPlanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" style="max-height: 95vh;">
    <div class="modal-content bg-dark text-white">
      <form method="POST" id="editPlanForm">
        @csrf @method('PUT')
        <div class="modal-header border-0">
          <h5 class="modal-title">ویرایش پلن</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">نام پلن</label>
              <input name="name" id="edit_name" class="form-control" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">پلتفرم</label>
              <div class="d-flex gap-3 mt-2">
                <label class="form-check">
                  <input class="form-check-input" type="checkbox" name="platforms[]" value="ps4" id="edit_pf_ps4">
                  <span class="form-check-label">PS4</span>
                </label>
                <label class="form-check">
                  <input class="form-check-input" type="checkbox" name="platforms[]" value="ps5" id="edit_pf_ps5">
                  <span class="form-check-label">PS5</span>
                </label>
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label">قابلیت اجرا</label>
              <select name="capability" id="edit_capability" class="form-select">
                <option value="both">هردو</option>
                <option value="online">آنلاین</option>
                <option value="offline">آفلاین</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">تعداد بازی همزمان</label>
              <select name="concurrent_games" id="edit_concurrent" class="form-select">
                @for($i=1;$i<=30;$i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">لیست بازی‌ها</label>
              <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" name="all_ps_store" value="1" id="edit_all_ps_store">
                <label class="form-check-label" for="edit_all_ps_store">کلیه بازی‌های استور سونی</label>
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label">تعداد بازی انتخابی سطح 1</label>
              <select name="level1_selection" id="edit_level1" class="form-select">
                @for($i=1;$i<=30;$i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">محدودیت تعویض بازی</label>
              <select name="swap_limit" id="edit_swap_limit" class="form-select">
                <option value="10d">۱۰ روزه</option>
                <option value="15d">۱۵ روزه</option>
                <option value="1m">۱ ماهه</option>
                <option value="2m">۲ ماهه</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">نصب دیتا</label>
              <div class="d-flex gap-3 mt-2">
                <label class="form-check">
                  <input class="form-check-input" type="checkbox" name="install_options[]" value="online" id="edit_install_online">
                  <span class="form-check-label">آنلاین توسط کاربر</span>
                </label>
                <label class="form-check">
                  <input class="form-check-input" type="checkbox" name="install_options[]" value="inperson" id="edit_install_inperson">
                  <span class="form-check-label">حضوری (رایگان)</span>
                </label>
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label">نوع بازی</label>
              <input name="game_type" id="edit_game_type" class="form-control">
            </div>

            <div class="col-md-4">
              <label class="form-label d-block">تخفیف دارد؟</label>
              <div class="d-flex align-items-center gap-2">
                <div class="form-check">
                  <input class="form-check-input toggle-discount" type="checkbox" name="has_discount" value="1" id="edit_has_discount">
                  <label class="form-check-label" for="edit_has_discount">بله</label>
                </div>
                <input name="discount_percent" id="edit_discount_percent" class="form-control w-auto d-none discount-percent-input" placeholder="درصد" inputmode="numeric">
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label d-block">بازی رایگان؟</label>
              <div class="d-flex align-items-center gap-2">
                <div class="form-check">
                  <input class="form-check-input toggle-free" type="checkbox" name="has_free_games" value="1" id="edit_has_free">
                  <label class="form-check-label" for="edit_has_free">بله</label>
                </div>
                <select name="free_games_count" id="edit_free_count" class="form-select w-auto d-none free-count-input">
                  <option value="">— تعداد —</option>
                  @for($i=1;$i<=30;$i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
              </div>
            </div>

            <div class="col-12">
              <label class="form-label">توضیحات</label>
              <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
            </div>

            <div class="col-12"><hr class="divider"></div>

            <div class="col-12">
              <label class="form-label d-block">مدت زمان‌های اشتراک</label>
              <div class="d-flex flex-wrap gap-3 align-items-center">
                <label class="form-check">
                  <input class="form-check-input dur-toggle" type="checkbox" name="dur_3" value="1" data-target="#price3_edit" id="edit_dur3">
                  <span class="form-check-label">۳ ماهه</span>
                </label>
                <input id="price3_edit" name="price_3" class="form-control w-auto d-none" placeholder="قیمت ۳ ماهه" inputmode="numeric">

                <label class="form-check">
                  <input class="form-check-input dur-toggle" type="checkbox" name="dur_6" value="1" data-target="#price6_edit" id="edit_dur6">
                  <span class="form-check-label">۶ ماهه</span>
                </label>
                <input id="price6_edit" name="price_6" class="form-control w-auto d-none" placeholder="قیمت ۶ ماهه" inputmode="numeric">

                <label class="form-check">
                  <input class="form-check-input dur-toggle" type="checkbox" name="dur_12" value="1" data-target="#price12_edit" id="edit_dur12">
                  <span class="form-check-label">۱۲ ماهه</span>
                </label>
                <input id="price12_edit" name="price_12" class="form-control w-auto d-none" placeholder="قیمت ۱۲ ماهه" inputmode="numeric">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" name="active" value="1" id="edit_active">
                <label class="form-check-label" for="edit_active">فعال باشد</label>
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer border-0">
          <button class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
          <button class="neon-btn">ذخیره تغییرات</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  // Placeholderها در تم روشن/تیره روشن و خوانا باشن (اگر global داری، نیاز نیست)
  document.querySelectorAll('input::placeholder, textarea::placeholder').forEach(()=>{});

  // نمایش/مخفی‌سازی فیلدهای وابسته (تخفیف / بازی رایگان / قیمت مدت‌ها)
  function bindDynamicToggles(scope){
    // discount
    scope.querySelectorAll('.toggle-discount').forEach(chk=>{
      const percent = scope.querySelector('.discount-percent-input');
      const toggle = ()=> { percent?.classList.toggle('d-none', !chk.checked); if(!chk.checked) percent.value=''; };
      chk.addEventListener('change', toggle); toggle();
    });

    // free games
    scope.querySelectorAll('.toggle-free').forEach(chk=>{
      const cnt = scope.querySelector('.free-count-input');
      const toggle = ()=> { cnt?.classList.toggle('d-none', !chk.checked); if(!chk.checked) cnt.value=''; };
      chk.addEventListener('change', toggle); toggle();
    });

    // durations -> price inputs
    scope.querySelectorAll('.dur-toggle').forEach(chk=>{
      const targetSel = chk.getAttribute('data-target');
      const price = targetSel ? scope.querySelector(targetSel) : null;
      const toggle = ()=> { if(price){ price.classList.toggle('d-none', !chk.checked); if(!chk.checked) price.value=''; } };
      chk.addEventListener('change', toggle); toggle();
    });
  }

  // Create modal
  const createModalEl = document.getElementById('createPlanModal');
  createModalEl?.addEventListener('shown.bs.modal', ()=> bindDynamicToggles(createModalEl));

  // Edit modal: پر کردن اطلاعات پلن
  const editModalEl = document.getElementById('editPlanModal');
  editModalEl?.addEventListener('show.bs.modal', (ev)=>{
    const btn = ev.relatedTarget;
    const plan = JSON.parse(btn.getAttribute('data-plan'));

    const form = document.getElementById('editPlanForm');
    form.setAttribute('action', "{{ route('admin.plans.update', ':id') }}".replace(':id', plan.id));

    // نام
    document.getElementById('edit_name').value = plan.name ?? '';

    // پلتفرم
    document.getElementById('edit_pf_ps4').checked = (plan.platforms||[]).includes('ps4');
    document.getElementById('edit_pf_ps5').checked = (plan.platforms||[]).includes('ps5');

    // capability
    document.getElementById('edit_capability').value = plan.capability ?? 'both';

    // اعداد
    document.getElementById('edit_concurrent').value = plan.concurrent_games ?? 1;
    document.getElementById('edit_level1').value = plan.level1_selection ?? 1;

    // all_ps_store
    document.getElementById('edit_all_ps_store').checked = !!plan.all_ps_store;

    // swap_limit
    document.getElementById('edit_swap_limit').value = plan.swap_limit ?? '1m';

    // نصب دیتا
    const inst = plan.install_options||[];
    document.getElementById('edit_install_online').checked   = inst.includes('online');
    document.getElementById('edit_install_inperson').checked = inst.includes('inperson');

    // نوع بازی
    document.getElementById('edit_game_type').value = plan.game_type ?? '';

    // تخفیف
    const hasDisc = !!plan.has_discount;
    document.getElementById('edit_has_discount').checked = hasDisc;
    document.getElementById('edit_discount_percent').value = plan.discount_percent ?? '';

    // بازی رایگان
    const hasFree = !!plan.has_free_games;
    document.getElementById('edit_has_free').checked = hasFree;
    document.getElementById('edit_free_count').value = plan.free_games_count ?? '';

    // توضیحات
    document.getElementById('edit_description').value = plan.description ?? '';

    // مدت‌ها و قیمت‌ها
    const durs = plan.durations||[];
    const prices = plan.prices||{};

    const d3  = document.getElementById('edit_dur3');
    const d6  = document.getElementById('edit_dur6');
    const d12 = document.getElementById('edit_dur12');
    const p3  = document.getElementById('price3_edit');
    const p6  = document.getElementById('price6_edit');
    const p12 = document.getElementById('price12_edit');

    d3.checked = durs.includes(3);  p3.value  = prices['3']  ?? '';  p3.classList.toggle('d-none', !d3.checked);
    d6.checked = durs.includes(6);  p6.value  = prices['6']  ?? '';  p6.classList.toggle('d-none', !d6.checked);
    d12.checked= durs.includes(12); p12.value = prices['12'] ?? '';  p12.classList.toggle('d-none', !d12.checked);

    // active
    document.getElementById('edit_active').checked = !!plan.active;

    // Bind toggles
    bindDynamicToggles(editModalEl);
  });
</script>
@endpush
