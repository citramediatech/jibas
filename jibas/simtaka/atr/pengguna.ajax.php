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
require_once('../inc/config.php');
require_once('../inc/sessioninfo.php');
require_once('../inc/db_functions.php');
require_once('../inc/common.php');
require_once('../inc/compatibility.php');
require_once('pengguna.func.php');

OpenDb();

$op = $_REQUEST['op'];
if ($op == "getperpus")
{
    $tingkat = $_REQUEST['tingkat'];
    $dep = $_REQUEST['dep'];
    
    http_response_code(200);
    GetPerpus($tingkat, $dep);
}

CloseDb();
?>
