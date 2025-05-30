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
require_once('../include/getheader.php');
$departemen = $_REQUEST['departemen'];
$proses = $_REQUEST['proses'];
$urut=$_REQUEST['urut'];
$urutan = $_REQUEST['urutan'];
$varbaris = $_REQUEST['varbaris'];	
$page = $_REQUEST['page'];
$total = $_REQUEST['total'];

OpenDb();
$sql = "SELECT proses FROM prosespenerimaansiswa WHERE replid = '$proses'";
$result=QueryDb($sql);
$row = @mysqli_fetch_array($result);
CloseDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Cetak Kelompok Calon Siswa]</title>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr><td align="left" valign="top">

<?=getHeader($departemen)?>

<center>
  <font size="4"><strong>DATA CALON SISWA</strong></font><br />
 </center><br /><br />
<table>
<tr>
	<td><strong>Departemen</strong> </td> 
	<td><strong>:&nbsp;<?=$departemen?></strong></td>
</tr>
<tr>
	<td><strong>Penerimaan</strong></td>
	<td><strong>:&nbsp;<?=$row['proses']?></strong></td>
</tr>

</table>
    <br />

	<table class="tab" id="table" border="1" cellpadding="2" style="border-collapse:collapse" cellspacing="0" width="100%" align="left" bordercolor="#000000">
   <tr height="30">
    	<td width="4%" class="header" align="center">No</td>
        <td width="25%" class="header" align="center">Kelompok</td>
        <td width="12%" class="header" align="center">Kapasitas</td>
        <td width="8%" class="header" align="center">Terisi</td>
        <td width="*" class="header" align="center">Keterangan</td>
    </tr>
<? 	
	OpenDb();
    $sql = "SELECT replid,kelompok,kapasitas,keterangan FROM kelompokcalonsiswa WHERE idproses='$proses' ORDER BY $urut $urutan ";//LIMIT ".(int)$page*(int)$varbaris.",$varbaris";  
	$result = QueryDB($sql);
	//if ($page==0)
		$cnt = 0;
	//else
		//$cnt = (int)$page*(int)$varbaris;
	while ($row = @mysqli_fetch_array($result)) { ?>
    <tr height="25">    	
    	<td align="center"><?=++$cnt ?></td>
        <td><?=$row['kelompok'] ?></td>        
        <td align="center"><?=$row['kapasitas'] ?></td>
        <td align="center">
		<?	OpenDb();
			$sql1 = "SELECT COUNT(*) FROM calonsiswa WHERE idkelompok='$row[replid]' AND aktif = 1";    
			$result1 = QueryDb($sql1);
			$row1 = @mysqli_fetch_row($result1);
			echo $row1[0];
		?>        </td>        
        <td><?=$row['keterangan']?></td>
   	</tr>
<?	}
	CloseDb(); ?>
    <!-- END TABLE CONTENT -->
    </table>
</table>	
</body>
<script language="javascript">
window.print();
</script>
</html>