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

$nis = "";
if (isset($_REQUEST['nis']))
	$nis = $_REQUEST['nis'];
    
OpenDb();

$res_nm_sis=QueryDb("SELECT nama FROM jbsakad.siswa WHERE nis='$nis'");
$row_nm_sis=@mysqli_fetch_array($res_nm_sis);
$tglawal = "";
if (isset($_REQUEST['tglawal'])){
	$tglawl = explode('-',$_REQUEST['tglawal']);
	$tglawal = $tglawl[2]."-".$tglawl[1]."-".$tglawl[0];
	
}
$tglakhir = "";
if (isset($_REQUEST['tglakhir'])){
	$tglakhr =  explode('-',$_REQUEST['tglakhir']);
	$tglakhir = $tglakhr[2]."-".$tglakhr[1]."-".$tglakhr[0];
	
}
$sql="SELECT ph.tanggal1,ph.tanggal2,phsiswa.keterangan FROM jbsakad.presensiharian ph, jbsakad.phsiswa phsiswa WHERE phsiswa.nis='$nis' AND phsiswa.idpresensi=ph.replid AND ph.tanggal1>='$tglawal' AND ph.tanggal2<='$tglakhir' AND phsiswa.keterangan<>''";
$result=QueryDb($sql);
?>
<style type="text/css">
<!--
.style1 {
	color: #666666;
	font-weight: bold;
}
-->
</style>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td><fieldset><legend class="style1">Presensi Harian</legend>
<table width="100%" border="0" cellspacing="0">
          <tr>
            <td width="11%"><strong>Siswa</strong></td>
            <td width="1%"><strong>:</strong></td>
            <td width="88%">[<?=$nis?>]&nbsp;<?=$row_nm_sis['nama']?></td>
          </tr>
          <tr>
            <td><strong>Periode</strong></td>
            <td><strong>:</strong></td>
            <td><?=$_REQUEST['tglawal']?> s.d. <?=$_REQUEST['tglakhir']?></td>
          </tr>
        </table>	
    </fieldset></td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="1" cellspacing="0" class="tab">
  <tr class="header" height="30">
    <td width="3%" align="center">No.</td>
    <td width="42%" >Periode</td>
    <td width="55%" >Keterangan</td>
  </tr>
  <?
  if (@mysqli_num_rows($result)>0){
  $cnt=1;
  while ($row=@mysqli_fetch_array($result)){
  	$a="";
	if ($cnt%2==0)
		$a="style='background-color:#FFFFCC'";
  ?>
  <tr height="25" <?=$a?>>
    <td align="center"><?=$cnt?></td>
    <td><?=ShortDateFormat($row['tanggal1'])?> s.d. <?=ShortDateFormat($row['tanggal2'])?></td>
    <td><?=$row['keterangan']?></td>
  </tr>
  <?
  $cnt++;
  }
  } else {
  ?>
   <tr height="25">
    <td align="center" colspan="3">Tidak ada keterangan presensi untuk periode tsb.</td>
  </tr>
  <? } ?>
</table>

    </td>
  </tr>
</table>
<? CloseDb() ?>