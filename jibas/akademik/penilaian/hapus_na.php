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
require_once('../include/theme.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
?>

<?
OpenDb();
$query3 = "DELETE FROM jbsakad.nau WHERE idjenis = '$_GET[id]'";
$result3 = QueryDb($query3);

$row3 = @mysqli_fetch_array($result3);

if(mysqli_affected_rows($mysqlconnection) > 0) {
?>
    <script language="JavaScript">
        //alert("Jenis Penilaian Siswa berhasil dihapus");
        document.location.href="tampil_nilai_pelajaran.php?jenis_penilaian=<?=$_GET['jenis_penilaian'] ?>&departemen=<?=$_GET['departemen'] ?>&tahun=<?=$_GET['tahun'] ?>&tingkat=<?=$_GET['tingkat'] ?>&semester=<?=$_GET['semester'] ?>&pelajaran=<?=$_GET['pelajaran'] ?>&kelas=<?=$_GET['kelas'] ?>";
    </script>
<?
}
else {
?>
    <script language="JavaScript">
        //alert('Ujian gagal dihapus!');
		document.location.href="tampil_nilai_pelajaran.php?jenis_penilaian=<?=$_GET['jenis_penilaian'] ?>&departemen=<?=$_GET['departemen'] ?>&tahun=<?=$_GET['tahun'] ?>&tingkat=<?=$_GET['tingkat'] ?>&semester=<?=$_GET['semester'] ?>&pelajaran=<?=$_GET['pelajaran'] ?>&kelas=<?=$_GET['kelas'] ?>";
    </script>

<?
}
CloseDb();
?>