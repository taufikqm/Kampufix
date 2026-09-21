<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    if (!Schema::hasTable('pengaduans')) {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // mis. FKLYYYY-NNN
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('nim')->nullable();
            $table->string('email');
            $table->string('lokasi')->nullable();
            $table->string('subjek');
            $table->string('foto')->nullable();
            $table->text('deskripsi');
            $table->string('status')->default('Baru'); // Baru, Diproses, Selesai, Ditolak
            $table->timestamps();
        });
    }
}

};
