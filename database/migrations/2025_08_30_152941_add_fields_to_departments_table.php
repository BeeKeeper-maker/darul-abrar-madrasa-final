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
        Schema::table('departments', function (Blueprint $table) {
            $table->string('head_of_department')->nullable()->after('code');
            $table->decimal('budget', 15, 2)->nullable()->after('description');
            $table->integer('established_year')->nullable()->after('budget');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn(['head_of_department', 'budget', 'established_year']);
        });
    }
};
