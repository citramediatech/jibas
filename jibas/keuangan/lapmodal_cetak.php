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
require_once('include/errorhandler.php');
require_once('include/sessionchecker.php');
require_once('include/common.php');
require_once('include/rupiah.php');
require_once('include/config.php');
require_once('include/db_functions.php');
require_once('include/getheader.php'); 

$tanggal1 = "";
if (isset($_REQUEST['tanggal1']))
	$tanggal1 = $_REQUEST['tanggal1'];
    
$tanggal2 = "";
if (isset($_REQUEST['tanggal2']))
	$tanggal2 = $_REQUEST['tanggal2'];

$bln = 0;
if (isset($_REQUEST['bln']))
	$bln = (int)$_REQUEST['bln'];

$thn = 0;
if (isset($_REQUEST['thn']))
	$thn = (int)$_REQUEST['thn'];
	
$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

$idtahunbuku = 0;
if (isset($_REQUEST['idtahunbuku']))
	$idtahunbuku = (int)$_REQUEST['idtahunbuku'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS KEU [Laporan Perubahan Modal]</title>
<script language="javascript" src="script/tables.js"></script>
<script language="javascript" src="script/tools.js"></script>
</head>

<body>

<?
OpenDb();
$first_date = "$thn-$bln-1";
$sql = "SELECT date_sub('$first_date', INTERVAL 1 DAY)";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$last_date = $row[0];

$sql = "SELECT SUM(jd.kredit - jd.debet) FROM rekakun ra, jurnal j, jurnaldetail jd 
		WHERE jd.idjurnal = j.replid AND jd.koderek = ra.kode AND j.idtahunbuku = '$idtahunbuku' AND 
			  j.tanggal BETWEEN '$tanggal1' AND '$last_date' AND ra.kategori IN ('PENDAPATAN', 'MODAL')";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$totalpendapatan = (float)$row[0];

$sql = "SELECT SUM(jd.debet - jd.kredit) FROM rekakun ra, jurnal j, jurnaldetail jd 
	    WHERE jd.idjurnal = j.replid AND jd.koderek = ra.kode AND j.idtahunbuku = '$idtahunbuku' AND 
		      j.tanggal BETWEEN '$tanggal1' AND '$last_date' AND ra.kategori = 'BIAYA'";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$totalbiaya = (float)$row[0];

$modalawal = $totalpendapatan - $totalbiaya;

$sql = "SELECT SUM(jd.kredit - jd.debet) FROM rekakun ra, jurnal j, jurnaldetail jd 
	    WHERE jd.idjurnal = j.replid AND jd.koderek = ra.kode AND j.idtahunbuku = '$idtahunbuku' AND 
		      j.tanggal BETWEEN '$first_date' AND '$tanggal2' AND ra.kategori = 'MODAL' AND jd.kredit > 0";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$jinvestasi = (float)$row[0];

$sql = "SELECT SUM(jd.debet - jd.kredit) FROM rekakun ra, jurnal j, jurnaldetail jd 
	    WHERE jd.idjurnal = j.replid AND jd.koderek = ra.kode AND j.idtahunbuku = '$idtahunbuku' AND 
		      j.tanggal BETWEEN '$first_date' AND '$tanggal2' AND ra.kategori = 'MODAL' AND jd.debet > 0";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$jpengambilan = (float)$row[0];

$sql = "SELECT SUM(jd.kredit - jd.debet) FROM rekakun ra, jurnal j, jurnaldetail jd 
        WHERE jd.idjurnal = j.replid AND jd.koderek = ra.kode AND j.idtahunbuku = '$idtahunbuku' AND 
		      j.tanggal BETWEEN '$first_date' AND '$tanggal2' AND ra.kategori = 'PENDAPATAN'";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$jpendapatan = (float)$row[0];

$sql = "SELECT SUM(jd.debet - jd.kredit) FROM rekakun ra, jurnal j, jurnaldetail jd 
        WHERE jd.idjurnal = j.replid AND jd.koderek = ra.kode AND j.idtahunbuku = '$idtahunbuku' AND 
		      j.tanggal BETWEEN '$first_date' AND '$tanggal2' AND ra.kategori = 'BIAYA'";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$jbiaya = (float)$row[0];

$jincome = $jpendapatan - $jbiaya;

$modalakhir = (float)$modalawal + (float)$jinvestasi - (float)$jpengambilan + (float)$jincome;
?>

<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr><td align="left" valign="top">

<?=getHeader($departemen)?>

<center><font size="4"><strong>LAPORAN PERUBAHAN MODAL</strong></font><br /> </center><br /><br />

<table border="0">
<tr>
	<td width="90"><strong>Departemen </strong></td>
    <td><strong>: <?=$departemen ?></strong></td>
</tr>
<tr>
	<td><strong>Per Tanggal </strong></td>
    <td><strong>: <?=LongDateFormat($tanggal2) ?></strong></td>
</tr>
</table>
<br />
<table border="1" cellpadding="8" cellspacing="5" width="85%" align="center">
<tr>
	<td width="*">Modal di awal <?=NamaBulan($bln) . " " . $thn?></td>
    <td align="right" width="200"><?=FormatRupiah($modalawal) ?></td>
    <td width="5">&nbsp;</td>
</tr>
<tr>
	<td>Investasi pada <?=NamaBulan($bln) . " " . $thn?></td>
    <td align="right"><?=FormatRupiah($jinvestasi) ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>Pengambilan pada <?=NamaBulan($bln) . " " . $thn?></td>
    <td align="right"><?=FormatRupiah(-1 * $jpengambilan) ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>Rugi / Laba pada <?=NamaBulan($bln) . " " . $thn?></td>
    <td align="right"><?=FormatRupiah($jincome) ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td colspan="2">
    <hr width="100%" style="color:#000000; border-style:dashed; line-height:1px;" />
    </td>
    <td><font size="3"><strong>+</strong></font></td>
</tr>
<tr>
	<td>&nbsp;&nbsp;<font size="2"><strong>Modal per tanggal  <?=LongDateFormat($tanggal2) ?></strong></font></td>
    <td align="right"><font size="2"><strong><?=FormatRupiah($modalakhir) ?></strong></font></td>
</tr>
</table>
</td></tr>
</table>


</td></tr></table>

<script language="javascript">window.print();</script>

</body>
</html>