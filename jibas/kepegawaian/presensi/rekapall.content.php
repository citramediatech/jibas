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
require_once('../include/sessionchecker.php');
require_once("../include/config.php");
require_once("../include/db_functions.php");
require_once("../include/common.php");
require_once("../library/datearith.php");

$tahun30 = $_REQUEST['tahun30'];
$bulan30 = $_REQUEST['bulan30'];
$tanggal30 = $_REQUEST['tanggal30'];
$tahun = $_REQUEST['tahun'];
$bulan = $_REQUEST['bulan'];
$tanggal = $_REQUEST['tanggal'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS Kepegawaian</title>
<link rel="stylesheet" href="../style/style.css" />
<link rel="stylesheet" href="../script/themes/ui-lightness/jquery-ui.css" />
<script type="application/x-javascript" src="../script/jquery-1.9.0.js"></script>
<script type="application/x-javascript" src="../script/ui/jquery-ui.custom.js"></script>
<script type="application/x-javascript" src="../script/ui/jquery.ui.tabs.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="rekapall.content.js"></script>
</head>

<body>
<?
OpenDb();
?>
<input type="hidden" name="tahun30" id="tahun30" value="<?=$tahun30?>">    
<input type="hidden" name="bulan30" id="bulan30" value="<?=$bulan30?>">    
<input type="hidden" name="tanggal30" id="tanggal30" value="<?=$tanggal30?>">
<input type="hidden" name="tahun" id="tahun" value="<?=$tahun?>">    
<input type="hidden" name="bulan" id="bulan" value="<?=$bulan?>">    
<input type="hidden" name="tanggal" id="tanggal" value="<?=$tanggal?>">

<a href="#" onclick="cetak()"><img src="../images/ico/print.png" border="0" title="cetak">&nbsp;cetak</a>&nbsp;|&nbsp;<a href="#" onclick="excel()"><img src="../images/ico/excel.png" border="0" title="excel">&nbsp;excel</a><br><br>
<table border="0" cellpadding="2" cellspacing="0" width="870">
<tr>
    <td align="center" width="50%">
    <img height="250" src="<?= "rekapall.image.php?type=bar&nip=$nip&tahun30=$tahun30&bulan30=$bulan30&tanggal30=$tanggal30&tahun=$tahun&bulan=$bulan&tanggal=$tanggal" ?>" />    
    </td>
    <td align="center" width="50%">
    <img height="250" src="<?= "rekapall.image.php?type=pie&nip=$nip&tahun30=$tahun30&bulan30=$bulan30&tanggal30=$tanggal30&tahun=$tahun&bulan=$bulan&tanggal=$tanggal" ?>" />    
    </td>
</tr>
<tr>
    <td colspan="2">
    
    <br><br>
        
    <div id="tabs">
    <ul>
        <li><a href="#tabs-1">Hadir</a></li>
        <li><a href="#tabs-2">Izin</a></li>
        <li><a href="#tabs-3">Sakit</a></li>
        <li><a href="#tabs-4">Cuti</a></li>
        <li><a href="#tabs-5">Alpa</a></li>
        <li><a href="#tabs-6">Bebas</a></li>
    </ul>
    <div id="tabs-1">
        <div style="overflow: auto; width: 100%; height: 400px">
        <div id="tabHadir"></div>    
        </div>        
    </div>
    <div id="tabs-2">
        <div style="overflow: auto; width: 100%; height: 400px">
        <div id="tabIzin"></div>    
        </div>        
    </div>
    <div id="tabs-3">
        <div style="overflow: auto; width: 100%; height: 400px">
        <div id="tabSakit"></div>    
        </div>        
    </div>
    <div id="tabs-4">
        <div style="overflow: auto; width: 100%; height: 400px">
        <div id="tabCuti"></div>    
        </div>        
    </div>
    <div id="tabs-5">
        <div style="overflow: auto; width: 100%; height: 400px">
        <div id="tabAlpa"></div>    
        </div>        
    </div>
    <div id="tabs-6">
        <div style="overflow: auto; width: 100%; height: 400px">
        <div id="tabBebas"></div>    
        </div>        
    </div>
    </div>
    
    </td>
</tr>
</table>



<?
CloseDb();
?>
</body>
</html>








