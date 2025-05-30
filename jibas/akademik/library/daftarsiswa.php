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
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$flag = 0;
if (isset($_REQUEST['flag']))
	$flag = (int)$_REQUEST['flag'];
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];
if (isset($_REQUEST['tingkat']))
	$tingkat = $_REQUEST['tingkat'];
if (isset($_REQUEST['tahunajaran']))
	$tahunajaran = $_REQUEST['tahunajaran'];
if (isset($_REQUEST['kelas']))
	$kelas = $_REQUEST['kelas'];


echo 'kok bisa '.$GLOBALS[tes];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daftar Pegawai</title>
<script language="javascript" src="script/string.js"></script>
<script language="javascript" src="script/tables.js"></script>
<script language="javascript">
function validate() {
	var nama = '' + document.getElementById('nama').value;
	var nis = '' + document.getElementById('nis').value;
	nama = trim(nama);
	nis = trim(nis);
	return (nama.length != 0) || (nis.length != 0);
}

function change() {
	var departemen = document.getElementById("departemen").value;
	var tingkat = document.getElementById("tingkat").value;
	var tahunajaran = document.getElementById("tahunajaran").value;
	var kelas = document.getElementById("kelas").value;
	document.location.href = "daftarsiswa.php?departemen="+departemen+"&tingkat="+tingkat+"&tahunajaran="+tahunajaran+"&kelas="+kelas;
}

function tambah() {
	var j = 0;
	var total = 6;
	for (i=1;i<=6;i++) {
		var pilih = document.getElementById("pilih"+i).checked;
		if (pilih) {			
			var j = j+1;
			var nis = document.getElementById("pilih"+i).value;
			var nama = document.getElementById("nama"+i).value;
			
			//opener.location.href="../presensi/presensi_tambah_siswa.php?total="+j+"&nis"+j+"="+nis;
			opener.location.href="../presensi/presensi_tambah_siswa.php?total="+j;
			alert ('nis'+j+' '+nis+' '+nama);
			opener.acceptSiswa(nis, nama, j);
		}	
		//alert ('lagi coba '+i+' '+pilih);
	}
	
	
	//window.close();
	
	//opener.acceptPegawai(nip, nama, <?=$flag ?>);
	//opener.acceptSiswa(pilih, siswa, <?=$flag ?>);
	
}

</script>
</head>

<body>
<!--<form name="main" method="post" action="../presensi/presensi_tambah_siswa.php" enctype="multipart/form-data" onsubmit="window.close();">-->
<form name="main" method="post" enctype="multipart/form-data">
<table border="0" cellpadding="5" cellspacing="5" width="100%" align="center">
<tr><td align="left">
<!-- BOF CONTENT -->

<table border="0" width="100%" cellpadding="2" cellspacing="2" align="center" >
<tr>
	<td>
    <input type="hidden" name="test" id="test" value="<?='satu' ?>" />
	<input type="hidden" name="flag" id="flag" value="<?=$flag ?>" />
    <input type="hidden" name="tahunajaran" id="tahunajaran" value="<?=$tahunajaran ?>" />
    <input type="hidden" name="kelas" id="kelas" value="<?=$kelas ?>" />
	<font size="2"><strong>Daftar Siswa</strong></font><br />
	Departemen: <strong><input type="text" name="departemen" id="departemen" value="<?=$departemen ?>" size="10" readonly 	style="background-color:#CCCCCC" /></strong>
    <input type="hidden" name="departemen" id="departemen" value="<?=$departemen ?>" />&nbsp;&nbsp;
	Tingkat: 
    <select name="tingkat" id="tingkat" onchange="change()">
 	<?	OpenDb();
		$sql = "SELECT replid,tingkat FROM tingkat WHERE aktif=1 AND departemen='$departemen' ORDER BY urutan";	
		$result = QueryDb($sql);
		CloseDb();
	
		while($row = mysqli_fetch_array($result)) {
		if ($tingkat == "")
			$tingkat = $row['replid'];				
		?>
        <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $tingkat) ?>>
           <?=$row['tingkat']?>
        </option>
        <?
		} //while
		?>
	</select>&nbsp;&nbsp;
</td></tr>

<tr><td>
<br />
<? 
OpenDb();
$sql = "SELECT s.nis, s.nama, k.kelas FROM siswa s, kelas k, tingkat t WHERE t.departemen = '$departemen' AND s.idkelas = k.replid AND k.idtingkat = t.replid AND t.replid = $tingkat AND k.idtahunajaran = $tahunajaran AND s.idkelas <> $kelas"; 

$result = QueryDb($sql);
$jum = mysqli_num_rows($result);
if ($jum > 0) {

?>
<table width="100%" id="table" class="tab" align="center" cellpadding="2" cellspacing="0">
<tr height="30">
	<td class="header" width="7%" align="center">No</td>
    <td class="header" width="15%" align="center">N I S</td>
    <td class="header" align="center">Nama</td>
    <td class="header" width="10%" align="center">Kelas</td>
    <td class="header" width="10%" align="center">&nbsp;</td>
</tr>
<?
	$cnt = 1;	
	while($row = mysqli_fetch_row($result)) { ?>
<tr>
	<td align="center"><?=$cnt ?></td>
    <td align="center"><?=$row[0] ?></td>
    <td><?=$row[1] ?></td>
    <td align="center"><?=$row[2] ?></td>
    <td align="center">
    <!--<input type="checkbox" name="pilih<?=$cnt;?>" value="1" ></td>-->
    <input type="checkbox" name="pilih<?=$cnt?>" id="pilih<?=$cnt?>" value="<?=$row[0]?>"></td>
    <input type="hidden" name="nis<?=$cnt?>" id="nis<?=$cnt?>" value="<?=$row[0] ?>" />
    <input type="hidden" name="nama<?=$cnt?>" id="nama<?=$cnt?>" value="<?=$row[1] ?>" />
    <!--<input type="button" name="pilih" class="but" id="pilih" value="Pilih" onclick="pilih('<?=$row[0]?>', '<?=$row[1]?>')" />-->
</tr>
<? $cnt++; 
	} ?>
</table>
</td></tr>
</table>

<!-- EOF CONTENT -->
<?
} else { 
	echo "<strong><font color='red'>Tidak ditemukan adanya data</strong>";
}
?>
</td></tr>


<tr height="26">
	<td colspan="5" align="center" >
    
    <input type="submit" name="simpan" value="Simpan" class="but" onclick="tambah()"/>
    <input type="button" class="but" name="tutup" id="tutup" value="Tutup" onclick="window.close()" /></td>
</tr>

</table>
</form>
<script language="javascript">
	Tables('table', 1, 0);
	//document.getElementById('nama').focus();
</script>
</body>
</html>