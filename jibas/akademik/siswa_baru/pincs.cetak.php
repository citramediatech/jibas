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
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/getheader.php');

OpenDb();

$idkelompok = $_REQUEST['idkelompok'];

$sql = "SELECT k.kelompok, p.proses, p.departemen
          FROM jbsakad.kelompokcalonsiswa k, jbsakad.prosespenerimaansiswa p 
         WHERE k.idproses = p.replid
           AND k.replid = $idkelompok";
$res = QueryDb($sql);
if ($row = mysqli_fetch_row($res))
{
    $kelompok = $row[0];
    $proses = $row[1];
    $departemen = $row[2];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>JIBAS SIMAKA [Cetak PIN Calon Siswa]</title>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
    <tr><td align="left" valign="top">

            <?=getHeader($departemen)?>

            <center>
                <font size="4"><strong>DAFTAR PIN CALON SISWA</strong></font><br />
            </center><br /><br />

            <br />
            <strong>Departemen : <?=$departemen?></strong>
            <br />
            <strong>Proses Penerimaan : <?=$proses?></strong>
            <br />
            <strong>Kelompok Calon Siswa : <?=$kelompok?></strong>

            <br /><br />
            <table class="tab" id="table" border="1" style="border-collapse:collapse" width="100%" align="left" bordercolor="#000000">
                <tr height="30">
                    <td width="4%" class="header" align="center">No</td>
                    <td width="25%" class="header" align="center">No Pendaftaran</td>
                    <td width="*" class="header" align="center">Nama</td>
                    <td width="15%" class="header" align="center">PIN</td>
                </tr>
                <?
                $sql = "SELECT nopendaftaran, nama, pinsiswa 
                          FROM jbsakad.calonsiswa
                         WHERE idkelompok = '$idkelompok'
                         ORDER BY nama";
                $result = QueryDB($sql);
                $cnt = 0;

                while ($row = mysqli_fetch_array($result)) { ?>
                    <tr height="25">
                        <td align="center"><?=++$cnt ?></td>
                        <td><?=$row['nopendaftaran'] ?></td>
                        <td><?=$row['nama'] ?></td>
                        <td align="center"><?=$row['pinsiswa'] ?></td>
                    </tr>
                <?	} ?>
                <!-- END TABLE CONTENT -->
            </table>
        </td>
    </tr>
</table>
</body>
<script language="javascript">
    window.print();
</script>
</html>
<?
CloseDb();
?>