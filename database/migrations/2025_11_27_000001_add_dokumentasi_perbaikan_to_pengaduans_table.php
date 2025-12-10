<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->text('catatan_perbaikan')->nullable()->after('deskripsi');
            $table->string('foto_perbaikan')->nullable()->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn(['catatan_perbaikan', 'foto_perbaikan']);
        });
    }
};

