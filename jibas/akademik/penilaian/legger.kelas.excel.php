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
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/theme.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');
require_once('legger.kelas.content.func.php');

$departemen = $_REQUEST['departemen'];
$tahunajaran = $_REQUEST['tahunajaran'];
$tingkat = $_REQUEST['tingkat'];
$kelas = $_REQUEST['kelas'];
$semester = $_REQUEST['semester'];
$pelajaran = $_REQUEST['pelajaran'];

header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/x-msexcel');
header('Content-Disposition: attachment; filename=LeggerRaporKelas.xls');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

OpenDb();

$sql = "SELECT tahunajaran FROM tahunajaran WHERE replid = '$tahunajaran'";
$res = QueryDb($sql);
$row = mysqli_fetch_row($res);
$ta  = $row[0];

$sql = "SELECT kelas FROM kelas WHERE replid = '$kelas'";
$res = QueryDb($sql);
$row = mysqli_fetch_row($res);
$kls = $row[0];

$sql = "SELECT semester FROM semester WHERE replid = '$semester'";
$res = QueryDb($sql);
$row = mysqli_fetch_row($res);
$sem = $row[0];

if ($pelajaran != 0)
{
    $sql = "SELECT nama FROM pelajaran WHERE replid = '$pelajaran'";
    $res = QueryDb($sql);
    $row = mysqli_fetch_row($res);
    $pel = $row[0];
}
else
{
    $pel = "(Semua Pelajaran)";
}

$arrSiswa = array();
$nisStr = "";
GetDataSiswa();

$arrPel = array();
$idPelStr = "";
GetDataPelajaran();

$arrAspekPel = array();
$arrAspek = array();
GetAspekPelajaran();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Legger Nilai Rapor</title>
</head>
<body>
<table border="0">
    <tr>
        <td colspan="2" align="left"><h3>Legger Nilai Rapor</h3></td>
    </tr>
    <tr>
        <td align="left">Departemen:</td>
        <td align="left"><?=$departemen?></td>
    </tr>
    <tr>
        <td align="left">Tahun Ajaran:</td>
        <td align="left"><?=$ta?></td>
    </tr>
    <tr>
        <td align="left">Kelas:</td>
        <td align="left"><?=$kls?></td>
    </tr>
    <tr>
        <td align="left">Semester:</td>
        <td align="left"><?=$sem?></td>
    </tr>
    <tr>
        <td align="left">Pelajaran:</td>
        <td align="left"><?=$pel?></td>
    </tr>
</table>

<br>

<table border="1" id="table" cellpadding="2" cellspacing="0" width="<?= GetTableWidth() ?>"  style="border-width: 1px; border-collapse:collapse;">
<tr>
    <td width="30" class="header" rowspan="2">No</td>
    <td width="140" class="header" rowspan="2">NIS</td>
    <td width="280" class="header" rowspan="2">Nama</td>
    <?php
    $nPel = count($arrPel);
    for($i = 0; $i < $nPel; $i++)
    {
        $idPel = $arrPel[$i][0];
        $nmPel = $arrPel[$i][1];

        $nAspek = count($arrAspekPel[$idPel]);
        $width = 60 * $nAspek;

        echo "<td width='$width' class='header' align='center' colspan='$nAspek'>$nmPel</td>";
    }

    $nAspek = count($arrAspek);
    $width = 60 * $nAspek;
    echo "<td width='$width' class='header' align='center' colspan='$nAspek'>RATA-RATA</td>";
    ?>
</tr>
<tr>
    <?php
    $nPel = count($arrPel);
    for($i = 0; $i < $nPel; $i++)
    {
        $idPel = $arrPel[$i][0];
        $nAspek = count($arrAspekPel[$idPel]);

        for($j = 0; $j < $nAspek; $j++)
        {
            $kdAspek = $arrAspekPel[$idPel][$j];
            echo "<td width='60' class='header' align='center'>$kdAspek</td>";
        }
    }

    $nAspek = count($arrAspek);
    for($i = 0; $i < $nAspek; $i++)
    {
        $kdAspek = $arrAspek[$i][0];
        echo "<td width='60' class='header' align='center'>$kdAspek</td>";
    }
    ?>
</tr>

<?php
$arrTotalNilaiAspekKelas = array();

$no = 0;
$nSiswa = count($arrSiswa);
for($i = 0; $i < $nSiswa; $i++)
{
    $no += 1;

    $nis = $arrSiswa[$i][0];
    $nama = $arrSiswa[$i][1];
    $arrTotalNilaiAspek = array();

    echo "<tr height='25'>";
    echo "<td align='left'>$no</td>";
    echo "<td align='left'>$nis</td>";
    echo "<td align='left'>$nama</td>";

    $colCnt = -1;
    $nPel = count($arrPel);
    for($j = 0; $j < $nPel; $j++)
    {
        $idPel = $arrPel[$j][0];
        $nAspek = count($arrAspekPel[$idPel]);

        for($k = 0; $k < $nAspek; $k++)
        {
            $colCnt += 1;

            $kdAspek = $arrAspekPel[$idPel][$k];

            $sql = "SELECT n.nilaiangka
                      FROM jbsakad.nap n, jbsakad.infonap i, jbsakad.aturannhb a
                     WHERE n.idinfo = i.replid
                       AND n.idaturan = a.replid
                       AND n.nis = '$nis'
                       AND i.idpelajaran = $idPel
                       AND i.idsemester = $semester
                       AND i.idkelas = $kelas
                       AND a.dasarpenilaian = '$kdAspek'";
            $res = QueryDb($sql);
            $nData = mysqli_num_rows($res);

            $nilai = "";
            if ($row = mysqli_fetch_row($res))
            {
                $nilai = $row[0];

                if (array_key_exists($kdAspek, $arrTotalNilaiAspek))
                {
                    $arrTotalNilaiAspek[$kdAspek][0] += $nilai;
                    $arrTotalNilaiAspek[$kdAspek][1] += 1;
                }
                else
                {
                    $arrTotalNilaiAspek[$kdAspek] = array($nilai, 1);
                }

                if ($no == 1)
                {
                    $arrTotalNilaiAspekKelas[$colCnt] = array($nilai, 1);
                }
                else
                {
                    $arrTotalNilaiAspekKelas[$colCnt][0] += $nilai;
                    $arrTotalNilaiAspekKelas[$colCnt][1] += 1;
                }

                echo "<td align='center'>$nilai</td>";
            }
            else
            {
                echo "<td align='center'>-</td>";
            }
        }
    }

    $nAspek = count($arrAspek);
    for($j = 0; $j < $nAspek; $j++)
    {
        $colCnt += 1;

        $kdAspek = $arrAspek[$j][0];

        $nilai = 0;
        $nNilai = 0;
        if (array_key_exists($kdAspek, $arrTotalNilaiAspek))
        {
            $nilai = $arrTotalNilaiAspek[$kdAspek][0];
            $nNilai = $arrTotalNilaiAspek[$kdAspek][1];
        }

        if ($nNilai > 0)
        {
            $nilai = round($nilai / $nNilai, 2);

            if ($no == 1)
            {
                $arrTotalNilaiAspekKelas[$colCnt] = array($nilai, 1);
            }
            else
            {
                $arrTotalNilaiAspekKelas[$colCnt][0] += $nilai;
                $arrTotalNilaiAspekKelas[$colCnt][1] += 1;
            }
        }

        echo "<td align='center'>$nilai</td>";
    }
    echo "</tr>";
}

//-- Hitung Rata-rata Kelas
$nCol = count($arrTotalNilaiAspekKelas);
echo "<tr height='35'>";
echo "<td align='left' style='background-color: #ddb639; font-weight: bold;' colspan='3'>RATA-RATA KELAS</td>";
for($i = 0; $i < $nCol; $i++)
{
    $rata = "";
    if ($arrTotalNilaiAspekKelas[$i][1] > 0)
        $rata = round($arrTotalNilaiAspekKelas[$i][0] / $arrTotalNilaiAspekKelas[$i][1], 2);

    echo "<td align='center' style='background-color: #ddb639; font-weight: bold;'>$rata</td>";
}
//$nAspek = count($arrAspek);
//echo "<td align='center' style='background-color: #ddb639; font-weight: bold;' colspan='$nAspek'>&nbsp;</td>";
echo "</tr>";
?>
</table>
</body>

</html>
<?php
CloseDb();
?>