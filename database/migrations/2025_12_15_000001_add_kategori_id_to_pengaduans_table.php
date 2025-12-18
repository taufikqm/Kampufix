<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pengaduans', 'kategori_id')) {
            Schema::table('pengaduans', function (Blueprint $table) {
                $table->foreignId('kategori_id')->nullable()->after('teknisi_id')->constrained('kategoris')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};
