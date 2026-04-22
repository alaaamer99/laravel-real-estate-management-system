<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء الصلاحيات
        $permissions = [
            'property.create',
            'property.edit',
            'property.delete',
            'property.view',
            'users.manage',
            'partners.manage',
            'property_types.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // إنشاء الأدوار
        $adminRole = Role::create(['name' => 'مدير']);
        $dataEntryRole = Role::create(['name' => 'مدخل بيانات']);

        // تعيين الصلاحيات للمدير
        $adminRole->givePermissionTo(Permission::all());

        // تعيين الصلاحيات لمدخل البيانات
        $dataEntryRole->givePermissionTo([
            'property.create',
            'property.edit',
            'property.view'
        ]);
    }
}
