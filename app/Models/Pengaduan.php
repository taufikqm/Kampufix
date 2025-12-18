<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'teknisi_id',
        'kategori_id',
        'kode',
        'nama',
        'nim',
        'email',
        'lokasi',
        'subjek',
        'foto',
        'deskripsi',
        'catatan_perbaikan',
        'foto_perbaikan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function progressPengerjaans()
    {
        return $this->hasMany(ProgressPengerjaan::class)->orderBy('created_at', 'desc');
    }
}
