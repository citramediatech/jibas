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
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('departemen.php');

OpenDb();
?>
<table width="100%" id="table" class="tab" align="center" cellpadding="2" cellspacing="0" bordercolor="#000000">
<tr height="30">
	<td class="header" width="7%" align="center">No</td>
    <td class="header" width="15%" align="center">N I S</td>
    <td class="header" >Nama</td>
	<td class="header" >Kelas</td>
	<td class="header" height="30">&nbsp;</td>
</tr>
<?

$kelas = $_REQUEST['kelas'];
$sql = "SELECT s.nis, s.nama, k.kelas FROM jbsakad.siswa s,jbsakad.kelas k WHERE k.replid=s.idkelas AND s.statusmutasi=0 AND s.idkelas='$kelas'  AND s.alumni=0 ORDER BY s.nama"; 
$result = QueryDb($sql);
$cnt = 1;
	
while($row = mysqli_fetch_row($result)) {
if ($cnt%2==0)
	$bg="bgcolor='#e7e7cf'";
if ($cnt%2==1)
	$bg="bgcolor='#ffffff'";
	?>
<tr>
	<td height="25" align="center" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer"><?=$cnt ?></td>
    <td height="25" align="center" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer"><?=$row[0] ?></td>
    <td height="25" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer"><?=$row[1] ?></td>
	<td height="25" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer"><?=$row[2] ?></td>
	<td height="25" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer" align="center"><input type="button" value="Pilih" onclick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')"  class="but"></td>
</tr>
<?
$cnt++;
}
CloseDb();	
if (mysqli_num_rows($result) == 0) { ?>
<tr height="26"><td colspan="4" align="center"><em>Tidak ditemukan data</em></td></tr>
<? } ?>

</table>