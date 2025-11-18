<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // kalau kamu pakai role di user
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ===========================
    // 🔥 RELASI YANG DIBUTUHKAN
    // ===========================

    // Relasi ke item keranjang
    public function keranjangItems()
    {
        return $this->hasMany(\App\Models\KeranjangItem::class, 'id');
    }

    // Relasi ke ulasan
    public function ulasan()
    {
        return $this->hasMany(\App\Models\Ulasan::class, 'user_id');
    }

    // Relasi ke produk favorit
    public function favorit()
    {
        return $this->hasMany(\App\Models\Favorit::class, 'id');
    }

    public function isAdmin()
{
    return $this->role === 'admin';
}
}
