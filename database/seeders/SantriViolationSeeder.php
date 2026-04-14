<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SantriViolationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('violation_details')->insert([
            [
                'santri_id' => '1',
                'violation_id' => '6',
                'date' => '2026-04-13',
                'description' => 'begadang Tadarusan',
                'inputed_by' => '3',
            ],
            [
                'santri_id' => '1',
                'violation_id' => '4',
                'date' => '2026-04-13',
                'description' => 'kabur gara-gara dibuli teman',
                'inputed_by' => '3',
            ],
            [
                'santri_id' => '2',
                'violation_id' => '6',
                'date' => '2026-04-13',
                'description' => 'begadang Tadarusan',
                'inputed_by' => '3',
            ],
        ]);
    }
}
