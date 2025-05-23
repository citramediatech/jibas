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
require_once('include/sessionchecker.php');
require_once('include/common.php');
require_once('include/rupiah.php');
require_once('include/config.php');
require_once('include/db_functions.php');

if (isset($_REQUEST['idpenerimaan']))
	$idpenerimaan = (int)$_REQUEST['idpenerimaan'];
	
if (isset($_REQUEST['idangkatan']))
	$idangkatan = (int)$_REQUEST['idangkatan'];

if (isset($_REQUEST['idtingkat']))
	$idtingkat = (int)$_REQUEST['idtingkat'];

if (isset($_REQUEST['idkelas']))
	$idkelas = (int)$_REQUEST['idkelas'];
	
if (isset($_REQUEST['telat']))
	$telat = (int)$_REQUEST['telat'];
	
$tanggal = "";
if (isset($_REQUEST['tanggal']))
	$tanggal = $_REQUEST['tanggal'];
	
$tgl = MySqlDateFormat($tanggal);

$varbaris=10;
if (isset($_REQUEST['varbaris']))
	$varbaris = $_REQUEST['varbaris'];

$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
	
$hal=0;
if (isset($_REQUEST['hal']))
	$hal = $_REQUEST['hal'];

$urut = "nama";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	

$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/tooltips.css">
<title>Untitled Document</title>
<script language="javascript" src="script/tooltips.js"></script>
<script language="javascript" src="script/tables.js"></script>
<script language="javascript" src="script/tools.js"></script>
<script language="javascript">

function refresh() {	
	document.location.href = "lapbayarsiswa_nunggak_skr.php?idkelas=<?=$idkelas ?>&idangkatan=<?=$idangkatan ?>&idpenerimaan=<?=$idpenerimaan ?>&telat=<?=$telat ?>&tanggal=<?=$tanggal ?>&idtingkat=<?=$idtingkat?>";
}

function cetak() {
	var total = document.getElementById("tes").value;
	var addr = "lapbayarsiswa_nunggak_skr_cetak.php?idkelas=<?=$idkelas ?>&idangkatan=<?=$idangkatan ?>&idpenerimaan=<?=$idpenerimaan ?>&telat=<?=$telat ?>&tanggal=<?=$tanggal ?>&idtingkat=<?=$idtingkat?>&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris=<?=$varbaris?>&page=<?=$page?>&total="+total;
	newWindow(addr, 'CetakLapPembayaranNunggakSkr','1000','580','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function excel() {
	var total = document.getElementById("tes").value;
	var addr = "lapbayarsiswa_nunggak_skr_excel.php?idkelas=<?=$idkelas ?>&idangkatan=<?=$idangkatan ?>&idpenerimaan=<?=$idpenerimaan ?>&telat=<?=$telat ?>&tanggal=<?=$tanggal ?>&idtingkat=<?=$idtingkat?>&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris=<?=$varbaris?>&page=<?=$page?>&total="+total;
	newWindow(addr, 'ExcelLapPembayaranNunggakSkr','1000','580','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function change_urut(urut,urutan) {		
	
	var varbaris=document.getElementById("varbaris").value;
		
	if (urutan =="ASC"){
		urutan="DESC"
	} else {
		urutan="ASC"
	}
	
	
	document.location.href = "lapbayarsiswa_nunggak_skr.php?idkelas=<?=$idkelas ?>&idangkatan=<?=$idangkatan ?>&idpenerimaan=<?=$idpenerimaan ?>&telat=<?=$telat ?>&tanggal=<?=$tanggal ?>&idtingkat=<?=$idtingkat?>&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris="+varbaris;
}

function change_page(page) {
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="lapbayarsiswa_nunggak_skr.php?idkelas=<?=$idkelas ?>&idangkatan=<?=$idangkatan ?>&idpenerimaan=<?=$idpenerimaan ?>&telat=<?=$telat ?>&tanggal=<?=$tanggal ?>&idtingkat=<?=$idtingkat?>&page="+page+"&hal="+page+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
}

function change_hal() {
	var hal = document.getElementById("hal").value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="lapbayarsiswa_nunggak_skr.php?idkelas=<?=$idkelas ?>&idangkatan=<?=$idangkatan ?>&idpenerimaan=<?=$idpenerimaan ?>&telat=<?=$telat ?>&tanggal=<?=$tanggal ?>&idtingkat=<?=$idtingkat?>&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris+"&page="+hal+"&hal="+hal;
}

function change_baris() {
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="lapbayarsiswa_nunggak_skr.php?idkelas=<?=$idkelas ?>&idangkatan=<?=$idangkatan ?>&idpenerimaan=<?=$idpenerimaan ?>&telat=<?=$telat ?>&tanggal=<?=$tanggal ?>&idtingkat=<?=$idtingkat?>&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
}
</script>
</head>
<body leftmargin="0" topmargin="0">

<?
OpenDb();
if ($idtingkat == -1) {
	$sql = "SELECT p.nis, datediff('$tgl', max(tanggal)) AS x FROM penerimaaniuran p, jbsakad.siswa s WHERE p.idpenerimaan = '$idpenerimaan' AND s.nis = p.nis AND s.idangkatan = '$idangkatan' GROUP BY p.nis HAVING x >= $telat ORDER BY tanggal DESC";
} else {
	if ($idkelas == -1)
		$sql = "SELECT p.nis, datediff('$tgl', max(tanggal)) AS x FROM penerimaaniuran p, jbsakad.siswa s, jbsakad.kelas k WHERE p.idpenerimaan = '$idpenerimaan' AND s.nis = p.nis AND s.idangkatan = '$idangkata'n AND s.idkelas = k.replid AND k.idtingkat = '$idtingkat' GROUP BY p.nis HAVING x >= $telat ORDER BY tanggal DESC";
	else
		$sql = "SELECT p.nis, datediff('$tgl', max(tanggal)) AS x FROM penerimaaniuran p, jbsakad.siswa s WHERE p.idpenerimaan = '$idpenerimaan' AND s.nis = p.nis AND s.idangkatan = '$idangkatan' AND s.idkelas = '$idkelas' GROUP BY p.nis HAVING x >= $telat ORDER BY tanggal DESC";
}

$result = QueryDb($sql);
$nisstr = "";
while($row = mysqli_fetch_row($result)) {
	if (strlen($nisstr) > 0)
		$nisstr = $nisstr . ",";
	$nisstr = $nisstr . "'" . $row[0] . "'";
}


//Dapatkan namapenerimaan
$sql = "SELECT nama FROM datapenerimaan WHERE replid=$idpenerimaan";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$namapenerimaan = $row[0];
?>
<table border="0" width="100%" align="center" background="" style="background-repeat:no-repeat; background-attachment:fixed">
<!-- TABLE CENTER -->
<tr>
	<td>

<? if (strlen($nisstr) > 0) { 
	$sql = "SELECT MAX(jumlah) FROM (SELECT nis, count(replid) AS jumlah FROM penerimaaniuran WHERE nis IN ($nisstr) GROUP BY nis) AS X";
	//echo  "$sql<br>";
	$result = QueryDb($sql);
	$row = mysqli_fetch_row($result);
	$max_n_cicilan = $row[0];
	$table_width = 810 + $max_n_cicilan * 90;
?>
	<table width="100%" border="0" align="center">
    <tr>
    	<td valign="bottom">
    <a href="#" onClick="refresh()"><img src="images/ico/refresh.png" border="0" onMouseOver="showhint('Refresh!', this, event, '50px')"/>&nbsp;Refresh</a>&nbsp;
    <a href="JavaScript:cetak()"><img src="images/ico/print.png" border="0" onMouseOver="showhint('Cetak!', this, event, '50px')"/>&nbsp;Cetak</a>&nbsp;
    <a href="JavaScript:excel()"><img src="images/ico/excel.png" border="0" onMouseOver="showhint('Buka di Ms Excel!', this, event, '50px')"/>&nbsp;Excel</a>&nbsp;
    	</td>
	</tr>
	</table>
	<br />
	<table class="tab" id="table" border="1" cellpadding="5" style="border-collapse:collapse" cellspacing="0" width="<?=$table_width ?>" align="left" bordercolor="#000000">
    <tr height="30" class="header" align="center">
        <td width="30" >No</td>
        <td width="80" onMouseOver="background='style/formbg2agreen.gif';height=30;" onMouseOut="background='style/formbg2.gif';height=30;" background="style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('nis','<?=$urutan?>')">N I S <?=change_urut('nis',$urut,$urutan)?></td>
        <td width="140" onMouseOver="background='style/formbg2agreen.gif';height=30;" onMouseOut="background='style/formbg2.gif';height=30;" background="style/formbg2.gif" style="cursor:pointer;" onClick="change_urut('nama','<?=$urutan?>')">Nama <?=change_urut('nama',$urut,$urutan)?></td>
        <td width="50">Kelas</td>
        <? 	for($i = 0; $i < $max_n_cicilan; $i++) { 
                $n = $i + 1; ?>
                <td class="header" width="120" align="center"><?="Bayaran-$n" ?></td>	
        <?  } ?>
        <td width="80">Telat<br /><em>(hari)</em></td>
        <td width="100">Total Pembayaran</td>
    </tr>
<?
$sql_tot = "SELECT s.nis, s.nama, k.kelas, t.tingkat FROM jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t WHERE s.idkelas = k.replid AND k.idtingkat = t.replid AND s.nis IN ($nisstr) ORDER BY s.nama";

$sql = "SELECT s.nis, s.nama, k.kelas, t.tingkat FROM jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t WHERE s.idkelas = k.replid AND k.idtingkat = t.replid AND s.nis IN ($nisstr) ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris"; 

$result_tot = QueryDb($sql_tot);
$total=ceil(mysqli_num_rows($result_tot)/(int)$varbaris);
$jumlah = mysqli_num_rows($result_tot);
$akhir = ceil($jumlah/5)*5;

$result = QueryDb($sql);
if ($page==0)
	$cnt = 0;
else 
	$cnt = (int)$page*(int)$varbaris;
$totalbiayaall = 0;
$totalbayarall = 0;

$totalbiayaallB = 0;
while ($rowA = @mysqli_fetch_row($result_tot)) {
	$sqlB = "SELECT jumlah FROM penerimaaniuran WHERE nis = '$rowA[0]' AND idpenerimaan = '$idpenerimaan' ORDER BY tanggal";
	$resultB = QueryDb($sqlB);
	while ($rowB = mysqli_fetch_row($resultB)) {
		$totalbiayaallB += $rowB[0];
	}
}

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
		$sql = "SELECT date_format(tanggal, '%d-%b-%y'), jumlah FROM penerimaaniuran WHERE nis = '$nis' AND idpenerimaan = $idpenerimaan ORDER BY tanggal";
		$result2 = QueryDb($sql);
		while ($row2 = mysqli_fetch_row($result2)) {
			$totalbayar = $totalbayar + $row2[1]; ?>
            <td>
                <table border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse" bordercolor="#000000">
                <tr height="20"><td align="center"><?=FormatRupiah($row2[1]) ?></td></tr>
                <tr height="20"><td align="center"><?=$row2[0] ?></td></tr>
                </table>
            </td>
 <?		}
 		$totalbayarall += $totalbayar;
	}	
	for ($i = 0; $i < $nblank; $i++) { ?>
	    <td>
            <table border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse" bordercolor="#000000">
            <tr height="20"><td align="center">&nbsp;</td></tr>
            <tr height="20"><td align="center">&nbsp;</td></tr>
            </table>
        </td>
    <? }?>
    	<td align="center">
<?	$sql = "SELECT max(datediff('$tgl', tanggal)) FROM penerimaaniuran WHERE nis = '$nis' AND idpenerimaan = '$idpenerimaan'";
	$result2 = QueryDb($sql);
	$row2 = mysqli_fetch_row($result2);
	echo  $row2[0]; ?>
        </td>
        <td align="right"><?=FormatRupiah($totalbayar) ?></td>
    </tr>
<?
}
?>
	<input type="hidden" name="tes" id="tes" value="<?=$total?>"/>
    <? if ($page==$total-1){ ?>
	<tr height="40">
        <td align="center" colspan="<?=5 + $max_n_cicilan ?>" bgcolor="#999900"><font color="#FFFFFF"><strong>T O T A L</strong></font></td>
        <td align="right" bgcolor="#999900"><font color="#FFFFFF"><strong><?=FormatRupiah($totalbiayaallB) ?></strong></font></td>
    </tr>
	<? } ?>
    </table>
    <script language='JavaScript'>
        Tables('table', 1, 0);
    </script>
    <? CloseDb() ?>
    <?	if ($page==0){ 
		$disback="style='display:none;'";
		$disnext="style=''";
		}
		if ($page<$total && $page>0){
		$disback="style=''";
		$disnext="style=''";
		}
		if ($page==$total-1 && $page>0){
		$disback="style=''";
		$disnext="style='display:none;'";
		}
		if ($page==$total-1 && $page==0){
		$disback="style='display:none;'";
		$disnext="style='display:none;'";
		}
	?>
    </td>
</tr> 
<tr>
    <td>
    <table border="0"width="100%" align="center"cellpadding="0" cellspacing="0">	
    <tr>
       	<td width="30%" align="left" colspan="2">Halaman
		<input <?=$disback?> type="button" class="but" name="back" value=" << " onClick="change_page('<?=(int)$page-1?>')" onMouseOver="showhint('Sebelumnya', this, event, '75px')">
        <select name="hal" id="hal" onChange="change_hal()">
        <?	for ($m=0; $m<$total; $m++) {?>
             <option value="<?=$m ?>" <?=IntIsSelected($hal,$m) ?>><?=$m+1 ?></option>
        <? } ?>
     	</select>
		<input <?=$disnext?> type="button" class="but" name="next" value=" >> " onClick="change_page('<?=(int)$page+1?>')" onMouseOver="showhint('Berikutnya', this, event, '75px')">
	  	dari <?=$total?> halaman
		
		<? 
     // Navigasi halaman berikutnya dan sebelumnya
        ?>
		<?
		//for($a=0;$a<$total;$a++){
		//	if ($page==$a){
		//		echo  "<font face='verdana' color='red'><strong>".($a+1)."</strong></font> "; 
		//	} else { 
		//		echo  "<a href='#' onClick=\"change_page('".$a."')\">".($a+1)."</a> "; 
		//	}
		//		 
	    //}
		?>
	     
 		</td>
        <td width="30%" align="right">Jumlah baris per halaman
      	<select name="varbaris" id="varbaris" onChange="change_baris()">
        <? 	for ($m=5; $m <= $akhir; $m=$m+5) { ?>
        	<option value="<?=$m ?>" <?=IntIsSelected($varbaris,$m) ?>><?=$m ?></option>
        <? 	} ?>
       
      	</select></td>
    </tr>
    </table>
<? } else { ?>
    <table width="100%" border="0" align="center">          
    <tr>
        <td align="center" valign="middle" height="250">
            <font size = "2" color ="red"><b>Tidak ditemukan adanya siswa yang menunggak pembayaran.
            </font>
        </td>
    </tr>
    </table>  
<? } ?>
    </td>
</tr>
</table>
</body>
</html>