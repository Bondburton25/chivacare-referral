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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('avatar')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date')->nullable();
            $table->float('weight', 8, 2)->nullable();
            $table->float('height', 8, 2)->nullable();
            $table->string('congenital_disease')->nullable();
            $table->string('preliminary_symptoms')->nullable();
            $table->string('food')->nullable();
            $table->enum('excretory_system', ['self_excretion', 'diaper', 'tubing'])->nullable();
            $table->string('expectations')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_person_relationship')->nullable();
            $table->string('treatment_history')->nullable();
            $table->string('phone_number')->nullable();
            $table->longText('reason_not_staying')->nullable();
            $table->string('expected_arrive')->nullable();
            $table->datetime('expected_arrive_date_time')->nullable();
            $table->datetime('arrive_date_time')->nullable();
            $table->enum('room_type', ['single', 'sharing'])->nullable();
            $table->string('precautions')->nullable();
            $table->string('recommend_service')->nullable();
            $table->unsignedBigInteger('referred_by_id');
            $table->foreign('referred_by_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('stage_id');
            $table->foreign('stage_id')->references('id')->on('stages');
            $table->unsignedBigInteger('health_status_id')->nullable();
            $table->foreign('health_status_id')->references('id')->on('health_statuses');
            $table->enum('staying_decision', ['stay', 'pending', 'backoff'])->nullable();
            $table->boolean('physical_therapy_service')->nullable();
            $table->datetime('contacted_relative_at')->nullable();
            $table->datetime('relative_visited_at')->nullable();
            $table->datetime('relative_decide_of_stay_at')->nullable();
            $table->datetime('admit_patient_at')->nullable();
            $table->datetime('decided_at')->nullable();
            $table->datetime('end_service_at')->nullable();
            $table->date('admission_date_one_month')->nullable();
            $table->date('admission_date_two_months')->nullable();
            $table->date('admission_date_three_months')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
