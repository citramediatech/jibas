<?php
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
<?php
require_once('../include/sessionchecker.php');
require_once('../include/common.php');
require_once('../include/rupiah.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../include/errorhandler.php');

$idPgTransLebih = $_REQUEST["idpgtranslebih"];

OpenDb();
$sql = "SELECT IFNULL(bm.berkas, '') AS berkas
          FROM jbsfina.pgtranslebih p
         INNER JOIN jbsfina.bankmutasi bm ON p.pridmutasi = bm.replid
         WHERE p.id = $idPgTransLebih";
$res = QueryDb($sql);
if (mysqli_num_rows($res) == 0)
{
    echo "<br><br>Data berkas tidak ditemukan!";
    return;
}

$row = mysqli_fetch_row($res);
$buktiTf64 = $row[0];

echo "<img src='data:image/jpeg;base64,$buktiTf64'>";
CloseDb();
?>
