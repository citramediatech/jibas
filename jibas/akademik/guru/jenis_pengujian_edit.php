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

$replid = $_REQUEST['replid'];
$ERROR_MSG = "";
if (isset($_REQUEST['Simpan'])) {
	OpenDb();
	$sql = "SELECT * FROM jenisujian WHERE jenisujian = '".CQ($_REQUEST['jenisujianbaru'])."' AND replid<>'$replid' AND idpelajaran = '$_REQUEST[idpelajaran]' AND info1='$_REQUEST[singkatan]'";
	$result = QueryDb($sql);
	if (mysqli_num_rows($result) > 0) {
		$jenisujian=$_REQUEST['jenisujianbaru'];
		CloseDb();
		$ERROR_MSG = "Jenis Ujian $jenisujian sudah digunakan!";
	} else {
		$sql = "UPDATE jenisujian SET replid='$_REQUEST[replid]',jenisujian='".CQ($_REQUEST['jenisujianbaru'])."',info1='".CQ($_REQUEST['singkatan'])."',keterangan='".CQ($_REQUEST['keterangan'])."' WHERE jenisujian='$_REQUEST[jenisujian]' AND replid='$_REQUEST[replid]'";
		$result = QueryDb($sql);
		CloseDb();
	
		if ($result) { ?>
			<script language="javascript">
				opener.refresh();
				window.close();
			</script> 
<?		
	}
}
}

OpenDb();

$sql = "SELECT j.replid,j.jenisujian,j.idpelajaran,j.keterangan,p.replid,p.nama,p.departemen,j.info1 FROM jenisujian j, pelajaran p WHERE j.replid = '$replid' AND j.idpelajaran = p.replid";   
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$jenisujian = $row[1];
if (isset($_REQUEST['jenisujian']))
	$jenisujian = $_REQUEST['jenisujian'];
$keterangan = $row[3];
if (isset($_REQUEST['keterangan']))
	$keterangan = $_REQUEST['keterangan'];
$pelajaran = $row[5];
$idpelajaran = $row[2];
$departemen = $row[6];
$singkatan = $row[7];


CloseDb();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Ubah Jenis Pengujian]</title>
<script src="../script/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script src="../script/SpryValidationTextfield.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextfield.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript">

function validate() {
	return validateEmptyText('jenisujianbaru', 'Jenis Pengujian') && 
		   validateEmptyText('singkatan', 'Singkatan') && 
		   validateMaxText('keterangan', 255, 'Keterangan');
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

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#dcdfc4" onLoad="document.getElementById('jenisujianbaru').focus();">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">
	<div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold">
    .: Ubah Jenis Pengujian :.
    </div>
	</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF">
    <!-- CONTENT GOES HERE //--->
<form name="main" onSubmit="return validate()">
<input type="hidden" name="replid" id="replid" value="<?=$replid ?>" />
<input type="hidden" name="idpelajaran" id="idpelajaran" value="<?=$idpelajaran ?>" />
<table border="0" width="95%" cellpadding="2" cellspacing="2" align="center">
<!-- TABLE CONTENT -->
<tr>
  <td><strong>Departemen</strong></td>
  <td><input type="text" name="departemen" id="departemen" size="10" maxlength="10" value="<?=$departemen ?>"  class="disabled" readonly/></td>
</tr>
<tr>
  <td><strong>Pelajaran</strong></td>
  <td><input type="text" name="pelajaran" id="pelajaran" size="30" maxlength="50" value="<?=$pelajaran ?>" class="disabled" readonly/></td>
</tr>
<tr>
	<td><strong>Jenis Pengujian</strong></td>
	<td>
    	<input type="text" name="jenisujianbaru" id="jenisujianbaru" size="30" maxlength="50" value="<?=$jenisujian ?>" onFocus="showhint('Nama jenis pengujian tidak boleh lebih dari 50 karakter!', this, event, '120px')" onKeyPress="return focusNext('singkatan', event)" /> <input type="hidden" name="jenisujian" id="jenisujian" size="30" maxlength="50" value="<?=$jenisujian ?>" />   </td>
</tr>
<tr>
	<td><strong>Singkatan</strong></td>
	<td>
    	<input type="text" name="singkatan" id="singkatan" size="10" maxlength="10" value="<?=$singkatan ?>" onFocus="showhint('Nama singkatan tidak boleh lebih dari 10 karakter!', this, event, '120px')" onKeyPress="return focusNext('keterangan', event)" /></td>
</tr>
<tr>
	<td valign="top">Keterangan</td>
	<td>
    	<textarea name="keterangan" id="keterangan" rows="3" cols="45" onKeyPress="return focusNext('Simpan', event)"><?=$keterangan ?></textarea>    </td>
</tr>
    <!--
<tr>
	<td colspan="2" height="25" width="100%" align="left" valign="top" style="border-width:1px; border-style:dashed; border-color:#03F; background-color:#CFF">				      
	<strong>Anda hanya perlu mengisikan nama jenis pengujian dan singkatannya. Penamaan jenis pengujian juga ditambahkan dengan kriteria/aspek penilaiannya. </strong><br />
	  <strong>Tidak perlu menambahkan tahun ajaran, semester atau nomor pengujian.<br />
	  <font color="#FF0000">Contoh yang salah : UTS 2010/2011 Semester 1 ke-1 </font><br />
	  <font color="Blue">Contoh yang benar : UAS Praktek, UAS Pemahaman Konsep</font></strong>
	</td>
</tr>
-->
<tr>
	<td colspan="2" align="center">
    <input type="submit" name="Simpan" id="Simpan" value="Simpan" class="but" />&nbsp;
    <input type="button" name="Tutup" id="Tutup" value="Tutup" class="but" onClick="window.close()" />    </td>
</tr>
<!-- END OF TABLE CONTENT -->
</table>
</form>
 <!-- END OF CONTENT //--->
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
</body>
</html>
<script language="javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("jenisujianbaru");
var sprytextfield2 = new Spry.Widget.ValidationTextField("singkatan");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("keterangan");
</script>