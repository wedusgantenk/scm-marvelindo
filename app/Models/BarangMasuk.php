<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = "barang_masuk";
    protected $fillable = [
        'id_produk',
        'id_petugas',
        'tanggal',
        'no_do',
        'no_po',
        'kode_cluster',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_produk');
    }

    public function jenis_barang()
    {
        return $this->belongsTo(JenisBarang::class, 'id_jenis_barang');
    }
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }
    public function cluster()
    {
        return $this->belongsTo(Cluster::class, 'kode_cluster', 'kode_cluster');
    }
}
