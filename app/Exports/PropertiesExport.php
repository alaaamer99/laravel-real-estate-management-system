<?php

namespace App\Exports;

use App\Models\Property;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PropertiesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request = null)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Property::with(['propertyType', 'creator', 'partners']);
        
        // إذا لم توجد فلاتر، إرجاع جميع العقارات
        if (!$this->request) {
            return $query->get();
        }
        
        // تطبيق نفس فلاتر صفحة الفهرس
        
        // البحث النصي
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference_number', '=', $search)
                  ->orWhere('reference_number', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // فلتر نوع العقار
        if ($this->request->filled('type_filter')) {
            $query->where('property_type_id', $this->request->type_filter);
        }
        
        // فلتر الحالة
        if ($this->request->filled('status_filter')) {
            if ($this->request->status_filter === 'متوفر') {
                $query->where('status', 'متوفر');
            } elseif ($this->request->status_filter === 'غير_متوفر') {
                $query->where('status', '!=', 'متوفر');
            }
        }
        
        // فلتر المسوقين
        if ($this->request->filled('partner_filter')) {
            $query->whereHas('partners', function($q) {
                $q->where('partners.id', $this->request->partner_filter);
            });
        }
        
        // الترتيب
        $sortBy = $this->request->get('sort_by', 'reference_newest');
        switch ($sortBy) {
            case 'reference_newest':
                $query->orderByRaw('CAST(reference_number AS UNSIGNED) DESC');
                break;
            case 'reference_oldest':
                $query->orderByRaw('CAST(reference_number AS UNSIGNED) ASC');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'area_desc':
                $query->orderBy('area', 'desc');
                break;
            case 'area_asc':
                $query->orderBy('area', 'asc');
                break;
            default:
                $query->orderByRaw('CAST(reference_number AS UNSIGNED) DESC');
                break;
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'رقم المرجع',
            'التاريخ',
            'نوع العقار',
            'نوع الإعلان',
            'العنوان',
            'المساحة (قدم)',
            'السعر (درهم)',
            'السعر لكل قدم',
            'حالة السعر',
            'العائد السنوي (%)',
            'عدد الوحدات',
            'الوصف',
            'المسوقين',
            'إعلان؟',
            'الحالة',
            'تم الإنشاء بواسطة',
            'تاريخ الإنشاء'
        ];
    }

    public function map($property): array
    {
        return [
            $property->reference_number,
            $property->date->format('Y-m-d'),
            $property->propertyType->name,
            $property->ad_side,
            $property->address,
            $property->area,
            $property->price,
            $property->price_per_foot,
            $property->price_status,
            $property->annual_return ?? '',
            $property->units_number,
            $property->description,
            $property->partners->pluck('name')->join(', '),
            $property->is_ad ? 'نعم' : 'لا',
            $property->status,
            $property->creator->name,
            $property->created_at->format('Y-m-d H:i:s')
        ];
    }
}
