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
require_once("config.php");

session_name("_JIBAS_KEPEGAWAIAN__");
session_start();

if (!isset($_SESSION['login']))
{
	if (file_exists("index.php")) 
	   $addr = "index.php";
	elseif (file_exists("../index.php")) 
	   $addr = "../index.php";
	elseif(file_exists("../../index.php")) 
	   $addr = "../../index.php";
	else	
	   $addr = "../../../index.php";
	?>
	<script language="javascript">
		if (self != self.top)
		{
			top.window.location.href='<?=$addr?>';
		}
		else if (self.name != "")
		{
			window.close();
			opener.top.window.location.href='<?=$addr?>';
		}
		else
		{
			window.location.href='<?=$addr?>';	
		}
	</script>
<?	exit();
}
?>