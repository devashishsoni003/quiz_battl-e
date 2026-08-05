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
        Schema::create('withdrawal_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('coins_per_usd', 12, 2);
            $table->decimal('usd_to_local_rate', 12, 2);
            $table->string('local_currency')->default('INR');
            $table->bigInteger('minimum_withdrawal_coins');
            $table->bigInteger('maximum_withdrawal_coins');
            $table->string('processing_time')->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_settings');
    }
};
