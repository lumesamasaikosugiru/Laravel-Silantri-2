<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SantriPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('santri_permissions')->insert([
            [
                'santri_id' => '1',
                'type' => 'keluar',
                'ticket_permission' => 'IZIN-' . Carbon::now()->year . '-' . Str::upper(Str::random(8)),
                'date_started' => '2026-03-13',
                'date_ended' => '2026-03-13',
                'reason' => 'Beli peralatan sholat',
                'submitted_by' => 'staf',
                'status' => 'menunggu',
                'inputed_by' => '3',
            ],
            // [
            //     'santri_id' => '1',
            //     'type' => 'pulang',
            //     'ticket_permission' => 'IZIN-' . Carbon::now()->year . '-' . Str::upper(Str::random(8)),
            //     'date_started' => '2026-03-13',
            //     'date_ended' => '2026-03-20',
            //     'reason' => 'Kelurga Berpulang',
            //     'submitted_by' => 'staf',
            //     'status' => 'menunggu',
            //     'inputed_by' => '3',
            // ],
            // [
            //     'santri_id' => '2',
            //     'type' => 'pulang',
            //     'ticket_permission' => 'IZIN-' . Carbon::now()->year . '-' . Str::upper(Str::random(8)),
            //     'date_started' => '2026-03-14',
            //     'date_ended' => '2026-03-14',
            //     'reason' => 'Beli peralatan mandi',
            //     'submitted_by' => 'staf',
            //     'status' => 'menunggu',
            //     'inputed_by' => '3',
            // ],
            // [
            //     'santri_id' => '3',
            //     'type' => 'pulang',
            //     'ticket_permission' => 'IZIN-' . Carbon::now()->year . '-' . Str::upper(Str::random(8)),
            //     'date_started' => '2026-03-14',
            //     'date_ended' => '2026-03-14',
            //     'reason' => 'Beli peralatan mandi',
            //     'submitted_by' => 'staf',
            //     'status' => 'menunggu',
            //     'inputed_by' => '3',
            // ],
        ]);
    }
}
