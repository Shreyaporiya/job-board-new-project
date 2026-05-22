<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_skills_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('color', 7)->default('#0d6efd'); // For pillbox colors
            $table->timestamps();
        });

        // Pivot table for many-to-many relationship
        Schema::create('skill_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->integer('proficiency_level')->nullable(); // Optional: skill level 1-10
            $table->timestamps();

            $table->unique(['user_id', 'skill_id']); // Prevent duplicate entries
        });
    }

    public function down()
    {
        Schema::dropIfExists('skill_user');
        Schema::dropIfExists('skills');
    }
};