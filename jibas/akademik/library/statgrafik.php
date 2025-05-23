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
$kode = $_REQUEST['kode'];
$departemen = $_REQUEST['key'];
$key = $_REQUEST['key'];
$keyword = $_REQUEST['keyword'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="style/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Grafik Statistik</title>
<script language="javascript" src="script/tools.js"></script>
<script  language="javascript">
function CetakWord() {
	var addr = "cetakgrafik.php?key=<?=$key?>&keyword=<?=$keyword?>&departemen=<?=$departemen?>&kode=<?=$kode?>";
	newWindow(addr, 'StatWord','790','630','resizable=1,scrollbars=1,status=0,toolbar=0');
}
</script>

</head>

<body topmargin="0" leftmargin="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td align="center">
<a href="JavaScript:CetakWord()"><img src="../images/ico/print.png" border="0" />&nbsp;Cetak</a>
</td></tr>
</table>
<br />
<table width="100%" border="0">
<tr><td>

	<div id="grafik" align="center">
	<table width="100%" border="0" align="center">
    <tr><td>
    	<div align="center">
            <img src="<?="statimage.php?type=bar&key=$key&keyword=$keyword&departemen=$departemen&kode=$kode"?>" />
        </div>
    </td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>
    	<div align="center">
              <img src="<?="statimage.php?type=pie&key=$key&keyword=$keyword&departemen=$departemen&kode=$kode"?>" />
        </div>
    </td></tr>
	</table>
	</div>
    
</td></tr>
</table>

</body>
</html>