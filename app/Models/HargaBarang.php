<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaBarang extends Model
{
    use HasFactory;
    protected $table = "harga_barang";
    protected $fillable = [
        'id_barang',        
        'id_jenis_outlet',
        'harga'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    public function jenisoutlet()
    {
        return $this->belongsTo(JenisOutlet::class, 'id_jenis_outlet', 'id');
    }
}
