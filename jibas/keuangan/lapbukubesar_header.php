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
require_once('include/errorhandler.php');
require_once('include/sessionchecker.php');
require_once('include/common.php');
require_once('include/rupiah.php');
require_once('include/config.php');
require_once('include/db_functions.php');
require_once('include/sessioninfo.php');
require_once('library/departemen.php');

OpenDb();

$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

$kategori = "ALL";
if (isset($_REQUEST['kategori']))
	$kategori = $_REQUEST['kategori'];

$idtahunbuku = 0;
if (isset($_REQUEST['idtahunbuku']))
	$idtahunbuku = $_REQUEST['idtahunbuku'];

$tgl1 = 0;
if (isset($_REQUEST['tgl1']))
	$tgl1 = (int)$_REQUEST['tgl1'];

$bln1 = 0;
if (isset($_REQUEST['bln1']))
	$bln1 = (int)$_REQUEST['bln1'];

$thn1 = 0;
if (isset($_REQUEST['thn1']))
	$thn1 = (int)$_REQUEST['thn1'];

$tgl2 = date("j");
if (isset($_REQUEST['tgl2']))
	$tgl2 = (int)$_REQUEST['tgl2'];

$bln2 = date("n");
if (isset($_REQUEST['bln2']))
	$bln2 = (int)$_REQUEST['bln2'];

$thn2 = date("Y");
if (isset($_REQUEST['thn2']))
	$thn2 = (int)$_REQUEST['thn2'];	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/tooltips.css">
<title>Laporan Buku Besar</title>
<script language="javascript" src="script/tooltips.js"></script>
<script language="javascript" src="script/ajax.js"></script>
<script language="javascript" src="script/validasi.js"></script>
<script language="javascript">

function change_kate() 
{
	parent.contentblank.location.href = "lapbukubesar_blank.php";
}

function change_tanggal()
{
	parent.contentblank.location.href = "lapbukubesar_blank.php";
}

function change_bulan()
{
	var departemen = document.getElementById('departemen').value;
	var idtahunbuku = document.getElementById("idtahunbuku").value;
	var kategori = document.getElementById('kategori').value;	
	var bln1 = parseInt(document.getElementById('bln1').value);
	var thn1 = parseInt(document.getElementById('thn1').value);
	var bln2 = parseInt(document.getElementById('bln2').value);
	var thn2 = parseInt(document.getElementById('thn2').value);
	
	document.location.href = "lapbukubesar_header.php?bln1="+bln1+"&thn1="+thn1+"&bln2="+bln2+"&thn2="+thn2+"&departemen="+departemen+"&idtahunbuku="+idtahunbuku+"&kategori="+kategori;
	parent.contentblank.location.href = "lapbukubesar_blank.php";
}

function change_dep() 
{
	var dep = document.getElementById('departemen').value;
	var tgl1 = document.getElementById('tgl1').value;
	var bln1 = document.getElementById('bln1').value;
	var thn1 = document.getElementById('thn1').value;
	var tgl2 = document.getElementById('tgl2').value;
	var bln2 = document.getElementById('bln2').value;
	var thn2 = document.getElementById('thn2').value;
	var kategori = document.getElementById('kategori').value;
	
	parent.contentblank.location.href = "lapbukubesar_blank.php";
	var addr = "lapbukubesar_header.php?tgl1="+tgl1+"&bln1="+bln1+"&thn1="+thn1+"&tgl2="+tgl2+"&bln2="+bln2+"&thn2="+thn2+"&departemen="+dep+"&kategori="+kategori;
	document.location.href = addr;
}


function show_laporan() 
{
	var dep = document.getElementById('departemen').value;
	var tgl1 = parseInt(document.getElementById('tgl1').value);
	var bln1 = parseInt(document.getElementById('bln1').value);
	var thn1 = parseInt(document.getElementById('thn1').value);
	var tgl2 = parseInt(document.getElementById('tgl2').value);
	var bln2 = parseInt(document.getElementById('bln2').value);
	var thn2 = parseInt(document.getElementById('thn2').value);
	var idtahunbuku = document.getElementById('idtahunbuku').value;
	var kategori = document.getElementById('kategori').value;
	var tanggal1 = escape(thn1 + "-" + bln1 + "-" + tgl1);
	var tanggal2 = escape(thn2 + "-" + bln2 + "-" + tgl2);
	
	if (idtahunbuku.length == 0) 
	{	
		alert ('Tahun Buku tidak boleh kosong!');
		document.getElementById('departemen').focus();
		return false;
	} 
	else if (tgl1.length == 0) 
	{	
		alert ('Tanggal awal tidak boleh kosong!');	
		document.main.tgl1.focus();
		return false;	
	} 
	else if (tgl2.length == 0) 
	{	
		alert ('Tanggal akhir tidak boleh kosong!');	
		document.main.tgl2.focus();
		return false;	
	}
	
	var validasi = validateTgl(tgl1, bln1, thn1, tgl2 ,bln2, thn2);
	if (validasi)
		parent.contentblank.location.href = "lapbukubesar_main2.php?departemen="+dep+"&tanggal1="+tanggal1+"&tanggal2="+tanggal2+"&idtahunbuku="+idtahunbuku+"&kategori="+kategori;
}

function change_tahunbuku()
{
	var departemen = document.getElementById("departemen").value;
	var idtahunbuku = document.getElementById("idtahunbuku").value;
	var kategori = document.getElementById('kategori').value;
	
	document.location.href = "lapbukubesar_header.php?departemen="+departemen+"&idtahunbuku="+idtahunbuku+"&kategori="+kategori;
	parent.contentblank.location.href = "lapbukubesar_blank.php";
}
</script>
</head>
<body topmargin="0" leftmargin="0" onload="document.getElementById('departemen').focus()">
<form method="post" name="main">
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
<tr>
	<td rowspan="3" width="60%">
    <table border="0" width = "100%">
    <tr>
        <td width="15%"><strong>Departemen </strong></td>
        <td colspan="4">
        <select name="departemen" id="departemen" style="width:115px" onchange="change_dep()">
        <?	OpenDb();
			$dep = getDepartemen(getAccess());
            foreach ($dep as $value) { 
                if ($departemen == "")
                    $departemen = $value ?>
                <option value="<?=$value ?>" <?=StringIsSelected($departemen, $value) ?> > <?=$value ?></option>
        <?  } ?>     
        </select>
        <strong>Tahun Buku</strong>&nbsp;
        <select name="idtahunbuku" id="idtahunbuku" onchange="change_tahunbuku()" style="width:160px">        
<? 		if ($departemen != "") 
		{ 
			$sql = "SELECT replid, tahunbuku, DAY(tanggalmulai), MONTH(tanggalmulai), YEAR(tanggalmulai), aktif 
					FROM tahunbuku WHERE departemen='$departemen' ORDER BY replid DESC";
			$result = QueryDb($sql);
			while ($row = mysqli_fetch_row($result))
			{
				if ($idtahunbuku == 0)
					$idtahunbuku = $row[0];
				
				$sel = "";
				if ($idtahunbuku == $row[0])
				{
					$sel = "selected";
					
					if ($tgl1 == 0)	$tgl1 = $row[2];
					if ($bln1 == 0) $bln1 = $row[3];
					if ($thn1 == 0) $thn1 = $row[4];
				}
				
				$A = "";
				if ($row[5] == 1)
					$A = "(A)";
				
				echo  "<option value='$row[0]' $sel>$row[1] $A</option>";
			}
		} ?>
        </select>
        </td>
    </tr>
    <tr>
        <td><strong>Buku Besar </strong></td>
        <td colspan="4">
        <select id="kategori" name="kategori" onchange="change_kate()" style="width:115px">
        <option value="ALL">(Semua)</option>
        <?
        $sql = "SELECT kategori FROM katerekakun ORDER BY kategori";
        $result = QueryDb($sql);
        while ($row = mysqli_fetch_row($result)) {
            if ($kategori == "")
                $kategori = $row[0] ?>
            <option value="<?=$row[0] ?>" <?=StringIsSelected($kategori, $row[0]) ?> > <?=$row[0] ?></option>
        <?
        }
        ?>
        </select>
        </td>
    </tr>
    <tr>
<?		if ($tgl1 == 0)	$tgl1 = $tgl2;
		if ($bln1 == 0) $bln1 = $bln2;
		if ($thn1 == 0) $thn1 = $thn2;
					
		$n1 = JmlHari($bln1, $thn1);
		$n2 = JmlHari($bln2, $thn2);	?>        
        <td><strong>Tanggal </strong></td>
       	<td width="10">
        	<div id="InfoTgl1">   
            <select name="tgl1" id="tgl1" onchange="change_tanggal()">
			<? for($i = 1; $i <= $n1; $i++) { ?>
                <option value="<?=$i ?>" <?=IntIsSelected($i, $tgl1) ?> > <?=$i ?></option>
            <? } ?>
            </select>
            </div>
     	</td>
        <td width="160">
            <select name="bln1" id="bln1" onchange="change_bulan()">
            <? for($i = 1; $i <= 12; $i++) { ?>
                <option value="<?=$i ?>" <?=IntIsSelected($i, $bln1) ?> > <?=$bulan[$i] ?></option>
            <? } ?>
            </select>
            <select name="thn1" id="thn1" onchange="change_bulan()">
            <? for($i = $G_START_YEAR; $i <= $thn1+1; $i++) { ?>
                <option value="<?=$i ?>" <?=IntIsSelected($i, $thn1) ?> > <?=$i ?></option>
            <? } ?>
            </select>s/d
        </td>
        <td width="10">
        	<div id="InfoTgl2">
            <select name="tgl2" id="tgl2" onchange="change_tanggal()">
            <? for($i = 1; $i <= $n2; $i++) { ?>
                <option value="<?=$i ?>" <?=IntIsSelected($i, $tgl2) ?> > <?=$i ?></option>
            <? } ?>
            </select>
         	</div>
        </td>
        <td>
            <select name="bln2" id="bln2" onchange="change_bulan()">
            <? for($i = 1; $i <= 12; $i++) { ?>
                <option value="<?=$i ?>" <?=IntIsSelected($i, $bln2) ?> > <?=$bulan[$i] ?></option>
            <? } ?>
            </select>
            <select name="thn2" id="thn2" onchange="change_bulan()">
            <? for($i = $G_START_YEAR; $i <= $thn2+1; $i++) { ?>
                <option value="<?=$i ?>" <?=IntIsSelected($i, $thn2) ?> > <?=$i ?></option>
            <? } ?>
            </select>
    	</td>
    </tr>
    </table>
    </td>
    <td rowspan="3" valign="middle">
    	<a href="#" onclick="show_laporan()"><img src="images/view.png" border="0" height="48" width="48" id="tabel" onmouseover="showhint('Klik untuk menampilkan data laporan buku besar!', this, event, '180px')" /></a>
    </td>
    <td width="30%" align="right" valign="top">
    	<font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Laporan Buku Besar</font><br />
    	<a href="lapkeuangan.php" target="_parent">
      	<font size="1" color="#000000"><b>Laporan Keuangan</b></font></a>&nbsp>&nbsp
        <font size="1" color="#000000"><b>Laporan Buku Besar</b></font>
	</td>
</tr>
</table>
</form>
<?
CloseDb();
?>
</body>
</html>