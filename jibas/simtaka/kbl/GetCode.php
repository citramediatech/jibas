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
require_once("../inc/config.php");
require_once("../inc/db_functions.php");
require_once("../inc/common.php");
OpenDb();

if(isset($_REQUEST['search'])) {
  $search=$_REQUEST['search'];
//echo($search);
	$sql = "SELECT kodepustaka FROM pinjam WHERE kodepustaka LIKE '%$search%' AND status=1";		
	$result = QueryDb($sql) or die (mysqli_error ());
		while($row = mysqli_fetch_array($result)){
			echo $row['kodepustaka']."\n";
		}
}
?>