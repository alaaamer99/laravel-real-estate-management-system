<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Partner;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // قراءة ملف JSON
        $jsonPath = database_path('seeders/properties_data.json');

        if (!File::exists($jsonPath)) {
            $this->command->error('ملف properties_data.json غير موجود في مجلد seeders');
            return;
        }

        $jsonContent = File::get($jsonPath);
        $data = json_decode($jsonContent, true);

        if (!$data || !isset($data['properties'])) {
            $this->command->error('خطأ في قراءة بيانات العقارات من ملف JSON');
            return;
        }
        $creator = User::first();

        if (!$creator) {
            $this->command->error('لا يوجد مستخدمين في قاعدة البيانات. يرجى تشغيل BasicDataSeeder أولاً');
            return;
        }

        $this->command->info('بدء إضافة العقارات...');

        foreach ($data['properties'] as $propertyData) {
            try {
                $propertyType = PropertyType::where('name', $propertyData['property_type'])->first();

                if (!$propertyType) {
                    $this->command->warn("نوع العقار '{$propertyData['property_type']}' غير موجود. سيتم تخطي العقار {$propertyData['reference_number']}");
                    continue;
                }

                $partnersData = [];
                if (!empty($propertyData['partners'])) {
                    if (is_string($propertyData['partners'])) {
                        $partnersData = array_map('trim', explode(',', $propertyData['partners']));
                    } else if (is_array($propertyData['partners'])) {
                        $partnersData = $propertyData['partners'];
                    }
                }

                $partnersCount = count($partnersData);

                $area = is_numeric($propertyData['area']) ? (float)$propertyData['area'] : 0;
                $price = is_numeric($propertyData['price']) ? (float)$propertyData['price'] : 0;
                $annualReturn = is_numeric($propertyData['annual_return']) ? (float)$propertyData['annual_return'] : 0;
                $unitsNumber = isset($propertyData['units_number']) && is_numeric($propertyData['units_number']) ? (int)$propertyData['units_number'] : 1;
                $isAd = strtoupper($propertyData['is_ad']) === 'TRUE' ? 1 : 0;

                $property = Property::create([
                    'reference_number' => $propertyData['reference_number'],
                    'date' => Carbon::parse($propertyData['date']),
                    'ad_side' => $propertyData['ad_side'],
                    'address' => $propertyData['address'],
                    'area' => $area,
                    'price' => $price,
                    'description' => $propertyData['description '] ?? $propertyData['description'] ?? '', // ملاحظة وجود مسافة في بعض الحقول
                    'status' => $propertyData['status'],
                    'is_ad' => $isAd,
                    'partners_count' => $partnersCount,
                    'units_number' => $unitsNumber,
                    'price_status' => $propertyData['price_status'] ?? 'نهائي',
                    'annual_return' => $annualReturn,
                    'price_per_foot' => $area > 0 ? round($price / $area, 2) : 0,
                    'property_type_id' => $propertyType->id,
                    'created_by' => $creator->id,
                ]);

                if (!empty($partnersData)) {
                    $partnerIds = [];

                    foreach ($partnersData as $partnerName) {
                        $partner = Partner::where('name', $partnerName)->first();

                        if ($partner) {
                            $partnerIds[] = $partner->id;
                        } else {
                            $this->command->warn("الطرف '{$partnerName}' غير موجود في قاعدة البيانات");
                        }
                    }

                    if (!empty($partnerIds)) {
                        $property->partners()->attach($partnerIds);
                    }
                }

                $this->command->info("تم إضافة العقار: {$property->reference_number}");

            } catch (\Exception $e) {
                $this->command->error("خطأ في إضافة العقار {$propertyData['reference_number']}: " . $e->getMessage());
            }
        }

        $totalProperties = Property::count();
        $this->command->info("تم الانتهاء من إضافة العقارات. إجمالي العقارات: {$totalProperties}");
    }
}
