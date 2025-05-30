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

$urut = "nokas";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	

$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];

$varbaris=10;
if (isset($_REQUEST['varbaris']))
	$varbaris = $_REQUEST['varbaris'];

$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];

$hal=0;
if (isset($_REQUEST['hal']))
	$hal = $_REQUEST['hal'];

if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

if (isset($_REQUEST['idtahunbuku']))
	$idtahunbuku = (int)$_REQUEST['idtahunbuku'];

if (isset($_REQUEST['tanggal1']))
	$tanggal1 = $_REQUEST['tanggal1'];

if (isset($_REQUEST['tanggal2']))
	$tanggal2 = $_REQUEST['tanggal2'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<link rel="stylesheet" type="text/css" href="style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pencarian Jurnal</title>
<script language="javascript" src="script/tables.js"></script>
<script language="javascript" src="script/tools.js"></script>
<script language="javascript" src="script/tooltips.js"></script>
<script language="javascript">
function edit(id) {
	var addr = "editjurnal.php?departemen=<?=$departemen?>&idjurnal="+id+"&jurnal=Pengeluaran";
	newWindow(addr, 'UbahJurnalPenerimaan','680','630','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function refresh() {
	document.location.href = "jurnalpengeluaran_content.php?departemen=<?=$departemen?>&idtahunbuku=<?=$idtahunbuku?>&tanggal1=<?=$tanggal1?>&tanggal2=<?=$tanggal2?>";
}

function cetak() {
	var total=document.getElementById("total").value;
	var addr = "carijurnal_cetak.php?idtahunbuku=<?=$idtahunbuku ?>&tanggal1=<?=$tanggal1?>&tanggal2=<?=$tanggal2?>&kriteria=11&departemen=<?=$departemen?>&varbaris=<?=$varbaris?>&page=<?=$page?>&total="+total+"&urut=<?=$urut?>&urutan=<?=$urutan?>";
	newWindow(addr, 'CetakJurnalPengeluaran','780','580','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function excel() {
	var total=document.getElementById("total").value;
	var addr = "carijurnal_excel.php?idtahunbuku=<?=$idtahunbuku ?>&tanggal1=<?=$tanggal1?>&tanggal2=<?=$tanggal2?>&kriteria=11&departemen=<?=$departemen?>&varbaris=<?=$varbaris?>&page=<?=$page?>&total="+total;
	newWindow(addr, 'ExcelJurnalPengeluaran','780','580','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function change_page(page) {
	var varbaris=document.getElementById("varbaris").value;
	document.location.href = "jurnalpengeluaran_content.php?departemen=<?=$departemen?>&idtahunbuku=<?=$idtahunbuku?>&tanggal1=<?=$tanggal1?>&tanggal2=<?=$tanggal2?>&page="+page+"&hal="+page+"&varbaris="+varbaris;
}

function change_hal() {
	var hal = document.getElementById("hal").value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="jurnalpengeluaran_content.php?departemen=<?=$departemen?>&idtahunbuku=<?=$idtahunbuku?>&tanggal1=<?=$tanggal1?>&tanggal2=<?=$tanggal2?>&page="+hal+"&hal="+hal+"&varbaris="+varbaris;
}

function change_baris() {
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="jurnalpengeluaran_content.php?departemen=<?=$departemen?>&idtahunbuku=<?=$idtahunbuku?>&tanggal1=<?=$tanggal1?>&tanggal2=<?=$tanggal2?>&varbaris="+varbaris;
}
function change_urut(urut,urutan) {		
	if (urutan =="ASC"){
		urutan="DESC"
	} else {
		urutan="ASC"
	}
	var hal = document.getElementById("hal").value;
	var varbaris=document.getElementById("varbaris").value;
	var addr = "jurnalpengeluaran_content.php?departemen=<?=$departemen?>&idtahunbuku=<?=$idtahunbuku?>&tanggal1=<?=$tanggal1?>&tanggal2=<?=$tanggal2?>&page="+hal+"&hal="+hal+"&varbaris="+varbaris+"&urut="+urut+"&urutan="+urutan;
	
	document.location.href = addr;
}
</script>
</head>
<body topmargin="0" leftmargin="0">
<table border="0" width="100%" align="center">
<tr>
	<td>
<? 	OpenDb();

	$sql_tot = "SELECT * FROM jurnal WHERE idtahunbuku = '$idtahunbuku' AND sumber = 'pengeluaran' AND tanggal BETWEEN '$tanggal1' AND '$tanggal2' ORDER BY tanggal";
	
	$result_tot = QueryDb($sql_tot);
	$total=ceil(mysqli_num_rows($result_tot)/(int)$varbaris);
	$jumlah = mysqli_num_rows($result_tot);
	$akhir = ceil($jumlah/5)*5;
	
	$sql = "SELECT * FROM jurnal WHERE idtahunbuku = '$idtahunbuku' AND sumber = 'pengeluaran' AND tanggal BETWEEN '$tanggal1' AND '$tanggal2' ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
	
	$result = QueryDb($sql);
	if (mysqli_num_rows($result) > 0) {

?>    
    <input type="hidden" name="total" id="total" value="<?=$total?>"/>
    <table border="0" width="100%" align="center">
    <tr>
        <td align="right">
        <a href="#" onClick="refresh()"><img src="images/ico/refresh.png" border="0" onMouseOver="showhint('Refresh!', this, event, '50px')"/>&nbsp;Refresh</a>&nbsp;&nbsp;
        <a href="JavaScript:cetak()"><img src="images/ico/print.png" border="0" onMouseOver="showhint('Cetak!', this, event, '50px')"/>&nbsp;Cetak</a>&nbsp;&nbsp;
        <a href="JavaScript:excel()"><img src="images/ico/excel.png" border="0" onMouseOver="showhint('Buka di Ms Excel!', this, event, '50px')"/>&nbsp;Excel</a>&nbsp;
        </td>
    </tr>
    </table>
    <br />
    <table border="1" style="border-collapse:collapse" cellpadding="5" width="100%" class="tab" bordercolor="#000000" cellspacing="0">
    <tr height="30">
        <td width="4%" align="center" class="header">No</td>
        <td width="15%" align="center" class="header" onClick="change_urut('nokas','<?=$urutan?>')">No. Jurnal/Tanggal <?=change_urut('nokas',$urut,$urutan)?></td>
        <td width="35%" align="center" class="header">Transaksi</td>
        <td align="center" class="header">Detail Jurnal</td>  
        
    </tr>

<?
	if ($page==0)
		$cnt = 1;
	else	
		$cnt = (int)$page*(int)$varbaris+1;
		
	while ($row = mysqli_fetch_array($result)) {
		if ($cnt % 2 == 0)
			$bgcolor = "#FFFFB7";
		else
			$bgcolor = "#FFFFB7";
?>
    <tr height="25">
        <td align="center" rowspan="2" bgcolor="<?=$bgcolor ?>"><font size="4"><strong><?=$cnt ?></strong></font></td>
        <td align="center" bgcolor="<?=$bgcolor ?>"><strong><?=$row['nokas']?></strong><br /><em><?=LongDateFormat($row['tanggal'])?></em></td>
        <td valign="top" bgcolor="<?=$bgcolor ?>"><?=$row['transaksi'] ?>
    <?	if (strlen($row['keterangan']) > 0 )  { ?>
            <br /><strong>Keterangan:</strong><?=$row['keterangan'] ?> 
    <?	} ?>    
        </td>
        <td rowspan="2" valign="top" bgcolor="#E8FFE8">
            <table border="1" style="border-collapse:collapse" width="100%" height="100%" cellpadding="2" bgcolor="#FFFFFF" bordercolor="#000000">    
        <?	$idjurnal = $row['replid'];
            $sql = "SELECT jd.koderek,ra.nama,jd.debet,jd.kredit FROM jurnaldetail jd, rekakun ra WHERE jd.idjurnal = '$idjurnal' AND jd.koderek = ra.kode ORDER BY jd.replid";    
            $result2 = QueryDb($sql); 
            while ($row2 = mysqli_fetch_array($result2)) { ?>
            <tr height="25">
                <td width="8%" align="center"><?=$row2['koderek'] ?></td>
                <td width="*" align="left"><?=$row2['nama'] ?></td>
                <td width="23%" align="right"><?=FormatRupiah($row2['debet']) ?></td>
                <td width="23%" align="right"><?=FormatRupiah($row2['kredit']) ?></td>
            </tr>
        <?	} ?>    
            </table>
        </td>
	
    </tr>
    <tr>    
        <td valign="top"><strong>Petugas: </strong><?=$row['petugas'] ?></td>
        <td valign="top">
        <strong>Sumber: Pengeluaran</strong>
    	</td>
    </tr>
    <tr style="height:2px">
        <td colspan="5" bgcolor="#EFEFDE"></td>
    </tr>
    <?
            $cnt++;
    }
    CloseDb();
    ?>
    </table>
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
            //        if ($page==$a){
            //            echo  "<font face='verdana' color='red'><strong>".($a+1)."</strong></font> "; 
            //        }				
            //        else 
            //            { echo  "<a href='#' onClick=\"change_page('".$a."')\">".($a+1)."</a> "; 
            //        }
            //        
            //}
            ?>
             
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
        <td align="center" valign="middle" height="300">
            <font size = "2" color ="red"><b>Tidak ditemukan adanya data.<br />
            Tambah data jurnal pengeluaran pada departemen <?=$departemen?> antara tanggal 
            <?=LongDateFormat($tanggal1)?> s/d <?=LongDateFormat($tanggal2)?><br />
            di menu Pembayaran Pengeluaran pada bagian Pengeluaran.  </font>
            
        </td>
    </tr>
    </table>  
<? } ?>
	</td>
</tr>
</table>
</body>
</html>