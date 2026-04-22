@extends('layouts.app')

@section('title', 'تفاصيل المسوق - السهل للعقارات')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient bg-primary text-white py-3">
                    <h4 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        تفاصيل المسوق
                    </h4>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group mb-4">
                                <label class="text-muted small">الاسم الكامل</label>
                                <h5 class="fw-bold text-dark">{{ $rentPartner->name }}</h5>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-group mb-4">
                                <label class="text-muted small">الحالة</label>
                                <div>
                                    @if($rentPartner->is_active)
                                        <span class="badge bg-success fs-6 px-3 py-2">
                                            <i class="bi bi-check-circle me-1"></i>
                                            فعال
                                        </span>
                                    @else
                                        <span class="badge bg-danger fs-6 px-3 py-2">
                                            <i class="bi bi-x-circle me-1"></i>
                                            غير فعال
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group mb-4">
                                <label class="text-muted small">رقم الهاتف</label>
                                <p class="fw-semibold text-dark">
                                    @if($rentPartner->phone)
                                        <i class="bi bi-telephone-fill text-success me-2"></i>
                                        <a href="tel:{{ $rentPartner->phone }}" class="text-decoration-none">
                                            {{ $rentPartner->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-group mb-4">
                                <label class="text-muted small">البريد الإلكتروني</label>
                                <p class="fw-semibold text-dark">
                                    @if($rentPartner->email)
                                        <i class="bi bi-envelope-fill text-primary me-2"></i>
                                        <a href="mailto:{{ $rentPartner->email }}" class="text-decoration-none">
                                            {{ $rentPartner->email }}
                                        </a>
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group mb-4">
                                <label class="text-muted small">نسبة العمولة</label>
                                <p class="fw-bold text-success fs-5">
                                    <i class="bi bi-percent me-1"></i>
                                    {{ $rentPartner->commission_rate }}%
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-group mb-4">
                                <label class="text-muted small">عدد العقارات المُعينة</label>
                                <p class="fw-bold text-info fs-5">
                                    <i class="bi bi-building me-1"></i>
                                    {{ $rentPartner->rentProperties->count() }} عقار
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    @if($rentPartner->notes)
                    <div class="info-group mb-4">
                        <label class="text-muted small">الملاحظات</label>
                        <div class="card bg-light border-0">
                            <div class="card-body py-2">
                                <p class="text-dark mb-0">{{ $rentPartner->notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group">
                                <label class="text-muted small">تاريخ الإضافة</label>
                                <p class="fw-semibold text-dark">
                                    <i class="bi bi-calendar-plus me-2"></i>
                                    {{ $rentPartner->created_at->format('d/m/Y - h:i A') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            @if($rentPartner->updated_at != $rentPartner->created_at)
                            <div class="info-group">
                                <label class="text-muted small">آخر تحديث</label>
                                <p class="fw-semibold text-dark">
                                    <i class="bi bi-arrow-clockwise me-2"></i>
                                    {{ $rentPartner->updated_at->format('d/m/Y - h:i A') }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- العقارات المُعينة -->
            @if($rentPartner->rentProperties->count() > 0)
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-gradient bg-info text-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-building me-2"></i>
                        العقارات المُعينة ({{ $rentPartner->rentProperties->count() }})
                    </h5>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>رقم العقار</th>
                                    <th>نوع العقار</th>
                                    <th>السعر</th>
                                    <th>المنطقة</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rentPartner->rentProperties as $property)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $property->property_number }}</strong>
                                    </td>
                                    <td>{{ $property->propertyType->name ?? 'غير محدد' }}</td>
                                    <td>
                                        <span class="fw-bold text-success">
                                            {{ number_format($property->price) }} درهم
                                        </span>
                                    </td>
                                    <td>{{ $property->area }}</td>
                                    <td>
                                        @if($property->status == 'available')
                                            <span class="badge bg-success">متاح</span>
                                        @elseif($property->status == 'rented')
                                            <span class="badge bg-warning">مؤجر</span>
                                        @else
                                            <span class="badge bg-secondary">غير متاح</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('rent-properties.show', $property) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- الشريط الجانبي -->
        <div class="col-lg-4">
            <!-- معلومات سريعة -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-gradient bg-secondary text-white py-3">
                    <h6 class="mb-0 fw-bold text-center">
                        <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                        إحصائيات المسوق
                    </h6>
                </div>
                <div class="card-body py-3">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h3 class="text-info mb-1">{{ $rentPartner->rentProperties->count() }}</h3>
                                <small class="text-muted">إجمالي العقارات</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h3 class="text-success mb-1">{{ $rentPartner->rentProperties->where('status', 'rented')->count() }}</h3>
                            <small class="text-muted">عقارات مؤجرة</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- الإجراءات -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient bg-dark text-white py-3">
                    <h6 class="mb-0 fw-bold text-center">
                        <i class="bi bi-gear-fill me-2 fs-5"></i>
                        الإجراءات المتاحة
                    </h6>
                </div>
                <div class="card-body py-3">
                    <div class="d-grid gap-3">
                        @auth
                        <a href="{{ route('rent-partners.edit', $rentPartner) }}" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center py-2 rounded-pill">
                            <i class="bi bi-pencil-square me-2"></i> 
                            تعديل المسوق
                        </a>
                        @endauth
                        
                        <a href="{{ route('rent-partners.index') }}" class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center py-2 rounded-pill">
                            <i class="bi bi-people me-2"></i> 
                            العودة لقائمة المسوقين
                        </a>
                        
                        @auth
                        <div class="border-top pt-3 mt-2">
                            <form method="POST" action="{{ route('rent-partners.destroy', $rentPartner) }}" 
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا المسوق؟ سيتم إلغاء تعيين جميع العقارات المرتبطة به.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100 d-flex align-items-center justify-content-center py-2 rounded-pill">
                                    <i class="bi bi-trash3-fill me-2"></i> 
                                    حذف المسوق
                                </button>
                            </form>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.info-group p, .info-group h5 {
    margin-bottom: 0;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection