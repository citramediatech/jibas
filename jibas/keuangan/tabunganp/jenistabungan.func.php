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
require_once('../library/departemen.php');

function CheckUserLevel()
{
    if (getLevel() == 2)
    { ?>
    	<script language="javascript">
            alert('Maaf, anda tidak berhak mengakses halaman ini!');
            document.location.href = "tabungan.php";
        </script>
<?      exit();
    } // end if
}

function ReadPageParam()
{
    global $varbaris, $page, $hal, $idkategori, $departemen;
    
    $varbaris = 10;
    if (isset($_REQUEST['varbaris']))
        $varbaris = $_REQUEST['varbaris'];
    
    $page = 0;
    if (isset($_REQUEST['page']))
        $page = $_REQUEST['page'];
        
    $hal = 0;
    if (isset($_REQUEST['hal']))
        $hal = $_REQUEST['hal'];
    
    $idkategori = "";
    if (isset($_REQUEST['idkategori']))
        $idkategori = $_REQUEST['idkategori'];
        
    $departemen = "";
    if (isset($_REQUEST['departemen']))
        $departemen = $_REQUEST['departemen'];
}


function DelTabungan($id)
{
	$sql = "DELETE FROM datatabunganp WHERE replid = '$id'";
	QueryDb($sql);
}

function SetAktif($id, $newaktif)
{
    global $idkategori, $departemen, $varbaris, $page, $hal;
    
    $sql = "UPDATE datatabunganp SET aktif = '$newaktif' WHERE replid= '$id'";
	QueryDb($sql);
    CloseDb();
    
	header("Location: jenistabungan.php?departemen=$departemen&varbaris=$varbaris&page=$page&hal=$hal");
    exit();
}

function ShowSelectDepartemen()
{
    global $departemen;
    
    echo "<select name='departemen' id='departemen' onChange='change_dep()' style='width:200px'>";
    $dep = getDepartemen(getAccess());
	foreach($dep as $value)
    { 
        if ($departemen == "") $departemen = $value;
        $selected = StringIsSelected($value, $departemen);
        echo "<option value='$value' $selected>$value</option>";
    }
    echo "</select>";
}
?>