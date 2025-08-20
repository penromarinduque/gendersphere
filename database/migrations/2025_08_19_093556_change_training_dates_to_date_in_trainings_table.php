<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTrainingDatesToDateInTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->date('training_start')->change();
            $table->date('training_end')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            // Assuming they were originally datetime, you can adjust this as needed
            $table->dateTime('training_start')->change();
            $table->dateTime('training_end')->change();
        });
    }
}
