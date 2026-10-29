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
        Schema::create('resolution_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flagged_result_id')->constrained()->cascadeOnDelete();
            $table->text('review_notes')->nullable();
            $table->string('resolution_status');
            $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resolution_logs');
    }
};
