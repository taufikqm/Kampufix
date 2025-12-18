<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressPengerjaan extends Model
{
    protected $fillable = [
        'pengaduan_id',
        'keterangan',
        'foto',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
