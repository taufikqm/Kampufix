<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi (mass assignable)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin' atau 'mahasiswa'
        'profile_photo_path',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting kolom (Laravel 10/11 style)
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Laravel otomatis hash
        ];
    }

    /**
     * RELASI: 1 user memiliki banyak pengaduan
     */
    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'user_id');
    }

    /**
     * CEK role admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * CEK role mahasiswa
     */
    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    /**
     * CEK role teknisi
     */
    public function isTeknisi()
    {
        return $this->role === 'teknisi';
    }
}
