<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardsTable extends Migration
{
    public function up(): void
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('referrer_id')->nullable();
            $table->string('reward_type');
            $table->enum('reward_status', ['pending', 'earned', 'expired'])->default('pending');
            $table->boolean('is_claim')->default(false);
            $table->decimal('amount', 15, 2)->default(0.00);
            $table->string('currency')->default('NGN');
            $table->enum('status', ['active', 'disabled'])->default('active');
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
}
