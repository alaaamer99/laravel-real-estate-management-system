<div class="card border-0 shadow-sm profile-card">
    <div class="card-header bg-warning text-dark">
        <h4 class="card-title mb-0">
            <i class="fas fa-lock me-2"></i>
            تحديث كلمة المرور
        </h4>
        <small class="text-muted">تأكد من استخدام كلمة مرور طويلة وعشوائية للحفاظ على أمان حسابك.</small>
    </div>
    
    <div class="card-body">
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-12 mb-3">
                    <label for="update_password_current_password" class="form-label">
                        <i class="fas fa-key text-muted me-1"></i>
                        كلمة المرور الحالية
                    </label>
                    <input type="password" 
                           class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                           id="update_password_current_password" 
                           name="current_password" 
                           autocomplete="current-password"
                           required>
                    @error('current_password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="update_password_password" class="form-label">
                        <i class="fas fa-shield-alt text-muted me-1"></i>
                        كلمة المرور الجديدة
                    </label>
                    <input type="password" 
                           class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                           id="update_password_password" 
                           name="password" 
                           autocomplete="new-password"
                           required>
                    @error('password', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="update_password_password_confirmation" class="form-label">
                        <i class="fas fa-check-double text-muted me-1"></i>
                        تأكيد كلمة المرور
                    </label>
                    <input type="password" 
                           class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                           id="update_password_password_confirmation" 
                           name="password_confirmation" 
                           autocomplete="new-password"
                           required>
                    @error('password_confirmation', 'updatePassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-2"></i>
                    تحديث كلمة المرور
                </button>

                @if (session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        تم تحديث كلمة المرور بنجاح!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
