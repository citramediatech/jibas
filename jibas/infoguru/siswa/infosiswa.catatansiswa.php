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
require_once('../include/sessionchecker.php');
require_once('../include/config.php');
require_once('../include/getheader.php');
require_once('../include/db_functions.php');
require_once('../include/common.php');

$nis = $_SESSION["infosiswa.nis"];

OpenDb();

$sql_year = "SELECT DISTINCT YEAR(tanggal) as tahun
               FROM jbsvcr.catatansiswa
              WHERE nis='$nis'";
$res_year = QueryDb($sql_year);

$tahun = "";
$bulan_pjg = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
?>
<table width="100%" border="0" cellspacing="5">
<tr>
    <td width="150" height="30" valign="top">
    <div id="thn_catatan">Tahun
    <select name="tahun" id="tahun" onChange="ChangeTahunCatatanSiswa('<?=$nis?>')">
<?	if (@mysqli_num_rows($res_year) > 0)
    {
        while ($row_year=@mysqli_fetch_array($res_year))
        {
            if ($tahun == "")
                $tahun=$row_year['tahun']; ?>
            <option value="<?=$row_year['tahun']?>"><?=$row_year['tahun']?></option>
<?  	}
	}
    else
    {	?>
        <option value="">Tidak ada data</option>
<?	}	?>
    </select>
    </div>
    <br />
	<div id="tabel_ck">
    <table width="100%" border="1" cellspacing="0" class="tab">
    <tr class="header" height="30">
        <td width="50"><div align="center">Bulan</div></td>
        <td width="35%"><div align="center">#</div></td>
    </tr>
<?  $sql = "SELECT MONTH(tanggal) AS bulan
              FROM jbsvcr.catatansiswa
             WHERE YEAR(tanggal)='$tahun' AND nis='$nis'
             GROUP BY MONTH(tanggal)";
    $result=QueryDb($sql);
    if (@mysqli_num_rows($result)>0)
    {
       	while ($row=@mysqli_fetch_array($result))
        {
		  	$sql_cnt = "SELECT COUNT(*)
                          FROM jbsvcr.catatansiswa
                         WHERE nis='$nis' AND MONTH(tanggal)='$row[bulan]' AND YEAR(tanggal)='$tahun'";
		  	$res_cnt = QueryDb($sql_cnt);
			$row_cnt = @mysqli_fetch_row($res_cnt); ?>
            <tr onClick="ShowCatatanSiswa('<?=$nis?>', '<?=$row['bulan']?>', '<?=$tahun?>')" style="cursor:pointer;" title="Klik untuk menampilkan daftar Catatan Siswa">
                <td width="50"><?=$bulan_pjg[$row['bulan']]?></td>
                <td><div align="center"><?=$row_cnt[0]?></div></td>
            </tr>
<?   	}
	}
    else
    {  ?>
            <tr>
                <td colspan="2" align="center">Tidak ada Data</td>
            </tr>
<?  } ?>
    </table>
    </div>
    </td>
    <td rowspan="2"><div id="contentcatatan">&nbsp;</div></td>
</tr>
<tr>
    <td valign="top"></td>
</tr>
</table>
<?
CloseDb();
?>