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
$tingkat=$_REQUEST['tingkat'];
$tahunajaran=$_REQUEST['tahunajaran'];
?>
<frameset cols="52%,*" border="1" framespacing="yes" frameborder="yes">
<frameset rows="110,*" border="1" framespacing="yes" frameborder="no">
<frame src="siswa_kenaikan_menu.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&tahunajaran=<?=$tahunajaran?>" name="siswa_kenaikan_menu" scrolling="No" noresize="noresize" id="siswa_kenaikan_menu" title="siswa_kenaikan_menu" style="border:1; border-bottom-color:#000000; border-bottom-style:solid"/>
<frame src="blank_kenaikan.php" name="siswa_kenaikan_pilih" id="siswa_kenaikan_pilih" title="siswa_kenaikan_pilih" />
</frameset> 
<frame src="siswa_kenaikan_tujuan.php?departemen=<?=$departemen?>&tingkatawal=<?=$tingkat?>&tahunajaranawal=<?=$tahunajaran?>" name="siswa_kenaikan_tujuan" id="siswa_kenaikan_tujuan" title="siswa_kenaikan_tujuan" style="border:1; border-left-color:#000000; border-left-style:solid"/>
</frameset><noframes></noframes>