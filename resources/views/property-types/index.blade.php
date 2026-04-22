@extends('layouts.app')

@section('title', 'أنواع العقارات')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h1 class="h3 mb-0 d-flex align-items-center">
            <i class="bi bi-tags text-primary me-2"></i>
            إدارة أنواع العقارات
            <span class="badge bg-secondary ms-2">{{ $propertyTypes->total() ?? 0 }}</span>
        </h1>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('property-types.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> إضافة نوع جديد
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($propertyTypes->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">#</th>
                        <th>اسم النوع</th>
                        <th style="width: 150px;">عدد العقارات</th>
                        <th style="width: 120px;">تاريخ الإنشاء</th>
                        <th style="width: 120px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($propertyTypes as $type)
                    <tr>
                        <td><small class="text-muted">{{ $type->id }}</small></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <strong>{{ $type->name }}</strong>
                            </div>
                        </td>
                        <td>
                            @if($type->properties_count > 0)
                                <a href="{{ route('properties.index') }}?type_filter={{ $type->id }}" 
                                   class="badge bg-info text-decoration-none w-100 fs-6"
                                   title="انقر لعرض العقارات من هذا النوع">
                                    {{ number_format($type->properties_count) }} عقار
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
                                {{ $type->created_at->format('Y-m-d') }}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('property-types.edit', $type) }}" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="تعديل {{ $type->name }}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($type->properties_count == 0)
                                <form method="POST" action="{{ route('property-types.destroy', $type) }}" class="d-inline" 
                                      onsubmit="return confirm('هل أنت متأكد من حذف نوع العقار: {{ $type->name }}؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف {{ $type->name }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @else
                                <button type="button" class="btn btn-sm btn-outline-secondary" 
                                        title="لا يمكن حذف هذا النوع لوجود عقارات مرتبطة به" disabled>
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
        @if($propertyTypes->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="pagination-info">
                <i class="bi bi-info-circle me-1"></i>
                عرض {{ $propertyTypes->firstItem() ?? 0 }} - {{ $propertyTypes->lastItem() ?? 0 }} 
                من أصل {{ number_format($propertyTypes->total()) }} نوع
            </div>
            
            <nav aria-label="تنقل بين الصفحات">
                <ul class="pagination pagination-sm mb-0">
                    {{-- Previous Page Link --}}
                    @if ($propertyTypes->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">السابق</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $propertyTypes->previousPageUrl() }}" rel="prev">السابق</a>
                        </li>
                    @endif
                    
                    {{-- Page Numbers --}}
                    @php
                        $start = max(1, $propertyTypes->currentPage() - 2);
                        $end = min($propertyTypes->lastPage(), $propertyTypes->currentPage() + 2);
                    @endphp
                    
                    {{-- First page --}}
                    @if($start > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $propertyTypes->url(1) }}">1</a>
                        </li>
                        @if($start > 2)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                    @endif
                    
                    {{-- Page numbers --}}
                    @for($page = $start; $page <= $end; $page++)
                        @if ($page == $propertyTypes->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $propertyTypes->url($page) }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endfor
                    
                    {{-- Last page --}}
                    @if($end < $propertyTypes->lastPage())
                        @if($end < $propertyTypes->lastPage() - 1)
                            <li class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ $propertyTypes->url($propertyTypes->lastPage()) }}">{{ $propertyTypes->lastPage() }}</a>
                        </li>
                    @endif
                    
                    {{-- Next Page Link --}}
                    @if ($propertyTypes->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $propertyTypes->nextPageUrl() }}" rel="next">التالي</a>
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
            <i class="bi bi-tags display-1 text-muted"></i>
            <h4 class="text-muted mt-3">لا توجد أنواع عقارات</h4>
            <p class="text-muted">لم يتم إضافة أي نوع عقار بعد</p>
            <a href="{{ route('property-types.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> إضافة نوع جديد
            </a>
        </div>
        @endif
    </div>
</div>
@endsection