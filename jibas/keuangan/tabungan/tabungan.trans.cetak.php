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
require_once('../include/sessionchecker.php');
require_once('../include/common.php');
require_once('../include/rupiah.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/getheader.php');
require_once('../library/jurnal.php');

require_once('tabungan.trans.input.func.php');
require_once('tabungan.trans.input.view.php');

$idtabungan = (int)$_REQUEST['idtabungan'];
$nis = (string)$_REQUEST['nis'];
$idtahunbuku = (int)$_REQUEST['idtahunbuku'];
$page = (int)$_REQUEST['page'];

OpenDb();

$sql = "SELECT departemen FROM tahunbuku WHERE replid='$idtahunbuku'"; 	
$result = QueryDb($sql);    
$row = mysqli_fetch_row($result);	
$departemen = $row[0];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS KEU [Transaksi Tabungan]</title>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr><td align="left" valign="top">

<?=getHeader($departemen)?>

<center><font size="4"><strong>TABUNGAN</strong></font><br /> </center><br /><br />

<table border="0">
<tr>
	<td width="120"><strong>Departemen</strong></td>
    <td><strong>: 
<?	$sql = "SELECT departemen FROM tahunbuku WHERE replid='$idtahunbuku'"; 	
	$result = QueryDb($sql);    
	$row = mysqli_fetch_row($result);	
	echo  $row[0]; ?>
    </strong></td>
</tr>
<tr>
	<td><strong>Tahun Buku</strong></td>
    <td><strong>:
<?	$sql = "SELECT tahunbuku FROM tahunbuku WHERE replid='$idtahunbuku'"; 	
	$result = QueryDb($sql);    
	$row = mysqli_fetch_row($result);
	echo  $row[0]; ?>
    </strong></td>
</tr>
<tr>
	<td><strong>Tabungan</strong></td>
    <td><strong>:
<?	$sql = "SELECT nama FROM datatabungan WHERE replid = '$idtabungan'"; 			
	$result = QueryDb($sql);    
	$row = mysqli_fetch_row($result);
	echo  $row[0]; ?>
    </strong></td>
</tr>

</table>

<?
$sql = "SELECT s.replid, nama, telponsiswa as telpon, hpsiswa as hp, kelas, alamatsiswa as alamattinggal, t.tingkat 
		  FROM jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t 
		 WHERE s.idkelas = k.replid AND nis = '$nis' AND t.replid = k.idtingkat";

$result = QueryDb($sql);
if (mysqli_num_rows($result) == 0) 
{
	CloseDb();
	exit();
}
else 
{
	$row = mysqli_fetch_array($result);
	$replid = $row['replid'];
	$nama = $row['nama'];
	$telpon = $row['telpon'];
	$hp = $row['hp'];
	$namakelas = $row['kelas'];
	$namatingkat = $row['tingkat'];
	$alamattinggal = $row['alamattinggal'];
}

?>
<table width="100%" border="0" height="100%" cellspacing="2" cellpadding="2">
<tr>
    <td valign="top" width="500">
<?	ShowInfoSiswa() ?>        		
    </td>
    <td valign="top">
<?	ShowInfoTabungan() ?>        
    </td>
</tr>
<tr>
    <td align="center" colspan="2"> 
    <fieldset>
    <legend><font size="2" color="#003300"><strong>Transaksi tabungan</strong></font></legend>
    <form name="main">   	
    <br />
    <table class="tab" id="tabTabunganList" border="1" style="border-collapse:collapse"
           width="100%" align="center" bordercolor="#000000">
	<tr height="30" align="center">
		<td class="header" width="5%">No</td>
	    <td class="header" width="18%">No. Jurnal/Tgl</td>
	    <td class="header" width="15%">Debet</td>
	    <td class="header" width="15%">Kredit</td>
	    <td class="header" width="*">Keterangan</td>
	    <td class="header" width="12%">Petugas</td>
	</tr>
<?
	$limit = ($page + 1) * 10;
	
	$sql = "SELECT COUNT(p.replid)
              FROM tabungan p, jurnal j
             WHERE p.idjurnal = j.replid
               AND p.nis = '$nis'
               AND j.idtahunbuku = '$idtahunbuku'
               AND p.idtabungan = '$idtabungan'";
    $nData = FetchSingle($sql);
    
    $sql = "SELECT p.replid AS id, j.nokas, date_format(p.tanggal, '%d-%b-%Y %H:%i:%s') as tanggal,
                   p.keterangan, p.debet, p.kredit, p.petugas
              FROM tabungan p, jurnal j
             WHERE p.idjurnal = j.replid
               AND p.nis = '$nis'
               AND j.idtahunbuku = '$idtahunbuku'
               AND p.idtabungan = '$idtabungan'
             ORDER BY p.replid DESC
             LIMIT $limit";
    $result = QueryDb($sql);
    if ($nData == 0)
    {
        echo "<tr height='100'><td colspan='7' align='center' valign='middle'><i>Belum ada data tabungan</i></td></tr>";
    }
    else if (mysqli_num_rows($result) == 0)
    {
        echo "";
    }
    else
    {
        $cnt = 0;
        while ($row = mysqli_fetch_array($result))
        {
            $kredit = (int) $row['kredit'];
            $bgcolor = $kredit != 0 ? "#E0F3FF" : "#F9F6EA";
            
            $no = $nData - $cnt;
            $cnt += 1;  ?>
            <tr height="25" style='background-color: <?=$bgcolor?>;'>
                <td align="center"><?=$no?></td>
                <td align="center"><?="<strong>" . $row['nokas'] . "</strong><br><i>" . $row['tanggal']?></i></td>
                <td align="right"><?=FormatRupiah($row['debet'])?></td>
                <td align="right"><?=FormatRupiah($row['kredit'])?></td>
                <td align="left"><?=$row['keterangan'] ?></td>
                <td align="center"><?=$row['petugas'] ?></td>
            </tr>
<?	    }
	} ?>
</table>
    </fieldset>

    </td>
</tr>
</table>
</body>
<?
CloseDb();
?>
</html>
<script language="javascript">window.print();</script>