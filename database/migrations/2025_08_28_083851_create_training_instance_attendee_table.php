<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {   Schema::dropIfExists('training_instance_attendee');
        Schema::create('training_instance_attendee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_instance_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('person_info_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('certificate_path')->nullable();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_instance_attendee');
    }
};
