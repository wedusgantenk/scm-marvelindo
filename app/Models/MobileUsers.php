<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileUsers extends Model
{
    use HasFactory;

    protected $table = 'm_users';

    protected $fillable = [
        'email',
        'password',
        'nama_outlet',
        'alamat',
        'id_jenis',
        'status',
        'code',
    ];
    public $timestamps = false;
}
