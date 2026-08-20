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
        Schema::table('sellers', function (Blueprint $table) {
            $table->string('email')->unique()->nullable()->after('mobile_number');
        });

        // Set default email for existing sellers
        $sellers = \App\Models\Seller::all();
        foreach ($sellers as $seller) {
            if (empty($seller->email)) {
                $seller->email = 'seller' . $seller->id . '@example.com';
                $seller->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};
