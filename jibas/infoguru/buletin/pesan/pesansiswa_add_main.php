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
require_once('../../include/sessioninfo.php');
require_once('../../include/sessionchecker.php');

$bulan="";
if (isset($_REQUEST['bulan']))
	$bulan=$_REQUEST['bulan'];
$tahun="";
if (isset($_REQUEST['tahun']))
	$tahun=$_REQUEST['tahun'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
</HEAD>
<FRAMESET COLS="*,245" FRAMEBORDER="yes" border="0">
	<frame src="pesansiswa_add.php" name="pesansiswa_add" id="pesansiswa_add" scrolling="auto">
	<!--<frame src="tujuanpesan.php?bulan=<?=$bulan?>&tahun=<?=$tahun?>" name="pesanguru_tujuan" id="pesanguru_tujuan" scrolling="auto">-->
	<frameset rows="120,*">
		<frame src="pesansiswa_tujuan.php?bulan=<?=$bulan?>&tahun=<?=$tahun?>" name="tujuan_header" id="tujuan_header" scrolling="no">
		<frame src="pesansiswa_tujuan_footer.php" name="tujuan_footer" id="tujuan_footer">
	</frameset>
</frameset>
</HTML>