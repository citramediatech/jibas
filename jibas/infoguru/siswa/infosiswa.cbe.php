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
require_once('../include/sessionchecker.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once("infosiswa.cbe.func.php");

OpenDb();
?>
<table border="0" cellpadding="2" cellspacing="0">
<tr>
    <td align="left" width="80">Bulan: </td>
    <td align="left" width="250">
        <?= showSelectBulan() ?>
        <?= showSelectTahun() ?>
    </td>
    <td align="left" rowspan="3">
        <img src="../images/ico/view.png" onclick="cbe_showRekapUjian()">
    </td>
</tr>
<tr>
    <td align="left">Jenis Ujian: </td>
    <td align="left">
        <?= showSelectJenisUjian() ?>
    </td>
</tr>
<tr>
    <td align="left">Pelajaran: </td>
    <td align="left">
    <span id="cbe_spCbPelajaran">
        <?= showSelectPelajaran(date('n'), date('Y'), -1) ?>
    </span>
    </td>
</tr>
</table>
<br>
<div id="cbe_divRekapUjian" style="width: 100%">
</div>
<?php
CloseDb();
?>