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
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

$cari=$_REQUEST['cari'];
$jenis=$_REQUEST['jenis'];
$departemen=$_REQUEST['departemen'];
//$angkatan=$_REQUEST['angkatan'];

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
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pencarian Alumni[Menu]</title>
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="javascript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/ajax.js"></script>
<script language="javascript">
function refresh() {
	var departemen = document.getElementById('departemen').value;
	var jenis= document.getElementById('jenis').value;
	var cari= document.getElementById('cari').value;
	
	document.location.href = "alumni_cari_footer.php?departemen="+departemen+"&jenis="+jenis+"&cari="+cari;	
}

function change_urutan(urut,urutan) {
	var cari = document.getElementById("cari").value;
	var departemen = document.getElementById("departemen").value;
	//var angkatan = document.getElementById("angkatan").value;
	var jenis = document.getElementById("jenis").value;
	
	if (urutan =="ASC"){
		urutan="DESC"
	} else {
		urutan="ASC"
	}
	
	document.location.href = "alumni_cari_footer.php?departemen="+departemen+"&jenis="+jenis+"&cari="+cari+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
}

function excel(urut,urutan) {
	var cari = document.getElementById("cari").value;
	var departemen = document.getElementById("departemen").value;
	var jenis = document.getElementById("jenis").value;
	var page = document.getElementById("hal").value;
	var varbaris=document.getElementById("varbaris").value;
	newWindow('alumni_cari_excel.php?departemen='+departemen+'&jenis='+jenis+'&cari='+cari+'&urut='+urut+'&urutan='+urutan+'&page='+page+'&hal='+page+"&varbaris="+varbaris,'CetakPencarianAlumniExcel','790','650','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function cetak(urut,urutan) {
	var cari = document.getElementById("cari").value;
	var departemen = document.getElementById("departemen").value;
	var jenis = document.getElementById("jenis").value;
	var total=document.getElementById("total").value;
	
	newWindow('alumni_cari_cetak.php?departemen='+departemen+'&jenis='+jenis+'&cari='+cari+'&urut='+urut+'&urutan='+urutan+'&varbaris=<?=$varbaris?>&page=<?=$page?>&total='+total,'CetakPencarianAlumniCetak','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function change_page(page) {
	var cari = document.getElementById("cari").value;
	var departemen = document.getElementById("departemen").value;
	var jenis = document.getElementById("jenis").value;
	
	document.location.href = "alumni_cari_footer.php?departemen="+departemen+"&jenis="+jenis+"&cari="+cari+"&urut=<?=$urut?>&urutan=<?=$urutan?>&page="+page+"&hal="+page+"&varbaris="+varbaris;
}

function change_hal() {
	var departemen = document.getElementById('departemen').value;
	var jenis = document.getElementById('jenis').value;
	var cari = document.getElementById('cari').value;
	var hal = document.getElementById("hal").value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="alumni_cari_footer.php?departemen="+departemen+"&jenis="+jenis+"&cari="+cari+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
}

function change_baris() {
	var departemen = document.getElementById('departemen').value;
	var jenis = document.getElementById('jenis').value;
	var cari = document.getElementById('cari').value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="alumni_cari_footer.php?departemen="+departemen+"&jenis="+jenis+"&cari="+cari+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
}

</script>
</head>
<body leftmargin="0" topmargin="0">
<table border="0" width="100%" align="center">
<!-- TABLE CENTER -->
<tr>
	<td>
<input type="hidden" name="departemen" id="departemen" value="<?=$departemen?>">
<input type="hidden" name="cari" id="cari" value="<?=$cari?>">
<input type="hidden" name="jenis" id="jenis" value="<?=$jenis?>">
<?
	OpenDb();
	if ($jenis!="kondisi" && $jenis!="status" && $jenis!="agama" && $jenis!="suku" && $jenis!="darah" && $jenis!="idangkatan" && $jenis!="tgllulus") {
		$sql_tot = "SELECT s.replid, s.nis, s.nama, s.idkelas, k.kelas, s.tmplahir, s.tgllahir, s.statusmutasi, s.aktif, s.alumni, a.tgllulus from jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t, jbsakad.alumni a WHERE s.$jenis LIKE '%$cari%' AND k.replid=a.klsakhir AND k.idtingkat=t.replid AND a.departemen='$departemen' AND s.nis = a.nis"; 
		$sql_siswa = "SELECT s.replid, s.nis, s.nama, s.idkelas, k.kelas, s.tmplahir, s.tgllahir, s.statusmutasi, s.aktif, s.alumni, t.tingkat, a.tgllulus from jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t, jbsakad.alumni a WHERE s.$jenis LIKE '%$cari%' AND k.replid=a.klsakhir AND k.idtingkat=t.replid AND a.departemen='$departemen' AND s.nis = a.nis ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris"; 
	} elseif ($jenis == "tgllulus") {
		$sql_tot = "SELECT s.replid, s.nis, s.nama, s.idkelas, k.kelas, s.tmplahir, s.tgllahir, s.statusmutasi, s.aktif, s.alumni, a.tgllulus from jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t, jbsakad.alumni a WHERE YEAR(a.tgllulus) ='$cari' AND k.replid=a.klsakhir AND k.idtingkat=t.replid AND a.departemen='$departemen' AND s.nis = a.nis"; 
		$sql_siswa = "SELECT s.replid, s.nis, s.nama, s.idkelas, k.kelas, s.tmplahir, s.tgllahir, s.statusmutasi, s.aktif, s.alumni, t.tingkat, a.tgllulus from jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t, jbsakad.alumni a WHERE YEAR(a.tgllulus) = '$cari' AND k.replid=a.klsakhir AND k.idtingkat=t.replid AND a.departemen='$departemen' AND s.nis = a.nis ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris"; 
	} else { 
		$sql_tot = "SELECT s.replid, s.nis, s.nama, s.idkelas, k.kelas, s.tmplahir, s.tgllahir, s.statusmutasi, s.aktif, s.alumni, a.tgllulus from jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t, jbsakad.alumni a WHERE s.$jenis ='$cari' AND k.replid=a.klsakhir AND k.idtingkat=t.replid AND a.departemen='$departemen' AND s.nis = a.nis"; 
		$sql_siswa = "SELECT s.replid, s.nis, s.nama, s.idkelas, k.kelas, s.tmplahir, s.tgllahir, s.statusmutasi, s.aktif, s.alumni, t.tingkat, a.tgllulus from jbsakad.siswa s, jbsakad.kelas k, jbsakad.tingkat t, jbsakad.alumni a WHERE s.$jenis = '$cari' AND k.replid=a.klsakhir AND k.idtingkat=t.replid AND a.departemen='$departemen' AND s.nis = a.nis ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris"; 
	}
	$result_tot = QueryDb($sql_tot);
	$total=ceil(mysqli_num_rows($result_tot)/(int)$varbaris);
	$jumlah = mysqli_num_rows($result_tot);
	$akhir = ceil($jumlah/5)*5;
	
	$result_siswa = QueryDb($sql_siswa);
	if (mysqli_num_rows($result_siswa) > 0) {
	
?>
	<input type="hidden" name="total" id="total" value="<?=$total?>"/>
    <table border="0" width="100%">
	<tr>
    	<td align="right">
		<a href="#" onclick="refresh()"><img src="../images/ico/refresh.png" border="0" onMouseOver="showhint('Refresh!', this, event, '50px')"/>&nbsp;Refresh</a>&nbsp;&nbsp;
        <a href="#" onclick="excel('<?=$urut?>','<?=$urutan?>')" ><img src="../images/ico/excel.png" border="0" onMouseOver="showhint('Cetak dalam format Excel!', this, event, '80px')" />&nbsp;Cetak Excel</a>&nbsp;&nbsp;
        <a href="#" onclick="cetak('<?=$urut?>','<?=$urutan?>')" ><img src="../images/ico/print.png" border="0" onMouseOver="showhint('Cetak!', this, event, '50px')"/>&nbsp;Cetak</a>
        </td>
    </tr>
    </table>
    <br />
    <table class="tab" id="table" border="1" style="border-collapse:collapse" width="100%" align="left" bordercolor="#000000">
    <!-- TABLE CONTENT -->
 	<tr height="30" class="header" align="center">
    	<td width="4%">No</td>
    	<td width="15%" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urutan('nis','<?=$urutan?>')" >NIS <?=change_urut('nis',$urut,$urutan)?></td>
    	<td width="*" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urutan('nama','<?=$urutan?>')" >Nama <?=change_urut('nama',$urut,$urutan)?></td>
        <td width="15%" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urutan('tingkat, kelas','<?=$urutan?>')" >Kelas Terakhir <?=change_urut('tingkat, kelas',$urut,$urutan)?></td>
        <td width="15%" onMouseOver="background='../style/formbg2agreen.gif';height=30;" onMouseOut="background='../style/formbg2.gif';height=30;" background="../style/formbg2.gif" style="cursor:pointer;" onClick="change_urutan('tgllulus','<?=$urutan?>')">Tahun Lulus <?=change_urut('tgllulus',$urut,$urutan)?></td>
    	<td width="8%">Detail</td>
  	</tr>
	<?
		if ($page==0)
			$cnt_siswa = 1;
		else 
			$cnt_siswa = (int)$page*(int)$varbaris+1;
		while ($row_siswa = @mysqli_fetch_array($result_siswa)) {		
	?>
  	<tr height="25"> 
  		<td align="center"><?=$cnt_siswa?></td>
    	<td align="center"><?=$row_siswa['nis']?></td>
    	<td><?=$row_siswa['nama']?></td>
    	<td align="center"><?=$row_siswa['tingkat']?> - <?=$row_siswa['kelas']?></td>
        <td align="center"><?=LongDateFormat($row_siswa['tgllulus'])?></td>
    	<td align="center">
        <!--<a href="#" onclick="newWindow('siswa_cari_detail.php?nis=<?=$nis?>&departemen=<?=$departemen?>','TampilSiswa',790,650,'resizable=1,scrollbars=1,status=0,toolbar=0')" >-->
        <a href="#" onclick="newWindow('../library/detail_siswa.php?replid=<?=$row_siswa['replid']?>','TampilSiswa',790,650,'resizable=1,scrollbars=1,status=0,toolbar=0')" >
        <img src="../images/ico/lihat.png" border="0" onmouseover="showhint('Lihat detail!', this, event, '50px')" /></a></td>
  	</tr>
  	<?		$cnt_siswa++;
		}
		CloseDb();
	?>
	<!-- END TABLE CONTENT -->
	</table> 
	
    <script language='JavaScript'>
	    Tables('table', 1, 0);
    </script>

<?	if ($page==0){ 
		$disback="style='visibility:hidden;'";
		$disnext="style='visibility:visible;'";
		}
		if ($page<$total && $page>0){
		$disback="style='visibility:visible;'";
		$disnext="style='visibility:visible;'";
		}
		if ($page==$total-1 && $page>0){
		$disback="style='visibility:visible;'";
		$disnext="style='visibility:hidden;'";
		}
		if ($page==$total-1 && $page==0){
		$disback="style='visibility:hidden;'";
		$disnext="style='visibility:hidden;'";
		}
	?>
    </td>
</tr>
<tr>
	<td>
    <table border="0"width="100%" align="center">	
    <tr>
       	<td width="30%" align="left">Halaman
        <select name="hal" id="hal" onChange="change_hal()">
        <?	for ($m=0; $m<$total; $m++) {?>
             <option value="<?=$m ?>" <?=IntIsSelected($hal,$m) ?>><?=$m+1 ?></option>
        <? } ?>
     	</select>
	  	dari <?=$total?> halaman
		
		<? 
     // Navigasi halaman berikutnya dan sebelumnya
        ?>
        </td>
    	<!--td align="center">
    <input <?=$disback?> type="button" class="but" name="back" value=" << " onClick="change_page('<?=(int)$page-1?>')" onMouseOver="showhint('Sebelumnya', this, event, '75px')">
		<?
		/*for($a=0;$a<$total;$a++){
			if ($page==$a){
				echo "<font face='verdana' color='red'><strong>".($a+1)."</strong></font> "; 
			} else { 
				echo "<a href='#' onClick=\"change_page('".$a."')\">".($a+1)."</a> "; 
			}
				 
	    }*/
		?>
	     <input <?=$disnext?> type="button" class="but" name="next" value=" >> " onClick="change_page('<?=(int)$page+1?>')" onMouseOver="showhint('Berikutnya', this, event, '75px')">
 		</td-->
        <td width="30%" align="right">Jumlah baris per halaman
      	<select name="varbaris" id="varbaris" onChange="change_baris()">
        <? 	for ($m=5; $m <= $akhir; $m=$m+5) { ?>
        	<option value="<?=$m ?>" <?=IntIsSelected($varbaris,$m) ?>><?=$m ?></option>
        <? 	} ?>
       
      	</select></td>
    </tr>
    </table>
   
<?	} else { ?>

<table width="100%" border="0" align="center" height="300">          
<tr>
	<td align="center" valign="middle">
    	<font size = "2" color ="red"><b>Tidak ditemukan adanya data.
        <br />Silahkan ulangi pencarian kembali.
       	</b></font>
	</td>
</tr>
</table>  
<? } ?> 
</td>
</tr>
<!-- END TABLE CENTER -->    
</table>    
</body> 
</html>