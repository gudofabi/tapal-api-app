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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2); // Loan amount
            $table->date('date'); // Date of the loan
            $table->decimal('loan_percentage', 5, 2); // Percentage with 2 decimals
            $table->decimal('agent_percentage', 5, 2)->nullable(); // Percentage with 2 decimals
            $table->foreignId('agent_id')->nullable(); // References users table
            $table->decimal('lead_generator_percentage', 5, 2)->nullable(); // Percentage for lead generator
            $table->foreignId('lead_generator_id')->nullable(); // References users table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
