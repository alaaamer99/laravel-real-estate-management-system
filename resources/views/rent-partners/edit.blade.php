@extends('layouts.app')

@section('title', 'تعديل المسوق - السهل للعقارات')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>
                        تعديل المسوق
                    </h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('rent-partners.update', $rentPartner) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user text-muted me-1"></i>
                                    اسم المسوق *
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $rentPartner->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone text-muted me-1"></i>
                                    رقم الهاتف
                                </label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $rentPartner->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope text-muted me-1"></i>
                                    البريد الإلكتروني
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $rentPartner->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="commission_rate" class="form-label">
                                    <i class="fas fa-percentage text-muted me-1"></i>
                                    نسبة العمولة (%)
                                </label>
                                <input type="number" 
                                       class="form-control @error('commission_rate') is-invalid @enderror" 
                                       id="commission_rate" 
                                       name="commission_rate" 
                                       value="{{ old('commission_rate', $rentPartner->commission_rate) }}" 
                                       step="0.01" 
                                       min="0" 
                                       max="100">
                                @error('commission_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">
                                <i class="fas fa-sticky-note text-muted me-1"></i>
                                ملاحظات
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="3"
                                      placeholder="ملاحظات إضافية...">{{ old('notes', $rentPartner->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $rentPartner->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    <i class="fas fa-toggle-on text-success me-1"></i>
                                    فعال
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('rent-partners.index') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-arrow-right me-2"></i>
                                    العودة للقائمة
                                </a>
                                <a href="{{ route('rent-partners.show', $rentPartner) }}" class="btn btn-outline-info">
                                    <i class="fas fa-eye me-2"></i>
                                    عرض التفاصيل
                                </a>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>
                                تحديث المسوق
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- معلومات إضافية عن العقارات المرتبطة -->
            @if($rentPartner->rentProperties->count() > 0)
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-building me-2"></i>
                        العقارات المرتبطة ({{ $rentPartner->rentProperties->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>تنبيه:</strong> هذا المسوق مُعين على {{ $rentPartner->rentProperties->count() }} عقار. 
                        في حالة إلغاء تفعيله، ستحتاج لإعادة تعيين العقارات لمسوق آخر.
                    </div>
                    <div class="row">
                        @foreach($rentPartner->rentProperties->take(6) as $property)
                        <div class="col-md-4 mb-2">
                            <div class="card bg-light">
                                <div class="card-body p-2">
                                    <small class="text-muted">رقم العقار:</small>
                                    <p class="mb-0 fw-bold">{{ $property->property_number }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @if($rentPartner->rentProperties->count() > 6)
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body p-2 text-center">
                                    <i class="fas fa-plus fa-2x mb-1"></i>
                                    <p class="mb-0">{{ $rentPartner->rentProperties->count() - 6 }} عقار آخر</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection