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
function ShowSelectDept()
{
    global $departemen;
    
    $dep = getDepartemen(getAccess());
    
    echo "<select name='departemen' id='departemen' style='width:100px' onchange='change_dep();'>";
    foreach($dep as $value)
    {
        if ($departemen == "")
            $departemen = $value;
        
        $sql = "SELECT replid
                  FROM jbsakad.departemen
                 WHERE departemen = '$value'";
        $replid = (int)FetchSingle($sql);
        
        echo "<option value='$replid' " . StringIsSelected($value, $departemen) . ">$value</option>";
    }
    echo "</select>";
}

function ShowSelectTanggal()
{
    global $selthn, $selbln, $seltgl, $G_START_YEAR;
    
    $sql = "SELECT YEAR(NOW())";
    $res = QueryDb($sql);
    $row = mysqli_fetch_row($res);
    $thnskrg = $row[0];
    
    
    $maxtgl = JmlHari($selbln, $selthn);
    
    ?>
    
    <select name="tgl" id = "tgl" onchange="change_tgl()">
    <? for($i = 1; $i <= $maxtgl; $i++) { ?>
        <option value="<?=$i ?>" <?=IntIsSelected($i, $seltgl) ?> > <?= $i ?></option>
    <? } ?>
    </select>
    
    <select name="bln" id="bln" onchange="change_tgl()">
    <? for($i = 1; $i <= 12; $i++) { ?>
        <option value="<?=$i ?>" <?=IntIsSelected($i, $selbln) ?> > <?= NamaBulan($i) ?></option>
    <? } ?>
    </select>
    
    <select name="thn" id="thn" onchange="change_tgl()">
    <? for($i = $G_START_YEAR; $i <= $thnskrg + 1; $i++) { ?>
        <option value="<?=$i ?>" <?=IntIsSelected($i, $selthn) ?> > <?= $i ?></option>
    <? } ?>
    </select>
    
    <?
}
?>