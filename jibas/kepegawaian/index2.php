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
require_once("include/sessionchecker.php");
require_once("include/sessioninfo.php");
?>
<title>JIBAS Kepegawaian</title>
<link href="images/jibas2015.ico" rel="shortcut icon" />
<frameset rows="74,*,32" frameborder="0" border="0" framespacing="0">
	<frame name="frameatas" src="frameatas.php" scrolling="no" noresize="noresize" />
    <frameset cols="30,*,30" frameborder="0" border="0" framespacing="0">
    	<frame name="framekiri" src="framekiri.php" scrolling="no" noresize="noresize" />
        <frame name="content" src="pegawai/pegawai.php"/>
        <frame name="framekanan" src="framekanan.php" scrolling="no" noresize="noresize" />
    </frameset>
	<frame name="framebawah" src="framebawah.php" scrolling="no" noresize="noresize" />
</frameset>
<noframes></noframes>