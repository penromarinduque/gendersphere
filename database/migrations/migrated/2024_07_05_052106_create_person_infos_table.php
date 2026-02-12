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
        Schema::create('person_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('lastname',150);
            $table->string('firstname',150);
            $table->string('middlename',150)->nullable();
            $table->string('extname',50)->nullable();
            $table->char('gender',30);
            $table->char('civil_status',50)->nullable();
            $table->date('birthdate',30)->nullable();
            $table->tinyInteger('age')->default(0);
            $table->double('height', 8,2)->default(0)->nullable();
            $table->double('weight', 8,2)->default(0)->nullable();
            $table->char('blood_type',20)->nullable();
            $table->integer('barangay_id')->default(0);
            $table->integer('municipality_id')->default(0);
            $table->integer('province_id')->default(0);
            $table->string('address_full',150)->nullable();
            $table->string('education_level',100)->nullable();
            $table->char('employment_type',30)->nullable();
            $table->string('position',200)->nullable();
            $table->string('organization',150)->nullable();
            $table->tinyInteger('person_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_infos');
    }
};
