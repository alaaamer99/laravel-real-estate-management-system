@extends('layouts.app')

@section('title', 'إضافة طرف جديد')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">إضافة طرف جديد</h1>
    <a href="{{ route('partners.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> العودة للقائمة
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('partners.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">اسم الطرف *</label>
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
                        <a href="{{ route('partners.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">أمثلة للأطراف</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="bi bi-building text-primary"></i> شركة العقارات الأولى</li>
                    <li><i class="bi bi-building text-success"></i> مكتب الخليج العقاري</li>
                    <li><i class="bi bi-building text-warning"></i> شركة الاستثمار العقاري</li>
                    <li><i class="bi bi-person text-info"></i> مكتب المدينة للعقارات</li>
                    <li><i class="bi bi-briefcase text-secondary"></i> شركة الرياض للتطوير</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection