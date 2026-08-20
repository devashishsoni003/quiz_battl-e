<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('u_id')->nullable()->unique()->after('id');
        });

        // Generate and assign unique serial-wise u_id to existing users
        $users = User::orderBy('id', 'asc')->get();
        $startId = 10001;
        foreach ($users as $index => $user) {
            $user->u_id = 'QB' . ($startId + $index);
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('u_id');
        });
    }
};
