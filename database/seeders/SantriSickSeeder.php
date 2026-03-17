<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SantriSickSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('santri_sicks')->insert([
            [
                'santri_id' => '1',
                'date_sick' => '2026-02-13',
                'date_recovered' => '2026-02-15',
                'diagnose' => 'Sakit Magh',
                'description' => 'Sakit Magh tingkat menengah',
                'inputed_by' => '3',
            ],
            [
                'santri_id' => '1',
                'date_sick' => '2026-02-16',
                'date_recovered' => '2026-02-17',
                'diagnose' => 'Sakit Magh',
                'description' => 'Sakit Magh tingkat menengah',
                'inputed_by' => '3',
            ],
            [
                'santri_id' => '2',
                'date_sick' => '2026-02-16',
                'date_recovered' => '2026-02-17',
                'diagnose' => 'Migran',
                'description' => 'Sakit migran tingkat menengah',
                'inputed_by' => '3',
            ],
            [
                'santri_id' => '3',
                'date_sick' => '2026-02-16',
                'date_recovered' => '2026-02-17',
                'diagnose' => 'Migran',
                'description' => 'Sakit migran tingkat menengah',
                'inputed_by' => '3',
            ],
        ]);
    }
}
