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
        Schema::table('contributions', function (Blueprint $table) {
            $table->string('payment_method')->default('card')->after('status');
            $table->timestamp('payment_verified_at')->nullable()->after('payment_method');
            $table->json('virtual_account_details')->nullable()->after('payment_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('contributions', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_verified_at', 'virtual_account_details']);
        });
    }
};
