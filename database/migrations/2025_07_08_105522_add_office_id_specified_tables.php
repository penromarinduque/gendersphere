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
        //
        Schema::table('committees', function (Blueprint $table) {
            $table->foreignId('office_id');
        });

        Schema::table('committee_positions', function (Blueprint $table) {
            $table->foreignId('office_id');
        });

        Schema::table('frontline_services', function (Blueprint $table) {
            $table->foreignId('office_id');
        });

        Schema::table('plan_budgets', function (Blueprint $table) {
            $table->foreignId('office_id');
        });

        Schema::table('cause_gender_issues', function (Blueprint $table) {
            $table->foreignId('office_id');
        });

        Schema::table('objectives', function (Blueprint $table) {
            $table->foreignId('office_id');
        });

        Schema::table('gender_issues', function (Blueprint $table) {
           $table->foreignId('office_id'); 
        });

        Schema::table('goals', function (Blueprint $table) {
            $table->foreignId('office_id');
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
    {
        Schema::table('committees', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            $table->dropColumn('office_id');
        });

        Schema::table('committee_positions', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            $table->dropColumn('office_id');
        });

        Schema::table('frontline_services', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            $table->dropColumn('office_id');
        });

        Schema::table('plan_budgets', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            $table->dropColumn('office_id');
        });

        Schema::table('cause_gender_issues', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            $table->dropColumn('office_id');
        });

        Schema::table('objectives', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            $table->dropColumn('office_id');
        });

        Schema::table('gender_issues', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            $table->dropColumn('office_id');
        });

        Schema::table('goals', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            $table->dropColumn('office_id');
        });

    }
};
