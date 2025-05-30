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
require_once('../inc/config.php');
require_once('../inc/db_functions.php');
require_once('../inc/common.php');

OpenDb();

$idperpustakaan = -1;
if (isset($_REQUEST['idperpustakaan']))
  $idperpustakaan = (int)$_REQUEST['idperpustakaan'];

$filter="";
if ($idperpustakaan != -1)
  $filter=" AND d.perpustakaan=".$idperpustakaan;
			
$idpustaka = $_REQUEST['idpustaka'];
$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$sql = "SELECT IF(p.nis IS NOT NULL, p.nis, IF(p.nip IS NOT NULL, p.nip, p.idmember)) AS idanggota, p.tglpinjam, p.info1
	      FROM pinjam p, daftarpustaka d, pustaka pu
		 WHERE p.tglpinjam BETWEEN '$from' AND '$to'
		   AND pu.replid = '$idpustaka'
		   AND p.kodepustaka = d.kodepustaka $filter
		   AND d.pustaka=pu.replid
		 ORDER BY tglpinjam DESC  ";
$result = QueryDb($sql);
//echo $sql;
?>
<table width="100%" border="1" cellspacing="0" cellpadding="5" class="tab">
<tr height="25">
  <td width='5%' align="center" class="header">No</td>
  <td width='14%' align="center" class="header">Tgl Pinjam</td>
  <td width='*' align="center" class="header">Peminjam</td>
</tr>
<?
$cnt = 1;
while ($row = @mysqli_fetch_row($result))
{ ?>
  <tr height="20">
	<td align="center"><?=$cnt?></td>
	<td align="center"><?=LongDateFormat($row[1])?></td>
	<td align="left">
	  <font style='font-size: 9px'><?=$row[0]?></font><br>
	  <font style='font-size: 11px; font-weight: bold;'><?=GetMemberName($row[0], $row[2])?></font>
	  </td>
  </tr>
<?
  $cnt++;
}
CloseDb();
?>
</table>
<?
function GetMemberName($idanggota, $jenisanggota)
{
	if ($jenisanggota == "siswa")
	{
		$sql = "SELECT nama
				  FROM jbsakad.siswa
				 WHERE nis = '$idanggota'";
	}
	elseif ($jenisanggota == "pegawai")
	{
		$sql = "SELECT nama
				  FROM jbssdm.pegawai
				 WHERE nip = '$idanggota'";
	}
	else
	{
		$sql = "SELECT nama
				  FROM jbsperpus.anggota
				 WHERE noregistrasi = '$idanggota'";
	}
	$res = QueryDb($sql);
	$row = mysqli_fetch_row($res);
	$namaanggota = $row[0];
	
	return $namaanggota;
}
?>