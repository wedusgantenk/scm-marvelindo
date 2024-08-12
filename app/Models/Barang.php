<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = "barang";
    protected $fillable = [
        'id_jenis',
        'nama',
        'gambar',
        'keterangan',
        'fisik',
    ];

    public function jenis_barang()
    {
        return $this->belongsTo(JenisBarang::class);
    }

    public function jenisOutlet()
    {
        return $this->belongsTo(JenisOutlet::class, 'id_jenis');
    }

    public function hargaBarang()
    {
        return $this->hasMany(HargaBarang::class, 'id_barang');
    }
}
