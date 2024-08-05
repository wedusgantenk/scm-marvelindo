<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriBarang extends Model
{
    use HasFactory;
    protected $table = "histori_barang";
    protected $fillable = [
        'id_detail_barang',
        'type',
        'id_lokasi_asal',
        'id_lokasi_tujuan',
        'tanggal',
    ];

    public function detail_barang()
    {
        return $this->belongsTo(DetailBarang::class,'id_detail_barang', 'id');
    }
    public function lokasi_asal()
    {
        return $this->belongsTo(Cluster::class,'id_lokasi_asal', 'id');
    }
    public function lokasi_tujuan()
    {
        return $this->belongsTo(Depo::class,'id_lokasi_tujuan', 'id');
    }
      public $timestamps = false;
}
