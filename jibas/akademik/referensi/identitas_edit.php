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
require_once('../include/theme.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../cek.php');
$departemen=$_REQUEST['departemen'];
$title = "Sekolah";
if ($departemen=='yayasan')
	$title = "";


OpenDb();
$sql = "SELECT * FROM jbsumum.identitas WHERE departemen='$departemen'";
$result = QueryDb($sql);
$row = mysqli_fetch_array($result);
$nama = $row['nama'];
$alamat1 = $row['alamat1'];
$alamat2 = $row['alamat2'];
$tlp1 = $row['telp1'];
$tlp2 = $row['telp2'];
$tlp3 = $row['telp3'];
$tlp4 = $row['telp4'];
$fax1 = $row['fax1'];
$fax2 = $row['fax2'];
$situs = $row['situs'];
$email = $row['email'];
$replid = $row['replid'];

if (isset($_REQUEST['nama']))
	$nama = CQ($_REQUEST['nama']);
if (isset($_REQUEST['alamat1']))
	$alamat1 = CQ($_REQUEST['alamat1']);
if (isset($_REQUEST['alamat2']))
	$alamat2 = CQ($_REQUEST['alamat2']);
if (isset($_REQUEST['tlp1']))
	$tlp1 = CQ($_REQUEST['tlp1']);	
if (isset($_REQUEST['tlp2']))
	$tlp2 = CQ($_REQUEST['tlp2']);	
if (isset($_REQUEST['tlp3']))
	$tlp3 = CQ($_REQUEST['tlp3']);
if (isset($_REQUEST['tlp4']))
	$tlp4 = CQ($_REQUEST['tlp4']);
if (isset($_REQUEST['fax1']))
	$fax1 = CQ($_REQUEST['fax1']);
if (isset($_REQUEST['fax2']))
	$fax2 = CQ($_REQUEST['fax2']);	
if (isset($_REQUEST['situs']))
	$situs = CQ($_REQUEST['situs']);	
if (isset($_REQUEST['email']))
	$email = CQ($_REQUEST['email']);

if (isset($_REQUEST['Simpan'])) {
	OpenDb();	
	$sql = "UPDATE jbsumum.identitas SET nama='$nama', situs='$situs', email='$email', alamat1='$alamat1', alamat2='$alamat2', telp1='$tlp1', telp2='$tlp2', telp3='$tlp3', telp4='$tlp4', fax1='$fax1', fax2='$fax2' WHERE departemen = '$departemen'";
	$result = QueryDb($sql);
	CloseDb();			
	if ($result) { 	
	?>
		<script language="javascript">
			opener.getfresh();
			window.close();
		</script> 
<?	}
	
}

CloseDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Ubah Identitas <?=$title?>]</title>
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript">

function validate() {
	return validateEmptyText('nama', 'Nama Sekolah') &&
			cekEmail();
	
}

function cekEmail() {
	if (!validateEmail("email") ) { 
		alert( "Email yang Anda masukkan bukan merupakan alamat email!" );
		document.getElementById('email')focus();
		return false;	
	}	
	return true;
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

function panggil(elem){
	var lain = new Array('nama','alamat1','alamat2','tlp1','tlp2','tlp3','tlp4','fax1','fax2','situs','email');
	for (i=0;i<lain.length;i++) {
		if (lain[i] == elem) {
			document.getElementById(elem).style.background='#4cff15';
		} else {
			document.getElementById(lain[i]).style.background='#FFFFFF';
		}
	}
}

</script>
</head>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"  style="background-color:#dcdfc4" onLoad="document.getElementById('nama').focus();">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">
	<div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold">
    .: Identitas Sekolah :.
    </div>
	</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF">
<form name="main" onSubmit="return validate()" method="post">
<input type="hidden" name="departemen" id="departemen" value="<?=$departemen ?>" />   
<table border="0" width="95%" cellpadding="2" cellspacing="2" align="center">
<!-- TABLE CONTENT -->
<tr>
	<td width="20%"><strong>Nama</strong></td>
    <td><input type="text" name="nama" id="nama" size="80" maxlength="250" value="<?=$nama ?>"onKeyPress="return focusNext('alamat1', event)"  onFocus="panggil('nama')"/></td>
</tr>
<tr>
	<td colspan="2">
    <table border="0" width="100%" align="center">
    <tr><td width="50%">
	<fieldset><legend><b>Lokasi 1</b></legend>
    <table border="0" width="100%" cellpadding="2" cellspacing="2" align="center">
    <tr>	
        <td valign="top">Alamat</td>
        <td>
            <textarea name="alamat1" id="alamat1" rows="3" style="width:190px"  onKeyPress="return focusNext('tlp1', event)" onFocus="panggil('alamat1')"><?=$alamat1 ?></textarea>
        </td>
    </tr>   
    <tr>
        <td>No Telp1</td>
        <td><input type="text" name="tlp1" id="tlp1" size="30" maxlength="50" value="<?=$tlp1 ?>"onKeyPress="return focusNext('tlp2', event)" onFocus="panggil('tlp1')"/>
        </td>
    </tr>
    <tr>
        <td>No Telp2</td>
        <td><input type="text" name="tlp2" id="tlp2" size="30" maxlength="50" value="<?=$tlp2 ?>"onKeyPress="return focusNext('fax1', event)" onFocus="panggil('tlp2')"/>
        </td>
    </tr>
    <tr>
        <td>No Fax</td>
        <td><input type="text" name="fax1" id="fax1" size="30" maxlength="50" value="<?=$fax1 ?>"onKeyPress="return focusNext('alamat2', event)" onFocus="panggil('fax1')"/>
        </td>
    </tr>
   	</table>
	</fieldset>
	</td><td>
    <fieldset><legend><b>Lokasi 2</b></legend>
    <table border="0" width="100%" cellpadding="2" cellspacing="2" align="center">
    <tr>	
        <td valign="top">Alamat</td>
        <td>
            <textarea name="alamat2" id="alamat2" rows="3" style="width:190px" onKeyPress="return focusNext('tlp3', event)" onFocus="panggil('alamat2')"><?=$alamat2 ?></textarea>
        </td>
    </tr>
    <tr>
        <td>No Telp1</td>
        <td><input type="text" name="tlp3" id="tlp3" size="30" maxlength="50" value="<?=$tlp3 ?>" onKeyPress="return focusNext('tlp4', event)" onFocus="panggil('tlp3')"/>
        </td>
    </tr>
    <tr>
        <td>No Telp2</td>
        <td><input type="text" name="tlp4" id="tlp4" size="30" maxlength="50" value="<?=$tlp4 ?>" onKeyPress="return focusNext('fax2', event)" onFocus="panggil('tlp4')"/>
        </td>
    </tr>
     <tr>
        <td>No Fax</td>
        <td><input type="text" name="fax2" id="fax2" size="30" maxlength="50" value="<?=$fax2 ?>" onKeyPress="return focusNext('situs', event)" onFocus="panggil('fax2')"/>
        </td>
    </tr>
   	</table>
	</fieldset>
    </td>
    </tr>    
    </table>
    </td>
</tr>
<tr>
	<td>Website</td>
	<td><input type="text" name="situs" id="situs" size="80" maxlength="100" value="<?=$situs ?>" onKeyPress="return focusNext('email', event)" onFocus="panggil('situs')"/>
    </td>
</tr>
<tr>
	<td>Email</td>
	<td><input type="text" name="email" id="email" size="80" maxlength="100" value="<?=$email?>" onKeyPress="return focusNext('Simpan', event)" onFocus="panggil('email')"/>
    </td>
</tr>
<tr>
	<td colspan="2" align="center">
    <input type="submit" name="Simpan" id="Simpan" value="Simpan" class="but" onFocus="panggil('Simpan')" />&nbsp;    
    <input type="button" name="Tutup" id="Tutup" value="Tutup" class="but" onClick="window.close()" />
    </td>
</tr>
<!-- END OF TABLE CONTENT -->
</table>
</form>
</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_06a.jpg">&nbsp;</td>
</tr>
<tr height="28">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_07.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_08a.jpg">&nbsp;</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_09.jpg">&nbsp;</td>
</tr>
</table>

<!-- Tamplikan error jika ada -->
<? if (strlen($ERROR_MSG) > 0) { ?>
<script language="javascript">
	alert('<?=$ERROR_MSG?>');
</script>
<? } ?>

<!-- Pilih inputan pertama -->

</body>
</html>
<script language="javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("nama");
var sprytextfield1 = new Spry.Widget.ValidationTextField("situs");
var sprytextfield1 = new Spry.Widget.ValidationTextField("email");
var sprytextfield1 = new Spry.Widget.ValidationTextField("tlp1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("tlp2");
var sprytextfield1 = new Spry.Widget.ValidationTextField("tlp3");
var sprytextfield1 = new Spry.Widget.ValidationTextField("tlp4");
var sprytextfield1 = new Spry.Widget.ValidationTextField("fax1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("fax2");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("alamat1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("alamat2");

</script>