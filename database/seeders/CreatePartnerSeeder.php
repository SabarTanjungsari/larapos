<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class CreatePartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $partners = [
            [
                'email' => 'customer@gmail.com',
                'name' => 'Standart Customer',
                'iscustomer' => true,
                'address' => 'Customer Address',
                'phone' => '0889-990-990'
            ],
            [
                'email' => 'vendor@gmail.com',
                'name' => 'Standart Vendor',
                'isvendor' => true,
                'address' => 'Vendor Address',
                'phone' => '0889-991-991'
            ],
        ];

        foreach ($partners as $partner) {
            Partner::create($partner);
        }
    }
}
