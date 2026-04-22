@extends('layouts.app')

@section('title', 'تعديل العقار - ' . $property->reference_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">تعديل العقار: {{ $property->reference_number }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('properties.show', $property) }}" class="btn btn-info">
            <i class="bi bi-eye"></i> عرض التفاصيل
        </a>
        <a href="{{ route('properties.index') }}" class="btn btn-secondary">
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
                
                <form method="POST" action="{{ route('properties.update', $property) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="reference_number" class="form-label">رقم المرجع *</label>
                            <input type="text" class="form-control @error('reference_number') is-invalid @enderror" 
                                   id="reference_number" name="reference_number" value="{{ old('reference_number', $property->reference_number) }}" required>
                            @error('reference_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label">التاريخ *</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                   id="date" name="date" value="{{ old('date', $property->date->format('Y-m-d')) }}" required>
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
                                    <option value="{{ $type->id }}" {{ old('property_type_id', $property->property_type_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('property_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="ad_side" class="form-label">نوع الإعلان *</label>
                            <select class="form-select @error('ad_side') is-invalid @enderror" 
                                    id="ad_side" name="ad_side" required>
                                <option value="">اختر نوع الإعلان</option>
                                <option value="مباشر" {{ old('ad_side', $property->ad_side) == 'مباشر' ? 'selected' : '' }}>مباشر</option>
                                <option value="طرف" {{ old('ad_side', $property->ad_side) == 'طرف' ? 'selected' : '' }}>طرف</option>
                            </select>
                            @error('ad_side')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="partners_count" class="form-label">عدد الشركاء *</label>
                            <input type="number" class="form-control @error('partners_count') is-invalid @enderror" 
                                   id="partners_count" name="partners_count" value="{{ old('partners_count', $property->partners_count) }}" min="1" required>
                            @error('partners_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="units_number" class="form-label">عدد الوحدات *</label>
                            <input type="number" class="form-control @error('units_number') is-invalid @enderror" 
                                   id="units_number" name="units_number" value="{{ old('units_number', $property->units_number) }}" min="1" required>
                            @error('units_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">العنوان *</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" required>{{ old('address', $property->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="area" class="form-label">المساحة (قدم) *</label>
                            <input type="number" step="0.01" class="form-control @error('area') is-invalid @enderror" 
                                   id="area" name="area" value="{{ old('area', $property->area) }}" min="0" required>
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="price" class="form-label">السعر (درهم) *</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price', $property->price) }}" min="0" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="price_per_foot" class="form-label">السعر لكل قدم *</label>
                            <input type="number" step="0.01" class="form-control @error('price_per_foot') is-invalid @enderror" 
                                   id="price_per_foot" name="price_per_foot" value="{{ old('price_per_foot', $property->price_per_foot) }}" min="0" required>
                            @error('price_per_foot')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price_status" class="form-label">حالة السعر *</label>
                            <select class="form-select @error('price_status') is-invalid @enderror" 
                                    id="price_status" name="price_status" required>
                                <option value="">اختر حالة السعر</option>
                                <option value="قابل للتفاوض" {{ old('price_status', $property->price_status) == 'قابل للتفاوض' ? 'selected' : '' }}>قابل للتفاوض</option>
                                <option value="نهائي" {{ old('price_status', $property->price_status) == 'نهائي' ? 'selected' : '' }}>نهائي</option>
                            </select>
                            @error('price_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="annual_return" class="form-label">العائد السنوي (%)</label>
                            <input type="number" step="0.01" class="form-control @error('annual_return') is-invalid @enderror" 
                                   id="annual_return" name="annual_return" value="{{ old('annual_return', $property->annual_return) }}" min="0" max="100">
                            @error('annual_return')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">الحالة *</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="متوفر" {{ old('status', $property->status) == 'متوفر' ? 'selected' : '' }}>متوفر</option>
                                <option value="غير متوفر" {{ old('status', $property->status) == 'غير متوفر' ? 'selected' : '' }}>غير متوفر</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="is_ad" name="is_ad" value="1" 
                                       {{ old('is_ad', $property->is_ad) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_ad">
                                    هل هو إعلان؟
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">الوصف *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required>{{ old('description', $property->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="partners" class="form-label">المسوقين</label>
                        <select class="form-select @error('partners') is-invalid @enderror" 
                                id="partners" name="partners[]" multiple>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->id }}" 
                                        {{ in_array($partner->id, old('partners', $property->partners->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $partner->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">يمكنك اختيار أكثر من طرف بالضغط على Ctrl</div>
                        @error('partners')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">إضافة صور جديدة (حد أقصى 6 صور إجمالية)</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror" 
                               id="images" name="images[]" multiple accept=".jpg,.jpeg,.png">
                        <div class="form-text">يمكنك رفع صور إضافية. الصيغ المدعومة: JPG, JPEG, PNG - حد أقصى 10MB لكل صورة</div>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- عرض الصور الحالية -->
                    @if($property->images->count() > 0)
                    <div class="mb-3">
                        <label class="form-label">الصور الحالية</label>
                        <div class="row">
                            @foreach($property->images as $image)
                            <div class="col-md-3 mb-2">
                                <div class="position-relative">
                                    <img src="{{ Storage::url($image->image_path) }}" 
                                         class="img-fluid rounded" 
                                         style="height: 100px; width: 100%; object-fit: cover;">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                            onclick="deleteImage({{ $image->id }})"
                                            title="حذف الصورة">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> تحديث العقار
                        </button>
                        <a href="{{ route('properties.show', $property) }}" class="btn btn-info">عرض التفاصيل</a>
                        <a href="{{ route('properties.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">معلومات العقار</h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>تم الإنشاء بواسطة:</strong>
                    <span class="text-muted">{{ $property->creator->name }}</span>
                </div>
                <div class="mb-2">
                    <strong>تاريخ الإنشاء:</strong>
                    <span class="text-muted">{{ $property->created_at->format('Y-m-d H:i') }}</span>
                </div>
                <div class="mb-2">
                    <strong>آخر تحديث:</strong>
                    <span class="text-muted">{{ $property->updated_at->format('Y-m-d H:i') }}</span>
                </div>
                <div class="mb-2">
                    <strong>عدد الصور:</strong>
                    <span class="badge bg-info">{{ $property->images->count() }} صور</span>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle"></i>
                    تذكر: سيتم حساب السعر لكل قدم تلقائياً عند تغيير السعر أو المساحة
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// حساب السعر لكل قدم تلقائياً
document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.getElementById('price');
    const areaInput = document.getElementById('area');
    const pricePerFootInput = document.getElementById('price_per_foot');
    
    function calculatePricePerFoot() {
        const price = parseFloat(priceInput.value) || 0;
        const area = parseFloat(areaInput.value) || 0;
        
        if (price > 0 && area > 0) {
            const pricePerFoot = (price / area).toFixed(2);
            pricePerFootInput.value = pricePerFoot;
        }
    }
    
    priceInput.addEventListener('input', calculatePricePerFoot);
    areaInput.addEventListener('input', calculatePricePerFoot);
});

// حذف الصورة
function deleteImage(imageId) {
    if (confirm('هل أنت متأكد من حذف هذه الصورة؟')) {
        fetch(`/property-images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء حذف الصورة');
        });
    }
}
</script>
@endpush
@endsection