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
OpenDb();
$departemen = $_POST['departemen'];
?>
<select name="kelas" id="kelas" onchange="change_kelas()"  style="width:100px">
<?
	$sql_kelas = "SELECT k.replid,k.kelas FROM jbsakad.kelas k,jbsakad.tahunajaran t WHERE k.aktif=1 AND t.departemen='$departemen' AND k.idtahunajaran=t.replid ORDER BY k.replid";
	
	$result_kelas = QueryDb($sql_kelas);
	
			
	while($row_kelas =@mysqli_fetch_row($result_kelas)) {
?>
		<option value="<?=urlencode($row_kelas[0])?>"><?=$row_kelas[1]?></option>
<?
	} //while
	CloseDb();
?>
</select>