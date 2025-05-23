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
require_once("../include/compatibility.php");
require_once("psb.daftar.func.php");

$op = $_REQUEST['op'];
if ($op == "getDaftarPsb")
{
    $idkelompok = $_REQUEST['idkelompok'];
    $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        
    OpenDb();    
    ShowDaftarPsb($idkelompok, $page);
    CloseDb();
}
elseif ($op == "doChangeData")
{
    $nocalon = urldecode($_REQUEST['nocalon']);
    $namacalon = urldecode($_REQUEST['namacalon']);
    $idkelompok = $_REQUEST['idkelompok'];
    $page = $_REQUEST['page'];
    $npage = $_REQUEST['npage'];
    
    ShowFormUbahData($nocalon, $namacalon, $idkelompok, $page, $npage);
}
elseif ($op == "setProsesPsb")
{
    $dept = $_REQUEST['dept'];
    
    OpenDb();
    ShowPenerimaanCombo($dept);
    CloseDb();
}
elseif ($op == "setKelompokPsb")
{
    $proses = $_REQUEST['proses'];
    
    OpenDb();
    ShowKelompokCombo($proses);
    CloseDb();
}
elseif ($op == "doCheckPin")
{
    $nocalon = urldecode($_REQUEST['nocalon']);
    $namacalon = urldecode($_REQUEST['namacalon']);
    $idkelompok = $_REQUEST['idkelompok'];
    $page = $_REQUEST['page'];
    $npage = $_REQUEST['npage'];
    $pincalon = $_REQUEST['pincalon'];
    
    OpenDb(); 
    if (PinIsValid($nocalon, $pincalon))
    {
        CloseDb();
        
        http_response_code(200);
        include("psb.edit.php");
    }
    else
    {
        CloseDb();
        http_response_code(500);
        echo "PIN Calon Siswa tidak sesuai!";    
    }
}
?>