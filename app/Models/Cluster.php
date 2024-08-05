<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;
    protected $table = "cluster";
    protected $fillable = [
        'id',
        'kode_cluster',
        'nama',
        'alamat',
        'updated_at',
        'created_at',
    ];
    public $timestamps = false;


}
