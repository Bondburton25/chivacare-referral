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
            $table->string('expected_arrive')->nullable();
            $table->enum('room_type', ['single', 'sharing'])->nullable();
            $table->string('precautions')->nullable();
            $table->string('recommend_service')->nullable();
            $table->unsignedBigInteger('referred_by_id');
            $table->foreign('referred_by_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('stage_id')->default(1);
            $table->foreign('stage_id')->references('id')->on('stages');
            $table->enum('health_status', ['very_stable', 'stable', 'moderate_stable', 'unstable', 'critically_ill'])->nullable();
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
