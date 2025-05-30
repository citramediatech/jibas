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
require_once('../library/datearith.php');
require_once('../sessionchecker.php');
require_once('../include/getheader.php');

OpenDb();

$nis = $_REQUEST['nis'];
$idkegiatan = $_REQUEST['idkegiatan'];
$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];

$sql = "SELECT departemen
          FROM jbsakad.tahunajaran t, jbsakad.kelas k, jbsakad.siswa s
         WHERE s.nis = '$nis'
           AND s.idkelas = k.replid
           AND k.idtahunajaran = t.replid";
$res = QueryDb($sql);
$row = mysqli_fetch_row($res);
$departemen = $row[0];

$sql = "SELECT nama
          FROM jbsakad.siswa
         WHERE nis = '$nis'";   
$res = QueryDB($sql);	
$row = mysqli_fetch_row($res);
$nama = $row[0];
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS INFOGURU [Cetak Laporan Presensi Kegiatan Siswa]</title>
</head>

<body>
    
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr>
	<td align="left" valign="top" colspan="2">
		<?=getHeader($departemen)?>
		<center>
			<font size="4"><strong>LAPORAN PRESENSI KEGIATAN SISWA</strong></font><br />
		</center>
		<br /><br />
	</td>
</tr>	
<tr>
	<td width='60'><strong>Siswa</strong></td>
    <td><strong>: <?= $nis . ' - ' . $nama ?></strong></td>
</tr>
<tr>
	<td align="left" valign="top" colspan="2">

<?
	$showbutton = false;
	require_once("presensikeg.siswa2.report.func.php");
?>        
    </td>
</tr>	        
</table>

</body>
</html>
<script type="text/javascript">
	window.print();
</script>