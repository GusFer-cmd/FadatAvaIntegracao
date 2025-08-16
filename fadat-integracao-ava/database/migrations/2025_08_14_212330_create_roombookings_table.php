<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roombookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->tinyInteger('day_of_week'); // 0=Dom, 1=Seg
            $table->time('start_time');
            $table->time('end_time');
            $table->string('professor_id')->nullable();
            $table->string('subject_id')->nullable();
            $table->string('classroom_id')->nullable();

            $table->timestamps();

            $table->foreign('professor_id')->references('id')->on('professors')->nullOnDelete();
            $table->foreign('subject_id')->references('id')->on('subjects')->nullOnDelete();
            $table->foreign('classroom_id')->references('id')->on('classrooms')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roombookings');
    }
};
