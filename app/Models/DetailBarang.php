<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBarang extends Model
{
        use HasFactory;
    protected $table = "detail_barang";
    protected $fillable = [
        'id_barang',
        'id_barang_masuk',
        'kode_unik',
        'status',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class,'id_barang', 'id');
    }
    public function barang_masuk()
    {
        return $this->belongsTo(BarangMasuk::class,'id_barang_masuk', 'id');
    }
}
