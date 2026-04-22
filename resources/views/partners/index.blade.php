@extends('layouts.app')

@section('title', 'المسوقين و الأطراف')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h1 class="h3 mb-0 d-flex align-items-center">
            <i class="bi bi-people text-primary me-2"></i>
            إدارة المسوقين و الأطراف
            <span class="badge bg-secondary ms-2">{{ $partners->total() ?? 0 }}</span>
        </h1>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('partners.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> إضافة إسم جديد
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($partners->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">#</th>
                        <th> الاسم </th>
                        <th style="width: 150px;">عدد العقارات</th>
                        <th style="width: 120px;">تاريخ الإنشاء</th>
                        <th style="width: 120px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($partners as $partner)
                    <tr>
                        <td><small class="text-muted">{{ $partner->id }}</small></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <strong>{{ $partner->name }}</strong>
                            </div>
                        </td>
                        <td class="align-middle d-flex align-items-center">
                            @if($partner->properties_count > 0)
                                <a href="{{ route('properties.index') }}?partner_filter={{ $partner->id }}" 
                                   class="badge bg-info text-decoration-none w-100 fs-6"
                                   title="انقر لعرض عقارات {{ $partner->name }}">
                                    {{ number_format($partner->properties_count) }} عقار
                                </a>
                            @else
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-dash-circle me-1"></i>
                                    0 عقار
                                </span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $partner->created_at->format('Y-m-d') }}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('partners.edit', $partner) }}" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="تعديل {{ $partner->name }}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($partner->properties_count == 0)
                                <form method="POST" action="{{ route('partners.destroy', $partner) }}" class="d-inline" 
                                      onsubmit="return confirm('هل أنت متأكد من حذف الطرف: {{ $partner->name }}؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف {{ $partner->name }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @else
                                <button type="button" class="btn btn-sm btn-outline-secondary" 
                                        title="لا يمكن حذف هذا الطرف لوجود عقارات مرتبطة به" disabled>
                                    <i class="bi bi-lock"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($partners->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="pagination-info">
                <i class="bi bi-info-circle me-1"></i>
                عرض {{ $partners->firstItem() ?? 0 }} - {{ $partners->lastItem() ?? 0 }} 
                من أصل {{ number_format($partners->total()) }} طرف
            </div>
            
            <nav aria-label="تنقل بين الصفحات">
                <ul class="pagination pagination-sm mb-0">
                    {{-- Previous Page Link --}}
                    @if ($partners->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">السابق</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $partners->previousPageUrl() }}" rel="prev">السابق</a>
                        </li>
                    @endif
                    
                    {{-- Page Numbers --}}
                    @php
                        $start = max(1, $partners->currentPage() - 2);
                        $end = min($partners->lastPage(), $partners->currentPage() + 2);
                    @endphp
                    
                    {{-- First page --}}
                    @if($start > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $partners->url(1) }}">1</a>
                        </li>
                        @if($start > 2)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                    @endif
                    
                    {{-- Page numbers --}}
                    @for($page = $start; $page <= $end; $page++)
                        @if ($page == $partners->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $partners->url($page) }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endfor
                    
                    {{-- Last page --}}
                    @if($end < $partners->lastPage())
                        @if($end < $partners->lastPage() - 1)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ $partners->url($partners->lastPage()) }}">{{ $partners->lastPage() }}</a>
                        </li>
                    @endif
                    
                    {{-- Next Page Link --}}
                    @if ($partners->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $partners->nextPageUrl() }}" rel="next">التالي</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">التالي</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
        @endif
        @else
        <div class="text-center py-5">
            <i class="bi bi-people display-1 text-muted"></i>
            <h4 class="text-muted mt-3">لا توجد أطراف</h4>
            <p class="text-muted">لم يتم إضافة أي طرف بعد</p>
            <a href="{{ route('partners.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> إضافة طرف جديد
            </a>
        </div>
        @endif
    </div>
</div>
@endsection