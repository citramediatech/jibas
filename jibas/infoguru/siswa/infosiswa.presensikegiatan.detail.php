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
require_once('../include/sessionchecker.php');
require_once('../include/config.php');
require_once('../include/common.php');
require_once('../include/db_functions.php');
require_once('../library/datearith.php');

$nis = $_SESSION["infosiswa.nis"];

$idkegiatan = $_REQUEST['idkegiatan'];
$bulan = isset($_REQUEST['bulan']) ? $_REQUEST['bulan'] : date('n');
$tahun = isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date('Y');
$cnt = $_REQUEST['cnt'];

OpenDb();
?>

    <a href='#' onclick='pk_closeDetail(<?=$cnt?>, <?=$idkegiatan?>)' style='color: blue; font-weight: normal;'>tutup</a>
    <table border='1' cellspacing='0' style='border-collapse: collapse;' cellpadding='2' width='100%'>
    <tr height='25'>
        <td width='7%' align='center' class='header'>No</td>
        <td width='8%' align='left' class='header'>Hari</td>
        <td width='15%' align='center' class='header'>Tanggal<br>Masuk</td>
        <td width='14%' align='center' class='header'>Jam Masuk</td>
        <td width='14%' align='center' class='header'>Jam Pulang</td>
        <td width='12%' align='center' class='header'>Kehadiran</td>
        <td width='12%' align='center' class='header'>Keter lambatan</td>
        <td width='*' align='left' class='header'>Keterangan</td>
    </tr>            
<?
    $cnt = 0;
    
    $sql = "SELECT p.replid, DATE_FORMAT(date_in, '%d %b %Y') AS date_in, time_in, DATE_FORMAT(date_out, '%d %b %Y') AS date_out, 
                   IF(p.time_out IS NULL, '-', p.time_out) AS time_out, p.smssent, p.smssenthome, p.description, 
                   WEEKDAY(date_in) AS weekday, IF(p.info1 IS NULL, 0, p.info1) AS telat, IF(p.nis IS NULL, 0, 1) AS ownertype
              FROM jbssat.frpresensikegiatan p
             WHERE MONTH(p.date_in) = $bulan
               AND YEAR(p.date_in) = $tahun
               AND p.nis = '$nis' 
               AND p.idkegiatan = $idkegiatan
             ORDER BY date_in DESC";
    $res = QueryDb($sql);
    while($row = mysqli_fetch_array($res))
    {
        $ti = $row['time_in'];
        
        $to = "";
        $tomark = "";
        if ($row['time_out'] == "-")
        {
            $wd = $row['weekday'];
            
            $sql = "SELECT pulangstd
                      FROM jbssat.frjadwalkegiatan
                     WHERE idkegiatan = $idkegiatan
                       AND hari = $wd";
            $res2 = QueryDb($sql);
            if (mysqli_num_rows($res2) > 0)
            {
                $row2 = mysqli_fetch_row($res2);
                
                $to = $row2[0] . ":00";
                $tomark = " (std)";
            }
            else
            {
                $to = "NA";
            }
            
            $hadir = "NA";
            if ($to != "NA")
            {
                $h = 0;
                $m = 0;
                $s = 0;
                DateArith::TimeDiff($to, $ti, $h, $m, $s);
                
                $hadir = DateArith::ToStringHour($h, $m, $s);
            }
        }
        
        $cnt += 1;
?>
        <tr>
            <td align='center'><?= $cnt ?></td>
            <td align='left'><?= DateArith::InaDayName($row['weekday']) ?></td>
            <td align='center'><?= $row['date_in'] ?></td>
            <td align='center'><?= $ti ?></td>
            <td align='center'><?= $to . $tomark ?></td>
            <td align='center'><?= $hadir ?></td>
            <td align='center'><?= DateArith::ToStringHourFromMinute($row['telat']) ?></td>
            <td align='left'><?= $row['description'] ?>&nbsp;</td>
        </tr>
<?
    }
?>
    </table>

<?
CloseDb();
?>