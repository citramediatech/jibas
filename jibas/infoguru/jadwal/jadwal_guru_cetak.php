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
require_once('../include/getheader.php');
require_once("../include/sessionchecker.php");

OpenDb();

$kelompokJam = NULL;
$jam = NULL;
$jadwal = NULL;

if (isset($_REQUEST['info']))
	$info = $_REQUEST['info'];
if (isset($_REQUEST['nip']))
	$nip = $_REQUEST['nip'];
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

OpenDb();	
function loadJam($id) {	
	$sql = "SELECT jamke, TIME_FORMAT(jam1, '%H:%i'), TIME_FORMAT(jam2, '%H:%i') ".
	       "FROM jam WHERE departemen = '$id' ORDER BY jamke";
	
	$result = QueryDb($sql);
	$GLOBALS['maxJam'] = mysqli_num_rows($result);
	
	while($row = mysqli_fetch_array($result)) {
		$GLOBALS['jam']['row'][$row[0]]['jam1'] = $row[1];
		$GLOBALS['jam']['row'][$row[0]]['jam2'] = $row[2];
	}
	return true;
}

function loadJadwal() {	
	$sql = "SELECT j.replid AS id, j.hari AS hari, j.jamke AS jam, j.njam AS njam, j.keterangan AS ket, ".
	       "l.nama AS pelajaran, k.kelas, ".
	       "CASE j.status WHEN 0 THEN 'Mengajar' WHEN 1 THEN 'Asistensi' WHEN 2 THEN 'Tambahan' END AS status ".
	       "FROM jadwal j, pelajaran l, kelas k ".
	       "WHERE j.nipguru = '".$_REQUEST['nip']."'".
	       " AND j.departemen = '".$_REQUEST['departemen']."'".
	       " AND j.infojadwal = '".$_REQUEST['info']."'".
	       " AND j.idkelas = k.replid ".
	       " AND j.idpelajaran = l.replid";
	
	$result = QueryDb($sql);
	
	while($row = mysqli_fetch_assoc($result)) {
		$GLOBALS['jadwal']['row'][$row['hari']][$row['jam']]['id'] = $row['id'];
		$GLOBALS['jadwal']['row'][$row['hari']][$row['jam']]['njam'] = $row['njam'];
		$GLOBALS['jadwal']['row'][$row['hari']][$row['jam']]['pelajaran'] = $row['pelajaran'];
		$GLOBALS['jadwal']['row'][$row['hari']][$row['jam']]['kelas'] = $row['kelas'];
		$GLOBALS['jadwal']['row'][$row['hari']][$row['jam']]['status'] = $row['status'];
		$GLOBALS['jadwal']['row'][$row['hari']][$row['jam']]['ket'] = $row['ket'];
	}
	return true;
}

function getCell($r, $c) {
	global $mask, $jadwal;
	if($mask[$c] == 0) {
		if(isset($jadwal['row'][$c][$r])) {
			$mask[$c] = $jadwal['row'][$c][$r]['njam'] - 1;
			
			$s = "<td class='jadwal' rowspan='{$jadwal['row'][$c][$r]['njam']}' width='95px'>";
			$s.= "{$jadwal['row'][$c][$r]['kelas']}<br>";
			$s.= "<b>{$jadwal['row'][$c][$r]['pelajaran']}</b><br>";
			$s.= "<i>{$jadwal['row'][$c][$r]['status']}</i><br>{$jadwal['row'][$c][$r]['ket']}<br>";
			$s.= "</td>";
			
			return $s;
		} else {
			$s = "<td class='jadwal' width='95px'>";			
			$s.= "</td>";

			return $s;
		}
	} else {
		--$mask[$c];
	}
}

$mask = NULL;
for($i = 1; $i <= 7; $i++) {
	$mask[$i] = 0;
}

loadJam($departemen);
loadJadwal();


$sql = "SELECT i.deskripsi, p.nip, p.nama, t.tahunajaran FROM infojadwal i, jbssdm.pegawai p, tahunajaran t WHERE i.replid = '$info' AND p.nip = '$nip' AND i.idtahunajaran = t.replid";

$result = QueryDb($sql);
$row = mysqli_fetch_array($result);
//$departemen = $row['departemen'];


?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS INFOGURU [Cetak Jadwal Guru]</title>

<style>
	.jadwal {
		border: 1px solid black;
		text-align: center;
		vertical-align: middle;
	}

	.jam {
		border: 1px solid black;
		height: 50px;
		background-color: #A0A0A0;
		text-align: center;
		vertical-align: middle;
	}
</style>
<!--<script language="javascript" src="../script/tools.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/tables.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/common.js"></script>
<script type="text/javascript" language="javascript">-->
</script>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr><td align="left" valign="top">
<?=getHeader($departemen)?>
<center>
  <font size="4"><strong>JADWAL GURU</strong></font><br />
 </center><br /><br />

<br />
<table>
<tr>
	<td><strong>Guru</strong></td>
    <td><strong>: <?=$row['nip'] ?> - <?=$row['nama'] ?></strong></td>
</tr>
<tr>
	<td><strong>Departemen</strong></td>
    <td><strong>: <?=$departemen?></strong></td>
</tr>
<tr>
	<td><strong>Tahun Ajaran</strong></td>
    <td><strong>: <?=$row['tahunajaran']?></strong></td>
</tr>
<tr>
	<td width="35%"><strong>Info Jadwal</strong></td>
    <td><strong>: <?=$row['deskripsi']?></strong></td>
</tr>
</table>
<br>
<table border="1" width="100%" id="table" class="tab" align="center" cellpadding="2" style="border-collapse:collapse" cellspacing="2" bordercolor="#000000">
<tr>
    <td width="110px" class="header" align="center">Jam</td>
    <td width="95px" class="header" align="center">Senin</td>
    <td width="95px" class="header" align="center">Selasa</td>
    <td width="95px" class="header" align="center">Rabu</td>
    <td width="95px" class="header" align="center">Kamis</td>
    <td width="95px" class="header" align="center">Jumat</td>
    <td width="95px" class="header" align="center">Sabtu</td>
    <td width="95px" class="header" align="center">Minggu</td>
</tr>
<?

if(isset($jam['row'])) {
    
    foreach($jam['row'] as $k => $v) {
    ?> 
    <tr>
        <td class="jam" width="110px"><b><?=++$j ?>.</b> <?=$v['jam1'] ?> - <?=$v['jam2'] ?></td>
        <? for($i = 1; $i <= 7; $i++) {?> 
        <?=getCell($k, $i); ?> 
        <? } ?>  
    </tr>
    <?
    }
	?>
</table>
<? } ?> 
	</td>
<tr>
</table>
</body>
<script language="javascript">
window.print();
</script>
</html>