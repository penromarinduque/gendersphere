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
        Schema::table('person_infos', function (Blueprint $table) {
            //
            $table->enum('employment_status', ['new', 'retired', 'resigned', 'terminated', 'renewed'])->default("new")->after('employment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('person_infos', function (Blueprint $table) {
            //
        });
    }
};
