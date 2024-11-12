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
        Schema::create('activity_details', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id');
            $table->string('sub_activity', 200)->nullable();
            $table->text('targets');
            $table->smallInteger('target_women')->default(0);
            $table->smallInteger('target_men')->default(0);
            $table->double('gad_budget', 12,2)->default(0);
            $table->string('responsible_unit', 200)->nullable();
            $table->text('actual_result')->nullable();
            $table->smallInteger('actual_women')->default(0);
            $table->smallInteger('actual_men')->default(0);
            $table->smallInteger('actual_lgbtq')->default(0);
            $table->double('actual_cost', 12,2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_details');
    }
};
