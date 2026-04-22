@extends('layouts.app')

@section('title', 'غير مصرح لك بالوصول - السهل للعقارات')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 text-center">
            <div class="error-page">
                <!-- رقم الخطأ -->
                <div class="error-number mb-4">
                    <span class="display-1 fw-bold text-danger position-relative">
                        4
                        <i class="bi bi-shield-x position-absolute top-50 start-50 translate-middle text-secondary" style="font-size: 3rem; opacity: 0.3;"></i>
                        3
                    </span>
                </div>

                <!-- رسالة الخطأ -->
                <div class="error-message mb-4">
                    <h2 class="h3 text-dark mb-3">غير مصرح لك بالوصول!</h2>
                    <p class="text-muted lead">
                        عذراً، ليس لديك الصلاحية اللازمة للوصول إلى هذه الصفحة.
                    </p>
                </div>

                <!-- معلومات الصلاحيات -->
                <div class="permissions-info mb-5">
                    <div class="card border-0 shadow-sm bg-light">
                        <div class="card-body py-4">
                            <h5 class="text-danger mb-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                معلومات الصلاحيات
                            </h5>
                            <div class="alert alert-warning border-0" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <div>
                                        <strong>المطلوب:</strong> صلاحية المدير للوصول إلى هذا القسم
                                    </div>
                                </div>
                            </div>
                            <ul class="list-unstyled text-muted mt-3">
                                <li class="mb-2">
                                    <i class="bi bi-arrow-left text-primary me-2"></i>
                                    تواصل مع المدير لطلب الصلاحية
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-arrow-left text-primary me-2"></i>
                                    تأكد من تسجيل الدخول بالحساب الصحيح
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-arrow-left text-primary me-2"></i>
                                    عد إلى الأقسام المسموحة لك
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- معلومات المستخدم -->
                @auth
                <div class="user-info mb-4">
                    <div class="card border-primary border-2">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="bi bi-person-circle me-2"></i>
                                معلومات المستخدم الحالي
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <small class="text-muted">الاسم</small>
                                    <p class="mb-1 fw-semibold">{{ auth()->user()->name }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted">الصلاحية الحالية</small>
                                    <p class="mb-1">
                                        <span class="badge bg-info">{{ auth()->user()->roles->first()->name ?? 'مستخدم عادي' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endauth

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



                <!-- تحذير أمني -->
                <div class="security-notice mt-4">
                    <div class="alert alert-light border border-warning" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-shield-check text-warning me-2" style="font-size: 1.25rem;"></i>
                            <small class="text-muted">
                                <strong>ملاحظة أمنية:</strong> 
                                تم تسجيل محاولة الوصول هذه لأغراض الأمان والمراجعة.
                            </small>
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
    background: linear-gradient(45deg, #dc3545, #c82333);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 4px 8px rgba(220,53,69,0.3);
}

.help-box {
    transition: all 0.3s ease;
    background: rgba(248, 249, 250, 0.5);
}

.help-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    background: white;
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
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.alert {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(255, 193, 7, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
    }
}
</style>
@endsection