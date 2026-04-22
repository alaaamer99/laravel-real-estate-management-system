<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alert;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // إنشاء تنبيهات تجريبية
        Alert::create([
            'title' => 'مرحباً بنظام التنبيهات الجديد',
            'message' => 'تم إطلاق نظام التنبيهات المتطور! يمكنك الآن متابعة جميع الأنشطة المهمة في النظام بسهولة',
            'level' => 'success',
            'category' => 'system'
        ]);

        Alert::create([
            'title' => 'عقارات تحتاج مسوقين',
            'message' => 'يوجد عقارات في النظام بدون مسوقين مخصصين لها. يرجى مراجعة تقرير جودة البيانات',
            'level' => 'warning',
            'category' => 'data_quality'
        ]);

        Alert::create([
            'title' => 'تنبيه حرج - بيانات ناقصة',
            'message' => 'تم العثور على عقارات بها بيانات أساسية ناقصة (سعر، مساحة، وصف). يحتاج إجراء عاجل',
            'level' => 'danger',
            'category' => 'data_quality'
        ]);

        Alert::create([
            'title' => 'شريك متميز',
            'message' => 'تهانينا! أحد الشركاء حقق إنجاز رائع هذا الشهر بإضافة عدد كبير من العقارات',
            'level' => 'success',
            'category' => 'partner_performance'
        ]);

        Alert::create([
            'title' => 'نشاط إيجابي في النظام',
            'message' => 'تم إضافة عقارات جديدة خلال الـ 24 ساعة الماضية. النظام يعمل بنشاط جيد',
            'level' => 'info',
            'category' => 'system'
        ]);

        Alert::create([
            'title' => 'شركاء يحتاجون متابعة',
            'message' => 'هناك بعض الشركاء لم يقوموا بإضافة عقارات خلال الفترة الأخيرة. قد يحتاجون للمتابعة',
            'level' => 'warning',
            'category' => 'partner_performance'
        ]);
    }
}
