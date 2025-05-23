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
$tingkat=$_REQUEST['tingkat'];
$tahunajaran=$_REQUEST['tahunajaran'];
?>
<select name="kelas" id="kelas" onchange="change_tabel()">
  <?
OpenDb();
$sql_kelas="SELECT k.replid,k.kelas,k.kapasitas FROM jbsakad.kelas k WHERE k.idtingkat='$tingkat' AND k.idtahunajaran='$tahunajaran' AND k.aktif=1 ORDER BY k.kelas";
$result_kelas=QueryDb($sql_kelas);

while ($row_kelas=@mysqli_fetch_row($result_kelas)){
//$idkelas=$row_kelas[0];
$sql_terisi="SELECT COUNT(*) FROM jbsakad.siswa WHERE idkelas='$row_kelas[0]' AND aktif = 1";
$result_terisi=QueryDb($sql_terisi);
$row_terisi=@mysqli_fetch_row($result_terisi);
$terisi=(int)$row_terisi[0];
?>
      <option value="<?=$row_kelas[0]?>">
        <?=$row_kelas[1]?>&nbsp;Kapasitas&nbsp;:&nbsp;<?=$row_kelas[2]?>&nbsp;Terisi&nbsp;:&nbsp;<?=$terisi?>
        </option>
      <?
}
CloseDb();
?></select>