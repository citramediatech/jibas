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
require_once('../library/departemen.php');
require_once('../include/errorhandler.php');
require_once('mutasibank.deposit.dialog.func.php');

OpenDb();

$idDeposit = $_REQUEST["iddeposit"];
$departemen = $_REQUEST["departemen"];
$bank = $_REQUEST["bank"];
$bankNo = $_REQUEST["bankno"];

$deposit = "";
$keterangan = "";
LoadValue();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Daftar Simpanan Bank</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <link rel="stylesheet" type="text/css" href="../style/tooltips.css">
    <link rel="stylesheet" type="text/css" href="onlinepay.style.css">
    <script language="javascript" src="../script/jquery-1.9.0.js"></script>
    <script language="javascript" src="../script/tooltips.js"></script>
    <script language="javascript" src="../script/tables.js"></script>
    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript" src="../script/rupiah2.js" ></script>
    <script language="javascript" src="../script/request.factory.js?r=<?=filemtime('../script/request.factory.js')?>"></script>
    <script language="javascript" src="mutasibank.deposit.dialog.js?r=<?=filemtime('mutasibank.deposit.dialog.js')?>"></script>
</head>

<body >
<table border="0" width="100%" cellpadding="10">
<tr>
    <td align="left" valign="top">

        <span style="font-size: 14pt">Simpanan Bank</span><br><br>

        <input type="hidden" id="iddeposit" value="<?=$idDeposit?>">
        <input type="hidden" id="departemen" value="<?=$departemen?>">
        <input type="hidden" id="bankno" value="<?=$bankNo?>">

        <table border="0" width="100%" cellpadding="5" cellspacing="2">
        <tr>
            <td align="right" width="15%"><strong>Departemen</strong></td>
            <td align="left"><strong>: <?= $departemen?></strong></td>
        </tr>
        <tr>
            <td align="right"><strong>Bank</strong></td>
            <td align="left" width="*"><strong>: <?= $bank?></strong></td>
        </tr>
        <tr>
            <td align="right"><strong>Rekening:</strong></td>
            <td align="left" width="*"><strong>: <?= $bankNo?></strong></td>
        </tr>
        <tr>
            <td align="right" valign="top">
                <strong>Nama</strong>
            </td>
            <td align="left" valign="top">:
                <input type="text" id="deposit" class="inputbox" maxlength="255" size="45" value="<?= $deposit ?>">
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">
                Keterangan
            </td>
            <td align="left" valign="top">:
                <textarea rows="2" cols="40" class="inputbox" id="keterangan"><?= $keterangan ?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <br>
                <input type="button" class="but" value="Simpan" style="width: 80px; height: 30px;"  onclick="simpanDeposit()">
                <input type="button" class="but" value="Tutup" style="width: 80px; height: 30px;"  onclick="window.close()">
            </td>
        </tr>
        </table>

    </td>
</tr>
</table>
</body>
</html>
<?php
CloseDb();
?>
