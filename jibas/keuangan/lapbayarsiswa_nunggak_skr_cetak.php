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
require_once('include/getheader.php'); 

$urut=$_REQUEST['urut'];
$urutan = $_REQUEST['urutan'];
$varbaris = $_REQUEST['varbaris'];	
$page = $_REQUEST['page'];
$total = $_REQUEST['total'];

if (isset($_REQUEST['idpenerimaan']))
	$idpenerimaan = (int)$_REQUEST['idpenerimaan'];

if (isset($_REQUEST['idangkatan']))
	$idangkatan = (int)$_REQUEST['idangkatan'];

if (isset($_REQUEST['idtingkat']))
	$idtingkat = (int)$_REQUEST['idtingkat'];

if (isset($_REQUEST['idkelas']))
	$idkelas = (int)$_REQUEST['idkelas'];
	
$telat = 0;
if (isset($_REQUEST['telat']))
	$telat = (int)$_REQUEST['telat'];
	
$tanggal = "";
if (isset($_REQUEST['tanggal']))
	$tanggal = $_REQUEST['tanggal'];

$tgl = MySqlDateFormat($tanggal);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS KEU [Laporan Tunggakan Iuran Sukarela Siswa Per Kelas]</title>
<script language="javascript" src="script/tables.js"></script>
<script language="javascript" src="script/tools.js"></script>
</head>

<body>

<?
OpenDb();
if ($idtingkat == -1) {
	$sql = "SELECT p.nis, datediff('$tgl', max(tanggal)) AS x FROM penerimaaniuran p, jbsakad.siswa s WHERE p.idpenerimaan = '$idpenerimaan' AND s.nis = p.nis AND s.idangkatan = '$idangkatan' GROUP BY p.nis HAVING x >= $telat ORDER BY tanggal DESC";
} else {
	if ($idkelas == -1)
		$sql = "SELECT p.nis, datediff('$tgl', max(tanggal)) AS x FROM penerimaaniuran p, jbsakad.siswa s, jbsakad.kelas k WHERE p.idpenerimaan = '$idpenerimaan' AND s.nis = p.nis AND s.idangkatan = '$idangkatan' AND s.idkelas = k.replid AND k.idtingkat = '$idtingkat' GROUP BY p.nis HAVING x >= $telat ORDER BY tanggal DESC";
	else
		$sql = "SELECT p.nis, datediff('$tgl', max(tanggal)) AS x FROM penerimaaniuran p, jbsakad.siswa s WHERE p.idpenerimaan = '$idpenerimaan' AND s.nis = p.nis AND s.idangkatan = '$idangkatan' AND s.idkelas = '$idkelas' GROUP BY p.nis HAVING x >= $telat ORDER BY tanggal DESC";
} 
//echo  "$sql<br>";
$result = QueryDb($sql);
$nisstr = "";
while($row = mysqli_fetch_row($result)) {
	if (strlen($nisstr) > 0)
		$nisstr = $nisstr . ",";
	$nisstr = $nisstr . "'" . $row[0] . "'";
}
//echo  "$nisstr<br>";
if (strlen($nisstr) == 0) {
	echo  "Tidak ditemukan data!";
	CloseDb();
	exit();
}

$sql = "SELECT MAX(jumlah) FROM (SELECT nis, count(replid) AS jumlah FROM penerimaaniuran WHERE nis IN ($nisstr) GROUP BY nis) AS X";
//echo  "$sql<br>";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$max_n_cicilan = $row[0];
$table_width = 810 + $max_n_cicilan * 90;

//Dapatkan namapenerimaan
$sql = "SELECT nama, departemen FROM datapenerimaan WHERE replid='$idpenerimaan'";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$namapenerimaan = $row[0];
$departemen = $row[1];

$namatingkat = "";
$namakelas = "";
if ($idtingkat <> -1) {
	if ($idkelas <> -1) {
		$sql = "SELECT tingkat, kelas FROM jbsakad.kelas k, jbsakad.tingkat t WHERE k.replid = '$idkelas' AND k.idtingkat = t.replid AND t.replid = '$idtingkat'";
		$result = QueryDb($sql);
		$row = mysqli_fetch_row($result);
		$namatingkat = $row[0]." - ";
		$namakelas = $row[1];	
	} else {
		$sql = "SELECT tingkat FROM jbsakad.tingkat t WHERE t.replid = '$idtingkat'";
		$result = QueryDb($sql);
		$row = mysqli_fetch_row($result);
		$namatingkat = $row[0];
	}
} else {
	$namakelas = "Semua Kelas";
}
?>

<table border="0" cellpadding="10" cellpadding="5" width="<?=$table_width ?>" align="left">
<tr><td align="left" valign="top">

<?=getHeader($departemen)?>

<center><font size="4"><strong>LAPORAN TUNGGAKAN <?=strtoupper($namapenerimaan) ?><br />
</strong></font><br /> </center><br />
<table border="0">
<tr>
	<td><strong>Departemen </strong></td>
    <td><strong>: <?=$departemen?></strong></td>
</tr>
<tr>
	<td><strong><? if ($idtingkat <> -1 && $idkelas == -1) echo  "Tingkat"; else echo  "Kelas"; ?></strong></td>
    <td><strong>: <?=$namatingkat.$namakelas?></strong></td>
</tr>

<tr>
	<td><strong>Telat Bayar </strong></td>
    <td><strong>: <?=$telat ?> hari dari tanggal <?=LongDateFormat($tanggal)?></strong></td>
</tr>
</table>
<br />

<table class="tab" id="table" border="1" cellpadding="0" style="border-collapse:collapse" cellspacing="0" width="<?=$table_width ?>" align="left" bordercolor="#000000">
<tr height="30">
	<td class="header" width="30" align="center">No</td>
    <td class="header" width="80" align="center">NIS</td>
    <td class="header" width="140" align="center">Nama</td>
    <td class="header" width="50" align="center">Kelas</td>
    <? 	for($i = 0; $i < $max_n_cicilan; $i++) { 
			$n = $i + 1; ?>
    		<td class="header" width="120" align="center"><?="Bayaran-$n" ?></td>	
    <?  } ?>
    <td class="header" width="80" align="center">Telat<br /><em>(hari)</em></td>
    <td class="header" width="100" align="center">Total Pembayaran</td>
</tr>
<?
OpenDb();
$sql = "SELECT s.nis, s.nama, k.kelas, t.tingkat FROM jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t WHERE s.idkelas = k.replid AND k.idtingkat = t.replid AND s.nis IN ($nisstr) ORDER BY $urut $urutan ";//LIMIT ".(int)$page*(int)$varbaris.",$varbaris"; 
$result = QueryDb($sql);
//if ($page==0)
	$cnt = 0;
//else 
	//$cnt = (int)$page*(int)$varbaris;

$totalbiayaall = 0;
$totalbayarall = 0;

while ($row = mysqli_fetch_array($result)) {
	$nis = $row['nis']; ?>
<tr height="40">
	<td align="center"><?=++$cnt ?></td>
    <td align="center"><?=$row['nis'] ?></td>
    <td><?=$row['nama'] ?></td>
    <td align="center"><? if ($idkelas == -1) echo  $row['tingkat']." - "; ?><?=$row['kelas'] ?></td>
<?	$sql = "SELECT count(*) FROM penerimaaniuran WHERE nis = '$nis' AND idpenerimaan = '$idpenerimaan'";
	//echo  "$sql<br>";
	$result2 = QueryDb($sql);
	$row2 = mysqli_fetch_row($result2);
	$nbayar = $row2[0];
	$nblank = $max_n_cicilan - $nbayar;
	$totalbayar = 0;
	
	if ($nbayar > 0) {
		$sql = "SELECT date_format(tanggal, '%d-%b-%y'), jumlah FROM penerimaaniuran WHERE nis = '$nis' AND idpenerimaan = '$idpenerimaan' ORDER BY tanggal";
		$result2 = QueryDb($sql);
		while ($row2 = mysqli_fetch_row($result2)) {
			$totalbayar = $totalbayar + $row2[1]; ?>
            <td>
                <table border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
                <tr height="20"><td align="center"><?=FormatRupiah($row2[1]) ?></td></tr>
                <tr height="20"><td align="center"><?=$row2[0] ?></td></tr>
                </table>
            </td>
 <?		}
 		$totalbayarall += $totalbayar;
	}	
	for ($i = 0; $i < $nblank; $i++) { ?>
	    <td>
            <table border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
            <tr height="20"><td align="center">&nbsp;</td></tr>
            <tr height="20"><td align="center">&nbsp;</td></tr>
            </table>
        </td>
    <? }?>
    <td align="center">
<?	$sql = "SELECT max(datediff('$tanggal', tanggal)) FROM penerimaaniuran WHERE nis = '$nis' AND idpenerimaan = '$idpenerimaan'";
	$result2 = QueryDb($sql);
	$row2 = mysqli_fetch_row($result2);
	echo  $row2[0]; ?>
    </td>
    <td align="right"><?=FormatRupiah($totalbayar) ?></td>
</tr>
<?
}
?>
<tr height="40">
	<td align="center" colspan="<?=5 + $max_n_cicilan ?>" bgcolor="#999900"><font color="#FFFFFF"><strong>T O T A L</strong></font></td>
    <td align="right" bgcolor="#999900"><font color="#FFFFFF"><strong><?=FormatRupiah($totalbayarall) ?></strong></font></td>
</tr>
</table>
<script language='JavaScript'>
	Tables('table', 1, 0);
</script>
<? CloseDb() ?>

	</td>
</tr>
    </table>
</td></tr></table>
</body>
</html>
<script language="javascript">window.print();</script>