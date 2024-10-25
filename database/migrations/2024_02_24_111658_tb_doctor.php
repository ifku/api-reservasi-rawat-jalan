<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_doctor', function (Blueprint $table) {
            $table->uuid('id_doctor')->primary()->unique();
            $table->string('doctor_name');
            $table->string('doctor_sip')->unique();
            $table->string('doctor_str')->unique();
            $table->integer('doctor_age');
            $table->double('doctor_rating');
            $table->string('doctor_image')->nullable();
            $table->uuid('clinic_id');
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->foreign('clinic_id')->references('id_clinic')->on('tb_clinic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
