<?php
/**[N]**
 * JIBAS Education Community
 * Jaringan Informasi Bersama Antar Sekolah
 *
 * @version: 32.0 (Feb 05, 2025)
 * @notes: 
 *
 * Copyright (C) 2024 JIBAS (http://www.jibas.net)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 **[N]**/ ?>
<?php
function inaMonthName($month)
{
    switch ($month)
    {
        case 1:
            return "Jan";
        case 2:
            return "Feb";
        case 3:
            return "Mar";
        case 4:
            return "Apr";
        case 5:
            return "Mei";
        case 6:
            return "Jun";
        case 7:
            return "Jul";
        case 8:
            return "Agt";
        case 9:
            return "Sep";
        case 10:
            return "Okt";
        case 11:
            return "Nop";
        default:
            return "Des";
    }
}

function formatInaMySqlDate($date)
{
    $lsDate = explode("-", $date);
    $d = str_pad($lsDate[2], 2, "0", STR_PAD_LEFT);
    $m = inaMonthName($lsDate[1]);
    $y = $lsDate[0];

    return "$d $m $y";
}

function NamaMetode($metode)
{
    if ($metode == 1)
        return "Tagihan";

    if ($metode == 2)
        return "Karanjang";

    return "";
}

function NamaKategori($kategori)
{
    if ($kategori == "JTT")
        return "Iuran Wajib";

    if ($kategori == "SKR")
        return "Iuran Sukarela";

    if ($kategori == "SISTAB")
        return "Tabungan Siswa";

    if ($kategori == "PEGTAB")
        return "Tabungan Pegawai";

    if ($kategori == "BL")
        return "Biaya Layanan";

    if ($kategori == "LB")
        return "Kelebihan Pembayaran";

    if ($kategori == "DPST")
        return "Deposit Bank";

    return "-";
}

function NamaPenerimaan($kategori, $idPenerimaan)
{
    if ($idPenerimaan == "0")
    {
        if ($kategori == "BL")
            return "Biaya Layanan";

        if ($kategori == "LB")
            return "Kelebihan Transfer";
    }

    if ($kategori == "JTT" || $kategori == "SKR")
    {
        $sql = "SELECT nama
                  FROM jbsfina.datapenerimaan
                 WHERE replid = $idPenerimaan";
        $res = QueryDb($sql);
        if ($row = mysqli_fetch_row($res))
            return $row[0];

        return "-";
    }

    if ($kategori == "SISTAB")
    {
        $sql = "SELECT nama
                  FROM jbsfina.datatabungan
                 WHERE replid = $idPenerimaan";
        $res = QueryDb($sql);
        if ($row = mysqli_fetch_row($res))
            return $row[0];

        return "-";
    }

    if ($kategori == "PEGTAB")
    {
        $sql = "SELECT nama
                  FROM jbsfina.datatabunganp
                 WHERE replid = $idPenerimaan";
        $res = QueryDb($sql);
        if ($row = mysqli_fetch_row($res))
            return $row[0];

        return "-";
    }

    if ($kategori == "DPST")
    {
        $sql = "SELECT nama
                  FROM jbsfina.bankdeposit
                 WHERE replid = $idPenerimaan";
        $res = QueryDb($sql);
        if ($row = mysqli_fetch_row($res))
            return $row[0];

        return "-";
    }

    return "-";
}

function PrePrintR($list)
{
    echo "<pre>";
    print_r($list);
    echo "</pre>";
}

function EchoBr($data)
{
    echo "$data<br>";
}

function SafeInput($data)
{
    $data = str_replace("\"", "`", $data);
    $data = str_replace("<", "&lt;", $data);
    return str_replace(">", "&gt;", $data);
}
?>
