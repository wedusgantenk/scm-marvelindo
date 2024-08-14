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
        return new BarangMasuk([
            'iccid' => $rows[0],
            'id_produk' => $rows[1],
            'no_do' => $rows[2],
            'tanggal' => $rows[3],
            'kode_cluster' => $rows[4],
            'no_po' => $rows[5],
        ]);
    }
}
