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
//include('../cek.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');


if(isset($_POST["departemen"])){
	$departemen = $_POST["departemen"];
}elseif(isset($_GET["departemen"])){
	$departemen = $_GET["departemen"];
}

OpenDb();
?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<script language="JavaScript" src="../script/tables.js"></script>
<link rel="stylesheet" type="text/css" href="../script/ajaxtabs.css" />
<script type="text/javascript" src="../script/ajaxtabs.js"></script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0">
<table width="100%" border="0">
  <tr>
    <td width="9%">Departemen</td>
    <td width="73%"><select name="departemen2" id="departemen2" onChange="departemen2()">
            <?	$dep = getDepartemen(SI_USER_ACCESS());    
				foreach($dep as $value) {
					if ($departemen == "")
						$departemen = $value; ?>
            <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> >
            <?=$value ?>
            </option>
            <?	} ?>
          </select></td>
    </tr>
  <tr>
    <td>Kelas</td>
    <td><div id="kelas_Info"><select name="kelas" id="kelas" onChange="kelas()" style="width:150px">
            <?	$sql="SELECT k.replid,k.kelas FROM jbsakad.kelas k,jbsakad.tahunajaran ta,jbsakad.tingkat ti WHERE k.idtahunajaran=ta.replid AND k.idtingkat=ti.replid AND ti.departemen='$departemen' AND ta.departemen='$departemen' AND k.aktif=1 ORDER BY k.kelas";
			$result=QueryDb($sql);
			while ($row=@mysqli_fetch_array($result)){
					if ($kelas == "")
						$kelas = $row[replid]; 
						?>
            <option value="<?=$row[replid] ?>" <?=StringIsSelected($row[replid], $kelas) ?> >
            <?=$row[kelas] ?>
            </option>
            <?	} ?>
          </select></div></td>
    </tr>
  	<tr>
    <td colspan="3">
	<div id="tabel_pilih">&nbsp;
    <table width="100%" id="table" class="tab" align="center" cellpadding="2" cellspacing="0">
<tr height="30" bordercolor="#000000">
	<td class="header" width="7%" align="center" height="30">No</td>
    <td class="header" width="15%" align="center" height="30">N I S</td>
    <td class="header" height="30">Nama</td>
	<td class="header" height="30">Kelas</td>
	<td class="header" height="30">&nbsp;</td>
</tr>
<?

OpenDb();
//$nama = $_REQUEST['nama'];
//$nis = $_REQUEST['nis'];
$sql = "SELECT s.nis, s.nama, k.kelas FROM jbsakad.siswa s,jbsakad.kelas k WHERE k.replid=s.idkelas AND s.statusmutasi=0 AND k.replid='$kelas' AND s.alumni=0 ORDER BY s.nama"; 
$result = QueryDb($sql);
$cnt = 1;


while($row = mysqli_fetch_row($result)) {
if ($cnt%2==0)
	$bg="bgcolor='#e7e7cf'";
if ($cnt%2==1)
	$bg="bgcolor='#ffffff'";	?>
<tr>
	<td align="center" height="25" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer"><?=$cnt ?></td>
    <td align="center" height="25" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer"><?=$row[0] ?></td>
    <td height="25" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer"><?=$row[1] ?></td>
	<td height="25" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer"><?=$row[2] ?></td>
	<td height="25" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer" align="center"><input type="button" value="Pilih" onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')"  class="but"></td>
</tr>
<?
$cnt++;
}
CloseDb();	
if (mysqli_num_rows($result) == 0) { ?>
<tr height="26"><td colspan="4" align="center"><em>Tidak ditemukan data</em></td></tr>
<? } ?>
</table>
	</div>
	</td>
    </tr>
</table>



</body>
</html>