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
require_once('../inc/common.php');
require_once('../inc/config.php');
require_once('../inc/rupiah.php');
require_once('../inc/db_functions.php');
require_once('../lib/GetHeaderCetak.php');
$perpustakaan	= $_REQUEST['perpustakaan'];
$from			= $_REQUEST['from'];
$to				= $_REQUEST['to'];
$limit			= $_REQUEST['limit'];
OpenDb();
if ($perpustakaan!='-1') {
	$sql 	= "SELECT nama FROM perpustakaan WHERE replid='$perpustakaan'";
	$result = QueryDb($sql);
	$row 	= @mysqli_fetch_row($result);
	$nama	= $row[0];
} else {
	$nama = "<i>Semua</i>";
}
$from	= explode('-',$from);
$to		= explode('-',$to);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../sty/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Statistik Peminjam</title>
</head>

<body>
<table border="0" cellpadding="10" cellspacing="5" width="780" align="left">
<tr><td align="left" valign="top">

<? GetHeader($perpustakaan) ?>

<center>
  <strong><font size="4">STATISTIK PEMINJAM YANG PALING SERING MEMINJAM</font></strong>
  <br /> 
</center><br /><br />

<br />
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td width="14%"><strong>Perpustakaan</strong></td>
            <td width="86%">&nbsp;<?=$nama?></td>
          </tr>
          <tr>
            <td><strong>Periode</strong></td>
            <td>&nbsp;<?=NamaBulan($from[1])?> <?=$from[0]?> s.d. <?=NamaBulan($to[1])?> <?=$to[0]?></td>
          </tr>
          <tr>
            <td><strong>Jumlah&nbsp;data yang&nbsp;ditampilkan</strong></td>
            <td valign="top">&nbsp;<?=$limit?></td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">
    	<?
		$filter="";
		if ($perpustakaan!='-1')
			$filter=" AND d.perpustakaan=".$perpustakaan;
		$sql = "SELECT count(*) as num, p.idanggota FROM pinjam p, daftarpustaka d WHERE p.tglpinjam BETWEEN '$_REQUEST[from]' AND '$_REQUEST[to]' AND d.kodepustaka=p.kodepustaka $filter GROUP BY p.idanggota ORDER BY num DESC LIMIT $limit";			
		$result = QueryDb($sql);
		//echo $sql;
		?>
        <img src="<?="statimage.php?type=bar&key=$_REQUEST[from],$_REQUEST[to]&Limit=$limit&krit=1&perpustakaan=$perpustakaan" ?>" />
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">
    	<img src="<?="statimage.php?type=pie&key=$_REQUEST[from],$_REQUEST[to]&Limit=$limit&krit=1&perpustakaan=$perpustakaan" ?>" />
    </td>
  </tr>
  <tr>
    <td>
    	<table width="90%" border="1" cellspacing="0" cellpadding="0" class="tab">
          <tr>
            <td height="25" align="center" class="header">No</td>
            <td height="25" align="center" class="header">Anggota</td>
            <td height="25" align="center" class="header">Jumlah</td>
          </tr>
          <? if (@mysqli_num_rows($result)>0) { ?>
          <? $cnt=1; ?>
          <? while ($row = @mysqli_fetch_row($result)) { ?>
          <? 
            $idanggota = $row[1];
            $NamaAnggota = GetMemberName($idanggota);
          ?>
          <tr>
            <td height="20" align="center"><?=$cnt?></td>
            <td height="20">&nbsp;<?=$idanggota?> - <?=$NamaAnggota?></td>
            <td height="20" align="center"><?=$row[0]?></td>
          </tr>
          <? $cnt++; ?>
          <? } ?>
          <? } else { ?>
          <tr>
            <td height="20" align="center" colspan="3" class="nodata">Tidak ada data</td>
          </tr>	
          <? } ?>
      </table>
    </td>
  </tr>
</table>
</td></tr></table>
</body>
<script language="javascript">
window.print();
</script>
</html>
<?
function GetMemberName($idanggota){
	$sql1 = "SELECT nama FROM ".get_db_name('akad').".siswa WHERE nis='$idanggota'";
	$result1 = QueryDb($sql1);
	if (@mysqli_num_rows($result1)>0){
		$row1 = @mysqli_fetch_array($result1);
		return $row1['nama'];
	} else {
		$sql2 = "SELECT nama FROM ".get_db_name('sdm').".pegawai WHERE nip='$idanggota'";
		$result2 = QueryDb($sql2);
		if (@mysqli_num_rows($result2)>0){
			$row2 = @mysqli_fetch_array($result2);
			return $row2['nama'];
		} else {
			$sql3 = "SELECT nama FROM anggota WHERE noregistrasi='$idanggota'";
			$result3 = QueryDb($sql3);
			if (@mysqli_num_rows($result3)>0){
				$row3 = @mysqli_fetch_array($result3);
				return $row3['nama'];
			} else {
				return "Tanpa Nama";
			}
		}
	}
}
?>