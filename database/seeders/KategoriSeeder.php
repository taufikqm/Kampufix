<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'AC / Pendingin', 'deskripsi' => 'Masalah terkait AC, pendingin ruangan, dan sirkulasi udara'],
            ['nama' => 'Listrik', 'deskripsi' => 'Masalah kelistrikan seperti lampu, stop kontak, dan MCB'],
            ['nama' => 'Elektronik & IT', 'deskripsi' => 'Masalah proyektor, komputer, jaringan, dan perangkat IT'],
            ['nama' => 'Furniture', 'deskripsi' => 'Masalah meja, kursi, lemari, dan perabotan lainnya'],
            ['nama' => 'Sanitasi & Kebersihan', 'deskripsi' => 'Masalah toilet, keran, kebersihan ruangan'],
            ['nama' => 'Bangunan', 'deskripsi' => 'Masalah struktur bangunan seperti pintu, jendela, plafon, atap'],
            ['nama' => 'Lainnya', 'deskripsi' => 'Pengaduan yang tidak termasuk kategori di atas'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::firstOrCreate(['nama' => $kategori['nama']], $kategori);
        }
    }
}
