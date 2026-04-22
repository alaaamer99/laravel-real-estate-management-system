@extends('layouts.app')

@section('title', 'الصفحة غير موجودة - السهل للعقارات')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 text-center">
            <div class="error-page">
                <!-- رقم الخطأ -->
                <div class="error-number mb-4">
                    <span class="display-1 fw-bold text-primary position-relative">
                        4
                        <i class="bi bi-house-door position-absolute top-50 start-50 translate-middle text-secondary" style="font-size: 3rem; opacity: 0.3;"></i>
                        4
                    </span>
                </div>

                <!-- رسالة الخطأ -->
                <div class="error-message mb-4">
                    <h2 class="h3 text-dark mb-3">عذراً، الصفحة غير موجودة!</h2>
                    <p class="text-muted lead">
                        الصفحة التي تبحث عنها قد تكون محذوفة أو تم نقلها إلى عنوان آخر.
                    </p>
                </div>

                <!-- إقتراحات -->
                <div class="suggestions mb-5">
                    <div class="card border-0 shadow-sm bg-light">
                        <div class="card-body py-4">
                            <h5 class="text-primary mb-3">
                                <i class="bi bi-lightbulb me-2"></i>
                                ماذا يمكنك أن تفعل؟
                            </h5>
                            <ul class="list-unstyled text-muted">
                                <li class="mb-2">
                                    <i class="bi bi-arrow-left text-success me-2"></i>
                                    تأكد من صحة رابط الصفحة
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-arrow-left text-success me-2"></i>
                                    استخدم الروابط في القائمة أعلاه
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-arrow-left text-success me-2"></i>
                                    عد إلى الصفحة الرئيسية وابدأ من جديد
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- أزرار التنقل -->
                <div class="error-actions">
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary w-100 py-3 rounded-pill">
                                <i class="bi bi-house me-2"></i>
                                الصفحة الرئيسية
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('properties.index') }}" class="btn btn-outline-success w-100 py-3 rounded-pill">
                                <i class="bi bi-building me-2"></i>
                                العقارات
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <button onclick="history.back()" class="btn btn-outline-secondary w-100 py-3 rounded-pill">
                                <i class="bi bi-arrow-right me-2"></i>
                                الصفحة السابقة
                            </button>
                        </div>
                    </div>
                </div>

                <!-- معلومات إضافية -->
                <div class="additional-info mt-5 pt-4 border-top">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <div class="feature-box">
                                <div class="feature-icon mb-2">
                                    <i class="bi bi-telephone-fill text-primary" style="font-size: 2rem;"></i>
                                </div>
                                <h6 class="mb-1">اتصل بنا</h6>
                                <small class="text-muted">للحصول على المساعدة</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="feature-box">
                                <div class="feature-icon mb-2">
                                    <i class="bi bi-envelope-fill text-success" style="font-size: 2rem;"></i>
                                </div>
                                <h6 class="mb-1">راسلنا</h6>
                                <small class="text-muted">سنرد عليك قريباً</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="feature-box">
                                <div class="feature-icon mb-2">
                                    <i class="bi bi-search text-info" style="font-size: 2rem;"></i>
                                </div>
                                <h6 class="mb-1">ابحث</h6>
                                <small class="text-muted">عن العقار المناسب</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-page {
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.error-number span {
    background: linear-gradient(45deg, #007bff, #0056b3);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 4px 8px rgba(0,123,255,0.3);
}

.feature-box {
    transition: transform 0.3s ease;
}

.feature-box:hover {
    transform: translateY(-5px);
}

.btn {
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}
</style>
@endsection