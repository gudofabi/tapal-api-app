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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_id', 20)->unique()->after('id'); // Add UUID column with unique constraint
            $table->enum('role', ['lender', 'agent', 'lead generator', 'admin'])->default('agent')->after('email'); // Add role column with enum values
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_id'); // Remove UUID column
            $table->dropColumn('role'); // Remove role column
        });
    }
};
