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
        Schema::table('super_admins', function (Blueprint $table) {
            $table->string('whatsapp_number')->nullable()->after('contact_number');
        });

        // Set default value for first admin
        $admin = \App\Models\SuperAdmin::first();
        if ($admin) {
            $admin->update(['whatsapp_number' => '1234567890']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('super_admins', function (Blueprint $table) {
            $table->dropColumn('whatsapp_number');
        });
    }
};
