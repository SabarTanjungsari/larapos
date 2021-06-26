<?php

namespace Database\Seeders;

use CreatePartnersTable;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(CreateProductSeeder::class);
        $this->call(CreatePartnerSeeder::class);
        $this->call(CreateSystemSeeder::class);
    }
}
