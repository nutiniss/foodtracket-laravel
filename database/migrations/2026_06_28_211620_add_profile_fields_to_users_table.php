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
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user');
                $table->integer('daily_calorie_goal')->nullable();
                $table->decimal('target_weight', 5, 2)->nullable();
            });
        }

        public function down(): void
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn([
                    'role',
                    'daily_calorie_goal',
                    'target_weight',
                ]);
            });
        }
};
