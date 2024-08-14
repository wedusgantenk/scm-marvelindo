<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSales extends Model
{
    use HasFactory;
    protected $table = "transaksi_distribusi_sales";
    protected $fillable = [
        'id_petugas',
        'id_depo',
        'id_depo',
        'id_sales',
        'tanggal',
        'status'
    ];

    
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'id_sales');
    }

    public function depo()
    {
        return $this->belongsTo(Depo::class, 'id_depo');
    }

    public function details()
    {
        return $this->hasMany(TransaksiSalesDetail::class, 'id_transaksi');
    }
}
