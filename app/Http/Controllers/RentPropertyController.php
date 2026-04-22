<?php

namespace App\Http\Controllers;

use App\Models\RentProperty;
use App\Models\PropertyType;
use App\Models\RentPartner;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RentPropertyController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = RentProperty::with(['propertyType', 'rentPartner']);

        // فلتر البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('property_number', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // فلتر نوع العقار
        if ($request->filled('type_filter')) {
            $query->where('property_type_id', $request->type_filter);
        }

        // فلتر المسوق
        if ($request->filled('partner_filter')) {
            $query->where('rent_partner_id', $request->partner_filter);
        }

        // فلتر الحالة
        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }

        // الترتيب
        $sortBy = $request->get('sort_by', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'area_asc':
                $query->orderBy('area', 'asc');
                break;
            case 'area_desc':
                $query->orderBy('area', 'desc');
                break;
            default:
                $query->latest();
        }

        $rentProperties = $query->paginate(15);

        return view('rent-properties.index', compact('rentProperties'));
    }

    public function create()
    {
        $propertyTypes = PropertyType::all();
        $rentPartners = RentPartner::where('is_active', true)->get();

        return view('rent-properties.create', compact('propertyTypes', 'rentPartners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_number' => 'required|integer|unique:rent_properties',
            'date' => 'required|date',
            'property_type_id' => 'required|exists:property_types,id',
            'rent_partner_id' => 'nullable|exists:rent_partners,id',
            'address' => 'required|string|max:255',
            'rooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'area' => 'required|numeric|min:0',
            'rental_type' => 'required|in:monthly,quarterly,semi_annual,annual',
            'price' => 'required|numeric|min:0',
            'payment_installments' => 'required|integer|min:1|max:12',
            'status' => 'required|in:available,rented',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            $uploadedImages = $request->file('images');
            $images = $this->handleImageUpload($uploadedImages, $request->property_number);
        }

        RentProperty::create([
            'property_number' => $request->property_number,
            'date' => $request->date,
            'property_type_id' => $request->property_type_id,
            'rent_partner_id' => $request->rent_partner_id,
            'address' => $request->address,
            'rooms' => $request->rooms,
            'bathrooms' => $request->bathrooms,
            'description' => $request->description,
            'area' => $request->area,
            'rental_type' => $request->rental_type,
            'price' => $request->price,
            'payment_installments' => $request->payment_installments,
            'status' => $request->status,
            'images' => $images
        ]);

        return redirect()->route('rent-properties.index')->with('success', 'تم إضافة العقار بنجاح!');
    }

    public function show(RentProperty $rentProperty)
    {
        $rentProperty->load(['propertyType', 'rentPartner']);
        return view('rent-properties.show', compact('rentProperty'));
    }

    public function edit(RentProperty $rentProperty)
    {
        $propertyTypes = PropertyType::all();
        $rentPartners = RentPartner::where('is_active', true)->get();

        return view('rent-properties.edit', compact('rentProperty', 'propertyTypes', 'rentPartners'));
    }

    public function update(Request $request, RentProperty $rentProperty)
    {
        $request->validate([
            'property_number' => 'required|integer|unique:rent_properties,property_number,' . $rentProperty->id,
            'date' => 'required|date',
            'property_type_id' => 'required|exists:property_types,id',
            'rent_partner_id' => 'nullable|exists:rent_partners,id',
            'address' => 'required|string|max:255',
            'rooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'area' => 'required|numeric|min:0',
            'rental_type' => 'required|in:monthly,quarterly,semi_annual,annual',
            'price' => 'required|numeric|min:0',
            'payment_installments' => 'required|integer|min:1|max:12',
            'status' => 'required|in:available,rented',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $images = $rentProperty->images ?? [];

        // حذف الصور المطلوب حذفها
        if ($request->has('removed_images') && !empty($request->removed_images)) {
            $removedImages = json_decode($request->removed_images, true);
            if ($removedImages) {
                $this->deleteSpecificImages($rentProperty->property_number, $removedImages);
                $images = array_diff($images, $removedImages);
                $images = array_values($images); // إعادة ترقيم المصفوفة
            }
        }

        // رفع الصور الجديدة
        if ($request->hasFile('images')) {
            $uploadedImages = $request->file('images');

            // التحقق من العدد الإجمالي
            $totalImages = count($images) + count($uploadedImages);
            if ($totalImages > 6) {
                return back()->withErrors(['images' => 'العدد الإجمالي للصور لا يمكن أن يتجاوز 6 صور.']);
            }

            $newImages = $this->handleImageUpload($uploadedImages, $request->property_number);
            $images = array_merge($images, $newImages);
        }

        $rentProperty->update([
            'property_number' => $request->property_number,
            'date' => $request->date,
            'property_type_id' => $request->property_type_id,
            'rent_partner_id' => $request->rent_partner_id,
            'address' => $request->address,
            'rooms' => $request->rooms,
            'bathrooms' => $request->bathrooms,
            'description' => $request->description,
            'area' => $request->area,
            'rental_type' => $request->rental_type,
            'price' => $request->price,
            'payment_installments' => $request->payment_installments,
            'status' => $request->status,
            'images' => $images
        ]);

        return redirect()->route('rent-properties.index')->with('success', 'تم تحديث العقار بنجاح!');
    }

    public function destroy(RentProperty $rentProperty)
    {
        // حذف مجلد الصور بالكامل
        $this->deletePropertyImages($rentProperty->property_number);

        $rentProperty->delete();

        return redirect()->route('rent-properties.index')->with('success', 'تم حذف العقار بنجاح!');
    }

}
