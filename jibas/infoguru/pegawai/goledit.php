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
require_once("../include/sessionchecker.php");
require_once("../include/config.php");
require_once("../include/db_functions.php");
require_once("../include/common.php");
require_once("../include/sessioninfo.php");
require_once('../include/theme.php');

$id = $_REQUEST['id'];

$gol = $_REQUEST['cbGolongan'];
$tgltmtgol = $_REQUEST['cbTglTMTGol'];
$blntmtgol = $_REQUEST['cbBlnTMTGol'];
$thntmtgol = $_REQUEST['txThnTMTGol'];
$tmt = "$thntmtgol-$blntmtgol-$tgltmtgol";
$sk = $_REQUEST['txSK'];
$keterangan = $_REQUEST['txKeterangan'];
$alasan = $_REQUEST['txAlasan'];

if (isset($_REQUEST['btSubmit']))
{
	OpenDb();
	$sql = "UPDATE jbssdm.peggol SET golongan='$gol', tmt='$tmt', sk='$sk', keterangan='$keterangan', doaudit = 1 WHERE replid=$id";
	QueryDb($sql);
	CloseDb(); ?>
    <script language="javascript">
		opener.Refresh();
		window.close();
    </script>
<?	exit();
}
else
{
	OpenDb();
	$sql = "SELECT golongan, tmt, sk, keterangan FROM jbssdm.peggol WHERE replid=$id";
	$result = QueryDb($sql);
	$row = mysqli_fetch_array($result);
	$gol = $row['golongan'];
	$tgl = $row['tmt'];
	$tgltmtgol = GetDatePart($tgl, 'd');
	$blntmtgol = GetDatePart($tgl, 'm');
	$thntmtgol = GetDatePart($tgl, 'y');
	$sk = $row['sk'];
	$keterangan = $row['keterangan'];
	CloseDb();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS Kepegawaian</title>
<link rel="stylesheet" href="../style/style<?=GetThemeDir2()?>.css" />
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">
function validate() {
	return validateEmptyText('txThnTMTGol', 'Tahun TMT Golongan Pegawai') && 
  		   validateInteger('txThnTMTGol', 'Tahun TMT Golongan Pegawai') && 
		   validateLength('txThnTMTGol', 'Tahun TMT Golongan Pegawai', 4);
}

function focusNext(elemName, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13) {
		document.getElementById(elemName).focus();
        return false;
    }
    return true;
}
</script>
</head>

<body>
<form name="main" method="post" onSubmit="return validate()">
<input type="hidden" name="id" id="id" value="<?=$id?>" />
<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr height="30">
	<td width="100%" class="header" align="center">Ubah Golongan</td>
</tr>
<tr>
	<td width="100%" align="center">
    
    <table border="0" cellpadding="0" cellspacing="5" width="100%">
    <tr>
        <td align="right" valign="top" width="22%"><strong>Golongan :</strong></td>
        <td width="*" align="left" valign="top">
        <select name="cbGolongan" id="cbGolongan" onKeyPress="return focusNext('cbTglTMTGol', event)">
    <?	OpenDb();
		$sql = "SELECT golongan FROM jbssdm.golongan ORDER BY urutan";
        $result = QueryDb($sql);
        while ($row = mysqli_fetch_row($result)) { ?>    
            <option value="<?=$row[0]?>" <?=StringIsSelected($row[0], $gol)?>><?=$row[0]?></option>
    <?	} 
		CloseDb();
		?>    
        </select>
        </td>
	</tr>
	<tr>
        <td align="right" valign="top"><strong>TMT :</strong></td>
        <td width="*" align="left" valign="top">
        <select id="cbTglTMTGol" name="cbTglTMTGol" onKeyPress="return focusNext('cbBlnTMTGol', event)">
    <?	for ($i = 1; $i <= 31; $i++) { ?>    
            <option value="<?=$i?>" <?=IntIsSelected($i, $tgltmtgol)?>><?=$i?></option>	
    <?	} ?>    
        </select>
        <select id="cbBlnTMTGol" name="cbBlnTMTGol" onKeyPress="return focusNext('txThnTMTGol', event)">
    <?	for ($i = 1; $i <= 12; $i++) { ?>    
            <option value="<?=$i?>" <?=IntIsSelected($i, $blntmtgol)?>><?=NamaBulan($i)?></option>	
    <?	} ?>    
        </select>
        <input type="text" name="txThnTMTGol" onKeyPress="return focusNext('txSK', event)" id="txThnTMTGol" size="4" maxlength="4" value="<?=$thntmtgol?>"/>
        </td>
	</tr>
    <tr>
    	<td align="right">SK : </td>
	    <td align="left" valign="top">
        <input type="text" name="txSK" value="<?=$sk?>" id="txSK" size="30" maxlength="100" onKeyPress="return focusNext('txKeterangan', event)" />
        </td>
    </tr>
    <tr>
    	<td align="right" valign="top">Keterangan : </td>
	    <td align="left" valign="top">
        <textarea id="txKeterangan" name="txKeterangan" rows="2" cols="40" onKeyPress="return focusNext('txAlasan', event)"><?=$keterangan?></textarea>
        </td>
    </tr>
    <tr>
    	<td align="right" valign="top">&nbsp;</td>
	    <td align="left" valign="top">
        <input type="submit" value="Simpan" name="btSubmit" id="btSubmit" class="but" />
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
