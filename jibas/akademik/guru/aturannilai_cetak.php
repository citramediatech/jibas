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
require_once('../library/dpupdate.php');

$id = $_REQUEST['id'];
$nip = $_REQUEST['nip'];

OpenDb();
$sql = "SELECT j.departemen, j.nama, p.nip, p.nama 
		FROM guru g, jbssdm.pegawai p, pelajaran j 
		WHERE g.nip=p.nip AND g.idpelajaran = j.replid AND j.replid = '$_REQUEST[id]' AND g.nip = '$_REQUEST[nip]'"; 

$result = QueryDb($sql);
$row = @mysqli_fetch_row($result);
$departemen = $row[0];
$pelajaran = $row[1];
$guru = $row[2].' - '.$row[3];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Cetak Aturan Penentuan Grading Nilai]</title>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<!-- TABLE CENTER -->

<tr>
    <td align="left" valign="top">
    <?=getHeader($departemen)?>

<center>
  <font size="4"><strong>ATURAN PENENTUAN GRADING NILAI</strong></font><br />
 </center><br /><br />
<br />
    <table>
    <tr>
		<td><strong>Departemen</strong>	</td>
    	<td><strong>: <?=$departemen ?></strong></td>
    </tr>
    <tr>
        <td><strong>Pelajaran</strong></td>
    	<td><strong>: <?=$pelajaran ?></strong></td>
   	</tr>
    <tr>
        <td><strong>Guru</strong></td>  	
        <td><strong>: <?=$guru ?></strong></td>       
	</tr>
    </table>
<?	$sql = "SELECT tingkat,replid FROM tingkat WHERE departemen = '$departemen' ORDER BY urutan";
	$result = QueryDb($sql);
	while ($row = @mysqli_fetch_array($result)) 
	{
		$sql1 = "SELECT g.dasarpenilaian, g.grade, g.nmin, g.nmax, dp.keterangan 
				   FROM aturangrading g, tingkat t, dasarpenilaian dp
				  WHERE t.replid = g.idtingkat AND t.departemen = '$departemen' 
					AND dp.dasarpenilaian = g.dasarpenilaian AND dp.aktif = 1 
					AND g.idpelajaran = '$id' AND g.idtingkat = '$row[replid]' AND g.nipguru = '$nip' GROUP BY g.dasarpenilaian";
		$result1 = QueryDb($sql1);
		if (@mysqli_num_rows($result1)>0)
		{ ?>
    <br />
    <b>Tingkat <?=$row['tingkat']?> </b><br /><br />
	<table border="1" width="100%" id="table" class="tab" bordercolor="#000000">
    <tr>		
			<td height="30" align="center" class="header">No</td>
		  <td height="30" align="center" class="header">Aspek Penilaian</td>
		  <td height="30" align="center" class="header">Grading</td>            
		</tr>
<? 		$cnt= 0;
		while ($row1 = @mysqli_fetch_row($result1)) 
		{ ?>	
		<tr>        			
		  <td height="25" align="center"><?=++$cnt?></td>
		  <td height="25"><?=$row1[4]?></td>
		  <td height="25">
<? 			$sql2 = "SELECT g.dasarpenilaian, g.grade, g.nmin, g.nmax 
					   FROM aturangrading g, tingkat t 
					  WHERE t.replid = g.idtingkat AND t.departemen = '$departemen' AND g.idpelajaran = '$id'
					    AND g.idtingkat = '$row[replid]' AND g.dasarpenilaian = '$row1[0]' AND g.nipguru = '$nip' ORDER BY grade";
			$result2 = QueryDb($sql2);			
			while ($row2 = @mysqli_fetch_row($result2)) {
				echo $row2[1].' : '.$row2[2].' s/d '.$row2[3]. '<br>'; 
			} ?>			</td>
            
		</tr>
	<? 	}		?>			
		</table>
	  
<?  	}
	} ?>
    <!-- END TABLE CONTENT -->
    </table>

	</td></tr>
<!-- END TABLE CENTER -->    
</table>
<?
CloseDb();
?>
</body>
<script language="javascript">
window.print();
</script>
</html>