<?php
Schema::create('attendee_training_instance', function (Blueprint $table) {
    $table->id();
    $table->foreignId('training_instance_id')->constrained()->onDelete('cascade');
    $table->foreignId('person_info_id')->constrained()->onDelete('cascade');
    $table->string('certificate_path')->nullable();
    $table->timestamps();
});
