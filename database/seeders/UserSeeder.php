<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'Super Admin',
                'email' => 'silantri@superadmin.dev',
                'password' => bcrypt('123123123'),
                'role' => 'superadmin',
            ],
            [
                'name' => 'Administrasi',
                'email' => 'silantri@admin.dev',
                'password' => bcrypt('123123123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Waritsul Ulum',
                'email' => 'silantri@staff.dev',
                'password' => bcrypt('123123123'),
                'role' => 'staff',
            ],
            [
                'name' => 'Kepala Pengasuhan',
                'email' => 'silantri@kepala.dev',
                'password' => bcrypt('123123123'),
                'role' => 'kepala_pengasuhan',
            ],
        ];
        foreach ($user as $data) {

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => $data['password'],
                ]
            );

            if (!$user->hasRole($data['role'])) {

                $user->assignRole($data['role']);
            }
        }
    }
}
