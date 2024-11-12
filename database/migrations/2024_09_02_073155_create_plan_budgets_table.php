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
        Schema::create('plan_budgets', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('year');
            $table->char('focus',30);
            $table->integer('goal_id');
            $table->integer('gender_issue_id');
            $table->integer('cause_gender_issue_id')->default(0);
            $table->text('relevant_org');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_budgets');
    }
};
