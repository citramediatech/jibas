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
require_once('../include/rupiah.php');

$replid=$_REQUEST['replid'];

OpenDb();

$sql = "SELECT c.nopendaftaran, c.nama, c.panggilan, c.tahunmasuk, c.idproses, c.idkelompok, c.suku, c.agama, c.status, c.kondisi,
			   c.kelamin, c.tmplahir, DAY(c.tgllahir) AS tanggal, MONTH(c.tgllahir) AS bulan, YEAR(c.tgllahir) AS tahun, c.tgllahir,
			   c.warga, c.anakke, c.jsaudara, c.bahasa, c.berat, c.tinggi, c.darah, c.foto, c.alamatsiswa, c.kodepossiswa, c.telponsiswa,
			   c.hpsiswa, c.emailsiswa, c.kesehatan, c.asalsekolah, c.ketsekolah, c.namaayah, c.namaibu, c.almayah, c.almibu, c.pendidikanayah,
			   c.pendidikanibu, c.pekerjaanayah, c.pekerjaanibu, c.wali, c.penghasilanayah, c.penghasilanibu, c.alamatortu, c.telponortu,
			   c.hportu, c.info1, c.info2, c.emailayah, c.emailibu, c.alamatsurat, c.keterangan, p.proses, p.departemen, p.kodeawalan,
			   k.kelompok, k.keterangan AS ket, c.nisn, c.nik, c.noun, c.statusanak, c.jkandung, c.jtiri, c.noijasah, c.tglijasah,
			   c.statusayah, c.statusibu, c.tmplahirayah, c.tmplahiribu, c.tgllahirayah, c.tgllahiribu, c.hobi, c.jarak
		  FROM calonsiswa c, kelompokcalonsiswa k, prosespenerimaansiswa p
		 WHERE c.replid=$replid AND p.replid = c.idproses AND k.replid = c.idkelompok AND p.replid = k.idproses";

$result=QueryDB($sql);
$row_siswa = mysqli_fetch_array($result);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style/style.css">

<title>JIBAS SIMAKA [Data Calon Siswa]</title>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">
function cetak() {
	var replid = document.getElementById('replid').value;
	newWindow('../siswa_baru/calon_cetak_detail.php?replid='+replid, 'CetakDetailCalonSiswa','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
	//newWindow('cetak_detail_calon.php?replid='+replid, 'CetakCalonSiswa','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}
</script>
</head>

<body>
<table width="100%">
<tr height="50">
    <td colspan="3"><div align="center"><font size="4"><strong>DATA CALON SISWA</strong></font></div><br /></td>
</tr>
<tr>
    <th width="15%" scope="row"><div align="left"><strong>Departemen</strong></div></th>
    <td><div align="left"><strong>:&nbsp;
                <?=$row_siswa['departemen']?>
            </strong></div></td>
</tr>
<tr>
    <th scope="row"><div align="left"><strong>Proses&nbsp;Penerimaan</strong></div></th>
    <td><div align="left"><strong>:&nbsp;
                <?=$row_siswa['proses']?>
            </strong></div></td>
</tr>
<tr>
    <th scope="row"><div align="left"><strong>Kelompok&nbsp;Calon&nbsp;Siswa&nbsp;</strong></div></th>
    <td><div align="left"><strong>:&nbsp;
                <?=$row_siswa['kelompok']?>
            </strong></div></td>
</tr>
<tr>
    <td><strong>No. Pendaftaran </strong></td>
    <td><strong>:&nbsp;
            <?=$row_siswa['nopendaftaran']?></strong></td>
    <td align="right" width="50%">
        <input type="hidden" name="replid" id="replid" value="<?=$replid?>" />
        <a href="#" onclick="cetak('<?=$replid?>')"><img src="../images/ico/print.png" border="0"/>&nbsp;Cetak</a>&nbsp;&nbsp;
        <a href="#" onclick="window.close();"><img src="../images/ico/exit.png" width="16" height="16" border="0" />&nbsp;Tutup</a></div>
    </td>
</tr>
</table>
<br />

<table border="0"  width="100%" align="left">
<tr>
    <td valign="top">

        <table border="0" class="tab" id="table" cellpadding="0" style="border-collapse:collapse" cellspacing="0" width="100%">
            <tr align="left"height="30">
                <td colspan="6" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Data Pribadi Calon Siswa</strong></font>
                    <hr width="300" style="line-height:1px; border-style:dashed" align="left" />          </td>
            </tr>
            <tr height="20">
                <td width="5%" rowspan="19" bgcolor="#FFFFFF"></td>
                <td>1.</td>
                <td>N I S N</td>
                <td>: <?=$row_siswa['nisn']?></td>
                <td colspan="2" rowspan="19" bgcolor="#FFFFFF" valign='top'>
                    <div align="center" ><img src="../library/gambar.php?replid=<?=$replid?>&table=calonsiswa"  /></div>
                </td>
            </tr>
            <tr height="20">
                <td>&nbsp;</td>
                <td>N I K</td>
                <td>: <?=$row_siswa['nik']?></td>
            </tr>
            <tr height="20">
                <td>&nbsp;</td>
                <td>No. UN Sebelumnya</td>
                <td>: <?=$row_siswa['noun']?></td>
            </tr>
            <tr height="20">
                <td width="5%">2.</td>
                <td colspan="2">Nama Peserta Didik</td>
            </tr>
            <tr height="20">
                <td bgcolor="#FFFFFF">&nbsp;</td>
                <td width="20%">a. Lengkap</td>
                <td>:
                    <?=$row_siswa['nama']?></td>
            </tr>
            <tr height="20">
                <td bgcolor="#FFFFFF">&nbsp;</td>
                <td>b. Panggilan</td>
                <td>:
                    <?=$row_siswa['panggilan']?></td>
            </tr>
            <tr height="20">
                <td >3.</td>
                <td>Jenis Kelamin</td>
                <td >:
                    <? 	if ($row_siswa['kelamin']=="l")
                        echo "Laki-laki";
                    if ($row_siswa['kelamin']=="p")
                        echo "Perempuan";
                    ?></td>
            </tr>
            <tr height="20">
                <td>4.</td>
                <td>Tempat Lahir</td>
                <td>:
                    <?=$row_siswa['tmplahir']?></td>
            </tr>
            <tr height="20">
                <td>5.</td>
                <td>Tanggal Lahir</td>
                <td>:
                    <?=format_tgl($row_siswa['tgllahir']) ?></td>
            </tr>
            <tr height="20">
                <td>6.</td>
                <td >Agama</td>
                <td>:
                    <?=$row_siswa['agama']?></td>
            </tr>
            <tr height="20">
                <td>7.</td>
                <td>Kewarganegaraan</td>
                <td>:
                    <?=$row_siswa['warga']?></td>
            </tr>
            <tr height="20">
                <td>8.</td>
                <td>Anak ke</td>
                <td>:
                    <? if ($row_siswa['anakke']!=0) { echo $row_siswa['anakke']; } ?></td>
            </tr>
            <tr height="20">
                <td>9.</td>
                <td>Dari</td>
                <td>:
                    <? if ($row_siswa['jsaudara']!=0) { echo $row_siswa['jsaudara']; } ?> bersaudara</td>
            </tr>
            <tr height="20">
                <td>10.</td>
                <td>Status Anak</td>
                <td>:
                    <?=$row_siswa['statusanak']?></td>
            </tr>
            <tr height="20">
                <td>11.</td>
                <td>Jumlah Saudara Kandung</td>
                <td>:
                    <?=$row_siswa['jkandung']?>&nbsp;orang</td>
            </tr>
            <tr height="20">
                <td>12.</td>
                <td>Jumlah Saudara Tiri</td>
                <td>:
                    <?=$row_siswa['jtiri']?>&nbsp;orang</td>
            </tr>
            <tr height="20">
                <td>13.</td>
                <td>Kondisi Siswa</td>
                <td>:
                    <?=$row_siswa['kondisi']?></td>
            </tr>
            <tr height="20">
                <td>14.</td>
                <td>Status Siswa</td>
                <td>:
                    <?=$row_siswa['status']?></td>
            </tr>
            <tr height="20">
                <td>15.</td>
                <td>Bahasa Sehari-hari</td>
                <td>:
                    <?=$row_siswa['bahasa']?></td>
            </tr>
            <tr>
                <td bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td><td bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr align="left" height="30">
                <td colspan="6" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Keterangan Tempat Tinggal</strong></font>
                    <hr width="300" style="line-height:1px; border-style:dashed" align="left" /></td>
            </tr>
            <tr height="20">
                <td rowspan="7" bgcolor="#FFFFFF"></td>
                <td>16.</td>
                <td>Alamat</td>
                <td colspan="2">:
                    <?=$row_siswa['alamatsiswa']?></td>
            </tr>
            <tr height="20">
                <td>17.</td>
                <td>Kode Pos</td>
                <td colspan="2">:
                    <?=$row_siswa['kodepossiswa']?>
                </td>
            </tr>
            <tr height="20">
                <td>18.</td>
                <td>Jarak ke Sekolah</td>
                <td colspan="2">:
                    <?=$row_siswa['jarak']?>&nbsp;km
                </td>
            </tr>
            <tr height="20">
                <td>19.</td>
                <td>Telepon</td>
                <td colspan="2">:
                    <?=$row_siswa['telponsiswa']?></td>
            </tr>
            <tr height="20">
                <td>20.</td>
                <td>Handphone</td>
                <td colspan="2">:
                    <?=$row_siswa['hpsiswa']?></td>
            </tr>
            <tr height="20">
                <td>21.</td>
                <td>Email</td>
                <td colspan="2">:
                    <?=$row_siswa['emailsiswa']?></td>
            </tr>
            <tr>
                <td colspan="5" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr align="left" height="30">
                <td colspan="6" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Keterangan Kesehatan</strong></font>
                    <hr width="300" style="line-height:1px; border-style:dashed" align="left" /></td>
            </tr>
            <tr height="20">
                <td rowspan="5" bgcolor="#FFFFFF"></td>
                <td>22.</td>
                <td >Berat Badan</td>
                <td colspan="2">:
                    <? if ($row_siswa['berat']!=0) { echo $row_siswa['berat']." Kg"; } ?></td>
            </tr>
            <tr height="20">
                <td>23.</td>
                <td>Tinggi Badan</td>
                <td colspan="2">:
                    <? if ($row_siswa['tinggi']!=0) { echo $row_siswa['tinggi']." cm"; } ?></td>
            </tr>
            <tr height="20">
                <td>24.</td>
                <td >Golongan Darah</td>
                <td colspan="2">:
                    <?=$row_siswa['darah']?></td>
            </tr>
            <tr height="20">
                <td>25.</td>
                <td >Riwayat Penyakit</td>
                <td colspan="2">:
                    <?=$row_siswa['kesehatan']?></td>
            </tr>
            <tr >
                <td colspan="4" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr align="left" height="30">
                <td colspan="6" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Keterangan Pendidikan Sebelumnya</strong></font>
                    <hr width="300" style="line-height:1px; border-style:dashed" align="left" /></td>
            </tr>
            <tr height="20">
                <td rowspan="4" bgcolor="#FFFFFF"></td>
                <td>26.</td>
                <td >Asal Sekolah</td>
                <td colspan="2">:
                    <?=$row_siswa['asalsekolah']?></td>
            </tr>
            <tr height="20">
                <td>27.</td>
                <td >No Ijasah</td>
                <td colspan="2">:
                    <?=$row_siswa['noijasah']?>
                </td>
            </tr>
            <tr height="20">
                <td>28.</td>
                <td >Tgl Ijasah</td>
                <td colspan="2">:
                    <?=$row_siswa['tglijasah']?>
                </td>
            </tr>
            <tr height="20">
                <td>29.</td>
                <td >Keterangan</td>
                <td colspan="2">:
                    <?=$row_siswa['ketsekolah']?></td>
            </tr>
            <tr >
                <td colspan="5" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr align="left" height="30">
                <td colspan="6" align="left" bgcolor="#FFFFFF"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Keterangan Orang Tua</strong></font>
                    <hr width="300" style="line-height:1px; border-style:dashed" align="left" /></td>
            </tr>
            <tr height="20">
                <td rowspan="16" bgcolor="#FFFFFF"></td>
                <td bgcolor="#FFFFFF">&nbsp;</td>
                <td><strong>Orang Tua</strong></td>
                <td width="30%"><div align="center"><strong>Ayah</strong></div></td>
                <td><div align="center"><strong>Ibu</strong></div></td>
            </tr>
            <tr height="20">
                <td>30.</td>
                <td >Nama</td>
                <td >:
                    <?=$row_siswa['namaayah']?>
                    <?
                    if ($row_siswa['almayah']==1)
                        echo "&nbsp;(alm)";
                    ?></td>
                <td><?=$row_siswa['namaibu']?>
                    <?
                    if ($row_siswa['almibu']==1)
                        echo "&nbsp;(alm)";
                    ?></td>
            </tr>
            <tr height="20">
                <td>31.</td>
                <td>Status</td>
                <td>:&nbsp;<?=$row_siswa['statusayah']?></td>
                <td><?=$row_siswa['statusibu']?></td>
            </tr>
            <tr height="20">
                <td>32.</td>
                <td>Tempat Lahir</td>
                <td>:&nbsp;<?=$row_siswa['tmplahirayah']?></td>
                <td><?=$row_siswa['tmplahiribu']?></td>
            </tr>
            <tr height="20">
                <td>33.</td>
                <td>Tanggal Lahir</td>
                <td>:&nbsp;<?=$row_siswa['tgllahirayah']?></td>
                <td><?=$row_siswa['tgllahiribu']?></td>
            </tr>
            <tr height="20">
                <td>34.</td>
                <td >Pendidikan</td>
                <td >:&nbsp;<?=$row_siswa['pendidikanayah']?></td>
                <td><?=$row_siswa['pendidikanibu']?></td>
            </tr>
            <tr height="20">
                <td>35.</td>
                <td >Pekerjaan</td>
                <td >:&nbsp;<?=$row_siswa['pekerjaanayah']?></td>
                <td><?=$row_siswa['pekerjaanibu']?></td>
            </tr>
            <tr height="20">
                <td>36.</td>
                <td >Penghasilan</td>
                <td >:&nbsp;<? if ($row_siswa['penghasilanayah']!=0) { echo FormatRupiah($row_siswa['penghasilanayah']); } ?></td>
                <td><? if ($row_siswa['penghasilanibu']!=0) { echo FormatRupiah($row_siswa['penghasilanibu']); } ?></td>
            </tr>
            <tr height="20">
                <td>37.</td>
                <td >Email Orang Tua</td>
                <td >:
                    <?=$row_siswa['emailayah']?></td>
                <td><?=$row_siswa['emailibu']?></td>
            </tr>
            <tr height="20">
                <td>38. </td>
                <td >Nama Wali</td>
                <td colspan="2">:
                    <?=$row_siswa['wali']?></td>
            </tr>
            <tr >
                <td>39.</td>
                <td >Alamat</td>
                <td colspan="2">:
                    <?=$row_siswa['alamatortu']?></td>
            </tr>
            <tr height="20">
                <td>40.</td>
                <td >Telepon</td>
                <td colspan="2">:
                    <?=$row_siswa['telponortu']?></td>
            </tr>
            <tr height="20">
                <td>41.</td>
                <td >Handphone #1</td>
                <td colspan="2">:
                    <?=$row_siswa['hportu']?></td>
            </tr>
            <tr height="20">
                <td>42.</td>
                <td >Handphone #2</td>
                <td colspan="2">:
                    <?=$row_siswa['info1']?></td>
            </tr>
            <tr height="20">
                <td>43.</td>
                <td >Handphone #3</td>
                <td colspan="2">:
                    <?=$row_siswa['info2']?></td>
            </tr>
            <tr height="20">
                <td bgcolor="#FFFFFF" >&nbsp;</td>
            </tr>
            <tr height="30" align="left">
                <td colspan="7" bgcolor="#FFFFFF"><div align="left"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Keterangan Lainnya</strong></font> </div>            <hr width="300" style="line-height:1px; border-style:dashed" align="left" /></td>
            </tr>
            <tr height="20">
                <td rowspan="3" bgcolor="#FFFFFF"></td>
                <td>44.</td>
                <td>Hobi</td>
                <td colspan="2">:
                    <?=$row_siswa['hobi']?></td>
            </tr>
            <tr height="20">
                <td>45.</td>
                <td>Alamat Surat</td>
                <td colspan="2">:
                    <?=$row_siswa['alamatsurat']?></td>
            </tr>
            <tr height="20">
                <td>46.</td>
                <td >Keterangan</td>
                <td colspan="2">:
                    <?=$row_siswa['keterangan']?></td>
            </tr>
<?php
$no = $row_siswa['nopendaftaran'];

$sql = "SELECT ds.replid, ds.idtambahan, td.kolom, ds.jenis, ds.teks, ds.filename 
          FROM tambahandatacalon ds, tambahandata td
         WHERE ds.idtambahan = td.replid
           AND ds.nopendaftaran = '$no'
         ORDER BY td.urutan  ";

$res = QueryDb($sql);
$ntambahandata = mysqli_num_rows($res);

if ($ntambahandata > 0)
{
            ?>
            <tr height="20">
                <td bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr height="30" align="left">
                <td colspan="7" bgcolor="#FFFFFF">
                    <div align="left">
                        <font size="3" face="Verdana, Arial, Helvetica, sans-serif"
                              style="background-color:#ffcc66">&nbsp;</font>&nbsp;
                        <font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="Gray"><strong>Tambahan Data</strong></font>
                    </div>
                    <hr width="300" style="line-height:1px; border-style:dashed" align="left"/>
                </td>
            </tr>
<?php
            $no = 46;
            $first = true;
            while ($row = mysqli_fetch_array($res)) {
                $no += 1;
                $replid = $row['replid'];
                $kolom = $row['kolom'];
                $jenis = $row['jenis'];

                if ($jenis == 1 || $jenis == 3) {
                    $data = $row['teks'];
                } else {
                    $filename = $row['filename'];
                    $data = "<a href='detail_calon_file.php?replid=$replid'>$filename</a>";
                }

                $rowspan = "";
                if ($first) {
                    $rowspan = "<td rowspan='$ntambahandata' bgcolor='#FFFFFF'></td>";
                    $first = false;
                }
                ?>
                <tr height="20">
                    <?= $rowspan ?>
                    <td><?= $no ?>.</td>
                    <td><?= $kolom ?></td>
                    <td colspan="2">:
                        <?= $data ?></td>
                </tr>
        <?
            }
}
?>
        </table>
        <script language='JavaScript'>
            Tables('table', 0, 0);
        </script>
    </td>
</tr>
</table>

</body>
</html>
<?php
CloseDb();
?>