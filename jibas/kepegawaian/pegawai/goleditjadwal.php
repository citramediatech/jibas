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

$id = $_REQUEST['id'];

$tgl = $_REQUEST['cbTgl'];
$bln = $_REQUEST['cbBln'];
$thn = $_REQUEST['txThn'];
$tmt = "$thn-$bln-$tgl";
$keterangan = $_REQUEST['txKeterangan'];

if (isset($_REQUEST['btSubmit']))
{
	OpenDb();
	$sql = "UPDATE jadwal SET tanggal='$tmt', keterangan='$keterangan', aktif=1 WHERE replid=$id";
	QueryDb($sql);
	CloseDb(); ?>
    <script language="javascript">
		opener.Refresh();
		window.close();
    </script>
<?
}
else
{
	OpenDb();
	$sql = "SELECT * FROM jadwal WHERE replid=$id";
	$result = QueryDb($sql);
	$row = mysqli_fetch_array($result);
	$tgl = GetDatePart($row['tanggal'], "d");
	$bln = GetDatePart($row['tanggal'], "m");
	$thn = GetDatePart($row['tanggal'], "y");
	$keterangan = $row['keterangan'];
	CloseDb();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ubah Jadwal Kenaikan Golongan</title>
<link rel="stylesheet" href="../style/style<?=GetThemeDir2()?>.css" />
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">
function validate()
{
	return validateEmptyText('txThn', 'Tanggal Jadwal Kenaikan Golongan Pegawai') && 
  		   validateInteger('txThn', 'Bulan Jadwal Kenaikan Golongan Pegawai') && 
		   validateLength('txThn', 'Tahun Jadwal Kenaikan Golongan Pegawai', 4) &&
		   validateEmptyText('txKeterangan', 'Keterangan Jadwal Kenaikan Golongan Pegawai');
}

function focusNext(elemName, evt)
{
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13)
	{
		document.getElementById(elemName).focus();
        return false;
    }
    return true;
}
</script>
</head>

<body onLoad="document.getElementById('cbTglPensiun').focus()">
<form name="main" method="post" onSubmit="return validate()">
<input type="hidden" name="id" id="id" value="<?=$id?>" />
<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr height="30">
	<td width="100%" class="header" align="center">Ubah Jadwal Kenaikan Golongan</td>
</tr>
<tr>
	<td width="100%" align="center">
    
    <table border="0" cellpadding="0" cellspacing="5" width="100%">
	<tr>
        <td align="right" valign="top" width="25%"><strong>Jadwal Kenaikan Golongan :</strong></td>
        <td width="*" align="left" valign="top">

        <select id="cbTgl" name="cbTgl" onKeyPress="return focusNext('cbBln', event)">
    <?	for ($i = 1; $i <= 31; $i++) { ?>    
            <option value="<?=$i?>" <?=IntIsSelected($i, $tgl)?>><?=$i?></option>	
    <?	} ?>    
        </select>
        <select id="cbBln" name="cbBln" onKeyPress="return focusNext('txThn', event)">
    <?	for ($i = 1; $i <= 12; $i++) { ?>    
            <option value="<?=$i?>" <?=IntIsSelected($i, $bln)?>><?=NamaBulan($i)?></option>	
    <?	} ?>    
        </select>
        <input type="text" name="txThn" onKeyPress="return focusNext('txKeterangan', event)" id="txThn" size="4" maxlength="4" value="<?=$thn?>"/>
        </td>
	</tr>
    <tr>
    	<td align="right" valign="top"><strong>Keterangan :</strong></td>
	    <td align="left" valign="top">
        <textarea id="txKeterangan" name="txKeterangan" rows="2" cols="40"><?=$keterangan?></textarea>
        </td>
    </tr>
    <tr>
    	<td align="right" valign="top">&nbsp;</td>
	    <td align="left" valign="top">
        <input type="submit" value="Simpan" name="btSubmit" class="but" />
        <input type="button" value="Tutup" onClick="window.close()" class="but" />
        </td> 
    </tr>
    </table>
    </td>
</tr>
</table>
</form>

</body>
</html>