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
require_once('../include/theme.php'); 
require_once('../cek.php');

OpenDb();

$petugas = SI_USER_ID() == "landlord" ? "NULL" : "'" . SI_USER_ID() . "'";

$mode = $_REQUEST['mode'];
$id = $_REQUEST['id'];
$departemen = $_REQUEST['departemen'];
$status = $_REQUEST['status'];

$judul = trim($_REQUEST['judul']);
$judul = str_replace("`", "'", $judul);
$judul = addslashes($judul);

$pengantar = trim($_REQUEST['pengantar']);
$pengantar = str_replace("`", "'", $pengantar);
$pengantar = addslashes($pengantar);

if ($id == 0)
{
    $sql = "INSERT INTO jbsumum.lampiransurat
               SET departemen = '$departemen',
                   tanggal = NOW(),
                   judul = '$judul',
                   pengantar = '$pengantar',
                   petugas = $petugas";
}
else
{
    $sql = "UPDATE jbsumum.lampiransurat
               SET tanggal = NOW(),
                   judul = '$judul',
                   pengantar = '$pengantar',
                   petugas = $petugas
             WHERE replid = $id";
}
QueryDb($sql);

CloseDb();
?>
<script>
    document.location.href = "lampiran.php?departemen=<?=$departemen?>&status=<?=$status?>";
</script>