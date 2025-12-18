<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pengaduans', 'rating')) {
            Schema::table('pengaduans', function (Blueprint $table) {
                $table->float('rating')->nullable()->after('status');
                $table->text('feedback')->nullable()->after('rating');
            });
        }
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn(['rating', 'feedback']);
        });
    }
};
