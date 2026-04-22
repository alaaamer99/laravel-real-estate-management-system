<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PropertyType;
use App\Models\Partner;
use App\Models\User;

class BasicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $propertyTypes = [
            'أرض',
            'استوديو',
            'برج',
            'بناية',
            'بيت',
            'تاون هاوس',
            'حوطة',
            'دوبليكس',
            'سكن عمال',
            'شبرات صناعية',
            'شقة',
            'صالون',
            'صناعية',
            'فيلا',
            'كافتيريا',
            'مستودع',
            'محل',
            'مزرعة',
            'مدرسة',
            'مستشفى',
            'محطة بترول',
            'مركز عناية بالسيارات',
            'مخبز',
            'مطعم',
            'معرض',
            'محطة بترول',
            'مكتب',
            'موقف سيارات',
            'مول تجاري'
        ];

        foreach ($propertyTypes as $type) {
            PropertyType::create(['name' => $type]);
        }

        $partners = [

            'فاطمة',
            'محمد شريف',
            'محمد سلامة',
        ];

        foreach ($partners as $partner) {
            Partner::create(['name' => $partner]);
        }

        $admin = User::create([
            'name' => 'المدير',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password123'),
        ]);

        $admin->assignRole('مدير');
    }
}
