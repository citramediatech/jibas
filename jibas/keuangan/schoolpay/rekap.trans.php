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
require_once('../library/stringbuilder.php');
require_once('../library/date.func.php');
require_once('rekap.trans.func.php');

OpenDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Rekapitulasi Transaksi Vendor</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <link rel="stylesheet" type="text/css" href="../style/tooltips.css">
    <script language="javascript" src="../script/jquery-1.9.0.js"></script>
    <script language="javascript" src="../script/tooltips.js"></script>
    <script language="javascript" src="../script/tables.js"></script>
    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript" src="../script/request.factory.js?r=<?=filemtime('../script/request.factory.js')?>"></script>
    <script language="javascript" src="rekap.trans.js?r=<?=filemtime('rekap.trans.js')?>"></script>
</head>

<body >
<table border="0" width="100%" height="100%">
<tr>
    <td align="center" valign="top" background="../images/bulu1.png" style="background-repeat:no-repeat">

        <table border="0" width="100%" align="center">
        <tr>
            <td align="left" valign="top">

                <table border="0"width="95%" align="center">
                <tr>
                    <td align="right">
                        <font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;
                        </font>&nbsp;<font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Rekapitulasi Transaksi Vendor</font>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <a href="schoolpay.php">
                            <font size="1" color="#000000"><b>SchoolPay</b></font>
                        </a>&nbsp>&nbsp
                        <font size="1" color="#000000"><b>Rekapitulasi Transaksi Vendor</b></font>
                    </td>
                </tr>
                <tr>
                    <td align="left">&nbsp;</td>
                </tr>
                </table>
                <br />

            </td>
        </tr>
        </table>
        <br>

        <table border="0" width="100%" align="left">
        <tr>
            <td align="left" valign="top" width="10%">
                &nbsp;
            </td>
            <td align="left" valign="top" width="*">

                <table border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="60" align="right">
                        <strong>Vendor:</strong>
                    </td>
                    <td align="left">
<?php                   ShowCbVendor() ?>
                    </td>
                    <td rowspan="2" valign="middle">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" class="but" style="height: 50px; width: 85px;" value="Lihat" onclick="showRekapTrans()">
                    </td>
                </tr>
                <tr>
                    <td width="60" align="right">
                        <strong>Tanggal:</strong>
                    </td>
                    <td align="left">
<?php                   ShowSelectTanggal1() ?>
                        &nbsp;s/d&nbsp;
<?php                   ShowSelectTanggal2() ?>
                    </td>
                </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td align="left" valign="top" width="10%">
                &nbsp;
            </td>
            <td align="left" valign="top" width="*">

                <table border="0" cellspacing="2" cellpadding="2">
                <tr><td align="left">
                    <span id="spReport"></span>
                </td></tr>
                </table>

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