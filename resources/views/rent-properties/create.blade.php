@extends('layouts.app')

@section('title', 'إضافة عقار للإيجار - السهل للعقارات')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        إضافة عقار جديد للإيجار
                    </h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('rent-properties.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- رقم العقار والتاريخ -->
                            <div class="col-md-6 mb-3">
                                <label for="property_number" class="form-label">
                                    <i class="fas fa-hashtag text-muted me-1"></i>
                                    رقم العقار *
                                </label>
                                <input type="number" 
                                       class="form-control @error('property_number') is-invalid @enderror" 
                                       id="property_number" 
                                       name="property_number" 
                                       value="{{ old('property_number') }}" 
                                       required>
                                @error('property_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">
                                    <i class="fas fa-calendar text-muted me-1"></i>
                                    التاريخ *
                                </label>
                                <input type="date" 
                                       class="form-control @error('date') is-invalid @enderror" 
                                       id="date" 
                                       name="date" 
                                       value="{{ old('date', date('Y-m-d')) }}" 
                                       required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- نوع العقار والمسوق -->
                            <div class="col-md-6 mb-3">
                                <label for="property_type_id" class="form-label">
                                    <i class="fas fa-building text-muted me-1"></i>
                                    نوع العقار *
                                </label>
                                <select class="form-select @error('property_type_id') is-invalid @enderror" 
                                        id="property_type_id" 
                                        name="property_type_id" 
                                        required>
                                    <option value="">اختر نوع العقار</option>
                                    @foreach($propertyTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('property_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('property_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="rent_partner_id" class="form-label">
                                    <i class="fas fa-user-tie text-muted me-1"></i>
                                    المسوق
                                </label>
                                <select class="form-select @error('rent_partner_id') is-invalid @enderror" 
                                        id="rent_partner_id" 
                                        name="rent_partner_id">
                                    <option value="">اختر المسوق (اختياري)</option>
                                    @foreach($rentPartners as $partner)
                                        <option value="{{ $partner->id }}" {{ old('rent_partner_id') == $partner->id ? 'selected' : '' }}>
                                            {{ $partner->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rent_partner_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- العنوان -->
                        <div class="mb-3">
                            <label for="address" class="form-label">
                                <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                العنوان *
                            </label>
                            <input type="text" 
                                   class="form-control @error('address') is-invalid @enderror" 
                                   id="address" 
                                   name="address" 
                                   value="{{ old('address') }}" 
                                   required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <!-- الغرف والحمامات -->
                            <div class="col-md-3 mb-3">
                                <label for="rooms" class="form-label">
                                    <i class="fas fa-bed text-muted me-1"></i>
                                    عدد الغرف *
                                </label>
                                <input type="number" 
                                       class="form-control @error('rooms') is-invalid @enderror" 
                                       id="rooms" 
                                       name="rooms" 
                                       value="{{ old('rooms') }}" 
                                       min="1" 
                                       required>
                                @error('rooms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="bathrooms" class="form-label">
                                    <i class="fas fa-bath text-muted me-1"></i>
                                    عدد الحمامات *
                                </label>
                                <input type="number" 
                                       class="form-control @error('bathrooms') is-invalid @enderror" 
                                       id="bathrooms" 
                                       name="bathrooms" 
                                       value="{{ old('bathrooms') }}" 
                                       min="1" 
                                       required>
                                @error('bathrooms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="area" class="form-label">
                                    <i class="fas fa-ruler-combined text-muted me-1"></i>
                                    المساحة (م²) *
                                </label>
                                <input type="number" 
                                       class="form-control @error('area') is-invalid @enderror" 
                                       id="area" 
                                       name="area" 
                                       value="{{ old('area') }}" 
                                       step="0.01" 
                                       min="0" 
                                       required>
                                @error('area')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="payment_installments" class="form-label">
                                    <i class="fas fa-credit-card text-muted me-1"></i>
                                    عدد الدفعات *
                                </label>
                                <input type="number" 
                                       class="form-control @error('payment_installments') is-invalid @enderror" 
                                       id="payment_installments" 
                                       name="payment_installments" 
                                       value="{{ old('payment_installments', 1) }}" 
                                       min="1" 
                                       max="12" 
                                       required>
                                @error('payment_installments')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- نوع الإيجار والسعر -->
                            <div class="col-md-4 mb-3">
                                <label for="rental_type" class="form-label">
                                    <i class="fas fa-calendar-alt text-muted me-1"></i>
                                    نوع الإيجار *
                                </label>
                                <select class="form-select @error('rental_type') is-invalid @enderror" 
                                        id="rental_type" 
                                        name="rental_type" 
                                        required>
                                    <option value="">اختر نوع الإيجار</option>
                                    <option value="monthly" {{ old('rental_type') == 'monthly' ? 'selected' : '' }}>شهري</option>
                                    <option value="quarterly" {{ old('rental_type') == 'quarterly' ? 'selected' : '' }}>ربع سنوي</option>
                                    <option value="semi_annual" {{ old('rental_type') == 'semi_annual' ? 'selected' : '' }}>نصف سنوي</option>
                                    <option value="annual" {{ old('rental_type') == 'annual' ? 'selected' : '' }}>سنوي</option>
                                </select>
                                @error('rental_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="price" class="form-label">
                                    <i class="fas fa-money-bill text-muted me-1"></i>
                                    السعر (درهم) *
                                </label>
                                <input type="number" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price') }}" 
                                       step="0.01" 
                                       min="0" 
                                       required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">
                                    <i class="fas fa-info-circle text-muted me-1"></i>
                                    الحالة *
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>متاح</option>
                                    <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>مؤجر</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- الوصف -->
                        <div class="mb-3">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left text-muted me-1"></i>
                                الوصف
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="أدخل وصف مفصل للعقار...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- رفع الصور -->
                        <div class="mb-4">
                            <label for="images" class="form-label">
                                <i class="fas fa-images text-muted me-1"></i>
                                صور العقار (الحد الأقصى 6 صور)
                            </label>
                            <input type="file" 
                                   class="form-control @error('images.*') is-invalid @enderror" 
                                   id="images" 
                                   name="images[]" 
                                   multiple 
                                   accept="image/jpeg,image/jpg,image/png,image/gif">
                            <div class="form-text">يمكن رفع صور بصيغة JPG, PNG, GIF. سيتم تحويل الصور تلقائياً إلى WebP لتحسين الأداء.</div>
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- الأزرار -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('rent-properties.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right me-2"></i>
                                العودة للقائمة
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>
                                حفظ العقار
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection