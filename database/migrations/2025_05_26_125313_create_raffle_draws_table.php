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
         Schema::create('raffle_draws', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->constrained()->onDelete('cascade');
            $table->string('reward');
            $table->string('price');
            $table->string('currency');
            $table->string('used_type');
            $table->dateTime('claimed_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->enum('status', ['pending', 'earned', 'expired'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffle_draws');
    }
};
