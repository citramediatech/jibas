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
require_once("../include/config.php");
require_once("../include/common.php");
require_once("../include/compatibility.php");
require_once("../include/db_functions.php");
require_once("notes.index.func.php");
?>
<table border='0' cellpadding='2' cellspacing='0' width='98%'>
<tr>
    <td align='left' valign='top'>
        <font class='TitleTabMenu'>N O T E S&nbsp;&nbsp;&nbsp;I N D E K S</font>    
    </td>
    <td align='right' valign='bottom'>
        <a onclick='notidx_BtBackClicked()'>kembali</a>&nbsp;&nbsp;
    </td>
</tr>    
</table>
<br>
Bulan: <? ShowComboBulan(); ?><? ShowComboTahun(); ?>
<table id='not_NotesIndexTableList' border='0' width='100%' cellspacing='0' cellpadding='5'>
<thead>
<tr height='25' class='NotesTableHeader'>
    <td width='12%' align='center'>DARI</td>
    <td width='12%' align='center'>KEPADA</td>
    <td width='*' align='left'>NOTES</td>
    <td width='10%' align='center'>KOMENTAR</td>
    <td width='10%' align='center'>DIBACA</td>
</tr>
</thead>
<tbody>
    
</tbody>
<tfoot>
    
</tfoot>
</table>