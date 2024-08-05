<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depo extends Model
{
    use HasFactory;
    protected $table = "depo";
    protected $fillable = [
        'id_cluster',
        'nama',
        'alamat',             
    ];

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }
}
