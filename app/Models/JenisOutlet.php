<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisOutlet extends Model
{
    use HasFactory;
    protected $table = "jenis_outlet";
    protected $fillable = [
        'nama',        
    ];
}
