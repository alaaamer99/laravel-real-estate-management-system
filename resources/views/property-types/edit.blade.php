@extends('layouts.app')

@section('title', 'تعديل نوع العقار')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">تعديل نوع العقار: {{ $propertyType->name }}</h1>
    <a href="{{ route('property-types.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> العودة للقائمة
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('property-types.update', $propertyType) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">اسم نوع العقار *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $propertyType->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> تحديث
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
                <h5 class="mb-0">معلومات إضافية</h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>تاريخ الإنشاء:</strong>
                    <span class="text-muted">{{ $propertyType->created_at->format('Y-m-d H:i') }}</span>
                </div>
                <div class="mb-2">
                    <strong>آخر تحديث:</strong>
                    <span class="text-muted">{{ $propertyType->updated_at->format('Y-m-d H:i') }}</span>
                </div>
                <div class="mb-2">
                    <strong>عدد العقارات المرتبطة:</strong>
                    <span class="badge bg-info">{{ $propertyType->properties()->count() }}</span>
                </div>
                
                @if($propertyType->properties()->count() > 0)
                <div class="alert alert-warning mt-3">
                    <i class="bi bi-exclamation-triangle"></i>
                    تنبيه: يوجد عقارات مرتبطة بهذا النوع. تأكد من صحة التعديل.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection