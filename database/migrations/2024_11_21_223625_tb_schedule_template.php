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
        Schema::create('tb_schedule_template', function (Blueprint $table) {
            $table->uuid('id_schedule_template')->primary()->unique()->index();
            $table->uuid('doctor_id');
            $table->enum('days_template', ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
            $table->time('start_time_template');
            $table->time('end_time_template');
            $table->timestamps();

            $table->foreign('doctor_id')->references('id_doctor')->on('tb_doctor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_schedule_template');
    }
};
