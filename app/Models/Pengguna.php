<?php

namespace App\Models;

// Instead of extending Authenticatable directly, we'll extend the User model 
// that comes with Laravel to keep auth functionality
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'users'; // Keep using Laravel's default users table
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // admin or pembeli
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string', // enum: admin/pembeli
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is customer (pembeli)
     */
    public function isPembeli(): bool
    {
        return $this->role === 'pembeli';
    }

    /**
     * Get alamat records for this user
     */
    public function alamat()
    {
        return $this->hasMany(Alamat::class, 'pembeli_id');
    }

    /**
     * Get keranjang items for this user
     */
    public function keranjangItems()
    {
        return $this->hasMany(KeranjangItem::class, 'pembeli_id');
    }

    /**
     * Get ulasan (reviews) by this user
     */
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'pembeli_id');
    }

    /**
     * Get favorit items for this user
     */
    public function favorit()
    {
        return $this->hasMany(Favorit::class, 'pembeli_id');
    }

    /**
     * Get pembayaran records for this user
     */
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'pembeli_id');
    }
}