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
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');
require_once('presensikeg.siswa2.func.php');

$idkegiatan = $_REQUEST['idkegiatan'];
$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];

OpenDb();

$sql = "SELECT departemen
          FROM jbssat.frkegiatan
         WHERE replid = $idkegiatan";
$res = QueryDb($sql);
$row = mysqli_fetch_row($res);
$departemen = $row[0];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Presensi Kegiatan Siswa</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../script/themes/ui-lightness/jquery-ui.css">
<script src="../script/jquery-1.9.1.js"></script>
<script src="../script/jquery-ui-1.10.3.custom.min.js"></script>
<script src="presensikeg.siswa2.siswa.js"></script>
<script src="../script/tools.js"></script>
<script src="../script/tables.js"></script>
    
<body topmargin="0" leftmargin="0">
<input type='hidden' id='idkegiatan' value='<?=$idkegiatan?>'>
<input type='hidden' id='bulan' value='<?=$bulan?>'>
<input type='hidden' id='tahun' value='<?=$tahun?>'>

<div id='tabs'>
    <ul>
        <li><a href="#tabs-1">Pilih Siswa</a></li>
        <li><a href="#tabs-2">Cari Siswa</a></li>
    </ul>
    <div id='tabs-1'>
        <table border='0' width='100%'>
        <tr>
            <td width='100' align='right'>
                <strong>Departemen :</strong>
            </td>
            <td align='left'>
        <?      $json = json_decode(GetCbDepartemen($departemen));
                $departemen = $json->value;
                echo $json->selection;  ?>
            </td>
        </tr>
        <tr>
            <td align='right'>
                <strong>Tingkat :</strong>
            </td>
            <td align='left'>
                <span id='divCbTingkat'>
        <?      $json = json_decode(GetCbTingkat($departemen, 0));
                $idtingkat = $json->value;
                echo $json->selection;   ?>
                </span>
            </td>
        </tr>
        <tr>
            <td align='right'>
                <strong>Kelas :</strong>
            </td>
            <td align='left'>
                <span id='divCbKelas'>
        <?      $json = json_decode(GetCbKelas($idtingkat, 0));
                $idkelas = $json->value;
                echo $json->selection; ?>
                </span>
            </td>
        </tr>
        <tr>
            <td colspan='2' align='left'>
            <span id='divSiswa'>
        <?      echo GetSiswa($idkegiatan, $bulan, $tahun, $idkelas); ?>        
            </span>    
            </td>
        </tr>
        </table>
    </div>
    <div id='tabs-2'>
        <table border='0' width='100%'>
        <tr>
            <td width='120' align='right'>
                <strong>Departemen :</strong>
            </td>
            <td align='left'>
        <?      $json = json_decode(GetCbDepartemen($departemen, "cbDepartemen2"));
                $departemen = $json->value;
                echo $json->selection;  ?>
            </td>
        </tr>
        <tr>
            <td align='right'>
                <strong>Cari
                <select id='cbFilter' onchange="cbFilterChange()">
                    <option value='nama'>Nama</option>
                    <option value='nis'>NIS</option>
                </select>&nbsp;:
                </strong>
            </td>
            <td align='left'>
                <input type='text' id='txKeyword' style='width: 100px' onkeyup='txKeywordKeyUp(event)'>
                <input type='button' id='btCari' class='but'
                       style='width: 40px' value='Cari' onclick='btCariClick()'>
            </td>
        </tr>
        <tr>
            <td colspan='2' align='center'>
                <span id='lbError' style='color: red'></span>                
            </td>
        </tr>
        <tr>
            <td colspan='2' align='left'>
            <span id='divSiswa2'>
                
            </span>    
            </td>
        </tr>
        </table>
    </div>
</div>

</body>
</html>
<?
CloseDb();
?>
<script language='JavaScript'>
    Tables('table', 1, 0);
</script>