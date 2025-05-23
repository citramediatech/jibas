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
require_once("../include/db_functions.php");
require_once("../library/datearith.php");
require_once("psb.status.func.php");

OpenDb();
?>
<form name="psb_daftar" id="psb_daftar" method="post">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
    <td width="15%" align="right">
        Departemen:
    </td>
    <td width="*" align="left">
<?      ShowDepartemenCombo() ?>        
    </td>
    <td width="45%" align="left" valign="middle" rowspan="2">
        <input type="button" value="Lihat" class="but" style="width: 100px; height: 40px;" onclick="psb_ShowStatusPsb()">
    </td>
</tr>
<tr>
    <td width="15%" align="right">
        Penerimaan:
    </td>
    <td width="*" align="left">
        <div id="psb_divProses">
<?      ShowPenerimaanCombo($selDept) ?>
        </div>
    </td>
</tr>
</table>
</form>
<hr width='96%' style='display: block; height: 1px; border: 0; border-top: 1px solid #557d1d;'>
<div id="psb_divStatus" style="width: 99%; height: 30px; overflow: auto;">
</div>    
<?
CloseDb();
?>
