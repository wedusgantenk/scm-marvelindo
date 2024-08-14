<?php

namespace App\Imports;

use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangMasukImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {        
    }    
}
