<?
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

$inputSet = array(
    array(3, "C", "departemen", false),
    array(4, "G", "idkelas", false),
    array(5, "C", "nip", true),
    array(7, "C", "kodeujian", true),
    array(8, "C", "tanggal", true),
    array(8, "E", "bulan", true),
    array(8, "G", "tahun", true),
    array(10, "C", "materi", true),
    array(11, "C", "keterangan", true),
);

function isInputCell($rowNo, $colChr)
{
    global $inputSet;

    for($i = 0; $i < count($inputSet); $i++)
    {
        if ($inputSet[$i][0] == $rowNo && $inputSet[$i][1] == $colChr)
            return $i;
    }

    if ($rowNo >= 14 && $colChr == "B")
        return -2;

    if ($rowNo >= 14 && $colChr == "D")
        return -3;

    if ($rowNo >= 14 && $colChr == "E")
        return -4;

    return -1;
}

function GetMaxDay($year, $month)
{
    switch ($month)
    {
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
            return 31;
        case 2:
            return $year % 4 == 0 ? 29 : 28;
        default:
            return 30;
    }
}

function SelectPelajaran()
{
    global $nip, $idkelas, $idpelajaran, $selpelajaran;

    $sql = "SELECT ta.departemen
              FROM jbsakad.kelas k, jbsakad.tahunajaran ta
             WHERE k.idtahunajaran = ta.replid
               AND k.replid = $idkelas";
    $departemen = FetchSingle($sql);

    $sql = "SELECT g.idpelajaran, p.nama
              FROM jbsakad.guru g, jbsakad.pelajaran p 
             WHERE g.idpelajaran = p.replid
               AND p.departemen = '$departemen'
               AND g.nip = '$nip'
             ORDER BY p.nama";
    $res = QueryDb($sql);

    $idpelajaran = 0;

    $select = "<select name='pelajaran' id='pelajaran' onchange='changePelajaran()' style='width: 200px; background-color: #f9ffc9;'>";
    while($row = mysqli_fetch_row($res))
    {
        $selected = "";
        $idpel = $row[0];
        $nmpel = $row[1];

        if ($idpelajaran == 0)
            $idpelajaran = $idpel;

        if (strtolower($selpelajaran) == strtolower($nmpel))
        {
            $idpelajaran = $idpel;
            $selected = "selected";
        }

        $select .= "<option value='$idpel' $selected>$nmpel</option>";
    }
    $select .= "</select>";

    return $select;
}

function SelectAspek()
{
    global $idpelajaran, $idtingkat, $nip, $idaspek, $selaspek;

    $sql = "SELECT DISTINCT ju.info1, dp.keterangan
              FROM jbsakad.jenisujian ju, jbsakad.dasarpenilaian dp
             WHERE ju.info1 = dp.dasarpenilaian
               AND ju.idpelajaran = $idpelajaran
             ORDER BY dp.keterangan";

    $sql = "SELECT DISTINCT a.dasarpenilaian, dp.keterangan 
				   FROM jbsakad.aturannhb a, dasarpenilaian dp
				  WHERE idpelajaran = '$idpelajaran' 
				    AND a.dasarpenilaian = dp.dasarpenilaian 
				    AND idtingkat = '$idtingkat' 
				    AND nipguru = '$nip' 
				  ORDER BY keterangan";
    $res = QueryDb($sql);

    $idaspek = "";

    $select = "<select name='aspek' id='aspek' onchange='changeAspek()' style='width: 200px; background-color: #f9ffc9;'>";
    while($row = mysqli_fetch_row($res))
    {
        $selected = "";
        $idasp = $row[0];
        $nmasp = $row[1];

        if ($idaspek == "") $idaspek = $idasp;
        if (strtolower($selaspek) == strtolower($nmasp))
        {
            $selected = "selected";
            $idaspek = $idasp;
        }

        $select .= "<option value='$idasp' $selected>$nmasp</option>";
    }
    $select .= "</select>";

    return $select;
}

function SelectJenisUjian()
{
    global $nip, $idpelajaran, $idaspek, $idkelas, $seljenis;

    $sql = "SELECT DISTINCT a.replid, ju.jenisujian
              FROM jbsakad.aturannhb a, jbsakad.jenisujian ju, jbsakad.kelas k 
             WHERE a.idjenisujian = ju.replid
               AND k.idtingkat = a.idtingkat
               AND a.idpelajaran = '$idpelajaran'
               AND a.dasarpenilaian = '$idaspek'
               AND a.nipguru = '$nip'
               AND k.replid = '$idkelas'";
    $res = QueryDb($sql);

    $select = "<select name='idaturan' id='idaturan' style='width: 200px; background-color: #f9ffc9;'>";
    while($row = mysqli_fetch_row($res))
    {
        $selected = "";

        $idju = $row[0];
        $nmju = $row[1];

        if (strtolower($seljenis) == strtolower($nmju)) $selected = "selected";

        $select .= "<option value='$idju' $selected>$nmju</option>";
    }
    $select .= "</select>";

    return $select;
}

function SelectRpp()
{
    global $idpelajaran, $idtingkat, $idsemester;

    $sql = "SELECT replid, rpp 
              FROM rpp 
             WHERE idtingkat = '$idtingkat' 
               AND idsemester = '$idsemester' 
               AND idpelajaran = '$idpelajaran' 
               AND aktif = 1 
             ORDER BY rpp";
    $res = QueryDb($sql);

    $select = "<select name='idrpp' id='idrpp' style='width: 200px; background-color: #f9ffc9;'>";
    $select .= "<option value='-1' selected>(Tanpa RPP)</option>";
    while($row = mysqli_fetch_row($res))
    {
        $idrpp = $row[0];
        $nmrpp = $row[1];

        $select .= "<option value='$idrpp'>$nmrpp</option>";
    }
    $select .= "</select>";

    return $select;
}

function SafeText($text)
{
    $text = str_replace("'", "`", $text);
    $text = str_replace("<", "&lt;", $text);
    $text = str_replace(">", "&gt;", $text);
    return $text;
}
?>
