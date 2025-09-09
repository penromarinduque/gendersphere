<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('training_users');
        Schema::dropIfExists('training_instances');
        Schema::create('training_instances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained('trainings')->onDelete('cascade');
            $table->foreignId('office_id')->constrained('offices')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('duration_hours', 8, 2)->nullable();
            $table->string('sponsor_facilitator')->nullable();
                       

            // Optional: add foreign key if office_id relates to offices table
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_instances');
    }
};
