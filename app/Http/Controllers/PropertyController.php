<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Partner;
use App\Models\PropertyImage;
use App\Http\Requests\PropertyRequest;
use App\Exports\PropertiesExport;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PropertyController extends Controller
{

    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }


    public function index(Request $request)
    {
        if ($request->has('export') && $request->export === 'excel') {
            $hasFilters = $request->filled(['search', 'type_filter', 'status_filter', 'partner_filter', 'sort_by']);
            $fileName = $hasFilters ? 'العقارات_مفلترة_' : 'جميع_العقارات_';
            $fileName .= date('Y-m-d') . '.xlsx';

            return Excel::download(new PropertiesExport($request), $fileName);
        }

        $query = Property::with(['propertyType', 'creator', 'partners']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference_number', '=', $search)
                  ->orWhere('reference_number', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type_filter')) {
            $query->where('property_type_id', $request->type_filter);
        }

        if ($request->filled('status_filter')) {
            if ($request->status_filter === 'متوفر') {
                $query->where('status', 'متوفر');
            } elseif ($request->status_filter === 'غير_متوفر') {
                $query->where('status', '!=', 'متوفر');
            }
        }

        if ($request->filled('partner_filter')) {
            $query->whereHas('partners', function($q) use ($request) {
                $q->where('partners.id', $request->partner_filter);
            });
        }

        $sortBy = $request->get('sort_by', 'reference_newest');
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

        $properties = $query->paginate(50)->withQueryString();
        return view('properties.index', compact('properties'));
    }


    public function create()
    {
        $propertyTypes = PropertyType::all();
        $partners = Partner::all();
        return view('properties.create', compact('propertyTypes', 'partners'));
    }


    public function store(PropertyRequest $request)
    {
        try {
            $data = $request->validated();
            $data['created_by'] = Auth::id();

            $property = Property::create($data);

            // ربط المسوقين
            if ($request->has('partners')) {
                $property->partners()->attach($request->partners);
            }

            // رفع الصور باستخدام ImageUploadService
            if ($request->hasFile('images')) {
                $result = $this->imageUploadService->uploadImages(
                    $request->file('images'),
                    $property->reference_number
                );

                if ($result['success']) {
                    // حفظ مسارات الصور في قاعدة البيانات
                    foreach ($result['images'] as $imagePath) {
                        PropertyImage::create([
                            'property_id' => $property->id,
                            'image_path' => $imagePath
                        ]);
                    }
                } else {
                    return back()->withErrors(['images' => $result['message']])->withInput();
                }
            }

            return redirect()->route('properties.index')->with('success', 'تم إضافة العقار بنجاح');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    public function show(Property $property)
    {
        $property->load(['propertyType', 'creator', 'partners', 'images']);
        return view('properties.show', compact('property'));
    }


    public function edit(Property $property)
    {
        $propertyTypes = PropertyType::all();
        $partners = Partner::all();
        $property->load(['partners', 'images']);
        return view('properties.edit', compact('property', 'propertyTypes', 'partners'));
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        // حذف الصور من التخزين
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // حذف مجلد العقار إذا كان موجوداً
        $folderPath = 'properties/' . $property->reference_number;
        if (Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->deleteDirectory($folderPath);
        }

        $property->delete();

        return redirect()->route('properties.index')->with('success', 'تم حذف العقار بنجاح');
    }

}
