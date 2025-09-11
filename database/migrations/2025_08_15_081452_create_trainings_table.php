<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('trainings');
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('training_title')->unique();
            $table->enum('learning_description_type', ['managerial', 'supervisory', 'technical']);
            $table->enum('training_nature', ['conducted', 'attended'])->default('attended');
            $table->boolean('is_gad_related')->default(false);
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};