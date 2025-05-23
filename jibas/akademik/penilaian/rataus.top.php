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
<title>Laporan Penilaian Pelajaran</title>
<script language="javascript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript">

function carisiswa() {
	parent.footer.location.href = "rataus.blank.php";
	//parent.isi.location.href = "blank_lap_pelajaran.php";
	newWindow('../library/siswa.php?flag=0', 'CariSiswa','600','500','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function acceptSiswa(nis, nama, flag) {
	document.getElementById('nis').value = nis;
//	document.getElementById('nis1').value = nis;
	document.getElementById('nama').value = nama;
	parent.footer.location.href = "../penilaian/rataus.footer.main.php?nis="+nis;
	//parent.isi.location.href = "../penilaian/blank_lap_pelajaran.php";	
}

function validate() {
	return validateEmptyText('nip', 'NIP Guru');
}
</script>
<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
</head>
	
<body leftmargin="0">

<form name="main" enctype="multipart/form-data" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%">
        <table border="0" >
        <tr>
            <td><strong>Nama</strong></td>
            <td><strong>
              <input type="text" name="nis" id="nis" size="15"  readonly class="disabled" value="<?=$nis ?>" onclick="carisiswa()" />
            </strong></td>
            <td><strong>
              <input type="text" name="nama" id="nama" size="25"  readonly value="<?=$nama ?>" class="disabled"  onclick="carisiswa()"/>
            </strong></td>
            <td><a href="JavaScript:carisiswa()" onmouseover="showhint('Cari Siswa!', this, event, '50px')"><img src="../images/ico/lihat.png" border="0"/></a></td>
        </tr>
        </table>  
    </td>
    <td width="30%">
        <div align="right">
        <font style="background-color: rgb(255, 204, 102);" face="Verdana, Arial, Helvetica, sans-serif" size="4">&nbsp;</font>&nbsp;<font color="Gray" face="Verdana, Arial, Helvetica, sans-serif" size="4">Rata-rata Nilai Setiap Siswa</font><br>
        <a href="../penilaian.php" target="content"> <font color="#000000" size="1"><b>Penilaian</b></font></a>&nbsp;&gt;&nbsp;<font color="#000000" size="1"><b>Rata-rata Nilai Setiap Siswa</b></font>
        </div>
    </td>
  </tr>
</table>
</form>
</body>
</html>