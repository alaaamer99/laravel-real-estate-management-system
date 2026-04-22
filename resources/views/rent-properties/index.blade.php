@extends('layouts.app')

@section('title', 'قائمة الإيجارات')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h1 class="h3 mb-0 d-flex align-items-center">
            <i class="bi bi-house-door text-primary me-2"></i>
            إدارة الإيجارات
            <span class="badge bg-secondary ms-2">{{ $rentProperties->total() ?? 0 }}</span>
        </h1>
    </div>
    <div class="col-md-6 text-end">
        @auth
        <a href="{{ route('rent-properties.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> إضافة عقار للإيجار
        </a>
        @endauth
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
                               placeholder="رقم العقار أو العنوان..." 
                               value="{{ request('search') }}"
                               title="البحث برقم العقار أو العنوان أو الوصف">
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
                    <i class="bi bi-people ms-1"></i>المسوق
                </label>
                <select name="partner_filter" class="form-select form-select-sm" onchange="filterProperties()">
                    <option value="">جميع المسوقين</option>
                    @foreach(\App\Models\RentPartner::orderBy('name')->get() as $partner)
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
                    <option value="available" {{ request('status_filter') == 'available' ? 'selected' : '' }}>متاح</option>
                    <option value="rented" {{ request('status_filter') == 'rented' ? 'selected' : '' }}>مؤجر</option>
                </select>
            </div>
            
            <div class="col-lg-2 col-md-4">
                <label class="form-label text-muted small mb-1">
                    <i class="bi bi-sort-down ms-1"></i>الترتيب
                </label>
                <select name="sort_by" class="form-select form-select-sm" onchange="filterProperties()">
                    <option value="newest" {{ request('sort_by', 'newest') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                    <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>الأقدم</option>
                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>السعر من الأقل</option>
                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>السعر من الأعلى</option>
                    <option value="area_desc" {{ request('sort_by') == 'area_desc' ? 'selected' : '' }}>المساحة من الأعلى</option>
                    <option value="area_asc" {{ request('sort_by') == 'area_asc' ? 'selected' : '' }}>المساحة من الأقل</option>
                </select>
            </div>
            
            <div class="col-lg-1 col-md-4">
                <label class="form-label text-muted small mb-1 opacity-0">إجراءات</label>
                <a href="{{ route('rent-properties.index') }}" class="btn btn-outline-secondary btn-sm w-100 d-block">
                    <i class="bi bi-arrow-clockwise"></i> إعادة
                </a>
            </div>
            
            <div class="col-lg-1 col-md-12">
                <label class="form-label text-muted small mb-1 opacity-0">تصدير</label>
                <a href="{{ route('reports.export.rentals') }}" class="btn btn-success btn-sm w-100 d-block">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
            </div>
        </div>

        @if($rentProperties->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr style="font-size: 0.85rem;">
                        <th style="width: 50px;">#</th>
                        <th style="width: 120px;">رقم العقار</th>
                        <th style="width: 90px;">التاريخ</th>
                        <th style="width: 100px;">نوع العقار</th>
                        <th style="width: 150px;">العنوان</th>
                        <th style="width: 80px;">الغرف</th>
                        <th style="width: 100px;">المسوق</th>
                        <th style="width: 80px;">المساحة</th>
                        <th style="width: 100px;">نوع الإيجار</th>
                        <th style="width: 100px;">السعر</th>
                        <th style="width: 80px;">الحالة</th>
                        <th style="width: 120px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.8rem;">
                    @foreach($rentProperties as $property)
                    <tr>
                        <td><small class="text-muted">{{ $property->id }}</small></td>
                        <td>
                            <strong class="text-primary">{{ $property->property_number }}</strong>
                        </td>
                        <td><small>{{ $property->date->format('Y-m-d') }}</small></td>
                        <td><span class="badge bg-secondary">{{ $property->propertyType->name }}</span></td>
                        <td class="text-truncate" style="max-width: 150px;" title="{{ $property->address }}">
                            <small>{{ $property->address }}</small>
                        </td>
                        <td>
                            <small>
                                <i class="fas fa-bed text-muted me-1"></i>{{ $property->rooms }}
                                <i class="fas fa-bath text-muted mx-1"></i>{{ $property->bathrooms }}
                            </small>
                        </td>
                        <td>
                            @if($property->rentPartner)
                                <small class="text-primary">{{ $property->rentPartner->name }}</small>
                            @else
                                <small class="text-muted">-</small>
                            @endif
                        </td>
                        <td><small>{{ number_format($property->area) }} م²</small></td>
                        <td><span class="badge bg-info">{{ $property->rental_type_text }}</span></td>
                        <td>
                            <strong class="text-success">{{ number_format($property->price) }}</strong>
                            <small class="text-muted d-block">درهم</small>
                        </td>
                        <td>
                            @if($property->status == 'available')
                                <span class="badge bg-success">{{ $property->status_text }}</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ $property->status_text }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('rent-properties.show', $property) }}" 
                                   class="btn btn-sm btn-outline-info" title="عرض التفاصيل">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @auth
                                <a href="{{ route('rent-properties.edit', $property) }}" 
                                   class="btn btn-sm btn-outline-warning" title="تعديل">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @can('property.delete')
                                <form action="{{ route('rent-properties.destroy', $property) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="حذف"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا العقار؟')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                 @endcan
                                @endauth
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <small class="text-muted">
                    عرض {{ $rentProperties->firstItem() }} إلى {{ $rentProperties->lastItem() }} 
                    من أصل {{ $rentProperties->total() }} نتيجة
                </small>
            </div>
            <div>
                {{ $rentProperties->appends(request()->query())->links() }}
            </div>
        </div>
        @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th>رقم العقار</th>
                                <th>التاريخ</th>
                                <th>نوع العقار</th>
                                <th>العنوان</th>
                                <th>الغرف</th>
                                <th>المساحة</th>
                                <th>نوع الإيجار</th>
                                <th>السعر</th>
                                <th>الحالة</th>
                                <th>المسوق</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentProperties as $property)
                            <tr>
                                <td>
                                    <span class="badge bg-primary">{{ $property->property_number }}</span>
                                </td>
                                <td>{{ $property->date->format('Y/m/d') }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $property->propertyType->name }}</span>
                                </td>
                                <td class="text-truncate" style="max-width: 200px;" title="{{ $property->address }}">
                                    {{ $property->address }}
                                </td>
                                <td>
                                    <i class="fas fa-bed text-muted me-1"></i>{{ $property->rooms }}
                                    <i class="fas fa-bath text-muted mx-1"></i>{{ $property->bathrooms }}
                                </td>
                                <td>{{ number_format($property->area) }} م²</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $property->rental_type_text }}</span>
                                </td>
                                <td>
                                    <strong class="text-success">{{ number_format($property->price) }}</strong>
                                    <small class="text-muted">درهم</small>
                                </td>
                                <td>
                                    @if($property->status == 'available')
                                        <span class="badge bg-success">{{ $property->status_text }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ $property->status_text }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($property->rentPartner)
                                        <span class="badge bg-dark">{{ $property->rentPartner->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('rent-properties.show', $property) }}" 
                                           class="btn btn-sm btn-outline-info" title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @auth
                                        <a href="{{ route('rent-properties.edit', $property) }}" 
                                           class="btn btn-sm btn-outline-primary" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('rent-properties.destroy', $property) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="حذف"
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا العقار؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="card-footer">
                    {{ $rentProperties->links() }}
                </div>
            <!-- حالة عدم وجود نتائج -->
        <div class="empty-state text-center py-5">
            <div class="empty-icon mb-3">
                <i class="bi bi-house-door" style="font-size: 4rem; color: #dee2e6;"></i>
            </div>
            <h5 class="text-muted mb-2">لا توجد عقارات للإيجار</h5>
            <p class="text-muted mb-3">
                @if(request()->hasAny(['search', 'type_filter', 'partner_filter', 'status_filter']))
                    لم يتم العثور على نتائج تطابق معايير البحث المحددة
                @else
                    ابدأ بإضافة أول عقار للإيجار في النظام
                @endif
            </p>
            
            <div class="d-flex justify-content-center gap-2">
                @if(request()->hasAny(['search', 'type_filter', 'partner_filter', 'status_filter']))
                    <a href="{{ route('rent-properties.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> إعادة تعيين الفلاتر
                    </a>
                @endif
                
                @auth
                <a href="{{ route('rent-properties.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> إضافة عقار للإيجار
                </a>
                @endauth
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function filterProperties() {
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = '{{ route("rent-properties.index") }}';
    
    // جمع جميع قيم الفلاتر
    const filters = ['type_filter', 'partner_filter', 'status_filter', 'sort_by'];
    const searchValue = document.querySelector('input[name="search"]').value;
    
    if (searchValue) {
        const searchInput = document.createElement('input');
        searchInput.type = 'hidden';
        searchInput.name = 'search';
        searchInput.value = searchValue;
        form.appendChild(searchInput);
    }
    
    filters.forEach(filterName => {
        const select = document.querySelector(`select[name="${filterName}"]`);
        if (select && select.value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = filterName;
            input.value = select.value;
            form.appendChild(input);
        }
    });
    
    document.body.appendChild(form);
    form.submit();
}

// إضافة event listeners
document.addEventListener('DOMContentLoaded', function() {
    // البحث عند الضغط على Enter
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('searchForm').submit();
            }
        });
    }
});
</script>
@endsection