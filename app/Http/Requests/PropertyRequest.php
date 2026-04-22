<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $propertyId = $this->route('property') ? $this->route('property')->id : null;
        
        return [
            'reference_number' => 'required|string|unique:properties,reference_number,' . $propertyId,
            'date' => 'required|date',
            'ad_side' => 'required|in:مباشر,طرف',
            'partners_count' => 'required|integer|min:1',
            'address' => 'required|string',
            'area' => 'required|numeric|min:0',
            'units_number' => 'required|integer|min:1',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'price_status' => 'required|in:قابل للتفاوض,نهائي',
            'annual_return' => 'nullable|numeric|min:0|max:100',
            'price_per_foot' => 'required|numeric|min:0',
            'is_ad' => 'boolean',
            'status' => 'required|in:متوفر,غير متوفر',
            'property_type_id' => 'required|exists:property_types,id',
            'partners' => 'array',
            'partners.*' => 'exists:partners,id',
            'images' => 'array|max:6',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:10240' // 10MB max per image
        ];
    }

    public function messages(): array
    {
        return [
            'reference_number.required' => 'رقم المرجع مطلوب',
            'reference_number.unique' => 'رقم المرجع موجود مسبقاً',
            'date.required' => 'التاريخ مطلوب',
            'address.required' => 'العنوان مطلوب',
            'area.required' => 'المساحة مطلوبة',
            'price.required' => 'السعر مطلوب',
            'property_type_id.required' => 'نوع العقار مطلوب',
            'images.max' => 'لا يمكن رفع أكثر من 6 صور',
            'images.*.image' => 'يجب أن يكون الملف صورة',
            'images.*.mimes' => 'الصيغ المدعومة هي JPG و JPEG و PNG فقط',
            'images.*.max' => 'حجم الصورة يجب أن يكون أقل من 10 ميجابايت'
        ];
    }
}
