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
            $table->string('phone')->after('email')->nullable();
            $table->timestamp('phone_verified_at')->after('phone')->nullable();
            $table->string('address')->after('level')->nullable();
            $table->string('landmark')->after('address')->nullable();
            $table->string('state')->after('landmark')->nullable();
            $table->string('lga')->after('state')->nullable();
            $table->string('country')->after('lga')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'phone_verified_at', 'country', 'lga', 'state', 'landmark', 'address']);
        });
    }
};
