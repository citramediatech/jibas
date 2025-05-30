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

if (isset($_REQUEST['replid']))	
	$replid = $_REQUEST['replid'];

if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

if (isset($_REQUEST['nipguru']))
	$nipguru = $_REQUEST['nipguru'];
	
if (isset($_REQUEST['nama']))
	$nama = $_REQUEST['nama'];	
	
if (isset($_REQUEST['status']))
	$status = $_REQUEST['status'];	

if (isset($_REQUEST['pelajaran']))
	$pelajaran = $_REQUEST['pelajaran'];	

if (isset($_REQUEST['keterangan']))
	$keterangan = CQ($_REQUEST['keterangan']);	

$ERROR_MSG = "";
if (isset($_REQUEST['Simpan'])) {
	OpenDb();	
	$sql1 = "SELECT * FROM guru g, pelajaran p WHERE p.departemen = '$departemen' AND g.nip = '$nipguru' AND g.idpelajaran = '$pelajaran' AND g.statusguru = '$status' AND g.idpelajaran = p.replid AND g.replid <> '$replid' ";	
	$result1 = QueryDb($sql1);

	if (mysqli_num_rows($result1) > 0) {
		CloseDb();		
		$ERROR_MSG = "Nama guru $nama sudah digunakan!";
	} else {	
		$sql_update = "UPDATE guru SET nip='$nipguru', idpelajaran='$pelajaran', statusguru='$status', keterangan='$keterangan' WHERE replid='$replid'";
		$result_update = QueryDb($sql_update);
		
		if ($result_update) { ?>
        	<script language="javascript">		
				opener.refresh();
				window.close();
			</script> 
<?
		}
	}
}

OpenDb();
$sql = "SELECT g.nip,g.statusguru,g.keterangan,l.departemen,p.nama,g.idpelajaran,l.nama AS pelajar FROM guru g, pelajaran l, jbssdm.pegawai p WHERE g.replid='$replid' AND p.nip = g.nip AND l.replid = g.idpelajaran";
$result = QueryDb($sql);
$row = mysqli_fetch_array($result);
$keterangan = $row['keterangan'];
$departemen = $row['departemen'];
$nipguru = $row['nip'];
$pelajar = $row['pelajar'];
$pelajaran = $row['idpelajaran'];
$status = $row['statusguru'];
$namaguru = $row['nama'];

if (isset($_REQUEST['status']))
	$status = $_REQUEST['status'];
if (isset($_REQUEST['namaguru']))
	$namaguru = $_REQUEST['namaguru'];
if (isset($_REQUEST['nipguru']))
	$nipguru = $_REQUEST['nipguru'];
if (isset($_REQUEST['pelajaran']))
	$pelajaran = $_REQUEST['pelajaran'];
if (isset($_REQUEST['keterangan']))
	$keterangan = $_REQUEST['keterangan'];
	
CloseDb();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Ubah Guru]</title>
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript">
function caripegawai() {
	newWindow('../library/caripegawai.php?flag=0', 'CariPegawai','500','565','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function acceptPegawai(nip, nama, flag) {
	document.getElementById('nip').value = nip;	
	document.getElementById('nama').value = nama;
	document.getElementById('nipguru').value = nip;
	document.getElementById('namaguru').value = nama;	
	document.getElementById('status').focus();		
}

function tutup() {
	document.getElementById('status').focus();
}

function validate() {
	return validateEmptyText('nip', 'NIP Guru') && 		   
		   validateMaxText('keterangan', 255, 'Keterangan');
}

function focusNext(elemName, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13) {
		document.getElementById(elemName).focus();
		if (elemName == 'nip')
			caripegawai();
		return false;
    } 
    return true;
}

function panggil(elem){
	var lain = new Array('pelajaran','status','keterangan');
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

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#dcdfc4" onLoad="document.getElementById('status').focus();">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">
	<div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold">
    .: Ubah Guru :.
    </div>
	</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF">
    <!-- CONTENT GOES HERE //--->
<form name="main" onSubmit="return validate()" >
<input type="hidden" name="replid" id="replid" value="<?=$replid?>" />
<input type="hidden" name="aktif" id="aktif" value="<?=$_REQUEST['aktif'] ?>" />
<table border="0" width="95%" cellpadding="2" cellspacing="2" align="center">
<!-- TABLE CONTENT -->
<tr>
	<td width="120"><strong>Departemen</strong></td>
	<td>
    	<input type="text" name="departemen" id="departemen" size="10" maxlength="50" readonly value="<?=$departemen ?>" class="disabled" />
        <input type="hidden" name="departemen" id="departemen" value="<?=$departemen ?>" /> 
	</td>
</tr>
<tr>
	<td><strong>Pelajaran</strong></td>
	<td> 
	<?	if ($_REQUEST['aktif'] == 1) { ?>
    	<input type="text" name="pelajaran" id="pelajaran" size="40" maxlength="50" readonly value="<?=$pelajar ?>" class="disabled"/>
        <input type="hidden" name="pelajaran" id="pelajaran" value="<?=$pelajaran ?>" /> 
	  
	<? 	} else { ?>    	
    	<select name="pelajaran" id="pelajaran" onKeyPress="return focusNext('nip', event)" onFocus="panggil('pelajaran')" style="width:255px">
          <?
          	OpenDb();
			$sql = "SELECT kode,nama,replid FROM pelajaran WHERE departemen = '$departemen' AND aktif =1 ORDER BY nama ASC";    
			$result = QueryDb($sql);	
			CloseDb();
			while ($row = @mysqli_fetch_array($result)) {
		?>				
          <option value="<?=$row['replid'] ?>" <?=IntIsSelected($row['replid'], $pelajaran) ?> >
		  <?=$row['nama'] ?>
          </option>
          <?	
		  	} 
		?>
        </select>
        <? } ?>
	</td>
</tr>
<tr>
    <td><strong>Guru</strong></td>
    <td>
      <input type="text" name="nip" id="nip" size="10" readonly value="<?=$nipguru ?>" class="disabled"  onClick="caripegawai()" onKeyPress="caripegawai();" onFocus="panggil('nip')"/> 
      <input type="hidden" name="nipguru" id="nipguru" value = "<?=$nipguru ?>" />
      <input type="text" name="nama" id="nama" size="25" readonly value="<?=$namaguru ?>" class="disabled"  onClick="caripegawai()" onFocus="panggil('nama')"/>
      <input type="hidden" name="namaguru" id="namaguru" value="<?=$namaguru ?>" />
      &nbsp;
        <a href="JavaScript:caripegawai()"><img src="../images/ico/lihat.png" border="0" /></a>    </td>
</tr>
<tr>
	<td><strong>Status</strong></td>
	<td>
    	<select name="status" id="status" onKeyPress="focusNext('keterangan',event)" onFocus="panggil('status')" style="width:255px">
          <?
          	OpenDb();
			$sql = "SELECT status FROM statusguru ORDER BY status ASC";    
			$result = QueryDb($sql);	
			CloseDb();
			while ($row = @mysqli_fetch_array($result)) {
				if ($status == "")
					$status = $row['status'];?>
          <option value="<?=$row['status'] ?>" <?=StringIsSelected($row['status'], $status) ?> >
		  <?=$row['status'] ?>
          </option>
          <?	
		  	} 
		?>
        </select>    </td>
</tr>
<tr>
	<td valign="top">Keterangan</td>
	<td>
    	<textarea name="keterangan" id="keterangan" rows="3" cols="45" onKeyPress="focusNext('Simpan',event)" onFocus="panggil('keterangan')"><?=$keterangan ?></textarea>    </td>
</tr>
<tr>
	<td colspan="2" align="center">
    <input type="submit" name="Simpan" id="Simpan" value="Simpan" class="but" onFocus="panggil('Simpan')"/>&nbsp;
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

<!-- Pilih inputan pertama -->

</body>
</html>