<?php
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/theme.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../cek.php');

$departemen = isset($_GET['departemen']) ? CQ($_GET['departemen']) : '';

OpenDb();
$sqlDept = "SELECT * FROM jbsakad.departemen WHERE departemen = '$departemen'";
$resultDept = QueryDb($sqlDept);
$dbDepartemen = mysqli_fetch_array($resultDept);
$idDepartemen = $dbDepartemen['replid'];

$sqlIdentitas = "SELECT * FROM jbsumum.identitas WHERE id_departemen = '$idDepartemen'";
$resultIdentitas = QueryDb($sqlIdentitas);
$dbUmum = mysqli_fetch_array($resultIdentitas);
CloseDb();

$nama = $dbUmum['nama'] ?? '';
$situs = $dbUmum['situs'] ?? '';
$email = $dbUmum['email'] ?? '';
$alamat1 = $dbUmum['alamat1'] ?? '';
$alamat2 = $dbUmum['alamat2'] ?? '';
$tlp1 = $dbUmum['telp1'] ?? '';
$tlp2 = $dbUmum['telp2'] ?? '';
$tlp3 = $dbUmum['telp3'] ?? '';
$tlp4 = $dbUmum['telp4'] ?? '';
$fax1 = $dbUmum['fax1'] ?? '';
$fax2 = $dbUmum['fax2'] ?? '';

$title = ($departemen == 'yayasan') ? '' : 'Sekolah';

if (isset($_POST['Simpan'])) {
    $idDepartemen = CQ($_POST['id_departemen']);
    $nama = CQ($_POST['nama']);
    $situs = CQ($_POST['situs']);
    $email = CQ($_POST['email']);
    $alamat1 = CQ($_POST['alamat1']);
    $alamat2 = CQ($_POST['alamat2']);
    $tlp1 = CQ($_POST['tlp1']);
    $tlp2 = CQ($_POST['tlp2']);
    $tlp3 = CQ($_POST['tlp3']);
    $tlp4 = CQ($_POST['tlp4']);
    $fax1 = CQ($_POST['fax1']);
    $fax2 = CQ($_POST['fax2']);

    OpenDb();
    $sqlCek = "SELECT replid FROM jbsumum.identitas WHERE id_departemen = '$idDepartemen'";
    $resultCek = QueryDb($sqlCek);

    if (mysqli_num_rows($resultCek) > 0) {
        $sql = "UPDATE jbsumum.identitas SET nama='$nama', situs='$situs', email='$email', alamat1='$alamat1', alamat2='$alamat2', telp1='$tlp1', telp2='$tlp2', telp3='$tlp3', telp4='$tlp4', fax1='$fax1', fax2='$fax2' WHERE id_departemen = '$idDepartemen'";
    } else {
        $sql = "INSERT INTO jbsumum.identitas (id_departemen, nama, situs, email, alamat1, alamat2, telp1, telp2, telp3, telp4, fax1, fax2) VALUES ('$idDepartemen', '$nama', '$situs', '$email', '$alamat1', '$alamat2', '$tlp1', '$tlp2', '$tlp3', '$tlp4', '$fax1', '$fax2')";
    }

    $result = QueryDb($sql);
    CloseDb();

    if ($result) {
        echo "<script>opener.getfresh(); window.close();</script>";
        exit;
    } else {
        $ERROR_MSG = "Gagal menyimpan data identitas.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Input Identitas <?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../style/style.css">
<script src="../script/tools.js"></script>
<script src="../script/validasi.js"></script>
<script>
function validate() {
    return validateEmptyText('nama', 'Nama <?=$title?>') && cekEmail();
}

function cekEmail() {
    if (!validateEmail("email")) {
        alert("Email yang Anda masukkan bukan merupakan alamat email!");
        document.getElementById('email').focus();
        return false;
    }
    return true;
}

function focusNext(elemName, evt) {
    evt = evt || event;
    if (evt.keyCode === 13) {
        document.getElementById(elemName).focus();
        return false;
    }
    return true;
}

function panggil(elem) {
    const fields = ['nama','alamat1','alamat2','tlp1','tlp2','tlp3','tlp4','fax1','fax2','situs','email'];
    for (let i = 0; i < fields.length; i++) {
        document.getElementById(fields[i]).style.background = (fields[i] == elem) ? '#4cff15' : '#FFFFFF';
    }
}
</script>
</head>
<body onload="document.getElementById('nama').focus();" style="background-color:#dcdfc4">
<form name="main" method="post" onsubmit="return validate()">
<input type="hidden" name="id_departemen" value="<?=$idDepartemen?>">
<input type="hidden" name="departemen" value="<?=$departemen?>">

<table width="95%" align="center">
<tr><td colspan="2"><h3>Identitas <?=$title?></h3></td></tr>
<tr>
    <td width="120"><strong>Nama</strong></td>
    <td><input type="text" name="nama" id="nama" size="80" maxlength="250" value="<?=$nama?>" onkeypress="return focusNext('alamat1', event)" onfocus="panggil('nama')"></td>
</tr>
<tr>
    <td colspan="2">
        <fieldset><legend><b>Lokasi 1</b></legend>
        Alamat:<br><textarea name="alamat1" id="alamat1" rows="3" cols="80" onkeypress="return focusNext('tlp1', event)" onfocus="panggil('alamat1')"><?=$alamat1?></textarea><br>
        Telp 1: <input type="text" name="tlp1" id="tlp1" value="<?=$tlp1?>" onkeypress="return focusNext('tlp2', event)" onfocus="panggil('tlp1')">
        Telp 2: <input type="text" name="tlp2" id="tlp2" value="<?=$tlp2?>" onkeypress="return focusNext('fax1', event)" onfocus="panggil('tlp2')">
        Fax: <input type="text" name="fax1" id="fax1" value="<?=$fax1?>" onkeypress="return focusNext('alamat2', event)" onfocus="panggil('fax1')">
        </fieldset>
    </td>
</tr>
<tr>
    <td colspan="2">
        <fieldset><legend><b>Lokasi 2</b></legend>
        Alamat:<br><textarea name="alamat2" id="alamat2" rows="3" cols="80" onkeypress="return focusNext('tlp3', event)" onfocus="panggil('alamat2')"><?=$alamat2?></textarea><br>
        Telp 1: <input type="text" name="tlp3" id="tlp3" value="<?=$tlp3?>" onkeypress="return focusNext('tlp4', event)" onfocus="panggil('tlp3')">
        Telp 2: <input type="text" name="tlp4" id="tlp4" value="<?=$tlp4?>" onkeypress="return focusNext('fax2', event)" onfocus="panggil('tlp4')">
        Fax: <input type="text" name="fax2" id="fax2" value="<?=$fax2?>" onkeypress="return focusNext('situs', event)" onfocus="panggil('fax2')">
        </fieldset>
    </td>
</tr>
<tr>
    <td>Website</td>
    <td><input type="text" name="situs" id="situs" size="80" value="<?=$situs?>" onkeypress="return focusNext('email', event)" onfocus="panggil('situs')"></td>
</tr>
<tr>
    <td>Email</td>
    <td><input type="text" name="email" id="email" size="80" value="<?=$email?>" onkeypress="return focusNext('Simpan', event)" onfocus="panggil('email')"></td>
</tr>
<tr>
    <td colspan="2" align="center">
        <input type="submit" name="Simpan" value="Simpan" class="but" onfocus="panggil('Simpan')">
        <input type="button" value="Tutup" class="but" onclick="window.close()">
    </td>
</tr>
</table>
</form>

<?php if (isset($ERROR_MSG) && strlen($ERROR_MSG) > 0) { ?>
<script>alert('<?=$ERROR_MSG?>');</script>
<?php } ?>
</body>
</html>
