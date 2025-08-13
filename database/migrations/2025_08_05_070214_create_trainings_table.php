<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('training_title');
            $table->dateTime('training_start');
            $table->dateTime('training_end');
            $table->integer('duration_hours');
            $table->string('learning_description_type');
            $table->string('sponsor_facilitator');
            $table->foreignId('office_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
}

