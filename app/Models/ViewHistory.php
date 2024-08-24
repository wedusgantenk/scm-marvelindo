<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewHistory extends Model
{
    protected $table = "vwhistoribarang";
    protected $fillable = [
        'id_detailbarang',
        'type',
        'id_lokasi_asal',
        'id_lokasi_tujuan',
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
