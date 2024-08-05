<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $table = "sales";
    
    protected $fillable = [
        'id_depo',        
        'nama',
        'email',
        'area',
        'password',
        'status',
    ];

    public $timestamps = false;

    public function depo()
    {
        return $this->belongsTo(Depo::class, 'id_depo', 'id');
    }
}
