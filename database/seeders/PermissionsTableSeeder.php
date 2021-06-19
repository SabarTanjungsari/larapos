<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::truncate();

        $permissions = [
            [
                'name' => 'show products',
            ],
            [
                'name' => 'create products',
            ],
            [
                'name' => 'delete products',
            ],
            [
                'name' => 'show categories',
            ],
            [
                'name' => 'create categories',
            ],
            [
                'name' => 'delete categories',
            ]
        ];

        foreach ($permissions as $key => $permission) {
            Permission::create($permission);
        }

        /**
         * Asign permission to Role
         */

        $role = Role::findByName('admin');
        $permissions = Permission::all();
        $role->syncPermissions($permissions);
    }
}
