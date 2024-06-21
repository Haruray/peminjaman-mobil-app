<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobil';
    //fillable
    protected $fillable = [
        'merk',
        'model',
        'nomor_plat',
        'tarif_per_hari',
        'user_id',
    ];

    //relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(PeminjamanMobil::class);
    }
}
