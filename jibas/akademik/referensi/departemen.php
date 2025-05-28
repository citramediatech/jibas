<?php
require_once('../include/sessioninfo.php');
require_once('../include/db_functions.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../cek.php');

OpenDb();

$op = $_REQUEST['op'] ?? "";

if ($op == "dw8dxn8w9ms8zs22") {
    $newaktif = $_REQUEST['newaktif'];
    $replid = $_REQUEST['replid'];
    $sql = "UPDATE departemen SET aktif = '$newaktif' WHERE replid = '$replid'";
    QueryDb($sql);
} elseif ($op == "xm8r389xemx23xb2378e23") {
    $replid = $_REQUEST['replid'];
    $sql = "DELETE FROM jbsakad.departemen WHERE replid = '$replid'";
    QueryDb($sql);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Departemen</title>
    <meta charset="utf-8" />
    <meta http-equiv="pragma" content="no-cache" />
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <link rel="stylesheet" type="text/css" href="../style/tooltips.css">
    <script src="../script/tooltips.js"></script>
    <script src="../script/tables.js"></script>
    <script src="../script/tools.js"></script>
    <script>
    function tambah() {
        newWindow('departemen_add.php', 'TambahDepartemen', '505', '308', 'resizable=1,scrollbars=1,status=0,toolbar=0');
    }

    function refresh() {
        location.href = "departemen.php";
    }

    function setaktif(replid, aktif) {
        let msg = aktif == 1 ?
            "Apakah anda yakin akan mengubah departemen ini menjadi TIDAK AKTIF?" :
            "Apakah anda yakin akan mengubah departemen ini menjadi AKTIF?";
        let newaktif = aktif == 1 ? 0 : 1;

        if (confirm(msg)) {
            location.href = `departemen.php?op=dw8dxn8w9ms8zs22&replid=${replid}&newaktif=${newaktif}`;
        }
    }

    function edit(replid) {
        newWindow(`departemen_edit.php?replid=${replid}`, 'UbahDepartemen', '505', '308', 'resizable=1,scrollbars=1,status=0,toolbar=0');
    }

    function hapus(replid) {
        if (confirm("Apakah anda yakin akan menghapus departemen ini?")) {
            location.href = `departemen.php?op=xm8r389xemx23xb2378e23&replid=${replid}`;
        }
    }

    function cetak() {
        newWindow('departemen_cetak.php', 'CetakDepartemen', '790', '650', 'resizable=1,scrollbars=1,status=0,toolbar=0');
    }
    </script>
</head>
<body>
<table width="100%" height="100%" border="0">
<tr>
    <td align="center" valign="top" background="../images/b_departemen.png" style="background-repeat:no-repeat;">
    <table width="100%" align="center">
        <tr height="300">
            <td valign="top">

                <table width="95%" align="center">
                    <tr>
                        <td align="right"><font size="4" color="gray"><b>Departemen</b></font></td>
                    </tr>
                    <tr>
                        <td align="right">
                            <a href="../referensi.php" target="content"><font size="1"><b>Referensi</b></font></a> &gt;
                            <font size="1"><b>Departemen</b></font>
                        </td>
                    </tr>
                </table><br /><br />

                <table width="95%" align="center">
                    <tr>
                        <td align="right">
                            <a href="#" onclick="refresh()"><img src="../images/ico/refresh.png" border="0" /> Refresh</a>&nbsp;&nbsp;
                            <a href="javascript:cetak()"><img src="../images/ico/print.png" border="0" /> Cetak</a>&nbsp;&nbsp;
                            <?php if (SI_USER_LEVEL() != $SI_USER_STAFF): ?>
                                <a href="javascript:tambah()"><img src="../images/ico/tambah.png" border="0" /> Tambah Departemen</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table><br />

                <table class="tab" id="table" width="95%" align="center" border="1" style="border-collapse:collapse" bordercolor="#000000">
                    <tr height="30">
                        <th>No</th>
                        <th>Kode Departemen</th>
                        <th>Nama Lembaga</th>
                        <th>Kepala Sekolah</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                <?php
                $no = 0;
                $query = "SELECT * FROM jbsakad.departemen ORDER BY replid";
                $res = QueryDb($query);

                if (mysqli_num_rows($res) > 0) {
                    while ($data = mysqli_fetch_array($res)) {
                        $no++;

                        // Kepala sekolah
                        $namaKepsek = '-';
                        if ($data['nipkepsek'] != "") {
                            $sqlKepsek = "SELECT nama FROM jbssdm.pegawai WHERE nip = '" . $data['nipkepsek'] . "'";
                            $resKepsek = QueryDb($sqlKepsek);
                            if (mysqli_num_rows($resKepsek) > 0) {
                                $rowKepsek = mysqli_fetch_assoc($resKepsek);
                                $namaKepsek = $rowKepsek['nama'];
                            }
                        }

                        // Nama lembaga
                        $namaLembaga = '-';
                        $sqlLembaga = "SELECT nama FROM jbsumum.identitas WHERE id_departemen = '" . $data['replid'] . "'";
                        $resLembaga = QueryDb($sqlLembaga);
                        if (mysqli_num_rows($resLembaga) > 0) {
                            $rowLembaga = mysqli_fetch_assoc($resLembaga);
                            $namaLembaga = $rowLembaga['nama'];
                        }

                        echo "<tr height='25'>
                            <td align='center'>{$no}</td>
                            <td>{$data['departemen']}</td>
                            <td>{$namaLembaga}</td>
                            <td>{$namaKepsek}</td>
                            <td>{$data['keterangan']}</td>
                            <td align='center'>
                                <a href=\"javascript:setaktif({$data['replid']}, {$data['aktif']})\">
                                    <img src=\"../images/ico/" . ($data['aktif'] == 1 ? 'aktif' : 'nonaktif') . ".png\" />
                                </a>
                            </td>
                            <td align='center'>
                                <a href=\"javascript:edit({$data['replid']})\"><img src=\"../images/ico/ubah.png\" /></a>&nbsp;
                                <a href=\"javascript:hapus({$data['replid']})\"><img src=\"../images/ico/hapus.png\" /></a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' align='center' height='250'>
                        <font color='red'><b>Tidak ditemukan adanya data.</b></font><br />";
                    if (SI_USER_LEVEL() != $SI_USER_STAFF) {
                        echo "Klik <a href='javascript:tambah()'><font color='green'>di sini</font></a> untuk mengisi data baru.";
                    }
                    echo "</td></tr>";
                }
                ?>
                </table>

                <script>Tables('table', 1, 0);</script>

            </td>
        </tr>
    </table>
    </td>
</tr>
</table>
</body>
</html>
<?php CloseDb(); ?>
