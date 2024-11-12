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
        Schema::create('gender_issues', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('mandate_year');
            $table->text('gender_issue_mandate');
            $table->tinyInteger('is_active_gender_issue');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gender_issues');
    }
};
