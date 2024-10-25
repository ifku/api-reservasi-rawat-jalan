<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientStatusSeeder extends Seeder
{
    public function run(): void
    {
        $patientStatusData = [
            'Sendiri' => '31976ae8-8548-4d8e-a9ae-77c54ce21693',
            'Suami' => 'cc1ff83f-9bc5-47cf-9bef-6e38a177b49d',
            'Istri' => '30404375-3054-4cf4-914a-6ea85a365ea8',
            'Anak' => '4c864af5-39f5-46b5-8272-d78bf51735e2',
            'Menantu' => '6f0252d4-1328-4c0b-8b17-539b2541686d',
            'Cucu' => '09213f26-7758-43a4-9ba2-48c2b4cb8aa0',
            'Orang Tua' => '9bb8c22f-401a-4565-9a16-8d59754d6d19',
            'Mertua' => '382b6bc2-b9a3-43a1-a0aa-ed7732042a72',
            'Pembantu' => '5fde5f3c-9ed7-42ad-ae82-5813bbf8c477',
            'Lainnya' => 'f0a656f9-21c6-42a3-93a6-f78aae3f461e'
        ];

        foreach ($patientStatusData as $status => $patientStatusId) {
            DB::table('tb_patient_status')->insert([
                'id_patient_status' => $patientStatusId,
                'patient_status_name' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
