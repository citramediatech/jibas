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
<frameset cols = "25%, *" border="1" frameborder="yes">
<frame src="input_presensi_menu.php?semester=<?=$_REQUEST['semester']?>&kelas=<?=$_REQUEST['kelas']?>" name="menu" id="menu">
<frame src="blank_presensi_harian.php?tipe=isi" name="isi" id="isi"  style="border:1; border-left-color:#000000; border-left-style:solid">
</frameset><noframes></noframes>