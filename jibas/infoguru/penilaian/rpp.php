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
require_once('../include/theme.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
OpenDb();
if(isset($_REQUEST["semester"]))
	$semester = $_REQUEST["semester"];
if(isset($_REQUEST["tingkat"]))
	$tingkat = $_REQUEST["tingkat"];
if(isset($_REQUEST["departemen"]))
	$departemen = $_REQUEST["departemen"];		
if(isset($_REQUEST["pelajaran"]))
	$pelajaran = $_REQUEST["pelajaran"];
    ?>
<select name="idrpp" id="idrpp"><!---->
                  <?
				  $sql_rpp="SELECT * FROM jbsakad.rpp WHERE idtingkat='$tingkat' AND idsemester='$semester' AND idpelajaran='$pelajaran' AND aktif=1";
				  $result_rpp=QueryDb($sql_rpp);
				  while ($row_rpp=@mysqli_fetch_array($result_rpp)){
				  ?>
                  <option value="<?=$row_rpp['replid']?>"><?=$row_rpp['rpp']?></option>
                  <?
				  }
				  ?>
                  </select><!---->

                  <?
				  CloseDb();
				 ?>