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
require_once('../include/sessionchecker.php');
require_once('../include/common.php');
require_once('../include/rupiah.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../library/departemen.php');
require_once('../include/errorhandler.php');

require_once('jenistabungan.func.php');

OpenDb();

CheckUserLevel();

ReadPageParam();
	
$op = $_REQUEST['op'];
if ($op == "12134892y428442323x423")
	DelTabungan($_REQUEST['id']);

if ($op == "d28xen32hxbd32dn239dx")
	SetAktif($_REQUEST['id'], $_REQUEST['newaktif']); ?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Jenis Tabungan</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="javascript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="jenistabungan.js"></script>
</head>

<body onLoad="document.getElementById('departemen').focus();">
<table border="0" width="100%" height="100%">
<!-- TABLE BACKGROUND IMAGE -->
<tr><td align="center" valign="top" background="../images/bulu1.png" style="background-repeat:no-repeat">

<table border="0" width="100%" align="center">
<!-- TABLE CENTER -->
<tr>
	<td align="left" valign="top">
	<table border="0"width="95%" align="center">
    <!-- TABLE TITLE -->
    <tr>
		<td align="right">
		<font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;
		</font>&nbsp;<font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Jenis Tabungan Pegawai</font>
        </td>
    </tr>
    <tr>
    	<td align="right">
			<a href="tabungan.php">
			<font size="1" color="#000000"><b>Tabungan Pegawai</b></font>
			</a>&nbsp>&nbsp
			<font size="1" color="#000000"><b>Jenis Tabungan Pegawai</b></font>
		</td>
    </tr>
    <tr>
      	<td align="left">&nbsp;</td>
    </tr>
	</table><br />
    <table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">
    <tr>
		<td width="15%">&nbsp;</td>
        <td width="12%"><strong>Departemen&nbsp;</strong></td>
        <td width="20%">
<?      ShowSelectDepartemen() ?>
		</td> 
<? 
		$sql = "SELECT COUNT(replid)
			  	  FROM datatabunganp
				 WHERE departemen = '$departemen'
				 ORDER BY replid";         
		$res = QueryDb($sql);
		$row = mysqli_fetch_row($res);
		$jumlah = $row[0];
		$total = ceil((int)$jumlah/(int)$varbaris);
	
		$sql = "SELECT *
				  FROM datatabunganp
				 WHERE departemen = '$departemen'
				 ORDER BY replid LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
	
		$akhir = ceil($jumlah/5) * 5;
		$request = QueryDb($sql);
	
	if (@mysqli_num_rows($request) > 0)
	{
?>          
        <input type="hidden" name="total" id="total" value="<?=$total?>"/>
        <td align="right">
        <a href="#" onClick="refresh()"><img src="../images/ico/refresh.png" border="0" onMouseOver="showhint('Refresh!', this, event, '50px')"/>&nbsp;Refresh</a>&nbsp;&nbsp;
        <a href="JavaScript:cetak()"><img src="../images/ico/print.png" border="0" onMouseOver="showhint('Cetak!', this, event, '50px')" />&nbsp;Cetak</a>&nbsp;&nbsp;       
        <a href="JavaScript:tambah()">
        <img src="../images/ico/tambah.png" border="0" onMouseOver="showhint('Tambah!', this, event, '50px')">&nbsp;Tambah Jenis Tabungan</a>        
        </td>
    </tr>   
	</table><br />
    
    <table id="table" class="tab" border="1" style="border-collapse:collapse" width="95%" align="center" bordercolor="#000000">
	<tr height="30" align="center">
        <td class="header" width="5%">No</td>
        <td class="header" width="15%">Nama</td>        
        <td class="header" width="30%">Kode Rekening</td>
        <td class="header" width="*">Keterangan</td>
		<td class="header" width="100">Notif SMS | TGRAM | JS</td>
        <td class="header" width="100">&nbsp;</td>
	</tr>
<?	
	if ($page == 0)
		$cnt = 0;
	else 
		$cnt = (int)$page*(int)$varbaris;
		
	while ($row = mysqli_fetch_array($request)) { ?>
    <tr height="25">
    	<td align="center"><?=++$cnt?></td>
        <td><?=$row['nama'] ?></td>        
        <td>
<?		$sql = "SELECT nama FROM rekakun WHERE kode = '$row[rekkas]'";
		$result = QueryDb($sql);
		$row2 = mysqli_fetch_row($result);
		$namarekkas = $row2[0];
	
		$sql = "SELECT nama FROM rekakun WHERE kode = '$row[rekutang]'";
		$result = QueryDb($sql);
		$row2 = mysqli_fetch_row($result);
		$namarekutang = $row2[0]; ?>
		<strong>Kas:</strong> <?=$row['rekkas'] . " " . $namarekkas ?><br />
		<strong>Utang:</strong> <?=$row['rekutang'] . " " . $namarekutang ?><br />
        </td>
        <td><?=$row['keterangan'] ?></td>
		<td align="center">
		<?	if ($row['info2'] == 1)
				echo "<img src='../images/ico/checka.png' title='kirim'>";
			else
				echo "&nbsp;"; ?>
		</td>
        <td align="center">
<?      
		$img = "aktif.png"; 
		$pesan = "Status Aktif!";
		if ($row['aktif'] == 0) {
			$img = "nonaktif.png";
			$pesan = "Status Tidak Aktif!"; 
		} 
?>		
        	<a href="#" onClick="set_aktif(<?=$row['replid'] ?>, <?=$row['aktif'] ?>)"><img src="../images/ico/<?=$img ?>" border="0" onMouseOver="showhint('<?=$pesan?>', this, event, '80px')"/></a>&nbsp;
        	<a href="#" onClick="newWindow('jenistabungan.edit.php?id=<?=$row['replid']?>&departemen=<?=$row['departemen'] ?>', 'UbahJenisTabungan','500','395','resizable=1,scrollbars=1,status=0,toolbar=0')"><img src="../images/ico/ubah.png" border="0" onMouseOver="showhint('Ubah Penerimaan!', this, event, '80px')"/></a>&nbsp;
        	<a href="#" onClick="hapus(<?=$row['replid'] ?>)"><img src="../images/ico/hapus.png" border="0" onMouseOver="showhint('Hapus Tabungan!', this, event, '80px')"/></a>   	
        </td>
    </tr>
<?	} CloseDb();?>
    </table>
    <script language='JavaScript'>
	    Tables('table', 1, 0);
    </script>
	
    </td>
</tr> 
<tr>
    <td>
    <table border="0"width="95%" align="center" cellpadding="0" cellspacing="0">	
    <tr>
       	<td width="30%" align="left">Halaman
		<input type="hidden" id="page" name="page" value="<?=$page?>">
        <select name="hal" id="hal" onChange="change_hal()">
        <?	for ($m=0; $m<$total; $m++) {?>
             <option value="<?=$m ?>" <?=IntIsSelected($hal,$m) ?>><?=$m+1 ?></option>
        <? } ?>
     	</select>
	  	dari <?=$total?> halaman
        </td>
        <td width="30%" align="right">Jumlah baris per halaman
      	<select name="varbaris" id="varbaris" onChange="change_baris()">
        <? 	for ($m=5; $m <= $akhir; $m=$m+5) { ?>
        	<option value="<?=$m ?>" <?=IntIsSelected($varbaris,$m) ?>><?=$m ?></option>
        <? 	} ?>
       
      	</select></td>
    </tr>
    </table>
<!-- EOF CONTENT -->
</td></tr>
</table>
<?	} else { ?>
	<td width = "50%"></td>
</tr>
</table>
<table width="95%" border="0" align="center">          
<tr>
	<td width="14%"></td>
	<td><hr style="border-style:dotted" color="#000000"/></td>
</tr>
</table>
<table width="100%" border="0" align="center">          
<tr>
	<td align="center" valign="middle" height="200">    
    	<font size = "2" color ="red"><b>Tidak ditemukan adanya data.        
        <br />Klik &nbsp;<a href="JavaScript:tambah()" ><font size = "2" color ="green">di sini</font></a>&nbsp;untuk mengisi data baru. 
        
        </b></font>
	</td>
</tr>
</table>  
<? } ?>
</td></tr>
<!-- END TABLE BACKGROUND IMAGE -->
</table> 
</body>
</html>
<script language="javascript">
	var spryselect1 = new Spry.Widget.ValidationSelect("idkategori");
	var spryselect1 = new Spry.Widget.ValidationSelect("departemen");
</script>