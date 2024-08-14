<?php

namespace App\Imports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\ToModel;

class BarangImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (count($row) < 4) {
            return null; // Lewati baris jika tidak memiliki cukup kolom
        }

        // Validasi kolom
        $nama = trim($row[0]);
        $id_jenis = intval($row[1]);
        $keterangan = trim($row[2]);
        $fisik = intval($row[3]);

        // Validasi lebih lanjut
        if (empty($nama) || $id_jenis <= 0 || !in_array($fisik, [0, 1])) {
            return null; // Lewati baris jika validasi gagal
        }

        // Validasi data duplikat
        $existingBarang = Barang::where('nama', $nama)->first();
        if ($existingBarang) {
            return null; // Lewati baris jika nama barang sudah ada
        }

        return new Barang([
            'nama'     => $nama,
            'id_jenis' => $id_jenis,
            'keterangan' => $keterangan,
            'fisik'    => $fisik,
        ]);
    }
}
