<?php
/**
 * JIBAS Education Community
 * Jaringan Informasi Bersama Antar Sekolah
 * @version: 32.0 (Feb 05, 2025)
 */

require_once("../include/theme.php");
require_once('../include/errorhandler.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../cek.php');

OpenDb();

$departemen = isset($_REQUEST['departemen']) ? $_REQUEST['departemen'] : '';
$id_lembaga = isset($_REQUEST['id_lembaga']) ? $_REQUEST['id_lembaga'] : '';
$nip = isset($_REQUEST['nip']) ? $_REQUEST['nip'] : '';

// Cek apakah user sudah punya login
$nip_escaped = mysqli_real_escape_string($GLOBALS['db_link'], $nip);

$sql_cek = "SELECT * FROM jbsuser.login WHERE login = '$nip_escaped'";
$res_cek = QueryDb($sql_cek);
$jum_cek = mysqli_num_rows($res_cek);

$query_cek2 = "SELECT * FROM jbsuser.hakakses WHERE login = '$nip_escaped' AND modul='SIMAKA'";
$result_cek2 = QueryDb($query_cek2);
$num_cek2 = mysqli_num_rows($result_cek2);
$row_cek2 = ($num_cek2 > 0) ? mysqli_fetch_array($result_cek2) : [];

$status_user = isset($row_cek2['tingkat']) ? $row_cek2['tingkat'] : '';
$keterangan = isset($row_cek2['keterangan']) ? $row_cek2['keterangan'] : '';
$dis = ($jum_cek > 0) ? "disabled='disabled' class='disabled' value='*******'" : '';
$dd1 = ($status_user == 1) ? "disabled" : "";


if (isset($_REQUEST['simpan'])) {
	OpenDb();
	$tingkat = $_REQUEST['status_user'];
	$pass=md5($_REQUEST['password']);
	
	$sql_dep = "AND departemen = '$_REQUEST[departemen]'";
	if ($_REQUEST['status_user'] == "" || $_REQUEST['status_user'] == 1) {
		$tingkat = 1;
		$sql_dep = "";	
	}	
	
  	//cek apakah sudah ada account yang sama di SIMAKA
	$query_c = "SELECT * FROM jbsuser.hakakses WHERE login = '$_REQUEST[nip]' AND tingkat = $tingkat AND modul = 'SIMAKA' $sql_dep";
	$result_c = QueryDb($query_c);
    $num_c = @mysqli_num_rows($result_c);
	
	$query_cek = "SELECT * FROM jbsuser.login WHERE login = '$_REQUEST[nip]'";
	$result_cek = QueryDb($query_cek);
    $num_cek = @mysqli_num_rows($result_cek);
	
	
		
	BeginTrans();
	$success=1;	
	
	if ($num_c == 0) {
		if ($tingkat==1){
			//Kalo manajer
			if ($num_cek == 0) {
				$sql_login="INSERT INTO jbsuser.login SET  login='$_REQUEST[nip]', password='$pass',  id_lembaga='$_REQUEST[id_lembaga]',aktif=1";
				QueryDbTrans($sql_login, $success);		
			}		
				
			$sql_hakakses="INSERT INTO jbsuser.hakakses SET  login='$_REQUEST[nip]', id_lembaga='$_REQUEST[id_lembaga]', tingkat=1, modul='SIMAKA', keterangan='".CQ($_REQUEST['keterangan'])."'";
		} elseif ($tingkat==2){
			//Kalo staf
			if ($num_cek == 0) {
				$sql_login="INSERT INTO jbsuser.login SET  login='$_REQUEST[nip]', password='$pass',id_lembaga='$_REQUEST[id_lembaga]', aktif=1";
				QueryDbTrans($sql_login, $success);		
			}			
			
			$sql_hakakses="INSERT INTO jbsuser.hakakses SET login='$_REQUEST[nip]', id_lembaga='$_REQUEST[id_lembaga]', departemen='$_REQUEST[departemen]', tingkat=2, modul='SIMAKA', keterangan='".CQ($_REQUEST['keterangan'])."'";
		}
		if ($success)	
			QueryDbTrans($sql_hakakses, $success);
	}
	
	
	
	if ($success){	
		CommitTrans();
		?>
		<script language="javascript">
			parent.opener.refresh();
			window.close();
		</script>
		<?
	} else {
		RollbackTrans();
		CloseDb();
	}
}

$input_awal = "onload=\"document.getElementById('password').focus()\"";
if (isset($_REQUEST['status_user']) || $jum_cek > 0) {
	$input_awal = "onload=\"document.getElementById('status_user').focus()\"";
	$status_user = $_REQUEST['status_user'];
} 

if($status_user == 1 || $status_user == "") {
	$dd = "disabled";
	$fokus = "onKeyPress=\"return focusNext('keterangan', event)\"";
} else {
	$dd = "";
	$departemen=$row_cek2['departemen'];
	$fokus = "onKeyPress=\"return focusNext('tt', event)\"";
}

if (isset($_REQUEST['keterangan']))
	$keterangan = $_REQUEST['keterangan'];
?>

<html>
<head>
<title>JIBAS SIMAKA [Tambah Pengguna]</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="JavaScript">

function cek_form() {
	var nip = document.tambah_user.nip.value;
	var dep = document.tambah_user.departemen.value;
	var stat = document.tambah_user.status_user.value;
	var pass = document.tambah_user.password.value;
	var kon = document.tambah_user.konfirmasi.value;
	var ket = document.tambah_user.keterangan.value;
	
	if (nip.length == 0) {
		alert("User tidak boleh kosong");
		return false;
	}

	if (pass.length == 0) {
		alert("Password tidak boleh kosong!");
		document.tambah_user.password.focus();
		return false;
	} else if (kon.length == 0) {
		alert("Konfirmasi tidak boleh kosong!");
		document.tambah_user.konfirmasi.focus();
		return false;
	}
	
	if (pass != kon) {
		alert("Password dan konfirmasi harus sama!");
		document.tambah_user.konfirmasi.focus();
		return false;
	}

	if (stat.length == 0) {
		alert("Tingkat tidak boleh kosong!");
		document.tambah_user.status_user.focus();
		return false;
	}
	
	if (stat != 1) {
		if (dep.length==0) {
		alert("Departemen tidak boleh kosong!");
		document.tambah_user.departemen.focus();
		return false;
		}
	}
	
	if (ket.length > 255) {
		alert("Keterangan tidak boleh lebih dari 255 karakter!");
		document.tambah_user.keterangan.focus();
		return false;
	}
}

function caripegawai() {
	//newWindow('../library/caripegawai.php?flag=0', 'CariPegawai','600','565','resizable=1,scrollbars=1,status=0,toolbar=0');
	newWindow('../library/pegawai.php?flag=0','CariPegawai','600','618','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function acceptPegawai(nip, nama, flag) {
	var dep = document.tambah_user.departemen.value;
	document.location.href = "../user/user_add.php?nip="+nip+"&departemen="+dep+"&nama="+nama;	
}

function change_tingkat() {
	var tin = document.tambah_user.status_user.value;
	var nip = document.tambah_user.nip.value;
	var nama = document.tambah_user.nama.value;
	var dep = document.tambah_user.departemen.value;
	var pass = document.tambah_user.password.value;
	var kon = document.tambah_user.konfirmasi.value;
	var keterangan = document.tambah_user.keterangan.value;
	
	if(tin == 1) {
		document.tambah_user.tt.disabled = true;
	} else {
		document.tambah_user.tt.disabled = false;
	}
	
	document.location.href ="user_add.php?nip="+nip+"&nama="+nama+"&departemen="+dep+"&status_user="+tin+"&password="+pass+"&konfirmasi="+kon+"&keterangan="+keterangan;
}

function focusNext(elemName, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13) {
		document.getElementById(elemName).focus();
		return false;
    } 
    return true;
}

function panggil(elem){
	var lain = new Array('password','konfirmasi','tt','status_user','keterangan');
	var dis = document.tambah_user.password.disabled;
	for (i=0;i<lain.length;i++) {
		if (lain[i] == elem) {
			document.getElementById(elem).style.background='#4cff15';
		} else {
			if (dis) {
				document.getElementById(lain[0]).style.background='#c0c0c0';
				document.getElementById(lain[1]).style.background='#c0c0c0';
			} 
			document.getElementById(lain[i]).style.background='#FFFFFF';
			
		}
	}
}

</script>
</head>
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="background-color:#dcdfc4" <?=$input_awal?>>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr height="58">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_01.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_02a.jpg">&nbsp;</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_03.jpg">&nbsp;</td>
</tr>
<tr height="150">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_04a.jpg">&nbsp;</td>
    <td width="0" style="background-color:#FFFFFF">
    <!-- CONTENT GOES HERE //--->
<form action="user_add.php" method="post" name="tambah_user" onSubmit="return cek_form()">
<table border="0" width="95%" cellpadding="2" cellspacing="2" align="center">
<!-- TABLE CONTENT -->
<tr height="25">
	<td height="25" colspan="3" class="header" align="center">Tambah Pengguna</td>
</tr>
<tr>
    <td width="20%"><strong>Login</strong></td>

    <td><input type="text" size="10" name="nip1" readonly value="<?=$_REQUEST['nip'] ?>" class="disabled" onClick="caripegawai()">&nbsp;<input type="text" size="30" name="nama1" readonly value="<?=$_REQUEST['nama']?>" class="disabled" onClick="caripegawai()">
    	<input type="hidden" name="nip" id="nip" value="<?=$_REQUEST['nip']?>">
        <input type="hidden" name="nama" id="nama" value="<?=$_REQUEST['nama']?>"><a href="#" onClick="caripegawai()"><img src="../images/ico/cari.png" border="0" onMouseOver="showhint('Cari pegawai',this, event, '100px')"></a>
    </td>
</tr>
<tr>
    <td><strong>Password</strong></td>
    <td><input type="password" size="25" maxlength="100" name="password" <?=$dis ?> id="password" onKeyPress="return focusNext('konfirmasi', event)" onFocus="panggil('password')" value="<?=$_REQUEST['password']?>"></td>
</tr>
<tr>
    <td><strong>Konfirmasi</strong></td>
    <td><input type="password" size="25" maxlength="100" name="konfirmasi" <?=$dis ?> id="konfirmasi" onKeyPress="return focusNext('status_user', event)" onFocus="panggil('konfirmasi')" value="<?=$_REQUEST['konfirmasi']?>" ></td>
</tr>
<tr>
	<td><strong>Tingkat</strong></td>
    <td><select name="status_user" id="status_user" style="width:165px" onChange="change_tingkat();" onFocus="panggil('status_user')" <?=$fokus.' '.$dd1?>>
            <option value="1"
                <?
                    if ($status_user==1)
                    echo "selected";
                    ?>
                >Manajer Akademik</option>
                <option value="2"
                <?
                    if ($status_user==2)
                    echo "selected";
                    ?>
                >Staf Akademik</option>
    	</select>
	</td>
</tr>
<tr>
<td><input type="text" name="id_departemen" value="<?=$id_departemen;?>"></td>	
</tr>
<tr>
    <td><strong>Departemen</strong></td>
	
    <td><select name="departemen" style="width:165px;" id="tt" <?=$dd ?> onKeyPress="return focusNext('keterangan', event)" onFocus="panggil('tt')">
    <?  if ($status_user == 1 || $status_user == ""){	
    		echo "<option value='' selected='selected'>Semua</option>";
    	}
		OpenDb();
		$query_pro = "SELECT departemen FROM jbsakad.departemen WHERE aktif=1 ORDER BY urutan ASC";
		$result_pro = QueryDb($query_pro);
	
		$i = 0;
		while($row_pro = @mysqli_fetch_array($result_pro)) {
			if($departemen == "") {
				$departemen = $row_pro['departemen'];
				if ($status_user == 1 || $status_user == "")
					$sel[$i] = "";
				else
					$sel[$i] = "selected";
			} elseif ($departemen == $row_pro['departemen']) {
				if ($status_user == 1 || $status_user == "")
					$sel[$i] = "";
				else
					$sel[$i] = "selected";
			} else {
				$sel[$i] = "";
			}
			echo "<option value='$row_pro[departemen]' $sel[$i]>$row_pro[departemen]";
			$i++;
		}
	?>
    	</option></select></td>
</tr>
<tr>
    <td valign="top">Keterangan</td>
    <td><textarea wrap="soft" name="keterangan" id="keterangan" cols="47" rows="3" onFocus="panggil('keterangan')" onKeyPress="return focusNext('simpan', event)"><?=$keterangan?></textarea></td>
</tr>
<tr>
    <td colspan="2" align="center">
   		<input type="submit" value="Simpan" name="simpan" id="simpan" class="but" onFocus="panggil('simpan')">&nbsp;
        <input type="button" value="Tutup" name="batal" class="but" onClick="window.close();">
    </td>
</tr>
</table>
</form>
    </td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_06a.jpg">&nbsp;</td>
</tr>
<tr height="28">
	<td width="28" background="../<?=GetThemeDir() ?>bgpop_07.jpg">&nbsp;</td>
    <td width="*" background="../<?=GetThemeDir() ?>bgpop_08a.jpg">&nbsp;</td>
    <td width="28" background="../<?=GetThemeDir() ?>bgpop_09.jpg">&nbsp;</td>
</tr>
</table>
</body>
</html>
<?
CloseDb();
?>