<?php
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
<?php
function SearchTrans($showMenu)
{
    $transId = $_REQUEST["transid"];

    $sql = "SELECT p.transactionid, DATE_FORMAT(p.waktu, '%d-%b-%Y %H:%i') AS waktu,
                   v.nama as namavendor, u.nama AS namauser, p.jenis, IFNULL(p.nis, '') AS nis, IFNULL(s.nama, '') AS namasiswa,
                   IFNULL(p.nip, '') AS nip, IFNULL(pg.nama, '') AS namapegawai, p.jumlah, p.keterangan, p.jenistrans, p.iddatapenerimaan,
                   IFNULL(dp.nama, '') AS namapenerimaan, IF(p.valmethod = 1, 'PIN', 'Agreement') AS valmethod,
                   IF(r.waktu IS NULL, '<b>(belum refund)</b>', DATE_FORMAT(r.waktu, '%d-%b-%Y %H:%i')) AS refund
              FROM jbsfina.paymenttrans p
             INNER JOIN jbsfina.vendor v ON p.vendorid = v.vendorid
             INNER JOIN jbsfina.userpos u ON p.userid = u.userid
              LEFT JOIN jbsakad.siswa s ON p.nis = s.nis
              LEFT JOIN jbssdm.pegawai pg ON p.nip = pg.nip
              LEFT JOIN jbsfina.datapenerimaan dp ON p.iddatapenerimaan = dp.replid
              LEFT JOIN jbsfina.refund r ON p.idrefund = r.replid
             WHERE transactionid = '$transId'";

    $res = QueryDb($sql);
    $num = mysqli_num_rows($res);
    if ($num == 0)
    {
        echo "tidak ditemukan transaksi dengan id $transId";
        return;
    }

    $no = 0;
    $total = 0;
    echo "<br>";
    if ($showMenu)
    {
        echo "<a href='#' onclick='cetakReport()'><img src='../images/ico/print.png' border='0'>&nbsp;cetak</a>&nbsp;&nbsp;";
        echo "<a href='#' onclick='excelReport()'><img src='../images/ico/excel.png' border='0'>&nbsp;excel</a>";
    }
    echo "<input type='hidden' id='transid' name='transid' value='$transId'>";
    echo "<table id='table' border='1' cellpadding='5' cellspacing='0' style='border-width: 1px;'>";
    echo "<tr style='height: 30px;'>";
    echo "<td align='center' class='header' width='40'>No</td>";
    echo "<td align='left' class='header' width='150'>Waktu</td>";
    echo "<td align='left' class='header' width='180'>Vendor / Petugas</td>";
    echo "<td align='left' class='header' width='180'>Pelanggan</td>";
    echo "<td align='right' class='header' width='150'>Jumlah</td>";
    echo "<td align='left' class='header' width='150'>Jenis</td>";
    echo "<td align='left' class='header' width='120'>Validasi</td>";
    echo "<td align='left' class='header' width='250'>Keterangan</td>";
    if ($showMenu)
    {
        echo "<td align='left' class='header' width='40'>&nbsp;</td>";
    }
    echo "</tr>";
    while($row = mysqli_fetch_array($res))
    {
        $no += 1;

        if ($row['jenis'] == 1)
            $pelanggan = "Pegawai: " . $row["namapegawai"] . " (" . $row["nip"] . ")";
        else
            $pelanggan = "Siswa: " . $row["namasiswa"] . " (" . $row["nis"] . ")";

        $jumlah = FormatRupiah($row["jumlah"]);
        $total += $row["jumlah"];

        $jenisTrans = $row["jenistrans"];
        $pembayaran = "";
        if ($jenisTrans == 0)
            $pembayaran = "Pembayaran Vendor";
        else if ($jenisTrans == 1)
            $pembayaran = "Pembayaran Iuran Wajib " . $row["namapenerimaan"];
        else if ($jenisTrans == 2)
            $pembayaran = "Pembayaran Iuran Sukarela " . $row["namapenerimaan"];

        $keterangan = "";
        $ket = $row["keterangan"];
        if (strlen($ket) != 0)
            $keterangan = "Ket: " . $ket . "<br>";
        $keterangan .= "Id Trans: " . $row["transactionid"] . "<br>";
        if ($jenisTrans == 0)
            $keterangan .= "Refund: " . $row["refund"];

        $transId = $row["transactionid"];

        echo "<tr>";
        echo "<td align='center'>$no</td>";
        echo "<td align='left'>$row[waktu]</td>";
        echo "<td align='left'>$row[namavendor]<br>$row[namauser]</td>";
        echo "<td align='left'>$pelanggan</td>";
        echo "<td align='right'>$jumlah</td>";
        echo "<td align='left'>$pembayaran</td>";
        echo "<td align='left'>$row[valmethod]</td>";
        echo "<td align='left'>$keterangan</td>";
        if ($showMenu)
        {
            echo "<td align='center' valign='top'>";
            echo "<a href='#' onclick=\"cetakKuitansi('$transId')\" title='cetak kuitansi'>";
            echo "<img src='../images/ico/print.png' border='0'></a>";
            echo "</td>";
        }
        echo "</tr>";
    }

    echo "<tr style='height: 50px'>";
    echo "<td align='right' colspan='4' style='background-color: #efefef; font-size: 14px; font-weight: bold;'>TOTAL</td>";
    echo "<td align='right' style='background-color: #efefef; font-size: 14px; font-weight: bold;'>" . FormatRupiah($total) . "</td>";
    $colspan = $showMenu ? 4 : 3;
    echo "<td align='left' style='background-color: #efefef;' colspan='$colspan'>&nbsp;</td>";
    echo "</tr>";
    echo "</table>";
}
?>
