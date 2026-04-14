<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('santris')->insert([
            [
                'nisn' => '1234567888',
                'name' => 'Ahmad Sumbul',
                'gender' => 'l',
                'date_birth' => '2000-02-18',
                'address_street' => 'Jl. Cilegon',
                'address_district' => 'Ciwandan',
                'address_city' => 'Kota Cilegon',
                'classroom_id' => '1',
                'status' => 'active',
            ],
            [
                'nisn' => '1234567788',
                'name' => 'Ilham Kashimiri',
                'gender' => 'l',
                'date_birth' => '2000-02-18',
                'address_street' => 'Jl. Pandean',
                'address_district' => 'Kramatwatu',
                'address_city' => 'Kab. Serang',
                'classroom_id' => '1',
                'status' => 'active',
            ],
            [
                'nisn' => '1234567778',
                'name' => 'Dita Karawhita',
                'gender' => 'p',
                'date_birth' => '2000-05-18',
                'address_street' => 'Jl. Waringin Kurung',
                'address_district' => 'Kramatwatu',
                'address_city' => 'Kab. Serang',
                'classroom_id' => '1',
                'status' => 'active',
            ],
            [
                'nisn' => '1234567777',
                'name' => 'Ahmad Sahroni',
                'gender' => 'l',
                'date_birth' => '2003-02-18',
                'address_street' => 'Jl. Cilegon',
                'address_district' => 'Ciwandan',
                'address_city' => 'Kota Cilegon',
                'classroom_id' => '2',
                'status' => 'active',
            ],
            [
                'nisn' => '123456666',
                'name' => 'Khalid Sarawhita',
                'gender' => 'l',
                'date_birth' => '2000-02-18',
                'address_street' => 'Jl. Cilegon',
                'address_district' => 'Ciwandan',
                'address_city' => 'Kota Cilegon',
                'classroom_id' => '1',
                'status' => 'active',
            ],
        ]);
    }
}
