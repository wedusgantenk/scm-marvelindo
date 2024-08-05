<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang_Depo extends Model
{
    use HasFactory;
    protected $table = "stok_barang_depo";
    protected $fillable = [
        'id_depo',
        'stok',
    ];
    public function depo()
    {
        return $this->belongsTo(Depo::class, 'id_depo', 'id');
    }
    
    public $timestamps = false;
}
