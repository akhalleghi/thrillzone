@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid py-3">
        <div class="card-glass mb-3 d-flex justify-content-between align-items-center">
            <h5 class="section-title m-0">لیست کاربران</h5>
        </div>

        <div class="card-glass table-responsive">
            <table class="table table-dark align-middle mb-0">
                <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>نام کاربر</th>
                    <th>شماره تماس</th>
                    <th>تاریخ ثبت‌نام</th>
                    <th>پلن فعال</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>{{ $user->name ?? '—' }}</td>
                        <td>{{ $user->phone ?? '—' }}</td>
                        <td>
                            @if($user->created_at)
                                {{ \Morilog\Jalali\Jalalian::forge($user->created_at)->format('Y/m/d') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-muted">—</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">هیچ کاربری ثبت نشده است</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
