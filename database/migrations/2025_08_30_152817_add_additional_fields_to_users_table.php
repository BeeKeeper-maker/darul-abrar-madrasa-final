<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new fields to users table
            $table->string('address')->nullable()->after('phone');
            $table->date('date_of_birth')->nullable()->after('address');
            $table->enum('gender', ['male', 'female'])->nullable()->after('date_of_birth');
        });
        
        // For SQLite, we can't modify enum directly, so we'll change the column type to string
        // and rely on validation in the application layer
        if (Schema::hasColumn('users', 'role')) {
            // First, let's create a backup of existing data
            $users = DB::table('users')->get();
            
            // Drop the role column and recreate it as string
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
            
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('student')->after('email');
            });
            
            // Restore the data
            foreach ($users as $user) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['role' => $user->role]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'date_of_birth', 'gender']);
        });
    }
};
