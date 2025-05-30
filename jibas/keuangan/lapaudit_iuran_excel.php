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

$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

$tanggal1 = "";
if (isset($_REQUEST['tanggal1']))
	$tanggal1 = $_REQUEST['tanggal1'];

$tanggal2 = "";
if (isset($_REQUEST['tanggal2']))
	$tanggal2 = $_REQUEST['tanggal2'];

$idtahunbuku = 0;
if (isset($_REQUEST['idtahunbuku']))
	$idtahunbuku = $_REQUEST['idtahunbuku'];	

$calon = "";
if (isset($_REQUEST['calon']))
	$calon = $_REQUEST['calon'];

if ($calon == "calon"){ 
	$judul = "Calon ";
	$judul2 = "Calon";
}
$filename = "Laporan_Audit_Iuran_".$judul2."Siswa.xls";
/**/
header('Content-Type: application/vnd.ms-excel'); //IE and Opera  
header('Content-Type: application/x-msexcel'); // Other browsers  
header('Content-Disposition: attachment; filename='.$filename);
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		
$tgl1 = explode(' ',$tanggal1);
$tgl2 = explode(' ',$tanggal2);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS KEU [Laporan Audit Perubahan Data Iuran Sukarela <?=$judul?>Siswa]</title>
</head>

<body>
<center><font size="4" face="Verdana"><strong>LAPORAN AUDIT PERUBAHAN DATA IURAN SUKARELA <?=strtoupper($judul)?>SISWA</strong></font><br /> 
</center>
<br /><br />

<table border="0">
<tr>
	<td width="90"><font size="2" face="Arial"><strong>Departemen </strong></font></td>
    <td><font size="2" face="Arial"><strong>: 
      <?=$departemen ?>
    </strong></font></td>
</tr>
<tr>
	<td width="90"><font size="2" face="Arial"><strong>Tanggal </strong></font></td>
    <td><font size="2" face="Arial"><strong>: 
      <?=LongDateFormat($tgl1[0]) . " s/d " . LongDateFormat($tgl2[0]) ?>
    </strong></font></td>
</tr>
</table>
<br />
<table class="tab" id="table" border="1" width="100%" align="left" cellpadding="5" cellspacing="0">
<tr height="30" align="center">
	<td width="4%" bgcolor="#CCCCCC" class="header"><strong><font size="2" face="Arial">No</font></strong></td>
    <td width="15%" bgcolor="#CCCCCC" class="header"><strong><font size="2" face="Arial">Status Data</font></strong></td>
    <td width="10%" bgcolor="#CCCCCC" class="header"><strong><font size="2" face="Arial">Tanggal</font></strong></td>
    <td width="15%" bgcolor="#CCCCCC" class="header"><strong><font size="2" face="Arial">Jumlah</font></strong></td>
    <td width="*" bgcolor="#CCCCCC" class="header"><strong><font size="2" face="Arial">Keterangan</font></strong></td>
    <td width="15%" bgcolor="#CCCCCC" class="header"><strong><font size="2" face="Arial">Petugas</font></strong></td>
</tr>
<?
OpenDb();
$sql = "SELECT DISTINCT ai.petugas as petugasubah, j.transaksi, date_format(ai.tanggal, '%d-%b-%Y %H:%i:%s') as tanggalubah, 
				   ap.replid AS id, ap.idaudit, ap.statusdata, j.nokas, date_format(ap.tanggal, '%d-%b-%Y') AS tanggal, ap.petugas, 
					ap.keterangan, ap.jumlah, ap.petugas, ai.alasan 
			 FROM auditpenerimaaniuran$calon ap, auditinfo ai, jurnal j 
			WHERE j.replid = ap.idjurnal AND j.idtahunbuku = '$idtahunbuku' AND ap.idaudit = ai.replid AND ai.departemen = '$departemen' 
			  AND ai.sumber='penerimaaniuran$calon' AND ai.tanggal BETWEEN '$tanggal1 00:00:00' AND '$tanggal2 23:59:59' 
	   ORDER BY ap.idaudit DESC, ai.tanggal DESC, ap.statusdata ASC";
$result = QueryDb($sql);
$cnt = 0;
$no = 0;
while ($row = mysqli_fetch_array($result)) {
	$statusdata = "Data Lama";
	$bgcolor = "#FFFFFF";
	if ($row['statusdata'] == 1) {
		$statusdata = "Data Perubahan";
		$bgcolor = "#FFFFB7";
	}
		
	if ($cnt % 2 == 0) { ?>
	<tr>
		<td rowspan="4" align="center"><font size="2" face="Arial"><strong>
		  <?=++$no ?>
		</strong></font></td>
        <td colspan="6" align="left"><font size="2" face="Arial"><em><strong>Perubahan dilakukan oleh
        <?=$row['petugasubah'] . " tanggal " . $row['tanggalubah'] ?>
        </strong></em></font></td>
	</tr>
    <tr>
    	<td colspan="6"><font size="2" face="Arial"><strong>No. Jurnal :</strong>
        <?=$row['nokas'] ?>
&nbsp;&nbsp;<strong>Alasan : </strong>
<?=$row['alasan'];?>
        <br />
        <strong>Transaksi :</strong> 
        <?=$row['transaksi'] ?>
    	</font></td>
    </tr>
<?  } ?>
	<tr>
		<td><font size="2" face="Arial">
	    <?=$statusdata ?>
		</font></td>
	    <td align="center"><font size="2" face="Arial">
        <?=$row['tanggal'] ?>
	    </font></td>
	    <td align="right"><font size="2" face="Arial">
        <?=$row['jumlah'] ?>
	    </font></td>
	    <td><font size="2" face="Arial">
        <?=$row['keterangan'] ?>
	    </font></td>
	    <td align="center"><font size="2" face="Arial">
        <?=$row['petugas']; ?>
	    </font></td>
	</tr>
<?
	$cnt++;
}
CloseDb();
?>
</table>
</body>
</html>
<script language="javascript">window.print();</script>