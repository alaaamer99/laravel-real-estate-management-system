@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- العنوان الرئيسي -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">لوحة التحكم</h1>
                <div class="text-muted">
                    <i class="bi bi-calendar3"></i>
                    {{ now()->format('Y/m/d') }}
                </div>
            </div>
        </div>
    </div>

    <!-- بطاقات الإحصائيات -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <h4 class="text-primary fw-bold mb-3">
                <i class="bi bi-house-heart me-2"></i>
                إحصائيات المبيعات
            </h4>
        </div>
        <!-- إجمالي العقارات -->
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card total">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h6 opacity-75">إجمالي العقارات</div>
                            <div class="display-6 fw-bold">{{ $totalProperties }}</div>
                        </div>
                        <i class="bi bi-building-fill dashboard-icon"></i>
                    </div>
                </div>
                <div class="card-footer bg-primary border-0 text-end">
                    <a href="{{ route('properties.index') }}" class="text-white text-decoration-none small">
                        عرض التفاصيل <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- العقارات المتوفرة -->
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card available">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h6 opacity-75">العقارات المتوفرة</div>
                            <div class="display-6 fw-bold">{{ $availableProperties }}</div>
                        </div>
                        <i class="bi bi-check-circle dashboard-icon"></i>
                    </div>
                </div>
                <div class="card-footer bg-success border-0 text-end">
                    <small>{{ number_format(($availableProperties / max($totalProperties, 1)) * 100, 1) }}% من إجمالي العقارات</small>
                </div>
            </div>
        </div>
        <!-- أنواع العقارات -->
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card types">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h6 opacity-75">أنواع العقارات</div>
                            <div class="display-6 fw-bold">{{ $propertyTypes }}</div>
                        </div>
                        <i class="bi bi-tags dashboard-icon"></i>
                    </div>
                </div>
                <div class="card-footer bg-info border-0 text-end">
                    <a href="{{ route('property-types.index') }}" class="text-white text-decoration-none small">
                        إدارة الأنواع <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- المسوقين -->
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card partners shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h6 opacity-75">المسوقين</div>
                            <div class="display-6 fw-bold">{{ $partners }}</div>
                        </div>
                        <i class="bi bi-people dashboard-icon"></i>
                    </div>
                </div>
                <div class="card-footer bg-warning border-0 text-end">
                    <a href="{{ route('partners.index') }}" class="text-white text-decoration-none small">
                        إدارة المسوقين <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- إحصائيات العقارات المؤجرة -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="text-primary fw-bold mb-3">
                <i class="bi bi-house-heart me-2"></i>
                إحصائيات الإيجارات
            </h4>
        </div>
    </div>
    
    <div class="row g-4 mb-4">
        <!-- إجمالي العقارات المؤجرة -->
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card rental-total border-0 shadow">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h6 opacity-75 text-white">إجمالي عقارات الإيجار</div>
                            <div class="display-6 fw-bold text-white">{{ $totalRentProperties }}</div>
                        </div>
                        <i class="bi bi-building-fill-check text-white opacity-75" style="font-size: 3rem;"></i>
                    </div>
                </div>
                <div class="card-footer bg-gradient bg-purple border-0 text-end">
                    <a href="{{ route('rent-properties.index') }}" class="text-white text-decoration-none small">
                        عرض التفاصيل <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- العقارات المتاحة للإيجار -->
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card rental-available border-0 shadow">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h6 opacity-75 text-white">متاح للإيجار</div>
                            <div class="display-6 fw-bold text-white">{{ $availableRentProperties }}</div>
                        </div>
                        <i class="bi bi-house-check text-white opacity-75" style="font-size: 3rem;"></i>
                    </div>
                </div>
                <div class="card-footer bg-gradient bg-teal border-0 text-end">
                    <small class="text-white">{{ $totalRentProperties > 0 ? number_format(($availableRentProperties / $totalRentProperties) * 100, 1) : 0 }}% من إجمالي العقارات</small>
                </div>
            </div>
        </div>
        
        <!-- العقارات المؤجرة -->
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card rental-rented border-0 shadow">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h6 opacity-75 text-white">عقارات مؤجرة</div>
                            <div class="display-6 fw-bold text-white">{{ $rentedProperties }}</div>
                        </div>
                        <i class="bi bi-house-heart text-white opacity-75" style="font-size: 3rem;"></i>
                    </div>
                </div>
                <div class="card-footer bg-gradient bg-orange border-0 text-end">
                    <small class="text-white">{{ $totalRentProperties > 0 ? number_format(($rentedProperties / $totalRentProperties) * 100, 1) : 0 }}% نسبة الإشغال</small>
                </div>
            </div>
        </div>
        
        <!-- مسوقي الإيجارات -->
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card rental-partners border-0 shadow">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="h6 opacity-75 text-white">مسوقي الإيجارات</div>
                            <div class="display-6 fw-bold text-white">{{ $rentPartners }}</div>
                        </div>
                        <i class="bi bi-person-badge text-white opacity-75" style="font-size: 3rem;"></i>
                    </div>
                </div>
                <div class="card-footer bg-gradient bg-indigo border-0 text-end">
                    <a href="{{ route('rent-partners.index') }}" class="text-white text-decoration-none small">
                        إدارة المسوقين <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- إحصائيات مالية للإيجارات -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card bg-gradient-primary text-white border-0 shadow">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">إجمالي قيمة الإيجارات</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($totalRentValue) }} درهم</h3>
                        </div>
                        <i class="bi bi-cash-stack" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-gradient-success text-white border-0 shadow">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">متوسط سعر الإيجار</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($avgRentPrice ?? 0) }} درهم</h3>
                        </div>
                        <i class="bi bi-graph-up" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-gradient-info text-white border-0 shadow">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">إجمالي المساحات</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($totalRentArea) }} م²</h3>
                        </div>
                        <i class="bi bi-rulers" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الروابط السريعة -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-lightning-charge"></i> الروابط السريعة</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('properties.create') }}" class="btn btn-outline-primary w-100 h-100 d-flex align-items-center justify-content-center flex-column py-3">
                                <i class="bi bi-plus-circle display-6 mb-2"></i>
                                <span>إضافة عقار</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('properties.index') }}" class="btn btn-outline-success w-100 h-100 d-flex align-items-center justify-content-center flex-column py-3">
                                <i class="bi bi-list-ul display-6 mb-2"></i>
                                <span>عرض العقارات</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('rent-properties.create') }}" class="btn btn-outline-purple w-100 h-100 d-flex align-items-center justify-content-center flex-column py-3">
                                <i class="bi bi-house-add display-6 mb-2"></i>
                                <span>إضافة إيجار</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('rent-properties.index') }}" class="btn btn-outline-teal w-100 h-100 d-flex align-items-center justify-content-center flex-column py-3">
                                <i class="bi bi-houses display-6 mb-2"></i>
                                <span>عرض الإيجارات</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('properties.index') }}?export=excel" class="btn btn-outline-info w-100 h-100 d-flex align-items-center justify-content-center flex-column py-3">
                                <i class="bi bi-file-earmark-excel display-6 mb-2"></i>
                                <span>تصدير Excel</span>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-warning w-100 h-100 d-flex align-items-center justify-content-center flex-column py-3">
                                <i class="bi bi-person-gear display-6 mb-2"></i>
                                <span>إدارة المستخدمين</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- آخر العقارات المؤجرة المضافة -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-gradient bg-purple text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-house-heart"></i> آخر العقارات المؤجرة المضافة</h5>
                    <a href="{{ route('rent-properties.index') }}" class="btn btn-sm btn-outline-light">عرض الكل</a>
                </div>
                <div class="card-body">
                    @if($recentRentProperties->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم العقار</th>
                                        <th>النوع</th>
                                        <th>المنطقة</th>
                                        <th>السعر</th>
                                        <th>المسوق</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الإضافة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentRentProperties as $property)
                                    <tr>
                                        <td>
                                            <a href="{{ route('rent-properties.show', $property) }}" class="text-decoration-none fw-bold text-primary">
                                                {{ $property->property_number }}
                                            </a>
                                        </td>
                                        <td>{{ $property->propertyType->name ?? 'غير محدد' }}</td>
                                        <td>{{ $property->area }}</td>
                                        <td>
                                            <span class="fw-bold text-success">{{ number_format($property->price) }} درهم</span>
                                        </td>
                                        <td>
                                            @if($property->rentPartner)
                                                <span class="badge bg-info">{{ $property->rentPartner->name }}</span>
                                            @else
                                                <span class="text-muted">غير مُعين</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($property->status == 'available')
                                                <span class="badge bg-success">متاح</span>
                                            @elseif($property->status == 'rented')
                                                <span class="badge bg-warning text-dark">مؤجر</span>
                                            @else
                                                <span class="badge bg-secondary">غير متاح</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $property->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-house-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">لا توجد عقارات مؤجرة بعد</p>
                            <a href="{{ route('rent-properties.create') }}" class="btn btn-purple">إضافة أول عقار للإيجار</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- العقارات الحديثة والإحصائيات -->
    <div class="row">
        <!-- آخر العقارات المضافة -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> آخر العقارات المضافة</h5>
                    <a href="{{ route('properties.index') }}" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                </div>
                <div class="card-body">
                    @if($recentProperties->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم المرجع</th>
                                        <th>النوع</th>
                                        <th>السعر</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الإضافة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProperties as $property)
                                    <tr>
                                        <td><strong>{{ $property->reference_number }}</strong></td>
                                        <td>{{ $property->propertyType->name }}</td>
                                        <td>{{ number_format($property->price, 0) }} درهم</td>
                                        <td>
                                            @if($property->status === 'متوفر')
                                                <span class="badge bg-success">{{ $property->status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $property->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $property->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('properties.show', $property) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <p class="text-muted mt-2">لا توجد عقارات حتى الآن</p>
                            <a href="{{ route('properties.create') }}" class="btn btn-primary">إضافة أول عقار</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- إحصائيات سريعة -->
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pie-chart"></i> إحصائيات سريعة</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <div class="h4 text-primary mb-1">{{ $totalValue ? number_format($totalValue / 1000000, 1) : 0 }}م</div>
                                <small class="text-muted">إجمالي القيمة (مليون درهم)</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="h4 text-success mb-1">{{ $avgPrice ? number_format($avgPrice / 1000, 0) : 0 }}ألف</div>
                            <small class="text-muted">متوسط السعر (ألف درهم)</small>
                        </div>
                        <div class="col-6">
                            <div class="border-end">
                                <div class="h4 text-info mb-1">{{ number_format($totalArea / 1000, 1) }}ألف</div>
                                <small class="text-muted">إجمالي المساحة (ألف قدم)</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="h4 text-warning mb-1">{{ $usersCount }}</div>
                            <small class="text-muted">عدد المستخدمين</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- أكثر أنواع العقارات -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-graph-up"></i> أكثر الأنواع</h5>
                </div>
                <div class="card-body">
                    @if($topPropertyTypes->count() > 0)
                        @foreach($topPropertyTypes as $type)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>{{ $type->name }}</span>
                            <div>
                                <span class="badge bg-primary">{{ $type->properties_count }}</span>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr class="my-2">
                        @endif
                        @endforeach
                    @else
                        <p class="text-muted text-center">لا توجد بيانات</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* بطاقات الإحصائيات المؤجرة */
.dashboard-card.rental-total {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.dashboard-card.rental-available {
    background: linear-gradient(135deg, #20bf6b 0%, #26d0ce 100%);
}

.dashboard-card.rental-rented {
    background: linear-gradient(135deg, #f39c12 0%, #f1c40f 100%);
}

.dashboard-card.rental-partners {
    background: linear-gradient(135deg, #8e44ad 0%, #3742fa 100%);
}

/* الألوان المضافة */
.bg-purple {
    background-color: #8e44ad !important;
}

.bg-gradient.bg-purple {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.bg-teal {
    background-color: #26d0ce !important;
}

.bg-gradient.bg-teal {
    background: linear-gradient(135deg, #20bf6b 0%, #26d0ce 100%) !important;
}

.bg-orange {
    background-color: #f39c12 !important;
}

.bg-gradient.bg-orange {
    background: linear-gradient(135deg, #f39c12 0%, #f1c40f 100%) !important;
}

.bg-indigo {
    background-color: #3742fa !important;
}

.bg-gradient.bg-indigo {
    background: linear-gradient(135deg, #8e44ad 0%, #3742fa 100%) !important;
}

/* أزرار الروابط السريعة */
.btn-outline-purple {
    color: #8e44ad;
    border-color: #8e44ad;
}

.btn-outline-purple:hover {
    background-color: #8e44ad;
    border-color: #8e44ad;
    color: #fff;
}

.btn-outline-teal {
    color: #26d0ce;
    border-color: #26d0ce;
}

.btn-outline-teal:hover {
    background-color: #26d0ce;
    border-color: #26d0ce;
    color: #fff;
}

.btn-purple {
    background-color: #8e44ad;
    border-color: #8e44ad;
    color: #fff;
}

.btn-purple:hover {
    background-color: #7d3c98;
    border-color: #7d3c98;
    color: #fff;
}

/* تحسين الكروت */
.dashboard-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

/* تدرجات الخلفية */
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important;
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
}

/* تأثيرات إضافية */
.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15) !important;
}

.border-0 {
    border: 0 !important;
}
</style>
@endsection
