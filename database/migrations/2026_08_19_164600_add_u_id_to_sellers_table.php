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
            $table->string('u_id')->nullable()->unique()->after('id');
        });

        // Populate existing sellers serial wise starting from 100001
        $sellers = \App\Models\Seller::orderBy('id', 'asc')->get();
        $startId = 100001;
        foreach ($sellers as $index => $seller) {
            $seller->u_id = (string) ($startId + $index);
            $seller->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn('u_id');
        });
    }
};
