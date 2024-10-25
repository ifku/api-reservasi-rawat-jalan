<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $imagePath = database_path('seeders/images/doctor_image/doctor_image1.jpg');
        $imageData = file_get_contents($imagePath);
        $fileName = time() . '.' . 'jpg';
        Storage::disk('public')->put('doctor_images/' . $fileName, $imageData);
        DB::table('tb_doctor')->insert([
            'id_doctor' => "7ab1bb20-661c-4520-a3df-9ba147f4c79c",
            'doctor_name' => "Dr. John Doe",
            'doctor_sip' => "123456789",
            'doctor_str' => "123456789",
            'doctor_age' => 35,
            'doctor_rating' => 4.5,
            'clinic_id' => "178d4b7d-4170-4571-96a1-20d15a904cf6",
            'doctor_image' => $fileName,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
