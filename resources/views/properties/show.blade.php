@extends('layouts.app')

@section('title', 'تفاصيل العقار - ' . $property->reference_number)

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
        <h1 class="h4 mb-0 text-primary">تفاصيل العقار: {{ $property->reference_number }}</h1>
        <div class="d-flex gap-2">
            @can('property.edit')
            <a href="{{ route('properties.edit', $property) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> تعديل
            </a>
            @endcan
            <button class="btn btn-info btn-sm" onclick="window.print()">
                <i class="bi bi-printer"></i> طباعة
            </button>
            <a href="{{ route('properties.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> العودة للقائمة
            </a>
        </div>
    </div>
</div>

<!-- Property Details Container -->
<div class="property-details-container">
    <div class="row g-3">
        <!-- معلومات العقار الأساسية -->
        <div class="col-lg-8">
            <!-- بطاقة المعلومات الأساسية -->
            <div class="card mb-2 shadow-sm">
                <div class="card-header bg-primary text-white py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">المعلومات الأساسية</h6>
                        <span class="badge {{ $property->status === 'متوفر' ? 'bg-success' : 'bg-danger' }}">
                            {{ $property->status }}
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <!-- عرض الشاشة -->
                    <div class="row g-2 screen-only">
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block mb-1">رقم المرجع</small>
                            <div class="fw-bold text-primary">{{ $property->reference_number }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block mb-1">التاريخ</small>
                            <div class="small">{{ $property->date->format('Y-m-d') }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block mb-1">نوع العقار</small>
                            <div class="small fw-medium">{{ $property->propertyType->name }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block mb-1">نوع الإعلان</small>
                            <div class="small">{{ $property->ad_side }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block mb-1">عدد الشركاء</small>
                            <div class="small">{{ $property->partners_count }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block mb-1">عدد الوحدات</small>
                            <div class="small">{{ $property->units_number }}</div>
                        </div>
                        <div class="col-md-6 col-12">
                            <small class="text-muted d-block mb-1">العنوان</small>
                            <div class="small">{{ $property->address }}</div>
                        </div>
                    </div>
                    
                    <!-- عرض الطباعة -->
                    <div class="row g-2 print-only">
                        <!-- الصف الأول: رقم المرجع والتاريخ -->
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">رقم المرجع</small>
                            <div class="fw-bold text-primary">{{ $property->reference_number }}</div>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">التاريخ</small>
                            <div class="small">{{ $property->date->format('Y-m-d') }}</div>
                        </div>
                        
                        <!-- الصف الثاني: نوع العقار ونوع الإعلان -->
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">نوع العقار</small>
                            <div class="small fw-medium">{{ $property->propertyType->name }}</div>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">نوع الإعلان</small>
                            <div class="small">{{ $property->ad_side }}</div>
                        </div>
                        
                        <div class="col-12 d-flex justify-content-between align-items-start">
                            <!-- الصف الثالث: العنوان -->
                            <div class="adress">
                                <small class="text-muted d-block mb-1">العنوان</small>
                                <div class="small">{{ $property->address }}</div>
                            </div>    
                            <div class="partners-info">
                                <!-- المسوقين -->
                                @if($property->partners->count() > 0)
                                    <small class="text-muted d-block mb-1">المسوقين ({{ $property->partners->count() }})</small>
                                    <div class="small">
                                        @foreach($property->partners as $partner)
                                            {{ $partner->name }}@if(!$loop->last) - @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>

            <!-- بطاقة المعلومات المالية -->
            <div class="card mb-2 shadow-sm">
                <div class="card-header bg-success text-white py-2">
                    <h6 class="mb-0 fw-bold">المعلومات المالية</h6>
                </div>
                <div class="card-body py-2">
                    <div class="row g-2">
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">المساحة (قدم)</small>
                            <div class="fw-bold text-primary">{{ number_format($property->area, 0) }}</div>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">السعر الإجمالي</small>
                            <div class="fw-bold text-success">{{ number_format($property->price, 0) }} درهم</div>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">السعر لكل قدم</small>
                            <div class="fw-bold text-info">{{ number_format($property->price_per_foot, 0) }} درهم</div>
                        </div>
                        <div class="col-3">
                            <small class="text-muted d-block mb-1">حالة السعر</small>
                            <span class="badge {{ $property->price_status === 'نهائي' ? 'bg-info' : 'bg-warning' }} small">
                                {{ $property->price_status }}
                            </span>
                        </div>
                        @if($property->annual_return)
                        <div class="col-md-6 col-6">
                            <small class="text-muted d-block mb-1">العائد السنوي</small>
                            <div class="fw-bold text-warning">{{ $property->annual_return }}%</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- بطاقة الوصف -->
            @if($property->description)
            <div class="card mb-2 shadow-sm">
                <div class="card-header bg-info text-white py-1">
                    <h6 class="mb-0 fw-bold">الوصف</h6>
                </div>
                <div class="card-body py-2">
                    <p class="mb-0 small">{{ $property->description }}</p>
                </div>
            </div>
            @endif

            <!-- بطاقة المسوقين -->
            @if($property->partners->count() > 0)
            <div class="card mb-2 shadow-sm screen-only">
                <div class="card-header bg-secondary text-white py-2">
                    <h6 class="mb-0 fw-bold">المسوقين المرتبطة</h6>
                </div>
                <div class="card-body py-2">
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($property->partners as $partner)
                        <span class="badge bg-primary small">{{ $partner->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- الشريط الجانبي -->
        <div class="col-lg-4">
            <!-- إحصائيات سريعة -->
            <div class="card mb-2 shadow-sm screen-only">
                <div class="card-header bg-warning text-dark py-1">
                    <h6 class="mb-0 fw-bold">معلومات إضافية</h6>
                </div>
                <div class="card-body py-2">
                    <div class="row g-1">
                        <div class="col-6">
                            <div class="d-flex justify-content-around align-items-center mb-1">
                                <small class="text-muted">إعلان:</small>
                                <span class="badge {{ $property->is_ad ? 'bg-success' : 'bg-secondary' }} small">
                                    {{ $property->is_ad ? 'نعم' : 'لا' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-around align-items-center mb-1">
                                <small class="text-muted">المُنشئ:</small>
                                <small class="fw-bold">{{ $property->creator->name }}</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-around align-items-center mb-1">
                                <small class="text-muted">تاريخ الإنشاء:</small>
                                <small>{{ $property->created_at->format('Y-m-d') }}</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-around align-items-center">
                                <small class="text-muted">آخر تحديث:</small>
                                <small>{{ $property->updated_at->format('Y-m-d') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- رفع الصور الجديدة -->
            @can('property.edit')
            <div class="card mb-3 shadow-sm screen-only">
                <div class="card-header bg-info text-white py-2">
                    <h6 class="mb-0 fw-bold">إضافة صور جديدة</h6>
                </div>
                <div class="card-body py-2">
                    <form id="uploadImagesForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <input type="file" class="form-control form-control-sm" 
                                   id="newImages" name="images[]" multiple accept=".jpg,.jpeg,.png"
                                   {{ $property->images->count() >= 6 ? 'disabled' : '' }}>
                            <small class="text-muted">
                                @if($property->images->count() >= 6)
                                    تم الوصول للحد الأقصى (6 صور)
                                @else
                                    يمكنك اختيار {{ 6 - $property->images->count() }} صور إضافية
                                @endif
                            </small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100"
                                {{ $property->images->count() >= 6 ? 'disabled' : '' }}>
                            <i class="bi bi-upload"></i> رفع الصور
                        </button>
                    </form>
                </div>
            </div>
            @endcan

            <!-- الإجراءات -->
            <div class="card shadow-sm screen-only">
                <div class="card-header bg-dark text-white py-2">
                    <h6 class="mb-0 fw-bold">الإجراءات</h6>
                </div>
                <div class="card-body py-2">
                    <div class="d-grid gap-1">
                        @can('property.edit')
                        <a href="{{ route('properties.edit', $property) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> تعديل العقار
                        </a>
                        @endcan
                        
                        <button class="btn btn-info btn-sm" onclick="window.print()">
                            <i class="bi bi-printer"></i> طباعة التفاصيل
                        </button>
                        
                        <button class="btn btn-success btn-sm" onclick="shareProperty()">
                            <i class="bi bi-share"></i> مشاركة العقار
                        </button>
                        
                        @can('property.delete')
                        <form method="POST" action="{{ route('properties.destroy', $property) }}" 
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا العقار؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> حذف العقار
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- صور العقار -->
@if($property->images->count() > 0)
<div class="property-images-section mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-2">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">صور العقار ({{ $property->images->count() }} من 6 صور)</h6>
                <div class="d-flex gap-2 align-items-center">
                    <small class="text-light screen-only">انقر على الصورة للعرض الكامل</small>
                    @if($property->images->count() > 0)
                    <a href="{{ route('property.images.download', $property) }}" class="btn btn-light btn-sm screen-only">
                        <i class="bi bi-download"></i> تحميل جميع الصور
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body p-2">
            <!-- عرض الصور في الشاشة -->
            <div class="row g-2 screen-only">
                @foreach($property->images as $index => $image)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="position-relative image-container" onclick="openImageModal({{ $index }})" style="cursor: pointer;">
                        <img src="{{ Storage::url($image->image_path) }}" 
                             class="img-fluid rounded shadow-sm property-image" 
                             alt="صورة العقار {{ $index + 1 }}"
                             loading="lazy">
                        @can('property.edit')
                        <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-image-btn"
                                onclick="deleteImage({{ $image->id }}); event.stopPropagation();"
                                title="حذف الصورة">
                            <i class="bi bi-trash" style="font-size: 10px;"></i>
                        </button>
                        @endcan
                        <div class="image-overlay">
                            <i class="bi bi-zoom-in text-white"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- عرض الصور في الطباعة -->
            <div class="print-images print-only">
                <div class="row g-1">
                    @foreach($property->images->take(6) as $index => $image)
                    <div class="col-4">
                        <img src="{{ Storage::url($image->image_path) }}" 
                             class="img-fluid rounded border print-image" 
                             alt="صورة العقار {{ $index + 1 }}">
                    </div>
                    @endforeach
                </div>
                @if($property->images->count() > 6)
                <p class="text-center mt-2 mb-0 small text-muted">
                    وعدد {{ $property->images->count() - 6 }} صور أخرى
                </p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal لعرض الصور -->
@if($property->images->count() > 0)
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">
                    <span id="imageCounter">صورة 1 من {{ $property->images->count() }}</span>
                    - عقار رقم {{ $property->reference_number }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body text-center position-relative p-2">
                <img id="modalImage" src="{{ Storage::url($property->images->first()->image_path) }}" 
                     class="img-fluid rounded shadow" alt="صورة العقار" style="max-height: 70vh;">
                
                @if($property->images->count() > 1)
                <!-- أزرار التنقل -->
                <button type="button" class="btn btn-dark btn-lg position-absolute top-50 start-0 translate-middle-y ms-3" 
                        id="prevImage" style="opacity: 0.8;">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button type="button" class="btn btn-dark btn-lg position-absolute top-50 end-0 translate-middle-y me-3" 
                        id="nextImage" style="opacity: 0.8;">
                    <i class="bi bi-chevron-right"></i>
                </button>
                @endif
            </div>
            @if($property->images->count() > 1)
            <div class="modal-footer justify-content-center">
                <div class="d-flex gap-2 flex-wrap" id="imageThumbnails">
                    @foreach($property->images as $index => $image)
                    <img src="{{ Storage::url($image->image_path) }}" 
                         class="img-thumbnail thumbnail-nav {{ $index == 0 ? 'active' : '' }}" 
                         style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                         data-index="{{ $index }}"
                         onclick="showImage({{ $index }})"
                         alt="صورة مصغرة {{ $index + 1 }}">
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endif
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
            @can('property.edit')
            <small class="text-primary">يمكنك إضافة صور من النموذج أعلاه</small>
            @endcan
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

@push('scripts')
<script>
// متغيرات للتحكم في الصور
let currentImageIndex = 0;
let totalImages = {{ $property->images->count() }};
let imagesSrc = [];

@if($property->images->count() > 0)
    @foreach($property->images as $index => $image)
        imagesSrc.push({!! json_encode(Storage::url($image->image_path)) !!});
    @endforeach
@endif

function openImageModal(imageIndex) {
    console.log('Opening modal with image index:', imageIndex);
    
    if (totalImages === 0 || imageIndex < 0 || imageIndex >= totalImages) {
        console.log('Invalid image index or no images');
        return;
    }
    
    currentImageIndex = imageIndex;
    console.log('Current image index:', currentImageIndex);
    console.log('Image src:', imagesSrc[currentImageIndex]);
    
    showImage(currentImageIndex);
    
    // فتح الـ modal
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}

function showImage(index) {
    console.log('showImage called with index:', index);
    
    if (index < 0 || index >= totalImages) {
        console.log('Invalid index');
        return;
    }
    
    currentImageIndex = index;
    const modalImage = document.getElementById('modalImage');
    const counterElement = document.getElementById('imageCounter');
    
    console.log('Modal image element:', modalImage);
    console.log('Image source to set:', imagesSrc[index]);
    
    if (modalImage && imagesSrc[index]) {
        modalImage.src = imagesSrc[index];
        console.log('Image src set successfully');
    } else {
        console.log('Failed to set image src - modalImage:', modalImage, 'imageSrc:', imagesSrc[index]);
    }
    
    if (counterElement) {
        counterElement.textContent = `صورة ${index + 1} من ${totalImages}`;
        console.log('Counter updated');
    }
    
    // تحديث الـ thumbnails
    document.querySelectorAll('.thumbnail-nav').forEach((thumb, i) => {
        thumb.classList.toggle('active', i === index);
    });
}

function deleteImage(imageId) {
    if (confirm('هل أنت متأكد من حذف هذه الصورة؟')) {
        fetch(`/property-images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('تم حذف الصورة بنجاح', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert('حدث خطأ أثناء حذف الصورة', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('حدث خطأ أثناء حذف الصورة', 'error');
        });
    }
}

function shareProperty() {
    if (navigator.share) {
        navigator.share({
            title: {!! json_encode('عقار: ' . $property->reference_number) !!},
            text: {!! json_encode($property->description) !!},
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href).then(() => {
            showAlert('تم نسخ رابط العقار إلى الحافظة', 'success');
        });
    }
}

// Handle image upload
document.getElementById('uploadImagesForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    const imageFiles = document.getElementById('newImages').files;
    
    if (imageFiles.length === 0) {
        showAlert('يرجى اختيار صور للرفع', 'error');
        return;
    }
    
    // Add CSRF token
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    // Add images
    for (let i = 0; i < imageFiles.length; i++) {
        formData.append('images[]', imageFiles[i]);
    }
    
    // Show loading
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> جاري الرفع...';
    submitBtn.disabled = true;
    
    fetch(`/properties/{{ $property->id }}/upload-images`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('تم رفع الصور بنجاح', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showAlert('حدث خطأ أثناء رفع الصور', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('حدث خطأ أثناء رفع الصور', 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

function showAlert(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) alert.remove();
    }, 4000);
}

// Print optimization
window.addEventListener('beforeprint', function() {
    document.body.classList.add('printing');
});

window.addEventListener('afterprint', function() {
    document.body.classList.remove('printing');
});

// أحداث التنقل في الـ modal
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, total images:', totalImages);
    console.log('Images array:', imagesSrc);
    
    if (totalImages <= 0) {
        console.log('No images to show');
        return;
    }
    
    // التنقل بالأزرار
    const prevBtn = document.getElementById('prevImage');
    const nextBtn = document.getElementById('nextImage');
    
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            const newIndex = currentImageIndex > 0 ? currentImageIndex - 1 : totalImages - 1;
            showImage(newIndex);
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            const newIndex = currentImageIndex < totalImages - 1 ? currentImageIndex + 1 : 0;
            showImage(newIndex);
        });
    }
    
    // التنقل بالـ thumbnails
    document.querySelectorAll('.thumbnail-nav').forEach((thumb, index) => {
        thumb.addEventListener('click', function() {
            showImage(parseInt(thumb.dataset.index));
        });
    });
    
    // اختبار فتح الـ modal
    console.log('Image modal element:', document.getElementById('imageModal'));
});
</script>
@endpush
@endsection