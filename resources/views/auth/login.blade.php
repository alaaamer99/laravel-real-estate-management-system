<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل الدخول</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/icon128.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>
<body>
    <!-- Floating Background Elements -->
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <div class="main-container">
        <div class="login-wrapper">

            <!-- Login Form Side -->
            <div class="login-form">
                <div class="form-title">
                    <p>مرحباً بك في نظام إدارة العقارات</p>
                </div>
                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Email Address -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> البريد الإلكتروني
                        </label>
                        <input id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="أدخل بريدك الإلكتروني">
                        @error('email')
                            <span class="error-message">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> كلمة المرور
                        </label>
                        <input id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               type="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="أدخل كلمة المرور">
                        @error('password')
                            <span class="error-message">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember_me" class="form-check-label">
                            تذكرني
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        دخول
                    </button>

                    <!-- Forgot Password Link -->
                    @if (Route::has('password.request'))
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            <i class="fas fa-question-circle"></i>
                            نسيت كلمة المرور؟
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add smooth animation to form elements
        document.addEventListener('DOMContentLoaded', function() {
            const formElements = document.querySelectorAll('.form-group');
            formElements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    element.style.transition = 'all 0.6s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Add focus effects
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>
