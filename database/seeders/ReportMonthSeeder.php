<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportMonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('report_months')->insert([
            [
                'month' => '2',
                'year' => '2026',
                'created_by' => '3',
                'status' => 'menunggu',
            ],
            [
                'month' => '3',
                'year' => '2026',
                'created_by' => '3',
                'status' => 'menunggu',
            ],
            [
                'month' => '4',
                'year' => '2026',
                'created_by' => '3',
                'status' => 'menunggu',
            ],
            [
                'month' => '5',
                'year' => '2026',
                'created_by' => '3',
                'status' => 'menunggu',
            ],
        ]);
    }
}
