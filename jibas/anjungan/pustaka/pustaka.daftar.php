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
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('pustaka.config.php');
require_once('pustaka.daftar.func.php');

OpenDb();
?>
<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr>
    <td align="right" width='10%'>
    <strong>Perpustakaan:</strong>
    </td>    
    <td align="left" width='52%'>
<?  ShowCbPustaka();    ?>
    </td>
    <td rowspan='2'>
    <input type='button' value='Lihat' class='but'
           style='height: 40px; width: 100px;'
           onclick='ptkadaftar_showlist()'>
    </td>
</tr>
<tr>
    <td align="right" width='100'>
    <strong>Kriteria:</strong>
    </td>    
    <td align="left">
<?  ShowCbPilih(); ?>
    <span id='ptkadaftar_divkriteria'>
<?  ShowCbKriteria('KAT'); ?>
    </span>
    </td>
</tr>
<tr>
    <td align="left" colspan="3">
    <br>
    <div id="ptkadaftar_content">

    </div>    
    </td>
</tr>
</table>
<?
CloseDb();
?>