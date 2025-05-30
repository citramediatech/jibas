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
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/rupiah.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../library/jurnal.php');
require_once('../library/smsmanager.func.php');

require_once('tabungan.trans.input.view.php');
require_once('tabungan.trans.input.func.php');

$idtabungan = (int)$_REQUEST['idtabungan'];
$nis = (string)$_REQUEST['nis'];
$idtahunbuku = (int)$_REQUEST['idtahunbuku'];
$tgl_jurnal = date('d-m-Y');
$errmsg = $_REQUEST['errmsg'];

OpenDb();

FetchDataSiswa();

FetchDataTabungan();

SimpanTransaksi();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pembayaran</title>
<script src="../script/jquery-1.9.0.js" language="javascript"></script>
<script src="../script/rupiah2.js" language="javascript"></script>
<script src="../script/validasi.js" language="javascript"></script>
<script src="../script/tables.js" language="javascript"></script>
<script src="../script/tooltips.js" language="javascript"></script>
<script src="../script/tools.js" language="javascript"></script>
<script src="../script/string.js" language="javascript"></script>
<script src="tabungan.trans.input.js" language="javascript"></script>
</head>
<body topmargin="0" leftmargin="0" <?=$input_awal?>>
<input type="hidden" id="nis" value="<?=$nis?>">
<input type="hidden" id="idtahunbuku" value="<?=$idtahunbuku?>">
<input type="hidden" id="idtabungan" value="<?=$idtabungan?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td valign="top" background="" style="background-repeat:no-repeat; background-attachment:fixed">
    <table width="100%" border="0" height="100%" cellspacing="2" cellpadding="2">
   	<tr>
    	<td align="left" colspan="2">
        <font size="5" color="#990000"><strong><?=$namatabungan ?></strong></font><p>
        </td>
   	</tr>
    <tr>
        <td align="left" colspan="2">
		<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="60%" valign="top">
<?      	ShowInfoSiswa(); ?>				
			</td>
			<td width="*" valign="top">
<?			ShowInfoTabungan();	 ?>
			</td>
		</tr>			
		</table>			
		
  		</td>
  	</tr>
    <tr>
        <td align="left" width="40%"> 
<?      ShowSetoranInput() ?>        
		</td>
        <td align="left" width="*"> 
<?      ShowTarikanInput(0) ?>        
		</td>
	</tr>
	<tr>
		<td align="left" colspan="2">
<?      ShowTransaksi(0); ?>
  		</td>
	</tr>
	</table>
    </td>
</tr>
</table>

<? if (strlen($errmsg) > 0) { ?>
<script language="javascript">
alert('<?=$errmsg ?>');
</script>
<? } ?>
</body>
</html>
