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
function getDepartemen($access) {
	if ($access == "ALL") {
		$sql = "SELECT departemen FROM jbsakad.departemen WHERE aktif=1 ORDER BY urutan";
		$result = QueryDb($sql);
		$i = 0;
		while($row = mysqli_fetch_row($result)) {
			$dep[$i] = $row[0];
			$i++;
		}
	} else {
		$dep[0] = $access;
	}
	return $dep;
}
?>