@extends('layouts.app')

@section('title', 'تفاصيل عقار الإيجار - ' . $rentProperty->property_number)

@section('content')
<!-- Print Header (Only visible when printing) -->
<div class="print-header d-none">
    <div class="company-header text-center mb-2">
        <div class="d-flex align-items-center justify-content-between">
            <img src="{{ asset('img/logo.png') }}" alt="شعار الشركة" class="company-logo">
            <div class="company-info text-center flex-grow-1 mx-3">
                <h2 class="company-name mb-1">شركة السهل للعقارات</h2>
                <p class="company-location mb-1">الامارات العربية المتحدة - الشارقة</p>
                <p class="company-phone mb-0" dir="ltr">+971508675333</p>
            </div>
            <img src="{{ asset('img/logo.png') }}" alt="شعار الشركة" class="company-logo">
        </div>
        <hr class="mt-2">
    </div>
</div>

<!-- Screen Header (Hidden when printing) -->
<div class="screen-header">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h4 mb-0 text-primary">تفاصيل عقار الإيجار: {{ $rentProperty->property_number }}</h1>
        <div class="d-flex gap-2">
            @auth
            <a href="{{ route('rent-properties.edit', $rentProperty) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> تعديل
            </a>
            @endauth
            <button class="btn btn-info btn-sm" onclick="window.print()">
                <i class="bi bi-printer"></i> طباعة
            </button>
            <a href="{{ route('rent-properties.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> العودة للقائمة
            </a>
        </div>
    </div>
</div>

<div class="container-fluid py-3">
    <div class="row g-3">
        <!-- معلومات العقار الأساسية -->
        <div class="col-lg-8">
            <!-- بطاقة المعلومات الأساسية -->
            <div class="card mb-2 shadow-sm">
                <div class="card-header bg-primary text-white py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">المعلومات الأساسية</h6>
                        <span class="badge {{ $rentProperty->status === 'available' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $rentProperty->status_text }}
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <!-- عرض الشاشة -->
                    <div class="row g-2 screen-only">
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block mb-1">رقم العقار</small>
                            <div class="fw-bold text-primary">{{ $rentProperty->property_number }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block mb-1">التاريخ</small>
                            <div class="small">{{ $rentProperty->date->format('Y-m-d') }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block mb-1">نوع العقار</small>
                            <div class="small fw-medium">{{ $rentProperty->propertyType->name }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block mb-1">نوع الإيجار</small>
                            <div class="small">{{ $rentProperty->rental_type_text }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block mb-1">عدد الغرف</small>
                            <div class="small">{{ $rentProperty->rooms }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block mb-1">عدد الحمامات</small>
                            <div class="small">{{ $rentProperty->bathrooms }}</div>
                        </div>
                        <div class="col-md-6 col-12">
                            <small class="text-muted d-block mb-1">العنوان</small>
                            <div class="small">{{ $rentProperty->address }}</div>
                        </div>
                    </div>
                    
                    <!-- عرض الطباعة -->
                    <div class="row g-2 print-only">
                        <!-- الصف الأول -->
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">رقم العقار</small>
                            <div class="fw-bold text-primary">{{ $rentProperty->property_number }}</div>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">التاريخ</small>
                            <div class="small">{{ $rentProperty->date->format('Y-m-d') }}</div>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">نوع العقار</small>
                            <div class="small fw-medium">{{ $rentProperty->propertyType->name }}</div>
                        </div>
                        <!-- الصف الثاني -->
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">نوع الإيجار</small>
                            <div class="small">{{ $rentProperty->rental_type_text }}</div>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">عدد الغرف</small>
                            <div class="small">{{ $rentProperty->rooms }}</div>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">عدد الحمامات</small>
                            <div class="small">{{ $rentProperty->bathrooms }}</div>
                        </div>
                        <!-- الصف الثالث -->
                        <div class="col-12">
                            <small class="text-muted d-block mb-1">العنوان</small>
                            <div class="small">{{ $rentProperty->address }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- بطاقة معلومات الإيجار -->
            <div class="card mb-2 shadow-sm">
                <div class="card-header bg-success text-white py-2">
                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-currency-dollar me-1"></i>
                        معلومات الإيجار
                    </h6>
                </div>
                <div class="card-body py-2">
                    <div class="row g-2">
                        <div class="col-4">
                            <small class="text-muted d-block mb-1">المساحة (م²)</small>
                            <div class="fw-bold text-primary">{{ number_format($rentProperty->area) }} م²</div>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block mb-1">السعر الإجمالي</small>
                            <div class="fw-bold text-success">{{ number_format($rentProperty->price) }} درهم</div>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block mb-1">السعر/م²</small>
                            <div class="fw-bold text-info">{{ number_format($rentProperty->price / $rentProperty->area, 2) }}</div>
                        </div>
                        @if($rentProperty->payment_installments > 1)
                        <div class="col-6">
                            <small class="text-muted d-block mb-1">عدد الدفعات</small>
                            <div class="fw-bold text-warning">{{ $rentProperty->payment_installments }}</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block mb-1">قيمة الدفعة</small>
                            <div class="fw-bold text-warning">{{ number_format($rentProperty->price / $rentProperty->payment_installments) }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- بطاقة الوصف -->
            @if($rentProperty->description)
            <div class="card mb-2 shadow-sm">
                <div class="card-header bg-info text-white py-1">
                    <h6 class="mb-0 fw-bold">وصف العقار</h6>
                </div>
                <div class="card-body py-2">
                    <p class="mb-0 small">{{ $rentProperty->description }}</p>
                </div>
            </div>
            @endif


        </div>

        <!-- الشريط الجانبي -->
        <div class="col-lg-4">
            <!-- معلومات المسوق -->
            @if($rentProperty->rentPartner)
            <div class="card mb-3 shadow-sm border-0 screen-only">
                <div class="card-header bg-gradient bg-primary text-white py-3">
                    <h6 class="mb-0 fw-bold text-center">
                        <i class="bi bi-person-badge-fill me-2 fs-5"></i>
                        المسوق المختص
                    </h6>
                </div>
                <div class="card-body py-3">
                    <div class="text-center">
                        <div class="mb-2">
                            <i class="bi bi-person-circle text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-2">{{ $rentProperty->rentPartner->name }}</h6>
                        @if($rentProperty->rentPartner->phone)
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="bi bi-telephone-fill text-success me-2"></i>
                                <span class="text-muted">{{ $rentProperty->rentPartner->phone }}</span>
                            </div>
                        @endif
                        @if($rentProperty->rentPartner->commission_rate > 0)
                            <div class="badge bg-info text-dark fs-6 px-3 py-2">
                                <i class="bi bi-percent me-1"></i>
                                نسبة العمولة: {{ $rentProperty->rentPartner->commission_rate }}%
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            
            <!-- معلومات إضافية -->
            <div class="card mb-3 shadow-sm border-0 screen-only">
                <div class="card-header bg-gradient bg-info text-white py-3">
                    <h6 class="mb-0 fw-bold text-center">
                        <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                        معلومات إضافية
                    </h6>
                </div>
                <div class="card-body py-3">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="bi bi-calendar-plus text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">تاريخ الإضافة</small>
                                <span class="fw-semibold">{{ $rentProperty->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        @if($rentProperty->updated_at != $rentProperty->created_at)
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="bi bi-arrow-clockwise text-warning"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">آخر تحديث</small>
                                <span class="fw-semibold">{{ $rentProperty->updated_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- الإجراءات -->
            <div class="card shadow-sm border-0 screen-only">
                <div class="card-header bg-gradient bg-dark text-white py-3">
                    <h6 class="mb-0 fw-bold text-center">
                        <i class="bi bi-gear-fill me-2 fs-5"></i>
                        الإجراءات المتاحة
                    </h6>
                </div>
                <div class="card-body py-3">
                    <div class="d-grid gap-3">
                        @auth
                        <a href="{{ route('rent-properties.edit', $rentProperty) }}" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center py-2 rounded-pill">
                            <i class="bi bi-pencil-square me-2"></i> 
                            تعديل العقار
                        </a>
                        @endauth
                        
                        <button class="btn btn-info btn-sm d-flex align-items-center justify-content-center py-2 rounded-pill" onclick="window.print()">
                            <i class="bi bi-printer-fill me-2"></i> 
                            طباعة التفاصيل
                        </button>
                        
                        <a href="{{ route('rent-properties.index') }}" class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center py-2 rounded-pill">
                            <i class="bi bi-house-door me-2"></i> 
                            العودة للقائمة
                        </a>
                        
                        @auth
                        <div class="border-top pt-3 mt-2">
                            <form method="POST" action="{{ route('rent-properties.destroy', $rentProperty) }}" 
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا العقار؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100 d-flex align-items-center justify-content-center py-2 rounded-pill">
                                    <i class="bi bi-trash3-fill me-2"></i> 
                                    حذف العقار
                                </button>
                            </form>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- معرض الصور -->
    @if($rentProperty->images && count($rentProperty->images) > 0)
    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">صور العقار ({{ count($rentProperty->images) }} من 6 صور)</h6>
                        <div class="d-flex gap-2 align-items-center">
                            <small class="text-light screen-only">انقر على الصورة للعرض الكامل</small>
                            @if(count($rentProperty->images) > 0)
                            <a href="{{ route('rent-property.images.download', $rentProperty) }}" class="btn btn-light btn-sm screen-only">
                                <i class="bi bi-download"></i> تحميل جميع الصور
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <!-- عرض الصور في الشاشة -->
                    <div class="row g-2 screen-only">
                        @foreach($rentProperty->images as $index => $image)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                            <div class="position-relative image-container" onclick="openImageModal({{ $index }})" style="cursor: pointer;">
                                <img src="{{ asset('storage/rent_properties/' . $rentProperty->property_number . '/' . $image) }}" 
                                     class="img-fluid rounded shadow-sm property-image" 
                                     alt="صورة {{ $index + 1 }}"
                                     style="height: 120px; width: 100%; object-fit: cover; transition: transform 0.2s;">
                                <div class="image-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
                                     style="background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.2s; border-radius: 0.375rem;">
                                    <i class="bi bi-zoom-in text-white fs-4"></i>
                                </div>
                                <span class="badge bg-dark position-absolute top-0 end-0 m-1">صورة {{ $index + 1 }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- عرض الصور في الطباعة -->
                    <div class="card-body py-2 print-only">
                        <div class="row g-1">
                            @foreach(array_slice($rentProperty->images ?? [], 0, 4) as $image)
                            <div class="col-3">
                                <img 
                                    src="{{ asset('storage/rent_properties/' . $rentProperty->property_number . '/' . $image) }}" 
                                    class="img-fluid rounded" 
                                    alt="صورة العقار"
                                    style="height: 80px; object-fit: cover; border: 1px solid #ddd;"
                                >
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



    <!-- Image Gallery Modal -->
    <div class="modal fade" id="imageGalleryModal" tabindex="-1" aria-labelledby="imageGalleryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageGalleryModalLabel">معرض صور العقار</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="position-relative">
                        <div class="text-center bg-dark" style="min-height: 500px; display: flex; align-items: center; justify-content: center;">
                            <img id="currentModalImage" src="" class="img-fluid" alt="صورة العقار" style="max-height: 70vh; max-width: 100%;">
                        </div>
                        
                        <!-- Navigation buttons -->
                        @if(count($rentProperty->images) > 1)
                        <button type="button" class="btn btn-light position-absolute top-50 start-0 translate-middle-y ms-3" 
                                onclick="previousImage()" id="prevImageBtn" style="z-index: 10;">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-light position-absolute top-50 end-0 translate-middle-y me-3" 
                                onclick="nextImage()" id="nextImageBtn" style="z-index: 10;">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        @endif
                        
                        <!-- Image counter -->
                        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-3">
                            <span class="badge bg-dark fs-6 px-3 py-2" id="imageCounter">
                                1 / {{ count($rentProperty->images) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Thumbnail strip -->
                    @if(count($rentProperty->images) > 1)
                    <div class="bg-light p-3">
                        <div class="d-flex gap-2 justify-content-center flex-wrap" id="thumbnailStrip">
                            @foreach($rentProperty->images as $index => $image)
                            <img src="{{ asset('storage/rent_properties/' . $rentProperty->property_number . '/' . $image) }}" 
                                 class="img-thumbnail thumbnail-image {{ $index === 0 ? 'active' : '' }}" 
                                 style="width: 80px; height: 60px; object-fit: cover; cursor: pointer;" 
                                 onclick="showImage({{ $index }})" 
                                 data-index="{{ $index }}">
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between w-100">
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary" onclick="downloadCurrentImage()">
                                <i class="bi bi-download"></i> تحميل الصورة
                            </button>
                            <a href="{{ route('rent-property.images.download', $rentProperty) }}" class="btn btn-primary">
                                <i class="bi bi-download"></i> تحميل جميع الصور
                            </a>
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="property-images-section mt-3 screen-only">
        <div class="card shadow-sm">
            <div class="card-header bg-light py-2">
                <h6 class="mb-0 text-muted">صور العقار</h6>
            </div>
            <div class="card-body text-center py-3">
                <i class="bi bi-image display-4 text-muted"></i>
                <h6 class="text-muted mt-2">لا توجد صور</h6>
                <p class="text-muted small">لم يتم رفع أي صور لهذا العقار</p>
            </div>
        </div>
    </div>
@endif

@push('styles')
<style>
/* Print Styles */
@media print {
    .print-only { display: block !important; }
    .screen-only, .screen-header { display: none !important; }
    
    .print-header { 
        display: block !important;
        margin-bottom: 10px;
    }
    
    body {
        font-size: 11px !important;
        line-height: 1.3 !important;
        margin: 0;
        padding: 10px;
    }
    
    .company-logo {
        width: 60px !important;
        height: 60px !important;
    }
    
    .company-name {
        font-size: 18px !important;
        font-weight: bold !important;
        margin-bottom: 5px !important;
    }
    
    .company-location, .company-phone {
        font-size: 12px !important;
        margin-bottom: 3px !important;
    }
    
    .card {
        border: 1px solid #ddd !important;
        margin-bottom: 10px !important;
        break-inside: avoid;
    }
    
    .card-header {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid #ddd !important;
        padding: 5px 10px !important;
        font-size: 12px !important;
        font-weight: bold !important;
    }
    
    .card-body {
        padding: 8px !important;
        font-size: 10px !important;
    }
    
    .property-details-container {
        width: 100% !important;
    }
    
    .row {
        margin: 0 !important;
    }
    
    .col-lg-8, .col-lg-4 {
        width: 100% !important;
        max-width: 100% !important;
        flex: none !important;
    }
    
    /* تحسين تخطيط الطباعة */
    .print-only .col-3 {
        width: 25% !important;
        float: right !important;
        padding: 2px 5px !important;
    }
    
    .print-only .col-12 {
        width: 100% !important;
        clear: both !important;
        padding: 2px 5px !important;
    }
    
    .print-image {
        width: 100% !important;
        height: 80px !important;
        object-fit: cover !important;
    }
    
    .fw-bold {
        font-weight: 700 !important;
    }
    
    small, .small {
        font-size: 12px !important;
        font-weight: bold !important;
        color: #000 !important;
    }
    
    .badge {
        font-size: 8px !important;
        padding: 2px 5px !important;
        font-weight: bold !important;
        color: #000 !important;
    }
    
    /* تحسين عرض النصوص في الطباعة */
    div, p, span, h1, h2, h3, h4, h5, h6 {
        color: #000 !important;
        font-weight: bold !important;
    }
    
    /* تحسين الوصف في الطباعة */
    .card-body p {
        font-size: 14px !important;
        line-height: 1.4 !important;
        text-align: justify !important;
        font-weight: bold !important;
        color: #000 !important;
    }
    
    .text-primary { color: #0d6efd !important; }
    .text-success { color: #198754 !important; }
    .text-info { color: #0dcaf0 !important; }
    .text-warning { color: #ffc107 !important; }
    
    /* إضافة فواصل بين الصفوف */
    .print-only .row > div {
        margin-bottom: 8px !important;
    }
    
    /* تأكيد عرض المعلومات في الطباعة */
    .print-only {
        display: block !important;
        visibility: visible !important;
    }
    
    /* تحسين المحاذاة في الطباعة */
    .print-only .small, .print-only small {
        font-size: 12px !important;
        margin-bottom: 2px !important;
        font-weight: bold !important;
        color: #000 !important;
    }
    
    /* تحسين النصوص العامة في الطباعة */
    .print-only * {
        color: #000 !important;
        font-weight: bold !important;
    }
    
    /* إخفاء شريط التنقل والهيدر الأساسي في الطباعة */
    .navbar, nav, .navigation {
        display: none !important;
    }
    
    /* إخفاء أي عناصر غير ضرورية في الطباعة */
    body > .container-fluid, body > .container {
        padding: 0 !important;
        margin: 0 !important;
    }
    
    /* تحسين عرض العناوين في الطباعة */
    .card-header h6 {
        font-size: 13px !important;
        font-weight: bold !important;
        color: #000 !important;
    }
    
    /* تحسين عرض القيم المهمة */
    .fw-bold.text-primary,
    .fw-bold.text-success,
    .fw-bold.text-info,
    .fw-bold.text-warning {
        font-size: 13px !important;
        font-weight: bold !important;
        color: #000 !important;
    }
}

/* Screen Styles */
@media screen {
    .print-only { display: none !important; }
    
    .property-image {
        height: 120px !important;
        width: 100% !important;
        object-fit: cover !important;
        cursor: pointer !important;
        transition: transform 0.2s ease;
    }
    
    .property-image:hover {
        transform: scale(1.05);
    }
    
    .image-container {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    
    .image-container:hover .image-overlay {
        opacity: 1;
    }
    
    .delete-image-btn {
        font-size: 10px !important;
        padding: 2px 4px !important;
        opacity: 0.8;
    }
    
    .delete-image-btn:hover {
        opacity: 1;
    }
    
    .company-header {
        display: none;
    }
    
    /* تحسين عرض الـ thumbnails */
    .thumbnail-nav {
        opacity: 0.7;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .thumbnail-nav:hover {
        opacity: 1;
        transform: scale(1.1);
    }
    
    .thumbnail-nav.active {
        opacity: 1;
        border-color: #0d6efd;
        transform: scale(1.1);
    }
}

.property-details-container .card {
    border-radius: 8px;
}

.property-details-container .card-header {
    border-radius: 8px 8px 0 0 !important;
}

.g-2 > * {
    padding: 0.25rem;
}

.g-3 > * {
    padding: 0.5rem;
}
</style>
@endpush

<script>
// Image Gallery Variables
let currentImageIndex = 0;
const images = [
    @if($rentProperty->images)
        @foreach($rentProperty->images as $index => $image)
            {
                src: "{{ asset('storage/rent_properties/' . $rentProperty->property_number . '/' . $image) }}",
                alt: "صورة {{ $index + 1 }}",
                name: "{{ $image }}"
            }{{ $loop->last ? '' : ',' }}
        @endforeach
    @endif
];

// Open Image Modal
function openImageModal(index) {
    currentImageIndex = index;
    showImage(index);
    const modal = new bootstrap.Modal(document.getElementById('imageGalleryModal'));
    modal.show();
}

// Show Image in Modal
function showImage(index) {
    if (images[index]) {
        currentImageIndex = index;
        document.getElementById('currentModalImage').src = images[index].src;
        document.getElementById('currentModalImage').alt = images[index].alt;
        document.getElementById('imageCounter').textContent = `${index + 1} / ${images.length}`;
        
        // Update thumbnail selection
        document.querySelectorAll('.thumbnail-image').forEach(thumb => {
            thumb.classList.remove('active');
        });
        const activeThumbnail = document.querySelector(`.thumbnail-image[data-index="${index}"]`);
        if (activeThumbnail) {
            activeThumbnail.classList.add('active');
        }
    }
}

// Navigate Images
function nextImage() {
    const nextIndex = (currentImageIndex + 1) % images.length;
    showImage(nextIndex);
}

function previousImage() {
    const prevIndex = currentImageIndex === 0 ? images.length - 1 : currentImageIndex - 1;
    showImage(prevIndex);
}

// Download Current Image
function downloadCurrentImage() {
    if (images[currentImageIndex]) {
        const link = document.createElement('a');
        link.href = "{{ route('rent-property.image.download', [$rentProperty, '__IMAGE__']) }}".replace('__IMAGE__', images[currentImageIndex].name);
        link.download = images[currentImageIndex].name;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Keyboard Navigation
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('imageGalleryModal');
    if (modal.classList.contains('show')) {
        if (e.key === 'ArrowRight') {
            nextImage();
            e.preventDefault();
        } else if (e.key === 'ArrowLeft') {
            previousImage();
            e.preventDefault();
        } else if (e.key === 'Escape') {
            bootstrap.Modal.getInstance(modal).hide();
            e.preventDefault();
        }
    }
});

// Image hover effects
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to image containers
    document.querySelectorAll('.image-container').forEach(container => {
        const overlay = container.querySelector('.image-overlay');
        
        container.addEventListener('mouseenter', function() {
            if (overlay) overlay.style.opacity = '1';
        });
        
        container.addEventListener('mouseleave', function() {
            if (overlay) overlay.style.opacity = '0';
        });
    });
});
</script>
@endsection