<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        $roles = [
            [
                'name' => 'admin',
            ],
            [
                'name' => 'cashier',
            ]
        ];
        foreach ($roles as $key => $role) {
            Role::create($role);
        }

        /**
         * Asign Role to User
         */

        $administrator = Role::findByName('admin');
        $admin = User::findOrFail(1);
        $admin->assignRole($administrator);

        $cashier = Role::findByName('cashier');
        $user = User::findOrFail(2);
        $user->assignRole($cashier);
    }
}
