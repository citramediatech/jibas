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
//require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/theme.php');
require_once('../cek.php');

if (isset($_REQUEST['departemen']))
	$departemen = CQ($_REQUEST['departemen']);

$sekolah=CQ($_REQUEST['sekolah']);
$ERROR_MSG ="";
if (isset($_POST['simpan'])) {
	OpenDb();
	
	$sql_cek="SELECT * FROM jbsakad.asalsekolah where sekolah='$sekolah' AND departemen='$departemen'"; 
	$hasil=QueryDb($sql_cek);
	if (mysqli_num_rows($hasil)>0){		
		CloseDb();
		$ERROR_MSG = "Nama Sekolah $sekolah sudah digunakan!";
	} else { 
		$sql = "INSERT INTO jbsakad.asalsekolah SET sekolah='$sekolah',departemen='$departemen'";
		$result = QueryDb($sql);
		CloseDb();
		if ($result) { 
		?>

		<script language="javascript">
			opener.document.location.href="siswa_add_asalsekolah.php?sekolah=<?=$sekolah?>&departemen=<?=$departemen?>";
			
			//opener.refresh();
			window.close();
		</script> 
<?	
		
		}
	}
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script src="../script/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="JavaScript" src="../script/tooltips.js"></script>
<title>JIBAS SIMAKA [Tambah Asal Sekolah]</title>
<script language="javascript">
function cek() {
	var sekolah = document.main.sekolah.value;
	var departemen = document.main.departemen.value;
	if (sekolah.length == 0) {
		alert('Anda belum memasukkan Nama Sekolah');
		document.main.sekolah.focus();
		return false;
	}
	if (sekolah.length > 100) {
		alert('Nama sekolah tidak boleh lebih dari 100 karakter');
		return false;
	}
	
	if (departemen.length == 0) {
		alert('Anda belum memasukkan Departemen');
		document.main.departemen.focus();
		return false;
	}
	if (departemen.length > 100) {
		alert('Departemen tidak boleh lebih dari 100 karakter');
		return false;
	}
	return true;
	document.location.href="siswa_add_asalsekolah_tambah.php?sekolah="+sekolah+"&departemen="+departemen;
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

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#dcdfc4" onLoad="document.getElementById('sekolah').focus();">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">
	<div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold">
    .: Tambah Asal Sekolah :.
    </div>
	</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF">
    <!-- CONTENT GOES HERE //--->
    <form name="main" method="post" onSubmit="return cek();">    
    <table border="0" width="95%" cellpadding="2" cellspacing="2" align="center">
	<!-- TABLE CONTENT -->
    <tr>
        <td width="35%"><strong>Departemen</strong></td>
        <td><input name="departemen" id="departemen" size="10" value="<?=$departemen?>">
			
		</td>
    </tr>
    <tr>
        <td><strong>Sekolah</strong></td>
        <td><input name="sekolah" id="sekolah" maxlength="100" size="30" value="<?=$sekolah?>" onKeyPress="return focusNext('Simpan', event)"></td>
    </tr>   
    <tr>    
        <td align="center" colspan="2">
        	<input class="but" type="submit" value="Simpan" name="simpan" id="Simpan">
            <input class="but" type="button" value="Tutup" onClick="window.close();">
        </td>
    </tr>
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

</body>
</html>
<script language="javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sekolah");
var sprytextfield2 = new Spry.Widget.ValidationTextField("departemen");
</script>