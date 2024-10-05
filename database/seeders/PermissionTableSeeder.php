<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $permissions = [
        //     'role-list',
        //     'role-create',
        //     'role-edit',
        //     'role-delete',
        //     'user-list',
        //     'user-create',
        //     'user-edit',
        //     'user-delete'
        // ];
        $permissions = [
            'roles-management',
            'users-management',
            'areas-management',
            'services-management',
            'organization-profile-management',
            'clients-management',
            'representatives-management',
            'representatives-orders-management',
            'representatives-fees-collection-management',
            'orders-management',
            'reports-management',
            'orders-importCSV-management',
            'general-settings-management',
            'representatives-payment-management',
        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
