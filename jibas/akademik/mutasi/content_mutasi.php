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
$departemen=$_REQUEST['departemen'];
$tahunawal=$_REQUEST['tahunawal'];
$tahunakhir=$_REQUEST['tahunakhir'];
?>
<frameset rows="*"  cols="619,*" border="1" frameborder="yes">
	<frame src="grafik.php?departemen=<?=$departemen?>&tahunawal=<?=$tahunawal?>&tahunakhir=<?=$tahunakhir?>" name="kiri"  style="border:1; border-right-color:#000000; border-right-style:solid" />
    <frame src="statistik_mutasi_table.php?departemen=<?=$departemen?>&tahunawal=<?=$tahunawal?>&tahunakhir=<?=$tahunakhir?>" name="kanan" />
</frameset>
<noframes></noframes>