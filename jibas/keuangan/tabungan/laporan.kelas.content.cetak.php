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
require_once('../include/sessionchecker.php');
require_once('../include/common.php');
require_once('../include/rupiah.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/getheader.php'); 
require_once('../library/jurnal.php');
require_once('laporan.kelas.content.func.php');

$urut = $_REQUEST['urut'];
$urutan = $_REQUEST['urutan'];
$varbaris = $_REQUEST['varbaris'];	
$page = $_REQUEST['page'];
$total = $_REQUEST['total'];

OpenDb();

ReadRequest();
GetNames();

$sql = "SELECT departemen FROM jbsakad.angkatan WHERE replid='$idangkatan'"; 	
$departemen = FetchSingle($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS KEU [Laporan Tabungan Per Kelas]</title>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" align="left">
<tr><td align="left" valign="top">

<?= getHeader($departemen) ?>

<center><font size="4"><strong>LAPORAN TABUNGAN PER KELAS</strong></font><br /> </center><br /><br />
<br />

<table border="0">
<tr>
<td><strong>Departemen:</strong></td>
   <td><?=$departemen?></td>
</tr>
<tr>
	<td><strong>Angkatan:</strong></td>
   <td><?=$namaangkatan?></td>
</tr>
<tr>
	<td><strong>Tingkat:</strong></td>
   <td><?=$namatingkat?></td>
</tr>
<tr>
	<td><strong>Kelas:</strong></td>
   <td><?=$namakelas?></td>
</tr>
</table>
<br>

<?
$pageLimit = false;
require_once("laporan.kelas.content.body.php");
?>
	
</td></tr></table>
</body>
</html>
<script language="javascript">window.print();</script>
<?
CloseDb()
?>