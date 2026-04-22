@extends('layouts.app')

@section('title', 'قائمة العقارات')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h1 class="h3 mb-0 d-flex align-items-center">
            <i class="bi bi-building-fill text-primary me-2"></i>
            إدارة العقارات
            <span class="badge bg-secondary ms-2">{{ $properties->total() ?? 0 }}</span>
        </h1>
    </div>
    <div class="col-md-6 text-end">
        @can('property.create')
        <a href="{{ route('properties.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> إضافة عقار جديد
        </a>
        @endcan
    </div>
</div>

<div class="card">
    <div class="card-body">
        <!-- فلاتر البحث والترشيح -->
        <div class="row g-2 mb-3">
            <div class="col-lg-3 col-md-6">
                <label class="form-label text-muted small mb-1">
                    <i class="bi bi-search ms-1"></i>البحث
                </label>
                <form method="GET" id="searchForm">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" 
                               placeholder="رقم المرجع (مطابق) أو العنوان/الوصف..." 
                               value="{{ request('search') }}"
                               title="البحث برقم المرجع سيعطي نتائج مطابقة، والبحث بالعنوان أو الوصف سيعطي نتائج جزئية">
                        <button type="submit" class="btn btn-outline-primary" title="بحث">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <label class="form-label text-muted small mb-1">
                    <i class="bi bi-tags ms-1"></i>نوع العقار
                </label>
                <select name="type_filter" class="form-select form-select-sm" onchange="filterProperties()">
                    <option value="">جميع الأنواع</option>
                    @foreach(\App\Models\PropertyType::all() as $type)
                    <option value="{{ $type->id }}" {{ request('type_filter') == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-lg-2 col-md-4">
                <label class="form-label text-muted small mb-1">
                    <i class="bi bi-people ms-1"></i>الطرف
                </label>
                <select name="partner_filter" class="form-select form-select-sm" onchange="filterProperties()">
                    <option value="">جميع المسوقين</option>
                    @foreach(\App\Models\Partner::orderBy('name')->get() as $partner)
                    <option value="{{ $partner->id }}" {{ request('partner_filter') == $partner->id ? 'selected' : '' }}>
                        {{ $partner->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-lg-1 col-md-4">
                <label class="form-label text-muted small mb-1">
                    <i class="bi bi-check-circle ms-1"></i>الحالة
                </label>
                <select name="status_filter" class="form-select form-select-sm" onchange="filterProperties()">
                    <option value="">الكل</option>
                    <option value="متوفر" {{ request('status_filter') == 'متوفر' ? 'selected' : '' }}>متوفر</option>
                    <option value="غير_متوفر" {{ request('status_filter') == 'غير_متوفر' ? 'selected' : '' }}>غير متوفر</option>
                </select>
            </div>
            
            <div class="col-lg-2 col-md-4">
                <label class="form-label text-muted small mb-1">
                    <i class="bi bi-sort-down ms-1"></i>الترتيب
                </label>
                <select name="sort_by" class="form-select form-select-sm" onchange="filterProperties()">
                    <option value="reference_newest" {{ request('sort_by', 'reference_newest') == 'reference_newest' ? 'selected' : '' }}>الأحدث حسب المرجع</option>
                    <option value="reference_oldest" {{ request('sort_by') == 'reference_oldest' ? 'selected' : '' }}>الأقدم حسب المرجع</option>
                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>السعر من الأقل</option>
                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>السعر من الأعلى</option>
                    <option value="area_desc" {{ request('sort_by') == 'area_desc' ? 'selected' : '' }}>المساحة من الأعلى</option>
                    <option value="area_asc" {{ request('sort_by') == 'area_asc' ? 'selected' : '' }}>المساحة من الأقل</option>
                </select>
            </div>
            
            <div class="col-lg-1 col-md-4">
                <label class="form-label text-muted small mb-1 opacity-0">إجراءات</label>
                <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary btn-sm w-100 d-block">
                    <i class="bi bi-arrow-clockwise"></i> إعادة
                </a>
            </div>
            
            <div class="col-lg-1 col-md-12">
                <label class="form-label text-muted small mb-1 opacity-0">تصدير</label>
                <a href="{{ route('properties.index') }}?export=excel{{ request()->getQueryString() ? '&'.request()->getQueryString() : '' }}" class="btn btn-success btn-sm w-100 d-block">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
            </div>
        </div>

        @if($properties->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr style="font-size: 0.85rem;">
                        <th style="width: 50px;">#</th>
                        <th style="width: 120px;">رقم المرجع</th>
                        <th style="width: 90px;">التاريخ</th>
                        <th style="width: 100px;">نوع العقار</th>
                        <th style="width: 150px;">العنوان</th>
                        <th style="width: 120px;">مختصر الوصف</th>
                        <th style="width: 100px;">المسوقين</th>
                        <th style="width: 80px;">المساحة</th>
                        <th style="width: 100px;">السعر</th>
                        <th style="width: 80px;">الحالة</th>
                        <th style="width: 80px;"> بواسطة</th>
                        <th style="width: 120px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.8rem;">
                    @foreach($properties as $property)
                    <tr>
                        <td><small class="text-muted">{{ $property->id }}</small></td>
                        <td>
                            <div class="d-flex flex-column">
                                <strong class="text-primary">{{ $property->reference_number }}</strong>
                                @if($property->is_ad)
                                    <span class="badge bg-info badge-sm mt-1" style="font-size: 0.7rem;">إعلان</span>
                                  @else
                                    <span class="badge bg-danger badge-sm mt-1" style="font-size: 0.7rem;">بدون اعلان</span>  
                                @endif
                            </div>
                        </td>
                        <td><small>{{ $property->date->format('Y-m-d') }}</small></td>
                        <td><span class="badge bg-secondary">{{ $property->propertyType->name }}</span></td>
                        <td class="text-truncate" style="max-width: 150px;" title="{{ $property->address }}">
                            <small>{{ $property->address }}</small>
                        </td>
                        <td class="text-truncate" style="max-width: 120px;" title="{{ $property->description }}">
                            <small class="text-muted">{{ $property->description ? Str::limit($property->description, 40) : '-' }}</small>
                        </td>
                        <td>
                            @if($property->partners->count() > 0)
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($property->partners->take(2) as $partner)
                                        <span class="badge bg-primary" style="font-size: 0.7rem;">{{ $partner->name }}</span>
                                    @endforeach
                                    @if($property->partners->count() > 2)
                                        <span class="badge bg-light text-dark" style="font-size: 0.7rem;">+{{ $property->partners->count() - 2 }}</span>
                                    @endif
                                </div>
                            @else
                                <small class="text-muted">-</small>
                            @endif
                        </td>
                        <td><small>{{ number_format($property->area, 0) }} قدم</small></td>
                        <td>
                            <div class="d-flex flex-column">
                                <strong class="text-success">{{ number_format($property->price, 0) }}</strong>
                                <small class="text-muted">درهم</small>
                            </div>
                        </td>
                        <td>
                            @if($property->status === 'متوفر')
                                <span class="badge bg-success" style="font-size: 0.7rem;">{{ $property->status }}</span>
                            @elseif($property->status === 'غير متوفر')
                                <span class="badge bg-danger" style="font-size: 0.7rem;">{{ $property->status }}</span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $property->creator->name }}</small></td>
                        <td>
                            <div class="btn-group-vertical btn-group-sm" role="group">
                                <a href="{{ route('properties.show', $property) }}" class="btn btn-outline-primary btn-sm" title="عرض" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <div class="btn-group" role="group">
                                    @can('property.edit')
                                    <a href="{{ route('properties.edit', $property) }}" class="btn btn-outline-warning btn-sm" title="تعديل" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endcan
                                    @can('property.delete')
                                    <form method="POST" action="{{ route('properties.destroy', $property) }}" class="d-inline" 
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا العقار؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="حذف" style="font-size: 0.7rem; padding: 0.2rem 0.4rem;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($properties->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class=\"pagination-info\">
                <i class=\"bi bi-info-circle me-1\"></i>
                عرض {{ $properties->firstItem() ?? 0 }} - {{ $properties->lastItem() ?? 0 }} 
                من أصل {{ number_format($properties->total()) }} عقار
            </div>
            
            <nav aria-label="تنقل بين الصفحات">
                <ul class="pagination pagination-sm mb-0">
                    {{-- Previous Page Link --}}
                    @if ($properties->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">السابق</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $properties->previousPageUrl() }}" rel="prev">السابق</a>
                        </li>
                    @endif
                    
                    {{-- Pagination Elements --}}
                    @foreach ($properties->getUrlRange(1, $properties->lastPage()) as $page => $url)
                        @if ($page == $properties->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                        
                        {{-- Show only 5 pages around current page --}}
                        @if($properties->lastPage() > 10)
                            @if($page == $properties->currentPage() + 2 && $properties->currentPage() < $properties->lastPage() - 3)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                                @php break; @endphp
                            @endif
                        @endif
                    @endforeach
                    
                    {{-- Show last page if there are many pages --}}
                    @if($properties->lastPage() > 10 && $properties->currentPage() < $properties->lastPage() - 3)
                        <li class="page-item">
                            <a class="page-link" href="{{ $properties->url($properties->lastPage()) }}">{{ $properties->lastPage() }}</a>
                        </li>
                    @endif
                    
                    {{-- Next Page Link --}}
                    @if ($properties->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $properties->nextPageUrl() }}" rel="next">التالي</a>
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
            <i class="bi bi-building display-1 text-muted"></i>
            <h4 class="text-muted mt-3">لا توجد عقارات</h4>
            <p class="text-muted">لم يتم إضافة أي عقار بعد</p>
            @can('property.create')
            <a href="{{ route('properties.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> إضافة أول عقار
            </a>
            @endcan
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function filterProperties() {
    const form = document.getElementById('searchForm');
    const typeFilter = document.querySelector('select[name="type_filter"]');
    const partnerFilter = document.querySelector('select[name="partner_filter"]');
    const statusFilter = document.querySelector('select[name="status_filter"]');
    const sortBy = document.querySelector('select[name="sort_by"]');
    const searchInput = document.querySelector('input[name="search"]');
    
    // إنشاء URLSearchParams من الفلاتر الحالية
    const params = new URLSearchParams();
    
    if (searchInput.value.trim()) {
        params.append('search', searchInput.value.trim());
    }
    if (typeFilter.value) {
        params.append('type_filter', typeFilter.value);
    }
    if (partnerFilter.value) {
        params.append('partner_filter', partnerFilter.value);
    }
    if (statusFilter.value) {
        params.append('status_filter', statusFilter.value);
    }
    if (sortBy.value) {
        params.append('sort_by', sortBy.value);
    }
    
    // توجيه للصفحة مع الفلاتر
    window.location.href = '{{ route("properties.index") }}' + (params.toString() ? '?' + params.toString() : '');
}

// إضافة مستمع للبحث السريع
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    let timeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            if (this.value.length >= 3 || this.value.length === 0) {
                filterProperties();
            }
        }, 500);
    });
    
    // تحسين مظهر الجدول للشاشات الصغيرة
    function adjustTableForMobile() {
        const table = document.querySelector('.table');
        const isMobile = window.innerWidth < 768;
        
        if (isMobile && table) {
            table.classList.add('table-responsive-stack');
        } else if (table) {
            table.classList.remove('table-responsive-stack');
        }
    }
    
    adjustTableForMobile();
    window.addEventListener('resize', adjustTableForMobile);
});

// إضافة tooltips للعناصر
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<style>
/* تحسينات إضافية للجدول */
.table-sm td, .table-sm th {
    padding: 0.4rem 0.3rem;
    vertical-align: middle;
}

.badge-sm {
    font-size: 0.65rem;
    padding: 0.2em 0.4em;
}

/* للشاشات الصغيرة - جعل الجدول قابل للتمرير الأفقي بشكل أفضل */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.75rem;
    }
    
    .table th, .table td {
        white-space: nowrap;
        min-width: 100px;
    }
    
    .btn-group-vertical .btn {
        font-size: 0.65rem;
        padding: 0.15rem 0.3rem;
    }
}

/* تحسين مظهر الفلاتر */
.form-select-sm, .form-control-sm {
    font-size: 0.8rem;
}

/* تحسين مظهر البحث */
.input-group-sm .btn {
    font-size: 0.8rem;
    padding: 0.375rem 0.5rem;
}

/* تحسين الألوان والتباعد */
.table-light th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    color: #495057;
}

.text-truncate {
    max-width: 1px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* تحسين مظهر الحالة */
.badge {
    font-weight: 500;
}

/* تحسين الأزرار */
.btn-group-vertical .btn:not(:last-child) {
    margin-bottom: 2px;
}

/* تحسين Pagination */
.pagination-sm .page-link {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
    margin: 0 2px;
    transition: all 0.2s ease;
}

.pagination-sm .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
    font-weight: 600;
}

.pagination-sm .page-link:hover {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #667eea;
}

.pagination-sm .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
}

/* تحسين عرض معلومات الصفحات */
.pagination-info {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

/* تحسين التباعد */
.pagination {
    --bs-pagination-border-radius: 0.5rem;
}
</style>
@endpush
@endsection