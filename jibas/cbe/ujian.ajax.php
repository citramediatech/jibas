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
require_once("ujian.func.php");

$op = $_REQUEST["op"];
if ($op == "getujiandata")
{
    echo getUjianData();
}
else if ($op == "getsoal")
{
    $idSoal = $_REQUEST["idsoal"];
    echo getSoal($idSoal);
}
else if ($op == "updateintent")
{
    $json = $_REQUEST["json"];
    $json = str_replace("\\", "", $json);
    echo updateUjianData($json);
}
else if ($op == "simpanjawaban")
{
    $jwbJson = $_REQUEST["jwbjson"];
    $jwbJson = str_replace("\\", "", $jwbJson);
    echo simpanJawaban($jwbJson);
}
else if ($op == "getelapsedtime")
{
    echo getElapsedTime();
}
else if ($op == "updateelapsed")
{
    $elapsed = $_REQUEST["elapsed"];
    echo updateElapsedTime($elapsed);
}
else if ($op == "finishujian")
{
    $ujianData = $_REQUEST["ujiandata"];
    echo finishUjian($ujianData);
}
else if ($op == "downloadsoal")
{
    $idSoal = $_REQUEST["idsoal"];
    echo checkDownloadSoal($idSoal);
}
else if ($op == "getgambarsoal")
{
    $idSoal = $_REQUEST["idsoal"];
    echo getGambarSoal($idSoal);
}
?>