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
require_once('include/errorhandler.php');
require_once('include/sessionchecker.php');
require_once('include/common.php');
require_once('include/rupiah.php');
require_once('include/config.php');
require_once('include/db_functions.php');
require_once('include/getheader.php'); 

$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS KEU [Daftar Jenis Pengeluaran]</title>
<script language="javascript" src="script/tables.js"></script>
<script language="javascript" src="script/tools.js"></script>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr><td align="left" valign="top">

<?=getHeader($departemen)?>


<center><font size="4"><strong>DAFTAR JENIS PENGELUARAN</strong></font><br /> </center><br /><br />

<table border="0">
<tr>
	<td><strong>Departemen : <?=$departemen ?></strong> </td>
</tr>
</table>
<br />

	<table id="table" class="tab" border="1" style="border-collapse:collapse" width="100%" bordercolor="#000000">
	<tr height="30" align="center">
        <td class="header" width="5%">No</td>
        <td class="header" width="20%">Nama</td>
        <td class="header" width="30%">Kode Rekening</td>
        <td class="header" width="*">Keterangan</td>
	</tr>
<?	OpenDb();
	$sql = "SELECT * FROM datapengeluaran WHERE departemen='$departemen' ORDER BY replid";
	$request = QueryDb($sql);
	$cnt = 0;
	while ($row = mysqli_fetch_array($request)) { ?>
    <tr height="25">
    	<td align="center"><?=++$cnt?></td>
        <td><?=$row['nama'] ?></td>
        <td>
<?			$sql = "SELECT nama FROM rekakun WHERE kode = '$row[rekkredit]'";
			$result = QueryDb($sql);
			$row2 = mysqli_fetch_row($result);
			$namarekkredit = $row2[0];
	
			$sql = "SELECT nama FROM rekakun WHERE kode = '$row[rekdebet]'";
			$result = QueryDb($sql);
			$row2 = mysqli_fetch_row($result);
			$namarekdebet = $row2[0]; ?>
		<strong>Rek. Kas:</strong> <?=$row['rekkredit'] . " " . $namarekkredit ?><br />
        <strong>Rek. Beban:</strong> <?=$row['rekdebet'] . " " . $namarekdebet ?>
        </td>
        <td><?=$row['keterangan'] ?></td>
    </tr>
    <?
	}
	CloseDb();
	?>
    </table>
    
</td></tr></table>
</body>
</html>
<script language="javascript">window.print();</script>