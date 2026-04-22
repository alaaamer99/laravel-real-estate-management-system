<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyType;

class PropertyTypeController extends Controller
{

    public function index()
    {
        if (!auth()->user()->can('property_types.manage')) {
            abort(403);
        }
        
        $propertyTypes = PropertyType::withCount('properties')->paginate(10);
        return view('property-types.index', compact('propertyTypes'));
    }

    public function create()
    {
        if (!auth()->user()->can('property_types.manage')) {
            abort(403);
        }
        
        return view('property-types.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('property_types.manage')) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|unique:property_types,name'
        ]);

        PropertyType::create($request->only('name'));
        
        return redirect()->route('property-types.index')->with('success', 'تم إضافة نوع العقار بنجاح');
    }

    public function edit(PropertyType $propertyType)
    {
        if (!auth()->user()->can('property_types.manage')) {
            abort(403);
        }
        
        return view('property-types.edit', compact('propertyType'));
    }

    public function update(Request $request, PropertyType $propertyType)
    {
        if (!auth()->user()->can('property_types.manage')) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|unique:property_types,name,' . $propertyType->id
        ]);

        $propertyType->update($request->only('name'));
        
        return redirect()->route('property-types.index')->with('success', 'تم تحديث نوع العقار بنجاح');
    }

    public function destroy(PropertyType $propertyType)
    {
        if (!auth()->user()->can('property_types.manage')) {
            abort(403);
        }
        
        if ($propertyType->properties()->count() > 0) {
            return redirect()->route('property-types.index')->with('error', 'لا يمكن حذف نوع العقار لوجود عقارات مرتبطة به');
        }
        
        $propertyType->delete();
        
        return redirect()->route('property-types.index')->with('success', 'تم حذف نوع العقار بنجاح');
    }
}
