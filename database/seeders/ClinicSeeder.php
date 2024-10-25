<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class ClinicSeeder extends Seeder
{
    public function run(): void
    {
        $clinics = array('Klinik Umum', 'Penyakit Dalam', 'Klinik Paru', 'Klinik THT', 'Klinik Kulit dan Kelamin', 'Klinik Mata', 'Klinik Kandungan', 'Klinik Bedah', 'Klinik Jantung', 'Klinik Syaraf', 'Klinik Gigi dan Mulut', 'Klinik Kecantikan');
        $clinicId = array('178d4b7d-4170-4571-96a1-20d15a904cf6', '81f0439d-ef6f-4a82-9ce3-60dd014d724a', 'c65f7c45-922c-4c1a-a9d3-299a3482edce', '5d8bcac0-142d-4405-98d4-9b5829442b56', '75bb4c96-20a6-4356-9abf-3a2485362030', '4359aabc-1214-4b5d-a721-7e6fb8aa216c', '5025c48c-1b52-4f3b-89c4-c2a782e61493', '6879a3be-e563-4740-907c-d490f281aa08', '4ce40dc3-e7d2-43d9-9dd7-c43cf8a8c055', '072e77e1-1ca5-4753-82dc-e559e24d4fee', '668c07fe-38dc-4079-8402-9c6ff563a35d', '05e2b301-6687-4d0f-81e2-608f5f7a41a5', 'e30b9254-748a-4a73-9436-cef245be9c2f');
        for ($i = 0; $i < count($clinics); $i++) {
            $imagePath = database_path('seeders/images/clinic_icon/icon_' . ($i + 1) . '.svg');
            $imageData = file_get_contents($imagePath);
            $fileName = time() . $i . '.' . 'svg';
            Storage::disk('public')->put('clinic_icon/' . $fileName, $imageData);
            DB::table('tb_clinic')->insert([
                'id_clinic' => $clinicId[$i],
                'clinic_name' => $clinics[$i],
                'clinic_icon' => $fileName,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
