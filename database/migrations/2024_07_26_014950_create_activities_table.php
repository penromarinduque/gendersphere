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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->char('type', 30);
            $table->text('gad_activity');
            $table->string('name_title', 150);
            $table->date('date_conducted');
            $table->string('place_conducted', 150);
            $table->string('resource_speakers', 200);
            $table->text('remarks')->nullable();
            $table->double('gad_budget_allotment', 20,2)->default(0);
            $table->double('gad_allocated', 20,2)->default(0);
            $table->double('gad_remaining_budget', 20,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
