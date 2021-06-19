<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('secret'),
                'status' => true
            ],
            [
                'name' => 'Cashier',
                'email' => 'cashier@gmail.com',
                'password' => bcrypt('secret'),
                'status' => true
            ]
        ];
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
