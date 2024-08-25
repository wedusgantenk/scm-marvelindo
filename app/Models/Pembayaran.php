<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'm_transaksi';

    protected $fillable = [
        'id_user',
        'tanggal',
        'tipe_payment',
        'total',
        'status',
        'status_pembayaran',
        'url_bukti',
    ];
    public function user()
    {
        return $this->belongsTo(MobileUsers::class, 'id', 'nama_outlet');
    }
    public $timestamps = false;

}
