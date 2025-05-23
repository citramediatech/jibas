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
require_once('../include/config.php');
require_once('../include/common.php');
require_once('../include/db_functions.php');
require_once('infosiswa.session.php');
require_once('infosiswa.security.php');

$nis = $_SESSION["infosiswa.nis"];

$bulan = isset($_REQUEST['bulan']) ? $_REQUEST['bulan'] : date('n');
$tahun = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date('Y');

OpenDb();
?>
<link href="../style/style.css" rel="stylesheet" type="text/css">
<div align="left" style="margin-left:1px">
<br />
<form name="panelpk" id="panelpk" method="post">
<table width="100%" cellpadding="0" cellspacing="0">    
<tr><td width="0" align="left">
Bulan:
<select id='pk_cbBulan' onchange='pk_changeBulan()'>
    <option value='1' <?=IntIsSelected(1, $bulan)?>>Januari</option>
    <option value='2' <?=IntIsSelected(2, $bulan)?>>Februari</option>
    <option value='3' <?=IntIsSelected(3, $bulan)?>>Maret</option>
    <option value='4' <?=IntIsSelected(4, $bulan)?>>April</option>
    <option value='5' <?=IntIsSelected(5, $bulan)?>>Mei</option>
    <option value='6' <?=IntIsSelected(6, $bulan)?>>Juni</option>
    <option value='7' <?=IntIsSelected(7, $bulan)?>>Juli</option>
    <option value='8' <?=IntIsSelected(8, $bulan)?>>Agustus</option>
    <option value='9' <?=IntIsSelected(9, $bulan)?>>September</option>
    <option value='10' <?=IntIsSelected(10, $bulan)?>>Oktober</option>
    <option value='11' <?=IntIsSelected(11, $bulan)?>>Nopember</option>
    <option value='12' <?=IntIsSelected(12, $bulan)?>>Desember</option>
</select>
<select id='pk_cbTahun' onchange='pk_changeBulan()'>
<?  for($i = $G_START_YEAR; $i <= date('Y') + 1; $i++) { ?>
    <option value='<?=$i?>' <?=IntIsSelected($i, $tahun)?>><?=$i?></option>
<?  } ?>
</select>
</td></tr>
<tr><td align='left'>
<?
require_once("infosiswa.presensikegiatan.func.php");
?>
</td></tr>
</table>
</form> 
</div>
<?
CloseDb();
?>