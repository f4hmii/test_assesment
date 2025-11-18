<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'pembeli_id',
        'total',
        'status',
        'metode',
        'detail_json',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'detail_json' => 'array',
    ];

    /**
     * Get the customer (pembeli) who made this payment
     */
    public function pembeli()
    {
        return $this->belongsTo(Pengguna::class, 'pembeli_id');
    }
}