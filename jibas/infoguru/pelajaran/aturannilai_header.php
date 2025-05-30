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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aturan Penentuan Grading Nilai</title>
<script language="javascript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript">
function caripegawai() {
	parent.aturan_nilai_footer.location.href = "../blank2.php";
	parent.aturan_nilai_content.location.href = "blank_nilai.php";
	newWindow('../library/guru.php?flag=0', 'CariPegawai','600','590','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function acceptPegawai(nip, nama, flag) {
	document.getElementById('nip').value = nip;		
	document.getElementById('nama').value = nama;	
	parent.aturan_nilai_footer.location.href = "../guru/aturannilai_menu.php?nip="+nip+"&nama="+nama;
	parent.aturan_nilai_content.location.href = "../guru/blank_nilai.php";
}

function validate() {
	return validateEmptyText('nip', 'NIP Guru');
}
</script>
</head>
	
<body leftmargin="0" style="background-color:#EEEEEE">

<form name="main" enctype="multipart/form-data" >
<strong>Pilih Guru </strong>
<table width="100%" border="0" align="center">
  <tr>
  	<td><strong>NIP</strong></td>
    <td><input type="text" name="nip" id="nip" size="10" class="disabled" readonly value="<?=$nip ?>"  onClick="caripegawai()"/>&nbsp;&nbsp;
    <a href="JavaScript:caripegawai()" onmouseover="showhint('Cari Guru!', this, event, '80px')"><img src="../images/ico/lihat.png" border="0"/></a>
    </td>
</tr>
<tr>
    <td><strong>Nama</strong></td>
    <td><input type="text" name="nama" id="nama" size="25" class="disabled" readonly value="<?=$nama ?>"  onClick="caripegawai()"/>
    </td>
</tr>
 
  <!--<tr>
    <td colspan="2" align="center"><a href="JavaScript:caripegawai()" onmouseover="showhint('Cari Guru!', this, event, '50px')"><img src="../images/ico/lihat.png" border="0"/></a></div></td>
    </tr>-->
</table>

</form>

</body>
</html>