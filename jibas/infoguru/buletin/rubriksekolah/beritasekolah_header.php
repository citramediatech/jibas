<?
/**[N]**
 * JIBAS Education Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 27.0 (May 16, 2022)
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
require_once('../../include/common.php');
require_once('../../include/sessioninfo.php');
require_once('../../include/sessionchecker.php');

$bulan=date("n");
if (isset($_REQUEST['bulan']))
	$bulan=$_REQUEST['bulan'];
	
$tahun=date("Y");
if (isset($_REQUEST['tahun']))
	$tahun=$_REQUEST['tahun'];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../style/style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function lihat(){
	var bulan=document.getElementById('bulan').value;
	var tahun=document.getElementById('tahun').value;
	parent.beritasekolah_footer.location.href="beritasekolah_footer.php?bulan="+bulan+"&tahun="+tahun;
}
function chg(){
	var bulan=parseInt(document.getElementById('bulan').value);
	var tahun=parseInt(document.getElementById('tahun').value);
	self.location.href="beritasekolah_header.php?tahun="+tahun+"&bulan="+bulan+"&send=true";
	parent.beritasekolah_footer.location.href="blank.php";
}
function next(){
	var bulan=parseInt(document.getElementById('bulan').value);
	var tahun=parseInt(document.getElementById('tahun').value);
	if (bulan==12){
		tahun=tahun+1;
    parent.beritasekolah_footer.location.href="blank.php";
	self.location.href="beritasekolah_header.php?bulan=1&tahun="+tahun;
	} else {
		bulan=bulan+1;
	parent.beritasekolah_footer.location.href="blank.php";
	self.location.href="beritasekolah_header.php?tahun="+tahun+"&bulan="+bulan+"&send=true";
	}
}
function prev(){
	var bulan=parseInt(document.getElementById('bulan').value);
	var tahun=parseInt(document.getElementById('tahun').value);
	if (bulan==1){
		tahun=tahun-1;
	parent.beritasekolah_footer.location.href="blank.php";
	self.location.href="beritasekolah_header.php?bulan=12&tahun="+tahun;
	} else {
		bulan=bulan-1;
	parent.beritasekolah_footer.location.href="blank.php";
	self.location.href="beritasekolah_header.php?tahun="+tahun+"&bulan="+bulan+"&send=true";
	}
}
</script></head>
<body onload="lihat();">
<table width="100%" border="0" cellspacing="0">
  <tr>
    <th align="right" scope="row">&nbsp;</th>
    <th align="right" scope="row"><font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font color="Gray" size="4" face="Verdana, Arial, Helvetica, sans-serif">Berita Sekolah</font><br />
      <a href="../../home.php" target="framecenter"> <font size="1" color="#000000"><b>Home</b></font></a>&nbsp>&nbsp<strong><font color="#000000" size="1">Berita Sekolah</font></strong></th>
  </tr>
  <tr>
    <td colspan="2" scope="row"><? if (SI_USER_ID()!="LANDLORD" && SI_USER_ID()!="landlord"){ ?><input type="button" name="beritabaru" id="beritabaru" value="Berita Baru" class="but" title="Tambah Berita Baru" onclick="parent.beritasekolah_footer.location.href='beritasekolah_add.php';"/><? } ?></th>
    
    Berita Bulan : 
      <input type="button" name="prevmonth" id="prevmonth" value=" < " class="but" title="Bulan Sebelumnya" onclick="prev()"/>
      <select name="bulan" id="bulan" onchange="chg()">
    <?
    if ($bulan == "")
        $bulan = date('n');
	for ($i=1;$i<=12;$i++){
	?>
        <option value="<?=(int)$i?>" <?=StringIsSelected($i,$bulan)?>><?=NamaBulan($i)?></option>
    <?
	}
	?>
    </select>
    <select name="tahun" id="tahun" onchange="chg()">
        <?
        if ($tahun == "")
            $tahun = date('Y');
	for ($y=2006;$y<=date('Y') + 1;$y++){
	?>
        <option value="<?=(int)$y?>" <?=StringIsSelected($y,$tahun)?>><?=$y?></option>
        <?
	}
	?>
        </select>
    &nbsp;
    <input type="button" name="nextmonth" id="nextmonth" value=" > " class="but" title="Bulan Selanjutnya" onclick="next()"/>
    </th>
    <input type="button" name="berita" id="berita" value="Lihat Berita" class="but" title="Lihat Berita" onclick="lihat()"/>    </tr>
</table>

</body>
</html>