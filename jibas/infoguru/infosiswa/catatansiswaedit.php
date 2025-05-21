<?
/**[N]**
 * JIBAS Education Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 2.6.0 (January 14, 2012)
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
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once("../include/sessionchecker.php");

$replid = "";
if (isset($_REQUEST['replid']))
	$replid = $_REQUEST['replid'];
$nis = "";
if (isset($_REQUEST['nis']))
	$nis = $_REQUEST['nis'];
$tahunajaran = "";
if (isset($_REQUEST['tahunajaran']))
	$tahunajaran = $_REQUEST['tahunajaran'];
$idkategori = "";
if (isset($_REQUEST['idkategori']))
	$idkategori = $_REQUEST['idkategori'];	

if (isset($_REQUEST['simpan'])){
	$nis = $_REQUEST['nis'];
	$tgl=explode("-",$_REQUEST['tanggal']);
	$tanggal=$tgl[2]."-".$tgl[1]."-".$tgl[0];
	$judul = $_REQUEST['judul'];
	$catatan = $_REQUEST['catatan'];
	$idkategori = $_REQUEST['kategori'];
	OpenDb();
	$sql="UPDATE jbsvcr.catatansiswa SET idkategori='$idkategori',tanggal='$tanggal',judul='$judul',catatan='$catatan' WHERE replid='$replid'";
	$result = QueryDb($sql);
	if ($result){
	?>
	<script language="javascript" type="text/javascript">
		parent.catatansiswamenu.show('<?=$idkategori?>');	
		//document.location.href="catatansiswaedit.php?nis=<?=$nis?>&tahunajaran=<?=$tahunajaran?>&idkategori=<?=$idkategori?>";
	</script>
	<?
	}
	CloseDb();
}
OpenDb();
$res=QueryDb("SELECT * FROM jbsvcr.catatansiswa WHERE replid='$replid'");
$rw=@mysqli_fetch_array($res);
$tanggal = RegularDateFormat($rw['tanggal']);
$judul = $rw['judul'];
$catatan = $rw['catatan'];
$idkategori = $rw['kategori'];
$nilai = $rw['nilai'];
$sifat = $rw['sifat'];
CloseDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../style/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../style/calendar-win2k-1.css">
<script type="text/javascript" src="../script/calendar.js"></script>
<script type="text/javascript" src="../script/lang/calendar-en.js"></script>
<script type="text/javascript" src="../script/calendar-setup.js"></script>
<script language="javascript" type="text/javascript" src="../script/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script src="../script/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../script/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../script/SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../script/SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
tinyMCE.init({
		mode : "exact",
		theme : "simple",
        elements : "catatan"
	});

function validate(){
	var judul=document.getElementById('judul').value;
	var catatan=tinyMCE.get('catatan').getContent();
	if (judul.length==0){
		alert ('Anda harus mengisikan data untuk Judul Catatan');
		document.getElementById('judul').focus();
		return false;
	}
	if (catatan.length==0){
		alert ('Anda harus mengisikan data untuk Catatan');
		document.getElementById('catatan').focus();
		return false;
	}
	return true;
}
</script>
</head>
<body leftmargin="0" topmargin="0" onLoad="document.getElementById('judul').focus();">
<form action="catatansiswaedit.php" onSubmit="return validate()">
<input name="replid" type="hidden" value="<?=$replid?>" id="replid" />
<input name="nis" type="hidden" value="<?=$nis?>" id="nis" />
<input name="tahunajaran" type="hidden" value="<?=$tahunajaran?>" id="tahunajaran" />
<input name="idkategori" type="hidden" value="<?=$idkategori?>" id="idkategori" />
<table width="100%" border="0" cellspacing="5">
  <tr>
    <td colspan="2"><strong><font size="2" color="#999999">Ubah Catatan :</font></strong><br /><br /></td>
  </tr>
  <tr>
    <td width="66"><strong>Kategori </strong></td>
    <td width="1149">
    <select name="kategori" id="kategori" >
    <?
	OpenDb();
	$sql = "SELECT * FROM jbsvcr.catatankategori WHERE aktif=1 ORDER BY replid";
	$result = QueryDb($sql);
	if (@mysqli_num_rows($result) > 0){
	$cnt=1;
	while ($row=@mysqli_fetch_array($result)){
		echo "<option value='".$row['replid']."'".StringIsSelected($row['replid'],$idkategori).">".$row['kategori']."</option>";
	}
	} else {
		echo "<option value=''>Tidak ada kategori</option>";
	}
    CloseDb();
	?>
	</select>
    </td>
  </tr>
  <tr>
    <td><strong>Tanggal </strong></td>
    <td><input title="Klik untuk membuka kalender !" type="text" name="tanggal" id="tanggal" size="25" readonly="readonly" class="disabled" value="<?=$tanggal?>"/><img title="Klik untuk membuka kalender !" src="../images/ico/calendar_1.png" name="btntanggal" width="16" height="16" border="0" id="btntanggal"/></td>
  </tr>
  <tr>
    <td><strong>Judul </strong></td>
    <td><input name="judul" type="text" id="judul" size="35" maxlength="254" value="<?=$judul?>" /></td>
  </tr>
    <tr>
        <td><strong>Nilai </strong></td>
        <td>
            <select name="nilai" id="nilai" style="font-size: 14px; height: 24px; width: 40px;">
                <option value="1" <?php if ($nilai == 1) echo "selected"; else echo ""; ?>>1</option>
                <option value="2" <?php if ($nilai == 2) echo "selected"; else echo ""; ?>>2</option>
                <option value="3" <?php if ($nilai == 3) echo "selected"; else echo ""; ?>>3</option>
                <option value="4" <?php if ($nilai == 4) echo "selected"; else echo ""; ?>>4</option>
                <option value="5" <?php if ($nilai == 5) echo "selected"; else echo ""; ?>>5</option>
            </select>&nbsp;dari 5
        </td>
    </tr>
    <tr>
        <td><strong>Sifat </strong></td>
        <td>
            <select name="sifat" id="sifat" style="font-size: 14px; height: 24px; width: 320px;">
                <option value="0" <?php if ($sifat == 0) echo "selected"; else echo ""; ?>>PUBLIC (bisa dilihat Guru lainnya)</option>
                <option value="1" <?php if ($sifat == 1) echo "selected"; else echo ""; ?>>PRIVATE (hanya untuk sendiri)</option>
            </select>
        </td>
    </tr>
  <tr>
    <td colspan="2" align="left"><strong>Catatan </strong>
      <div align="center"><br />
          <textarea name="catatan" rows="25" id="catatan" style="width:100%"><?=$catatan?></textarea>
    </div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input name="simpan" type="submit" class="but" id="simpan" value="Simpan" />
    </div></td>
  </tr>
</table>
</form>
</body>
</html>
<script type="text/javascript">
  Calendar.setup(
    {
	  inputField  : "tanggal",         
      ifFormat    : "%d-%m-%Y",  
      button      : "btntanggal"    
    }
   );
   Calendar.setup(
    {
	  inputField  : "tanggal",      
      ifFormat    : "%d-%m-%Y",   
      button      : "tanggal"     
    }
   );
  
</script>
<script language="javascript">
var sprytextfield = new Spry.Widget.ValidationTextField("judul");
var spryselect = new Spry.Widget.ValidationSelect("kategori");
</script>