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
if(isset($_GET['departemen'])){
	$file1 = "filter_penentuan.php?departemen=$_GET[departemen]&tingkat=$_GET[tingkat]&semester=$_GET[semester]&kelas=$_GET[kelas]";
	$file2 = "penentuan_footer.php?departemen=$_GET[departemen]&tingkat=$_GET[tingkat]&semester=$_GET[semester]&kelas=$_GET[kelas]";
}else{
	$file1 = "filter_penentuan.php";
	$file2 = "blank_penentuan.php";
}
?>
<frameset rows="60,*" border="1" frameborder="0" framespacing="0">
    <frame name="filter_penentuan" src="filter_penentuan.php" target="filter_penentuan"  scrolling="no" style="border:1px; border-bottom-color:#000000; border-bottom-style:solid">
    <frame name="penentuan_footer" src="blank_penentuan.php">
</frameset><noframes></noframes>
</html>