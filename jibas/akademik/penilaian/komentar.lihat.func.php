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
function ReadParams()
{
    global $SI_USER_STAFF;

    if (SI_USER_LEVEL() == $SI_USER_STAFF)
    {
        global $dis_text, $dis;

        $dis_text ="disabled class='disabled'";
        $dis = "disabled";
    }

    global $urut, $urutan, $departemen, $semester, $tingkat, $tahunajaran, $pelajaran, $kelas, $jum;

    $urut = $_REQUEST['urut'];
    if ($urut == "")
        $urut = "nama";
    else
        $urut = $_REQUEST['urut'];

    $urutan = $_REQUEST['urutan'];
    if ($urutan == "")
        $urutan = "asc";
    else
        $urutan = $_REQUEST['urutan'];

    if (isset($_REQUEST['departemen']))
        $departemen = $_REQUEST['departemen'];

    if (isset($_REQUEST['semester']))
        $semester = $_REQUEST['semester'];

    if (isset($_REQUEST['tingkat']))
        $tingkat = $_REQUEST['tingkat'];

    if (isset($_REQUEST['tahunajaran']))
        $tahunajaran = $_REQUEST['tahunajaran'];

    if (isset($_REQUEST['pelajaran']))
        $pelajaran = $_REQUEST['pelajaran'];

    if (isset($_REQUEST['kelas']))
        $kelas = $_REQUEST['kelas'];

    if (isset($_REQUEST['jum']))
        $jum = $_REQUEST['jum'];
}

function PredikatNama($predikat)
{
    switch ($predikat)
    {
        case 4:
            return "Istimewa";
        case 3:
            return "Baik";
        case 2:
            return "Cukup";
        case 1:
            return "Kurang";
        case 0:
            return "Buruk";

    }
}
?>
