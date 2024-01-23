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
        Schema::create('loan_amortization_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained();
            $table->unsignedSmallInteger('month');
            $table->unsignedDouble('starting_balance');
            $table->unsignedDouble('monthly_payment');
            $table->unsignedDouble('principal_payment');
            $table->unsignedDouble('interest_payment');
            $table->unsignedDouble('ending_balance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_amortization_schedules');
    }
};