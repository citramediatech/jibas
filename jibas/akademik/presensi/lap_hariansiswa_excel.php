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

header('Content-Type: application/vnd.ms-excel'); //IE and Opera  
header('Content-Type: application/x-msexcel'); // Other browsers  
header('Content-Disposition: attachment; filename=PresensiHarianSiswa.xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

$nis = $_REQUEST['nis'];
$tglawal = $_REQUEST['tglawal'];
$tglakhir = $_REQUEST['tglakhir'];
$urut = $_REQUEST['urut'];
$urutan = $_REQUEST['urutan'];


OpenDb();
$sql = "SELECT nama FROM siswa WHERE nis='$nis'";   
$result = QueryDB($sql);	
$row = mysqli_fetch_array($result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Cetak Laporan Presensi Harian Siswa]</title>
<style type="text/css">
<!--
.style3 {font-family: Verdana; font-weight: bold; font-size: 12px; }
.style4 {color: #FFFFFF}
.style5 {font-family: Verdana}
.style8 {
	font-family: Verdana;
	font-size: 16px;
}
.style10 {font-size: 14px; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <th scope="row" colspan="2"><span class="style8">Laporan Presensi Harian Siswa</span></th>
  </tr>
</table>
<br />
<table width="17%">
<tr>
	<td width="65%"><span class="style3">Siswa</span></td>
    <td width="35%" colspan="3"><span class="style3">: 
      <?=$nis.' - '.$row['nama']?>
    </span></td>
</tr>
<!--<tr>
	<td><strong>Nama</strong></td>
    <td><strong>: <?=$row['nama']?></strong></td>
</tr>-->
<tr>
	<td><span class="style3">Periode Presensi</span></td>
    <td  colspan="3"><span class="style3">: <?=format_tgl($tglawal).' s/d '. format_tgl($tglakhir) ?></span></td>
</tr>
</table>
<br />
<? 	OpenDb();
	$sql = "SELECT DAY(p.tanggal1), MONTH(p.tanggal1), YEAR(p.tanggal1), DAY(p.tanggal2), MONTH(p.tanggal2), YEAR(p.tanggal2), ph.hadir, ph.ijin, ph.sakit, ph.alpa, ph.cuti, ph.keterangan, s.nama, m.semester, k.kelas FROM presensiharian p, phsiswa ph, siswa s, semester m, kelas k WHERE ph.idpresensi = p.replid AND ph.nis = s.nis AND ph.nis = '$nis' AND p.idsemester = m.replid AND p.idkelas = k.replid AND (((p.tanggal1 BETWEEN '$tglawal' AND '$tglakhir') OR (p.tanggal2 BETWEEN '$tglawal' AND '$tglakhir')) OR (('$tglawal' BETWEEN p.tanggal1 AND p.tanggal2) OR ('$tglakhir' BETWEEN p.tanggal1 AND p.tanggal2))) ORDER BY $urut $urutan ";
	
	$result = QueryDb($sql);
	$jum = mysqli_num_rows($result);
	if ($jum > 0) { 
?>
	<table class="tab" id="table" border="1" cellpadding="2" style="border-collapse:collapse" cellspacing="2" width="100%" align="left">
  <tr height="30" align="center">
    	<td width="5%" bgcolor="#CCCCCC" class="style5 style4 header"><span class="style10">No</span></td>
    <td width="25%" bgcolor="#CCCCCC" class="style5 style4 header"><span class="style10">Tanggal</span></td>
     <td width="8%" bgcolor="#CCCCCC" class="style5 style4 header"><span class="style10">Semester</span></td>
    <td width="8%" bgcolor="#CCCCCC" class="style5 style4 header"><span class="style10">Kelas</span></td>
    <td width="5%" bgcolor="#CCCCCC" class="style5 style4 header"><span class="style10">Hadir</span></td>
    <td width="5%" bgcolor="#CCCCCC" class="style5 style4 header"><span class="style10">Ijin</span></td>            
    <td width="5%" bgcolor="#CCCCCC" class="style5 style4 header"><span class="style10">Sakit</span></td>
    <td width="5%" bgcolor="#CCCCCC" class="style5 style4 header"><span class="style10">Alpa</span></td>
    <td width="5%" bgcolor="#CCCCCC" class="style5 style4 header"><span class="style10">Cuti</span></td>
    <td width="*" bgcolor="#CCCCCC" class="style5 style4 header"><span class="style10">Keterangan</span></td>      
    </tr>
<?		
	$cnt = 0;
	$h=0;
	$i=0;
	$s=0;
	$a=0;
	$c=0;
	while ($row = mysqli_fetch_row($result)) { ?>
    <tr height="25">    	
    	<td align="center"><?=++$cnt?></td>
		<td align="center"><?=$row[0].' '.$bulan[$row[1]].' '.$row[2].' - '.$row[3].' '.$bulan[$row[4]].' '.$row[5]?></td>
        <td align="center"><?=$row[13]?></td>
        <td align="center"><?=$row[14]?></td>
        <td align="center"><?=$row[6]?></td>
		<td align="center"><?=$row[7]?></td>
       	<td align="center"><?=$row[8]?></td> 
        <td align="center"><?=$row[9]?></td>
        <td align="center"><?=$row[10]?></td>
       
        <td><?=$row[11]?></td>
    </tr>
<?	
	$h+=$row[6];
	$i+=$row[7];
	$s+=$row[8];
	$a+=$row[9];
	$c+=$row[10];
	} 
	CloseDb() ?>
    <tr>	
		<td width="5%" colspan="4" align="right" bgcolor="#CCCCCC"><strong>Jumlah&nbsp;&nbsp;</strong></td>
   		<td width="5%" height="25" align="center"><?=$h?></td>
		<td width="5%" height="25" align="center"><?=$i?></td>            
		<td width="5%" height="25" align="center"><?=$s?></td>
        <td width="5%" height="25" align="center"><?=$a?></td>
        <td width="5%" height="25" align="center"><?=$c?></td>      
        <td width="*" bgcolor="#CCCCCC"></td>
    </tr>	
    <!-- END TABLE CONTENT -->
    </table>	
<? 	} ?>


<script language="javascript">
window.print();
</script>

</html>