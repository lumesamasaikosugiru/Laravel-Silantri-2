<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViolationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('violations')->insert([
            [
                'code' => 'B001-20',
                'name' => 'Kabur dari pondok',
                'category' => 'berat',
                'point' => '20',
            ],
            [
                'code' => 'B002-20',
                'name' => 'Merokok',
                'category' => 'berat',
                'point' => '20',
            ],
            [
                'code' => 'B003-50',
                'name' => 'Mencuri',
                'category' => 'berat',
                'point' => '50',
            ],
            [
                'code' => 'S001-10',
                'name' => 'Terlambat datang ke Pondok',
                'category' => 'sedang',
                'point' => '10',
            ],
            [
                'code' => 'S002-10',
                'name' => 'Bergaul dengan lawan jenis di luar batas',
                'category' => 'sedang',
                'point' => '10',
            ],
            [
                'code' => 'R001-2',
                'name' => 'Kesiangan Bangun Pagi',
                'category' => 'ringan',
                'point' => '2',
            ],
            [
                'code' => 'R002-2',
                'name' => 'Berisik di jam malam',
                'category' => 'ringan',
                'point' => '2',
            ],
        ]);
    }
}
