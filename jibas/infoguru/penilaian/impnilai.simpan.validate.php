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
<?php
$errmsg = array();

// Validasi DEPARTEMEN -----------------------------
$departemen = trim($_REQUEST['departemen']);
if (strlen($departemen) == 0)
{
    $errmsg[] = "Departemen belum ditentukan!";
}
else
{
    $sql = "SELECT COUNT(replid) FROM jbsakad.departemen WHERE departemen = '$departemen'";
    if (0 == (int) FetchSingle($sql))
        $errmsg[] = "Departemen $departemen tidak ditemukan!";
}

// Validasi Id Kelas -------------------------------
$idkelas = trim($_REQUEST['idkelas']);
if (strlen($idkelas) == 0)
{
    $errmsg[] = "Id Kelas belum ditentukan!";
}
else
{
    $sql = "SELECT COUNT(replid) FROM jbsakad.kelas WHERE replid = '$idkelas'";
    if (0 == (int) FetchSingle($sql))
        $errmsg[] = "Id Kelas $idkelas tidak ditemukan!";
}

// Validasi NIP ------------------------------------
$nip = trim($_REQUEST['nip']);
if (strlen($nip) == 0)
{
    $errmsg[] = "NIP Guru belum ditentukan!";
}
else
{
    $sql = "SELECT COUNT(replid) FROM jbssdm.pegawai WHERE nip = '$nip'";
    if (0 == (int) FetchSingle($sql))
        $errmsg[] = "NIP Guru $nip tidak ditemukan!";
}

if ($nip != SI_USER_ID())
    $errmsg[] = "Hanya bisa mengimpor nilai dari guru dengan NIP " . SI_USER_ID() . "!";

// Validasi Kode Ujian -------------------------------
$kodeujian = trim($_REQUEST['kodeujian']);
if (strlen($kodeujian) == 0)
{
    $errmsg[] = "Kode ujian belum ditentukan!";
}

// Validasi Tahun ------------------------------------
$tahun = trim($_REQUEST['tahun']);
if (strlen($tahun) != 4)
{
    $errmsg[] = "Tahun ujian belum ditentukan!";
}
else
{
    if (!is_numeric($tahun))
        $errmsg[] = "Tahun ujian harus berupa angka!";
}

// Validasi Bulan ------------------------------------
$bulan = trim($_REQUEST['bulan']);
if (strlen($bulan) == 0 || strlen($bulan) > 2)
{
    $errmsg[] = "Bulan ujian belum ditentukan!";
}
else
{
    if (!is_numeric($bulan))
        $errmsg[] = "Bulan ujian harus berupa angka!";

    if ($bulan < 0 || $bulan > 12)
        $errmsg[] = "Bulan ujian harus antara 1 dan 12!";
}

// Validasi Tanggal ----------------------------------
$tanggal = trim($_REQUEST['tanggal']);
if (strlen($tanggal) == 0 || strlen($tanggal) > 2)
{
    $errmsg[] = "Tanggal ujian belum ditentukan!";
}
else
{
    if (!is_numeric($tanggal))
        $errmsg[] = "Tanggal ujian harus berupa angka!";

    $nday = GetMaxDay($tahun, $bulan);
    if ($tanggal < 0 || $tanggal > $nday)
        $errmsg[] = "Tanggal ujian harus antara 1 dan $nday!";
}

$nData = trim($_REQUEST['nnilai']);
if ($nData == 0)
    $errmsg[] = "Data nilai ujian siswa tidak ditemukan!";

for($i = 1; $i <= $nData; $i++)
{
    $param = "nis$i";
    $nis = trim($_REQUEST[$param]);
    if (strlen($nis) == 0) {
        $errmsg[] = "NIS Siswa baris ke-$i belum ditentukan";
    }
    else {
        $nis = str_replace("'", "`", $nis);
        $sql = "SELECT aktif FROM jbsakad.siswa WHERE nis = '$nis'";
        $res2 = QueryDb($sql);
        if (mysqli_num_rows($res2) == 0) {
            $errmsg[] = "NIS Siswa {$nis} baris ke-$i tidak ditemukan!";
        }
        else
        {
            $row2 = mysqli_fetch_row($res2);
            $aktif = $row2[0];
            if ($aktif != 1)
                $errmsg[] = "NIS Siswa {$nis} baris ke-$i tidak aktif!";
        }
    }

    $param = "nilai$i";
    $nilai = trim($_REQUEST[$param]);
    if (strlen($nilai) == 0)
        $errmsg[] = "Nilai siswa baris ke-$i belum ditentukan";

    if (!is_numeric($nilai))
        $errmsg[] = "Nilai siswa baris ke-$i harus berupa angka!";

    if ($nilai < 0)
        $errmsg[] = "Nilai siswa baris ke-$i harus lebih besar dari 0!";
}

if (count($errmsg) != 0)
{
    echo "<font style='color:red'><strong>PESAN KESALAHAN:</strong></font><br>";
    for ($i = 0; $i < count($errmsg); $i++)
    {
        echo "<font style='color:red'><strong>- " . $errmsg[$i] . "</strong></font><br>";
    }
    CloseDb();
    exit();
}

?>
