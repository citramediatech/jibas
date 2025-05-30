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
require_once('include/errorhandler.php');
require_once('include/sessionchecker.php');
require_once('include/sessioninfo.php');
if (getLevel() == 2) { ?>
	<script language="javascript">
        alert('Maaf, anda tidak berhak mengakses halaman ini!');
        document.location.href = "lapkeuangan.php";
    </script>
<?  exit();
} ?>   
<frameset rows="100,*" border="0" framespacing="0" frameborder="0">
	<frame name="header" src="lapbukubesar_header.php" scrolling="no" noresize="noresize" style="border:1px; border-bottom-color:#000000; border-bottom-style:solid" />
    <frame name="contentblank" src="lapbukubesar_blank.php" />
   <!-- <frameset border="1" cols="380,*" frameborder="no">
    	<frame name="pilih" src="lapbukubesar_blank.php" scrolling="auto" />
	    <frame name="content" src="lapbukubesar_blank.php" scrolling="no" style="border:1; border-left-color:#000000; border-left-style:solid" />
    </frameset>-->
</frameset><noframes></noframes>