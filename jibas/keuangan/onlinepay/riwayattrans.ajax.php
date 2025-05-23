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
require_once('riwayattrans.func.php');

$op = $_REQUEST["op"];
if ($op == "893478934732")
{
    OpenDb();
    ShowSelectIuranWajib();
    CloseDb();
}
else if ($op == "987589345789345")
{
    OpenDb();
    ShowSelectIuranSukarela();
    CloseDb();
}
else if ($op == "437682489324234")
{
    OpenDb();
    ShowSelectTabunganSiswa();
    CloseDb();
}
else if ($op == "989834789234")
{
    $laporan = $_REQUEST["laporan"];
    if ($laporan == "RIWAYAT")
        require_once ("riwayattrans.riwayat.php");
    else
        require_once("riwayattrans.rekap.php");
}
?>