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
require_once('../include/common.php');
require_once('../include/rupiah.php');
require_once('../include/theme.php');
require_once('../include/config.php');
require_once('../include/sessioninfo.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');

$login = SI_USER_ID();

if (isset($_REQUEST['simpan'])) {
	$nip=trim($_REQUEST['nip']);
	$login=trim($_REQUEST['login']);
	if ($login=='landlord' || $login=='LANDLORD'){
		OpenDb();
		$sql = "SELECT password FROM jbsuser.landlord WHERE password=md5('$_REQUEST[passlama]')";
		$result = QueryDb($sql);
		if (mysqli_num_rows($result) == 0) {
			CloseDb(); 
			$MYSQL_ERROR_MSG = "Password lama Anda tidak cocok!";
		} else {
			$sql = "UPDATE jbsuser.landlord SET password=md5('$_REQUEST[pass1]')";
			$result = QueryDb($sql);
			CloseDb();
			$MYSQL_ERROR_MSG = "Password Administrator telah berubah!";	
			$exit = 1;
		}	
	} else {
		OpenDb();
		$sql = "SELECT login FROM jbsuser.login WHERE password=md5('$_REQUEST[passlama]') AND login='$nip'";
		$result = QueryDb($sql);
		if (mysqli_num_rows($result) == 0) {
			CloseDb(); 
			$MYSQL_ERROR_MSG = "Password lama Anda tidak cocok!";
		} else {
			$sql = "UPDATE jbsuser.login SET password=md5('$_REQUEST[pass1]') WHERE login='$nip'";
			$result = QueryDb($sql);
			CloseDb();
			$MYSQL_ERROR_MSG = "Password Anda telah berubah!";	
			$exit = 1;
		}
	}
	
}

OpenDb();
if ($login=='landlord' || $login=='LANDLORD'){
	$nip = "";
	$nama = "Administator";
	$title = "Administrator";
} else {
	$sql = "SELECT p.nip, p.nama FROM jbssdm.pegawai p WHERE p.nip = '$login'"; 
	$result = QueryDb($sql);
	$row = mysqli_fetch_row($result);
	$nip = $row[0];
	$nama = $row[1];
	$title = "Pengguna";
}
CloseDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ganti Password Pengguna</title>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script src="../script/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../script/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function validasi() {
		var passlama = document.getElementById('passlama').value;
		var pass1 = document.getElementById('pass1').value;
		var pass2 = document.getElementById('pass2').value;
		if (passlama.length==0){
			alert('Anda harus mengisikan data untuk Password Lama!');
			document.getElementById('passlama').focus();
			return false;
		}
		if (pass1.length==0){
			alert('Silakan masukan password baru!');
			document.getElementById('pass1').focus();
			return false;
		}
		if (pass2.length==0){
			alert('Silakan masukan password baru (ulang)!');
			document.getElementById('pass2').focus();
			return false;
		}
		if (pass1 != pass2) {
			alert('Password yang anda masukkan tidak sama!');
			document.getElementById('pass2').focus();
			return false;
		} else {
			return true;
		}
	
}
</script>
</head>
<body onLoad="document.getElementById('passlama').focus();" style="margin-left:0px; margin-top:0px; margin-bottom:0px; margin-right:0px;">
    <form name="main" method="post" onSubmit="return validasi();"> 
    <input type="hidden" name="login" id="login" value="<?=$login ?>" />
    <table border="1" cellpadding="0" cellspacing="0" class="tab" align="center">
    <tr>
        <td colspan="2" class="header" align="center" height="30">Ubah Password <?=$title?></td>
    </tr>
    <tr>
        <td align="left" class="td">Nama:</td>
        <td align="left" class="td">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
              <? if ($login!='landlord' && $login!='LANDLORD'){ ?>
                    <input type="text" name="nip" id="nip" size="10" readonly="readonly" value="<?=$nip ?>"  style="background-color:#CCCCCC"/>
                <? } ?>
            </td>
            <td><input type="text" name="nama" id="nama" size="20" readonly="readonly" value="<?=$nama ?>"  style="background-color:#CCCCCC"/></td>
          </tr>
        </table>
    </tr>
    <tr>
    	<td align="left" class="td">Password Lama:</td>
        <td align="left" class="td"><input type="password" name="passlama" id="passlama" size="20" /></td>
    </tr>
    <tr>
    	<td align="left" class="td">Password:</td>
        <td align="left" class="td"><input type="password" name="pass1" id="pass1" size="20" /></td>
    </tr>
    <tr>
    	<td align="left" class="td">Ulangi Password:</td>
        <td align="left" class="td"><input type="password" name="pass2" id="pass2" size="20" /></td>
    </tr>
    <tr>
        <td colspan="2" align="left" class="td">
        	<div align="center">
        	  <input class="but" type="submit" value="Ganti" name="simpan">&nbsp;
        	  <input class="but" type="button" value="Tutup" onClick="window.close();">        
      	  </div></td>
        </tr>
    </table>
	  <script language='JavaScript'>
	    //Tables('table', 1, 0);
    </script>
    </form>
<? if (strlen($MYSQL_ERROR_MSG) > 0) { ?>
<script language="javascript">
    alert('<?=$MYSQL_ERROR_MSG ?>');
</script>
<? } ?>
</body>
</html>
<? if ($exit) { ?>
<script language="javascript">
    window.close();
</script>
<? } ?>
<script language="javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("passlama");
var sprytextfield2 = new Spry.Widget.ValidationTextField("pass1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("pass2");
</script>