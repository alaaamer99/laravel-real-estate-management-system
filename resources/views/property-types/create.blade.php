@extends('layouts.app')

@section('title', 'إضافة نوع عقار جديد')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">إضافة نوع عقار جديد</h1>
    <a href="{{ route('property-types.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> العودة للقائمة
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('property-types.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">اسم نوع العقار *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> حفظ
                        </button>
                        <a href="{{ route('property-types.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">أنواع العقارات المقترحة</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="bi bi-building text-primary"></i> بناية</li>
                    <li><i class="bi bi-house text-success"></i> فيلا</li>
                    <li><i class="bi bi-shop text-warning"></i> محل تجاري</li>
                    <li><i class="bi bi-buildings text-info"></i> شقة</li>
                    <li><i class="bi bi-building-gear text-secondary"></i> مستودع</li>
                    <li><i class="bi bi-laptop text-dark"></i> مكتب</li>
                    <li><i class="bi bi-geo-alt text-danger"></i> أرض</li>
                    <li><i class="bi bi-house-door text-primary"></i> حوطة</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection