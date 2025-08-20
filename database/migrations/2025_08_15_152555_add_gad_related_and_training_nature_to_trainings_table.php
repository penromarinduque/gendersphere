<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            // Add training_nature enum
            $table->enum('training_nature', ['attended', 'conducted'])->nullable()->after('office_id');
            // Add gad_related checkbox
            $table->boolean('is_gad_related')->nullable()->after('training_nature');
        });
    }

    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            // Drop added fields
            $table->dropColumn('gad_related');
            $table->dropColumn('training_nature');
        });
    }
};