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

$idpenerimaan = 0;
if (isset($_REQUEST['idpenerimaan']))
	$idpenerimaan = (int)$_REQUEST['idpenerimaan'];
	
$kelompok = -1;
if (isset($_REQUEST['kelompok']))
	$kelompok = (int)$_REQUEST['kelompok'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Laporan Pembayaran Iuran Sukarela Calon Siswa Per Kelompok</title>
<script language="javascript" src="script/tables.js"></script>
<script language="javascript" src="script/tools.js"></script>
</head>

<body>

<?
OpenDb();

$sql = "SELECT nama, departemen FROM datapenerimaan WHERE replid = '$idpenerimaan'";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$namapenerimaan = $row[0];
$departemen = $row[1];

$sql = "SELECT replid FROM tahunbuku WHERE departemen='$departemen' AND aktif=1";
$idtahunbuku = FetchSingle($sql);

if ($kelompok == -1)
    $sql = "SELECT max(jml) FROM ((SELECT s.replid, COUNT(p.replid) as jml 
									 FROM penerimaaniurancalon p, jurnal j, jbsakad.calonsiswa s 
									WHERE p.idjurnal = j.replid AND j.idtahunbuku = '$idtahunbuku' 
									  AND p.idcalon = s.replid AND p.idpenerimaan = '$idpenerimaan' GROUP BY s.replid) as X)";
else
    $sql = "SELECT max(jml) FROM ((SELECT s.replid, COUNT(p.replid) as jml 
									 FROM penerimaaniurancalon p, jurnal j, jbsakad.calonsiswa s 
									WHERE p.idjurnal = j.replid AND j.idtahunbuku = '$idtahunbuku' 
									  AND p.idcalon = s.replid AND s.idkelompok = '$kelompok' AND p.idpenerimaan = '$idpenerimaan' GROUP BY s.replid) as X)";

$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$max_n_bayar = $row[0];
$table_width = 520 + $max_n_bayar * 100;
?>

<table border="0" cellpadding="10" cellpadding="5" width="<?=$table_width + 50 ?>" align="left">
<tr><td align="left" valign="top">

<?=getHeader($departemen)?>

<center><font size="4"><strong>LAPORAN PEMBAYARAN IURAN SUKARELA CALON SISWA</strong></font><br /> </center><br /><br />


<table class="tab" id="table" border="1" cellpadding="5" style="border-collapse:collapse" cellspacing="0" width="<?=$table_width ?>" align="left" bordercolor="#333333">
<tr height="30" align="center" class="header">
	<td width="30">No</td>
    <td width="90">No. Reg</td>
    <td width="160">Nama</td>
    <td width="50">Kelompok</td>
<?	for($i = 0; $i < $max_n_bayar; $i++) { ?>
	<td class="header" width="125" align="center">Bayaran-<?=$i + 1 ?></td>
<?  } ?>
    <td class="header" width="125" align="center">Total Pembayaran</td>
    <!--<td class="header" width="200" align="center">Keterangan</td>--->
</tr>
<?
OpenDb();

if ($kelompok == -1) 
{
	$sql_tot = "SELECT DISTINCT s.replid, s.nopendaftaran, s.nama, k.kelompok 
	              FROM penerimaaniurancalon p, jurnal j, jbsakad.calonsiswa s, jbsakad.kelompokcalonsiswa k 
				 WHERE p.idjurnal = j.replid AND j.idtahunbuku = '$idtahunbuku' 
				   AND p.idcalon = s.replid AND s.idkelompok = k.replid AND p.idpenerimaan = '$idpenerimaan' ORDER BY s.nama";
	
	$sql = "SELECT DISTINCT s.replid, s.nopendaftaran, s.nama, k.kelompok 
	          FROM penerimaaniurancalon p, jurnal j, jbsakad.calonsiswa s, jbsakad.kelompokcalonsiswa k 
			 WHERE p.idjurnal = j.replid AND j.idtahunbuku = '$idtahunbuku' 
			   AND p.idcalon = s.replid AND s.idkelompok = k.replid AND p.idpenerimaan = '$idpenerimaan' 
		  ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris"; 
} 
else 
{
	$sql_tot = "SELECT DISTINCT s.replid, s.nopendaftaran, s.nama, k.kelompok 
	              FROM penerimaaniurancalon p, jurnal j, jbsakad.calonsiswa s, jbsakad.kelompokcalonsiswa k 
				 WHERE p.idjurnal = j.replid AND j.idtahunbuku = '$idtahunbuku'
				   AND p.idcalon = s.replid AND s.idkelompok = k.replid AND s.idkelompok = '$kelompok' AND p.idpenerimaan = '$idpenerimaan' ORDER BY s.nama";
	
	$sql = "SELECT DISTINCT s.replid, s.nopendaftaran, s.nama, k.kelompok 
	          FROM penerimaaniurancalon p, jurnal j, jbsakad.calonsiswa s, jbsakad.kelompokcalonsiswa k 
			 WHERE p.idjurnal = j.replid AND j.idtahunbuku = '$idtahunbuku'
			   AND p.idcalon = s.replid AND s.idkelompok = k.replid AND s.idkelompok = '$kelompok' AND p.idpenerimaan = '$idpenerimaan' 
	      ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris"; 
}

$result = QueryDb($sql);
if ($page==0)
	$cnt = 0;
else 
	$cnt = (int)$page*(int)$varbaris;
$totalall = 0;
while ($row = mysqli_fetch_array($result)) { 
	$replid = $row['replid'];
?>
	
    <tr height="40">
    	<td align="center"><?=++$cnt ?></td>
        <td align="center"><?=$row['nopendaftaran'] ?></td>
        <td align="left"><?=$row['nama'] ?></td>
        <td align="center"><?=$row['kelompok'] ?></td>
<?		$sql = "SELECT date_format(p.tanggal, '%d-%b-%y') as tanggal, jumlah 
                  FROM penerimaaniurancalon p, jurnal j
				 WHERE p.idjurnal = j.replid AND j.idtahunbuku = '$idtahunbuku' 
				   AND idcalon = '$replid' AND idpenerimaan = '$idpenerimaan'";
		$result2 = QueryDb($sql);
		$nbayar = mysqli_num_rows($result2);
		$nblank = $max_n_bayar - $nbayar;
		
		$totalbayar = 0;
		while ($row2 = mysqli_fetch_array($result2)) {
			$totalbayar += $row2['jumlah']; ?>
            <td>
                <table border="1" width="100%" style="border-collapse:collapse" cellspacing="0" cellpadding="0" bordercolor="#000000">
                <tr height="20"><td align="center"><?=FormatRupiah($row2['jumlah']) ?></td></tr>
                <tr height="20"><td align="center"><?=$row2['tanggal'] ?></td></tr>
                </table>
            </td>
<?		} //end for 
		$totalall += $totalbayar;

		for ($i = 0; $i < $nblank; $i++) { ?>        
            <td>
                <table border="1" width="100%" style="border-collapse:collapse" cellspacing="0" cellpadding="0" bordercolor="#000000">
                <tr height="20"><td align="center">&nbsp;</td></tr>
                <tr height="20"><td align="center">&nbsp;</td></tr>
                </table>
            </td>
<?		} //end for ?>        
		<td align="right"><?=FormatRupiah($totalbayar) ?></td>
        <!--<td align="right"><?=$row['keterangan'] ?></td>-->
    </tr>
<? } //end for ?>
	<tr height="30">
    	<td bgcolor="#999900" align="center" colspan="<?=4 + $max_n_bayar ?>"><font color="#FFFFFF"><strong>T O T A L</strong></font></td>
        <td bgcolor="#999900" align="right"><font color="#FFFFFF"><strong><?=FormatRupiah($totalall) ?></strong></font></td>
        <!--<td bgcolor="#999900">&nbsp;</td>-->
    </tr>
</table>
<?
CloseDb();
?>
</td>
</tr>
    </table>
</td></tr></table>
</body>
</html>
<script language="javascript">window.print();</script>