@extends('user.layouts.app')

@section('title', 'لیست بازی‌های منطقه هیجان')

@section('extra-styles')
    <style>
        .card-glass {
            background: rgba(16,21,52,.88);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.35);
            backdrop-filter: blur(18px);
        }
        .section-title {
            background: linear-gradient(135deg,#00f5ff,#ff4dff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }
        .neon-btn {
            background: linear-gradient(135deg,#00f5ff,#ff4dff);
            border: none;
            border-radius: 12px;
            color: #06163c;
            font-weight: 700;
            padding: .65rem 1.5rem;
            box-shadow: 0 0 25px rgba(0,255,255,.35);
            transition: .2s;
        }
        .neon-btn:hover {
            box-shadow: 0 0 35px rgba(255,0,255,.45);
            transform: translateY(-1px);
        }
        .form-control,
        .form-select {
            background: rgba(6,10,35,.65);
            border: 1px solid rgba(255,255,255,.1);
            color: #fff;
        }
        .form-control::placeholder {
            color: rgba(255,255,255,.45);
        }
        .table-wrapper { position: relative; }
        .table-scroll { overflow-x: auto; }
        .table {
            color: #fff;
            background: transparent;
        }
        .table.table-dark {
            --bs-table-bg: transparent;
            --bs-table-striped-bg: rgba(255,255,255,.03);
            --bs-table-striped-color: #fff;
            --bs-table-hover-bg: rgba(0,0,0,.2);
            --bs-table-hover-color: #fff;
        }
        .table thead th {
            border-bottom: 1px solid rgba(255,255,255,.12);
            color: #9fe3ff;
            font-size: .9rem;
            white-space: nowrap;
        }
        .table td,
        .table th {
            border-color: rgba(255,255,255,.07);
            vertical-align: middle;
            font-size: .95rem;
        }
        .cover-img {
            width: 64px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid rgba(255,255,255,.08);
        }
        .badge-soft {
            border-radius: 999px;
            padding: .35rem .9rem;
            font-size: .78rem;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,.12);
        }
        .badge-type-original { background: rgba(0,255,255,.18); color: #7bfffb; }
        .badge-type-free { background: rgba(40,167,69,.18); color: #9affb1; }
        .badge-type-default { background: rgba(255,255,255,.1); color: #fff; }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }
        .empty-state .icon {
            font-size: 3rem;
            color: #2ddfff;
            margin-bottom: 1rem;
        }
        .mobile-cards { display: none; }
        .game-card {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 14px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .game-card .card-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: .35rem;
            font-size: .9rem;
        }
        .game-card .card-row span:first-child {
            color: rgba(255,255,255,.6);
        }
        .pagination-glass .page-item .page-link {
            background: rgba(10,15,40,.7);
            border: 1px solid rgba(255,255,255,.1);
            color: #cde8ff;
            border-radius: 12px;
            padding: .4rem .85rem;
            display: flex;
            align-items: center;
            gap: .35rem;
        }
        .pagination-glass .page-item .page-link:hover {
            color: #00f5ff;
            border-color: rgba(0,245,255,.5);
        }
        .pagination-glass .page-item.active .page-link {
            background: linear-gradient(135deg,#00f5ff,#ff4dff);
            color: #06163c;
            border-color: transparent;
        }
        .pagination-glass .page-item.disabled .page-link {
            opacity: .5;
        }
        .filters-stack > * {
            margin-bottom: .75rem;
        }
        @media (max-width: 992px) {
            .table-wrapper { display: none; }
            .mobile-cards { display: block; }
        }
    </style>
@endsection

@section('content')
    @php
        $selectedType = $selectedType ?? null;
        $selectedLevel = $selectedLevel ?? null;

        $typeMap = [
            'original' => ['label' => 'نسخه اصلی', 'class' => 'badge-type-original'],
            'free'     => ['label' => 'رایگان', 'class' => 'badge-type-free'],
        ];

        $levelLabel = static function ($level) {
            if ($level === null || $level === '') {
                return 'نامشخص';
            }
            return ((int) $level === 1) ? 'سطح ۱' : 'سطح ۲ و بیشتر';
        };
    @endphp
    @php
        $typeMap = [
            'original' => ['label' => 'نسخه اصلی', 'class' => 'badge-type-original'],
            'free'     => ['label' => 'رایگان', 'class' => 'badge-type-free'],
        ];

        $levelLabel = static function ($level) {
            if ($level === null || $level === '') {
                return 'نامشخص';
            }
            return ((int) $level === 1) ? 'سطح ۱' : 'سطح ۲ و بیشتر';
        };
    @endphp
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-4 gap-2">
        <div>
            <h3 class="section-title mb-0">بازی‌های منطقه هیجان</h3>
            <p class="text-secondary mb-0">در این قسمت میتوانید تمامی بازی های موجود و فعال در حال حاضر  برای انتخاب را مشاهده نمایید</p>
        </div>
        <span class="text-muted small">تعداد کل: {{ $games->total() }}</span>
    </div>

    <div class="card-glass mb-4">
        <form method="GET" action="{{ route('user.games') }}">
            <div class="row g-3 align-items-end filters-stack">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <label class="form-label text-light">جستجو در بازی‌ها</label>
                    <input type="text"
                           class="form-control"
                           name="q"
                           value="{{ $search }}"
                           placeholder="نام بازی، ژانر یا نوع را بنویسید...">
                </div>
                <div class="col-lg-3 col-md-5 col-sm-6">
                    <label class="form-label text-light">نوع بازی</label>
                    <select class="form-select text-white"
                            name="type">
                        <option value="">همه انواع</option>
                        <option value="original" {{ $selectedType === 'original' ? 'selected' : '' }}>نسخه اصلی</option>
                        <option value="free" {{ $selectedType === 'free' ? 'selected' : '' }}>رایگان</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <label class="form-label text-light">سطح</label>
                    <select class="form-select text-white"
                            name="level">
                        <option value="">همه سطوح</option>
                        <option value="1" {{ $selectedLevel === '1' ? 'selected' : '' }}>سطح ۱</option>
                        <option value="2_plus" {{ $selectedLevel === '2_plus' ? 'selected' : '' }}>سطح ۲ و بیشتر</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6">
                    <button class="neon-btn w-100" type="submit">
                        <i class="bi bi-search"></i> جستجو
                    </button>
                </div>
                <div class="col-md-2 col-sm-6">
                    <a href="{{ route('user.games') }}" class="btn btn-outline-light w-100">
                        ریست
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($games->isEmpty())
        <div class="card-glass empty-state">
            <div class="icon"><i class="bi bi-controller"></i></div>
            <h5 class="text-light">در حال حاضر بازی فعالی ثبت نشده است</h5>
            <p class="text-secondary mb-0">به زودی بازی‌های بیشتری اضافه می‌شود؛ بعداً دوباره سر بزنید.</p>
        </div>
    @else
        <div class="card-glass table-wrapper mb-4">
            <div class="table-scroll">
                <table class="table table-dark align-middle mb-0" style="min-width: 950px;">
                    <thead>
                        <tr>
                            <th>کاور</th>
                            <th>نام بازی</th>
                            <th>ژانر</th>
                            <th>نوع</th>
                            <th class="text-center">سطح</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($games as $game)
                            @php
                                $typeInfo = $typeMap[$game->type] ?? ['label' => 'نامشخص', 'class' => 'badge-type-default'];
                            @endphp
                            <tr>
                                <td>
                                    <img src="{{ $game->cover_url }}" alt="{{ $game->name }}" class="cover-img">
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $game->name }}</div>
                                    <small class="text-secondary">وضعیت: {{ $game->status === 'active' ? 'فعال' : 'غیرفعال' }}</small>
                                </td>
                                <td>{{ $game->genre ?? '—' }}</td>
                                <td>
                                    <span class="badge-soft {{ $typeInfo['class'] }}">{{ $typeInfo['label'] }}</span>
                                </td>
                                <td class="text-center">{{ $levelLabel($game->level) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mobile-cards">
            @foreach($games as $game)
                @php
                    $typeInfo = $typeMap[$game->type] ?? ['label' => 'نامشخص', 'class' => 'badge-type-default'];
                @endphp
                <div class="game-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ $game->cover_url }}" alt="{{ $game->name }}" class="cover-img">
                        <div>
                            <div class="fw-semibold">{{ $game->name }}</div>
                            <small class="text-secondary">ژانر: {{ $game->genre ?? '—' }}</small>
                        </div>
                    </div>
                    <div class="card-row">
                        <span>نوع</span>
                        <span class="badge-soft {{ $typeInfo['class'] }}">{{ $typeInfo['label'] }}</span>
                    </div>
                    <div class="card-row">
                        <span>سطح</span>
                        <span>{{ $levelLabel($game->level) }}</span>
                    </div>
                    <div class="card-row">
                        <span>وضعیت</span>
                        <span>{{ $game->status === 'active' ? 'فعال' : 'غیرفعال' }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        @php
            $paginator = $games->onEachSide(1);
            $window = \Illuminate\Pagination\UrlWindow::make($paginator);
            $elements = array_filter([
                $window['first'],
                is_array($window['slider']) ? '...' : null,
                $window['slider'],
                is_array($window['last']) ? '...' : null,
                $window['last'],
            ]);
        @endphp
        @if ($paginator->hasPages())
            <nav class="pagination-glass d-flex justify-content-center mt-3" aria-label="صفحه‌بندی بازی‌ها">
                <ul class="pagination justify-content-center gap-2 mb-0 flex-wrap">
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">
                                <i class="bi bi-chevron-right"></i>
                                قبلی
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                                <i class="bi bi-chevron-right"></i>
                                قبلی
                            </a>
                        </li>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                                بعدی
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">
                                بعدی
                                <i class="bi bi-chevron-left"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </nav>
        @endif
    @endif
@endsection
