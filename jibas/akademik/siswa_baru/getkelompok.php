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
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$kelompok = $_REQUEST['kelompok'];
?>
<select name="kelompok" id="kelompok" onchange="change_kel()" style="width:280px">
<?	OpenDb();
	$sql = "SELECT k.replid,kelompok,kapasitas FROM kelompokcalonsiswa k, prosespenerimaansiswa p WHERE p.departemen = '$_REQUEST[departemen]' AND p.aktif = 1 AND p.replid = k.idproses ORDER BY kelompok";
	$result = QueryDb($sql);
	
	while ($row = @mysqli_fetch_row($result)) {
		if ($kelompok == "") 
			$kelompok = $row[0];	
		$sql1 = "SELECT COUNT(replid) FROM calonsiswa WHERE idkelompok = '$row[0]' AND aktif = 1";
		$result1 = QueryDb($sql1);				
		$row1 = mysqli_fetch_row($result1);			
	?>
    <option value="<?=urlencode($row[0])?>" <?=IntIsSelected($row[0], $kelompok)?> ><?=$row[1].', kapasitas: '.$row[2] .', terisi: '.$row1[0]?></option>
    <? } ?>
</select>&nbsp;<img src="../images/ico/tambah.png" onclick="tampil_kelompok();" onMouseOver="showhint('Tambah Kelompok!', this, event, '60px')" />