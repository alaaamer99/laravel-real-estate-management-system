<?php

namespace App\Http\Controllers;

use App\Models\RentPartner;
use Illuminate\Http\Request;

class RentPartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $rentPartners = RentPartner::withCount('rentProperties')
            ->latest()
            ->paginate(15);

        return view('rent-partners.index', compact('rentPartners'));
    }

    public function create()
    {
        return view('rent-partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        RentPartner::create($request->all());

        return redirect()->route('rent-partners.index')->with('success', 'تم إضافة المسوق بنجاح!');
    }

    public function show(RentPartner $rentPartner)
    {
        $rentPartner->load('rentProperties.propertyType');
        return view('rent-partners.show', compact('rentPartner'));
    }

    public function edit(RentPartner $rentPartner)
    {
        return view('rent-partners.edit', compact('rentPartner'));
    }

    public function update(Request $request, RentPartner $rentPartner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $rentPartner->update($request->all());

        return redirect()->route('rent-partners.index')->with('success', 'تم تحديث المسوق بنجاح!');
    }

    public function destroy(RentPartner $rentPartner)
    {
        if ($rentPartner->rentProperties()->count() > 0) {
            return back()->withErrors(['error' => 'لا يمكن حذف المسوق لوجود عقارات مرتبطة به.']);
        }

        $rentPartner->delete();

        return redirect()->route('rent-partners.index')->with('success', 'تم حذف المسوق بنجاح!');
    }
}
