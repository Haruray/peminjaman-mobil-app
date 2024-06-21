<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanMobil extends Model
{
    use HasFactory;
    protected $table = 'peminjaman_mobil';

    protected $fillable = [
        'mobil_id',
        'user_id',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'status',
        'total_harga',
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
