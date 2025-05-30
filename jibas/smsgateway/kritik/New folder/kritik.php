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
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/common.php');
require_once('kritik.class.php');
OpenDb();
$K = new Kritik();
//$P->OnStart();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pesan Masuk</title>
<link rel="stylesheet" type="text/css" href="../script/ui/jquery.ui.all.css" />
<link rel="stylesheet" type="text/css" href="../style/style.css" />
<script language="javascript" src="kritik.js"></script>
<script language="javascript" src="../script/ShowError.js"></script>
<script language="javascript" src="../script/ajax.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/jquery-1.4.2.js"></script>
<script language="javascript" src="../script/jquery-ui.js"></script>
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
</head>
<body id="body" onload="ResizeThisWin();KritikOnloads();" onresize="ResizeThisWin()">
<div align="center" id="BlackDiv" style="display:none; z-index:1; background-color:#333; padding-top:50px ">
<div id="DivPopup" style="width:350px; border:8px #999 solid; min-height:200px; background-color:#FFF; max-height:300px; -moz-border-radius: 10px;  overflow:auto
"></div> 
</div>
<div id="MainDiv" style="z-index:2;">
<div id="SubTitle" align="right">
<span style="color:#F90; background-color:#F90; font-size:20px">&nbsp;</span>&nbsp;<span style="color:#060; font-size:16px; font-weight:bold">Kritik &amp; Saran</span></div>
<div id="DivGetNewKritik" style="display:none" >
<input type="text" id="NewKritikIdList" style="width:100%" value="" />
<input type="text" id="NumKritikIdList" style="width:100%" value="0" />
</div>
<?
$K->Main();
?>
</div>

</body>
</html>