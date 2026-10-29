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
        Schema::create('flagged_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('result_id')->constrained()->cascadeOnDelete();
            $table->string('abnormality_type');
            $table->string('severity')->default('medium');
            $table->boolean('is_resolved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flagged_results');
    }
};
