<?php

namespace App\Helpers;

class AppHelper
{
    public function readMore($teks)
    {
        $start = strpos($teks, '<p>');
        $end = strpos($teks, '</p>', $start);
        $paragraph = substr($teks, $start, $end - $start + 4);

        $string = html_entity_decode(strip_tags($paragraph));
        $word = explode(' ', $string);
        if (count($word) > 20) {
            $text = implode(' ', array_slice(explode(' ', $string), 0, 20));
        } else {
            $text = implode(' ', array_slice(explode(' ', $string), 0, count($word)));
        }

        return $text . " ...";
    }

    public function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }

    function convertDate($date)
    {
        $originalDate = $date;
        $newDate = date("d F Y", strtotime($originalDate));
        return $newDate;
    }

    function tanggal_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
    }

    function get_tanggal($tanggal)
    {        
        $split = explode('-', $tanggal);
        return $split[2];
    }

    function get_bulan($tanggal)
    {
        $bulan = array(
            1 =>   'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Juni',
            'Juli',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        );
        $split = explode('-', $tanggal);
        return $bulan[(int)$split[1]];
    }


    public static function instance()
    {
        return new AppHelper();
    }
}
