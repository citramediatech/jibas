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
require_once('../cek.php');

if(isset($_REQUEST["tingkat"]))
	$tingkat = $_REQUEST["tingkat"];
if(isset($_REQUEST["semester"]))
	$semester = $_REQUEST["semester"];
if(isset($_REQUEST["pelajaran"]))
	$pelajaran = $_REQUEST["pelajaran"];

OpenDb();
$sql="SELECT t.tingkat, p.nama FROM tingkat t, pelajaran p WHERE p.replid='$pelajaran' AND t.replid='$tingkat'";
$result=QueryDb($sql);
$row = mysqli_fetch_array($result);
$namatingkat = $row['tingkat'];
$namapelajaran = $row['nama'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Menu</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style/style.css">
<script language="JavaScript" src="../script/tables.js"></script>
<script language="JavaScript">

function pilih(tingkat,rpp){
	parent.content.location.href="ujian_rpp_kelas_content.php?tingkat="+tingkat+"&rpp="+rpp;
}
</script>
</head>
<body topmargin="5" leftmargin="5" style="background-color: #f5f5f5; line-height: 22px;">
<?
//$query_aturan = "SELECT DISTINCT u.idrpp, r.rpp FROM ujian u, rpp r WHERE u.idrpp = r.replid AND r.idtingkat = $tingkat AND r.idsemester = $semester AND r.idpelajaran = $pelajaran AND r.aktif = 1 ORDER BY koderpp";
$query_aturan = "SELECT * FROM rpp r WHERE r.idtingkat = '$tingkat' AND r.idsemester = '$semester' AND r.idpelajaran = '$pelajaran' AND r.aktif = 1 ORDER BY koderpp";

$result_aturan = QueryDb($query_aturan);
if (!mysqli_num_rows($result_aturan)==0){ ?>

<strong>RPP:</strong>
<table class="tab" id="table" border="1" style="border-collapse:collapse; border-width: 1px; border-color: #f5f5f5;"  width="100%" align="left" bordercolor="#000000">
<!-- TABLE CONTENT -->


<tr style="height: 2px">
    <td></td>
</tr>	
<? 
	$i=0;
	$cnt = 0;
	while ($row_aturan=@mysqli_fetch_array($result_aturan)){
		if ($i>=5)
			$i=0;
		
?>
<tr style="height: 25px;">
    <td align="left" height="25" onclick="pilih(<?=$tingkat?>,<?=$row_aturan['replid']?>)" style="cursor:pointer"><?=$row_aturan['rpp']?>
    </td>
</tr>
<!-- END TABLE CONTENT -->
<?
  		$i++;
 	} 
?>	
</table>
<script language='JavaScript'>
	Tables('table', 1, 0);
</script>
<? 
	CloseDb(); 
	} else { 
?>
<table width="100%" border="0" align="center">          
<tr>
    <td align="center" valign="middle" height="200">
    <br />
    <font color ="red" size="2"><b>Tidak ditemukan adanya data. <br /><br />Tambah Rencana Program Pembelajaran di menu Rencana Program Pembelajaran (RPP) pada bagian Guru & Pelajaran.
    </b></font>
    </td>
</tr>
</table> 
<? } ?> 
</body>
</html>