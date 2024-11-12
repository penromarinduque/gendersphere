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
        Schema::create('frontline_services', function (Blueprint $table) {
            $table->id();
            $table->integer('permit_type_id');
            $table->string('client_name', 200);
            $table->char('gender', 10);
            $table->date('date_applied');
            $table->date('date_released');
            $table->integer('barangay_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frontline_services');
    }
};
