<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('partners.manage')) {
            abort(403);
        }
        
        $partners = Partner::withCount('properties')->paginate(50);
        return view('partners.index', compact('partners'));
    }

    public function create()
    {
        if (!auth()->user()->can('partners.manage')) {
            abort(403);
        }
        
        return view('partners.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('partners.manage')) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|unique:partners,name'
        ]);

        Partner::create($request->only('name'));
        
        return redirect()->route('partners.index')->with('success', 'تم إضافة الطرف بنجاح');
    }

    public function edit(Partner $partner)
    {
        if (!auth()->user()->can('partners.manage')) {
            abort(403);
        }
        
        return view('partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        if (!auth()->user()->can('partners.manage')) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|unique:partners,name,' . $partner->id
        ]);

        $partner->update($request->only('name'));
        
        return redirect()->route('partners.index')->with('success', 'تم تحديث الطرف بنجاح');
    }

    public function destroy(Partner $partner)
    {
        if (!auth()->user()->can('partners.manage')) {
            abort(403);
        }
        
        if ($partner->properties()->count() > 0) {
            return redirect()->route('partners.index')->with('error', 'لا يمكن حذف الطرف لوجود عقارات مرتبطة به');
        }
        
        $partner->delete();
        
        return redirect()->route('partners.index')->with('success', 'تم حذف الطرف بنجاح');
    }
}
