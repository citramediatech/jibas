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
require_once('library/jurnal.php');
require_once('library/repairdatajttcalon.php');

$idtahunbuku = $_REQUEST['idtahunbuku'];
$replid = $_REQUEST['replid'];
$tanggal1 = $_REQUEST['tanggal1'];
$tanggal2 = $_REQUEST['tanggal2'];

OpenDb();

$sql = "SELECT s.nama, s.nopendaftaran, k.kelompok, p.proses, p.departemen 
          FROM jbsakad.calonsiswa s, jbsakad.kelompokcalonsiswa k, jbsakad.prosespenerimaansiswa p 
			WHERE s.replid = '$replid' AND s.idkelompok = k.replid AND s.idproses = p.replid";
$row = FetchSingleRow($sql);
$namacalon = $row[0];
$kelompok = $row[2];
$proses = $row[3];
$no = $row[1];
$departemen = $row[4];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Pembayaran Per Siswa</title>
<script language="javascript" src="script/tables.js"></script>
<script language="javascript" src="script/tools.js"></script>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr><td align="left" valign="top">

<?=getHeader($departemen)?>

<center><font size="4"><strong>DATA PEMBAYARAN CALON SISWA</strong></font><br /> </center><br /><br />

<table border="0">
<tr>
	<td><strong>Calon Siswa </strong></td>
    <td><strong>: <?=$no . " - " . $namacalon?></strong></td>
</tr>
<tr>
	<td><strong>Proses </strong></td>
    <td><strong>: <?=$proses?></strong></td>
</tr>
<tr>
	<td><strong>Kelompok </strong></td>
    <td><strong>: <?=$kelompok?></strong></td>
</tr>

<tr>
	<td><strong>Tanggal </strong></td>
    <td><strong>: <?=LongDateFormat($tanggal1) . " s/d " . LongDateFormat($tanggal2) ?></strong></td>
</tr>
</table>
<br />

<table border="1" style="border-collapse:collapse" width="100%" bordercolor="#000000"> 
<?
$sql = "SELECT DISTINCT b.replid AS id, b.besar, b.lunas, b.keterangan, d.nama 
          FROM besarjttcalon b, penerimaanjttcalon p, datapenerimaan d 
			WHERE p.idbesarjttcalon = b.replid AND b.idpenerimaan = d.replid AND b.idcalon='$replid' AND b.info2='$idtahunbuku'
			  AND p.tanggal BETWEEN '$tanggal1' AND '$tanggal2' ORDER BY nama";

$totalbesarwjb = 0;
$totalbayarwjb = 0;
$totaldiskonwjb = 0;
$totalsisawjb = 0;

$result = QueryDb($sql);
while ($row = mysqli_fetch_array($result))
{
	$idbesarjtt = $row['id'];
	$namapenerimaan = $row['nama']; 
	$besar = $row['besar'];
	$lunas = $row['lunas'];
	$keterangan = $row['keterangan'];
	
	$sql = "SELECT SUM(jumlah), SUM(info1) FROM penerimaanjttcalon WHERE idbesarjttcalon = '$idbesarjtt'";
	$row2 = FetchSingleRow($sql);
	$pembayaran = $row2[0] + $row2[1];
	$diskon = $row2[1];
	$sisa = $besar - $pembayaran;

    $totalbesarwjb += $besar;
    $totalbayarwjb += $pembayaran;
    $totaldiskonwjb += $diskon;
    $totalsisawjb += $sisa;
	
	$sql = "SELECT jumlah, DATE_FORMAT(tanggal, '%d-%b-%Y') AS ftanggal, info1 FROM penerimaanjttcalon WHERE idbesarjttcalon='$idbesarjtt' ORDER BY tanggal DESC LIMIT 1";
	$result2 = QueryDb($sql);
	$byrakhir = 0;
	$dknakhir = 0;
	$tglakhir = "";
	if (mysqli_num_rows($result2)) {
		$row2 = mysqli_fetch_row($result2);
		$byrakhir = $row2[0];
		$tglakhir = $row2[1];
		$dknakhir = $row2[2];
	};	?>
    <tr height="35">
        <td colspan="4" bgcolor="#99CC00"><font size="2"><strong><em><?=$namapenerimaan?></em></strong></font></td>
    </tr>    
    <tr height="25">
        <td width="20%" bgcolor="#CCFF66"><strong>Total Bayaran</strong> </td>
        <td width="15%" bgcolor="#FFFFFF" align="right"><?=FormatRupiah($besar) ?></td>
        <td width="22%" bgcolor="#CCFF66" align="center"><strong>Pembayaran Terakhir</strong></td>
        <td width="43%" bgcolor="#CCFF66" align="center"><strong>Keterangan</strong></td>
    </tr>
    <tr height="25">
        <td bgcolor="#CCFF66"><strong>Jumlah Besar Pembayaran</strong> </td>
        <td bgcolor="#FFFFFF" align="right"><?=FormatRupiah($pembayaran) ?></td>
        <td bgcolor="#FFFFFF" align="center" valign="top" rowspan="3"><?=FormatRupiah($byrakhir) . "<br><i>" . $tglakhir . "</i><br>(diskon " . FormatRupiah($dknakhir) . ")" ?> </td>
        <td bgcolor="#FFFFFF" align="left" valign="top" rowspan="3"><?=$keterangan ?></td>
    </tr>
	<tr height="25">
        <td bgcolor="#CCFF66"><strong>Jumlah Diskon</strong> </td>
        <td bgcolor="#FFFFFF" align="right"><?=FormatRupiah($diskon) ?></td>
    </tr>
    <tr height="25">
        <td bgcolor="#CCFF66"><strong>Sisa Bayaran</strong> </td>
        <td bgcolor="#FFFFFF" align="right"><?=FormatRupiah($sisa) ?></td>
    </tr>
    <tr height="3">
        <td colspan="4" bgcolor="#E8E8E8">&nbsp;</td>
    </tr>
<? 
} //while iuran wajib

$totalbayarskr = 0;

$sql = "SELECT DISTINCT p.idpenerimaan, d.nama 
          FROM penerimaaniurancalon p, jurnal j, datapenerimaan d 
			WHERE p.idjurnal = j.replid AND j.idtahunbuku = '$idtahunbuku'
			  AND p.idpenerimaan = d.replid AND p.idcalon='$replid' AND p.tanggal BETWEEN '$tanggal1' AND '$tanggal2' ORDER BY nama";
$result = QueryDb($sql);
while ($row = mysqli_fetch_array($result)) {
	$idpenerimaan = $row['idpenerimaan'];
	$namapenerimaan = $row['nama'];
	
	$sql = "SELECT SUM(jumlah) FROM penerimaaniurancalon WHERE idpenerimaan='$idpenerimaan' AND idcalon='$replid'";
	$pembayaran = FetchSingle($sql);
    $totalbayarskr += $pembayaran;

	$sql = "SELECT jumlah, DATE_FORMAT(tanggal, '%d-%b-%Y') AS ftanggal FROM penerimaaniurancalon WHERE idpenerimaan='$idpenerimaan' AND idcalon='$replid' ORDER BY tanggal DESC LIMIT 1";
	$result2 = QueryDb($sql);
	$byrakhir = 0;
	$tglakhir = "";
	if (mysqli_num_rows($result2)) {
		$row2 = mysqli_fetch_row($result2);
		$byrakhir = $row2[0];
		$tglakhir = $row2[1];
	};	
?>
 	<tr height="35">
        <td colspan="4" bgcolor="#99CC00"><font size="2"><strong><em><?=$namapenerimaan?></em></strong></font></td>
    </tr>  
   	<tr height="25">
        <td width="22%" bgcolor="#CCFF66" align="center"><strong>Total Pembayaran</strong> </td>
        <td width="22%" bgcolor="#CCFF66" align="center"><strong>Pembayaran Terakhir</strong></td>
        <td width="50%" colspan="2" bgcolor="#CCFF66" align="center"><strong>Keterangan</strong></td>
    </tr>
    <tr height="25">
        <td bgcolor="#FFFFFF" align="center"><?=FormatRupiah($pembayaran) ?></td>
        <td bgcolor="#FFFFFF" align="center"><?=FormatRupiah($byrakhir) . "<br><i>" . $tglakhir . "</i>" ?></td>
        <td colspan="2" bgcolor="#FFFFFF" align="left">&nbsp;</td>
    </tr>
    <tr height="3">
        <td colspan="4" bgcolor="#E8E8E8">&nbsp;</td>
    </tr>
<?
} //while iuran sukarela
?>

</table>

<br><br>
<font style="font-size: 16px;">REKAPITULASI PEMBAYARAN</font>
<table border="0" width="900">
<tr>
    <td width="50%" align="left" valign="top">
        <table border="1" style="border-width: 1px; border-collapse: collapse;" cellpadding="5">
        <tr>
            <td colspan="2" style="background-color: #87c7f4; font-size: 14px;">Iuran Wajib Siswa</td>
        </tr>
        <tr>
            <td width="240" align="left" style="background-color: #e6f5ff">Total Semua Besar Bayaran</td>
            <td width="140" align="right"><?=FormatRupiah($totalbesarwjb)?></td>
        </tr>
        <tr>
            <td align="left" style="background-color: #e6f5ff">Total Semua Pembayaran</td>
            <td align="right"><?=FormatRupiah($totalbayarwjb)?></td>
        </tr>
        <tr>
            <td align="left" style="background-color: #e6f5ff">Total Semua Diskon</td>
            <td align="right"><?=FormatRupiah($totaldiskonwjb)?></td>
        </tr>
        <tr>
            <td align="left" style="background-color: #e6f5ff">Total Semua Sisa Tagihan</td>
            <td align="right"><?=FormatRupiah($totalsisawjb)?></td>
        </tr>
        </table>
    </td>
    <td width="50%" align="left" valign="top">
        <table border="1" style="border-width: 1px; border-collapse: collapse;" cellpadding="5">
        <tr>
            <td colspan="2" style="background-color: #87c7f4; font-size: 14px;">Iuran Sukarela Siswa</td>
        </tr>
        <tr>
            <td width="240" align="left" style="background-color: #e6f5ff">Total Semua Pembayaran</td>
            <td width="140" align="right"><?=FormatRupiah($totalbayarskr)?></td>
        </tr>
        </table>
    </td>
</tr>
</table>

<?
CloseDb();
?>

</table>

</td></tr></table>
</body>
</html>
<script language="javascript">window.print();</script>