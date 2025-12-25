<?php

namespace App\Models;

// TAMBAHKAN INI
use Laravel\Sanctum\HasApiTokens; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // TAMBAHKAN 'HasApiTokens' DI SINI
    use HasApiTokens, HasFactory, Notifiable; 

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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

    // ... sisa relasi Anda biarkan saja ...
    public function keranjangItems() { return $this->hasMany(\App\Models\KeranjangItem::class, 'id'); }
    public function ulasan() { return $this->hasMany(\App\Models\Ulasan::class, 'user_id'); }
    public function favorit() { return $this->hasMany(\App\Models\Favorit::class, 'id'); }
    public function isAdmin() { return $this->role === 'admin'; }
}