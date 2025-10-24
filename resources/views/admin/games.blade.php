{{-- resources/views/admin/games.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'مدیریت بازی‌ها')

@php
    use Morilog\Jalali\Jalalian;
@endphp

@section('content')
    <style>
        /* هماهنگی با تم فعلی + خوانایی placeholder در هر دو حالت روشن/تیره */
        .card-glass { background: var(--panel); border: 1px solid var(--border); border-radius: 14px; padding: 1rem; }
        .section-title { background: var(--grad); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 800; }
        .neon-btn { background: var(--grad); border: none; border-radius: 12px; color: #0a0e27; font-weight: 700; padding: .55rem 1rem; box-shadow: 0 0 20px rgba(0,255,255,.25); transition: .2s; }
        .neon-btn:hover { box-shadow: 0 0 35px rgba(255,0,255,.4); transform: translateY(-1px); }
        .form-control, .form-select { background: var(--panel); border: 1px solid var(--border); color: var(--text); }
        .form-control::placeholder { color: var(--placeholder); }
        .table thead th { border-bottom: 1px solid var(--border); }
        .table td, .table th { border-color: var(--border); vertical-align: middle; }
        .cover-img { width: 64px; height: 40px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border); }
        .badge-status { border-radius: 999px; }
        .btn-icon { padding: .35rem .55rem; }
        .text-muted-rtl { color: var(--muted); }
        .filter-chip { font-size: .85rem; color: var(--muted); }
        .table-responsive { overflow-x: auto; }
        @media (max-width: 992px) {
            .filters-stack > * { margin-bottom: .5rem; }
        }
        /* ===== کارت‌های موبایل برای بازی‌ها ===== */
        .game-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 14px;
        padding: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.25);
        backdrop-filter: blur(12px);
        }

        [data-theme="light"] .game-card {
        background: #fff;
        border-color: #e4e7ec;
        }

        .game-card img {
        flex-shrink: 0;
        }

        .game-card small {
        color: var(--muted);
        }

        /* برای حالت خیلی کوچک‌تر */
        @media (max-width: 576px) {
        .game-card {
            padding: 0.85rem;
            font-size: 0.85rem;
        }
        }
        .text-muted {
        --bs-text-opacity: 1;
        color: rgba(249, 252, 255, 0.75) !important;
        }

    </style>

    {{-- هدر بخش + اکشن‌ها --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
        <h4 class="section-title m-0">مدیریت بازی‌ها</h4>
        <div class="d-flex align-items-center gap-2">
            <button class="neon-btn" data-bs-toggle="modal" data-bs-target="#gameModal"
                    data-mode="create">
                <i class="bi bi-plus-lg"></i> بازی جدید
            </button>
        </div>
    </div>

    {{-- فیلترها / جستجو --}}
    <div class="card-glass mb-3">
        <form method="GET" action="{{ route('admin.games.index') }}">
            <div class="row g-2 align-items-end filters-stack">
                <div class="col-md-4">
                    <label class="form-label">جستجو</label>
                    <input type="text" name="q" class="form-control"
                           value="{{ request('q') }}"
                           placeholder="نام بازی یا ژانر را جستجو کنید...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">ژانر</label>
                    <input type="text" name="genre" class="form-control"
                           value="{{ request('genre') }}"
                           placeholder="مثلاً: اکشن، ورزشی، ماجراجویی">
                </div>
                <div class="col-md-3">
                    <label class="form-label">وضعیت</label>
                    <select name="status" class="form-select">
                        <option value="">همه</option>
                        <option value="active" {{ request('status')==='active' ? 'selected' : '' }}>فعال</option>
                        <option value="inactive" {{ request('status')==='inactive' ? 'selected' : '' }}>غیرفعال</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <button class="neon-btn w-100" type="submit">
                        <i class="bi bi-search"></i> جستجو
                    </button>
                </div>
            </div>
        </form>

        {{-- چیپ‌های وضعیت فیلتر فعال --}}
        @if(request()->filled('q') || request()->filled('genre') || request()->filled('status'))
            <div class="mt-2 d-flex flex-wrap gap-2">
                <span class="filter-chip">فیلترها:</span>
                @if(request('q')) <span class="badge bg-info-subtle text-dark">جستجو: {{ e(request('q')) }}</span> @endif
                @if(request('genre')) <span class="badge bg-info-subtle text-dark">ژانر: {{ e(request('genre')) }}</span> @endif
                @if(request('status') !== null && request('status') !== '')
                    <span class="badge bg-info-subtle text-dark">
                        وضعیت: {{ request('status')==='active' ? 'فعال' : 'غیرفعال' }}
                    </span>
                @endif
                <a href="{{ route('admin.games.index') }}" class="btn btn-sm btn-outline-light ms-auto">
                    حذف فیلترها
                </a>
            </div>
        @endif
    </div>

    {{-- پیام‌های وضعیت --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $e)
                <div>{{ $e }}</div>
            @endforeach
        </div>
    @endif

    <div class="card-glass">
    <!-- نسخه دسکتاپ (جدول) -->
    <div class="table-wrapper d-none d-md-block">
        <div class="table-scroll">
            <table class="table table-dark align-middle mb-0">
                <thead>
                <tr>
                    <th style="width:70px;">#</th>
                    <th style="width:90px;">کاور</th>
                    <th>نام بازی</th>
                    <th style="width:180px;">ژانر</th>
                    <th style="width:160px;">تاریخ افزودن</th>
                    <th style="width:120px;">وضعیت</th>
                    <th style="width:140px;">عملیات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($games as $index => $game)
                    <tr>
                        <td>{{ \Morilog\Jalali\CalendarUtils::convertNumbers(($games->firstItem() ?? 1) + $index) }}</td>
                        <td>
                            <img src="{{ $game->cover_url }}" alt="cover" class="cover-img rounded" style="width:60px; height:40px; object-fit:cover;">
                        </td>
                        <td class="fw-semibold">{{ $game->name }}</td>
                        <td>{{ $game->genre ?: '—' }}</td>
                        <td class="text-muted-rtl">{{ Jalalian::fromCarbon($game->created_at)->format('Y/m/d') }}</td>
                        <td>
                            @if($game->status === 'active')
                                <span class="badge bg-success badge-status">فعال</span>
                            @else
                                <span class="badge bg-secondary badge-status">غیرفعال</span>
                            @endif
                        </td>
                        <td>
                            <button
                                type="button"
                                class="btn btn-sm btn-outline-info me-1"
                                data-bs-toggle="modal" data-bs-target="#gameModal"
                                data-mode="edit"
                                data-id="{{ $game->id }}"
                                data-name="{{ $game->name }}"
                                data-genre="{{ $game->genre }}"
                                data-status="{{ $game->status }}"
                                data-cover="{{ $game->cover ? asset('storage/'.$game->cover) : '' }}"
                                title="ویرایش">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <form method="POST" action="{{ route('admin.games.destroy', $game) }}" class="d-inline"
                                  onsubmit="return confirm('حذف این بازی قطعی است. ادامه می‌دهید؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">هیچ بازی‌ای یافت نشد.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- نسخه موبایل (کارت‌ها) -->
    <div class="d-md-none">
        @forelse($games as $index => $game)
            <div class="game-card mb-3">
                <div class="d-flex align-items-center mb-2">
                    <img src="{{ $game->cover_url }}" alt="cover" class="rounded me-2" style="width:64px;height:40px;object-fit:cover;">
                    <div>
                        <h6 class="fw-bold mb-0">{{ $game->name }}</h6>
                        <small class="text-muted">{{ $game->genre ?: 'بدون ژانر' }}</small>
                    </div>
                    <div class="ms-auto">
                        @if($game->status === 'active')
                            <span class="badge bg-success">فعال</span>
                        @else
                            <span class="badge bg-secondary">غیرفعال</span>
                        @endif
                    </div>
                </div>

                <div class="small text-muted mb-2">
                    <i class="bi bi-calendar-event me-1"></i>
                    {{ Jalalian::fromCarbon($game->created_at)->format('Y/m/d') }}
                </div>

                <div class="text-end">
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-info me-1"
                        data-bs-toggle="modal" data-bs-target="#gameModal"
                        data-mode="edit"
                        data-id="{{ $game->id }}"
                        data-name="{{ $game->name }}"
                        data-genre="{{ $game->genre }}"
                        data-status="{{ $game->status }}"
                        data-cover="{{ $game->cover ? asset('storage/'.$game->cover) : '' }}">
                        <i class="bi bi-pencil"></i> ویرایش
                    </button>

                    <form method="POST" action="{{ route('admin.games.destroy', $game) }}" class="d-inline"
                          onsubmit="return confirm('حذف این بازی قطعی است؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i> حذف
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">هیچ بازی‌ای ثبت نشده است.</div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $games->links('pagination::bootstrap-5') }}
    </div>
</div>

    {{-- مودال افزودن/ویرایش بازی (یک مودال چندمنظوره) --}}
    <div class="modal fade" id="gameModal" tabindex="-1" aria-labelledby="gameModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form id="gameForm" method="POST" enctype="multipart/form-data" class="modal-content"
                  style="background: linear-gradient(135deg, rgba(18, 24, 54, 0.96), rgba(30, 16, 66, 0.94)); color: var(--text); border: 1px solid var(--border)">
                @csrf
                <input type="hidden" name="_method" value="POST" id="methodField">

                <div class="modal-header border-0">
                    <h5 class="modal-title" id="gameModalLabel">افزودن بازی جدید</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">نام بازی <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="gameName" class="form-control" required
                               placeholder="مثلاً: Call of Duty">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ژانر</label>
                        <input type="text" name="genre" id="gameGenre" class="form-control"
                               placeholder="اکشن، ورزشی، ماجراجویی...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">وضعیت</label>
                        <select name="status" id="gameStatus" class="form-select">
                            <option value="active">فعال</option>
                            <option value="inactive">غیرفعال</option>
                        </select>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">کاور (اختیاری)</label>
                        <input type="file" name="cover" id="gameCover" class="form-control"
                               accept="image/*">
                        <div class="small text-muted-rtl mt-1">
                            فرمت‌های مجاز: jpg, jpeg, png — حداکثر 2MB
                        </div>
                    </div>

                    <div class="mt-3 d-none" id="coverPreviewWrap">
                        <label class="form-label">پیش‌نمایش کاور</label>
                        <img id="coverPreview" src="" alt="preview"
                             style="width:160px;height:100px;object-fit:cover;border-radius:8px;border:1px solid var(--border)">
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="neon-btn">ذخیره</button>
                </div>
            </form>
        </div>
    </div>

    {{-- اسکریپت‌های صفحه --}}
    <script>
        // پیش‌نمایش فایل کاور
        const coverInput = document.getElementById('gameCover');
        const coverPreviewWrap = document.getElementById('coverPreviewWrap');
        const coverPreview = document.getElementById('coverPreview');

        coverInput?.addEventListener('change', function () {
            const file = this.files?.[0];
            if (!file) { coverPreviewWrap.classList.add('d-none'); return; }
            const url = URL.createObjectURL(file);
            coverPreview.src = url;
            coverPreviewWrap.classList.remove('d-none');
        });

        // مودال چندمنظوره: افزودن/ویرایش
        const gameModal = document.getElementById('gameModal');
        const gameForm  = document.getElementById('gameForm');
        const methodFld = document.getElementById('methodField');
        const modalTitle= document.getElementById('gameModalLabel');
        const nameFld   = document.getElementById('gameName');
        const genreFld  = document.getElementById('gameGenre');
        const statusFld = document.getElementById('gameStatus');

        gameModal?.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            const mode = btn?.getAttribute('data-mode') || 'create';

            if (mode === 'create') {
                // تنظیمات حالت افزودن
                modalTitle.textContent = 'افزودن بازی جدید';
                gameForm.action = "{{ route('admin.games.store') }}";
                methodFld.value = "POST";
                nameFld.value = '';
                genreFld.value = '';
                statusFld.value = 'active';
                coverInput.value = '';
                coverPreviewWrap.classList.add('d-none');
            } else {
                // حالت ویرایش
                const id     = btn.getAttribute('data-id');
                const name   = btn.getAttribute('data-name') || '';
                const genre  = btn.getAttribute('data-genre') || '';
                const cover  = btn.getAttribute('data-cover') || '';

                modalTitle.textContent = 'ویرایش بازی';
                gameForm.action = "{{ route('admin.games.update', '__ID__') }}".replace('__ID__', id);
                methodFld.value = "PUT";

                nameFld.value = name;
                genreFld.value = genre;
                const status = btn.getAttribute('data-status') || 'active';
                statusFld.value = status;

                // پیش‌نمایش کاور موجود
                if (cover) {
                    coverPreview.src = cover;
                    coverPreviewWrap.classList.remove('d-none');
                } else {
                    coverPreviewWrap.classList.add('d-none');
                }
                coverInput.value = '';
            }
        });
    </script>
@endsection

