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

$kelas=$_REQUEST['kelas'];

$urut = "nama";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	

$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];

$op = $_REQUEST['op'];
if ($op == "dw8dxn8w9ms8zs22") {
	$pin = random(5);
	OpenDb();
	$sql	= "SELECT pinsiswa,pinortu FROM jbsakad.siswa WHERE nis='$_REQUEST[nis]'";
	$result = QueryDb($sql);
	$row	= @mysqli_fetch_array($result);
	if ($field=='pinsiswa'){
		if ($row['pinortu']==$pin){
			while ($row['pinortu']==$pin || $row['pinortuibu']==$pin)
				$pin = random(5);
		}
	}
	
	if ($field=='pinortu'){
		if ($row['pinsiswa']==$pin){
			while ($row['pinsiswa']==$pin || $row['pinortuibu']==$pin)
				$pin = random(5);
		}
	}

	$sql = "UPDATE jbsakad.siswa SET $_REQUEST[field] = '$pin' WHERE nis = '$_REQUEST[nis]'";
	QueryDb($sql);
	CloseDb();
}

OpenDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Pendataan PIN]</title>
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="javascript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">

function gantipin(field, nis) {
	if (confirm("Apakah anda yakin akan mengganti PIN ini?")) {
		var kelas = document.getElementById('kelas').value;	
		document.location.href = "pin_footer.php?op=dw8dxn8w9ms8zs22&kelas="+kelas+"&urut=<?=$urut?>&urutan=<?=$urutan?>&field="+field+"&nis="+nis;
	}	
}

function refresh() {
	document.location.reload;
}

function cetak() {	
	var kelas = document.getElementById('kelas').value;
	
	newWindow('pin_cetak.php?kelas='+kelas+'&urut=<?=$urut?>&urutan=<?=$urutan?>', 'CetakPendataanPIN','790','650','resizable=1,scrollbars=1,status=0,toolbar=0');
	
}

function change_urut(urut,urutan) {		
	var kelas = document.getElementById('kelas').value;
	
	if (urutan =="ASC"){
		urutan="DESC"
	} else {
		urutan="ASC"
	}
	
	document.location.href = "pin_footer.php?kelas="+kelas+"&urut="+urut+"&urutan="+urutan;
	
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<input type="hidden" name="kelas" id="kelas" value="<?=$kelas?>"/>
<input type="hidden" name="urut" id="urut" value="<?=$urut?>"/>
<input type="hidden" name="urutan" id="urutan" value="<?=$urutan?>"/>

<table width="100%" border="0" height="100%">
<tr>
	<td>	
<? 	
	OpenDb();
	$sql = "SELECT * FROM jbsakad.siswa s WHERE s.idkelas = '$kelas' AND s.aktif = 1 ORDER BY $urut $urutan ";
	
	$result = QueryDb($sql);
	if (@mysqli_num_rows($result) > 0){ 
?>

	<table width="100%" border="0" align="center">          
	<tr>
	<td align="right">            
    	<a href="#" onClick="document.location.reload()"><img src="../images/ico/refresh.png" border="0" name="refresh" id="refresh" onMouseOver="showhint('Refresh!', this, event, '50px')"/>&nbsp;Refresh</a>&nbsp;&nbsp;
        <a href="JavaScript:cetak()" ><img src="../images/ico/print.png" border="0" name="cetak" id="cetak" onMouseOver="showhint('Cetak!', this, event, '50px')"/>&nbsp;Cetak</a>&nbsp;&nbsp;   	
     	</td>
	</tr>          
    </table>
    <br />

	<table class="tab" id="table" border="1" style="border-collapse:collapse" width="100%" align="center" bordercolor="#000000">
<!-- TABLE CONTENT -->
    <tr height="30" class="header" align="center">
        <td width="4%">No</td>        
        <td width="15%" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('nis','<?=$urutan?>')">N I S <?=change_urut('nis',$urut,$urutan)?></td>    
        <td width="*" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('nama','<?=$urutan?>')">Nama <?=change_urut('nama',$urut,$urutan)?></td>
        <td width="20%" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('pinsiswa','<?=$urutan?>')">PIN Siswa <?=change_urut('pinsiswa',$urut,$urutan)?></td>
        <td width="20%" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('pinortu','<?=$urutan?>')">PIN Ayah <?=change_urut('pinortu',$urut,$urutan)?></td>
		<td width="20%" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('pinortuibu','<?=$urutan?>')">PIN Ibu <?=change_urut('pinortuibu',$urut,$urutan)?></td>
    </tr>
    <?
		while ($row = @mysqli_fetch_array($result)) {
	?>
    <tr height="25">   	
        <td align="center"><?=++$cnt ?></td>
        <td align="center"><?=$row['nis']?></td>
        <td><?=$row['nama'] ?></td>      
        <td align="center"><?=$row['pinsiswa'] ?>&nbsp;
        <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
        <a href="JavaScript:gantipin('pinsiswa','<?=$row['nis']?>')" ><img src="../images/ico/refresh.png" border="0" onMouseOver="showhint('Ganti PIN!', this, event, '50px')"/></a>
        <? } ?>
        </td>      
        <td align="center"><?=$row['pinortu'] ?>&nbsp;
        <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
        <a href="JavaScript:gantipin('pinortu','<?=$row['nis']?>')" ><img src="../images/ico/refresh.png" border="0" onMouseOver="showhint('Ganti PIN Ayah!', this, event, '50px')"/></a>
        <? } ?>
        </td>
		<td align="center"><?=$row['pinortuibu'] ?>&nbsp;
        <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
        <a href="JavaScript:gantipin('pinortuibu','<?=$row['nis']?>')" ><img src="../images/ico/refresh.png" border="0" onMouseOver="showhint('Ganti PIN Ibu!', this, event, '50px')"/></a>
        <? } ?>
        </td>
    </tr>
	<?	} ?>
    </table>
    <script language='JavaScript'>
	    Tables('table', 1, 0);
    </script></div>


<?	} else { ?>

<table width="100%" border="0" align="center">          
<tr>
	<td align="center" valign="middle" height="200">
    	<font size = "2" color ="red"><b>Tidak ditemukan adanya data.      
        </b></font>
	</td>
</tr>
</table>  
<? } ?> 
</td>
</tr>
</table>
</body>
</html>