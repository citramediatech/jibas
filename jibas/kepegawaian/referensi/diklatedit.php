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
require_once("../include/config.php");
require_once("../include/db_functions.php");
require_once("../include/common.php");
require_once('../include/theme.php');
require_once("../include/sessioninfo.php");

OpenDb();

$id = $_REQUEST['id'];

if (isset($_REQUEST['btSimpan'])) 
{
	$diklat = $_REQUEST['txDiklat'];
	$sql = "UPDATE diklat SET diklat='$diklat' WHERE replid = $id";
	QueryDb($sql);
	CloseDb($sql);
	?>
	<script language="javascript">
		opener.RefreshPage(<?=$id?>);
		window.close();
    </script>    
    <?
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ubah Diklat</title>
<link rel="stylesheet" href="../style/style<?=GetThemeDir2()?>.css" />
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#ffffff">

<?
OpenDb();

$sql = "SELECT diklat FROM diklat WHERE replid=$id";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$diklat = $row[0];
?>
<form name="main" method="post">
<input type="hidden" name="id" id="id" value="<?=$id?>" />
<table border="0" cellpadding="0" cellspacing="5" width="100%" id="table56">
<tr>
	<td class="header" colspan="2" align="center">Ubah Diklat</td>
</tr>
<tr>
	<td align="right" width="120">Diklat :</td>
    <td align="left"><input type="text" name="txDiklat" id="txDiklat" value="<?=$diklat?>" size="30" maxlength="255" /></td>
</tr>
<tr>
	<td colspan="2" align="center" bgcolor="#EAEAEA">
    <input type="submit" class="but" name="btSimpan" value="Simpan" />&nbsp;
    <input type="button" class="but" name="btClose" value="Tutup" onClick="window.close()" />
    </td>
</tr>
</table>
</form>
<?
CloseDb();
?>
</body>
</html>