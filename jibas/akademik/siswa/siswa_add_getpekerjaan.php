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
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$pekerjaan_kiriman=$_REQUEST['pekerjaan'];
?>
	<select name="pekerjaanayah" id="Infopekerjaanayah" class="ukuran"  onKeyPress="return focusNext('Infopekerjaanibu', event)" onfocus="panggil('Infopekerjaanayah')" style="width:140px">
    <option value="">[Pilih Pekerjaan]</option>
      <? 
	OpenDb();
	
	$sql_kerja_ibu="SELECT pekerjaan FROM jbsumum.jenispekerjaan ORDER BY pekerjaan";
	$result_kerja_ibu=QueryDB($sql_kerja_ibu);
	while ($row_kerja_ibu = mysqli_fetch_array($result_kerja_ibu)) {
	//if ($pekerjaan_kiriman=="")
	//$pekerjaan_kiriman=$row_kerja_ibu['pekerjaan'];
	?>
      <option value="<?=$row_kerja_ibu['pekerjaan']?>"<?=StringIsSelected($row_kerja_ibu['pekerjaan'],$pekerjaan_kiriman)?>><?=$row_kerja_ibu['pekerjaan']?></option>
      <?
    } 
	CloseDb();
	// Akhir Olah Data sekolah
	?>
	</select>