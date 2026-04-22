@extends('layouts.app')

@section('title', 'تعديل عقار الإيجار - ' . $rentProperty->property_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">تعديل عقار الإيجار: {{ $rentProperty->property_number }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('rent-properties.show', $rentProperty) }}" class="btn btn-info">
            <i class="bi bi-eye"></i> عرض التفاصيل
        </a>
        <a href="{{ route('rent-properties.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة للقائمة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('rent-properties.update', $rentProperty) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="property_number" class="form-label">رقم العقار *</label>
                            <input type="number" class="form-control @error('property_number') is-invalid @enderror" 
                                   id="property_number" name="property_number" value="{{ old('property_number', $rentProperty->property_number) }}" required>
                            @error('property_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label">التاريخ *</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date', $rentProperty->date->format('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="property_type_id" class="form-label">نوع العقار *</label>
                            <select class="form-select @error('property_type_id') is-invalid @enderror" 
                                    id="property_type_id" name="property_type_id" required>
                                <option value="">اختر نوع العقار</option>
                                @foreach($propertyTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('property_type_id', $rentProperty->property_type_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('property_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="rent_partner_id" class="form-label">المسوق</label>
                            <select class="form-select @error('rent_partner_id') is-invalid @enderror" 
                                    id="rent_partner_id" name="rent_partner_id">
                                <option value="">اختر المسوق (اختياري)</option>
                                @foreach($rentPartners as $partner)
                                    <option value="{{ $partner->id }}" {{ old('rent_partner_id', $rentProperty->rent_partner_id) == $partner->id ? 'selected' : '' }}>
                                        {{ $partner->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rent_partner_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">العنوان *</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" 
                               id="address" name="address" value="{{ old('address', $rentProperty->address) }}" required>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="rooms" class="form-label">عدد الغرف *</label>
                            <input type="number" class="form-control @error('rooms') is-invalid @enderror" 
                                   id="rooms" name="rooms" value="{{ old('rooms', $rentProperty->rooms) }}" min="1" required>
                            @error('rooms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="bathrooms" class="form-label">عدد الحمامات *</label>
                            <input type="number" class="form-control @error('bathrooms') is-invalid @enderror" 
                                   id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $rentProperty->bathrooms) }}" min="1" required>
                            @error('bathrooms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="area" class="form-label">المساحة (م²) *</label>
                            <input type="number" class="form-control @error('area') is-invalid @enderror" 
                                   id="area" name="area" value="{{ old('area', $rentProperty->area) }}" step="0.01" min="0" required>
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="payment_installments" class="form-label">عدد الدفعات *</label>
                            <input type="number" class="form-control @error('payment_installments') is-invalid @enderror" 
                                   id="payment_installments" name="payment_installments" value="{{ old('payment_installments', $rentProperty->payment_installments) }}" min="1" max="12" required>
                            @error('payment_installments')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="rental_type" class="form-label">نوع الإيجار *</label>
                            <select class="form-select @error('rental_type') is-invalid @enderror" 
                                    id="rental_type" name="rental_type" required>
                                <option value="">اختر نوع الإيجار</option>
                                <option value="monthly" {{ old('rental_type', $rentProperty->rental_type) == 'monthly' ? 'selected' : '' }}>شهري</option>
                                <option value="quarterly" {{ old('rental_type', $rentProperty->rental_type) == 'quarterly' ? 'selected' : '' }}>ربع سنوي</option>
                                <option value="semi_annual" {{ old('rental_type', $rentProperty->rental_type) == 'semi_annual' ? 'selected' : '' }}>نصف سنوي</option>
                                <option value="annual" {{ old('rental_type', $rentProperty->rental_type) == 'annual' ? 'selected' : '' }}>سنوي</option>
                            </select>
                            @error('rental_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="price" class="form-label">السعر (درهم) *</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price', $rentProperty->price) }}" step="0.01" min="0" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">الحالة *</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="">اختر الحالة</option>
                                <option value="available" {{ old('status', $rentProperty->status) == 'available' ? 'selected' : '' }}>متاح</option>
                                <option value="rented" {{ old('status', $rentProperty->status) == 'rented' ? 'selected' : '' }}>مؤجر</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">الوصف</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" placeholder="وصف اختياري للعقار">{{ old('description', $rentProperty->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- صور العقار -->
                    <div class="mb-3">
                        <label for="images" class="form-label">صور العقار</label>
                        <div class="border rounded p-3">
                            <!-- الصور الموجودة -->
                            @if($rentProperty->images && count($rentProperty->images) > 0)
                                <div class="mb-3">
                                    <h6>الصور الموجودة:</h6>
                                    <div class="row" id="existing-images">
                                        @foreach($rentProperty->images as $index => $image)
                                            <div class="col-md-3 mb-2 image-item" data-index="{{ $index }}">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/rent_properties/' . $rentProperty->property_number . '/' . $image) }}" 
                                                         class="img-thumbnail" style="width: 100%; height: 100px; object-fit: cover;">
                                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-existing-image" 
                                                            data-image="{{ $image }}">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                            @endif
                            
                            <!-- رفع صور جديدة -->
                            <div>
                                <label for="new_images" class="form-label">إضافة صور جديدة (حد أقصى {{ 6 - count($rentProperty->images ?? []) }} صور)</label>
                                <input type="file" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" 
                                       id="new_images" name="images[]" multiple accept="image/*">
                                <div class="form-text">يمكنك اختيار حتى {{ 6 - count($rentProperty->images ?? []) }} صور (JPG, PNG, WebP)</div>
                                @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <!-- معاينة الصور الجديدة -->
                                <div id="new-images-preview" class="row mt-3" style="display: none;"></div>
                            </div>
                        </div>
                        
                        <!-- قائمة الصور المحذوفة -->
                        <input type="hidden" id="removed_images" name="removed_images" value="">
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2"></i> تحديث العقار
                        </button>
                        <a href="{{ route('rent-properties.show', $rentProperty) }}" class="btn btn-secondary">
                            <i class="bi bi-x"></i> إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- الشريط الجانبي -->
    <div class="col-lg-4">
        <!-- معلومات العقار الحالية -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">معلومات العقار الحالية</h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6">
                        <small class="text-muted">رقم العقار:</small>
                        <div class="fw-bold">{{ $rentProperty->property_number }}</div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">الحالة:</small>
                        <div class="small">
                            <span class="badge {{ $rentProperty->status === 'available' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $rentProperty->status_text }}
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">السعر:</small>
                        <div class="text-success fw-bold">{{ number_format($rentProperty->price) }} درهم</div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">نوع الإيجار:</small>
                        <div class="small">{{ $rentProperty->rental_type_text }}</div>
                    </div>
                    <div class="col-12 mt-2">
                        <small class="text-muted">آخر تحديث:</small>
                        <div class="small">{{ $rentProperty->updated_at->format('Y-m-d H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newImagesInput = document.getElementById('new_images');
    const newImagesPreview = document.getElementById('new-images-preview');
    const removedImagesInput = document.getElementById('removed_images');
    let removedImages = [];

    // معاينة الصور الجديدة
    newImagesInput.addEventListener('change', function(e) {
        newImagesPreview.innerHTML = '';
        
        if (e.target.files.length > 0) {
            newImagesPreview.style.display = 'flex';
            
            for (let i = 0; i < e.target.files.length; i++) {
                const file = e.target.files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'col-md-3 mb-2';
                    div.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" class="img-thumbnail" style="width: 100%; height: 100px; object-fit: cover;">
                            <small class="text-muted d-block text-center mt-1">${file.name}</small>
                        </div>
                    `;
                    newImagesPreview.appendChild(div);
                };
                
                reader.readAsDataURL(file);
            }
        } else {
            newImagesPreview.style.display = 'none';
        }
    });

    // حذف الصور الموجودة
    document.querySelectorAll('.remove-existing-image').forEach(button => {
        button.addEventListener('click', function() {
            const imageName = this.getAttribute('data-image');
            const imageItem = this.closest('.image-item');
            
            if (confirm('هل أنت متأكد من حذف هذه الصورة؟')) {
                // إضافة الصورة لقائمة الصور المحذوفة
                removedImages.push(imageName);
                removedImagesInput.value = JSON.stringify(removedImages);
                
                // إخفاء الصورة من الواجهة
                imageItem.style.display = 'none';
                
                // تحديث النص المساعد لرفع الصور
                const currentCount = document.querySelectorAll('.image-item:not([style*="display: none"])').length;
                const maxNew = 6 - currentCount;
                document.querySelector('label[for="new_images"]').textContent = `إضافة صور جديدة (حد أقصى ${maxNew} صور)`;
                document.querySelector('.form-text').textContent = `يمكنك اختيار حتى ${maxNew} صور (JPG, PNG, WebP)`;
            }
        });
    });
});
</script>
@endsection