@extends('layouts.app')

@section('title', 'تعديل المستخدم')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">تعديل المستخدم: {{ $user->name }}</h1>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> العودة للقائمة
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">الاسم الكامل *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">البريد الإلكتروني *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">كلمة المرور الجديدة</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password">
                            <div class="form-text">اتركه فارغاً إذا كنت لا تريد تغيير كلمة المرور</div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">الدور *</label>
                        <select class="form-select @error('role') is-invalid @enderror" 
                                id="role" name="role" required>
                            <option value="">اختر الدور</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" 
                                        {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> تحديث المستخدم
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">معلومات إضافية</h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>تاريخ الإنشاء:</strong>
                    <span class="text-muted">{{ $user->created_at->format('Y-m-d H:i') }}</span>
                </div>
                <div class="mb-2">
                    <strong>آخر تحديث:</strong>
                    <span class="text-muted">{{ $user->updated_at->format('Y-m-d H:i') }}</span>
                </div>
                <div class="mb-2">
                    <strong>الدور الحالي:</strong>
                    @foreach($user->roles as $role)
                        <span class="badge bg-primary">{{ $role->name }}</span>
                    @endforeach
                </div>
                
                @if($user->id === auth()->id())
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle"></i>
                    هذا هو حسابك الشخصي
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection