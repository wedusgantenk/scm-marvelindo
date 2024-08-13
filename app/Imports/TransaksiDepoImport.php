<?php
namespace App\Imports;

use App\Models\Sales;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransaksiDepoImport implements ToCollection, WithHeadingRow
{
    private $data;

    public function collection(Collection $rows)
    {
        $this->data;
        
    }

    public function getData()
    {
        return $this->data;
    }
    
}
