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
        Schema::create('academic_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. 2026/2027
            $table->integer('semester'); // 1 or 2
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            
            // A session name and semester combination should be unique
            $table->unique(['name', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_sessions');
    }
};
