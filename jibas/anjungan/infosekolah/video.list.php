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
require_once("notes.list.func.php");
require_once("infosekolah.common.func.php");
?>
<table border='0' cellpadding='2' cellspacing='0' width='98%'>
<tr>
    <td align='left' valign='top'>
        <font class='TitleTabMenu'>V I D E O</font>    
    </td>
    <td align='right' valign='bottom'>
        <a onclick='vidlst_NewVideoClicked()'>video baru</a>&nbsp;&nbsp;
        <a onclick='vidlst_ShowVideoIndexClicked()'>video indeks</a>&nbsp;&nbsp;
        <a onclick='vidlst_RefreshVideoList()'>refresh</a>
    </td>
</tr>    
</table>
<br>
<table id='vidlst_VideoTableList' border='0' width='100%' cellspacing='0' cellpadding='5'>
<thead>
<tr height='25' class='VideoTableHeader'>
    <td width='25%' align='center'>VIDEO</td>
    <td width='*' align='left'>DESKRIPSI</td>
    <td width='10%' align='center'>KOMENTAR</td>
    <td width='10%' align='center'>DILIHAT</td>
</tr>
</thead>
<tbody>
    
</tbody>
<tfoot>
    
</tfoot>
</table>