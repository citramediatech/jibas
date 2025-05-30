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
require_once('../include/errorhandler.php');
require_once('../include/sessionchecker.php');
require_once('../include/config.php');
require_once('../include/common.php');
require_once('../include/db_functions.php');
require_once("rekapall.reportlist.func.php");

header('Content-Type: application/vnd.ms-excel'); //IE and Opera  
header('Content-Type: application/x-msexcel'); // Other browsers  
header('Content-Disposition: attachment; filename=Rekap_Presensi_Semua_Pegawai.xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS Kepegawaian</title>
<style type="text/css">
<!--
.style1 {
	font-size: 24px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<?
$tahun30 = $_REQUEST['tahun30'];
$bulan30 = $_REQUEST['bulan30'];
$tanggal30 = $_REQUEST['tanggal30'];
$tahun = $_REQUEST['tahun'];
$bulan = $_REQUEST['bulan'];
$tanggal = $_REQUEST['tanggal'];

OpenDb();
?>
<strong>Tanggal: <?= $tanggal30 . " " . NamaBulan($bulan30) . " " . $tahun30 . " s/d " . $tanggal . " " . NamaBulan($bulan) . " " . $tahun ?></strong><br /><br />
<br><strong>Hadir:</strong><br>
<? ShowReportList(1); ?>

<br><strong>Izin:</strong><br>
<? ShowReportList(2); ?>

<br><strong>Sakit:</strong><br>
<? ShowReportList(3); ?>

<br><strong>Cuti:</strong><br>
<? ShowReportList(4); ?>

<br><strong>Alpa:</strong><br>
<? ShowReportList(5); ?>

<br><strong>Bebas:</strong><br>
<? ShowReportList(6); ?>

<?
CloseDb();
?>
</body>
</html>