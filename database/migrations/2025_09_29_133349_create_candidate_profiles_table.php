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
        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('birth_date')->nullable();
            $table->string('nationality')->default('cubana');
            $table->string('education_level')->nullable();
            $table->text('work_experience')->nullable();
            $table->json('languages')->nullable();
            $table->json('skills')->nullable();
            $table->string('desired_position')->nullable();
            $table->decimal('desired_salary', 10, 2)->nullable();
            $table->string('cv_path')->nullable();
            $table->text('about_me')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_profiles');
    }
};
