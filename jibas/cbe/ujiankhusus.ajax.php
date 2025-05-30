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
<?php
require_once("ujiankhusus.func.php");

$op = $_REQUEST["op"];
if ($op == "getdaftarpelajaran")
{
    $viewDaftarUjian = $_REQUEST["viewdaftarujian"];

    echo getDaftarPelajaran($viewDaftarUjian);
}
else if ($op == "getdaftarujian")
{
    $viewDaftarUjian = $_REQUEST["viewdaftarujian"];
    $idPelajaran = $_REQUEST["idpelajaran"];

    echo getDaftarUjian($viewDaftarUjian, $idPelajaran);
}
else if ($op == "startujian")
{
    $idUjian = $_REQUEST["idujian"];
    $idRemedUjian = $_REQUEST["idremedujian"];
    $idUjianSerta = $_REQUEST["idujianserta"];
    $idJadwalUjian = $_REQUEST["idjadwalujian"];

    echo startUjian($idUjian, $idRemedUjian, $idUjianSerta, $idJadwalUjian);
}
?>