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
        Schema::create('tb_queue', function (Blueprint $table) {
            $table->uuid('id_queue')->primary()->unique()->index();
            $table->integer('queue_number')->unique();
            $table->uuid('doctor_id');
            $table->timestamps();

            $table->foreign('doctor_id')->references('id_doctor')->on('tb_doctor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_queue');
    }
};
