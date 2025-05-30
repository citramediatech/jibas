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

$tanggal1 = "";
if (isset($_REQUEST['tanggal1']))
	$tanggal1 = $_REQUEST['tanggal1'];
	
$tanggal2 = "";
if (isset($_REQUEST['tanggal2']))
	$tanggal2 = $_REQUEST['tanggal2'];
	
$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

$idtahunbuku = 0;
if (isset($_REQUEST['idtahunbuku']))
	$idtahunbuku = (int)$_REQUEST['idtahunbuku'];
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

function cetak() {
	var addr = "lapneracaper_cetak.php?departemen=<?=$departemen?>&tanggal1=<?=$tanggal1?>&tanggal2=<?=$tanggal2?>&idtahunbuku=<?=$idtahunbuku?>";
	newWindow(addr, 'NeracaPercobaan','790','630','resizable=1,scrollbars=1,status=0,toolbar=0');
}
function excel() {
	var addr = "lapneracaper_excel.php?departemen=<?=$departemen?>&tanggal1=<?=$tanggal1?>&tanggal2=<?=$tanggal2?>&idtahunbuku=<?=$idtahunbuku?>";
	newWindow(addr, 'NeracaPercobaanExcel','790','630','resizable=1,scrollbars=1,status=0,toolbar=0');
}
</script>
</head>

<body>
<table border="0" width="100%" align="center" background="" style="background-repeat:no-repeat; background-attachment:fixed">
<!-- TABLE CENTER -->
<tr>
	<td>
    <? 
    OpenDb();
	$sql = "SELECT ra.nama, ra.kode, k.kategori, SUM(jd.debet) AS debet, SUM(jd.kredit) AS kredit 
	          FROM rekakun ra, katerekakun k, jurnal j, jurnaldetail jd 
			 WHERE jd.idjurnal = j.replid AND jd.koderek = ra.kode AND ra.kategori = k.kategori 
			   AND j.idtahunbuku = '$idtahunbuku' AND j.tanggal BETWEEN '$tanggal1' AND '$tanggal2' 
		  GROUP BY ra.nama, ra.kode, k.kategori ORDER BY k.urutan, ra.kode;";
	$result = QueryDb($sql);
	if (mysqli_num_rows($result) > 0) {
	?>
    <table border="0" width="100%" align="center">
    <tr>
        <td align="right">
        <a href="#" onClick="document.location.reload()"><img src="images/ico/refresh.png" border="0" onMouseOver="showhint('Refresh!', this, event, '50px')"/>&nbsp;Refresh</a>&nbsp;&nbsp;
        <a href="JavaScript:cetak()"><img src="images/ico/print.png" border="0" onMouseOver="showhint('Cetak!', this, event, '50px')"/>&nbsp;Cetak</a>&nbsp;&nbsp;
        <a href="JavaScript:excel()"><img src="images/ico/excel.png" border="0" onMouseOver="showhint('Buka di Ms Excel!', this, event, '50px')"/>&nbsp;Excel</a>&nbsp;
        </td>
    </tr>
    </table>
    <br />
    <table class="tab" style="border-collapse:collapse" id="table" border="1" cellpadding="2"  width="100%" bordercolor="#000000" />
    <tr height="30">
        <td class="header" width="5%" align="center">No</td>
        <td class="header" width="8%" align="center">Kode</td>
        <td class="header" width="*" align="center">Rekening</td>
        <td class="header" width="20%" align="center">Debet</td>
        <td class="header" width="20%" align="center">Kredit</td>
    </tr>
	<?
    $cnt = 0;
    $totaldebet = 0;
    $totalkredit = 0;
    while($row = mysqli_fetch_array($result)) {
        $kategori = $row['kategori'];
        switch($kategori) {
            case 'HARTA':
			case 'PIUTANG':
            case 'INVENTARIS':
            case 'BIAYA':
                $debet1 = $row['debet'] - $row['kredit'];
                $debet = FormatRupiah($debet1);
                $kredit = "$nbsp";
                $totaldebet += $debet1;
				break;
            default:
                $kredit1 = $row['kredit'] - $row['debet'];
                $kredit = FormatRupiah($kredit1);
                $debet = "&nbsp";
				$totalkredit += $kredit1;
		}
        
        
    ?>
    <tr height="25">
        <td align="center"><?=++$cnt ?></td>
        <td align="center"><?=$row['kode'] ?></td>
        <td align="left"><?=$row['nama'] ?></td>
        <td align="right"><?=$debet ?></td>
        <td align="right"><?=$kredit ?></td>
    </tr>
    <?
    }
    CloseDb();
    ?>
    <tr height="30">
        <td colspan="3" align="center" bgcolor="#999900"><font color="#FFFFFF"><strong>T O T A L</strong></font></td>
        <td align="right" bgcolor="#999900"><font color="#FFFFFF"><strong><?=FormatRupiah($totaldebet) ?></strong></font></td>
        <td align="right" bgcolor="#999900"><font color="#FFFFFF"><strong><?=FormatRupiah($totalkredit) ?></strong></font></td>
    </tr>
    </table>
    <script language='JavaScript'>
        Tables('table', 1, 0);
    </script>
<? } else { ?>
    <table width="100%" border="0" align="center">          
    <tr>
        <td align="center" valign="middle" height="300">
            <font size = "2" color ="red"><b>Tidak ditemukan adanya data transaksi keuangan pada departemen <?=$departemen?> antara tanggal <?=LongDateFormat($tanggal1)?> s/d <?=LongDateFormat($tanggal2)?>.</b></font>
            
        </td>
    </tr>
    </table>  
<? } ?>
	</td>
</tr>
</table>
</body>
</html>