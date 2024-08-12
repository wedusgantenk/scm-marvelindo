<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDepo extends Model
{
    use HasFactory;
    protected $table = "transaksi_distribusi_depo";
    protected $fillable = [
        'id_petugas',
        'id_cluster',
        'id_depo',
        'tanggal',
        'status'
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }

    public function cluster()
    {
        return $this->belongsTo(Cluster::class, 'id_cluster');
    }

    public function depo()
    {
        return $this->belongsTo(Depo::class, 'id_depo');
    }

    public function details()
    {
        return $this->hasMany(TransaksiDepoDetail::class, 'id_transaksi');
    }

    
}
