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
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('withdrawal_account_id')->constrained('withdrawal_accounts')->onDelete('cascade');
            $table->integer('coins');
            $table->decimal('coins_rate', 12, 2);
            $table->decimal('usd_amount', 12, 2);
            $table->decimal('usd_rate', 12, 2);
            $table->decimal('final_amount', 12, 2);
            $table->string('currency');
            $table->string('status')->default('Pending'); // Pending, Approved, Rejected
            $table->string('transaction_id')->nullable();
            $table->text('admin_note')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('super_admins')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};
