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

/**/
header('Content-Type: application/vnd.ms-excel'); //IE and Opera  
header('Content-Type: application/x-msexcel'); // Other browsers  
header('Content-Disposition: attachment; filename=Laporan_Tunggakan_Iuran_Sukarela_Siswa_setiap_Kelas.xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS KEU [Laporan Tunggakan Iuran Sukarela Siswa Per Kelas]</title>
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

<center><font size="4" face="Verdana"><strong>LAPORAN TUNGGAKAN <?=strtoupper($namapenerimaan) ?><br />
</strong></font><br /> 
</center>
<br />
<table border="0">
<tr>
	<td><font size="2" face="Arial"><strong>Departemen </strong></font></td>
    <td><font size="2" face="Arial"><strong>: 
      <?=$departemen?>
    </strong></font></td>
</tr>
<tr>
	<td><font size="2" face="Arial"><strong>
	  <? if ($idtingkat <> -1 && $idkelas == -1) echo  "Tingkat"; else echo  "Kelas"; ?>
	</strong></font></td>
    <td><font size="2" face="Arial"><strong>: 
      <?=$namatingkat.$namakelas?>
    </strong></font></td>
</tr>

<tr>
	<td><font size="2" face="Arial"><strong>Telat Bayar </strong></font></td>
    <td><font size="2" face="Arial"><strong>: 
      <?=$telat ?> 
      hari dari tanggal 
      <?=LongDateFormat($tanggal)?>
    </strong></font></td>
</tr>
</table>
<br />

<table class="tab" id="table" border="1" cellpadding="0" style="border-collapse:collapse" cellspacing="0" width="<?=$table_width ?>" align="left" bordercolor="#000000">
<tr height="30">
	<td width="30" align="center" bgcolor="#CCCCCC" class="header"><strong><font size="2" face="Arial">No</font></strong></td>
    <td width="80" align="center" bgcolor="#CCCCCC" class="header"><strong><font size="2" face="Arial">NIS</font></strong></td>
    <td width="140" align="center" bgcolor="#CCCCCC" class="header"><strong><font size="2" face="Arial">Nama</font></strong></td>
    <td width="50" align="center" bgcolor="#CCCCCC" class="header"><strong><font size="2" face="Arial">Kelas</font></strong></td>
<? 	for($i = 0; $i < $max_n_cicilan; $i++) { 
			$n = $i + 1; ?>
    		<td width="120" align="center" bgcolor="#CCCCCC" class="header"><strong><font size="2" face="Arial">
   		    <?="Bayaran-$n" ?>
    		</font></strong></td>	
    <?  } ?>
    <td width="80" align="center" bgcolor="#CCCCCC" class="header"><strong><font size="2" face="Arial">Telat<br />
        <em>(hari)</em></font></strong></td>
    <td width="100" align="center" bgcolor="#CCCCCC" class="header"><strong><font size="2" face="Arial">Total Pembayaran</font></strong></td>
</tr>
<?
OpenDb();
$sql = "SELECT s.nis, s.nama, k.kelas, t.tingkat FROM jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t WHERE s.idkelas = k.replid AND k.idtingkat = t.replid AND s.nis IN ($nisstr) ORDER BY $urut $urutan"; 
$result = QueryDb($sql);
$cnt = 0;

$totalbiayaall = 0;
$totalbayarall = 0;

while ($row = mysqli_fetch_array($result)) {
	$bg1="#ffffff";
	if ($cnt==0 || $cnt%2==0)
		$bg1="#fcffd3";
	$nis = $row['nis']; ?>
<tr height="40" bgcolor="<?=$bg1?>">
	<td align="center"><font size="2" face="Arial">
	  <?=++$cnt ?>
	</font></td>
    <td align="center"><font size="2" face="Arial">
      <?=$row['nis'] ?>
    </font></td>
    <td><font size="2" face="Arial">
      <?=$row['nama'] ?>
    </font></td>
    <td align="center"><font size="2" face="Arial">
      <? if ($idkelas == -1) echo  $row['tingkat']." - "; ?>
      <?=$row['kelas'] ?>
    </font></td>
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
		$x=0;
		while ($row2 = mysqli_fetch_row($result2)) {
			$bg2=$bg1;
			if ($x%2==0 || $x==0)
				$bg2="#d3fffd";
			$totalbayar = $totalbayar + $row2[1]; ?>
            <td bgcolor="<?=$bg2?>">
                <table border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
                <tr height="20"><td align="center"><font size="2" face="Arial">
                <?=$row2[1] ?>
                </font></td></tr>
                <tr height="20"><td align="center"><font size="2" face="Arial">
                <?=$row2[0] ?>
                </font></td></tr>
    </table>            </td>
<?		$x++;
		}
 		$totalbayarall += $totalbayar;
	}	
	for ($i = 0; $i < $nblank; $i++) { ?>
	    <td>
            <table border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
            <tr height="20"><td align="center">&nbsp;</td></tr>
            <tr height="20"><td align="center">&nbsp;</td></tr>
    </table>        </td>
    <? }?>
    <td align="center">
      <font size="2" face="Arial">
      <?	$sql = "SELECT max(datediff('$tanggal', tanggal)) FROM penerimaaniuran WHERE nis = '$nis' AND idpenerimaan = '$idpenerimaan'";
	$result2 = QueryDb($sql);
	$row2 = mysqli_fetch_row($result2);
	echo  $row2[0]; ?>    
    </font></td>
    <td align="right"><font size="2" face="Arial">
      <?=$totalbayar ?>
    </font></td>
</tr>
<?
}
?>
<tr height="40">
	<td align="center" colspan="<?=5 + $max_n_cicilan ?>" bgcolor="#999900"><font color="#FFFFFF" size="2" face="Arial"><strong>T O T A L</strong></font></td>
    <td align="right" bgcolor="#999900"><font color="#FFFFFF" size="2" face="Arial"><strong><?=$totalbayarall ?></strong></font></td>
</tr>
</table>
<script language='JavaScript'>
	Tables('table', 1, 0);
</script>
<? CloseDb() ?>

</td>
</tr>
</table>
</body>
</html>
<script language="javascript">window.print();</script>