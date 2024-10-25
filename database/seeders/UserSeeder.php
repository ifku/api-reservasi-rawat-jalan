<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_users')->insert([
            'id_user' => "e15daef5-0dbf-4325-8ad7-b61fde69b8c4",
            'user_name' => 'admin',
            'user_fullname' => 'Admin',
            'user_nik' => '1234567890123456',
            'user_email' => 'admin@gmail.com',
            'user_phone' => '081234567890',
            'user_address' => 'Jl. Admin No. 1',
            'user_gender' => 'MALE',
            'user_date_of_birth' => '1990-01-01',
            'is_complete_profile' => true,
            'role_id' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
