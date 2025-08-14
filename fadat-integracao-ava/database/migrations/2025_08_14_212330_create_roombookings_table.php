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
            $table->timestamp('start_date_time');
            $table->timestamp('end_date_time');
            $table->unisigedBigInteger('professor_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('classroom_id');

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
