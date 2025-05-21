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
function SimpanPesanTagihan()
{
    try
    {
        $nDept = $_REQUEST["ndept"];
        for($i = 1; $i <= $nDept; $i++)
        {
            $key = "dept$i";
            $dept = $_REQUEST[$key];

            $key = "pesan$i";
            $pesan = $_REQUEST[$key];

            $sql = "UPDATE jbsfina.formatpesanpg SET pesan = '$pesan', kelompok = 'TAGIHAN', issync = 0 WHERE departemen = '$dept'";
            QueryDbEx($sql);
        }

        return createJsonReturn(1, "OK", "");
    }
    catch (Exception $ex)
    {
        return createJsonReturn(-1, $ex->getMessage(), "");
    }
}

function SimpanPesanPembayaran()
{
    try
    {
        $nDept = $_REQUEST["ndept"];
        for($i = 1; $i <= $nDept; $i++)
        {
            $key = "dept$i";
            $dept = $_REQUEST[$key];

            $key = "pesan$i";
            $pesan = $_REQUEST[$key];

            $sql = "UPDATE jbsfina.formatpesanpg SET pesan = '$pesan', kelompok = 'PEMBAYARAN', issync = 0 WHERE departemen = '$dept'";
            QueryDb($sql);
        }

        return createJsonReturn(1, "OK", "");
    }
    catch (Exception $ex)
    {
        return createJsonReturn(-1, $ex->getMessage(), "");
    }

}

function createJsonReturn($status, $message, $data)
{
    $ret = array($status, $message, $data);
    return json_encode($ret);
}
?>