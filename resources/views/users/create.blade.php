@extends('layouts.app')

@section('title', 'إضافة مستخدم جديد')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">إضافة مستخدم جديد</h1>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> العودة للقائمة
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">الاسم الكامل *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">البريد الإلكتروني *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">كلمة المرور *</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور *</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">الدور *</label>
                        <select class="form-select @error('role') is-invalid @enderror" 
                                id="role" name="role" required>
                            <option value="">اختر الدور</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
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
                            <i class="bi bi-check-lg"></i> حفظ المستخدم
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
                <h5 class="mb-0">الأدوار المتاحة</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">مدير</h6>
                    <ul class="list-unstyled small">
                        <li><i class="bi bi-check text-success"></i> إضافة وتعديل وحذف العقارات</li>
                        <li><i class="bi bi-check text-success"></i> إدارة المستخدمين</li>
                        <li><i class="bi bi-check text-success"></i> إدارة أنواع العقارات</li>
                        <li><i class="bi bi-check text-success"></i> إدارة المسوقين</li>
                    </ul>
                </div>
                
                <div class="mb-3">
                    <h6 class="text-warning">مدخل بيانات</h6>
                    <ul class="list-unstyled small">
                        <li><i class="bi bi-check text-success"></i> إضافة وتعديل العقارات</li>
                        <li><i class="bi bi-x text-danger"></i> حذف العقارات</li>
                        <li><i class="bi bi-x text-danger"></i> إدارة المستخدمين</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection