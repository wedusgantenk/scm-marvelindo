<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang_Cluster extends Model
{
    use HasFactory;
    protected $table = "stok_barang_cluster";
    protected $fillable = [
        'id_cluster',
        //'id_barang',
        'stok',
    ];
    public function cluster()
    {
        return $this->belongsTo(Cluster::class, 'id_cluster', 'id');
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
    public $timestamps = false;
}
