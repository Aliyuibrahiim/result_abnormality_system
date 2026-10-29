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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->decimal('ca_score', 5, 2)->nullable();
            $table->decimal('exam_score', 5, 2)->nullable();
            $table->decimal('total_score', 5, 2)->nullable();
            $table->string('grade')->nullable();
            $table->decimal('points', 4, 2)->nullable(); // e.g., 5.0, 4.0
            $table->foreignId('academic_session_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // A student can only have one result per course per session
            $table->unique(['student_id', 'course_id', 'academic_session_id'], 'unique_result_per_session');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
