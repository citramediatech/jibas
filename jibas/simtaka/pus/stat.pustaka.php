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
require_once('../inc/config.php');
require_once('../inc/db_functions.php');
require_once('../inc/common.php');
require_once('../inc/sessioninfo.php'); 
require_once('stat.pustaka.class.php');

OpenDb();
$S = new CStat();
$S->OnStart();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../sty/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../scr/tables.js"></script>
<script type="text/javascript" src="../scr/tools.js"></script>
<script type="text/javascript" src="../scr/ajax.js"></script>
<script type="text/javascript" src="stat.pustaka.js"></script>
</head>
<body topmargin="0">
	<div id="waitBox" style="position:absolute; visibility:hidden;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="32"><img src="../img/loading.gif" width="32" height="32" border="0" /></td>
            <td>&nbsp;<span class="news_title1">Please&nbsp;wait...</span></td>
          </tr>
        </table>
    </div>
	
    <div id="content">
      <?=$S->Content()?>
    </div>
</body>
</html>
<? CloseDb(); ?>