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
require_once('../include/common.php');

$th = $_REQUEST['tahun'];
$bln = $_REQUEST['bulan'];
$tgl = $_REQUEST['tgl'];

if ($bln == 4 || $bln == 6|| $bln == 9 || $bln == 11) 
	$n = 30;
else if ($bln == 2 && $th % 4 <> 0) 
	$n = 28;
else if ($bln == 2 && $th % 4 == 0) 
	$n = 29;
else 
	$n = 31;
	
	for($i=1;$i<=$n;$i++){    	        
?>      
	<option value="<?=$i?>" <?=IntIsSelected($tgl, $i)?>> <?=$i?> </option>
<?  } ?>