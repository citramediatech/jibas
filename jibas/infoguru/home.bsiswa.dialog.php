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
require_once('include/common.php');
require_once('include/sessioninfo.php');
require_once('include/config.php');
require_once('include/db_functions.php');
require_once('include/sessionchecker.php');

$replid="";
if (isset($_REQUEST['replid']))
	$replid=$_REQUEST['replid'];
	
OpenDb();

$sql_berita="SELECT YEAR(tanggal) as thn,MONTH(tanggal) as bln,DAY(tanggal) as tgl,replid as replid,
                    judul as judul,abstrak as abstrak ,isi as berita,
					idpengirim, idguru, IF(idguru IS NULL, 'S', 'P') AS jenis
               FROM jbsvcr.beritasiswa
              WHERE replid='$replid'";
$result_berita=QueryDb($sql_berita);
$row_berita=@mysqli_fetch_array($result_berita);

$jenis = $row_berita['jenis'];
if ($jenis == "S")
{
	$sql = "SELECT nama
			  FROM jbsakad.siswa
			 WHERE nis = '" . $row_berita['idpengirim'] ."'";
}
else
{
	$sql = "SELECT nama
			  FROM jbssdm.pegawai
			 WHERE nip = '" . $row_berita['idguru'] ."'";
}
$res2 = QueryDb($sql);
$row2 = mysqli_fetch_row($res2);
$nama = $row2[0];

CloseDb();

$tglberita=$row_berita['tgl']." ".NamaBulan($row_berita['bln'] - 1)." ".$row_berita['thn'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Berita Siswa</title>
<script language="javascript" src="script/tools.js"></script>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
.style3 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<table id="Table_01" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<img src="images/BGNews_01.png" width="12" height="11" alt=""></td>
		<td height="11" colspan="2" background="images/BGNews_02.png">			</td>
		<td>
			<img src="images/BGNews_03.png" width="18" height="11" alt=""></td>
	</tr>
	<tr>
	  <td background="images/BGNews_04.png"></td>
	  <td width="570" align="left" background="images/BGNews_05.png">
      <div align="left" style="padding-bottom:10px"><span style="color:#339900; font-size:20px; font-weight:bold">.:</span><span style="color:#FF6600; font-family:Calibri; font-size:16px; font-weight:bold; ">Berita Siswa</span></div>
      </td>
	  <td width="614" valign="top" align="right" background="images/BGNews_05.png">
		&nbsp;
	  </td>
	  <td background="images/BGNews_06.png"></td>
  </tr>
	<tr>
		<td background="images/BGNews_04.png" width="12">			</td>
		<td colspan="2" background="images/BGNews_05.png">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
            <tr>
				<td align="left">
					<font style="color:#a20707; font-size:9px;"><i><?=$tglberita?></i></font>
				</td>
			</tr>
			<tr>
				<td align="left">
					<font style="font-size:16px;"><strong><?=$row_berita['judul']?></strong></font>
				</td>
			</tr>
			<tr>
				<td align="left">
					<font style="color: #757575; font-size:11px;"><?=$nama?></font>
					<br><br>
				</td>
			</tr>
			<tr>
				<td align="left">
					<font style="font-size:11px; line-height: 18px;">
					<?
					$berita = $row_berita['berita'];
					$berita = str_replace("#sq;", "'", $berita);
					echo $berita;
					?>
					</font>
				</td>
			</tr>
            </table>
        </td>
		<td background="images/BGNews_06.png" width="18">			</td>
	</tr>
	<tr>
		<td>
			<img src="images/BGNews_07.png" width="12" height="20" alt=""></td>
		<td height="17" colspan="2" background="images/BGNews_08.png">			</td>
		<td>
			<img src="images/BGNews_09.png" width="18" height="20" alt=""></td>
	</tr>
</table>
</body>
</html>