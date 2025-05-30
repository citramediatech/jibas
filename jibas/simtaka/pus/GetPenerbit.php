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

$penerbit=$_REQUEST['penerbit'];

OpenDb();

$sql = "SELECT MAX(LENGTH(kode))
		  FROM penerbit";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$maxlen = $row[0];
?>
<select name="penerbit" id="penerbit" class="cmbfrm" style="width:100%; font-family:'Courier New'">
<?
$sql = "SELECT replid, kode, nama
		  FROM penerbit
		 ORDER BY nama";
$result = QueryDb($sql);
while ($row = @mysqli_fetch_row($result))
{
	$len = strlen(trim($row[1]));
	$space = GetSpace($maxlen, $len);
	
	if ($penerbit == "")
		$penerbit = $row[0];	
?>
	<option value="<?=$row[0]?>" <?=IntIsSelected($row[0],$penerbit)?>>
		<?= "$space$row[1] - $row[2]" ?> 
	</option>
<?
}
CloseDb();
?>
</select>

<?
function GetSpace($maxlength,$length)
{
	$spacer="";
	for ($i=1;$i<=$maxlength-$length;$i++)
		$spacer .="&nbsp;";
		
	return $spacer;	
}
?>