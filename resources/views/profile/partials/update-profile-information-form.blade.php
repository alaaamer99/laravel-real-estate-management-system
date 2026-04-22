<div class="card border-0 shadow-sm profile-card">
    <div class="card-header bg-primary text-white">
        <h4 class="card-title mb-0">
            <i class="fas fa-user me-2"></i>
            معلومات الحساب الشخصي
        </h4>
        <small class="text-white-50">قم بتحديث معلومات حسابك الشخصي وعنوان البريد الإلكتروني.</small>
    </div>
    
    <div class="card-body">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-user text-muted me-1"></i>
                        الاسم الكامل
                    </label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           required 
                           autofocus 
                           autocomplete="name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope text-muted me-1"></i>
                        البريد الإلكتروني
                    </label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           required 
                           autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="alert alert-warning mt-3" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>تنبيه:</strong> عنوان البريد الإلكتروني غير مُتحقق منه.
                            <br>
                            <button type="submit" form="send-verification" class="btn btn-link p-0 text-decoration-underline mt-1">
                                انقر هنا لإعادة إرسال رسالة التحقق
                            </button>
                        </div>

                        @if (session('status') === 'verification-link-sent')
                            <div class="alert alert-success mt-2" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                تم إرسال رابط تحقق جديد إلى عنوان بريدك الإلكتروني.
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>
                    حفظ التغييرات
                </button>

                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        تم حفظ البيانات بنجاح!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
