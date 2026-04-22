<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center">
            <i class="fas fa-user-cog text-primary me-3 fs-4"></i>
            <div>
                <h2 class="mb-0 text-dark fw-bold">إدارة الحساب الشخصي</h2>
                <small class="text-muted">قم بتحديث معلوماتك الشخصية وإعدادات الأمان</small>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <!-- معلومات الحساب الشخصي -->
                <div class="mb-4">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- تحديث كلمة المرور -->
                <div class="mb-4">
                    @include('profile.partials.update-password-form')
                </div>

                <!-- معلومات إضافية -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            نصائح الأمان
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center mb-3">
                                <div class="bg-light p-3 rounded">
                                    <i class="fas fa-shield-alt text-success fs-2 mb-2"></i>
                                    <h6 class="fw-bold">كلمة مرور قوية</h6>
                                    <small class="text-muted">استخدم 8 أحرف على الأقل مع رموز خاصة</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-center mb-3">
                                <div class="bg-light p-3 rounded">
                                    <i class="fas fa-envelope-circle-check text-primary fs-2 mb-2"></i>
                                    <h6 class="fw-bold">تأكيد البريد</h6>
                                    <small class="text-muted">تحقق من بريدك الإلكتروني لحماية حسابك</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-center mb-3">
                                <div class="bg-light p-3 rounded">
                                    <i class="fas fa-clock text-warning fs-2 mb-2"></i>
                                    <h6 class="fw-bold">تحديث منتظم</h6>
                                    <small class="text-muted">حدث معلوماتك بانتظام للحفاظ على الأمان</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
