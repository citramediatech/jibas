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

if (isset($_REQUEST['jenismutasi']))
	$jenismutasi=CQ($_REQUEST['jenismutasi']);
	
if (isset($_REQUEST['keterangan']))	
	$keterangan=CQ($_REQUEST['keterangan']);

$ERROR_MSG = "";
if (isset($_REQUEST['Simpan'])) {
	OpenDb();
	$sql = "SELECT * FROM jbsakad.jenismutasi WHERE jenismutasi='$jenismutasi'";
	$result = QueryDb($sql);
	$row = mysqli_num_rows($result);
	if (mysqli_num_rows($result) > 0){ 
		CloseDb();
		$ERROR_MSG = "Jenis Mutasi $jenismutasi sudah digunakan!";	
    } else {
        $sql = "INSERT INTO jbsakad.jenismutasi SET jenismutasi='$jenismutasi',keterangan='$keterangan'";
        $result = QueryDb($sql);
        if ($result){
    ?>
            <script language="javascript">
				opener.refresh();
                window.close();
            </script>
    <?
    	}
	}
	CloseDb();
}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../style/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Tambah Jenis Mutasi]</title>
<SCRIPT language="JavaScript" src="../script/validasi.js"></SCRIPT>
<SCRIPT language="JavaScript" src="../script/tables.js"></SCRIPT>
<SCRIPT language="javascript" src="../script/common.js"></script>
<SCRIPT language="javascript" src="../script/tools.js"></script>
<script language="JavaScript" src="../script/tooltips.js"></script>
<script src="../script/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../script/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../script/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
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

function validate(){
	return	validateEmptyText('jenismutasi', 'Jenis Mutasi') &&
			validateMaxText('keterangan', 255, 'Keterangan');
}			
</script>
</head>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#dcdfc4" onLoad="document.getElementById('jenismutasi').focus()">
<form name="mutasi" action="tambah_jenis_mutasi.php" method="post" onSubmit="return validate()">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">
	<div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold">
    .: Tambah Jenis Mutasi :.
    </div>
	</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF">
    <!-- CONTENT GOES HERE //--->
    <table width="95%" border="0" cellspacing="2" cellpadding="2" align="center">
    <tr>
       <td width="80"><strong>Jenis Mutasi </strong></td>
       <td><input name="jenismutasi" type="text" id="jenismutasi" size="30" maxlength="45" value="<?=$jenismutasi?>" onKeyPress="return focusNext('keterangan', event)"></td>
    </tr>
    <tr valign="top">
       <td>Keterangan</td>
       <td><textarea name="keterangan" cols="30" rows="4" id="keterangan" onKeyPress="return focusNext('simpan', event)"><?=$keterangan?></textarea></td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
    	<input name="Simpan" type="Submit" class="but" value="Simpan" id="simpan">&nbsp;                     
        <input name="Tutup" type="button" class="but" value="Tutup" onClick="window.close()">
       	</td>
    </tr>
    </table>
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
</form>
<!-- Tamplikan error jika ada -->
<? if (strlen($ERROR_MSG) > 0) { ?>
<script language="javascript">
	alert('<?=$ERROR_MSG?>');
</script>
<? } ?>
</body>
</html>
<script language="javascript">
	var sprytextfield1 = new Spry.Widget.ValidationTextField("jenismutasi");
	var sprytextarea1 = new Spry.Widget.ValidationTextarea("keterangan");
</script>