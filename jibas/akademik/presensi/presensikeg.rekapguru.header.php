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
require_once('../cek.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Presensi Kegiatan Guru</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<script src="presensikeg.rekapguru.header.js"></script>
<script src="../script/jquery-1.9.1.js"></script>
<script src="../script/tools.js"></script>
    
<body topmargin="0" leftmargin="0">
<table border="0" width="100%">
<tr>
    <td width="52" align="right"><strong>Bulan</strong></td>
    <td align="left">
        <select id='cbBulan' onchange='clearContent()'>
<?      for($i = 1; $i <= 12; $i++)
        {
            $sel = $i == date('n') ? "selected" : "";
            echo "<option value='$i' $sel>" . NamaBulan($i) . "</option>";
        } ?>            
        </select>
        <select id='cbTahun' onchange='clearContent()'>
<?      for($i = $G_START_YEAR; $i <= date('Y'); $i++)
        {
            $sel = $i == date('Y') ? "selected" : "";
            echo "<option value='$i' $sel>" . $i . "</option>";
        } ?>            
        </select>
    </td>
    <td align='left'>
        <a href="#" onclick="show()">
            <img src="../images/view.png" height="48" border="0"/>
        </a>
    </td>
    <td align='right' valign='top'>
        <font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;
        <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Rekapitulasi Presensi Kegiatan Guru</font><br />
        <a href="../presensi.php?page=pk" target="content">
        <font size="1" color="#000000"><b>Presensi</b></font></a>&nbsp>&nbsp
        <font size="1" color="#000000"><b>Rekapitulasi Presensi Kegiatan Guru</b></font>
    </td>
</tr>
</table>
</body>
</html>
<?
CloseDb();
?>