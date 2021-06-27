<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-list',
            'user-show',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-show',
            'role-create',
            'role-edit',
            'role-delete',
            'category-list',
            'category-show',
            'category-create',
            'category-edit',
            'category-delete',
            'product-list',
            'product-show',
            'product-create',
            'product-edit',
            'product-delete',
            'partner-list',
            'partner-show',
            'partner-create',
            'partner-edit',
            'partner-delete',
            'cart-list',
            'sales-list',
            'transaction-list',
            'transaction-show',
            'transaction-create',
            'transaction-edit',
            'transaction-delete',
            'system-list',
            'system-edit'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
