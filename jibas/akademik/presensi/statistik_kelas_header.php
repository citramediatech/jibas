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

$th1 = date("Y");
if (isset($_REQUEST['th1']))
	$th1 = $_REQUEST['th1'];
$bln1 = date("n");
if (isset($_REQUEST['bln1']))
	$bln1 = $_REQUEST['bln1'];
$th2 = date("Y");
if (isset($_REQUEST['th2']))
	$th2 = $_REQUEST['th2'];

$bln2 = date("n");
if (isset($_REQUEST['bln2']))
	$bln2 = $_REQUEST['bln2'];
$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];
$tingkat = "";
if (isset($_REQUEST['tingkat']))
	$tingkat = $_REQUEST['tingkat'];
$semester = "";
if (isset($_REQUEST['semester']))
	$semester = $_REQUEST['semester'];
$tahunajaran = "";
if (isset($_REQUEST['tahunajaran']))
	$tahunajaran = $_REQUEST['tahunajaran'];
$pelajaran = "";
if (isset($_REQUEST['pelajaran']))
	$pelajaran = $_REQUEST['pelajaran'];


OpenDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Statistik Kehadiran Setiap Kelas</title>
<script src="../script/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../script/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="javascript" src="../script/tools.js"></script>
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript">
var win = null;
function newWindow(mypage,myname,w,h,features) {
      var winl = (screen.width-w)/2;
      var wint = (screen.height-h)/2;
      if (winl < 0) winl = 0;
      if (wint < 0) wint = 0;
      var settings = 'height=' + h + ',';
      settings += 'width=' + w + ',';
      settings += 'top=' + wint + ',';
      settings += 'left=' + winl + ',';
      settings += features;
      win = window.open(mypage,myname,settings);
      win.window.focus();
}

function tampil() {
	var th2 = parseInt(document.getElementById('th2').value);
	var bln2 = parseInt(document.getElementById('bln2').value);
	var th1 = parseInt(document.getElementById('th1').value);
	var bln1 = parseInt(document.getElementById('bln1').value);
	var semester = document.getElementById('semester').value;
	var tingkat = document.getElementById('tingkat').value;
	var pelajaran = document.getElementById('pelajaran').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
		
	if (tahunajaran.length == 0) {
		alert ('Pastikan tahunajaran sudah ada!');
		return false;
	} else if (semester.length == 0) {
		alert ('Pastikan semester sudah ada!');
		return false;
	} else if (tingkat.length == 0) {
		alert ('Pastikan tingkat sudah ada!');
		return false;
	}
	
	if (th2 < th1) {
		alert ('Pastikan batas tahun akhir tidak kurang dari batas tahun awal');
		return false;
	} 
	
	if (th2 == th1 && bln2 < bln1 ) {
		alert ('Pastikan batas bulan akhir tidak kurang dari batas bulan awal');
		return false; 
	}	
	
	parent.footer.location.href = "statistik_kelas_footer.php?bln1="+bln1+"&th1="+th1+"&bln2="+bln2+"&th2="+th2+"&semester="+semester+"&tingkat="+tingkat+"&pelajaran="+pelajaran;
}

function change() {
	var th2 = parseInt(document.getElementById('th2').value);
	var bln2 = parseInt(document.getElementById('bln2').value);
	var th1 = parseInt(document.getElementById('th1').value);
	var bln1 = parseInt(document.getElementById('bln1').value);
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var semester = document.getElementById('semester').value;
	var tingkat = document.getElementById('tingkat').value;
	var pelajaran = document.getElementById('pelajaran').value;
			
	parent.header.location.href = "statistik_kelas_header.php?bln1="+bln1+"&th1="+th1+"&bln2="+bln2+"&th2="+th2+"&departemen="+departemen+"&tahunajaran="+tahunajaran+"&semester="+semester+"&tingkat="+tingkat+"&pelajaran="+pelajaran;	
	parent.footer.location.href = "blank_statistik_kehadiran_siswa.php";	
}

function panggil() {
	parent.footer.location.href = "blank_statistik_kehadiran_siswa.php";	
}

function change_dep() {
	var th2 = parseInt(document.getElementById('th2').value);
	var bln2 = parseInt(document.getElementById('bln2').value);
	var th1 = parseInt(document.getElementById('th1').value);
	var bln1 = parseInt(document.getElementById('bln1').value);
	var departemen = document.getElementById('departemen').value;
	var semester = document.getElementById('semester').value;
	var pelajaran = document.getElementById('pelajaran').value;
						
	parent.header.location.href = "statistik_kelas_header.php?bln1="+bln1+"&th1="+th1+"&bln2="+bln2+"&th2="+th2+"&departemen="+departemen+"&semester="+semester+"&pelajaran="+pelajaran;	
	parent.footer.location.href = "blank_statistik_kehadiran_siswa.php";	
}

function change_ajaran() {
	var th2 = parseInt(document.getElementById('th2').value);
	var bln2 = parseInt(document.getElementById('bln2').value);
	var th1 = parseInt(document.getElementById('th1').value);
	var bln1 = parseInt(document.getElementById('bln1').value);
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var semester = document.getElementById('semester').value;
	var pelajaran = document.getElementById('pelajaran').value;
	
	parent.header.location.href = "statistik_kelas_header.php?bln1="+bln1+"&th1="+th1+"&bln2="+bln2+"&th2="+th2+"&departemen="+departemen+"&semester="+semester+"&tahunajaran="+tahunajaran+"&pelajaran="+pelajaran;	
	parent.footer.location.href = "blank_statistik_kehadiran_siswa.php";	
}

function change_tingkat() {
	var th2 = parseInt(document.getElementById('th2').value);
	var bln2 = parseInt(document.getElementById('bln2').value);
	var th1 = parseInt(document.getElementById('th1').value);
	var bln1 = parseInt(document.getElementById('bln1').value);
	var departemen = document.getElementById("departemen").value;
	var tahunajaran = document.getElementById("tahunajaran").value;
	var semester = document.getElementById("semester").value;
	var tingkat = document.getElementById("tingkat").value;
	var pelajaran = document.getElementById("pelajaran").value;
		
	parent.header.location.href = "statistik_siswa_header.php?bln1="+bln1+"&th1="+th1+"&bln2="+bln2+"&th2="+th2+"&departemen="+departemen+"&semester="+semester+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&pelajaran="+pelajaran;	
	parent.footer.location.href = "blank_statistik_kehadiran_siswa.php";	
}

function change_tgl1() {
	var th1 = parseInt(document.getElementById('th2').value);
	var bln1 = parseInt(document.getElementById('bln2').value);
	
	var th = parseInt(document.getElementById('th1').value);
	var bln = parseInt(document.getElementById('bln1').value);
	
	
	if (th > th1) {
		alert ('Pastikan batas tahun akhir tidak kurang dari batas tahun awal');
		return false;
	} 
	
	if (th == th1 && bln > bln1 ) {
		alert ('Pastikan batas bulan akhir tidak kurang dari batas bulan awal');
		return false; 
	}	
}

function change_tgl2() {
	var th1 = parseInt(document.getElementById('th1').value);
	var bln1 = parseInt(document.getElementById('bln1').value);
	
	var th = parseInt(document.getElementById('th2').value);
	var bln = parseInt(document.getElementById('bln2').value);
		
	if (th1 > th) {
		alert ('Pastikan batas tahun akhir tidak kurang dari batas tahun awal');
		return false;
	} 
	
	if (th1 == th && bln1 > bln ) {
		alert ('Pastikan batas bulan akhir tidak kurang dari batas bulan awal');
		return false; 
	}	
		
}

function focusNext(elemName, evt) {
	evt = (evt) ? evt : event;
	var charCode = (evt.charCode) ? evt.charCode :
		((evt.which) ? evt.which : evt.keyCode);
	if (charCode == 13) {
		document.getElementById(elemName).focus();
		if (elemName == 'tabel')
			tampil();
		return false;
	}
	return true;
}
</script>
</head>
	
<body topmargin="0" leftmargin="0" onload="document.getElementById('departemen').focus()">
<form action="statistik_kelas_header.php" method="post" name="main">
<table border="0" width="100%" align="center">
<!-- TABLE CENTER -->
<tr>
	<td rowspan="3" width="62%">
	<table width = "100%" border = "0">
    <tr>
    	<td width="20%"><strong>Departemen </strong></td>
    	<td> 
    	<select name="departemen" id="departemen" onChange="change_dep()" style="width:160px" onKeyPress="focusNext('tahunajaran',event)">
		<?	$dep = getDepartemen(SI_USER_ACCESS());    
			foreach($dep as $value) {
			if ($departemen == "")
				$departemen = $value; ?>
		<option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> > <?=$value ?> </option>
	<?	} ?>
		</select></td>
        <td width="12%"><strong>Tingkat </strong></td>
    	<td>
		<select name="tingkat" id="tingkat" onchange="change()" style="width:200px" onKeyPress="focusNext('pelajaran',event)">
          <?	OpenDb();
			$sql = "SELECT replid,tingkat FROM tingkat WHERE departemen='$departemen' AND aktif = 1 ORDER BY urutan";	
			$result = QueryDb($sql);
			CloseDb();
	
			while($row = mysqli_fetch_array($result)) {
			if ($tingkat == "")
				$tingkat = $row['replid'];			
			?>
          <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $tingkat) ?>><?=$row['tingkat']?>
            </option>
          <?
			} //while
			?>
        </select></td> 
          
    </tr>
	<tr>
    	<td><strong>Tahun Ajaran </strong></td>
      	<td>
        	<select name="tahunajaran" id="tahunajaran" onchange="change_ajaran()" style="width:160px" onKeyPress="focusNext('semester',event)">
   		 	<?
			OpenDb();
			$sql = "SELECT replid,tahunajaran,aktif FROM tahunajaran WHERE departemen='$departemen' ORDER BY aktif DESC, tahunajaran DESC";
			$result = QueryDb($sql);
			CloseDb();
			while ($row = @mysqli_fetch_array($result)) {
			if ($tahunajaran == "") 				
				$tahunajaran = $row['replid'];			
			$ada = "";
			if ($row['aktif'])
				$ada = "(Aktif)";					
			?>
            
    		<option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $tahunajaran)?> ><?=$row['tahunajaran'].' '.$ada?></option>
                  
    		<?
			}
    		?>
    		</select>		</td> 
      	<td><strong>Pelajaran</strong></td>
      	<td>
        	<select name="pelajaran" id="pelajaran" onchange="change()" style="width:200px" onKeyPress="focusNext('bln1',event)">
   		 	<?
			OpenDb();
			$sql = "SELECT replid,nama FROM pelajaran WHERE departemen = '$departemen' AND aktif=1 ORDER BY nama";
			$result = QueryDb($sql);
			CloseDb();
			while ($row = @mysqli_fetch_array($result)) {
			if ($pelajaran == "") 				
				$pelajaran = $row['replid'];			
			?>
            
    		<option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $pelajaran)?> ><?=$row['nama']?></option>
                  
    		<?
			}
    		?>
    		</select>       	</td>  
        </tr>
    <tr>
    	<td><strong>Semester </strong></td>
      	<td>
        	<select name="semester" id="semester" onchange="change()" style="width:160px" onKeyPress="focusNext('tingkat',event)">
   		 	<?
			OpenDb();
			$sql = "SELECT replid,semester,aktif FROM semester where departemen='$departemen' ORDER BY aktif DESC, replid DESC";
			$result = QueryDb($sql);
			CloseDb();
			while ($row = @mysqli_fetch_array($result)) {
			if ($semester == "") 
				$semester = $row['replid'];
			$ada = "";
			if ($row['aktif'])
				$ada = "(Aktif)";
			?>
            
    		<option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $semester)?> ><?=$row['semester'].' '.$ada?></option>
                 
    		<?
			}
    		?>
    		</select>		</td>
        <td colspan="2">        </td>
       	</tr>
    <tr>   	
       	<td><strong>Bulan </strong></td>
        <td colspan="3">
        <? if ($tahunajaran <> "") { 
			OpenDb();
			$sql = "SELECT t.tahunajaran, YEAR(t.tglmulai) AS tahun1, YEAR(t.tglakhir) AS tahun2 FROM tahunajaran t WHERE t.replid='$tahunajaran'";
			$result = QueryDb($sql);
			CloseDb();
			$row = mysqli_fetch_row($result);
			$tahun1 = $row[1];
			$tahun2 = $row[2]; 
			}
		 ?> 
          	<select name="bln1" id ="bln1" onchange="change_tgl1()" onfocus = "panggil()" onKeyPress="focusNext('th1',event)">
        <? 	for ($i=1;$i<=12;$i++) { ?>
          	<option value="<?=$i?>" <?=IntIsSelected($bln1, $i)?>><?=$bulan[$i]?></option>	
       	<?	}	?>	
        	</select>
       		<select name="th1" id = "th1" onchange="change_tgl1()" onfocus = "panggil()" onKeyPress="focusNext('bln2',event)" style="width:60px">
        <?  for ($i = $tahun1; $i <= $tahun2; $i++) { ?>
		<?  //for($i=$th1-10;$i<=$th1;$i++){ ?>
          	<option value="<?=$i?>" <?=IntIsSelected($th1, $i)?>><?=$i?></option>	   
       	<?	} ?>	
        	</select> 
            s/d 
        	<select name="bln2" id ="bln2" onchange="change_tgl2()" onfocus = "panggil()" onKeyPress="focusNext('th2',event)">
        <? 	for ($i=1;$i<=12;$i++) { ?>
        	<option value="<?=$i?>" <?=IntIsSelected($bln2, $i)?>><?=$bulan[$i]?></option>	
        <?	}	?>	
        	</select>
       	 	<select name="th2" id = "th2" onchange="change_tgl2()" onfocus = "panggil()" onKeyPress="focusNext('tabel',event)" style="width:60px">
       	<?  for ($i = $tahun1; $i <= $tahun2; $i++) { ?>
		<?  //for($i=$th2-10;$i<=$th2;$i++){ ?>
        	<option value="<?=$i?>" <?=IntIsSelected($th2, $i)?>><?=$i?></option>	   
    	<?	} ?>	
        	</select>        </td> 
   	</tr>   
	</table>
    <td rowspan="4" align="left" valign="middle"><a href="#" onclick="tampil()" ><img src="../images/view.png" onmouseover="showhint('Klik untuk menampilkan statistik kehadiran harian setiap siswa!', this, event, '120px')" height="48" width="48" border="0" name="tabel" id="tabel2"/></a></td>
        <td width="*" rowspan="3" align="right" valign="top">
        <font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Statistik Kehadiran Setiap Kelas</font><br />
    	<a href="../presensi.php?page=pp" target="content">
      	<font size="1" color="#000000"><b>Presensi</b></font></a>&nbsp>&nbsp
        <font size="1" color="#000000"><b>Statistik Kehadiran Setiap Kelas</b></font>
        </td>     
    </tr>
	</table>
    </td>
</tr>
</table>
</form>
</body>
</html>
<script language="javascript">
	var spryselect1 = new Spry.Widget.ValidationSelect("departemen");
	var spryselect2 = new Spry.Widget.ValidationSelect("tahunajaran");
	var spryselect3 = new Spry.Widget.ValidationSelect("tingkat");
	var spryselect5 = new Spry.Widget.ValidationSelect("pelajaran");
	var spryselect6 = new Spry.Widget.ValidationSelect("semester");
	var spryselect7 = new Spry.Widget.ValidationSelect("bln1");
	var spryselect8 = new Spry.Widget.ValidationSelect("th1");
	var spryselect9 = new Spry.Widget.ValidationSelect("bln2");
	var spryselect10 = new Spry.Widget.ValidationSelect("th2");
</script>