<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Seeder;

class CreateSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system = System::create([
            'name' => 'PT. Lara POS',
            'address' => 'JL. Raya Babelan Kebalen Bekasi Utara Jawa Barat',
            'phone' => '081806159252',
            'email' => 'sabartanjungsari@gmail.com'
        ]);
    }
}
