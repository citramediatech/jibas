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
require_once("../include/sessionchecker.php");

if (isset($_REQUEST['semester']))
	$semester = $_REQUEST['semester'];
if (isset($_REQUEST['tingkat']))
	$tingkat = $_REQUEST['tingkat'];
if (isset($_REQUEST['pelajaran']))
	$pelajaran = $_REQUEST['pelajaran'];
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];

$kode = "";
if (isset($_REQUEST['kode']))
	$kode = $_REQUEST['kode'];
$materi = "";
if (isset($_REQUEST['materi']))
	$materi = $_REQUEST['materi'];	
$deskripsi = "";
if (isset($_REQUEST['deskripsi']))
	$deskripsi = $_REQUEST['deskripsi'];	

$ERROR_MSG = "";

if (isset($_REQUEST['Simpan'])) {
	OpenDb();
	$sql = "SELECT * FROM rpp WHERE koderpp = '$kode'";
	$result = QueryDb($sql);
	
	if (mysqli_num_rows($result) > 0) {
		CloseDb();
		?>
        <script language="javascript">
			alert ('Kode pembelajaran <?=$kode?> sudah digunakan!');
		</script>
        <?	
	} else {
		$sql = "INSERT INTO rpp SET idtingkat = '$tingkat', idsemester = '$semester', idpelajaran = '$pelajaran', koderpp = '$kode', rpp = '$materi', deskripsi = '$deskripsi'";
		$result = QueryDb($sql);
		CloseDb();
	
		if ($result) { ?>
			<script language="javascript">
				opener.refresh();
				//opener.location.href = "rpp_footer.php?semester=<?=$semester?>&tingkat=<?=$tingkat?>&pelajaran=<?=$pelajaran?>&urut=<?=$urut?>&urutan=<?=$urutan?>";
				window.close();
			</script> 
<?		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS INFOGURU [Tambah Rencana Program Pembelajaran]</title>
<script src="../script/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../script/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script src="../script/tinymce/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script language="javascript">
//textarea
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "safari,pagebreak,style,layer,table,save,advhr,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",		
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,forecolor,backcolor,fullscreen,print",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false,
	content_css : "../style/word.css"
});

function validate() {
	return 	validateEmptyText('kode', 'Kode pembelajaran') && 
			validateEmptyText('materi', 'Materi pembelajaran') && 
		   	validateMaxText('materi', 255, 'Materi pembelajaran');
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
<style type="text/css">
<!--
.style1 {
	font-family: Arial;
	font-weight: bold;
	font-size: 14px;
}
-->
</style>
</head>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style=" background-image:url(../images/bgpop.jpg); background-repeat:repeat-x" onLoad="document.getElementById('kode').focus();">
<form name="main" onSubmit="return validate()">
<input type="hidden" name="semester" id="semester" value="<?=$semester?>"/>
<input type="hidden" name="tingkat" id="tingkat" value="<?=$tingkat?>"/>
<input type="hidden" name="pelajaran" id="pelajaran" value="<?=$pelajaran?>"/>
<input type="hidden" name="urut" id="urut" value="<?=$urut?>"/>
<input type="hidden" name="urutan" id="urutan" value="<?=$urutan?>"/>
<table border="0" width="100%" cellpadding="2" cellspacing="2" align="center">
<!-- TABLE CONTENT -->
<tr height="25">
<td colspan="2" align="left"><font size="+2" style="background-color:#FF9900">&nbsp;&nbsp;</font>&nbsp;<span class="style1">Rencana Program Pembelajaran</span><br /><br /></td>
</tr>
<tr>
	<td width="50"><strong>Kode</strong></td>
	<td>
    	<input type="text" name="kode" id="kode" size="10" maxlength="20" value="<?=$kode?>" onFocus="showhint('Kode pembelajaran tidak boleh lebih dari 20 karakter!', this, event, '120px')"  onKeyPress="return focusNext('materi', event)"/>
    </td>
</tr>
<tr>
	<td valign="top"><strong>Materi</strong></td>
	<td><input type="text" name="materi" id="materi" size="83" maxlength="225" value="<?=$materi?>" onFocus="showhint('Materi pembelajaran tidak boleh lebih dari 225 karakter!', this, event, '120px')"  onKeyPress="return focusNext('deskripsi', event)"/>
    	<!--<textarea name="materi" id="materi" rows="3" cols="45"><?=$materi ?></textarea>-->
    </td>
</tr>
<tr>
	<td colspan = "2" height="200" valign="top">
	<fieldset><legend><b>Deskripsi Program Pembelajaran</b></legend>
    <br />
    <textarea name="deskripsi" id="deskripsi" rows="20"><?=$deskripsi?></textarea>
    </fieldset>
</tr>

<tr>
	<td colspan="2" align="center">
    <input type="submit" name="Simpan" id="Simpan" value="Simpan" class="but" />&nbsp;
    <input type="button" name="Tutup" id="Tutup" value="Tutup" class="but" onClick="window.close()" />
    </td>
</tr>
<!-- END OF TABLE CONTENT -->
</table>
</form>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("materi");
var sprytextfield2 = new Spry.Widget.ValidationTextField("kode");
</script>