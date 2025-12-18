<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pengaduans', 'teknisi_id')) {
            Schema::table('pengaduans', function (Blueprint $table) {
                $table->foreignId('teknisi_id')->nullable()->after('user_id')->constrained('users')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropForeign(['teknisi_id']);
            $table->dropColumn('teknisi_id');
        });
    }
};

