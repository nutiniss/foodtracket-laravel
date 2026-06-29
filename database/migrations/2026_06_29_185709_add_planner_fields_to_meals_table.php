<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meals', function (Blueprint $table) {
            $table->boolean('is_planned')->default(false)->after('name');
            $table->boolean('is_eaten')->default(true)->after('is_planned');
            $table->timestamp('eaten_at')->nullable()->after('is_eaten');
        });
    }

    public function down(): void
    {
        Schema::table('meals', function (Blueprint $table) {
            $table->dropColumn([
                'is_planned',
                'is_eaten',
                'eaten_at',
            ]);
        });
    }
};