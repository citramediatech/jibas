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
require_once('../include/theme.php'); 
require_once('../cek.php');

$varbaris=10;
if (isset($_REQUEST['varbaris']))
	$varbaris = $_REQUEST['varbaris'];

$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
	
$hal=0;
if (isset($_REQUEST['hal']))
	$hal = $_REQUEST['hal'];

$op = $_GET['op'];
$nama_suku = $_REQUEST['nama_suku'];
$suku_kiriman=$_REQUEST['suku'];
$aktif = $_GET['aktif'];
$isnew = $_GET['isnew'];

if (($op == "del") && (strlen($nama_suku) > 0)) {
	OpenDb();
	$sql = "DELETE FROM jbsumum.suku WHERE suku = '$nama_suku'";
	$result = QueryDb($sql);
	CloseDb();
$page=0;
$hal=0;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="JavaScript" src="../script/tables.js"></script>
<script language="JavaScript" src="../script/ajax.js"></script>
<script language="JavaScript" src="../script/tools.js"></script>
<script language="javascript">

function refresh(suku) {
	document.location.href = "suku.php?suku="+suku+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
}

function refresh() {
	document.location.href = "suku.php";
}

function del(nama_suku) {
	if (confirm("Apakah anda yakin akan menghapus suku "+nama_suku+" ?"))
		document.location.href = "suku.php?op=del&nama_suku="+nama_suku+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
}

function tambah() {
	newWindow('suku_tambah.php', 'TambahSuku','400','240','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function change_page(page) {
	var varbaris=document.getElementById("varbaris").value;
	document.location.href="suku.php?page="+page+"&hal="+page+"&varbaris="+varbaris;
}

function change_hal() {
	var hal = document.getElementById("hal").value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="suku.php?page="+hal+"&hal="+hal+"&varbaris="+varbaris;
}

function change_baris() {
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="suku.php?varbaris="+varbaris;
}

function tutup() {
	var suku_kiriman=document.getElementById('suku_kiriman').value;
	
	if (suku_kiriman.length==0){
		opener.refresh_delete();
		window.close();
	} else {
		parent.opener.suku_kiriman(suku_kiriman);
		window.close();
	}
}

locnm=location.href;
pos=locnm.indexOf("indexb.htm");
locnm1=locnm.substring(0,pos);
function ByeWin() {

windowIMA=parent.opener.refresh_delete();
}

</script>
<title>JIBAS SIMAKA [Daftar Suku]</title>
</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#dcdfc4" onUnload="ByeWin()">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">
	<div align="center" style="color:#FFFFFF; font-size:16px; font-weight:bold">
    .: Suku :.
    </div>
	</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF" height="335" valign="top">
    <!--content -->
<table border="0" width="100%" align="center">
<tr>
    <td align="center" valign="top">
    <?
    OpenDb();
	
	$sql_tot = "SELECT * FROM jbsumum.suku";
	$result_tot = QueryDb($sql_tot);
	$total = ceil(mysqli_num_rows($result_tot)/(int)$varbaris);
	$jumlah = mysqli_num_rows($result_tot);
						
	$sql = "SELECT suku,replid FROM jbsumum.suku ORDER BY suku LIMIT ".(int)$page*(int)$varbaris.",$varbaris"; 						
	$akhir = ceil($jumlah/5)*5;
	$result = QueryDb($sql);	
	if (@mysqli_num_rows($result) > 0) {
    ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- TABLE LINK -->
    <tr>
        <td align="right">
        	<a href="#" onClick="refresh();"><img src="../images/ico/refresh.png" border="0" onMouseOver="showhint('Refresh!', this, event, '50px')">&nbsp;Refresh</a>&nbsp;&nbsp;
            <a href="#" onClick="JavaScript:tambah();"><img src="../images/ico/tambah.png" border="0" onMouseOver="showhint('Tambah Suku!', this, event, '50px')">&nbsp;Tambah Suku</a></td>
    </tr>
	</table>
   	</td>
</tr>
<tr>
	<td>
    <br />
	<table class="tab" id="table" border="1" style="border-collapse:collapse" width="100%" align="left" bordercolor="#000000">
	<tr class="header" height="30" align="center">
        <td width="10%" >No</td>
        <td width="*">Suku</td>
        <td width="15%">&nbsp;</td>
	</tr>
    <?
	
	if ($page==0)
		$cnt = 1;
	else 
		$cnt = (int)$page*(int)$varbaris+1;
		
	while ($row = @mysqli_fetch_array($result)) {
		//$suku=$row['suku'];
		$replid=$row['replid'];
	?>
    <tr height="25">
    	<td align="center"><?=$cnt?></td>
        <td><?=$row['suku']?></td>
        <td align="center">
        <a href="#" onClick="newWindow('suku_edit.php?suku=<?=$row['suku']?>&replid=<?=$replid?>',
        'UbahSuku','400','240','resizable=1,scrollbars=1,status=0,toolbar=0')"><img src="../images/ico/ubah.png" border="0" onMouseOver="showhint('Ubah Suku!', this, event, '50px')"></a>&nbsp;<a href="#" onClick="del('<?=$row['suku']?>')"><img src="../images/ico/hapus.png" border="0" onMouseOver="showhint('Hapus Suku!', this, event, '50px')"></a>        </td>
	</tr> 
     
    <?
	$cnt++;	
	} //while
	CloseDb();
	?>
    </table>
    <script language='JavaScript'>
	    Tables('table', 1, 0);
    </script>
	<script language='JavaScript'>
	    Tables('table', 1, 0);
    </script>
  	<?	if ($page==0){ 
		$disback="style='visibility:hidden;'";
		$disnext="style='visibility:visible;'";
		}
		if ($page<$total && $page>0){
		$disback="style='visibility:visible;'";
		$disnext="style='visibility:visible;'";
		}
		if ($page==$total-1 && $page>0){
		$disback="style='visibility:visible;'";
		$disnext="style='visibility:hidden;'";
		}
		if ($page==$total-1 && $page==0){
		$disback="style='visibility:hidden;'";
		$disnext="style='visibility:hidden;'";
		}
	?>
    </td>
</tr> 
<tr>
    <td>
    <table border="0"width="100%" align="center"cellpadding="0" cellspacing="0">	
    <tr>
       	<td width="35%" align="left">Hal
        <select name="hal" id="hal" onChange="change_hal()">
        <?	for ($m=0; $m<$total; $m++) {?>
             <option value="<?=$m ?>" <?=IntIsSelected($hal,$m) ?>><?=$m+1 ?></option>
        <? } ?>
     	</select>
	  	dari <?=$total?> hal
		
		<? 
     // Navigasi halaman berikutnya dan sebelumnya
        ?>
        </td>
    	<!--td align="center">
    <input <?=$disback?> type="button" class="but" name="back" value=" << " onClick="change_page('<?=(int)$page-1?>')" onMouseOver="showhint('Sebelumnya', this, event, '75px')">
		<?
		/*for($a=0;$a<$total;$a++){
			if ($page==$a){
				echo "<font face='verdana' color='red'><strong>".($a+1)."</strong></font> "; 
			} else { 
				echo "<a href='#' onClick=\"change_page('".$a."')\">".($a+1)."</a> "; 
			}
				 
	    }*/
		?>
	     <input <?=$disnext?> type="button" class="but" name="next" value=" >> " onClick="change_page('<?=(int)$page+1?>')" onMouseOver="showhint('Berikutnya', this, event, '75px')">
 		</td-->
        <td width="35%" align="right">Jml baris per hal
      	<select name="varbaris" id="varbaris" onChange="change_baris()">
        <? 	for ($m=5; $m <= $akhir; $m=$m+5) { ?>
        	<option value="<?=$m ?>" <?=IntIsSelected($varbaris,$m) ?>><?=$m ?></option>
        <? 	} ?>
       
      	</select></td>
    </tr>
    </table>
    
<?	} else { ?>

	<table width="100%" border="0" align="center">
   	<tr>
    	<td colspan="3"><hr style="border-style:dotted" color="#000000" /> 
       	</td>
   	</tr>
	<tr>
		<td align="center" valign="middle" height="200">
    	<font size = "2" color ="red"><b>Tidak ditemukan adanya data. 
        <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
        <br />Klik &nbsp;<a href="JavaScript:tambah()" ><font size = "2" color ="green">di sini</font></a>&nbsp;untuk mengisi data baru. 
        <? } ?>
        </b></font>
        </td>
   	</tr>
   	</table>
<? } ?> 
	</td>
</tr>
<tr height="35">
	<td colspan="3" align="center">
        <input class="but" type="button" value="Tutup" onClick="tutup()">
        <input type="hidden" name="suku_kiriman" id="suku_kiriman" value="<?=$suku_kiriman?>" />
	</td>
</tr>
</table>
<!-- footer -->
 </td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_06a.jpg">&nbsp;</td>
</tr>
<tr height="28">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_07.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_08a.jpg">&nbsp;</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_09.jpg">&nbsp;</td>
</tr>
</table>
</body>
</html>