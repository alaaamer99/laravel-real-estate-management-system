<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Partner;
use App\Models\User;
use App\Models\RentProperty;
use App\Models\RentPartner;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // جلب الإحصائيات - العقارات العادية
        $totalProperties = Property::count();
        $availableProperties = Property::where('status', 'متوفر')->count();
        $propertyTypes = PropertyType::count();
        $partners = Partner::count();
        $usersCount = User::count();

        // إحصائيات العقارات المؤجرة
        $totalRentProperties = RentProperty::count();
        $availableRentProperties = RentProperty::where('status', 'available')->count();
        $rentedProperties = RentProperty::where('status', 'rented')->count();
        $rentPartners = RentPartner::count();

        // إحصائيات مالية - العقارات العادية
        $totalValue = Property::sum('price');
        $avgPrice = Property::avg('price');
        $totalArea = Property::sum('area');

        // إحصائيات مالية - العقارات المؤجرة
        $totalRentValue = RentProperty::sum('price');
        $avgRentPrice = RentProperty::avg('price');
        $totalRentArea = RentProperty::sum('area');

        // آخر العقارات المضافة - العادية
        $recentProperties = Property::with('propertyType')
            ->latest()
            ->take(5)
            ->get();

        // آخر العقارات المؤجرة المضافة
        $recentRentProperties = RentProperty::with(['propertyType', 'rentPartner'])
            ->latest()
            ->take(5)
            ->get();

        // أكثر أنواع العقارات العادية
        $topPropertyTypes = PropertyType::withCount('properties')
            ->orderBy('properties_count', 'desc')
            ->take(5)
            ->get();

        // أكثر أنواع العقارات المؤجرة
        $topRentPropertyTypes = PropertyType::withCount('rentProperties')
            ->orderBy('rent_properties_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProperties',
            'availableProperties',
            'propertyTypes',
            'partners',
            'usersCount',
            'totalValue',
            'avgPrice',
            'totalArea',
            'recentProperties',
            'topPropertyTypes',
            'totalRentProperties',
            'availableRentProperties',
            'rentedProperties',
            'rentPartners',
            'totalRentValue',
            'avgRentPrice',
            'totalRentArea',
            'recentRentProperties',
            'topRentPropertyTypes'
        ));
    }
}
