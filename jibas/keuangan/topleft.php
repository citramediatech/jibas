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
require_once('include/common.php');
require_once('include/sessioninfo.php');
require_once('include/sessionchecker.php');
require_once('include/config.php');
require_once('include/theme.php');
require_once('include/db_functions.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript">
function get_fresh(){
document.location.reload();
}
</script>
<title>Untitled Document</title>
</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background:url(images/bgmain.jpg)">
<table border="0" cellpadding="0" cellspacing="0" width="56">
<tr height="38">
    <td width="28" background="<?=GetThemeDir() ?>bgmain_02.jpg">&nbsp;</td>
    <td width="28" colspan="2" background="<?=GetThemeDir() ?>bgmain_03a.jpg">&nbsp;</td>
</tr>
<tr height="60">
    <td width="28" background="<?=GetThemeDir() ?>bgmain_06a.jpg">&nbsp;</td>
    <td width="28" colspan="2" background="<?=GetThemeDir() ?>bgtable.jpg">&nbsp;</td>
</tr>
<tr height="26">
    <td width="28" background="<?=GetThemeDir() ?>bgmain_06a.jpg">&nbsp;</td>
    <td width="22" background="<?=GetThemeDir() ?>bgmain_10.jpg">&nbsp;</td>
    <td width="6" background="<?=GetThemeDir() ?>bgmain_11a.jpg">&nbsp;</td>
</tr>
</table>
</body>
</html>