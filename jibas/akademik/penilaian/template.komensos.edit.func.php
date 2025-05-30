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
    global $replid, $komentar, $jenis;

    if (isset($_REQUEST['replid']))
        $replid = $_REQUEST['replid'];

    if (isset($_REQUEST['komentar']))
        $komentar = CQ($_REQUEST['komentar']);

    if (isset($_REQUEST['jenis']))
        $jenis = CQ($_REQUEST['jenis']);

    $komentar = urldecode($komentar);
}

function ReadData()
{
    global $replid, $komentar;

    OpenDb();
    $sql = "SELECT komentar FROM pilihkomensos WHERE replid = '$replid'";
    $res = QueryDb($sql);
    $row = mysqli_fetch_row($res);
    $komentar = $row[0];
    CloseDb();
}

function SimpanData()
{
    global $replid, $komentar, $jenis;

    OpenDb();
    $komentar = CQ($komentar);
    $sql = "UPDATE pilihkomensos 
               SET komentar = '$komentar'
             WHERE replid = '$replid'";
    $result = QueryDb($sql);
    if ($result)
    { 	?>
        <script language="javascript">
            opener.refreshListKomentarSos('<?=$jenis?>');
            window.close();
        </script>
        <?
    }
    CloseDb();
    exit();

}
?>