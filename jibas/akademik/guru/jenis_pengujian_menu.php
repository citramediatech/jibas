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
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');

if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

OpenDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Status Guru</title>
<script src="../script/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../script/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../script/ajax.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">

function refresh() {	
	document.location.reload();
}

function tampil() {		
	var departemen = document.getElementById('departemen').value;
	document.location.href = "jenis_pengujian_menu.php?departemen="+departemen;
	parent.jenis_pengujian_content.location.href = "blank_pengujian.php";
}
function pilih(id,nama_dep,nama_pel) {		
	parent.jenis_pengujian_content.location.href = "jenis_pengujian_content.php?id="+id+"&nama_dep="+nama_dep+"&nama_pel="+nama_pel;
}
</script>
</head>

<body onload="document.getElementById('departemen').focus()" style="background-color: #f5f5f5;">

<table border="0" width="100%" align="center">
<!-- TABLE CENTER -->
<tr>
	<td align="left" valign="top">
	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="left">
	<!-- TABLE LINK -->
	<tr>
    <td align="left" width="100%">
      <p><strong>Departemen&nbsp;</strong>
            <select name="departemen" id="departemen" onchange="tampil()" style="width:50%;">
         <?	$dep = getDepartemen(SI_USER_ACCESS());    
	foreach($dep as $value) {
		if ($departemen == "")
			$departemen = $value; ?>
              <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> > 
                <?=$value ?> 
                </option>
                <?	} ?>
            </select></td>
    <td>
        <!--<input type="button" name="tampil" value="Tampilkan Semua Guru" class="but"/>   -->
          
    </td>    
    </tr>
	</table>  <br />
        <br />	
<?	OpenDb();
	$sql = "SELECT replid,nama,departemen,kode FROM pelajaran WHERE departemen = '$departemen' ORDER BY nama";
	$result = QueryDb($sql);
	if (@mysqli_num_rows($result)>0){
?>
    <br><br>
    <strong>Pelajaran:</strong>
	<table class="tab" id="table" border="1" style="border-collapse:collapse; border-width: 1px; border-color: #f5f5f5;" width="100%" align="left" bordercolor="#000000">
    <!-- TABLE CONTENT -->
    
    <tr style="height: 2px;">
    	<td width="15%"></td>
        <td width="*"></td>
    </tr>
    
     <?
		
		$cnt = 0;
		while ($row = @mysqli_fetch_array($result)) {
	?>
    <tr height="25" onClick="pilih('<?=$row[0]?>','<?=$row[2]?>','<?=$row[1]?>')" style="cursor:pointer;">   	
       	<td align="left"><?=$row[3]?></td>
        <td align="left"><a href="Javascript:pilih('<?=$row[0]?>','<?=$row[2]?>','<?=$row[1]?>')"><?=$row[1]?></a></td>
            
    </tr>
<?	} 
	CloseDb(); 
?>	
	<!-- END TABLE CONTENT -->
	</table>
	<script language='JavaScript'>
	    Tables('table', 1, 0);
    </script>  
<?	} else { ?>
	&nbsp;
   
	<table width="100%" border="0" align="center">          
	<tr>
		<td align="center" valign="middle" height="200">
        <? if ($departemen <> "") {	?>
    		<font size = "2" color ="red"><b>Tidak ditemukan adanya data. <br /><br />Tambah data pelajaran pada departemen <?=$departemen?> di menu Pendataan Pelajaran pada bagian Guru & Pelajaran. </b></font>
        <? } else { ?> 
              <font size = "2" color ="red"><b>Belum ada data Departemen.
              <br />Silahkan isi terlebih dahulu di menu Departemen pada bagian Referensi.
              </b></font>
		<? } ?> 
		</td>
	</tr>
	</table>  
	
<? } ?> 
	</td>
</tr>
<!-- END TABLE CENTER -->    
</table>    

    
<?	CloseDb() ?>    
  

</body>
</html>
<script language="javascript">
	var spryselect1 = new Spry.Widget.ValidationSelect("departemen");
</script>