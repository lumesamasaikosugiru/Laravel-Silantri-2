<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classrooms')->insert([
            [
                'name' => 'VII Firdaus',
                'level' => 'mts',
                'description' => Str::random(25),
            ],
            [
                'name' => 'VIII Mawa',
                'level' => 'mts',
                'description' => Str::random(25),
            ],
            [
                'name' => 'IX Darussalam',
                'level' => 'mts',
                'description' => Str::random(25),
            ],
            [
                'name' => 'X Firdaus',
                'level' => 'ma',
                'description' => Str::random(25),
            ],
            [
                'name' => 'XI Mawa',
                'level' => 'ma',
                'description' => Str::random(25),
            ],
            [
                'name' => 'XII Darussalam',
                'level' => 'ma',
                'description' => Str::random(25),
            ],
        ]);
    }
}
