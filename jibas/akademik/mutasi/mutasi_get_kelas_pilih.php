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
//include('../cek.php');
require_once('../include/config.php');
require_once('../include/common.php');
require_once('../include/db_functions.php');
//require_once('../library/departemen.php');
$departemen = $_POST["departemen"];
OpenDb();
?>
<select name="kelas" id="kelas" onChange="kelas()" style="width:150px">
            <?	$sql="SELECT k.replid,k.kelas FROM jbsakad.kelas k,jbsakad.tahunajaran ta,jbsakad.tingkat ti WHERE k.idtahunajaran=ta.replid AND k.idtingkat=ti.replid AND ti.departemen='$departemen' AND ta.departemen='$departemen' AND k.aktif=1 ORDER BY k.kelas";
			$result=QueryDb($sql);
			while ($row=@mysqli_fetch_array($result)){
					if ($kelas == "")
						$kelas = $row['replid'];
						?>
            <option value="<?=$row['replid'] ?>" <?=StringIsSelected($row['replid'], $kelas) ?> >
            <?=$row['kelas'] ?>
            </option>
            <?	} ?>
          </select>