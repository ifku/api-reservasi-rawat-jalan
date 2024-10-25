<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_patient')->insert([
            'id_patient' => "0dbdbfc0-c881-44e5-b460-7ee48566bf3a",
            'patient_fullname' => "Admin Patient",
            'patient_nik' => "12345678987654321",
            'patient_date_of_birth' => "1990-01-01",
            'patient_phone' => "081234567890",
            'user_id' => "e15daef5-0dbf-4325-8ad7-b61fde69b8c4",
            "patient_status_id" => "cc1ff83f-9bc5-47cf-9bef-6e38a177b49d",
            "created_at" => "2024-01-01 00:00:00",
            "updated_at" => "2024-01-01 00:00:00"
        ]);
    }
}
