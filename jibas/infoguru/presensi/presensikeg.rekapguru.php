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
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../library/datearith.php');
require_once('../sessionchecker.php');
require_once('presensikeg.rekapguru.func.php');

$bulan = isset($_REQUEST['bulan']) ? $_REQUEST['bulan'] : date('n');
$tahun = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date('Y');

$nip = SI_USER_ID();    

OpenDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Rekapitulasi Presensi Kegiatan Guru</title>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/jquery-1.9.1.js"></script>
<script language="javascript" src="presensikeg.rekapguru.js"></script>
</head>

<body>
<br>
<input type='hidden' id='nip' value='<?=$nip?>'>    
<table border="0" width="100%">
<tr>
    <td align='right' valign='top'>
        <font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;
        <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Rekapitulasi Presensi Kegiatan Guru</font><br />
        <a href="../presensi.php?page=pk" target="framecenter">
        <font size="1" color="#000000"><b>Presensi</b></font></a>&nbsp>&nbsp
        <font size="1" color="#000000"><b>Rekapitulasi Presensi Kegiatan Guru</b></font>
    </td>
</tr>
</table>
<br><br>
<table border="0" cellpadding='2'>
<tr>
    <td width='100' align='right'>Bulan:</td>
    <td align='left'>
<?      ShowCbBulan($bulan) ?>
<?      ShowCbTahun($tahun) ?>        
    </td>
</tr>
</table>    


<br>
<?
$showbutton = true;
require_once("presensikeg.rekapguru.report.php");
?>
</body>
</html>
<?
CloseDb();
?>
<script language='JavaScript'>
    //Tables('table', 1, 0);
</script>