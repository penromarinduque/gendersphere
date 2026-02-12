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
        Schema::table('plan_budgets', function (Blueprint $table) {
            //
            $table->string('attr_program_name', 300)->nullable()->after('objective_id'); // new column
            $table->double('attr_program_budget', 12,2)->default(0)->nullable()->after('attr_program_name'); // new column

            // altered columns
            $table->integer('goal_id')->nullable()->change();
            $table->integer('gender_issue_id')->nullable()->change();
            $table->integer('cause_gender_issue_id')->default(0)->nullable()->change();
            $table->integer('objective_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planbudgets', function (Blueprint $table) {
            //
            $table->dropColumn('attr_program_name');
            $table->dropColumn('attr_program_budget');

            // Revert altered columns to original (assuming they were NOT NULL and had no default)
            $table->integer('goal_id')->nullable(false)->change();
            $table->integer('gender_issue_id')->nullable(false)->change();
            $table->integer('cause_gender_issue_id')->nullable(false)->default(null)->change();
            $table->integer('objective_id')->nullable(false)->default(null)->change();
        });
    }
};
