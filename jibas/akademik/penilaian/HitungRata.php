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
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

function HitungRataSiswa($idkelas, $idsemester, $idaturan, $nis, &$success)
{
	
	if (!$success)
		return;
		
	$sql = "SELECT replid, idpelajaran, idjenis 
			  FROM ujian 
			 WHERE idkelas = $idkelas AND idsemester = $idsemester AND idaturan = '$idaturan'";
	$result	= QueryDb($sql);
	$cnt = 0;
	$nilai = 0;
	while ($row	= @mysqli_fetch_row($result))
	{
		$idujian = $row[0];
		$idpelajaran = $row[1];
		$idjenis = $row[2];
		$sql2 = "SELECT nilaiujian 
				   FROM nilaiujian 
				  WHERE idujian='$idujian' AND nis='$nis'";
		$result2 = QueryDb($sql2);
		$row2 = @mysqli_fetch_row($result2);
		$nilai += $row2[0];
		$cnt++;
	}

	if ($cnt > 0)
	    $rataus = round($nilai / $cnt, 2);
	else
	    $rataus = 0;
	
	$sql = "SELECT idpelajaran,idjenisujian FROM aturannhb WHERE replid='$idaturan'";
	$res = QueryDb($sql);
	$row = @mysqli_fetch_row($res);
	$idpelajaran = $row[0];
	$idjenis = $row[1];

	$sql = "SELECT replid FROM rataus 
			WHERE idsemester='$idsemester' AND idkelas='$idkelas' AND idjenis='$idjenis' 
			AND idpelajaran='$idpelajaran'  AND idaturan='$idaturan' AND nis='$nis'";
	$result = QueryDb($sql);
	$num = @mysqli_num_rows($result);
	if ($num == 0)
		$sql2 = "INSERT INTO rataus SET idsemester='$idsemester', idkelas='$idkelas', idjenis='$idjenis', 
				 idpelajaran='$idpelajaran', idaturan='$idaturan', nis='$nis', rataUS='$rataus'";
	else {
		$row = @mysqli_fetch_row($result);
		$idrataus = $row[0];
		//echo $row[0];
		//$sql2 = "UPDATE rataus SET rataUS='$rataus' WHERE idsemester='$idsemester' AND idkelas='$idkelas' 
				// AND idjenis='$idjenis' AND idpelajaran='$idpelajaran'  AND idaturan='$idaturan' AND nis='$nis'";
		$sql2 = "UPDATE rataus SET rataUS='$rataus' WHERE replid='$idrataus'";
	}
	//echo $sql2;exit;
	QueryDbTrans($sql2, $success);
}

function HitungUlangRataSiswa($idkelas, $idsemester, $idaturan, &$success)
{
	if (!$success)
		return;
		
	$sqlsiswa = "SELECT nis FROM jbsakad.siswa WHERE idkelas = '$idkelas' AND aktif = 1";
	$ressiswa = QueryDb($sqlsiswa);
	while($rowsiswa = mysqli_fetch_row($ressiswa))
	{
		if ($success)
		{
			$nis = $rowsiswa[0];
			HitungRataSiswa($idkelas, $idsemester, $idaturan, $nis, $success);
		}
	}
}

function HitungRataKelas($idkelas, $idsemester, $idaturan, &$success)
{
	if (!$success)
		return;
		
	$sql = "SELECT replid, idpelajaran, idjenis 
			  FROM ujian 
			 WHERE idkelas=$idkelas AND idsemester=$idsemester AND idaturan=$idaturan";
	$result	= QueryDb($sql);
	while ($row	= @mysqli_fetch_row($result))
	{
		if ($success)
		{
			$idujian= $row[0];
			$sql2	= "SELECT nilaiujian FROM nilaiujian WHERE idujian='$idujian'";
			$result2= QueryDb($sql2);
			$i		= 0;
			$nilai  = 0;
			while ($row2 = @mysqli_fetch_row($result2))
			{
				$nilai	+= $row2[0];
				$i++;
			}

			if ($i > 0)
			    $ratauk = round($nilai/$i,2);
			else
			    $ratauk = 0;
			
			$sql2 = "SELECT replid FROM ratauk WHERE idsemester='$idsemester' AND idkelas='$idkelas' AND idujian='$idujian'";
			$result2 = QueryDb($sql2);
			$num2 = @mysqli_num_rows($result2);
			if ($num2 == 0)
				$sql3 = "INSERT INTO ratauk SET idsemester='$idsemester', idkelas='$idkelas', idujian='$idujian', nilaiRK='$ratauk'";
			else 
				$sql3 = "UPDATE ratauk SET nilaiRK='$ratauk' WHERE idsemester='$idsemester' AND idkelas='$idkelas' AND idujian='$idujian'";
				
			QueryDbTrans($sql3, $success);
		}
	}
}

function HitungRataKelasUjian($idkelas, $idsemester, $idaturan, $idujian, &$success)
{
	if (!$success)
		return;
		
	$sql2 = "SELECT nilaiujian FROM nilaiujian WHERE idujian='$idujian'";
	$result2 = QueryDb($sql2);
	$i = 0;
	$nilai = 0;
	while ($row2 = @mysqli_fetch_row($result2))
	{
		$nilai += $row2[0];
		$i++;
	}

	if ($i > 0)
	    $ratauk = round($nilai/$i,2);
	else
	    $ratauk = 0;
	
	$sql2 = "SELECT replid FROM ratauk WHERE idsemester='$idsemester' AND idkelas='$idkelas' AND idujian='$idujian'";
	$result2 = QueryDb($sql2);
	$num2 = @mysqli_num_rows($result2);
	if ($num2 == 0)
		$sql3 = "INSERT INTO ratauk SET idsemester='$idsemester', idkelas='$idkelas', idujian='$idujian', nilaiRK='$ratauk'";
	else 
		$sql3 = "UPDATE ratauk SET nilaiRK='$ratauk' WHERE idsemester='$idsemester' AND idkelas='$idkelas' AND idujian='$idujian'";
		
	QueryDbTrans($sql3, $success);
}


function GetRataKelas($idkelas,$idsemester,$idujian)
{
	$sql	= "SELECT nilaiRK FROM ratauk WHERE idsemester='$idsemester' AND idkelas='$idkelas' AND idujian='$idujian'";
	$result = QueryDb($sql);
	$num	= @mysqli_num_rows($result);
	$row	= @mysqli_fetch_row($result);
	if ($num==0)
		echo '0';
	else
		echo round($row[0],2);
}

function GetRataSiswa2($idpelajaran, $idjenis, $idkelas, $idsemester, $idaturan, $nis)
{
	$sql = "SELECT rataUS FROM rataus 
			WHERE idsemester='$idsemester' AND idkelas='$idkelas' AND idjenis='$idjenis' 
			AND idpelajaran='$idpelajaran' AND idaturan='$idaturan' AND nis='$nis'";
	$result = QueryDb($sql);
	$num = @mysqli_num_rows($result);
	$row = @mysqli_fetch_row($result);
	if ($num == 0)
		echo '0';
	else
		echo round($row[0], 2);
}

function GetRataSiswa($idkelas, $idsemester, $idaturan, $nis)
{
	$sql = "SELECT replid, idpelajaran, idjenis FROM ujian WHERE idkelas=$idkelas AND idsemester=$idsemester AND idaturan=$idaturan";
	$result	= QueryDb($sql);
	$cnt	= 0;
	$nilai = 0;
	while ($row	= @mysqli_fetch_row($result)){
		$idujian= $row[0];
		$idpelajaran= $row[1];
		$idjenis= $row[2];

		$sql2	= "SELECT nilaiujian FROM nilaiujian WHERE idujian='$idujian' AND nis='$nis'";
		$result2= QueryDb($sql2);
		$row2	= @mysqli_fetch_row($result2);
		$nilai	+= (int)$row2[0];
		$cnt++;
	}
	if ($cnt > 0)
	    $rataus = $nilai/$cnt;
	else
	    $rataus = 0;

	$sql = "SELECT rataUS FROM rataus WHERE idsemester='$idsemester' AND idkelas='$idkelas' AND idjenis='$idjenis' AND idpelajaran='$idpelajaran'  AND idaturan='$idaturan' AND nis='$nis'";
	$result = QueryDb($sql);
	$num = @mysqli_num_rows($result);
	$row	= @mysqli_fetch_row($result);
	if ($num==0)
		echo '0';
	else
		echo round($row[0],2);
}
?>