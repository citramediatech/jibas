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

$idtahunbuku = "";
if (isset($_REQUEST['idtahunbuku']))
	$idtahunbuku = $_REQUEST['idtahunbuku'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<link rel="stylesheet" type="text/css" href="style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script language="javascript" src="script/tooltips.js"></script>
<script language="javascript" src="script/tables.js"></script>
<script language="javascript" src="script/tools.js"></script>
<script language="javascript">
function cetak() 
{
	var addr = "lapaudit_pengeluaran_cetak.php?idtahunbuku=<?=$idtahunbuku?>&departemen=<?=$departemen?>&tanggal1=<?=$tanggal1?>&tanggal2=<?=$tanggal2?>";
	newWindow(addr, 'CetakAuditPengeluaran','780','580','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function excel() 
{
	var addr = "lapaudit_pengeluaran_excel.php?idtahunbuku=<?=$idtahunbuku?>&departemen=<?=$departemen?>&tanggal1=<?=$tanggal1?>&tanggal2=<?=$tanggal2?>";
	newWindow(addr, 'ExcelAuditPengeluaran','780','580','resizable=1,scrollbars=1,status=0,toolbar=0');
}
</script>
</head>

<body topmargin="0" marginheight="0" >
<br />
<table width="100%" border="0" align="center">
<tr>
	<td valign="top" background="" style="background-repeat:no-repeat; background-attachment:fixed">
  	<table width="100%" border="0" height="100%" cellspacing="0" cellpadding="0">
   	<tr>
		<td><font size="2" color="#990000">
        	<strong>Perubahan Data Pengeluaran</strong></font>
        </td>
        <td align="right">
        <a href="#" onClick="document.location.reload()"><img src="images/ico/refresh.png" border="0" onMouseOver="showhint('Refresh!', this, event, '50px')"/>&nbsp;Refresh</a>&nbsp;
        <a href="JavaScript:cetak()"><img src="images/ico/print.png" border="0" onMouseOver="showhint('Cetak!', this, event, '50px')"/>&nbsp;Cetak</a>&nbsp;
        <a href="JavaScript:excel()"><img src="images/ico/excel.png" border="0" onMouseOver="showhint('Buka di Ms Excel!', this, event, '50px')"/>&nbsp;Excel</a>&nbsp;
        </td>
    </tr>
    </table>
    <br />
    <table class="tab" id="table" border="1" width="100%" align="left" cellpadding="5" cellspacing="0" bordercolor="#000000">
    <tr height="30" align="center">
        <td class="header" width="3%">No</td>
        <td class="header" width="17%">Status Data</td>
        <td class="header" width="10%">Tanggal</td>
        <td class="header" width="15%">Jumlah</td>
        <td class="header" width="*">Keterangan</td>
        <td class="header" width="15%">Petugas</td>
    </tr>
<?  OpenDb();

    $sql = "SELECT DISTINCT ai.petugas as petugasubah, j.transaksi, date_format(ai.tanggal, '%d-%b-%Y %H:%i:%s') as tanggalubah, 
	  					 ap.replid AS id, ap.idaudit, ap.statusdata, j.nokas, date_format(ap.tanggal, '%d-%b-%Y') AS tanggal, ap.petugas, 
						 ap.keterangan, ap.jumlah, ap.petugas, ai.alasan 
				  FROM auditpengeluaran ap, auditinfo ai, jurnal j 
				 WHERE j.replid = ap.idjurnal AND j.idtahunbuku = '$idtahunbuku' AND ap.idaudit = ai.replid  AND ai.departemen = '$departemen' 
				   AND ai.sumber='pengeluaran' AND ai.tanggal BETWEEN '$tanggal1 00:00:00' AND '$tanggal2 23:59:59' 
		  	 ORDER BY ap.idaudit DESC, ai.tanggal DESC, ap.statusdata ASC";
			 
    $result = QueryDb($sql);
    $cnt = 0;
    $no = 0;
    while ($row = mysqli_fetch_array($result)) 
	 {
        $statusdata = "Data Lama";
		  $bgcolor = "#FFFFFF";
        if ($row['statusdata'] == 1) 
		  {
            $statusdata = "Data Perubahan";
				$bgcolor = "#FFFFB7";
        }    
            
        if ($cnt % 2 == 0) 
		  { ?>
        <tr>
            <td rowspan="4" align="center" bgcolor="#ededed"><strong><?=++$no ?></strong></td>
            <td colspan="6" align="left" style="background-color: #3994c6; color: #ffffff;"><font size="2"><em><strong>Perubahan dilakukan oleh <?=$row['petugasubah'] . " tanggal " . $row['tanggalubah'] ?></strong></em></font></td>
        </tr>
        <tr>
            <td colspan="6" style="background-color: #e5fdff;"><strong>No. Jurnal :</strong> <?=$row['nokas'] ?>
            &nbsp;&nbsp;<strong>Alasan : </strong><?=$row['alasan'];?>
            <br /><strong>Transaksi :</strong> <?=$row['transaksi'] ?></td>
        </tr>
    <?  } ?>
        <tr bgcolor="<?=$bgcolor?>">
            <td><?=$statusdata ?></td>
            <td align="center"><?=$row['tanggal'] ?></td>
            <td align="right"><?=FormatRupiah($row['jumlah']) ?></td>
            <td><?=$row['keterangan'] ?></td>
            <td align="center"><?=$row['petugas']; ?></td>
        </tr>
    <?
        $cnt++;
    }
    CloseDb();
    ?>
    </table>
    </td>
</tr>
</table>
</body>
</html>