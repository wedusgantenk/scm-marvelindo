<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDepoDetail extends Model
{
    use HasFactory;
    protected $table = "transaksi_distribusi_depo_detail";
    protected $fillable = [
        'id_transaksi',
        'id_barang',
        'kode_unik',
        'status'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class,'id_barang', 'id');
    }

    public function transaksiDepo()
{
    return $this->belongsTo(TransaksiDepo::class, 'id_transaksi');
}

    // public function detail()
    // {
    //     return $this->belongsTo(DetailBarang::class,'kode_unik', 'id');
    // }

   
}
