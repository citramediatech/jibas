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
require_once("../include/sessionchecker.php");
require_once("../include/config.php");
require_once("../include/db_functions.php");
require_once("../include/common.php");
require_once("../include/sessioninfo.php");

$replid = $_REQUEST['replid'];

OpenDb();
$sql = "SELECT filedata, filename, filemime, filesize FROM jbssdm.tambahandatapegawai WHERE replid = $replid";
$res = QueryDb($sql);
if ($row = mysqli_fetch_array($res))
{
    $filedata = $row['filedata'];
    $filename = $row['filename'];
    $filemime = $row['filemime'];
    $filesize = $row['filesize'];

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    header("Content-Type: $filemime");
    header("Content-Disposition: attachment; filename=\"$filename\";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: $filesize");
    ob_clean();
    flush();
    echo $filedata;
}
CloseDb();
?>