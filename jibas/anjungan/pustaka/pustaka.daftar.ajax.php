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
require_once('../include/compatibility.php');
require_once('pustaka.config.php');
require_once('pustaka.daftar.func.php');

$op = $_REQUEST['op'];
if ($op == "getchoice")
{
    OpenDb();
    try
    {
        $choice = $_REQUEST['choice'];
        ShowCbKriteria($choice);
        CloseDb();
        
        http_response_code(200);
    }
    catch(DbException $dbe)
    {
        CloseDb();
        
        http_response_code(500);
        echo $dbe->getMessage();
    }
    catch(Exception $e)
    {
        CloseDb();
        
        http_response_code(500);
        echo $e->getMessage();
    } 
}
elseif ($op == "showlist")
{
    OpenDb();
    try
    {
        $perpus = $_REQUEST['perpus'];
        $pilih = $_REQUEST['pilih'];
        $kriteria = $_REQUEST['kriteria'];
        $halaman = isset($_REQUEST['halaman']) ? $_REQUEST['halaman'] : 1;
        
        ShowList($perpus, $pilih, $kriteria, $halaman);
        CloseDb();
        
        http_response_code(200);
    }
    catch(DbException $dbe)
    {
        CloseDb();
        
        http_response_code(500);
        echo $dbe->getMessage();
    }
    catch(Exception $e)
    {
        CloseDb();
        
        http_response_code(500);
        echo $e->getMessage();
    }
}
elseif($op == "getdetail")
{
    OpenDb();
    try
    {
        $cnt = $_REQUEST['cnt'];
        $idpustaka = $_REQUEST['idpustaka'];
        
        ShowDetailPustaka($cnt, $idpustaka);
        CloseDb();
        
        http_response_code(200);
    }
    catch(DbException $dbe)
    {
        CloseDb();
        
        http_response_code(500);
        echo $dbe->getMessage();
    }
    catch(Exception $e)
    {
        CloseDb();
        
        http_response_code(500);
        echo $e->getMessage();
    }
}
elseif ($op == "hidedetail")
{
    $cnt = $_REQUEST['cnt'];
    $idpustaka = $_REQUEST['idpustaka'];
        
    echo "<a style='color: #0000ff; font-size: 9px; text-decoration: underline' onclick='ptkadaftar_showdetail($cnt, $idpustaka)'>";
    echo "detail";
    echo "</a>";
    
    http_response_code(200);
}
?>