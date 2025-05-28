
<?php
$departemen = $_REQUEST['departemen'];
$title = "Sekolah";
if ($departemen=='yayasan')
	$title = "";
if (isset($_REQUEST['Simpan'])) {
	OpenDb();
		$sql1="SELECT * FROM jbsumum.identitas WHERE jbsakad.departemen='$departemen'";
		$result1=QueryDb($sql1);
		$row1 = mysqli_fetch_array($result1);
        $idDepartemen = CQ (['id_departemen']);
		$nama = CQ($_REQUEST['nama']);
		$situs = CQ($_REQUEST['situs']);
		$email = CQ($_REQUEST['email']);
		$alamat1 = CQ($_REQUEST['alamat1']);
		$alamat2 = CQ($_REQUEST['alamat2']);
		$tlp1 = CQ($_REQUEST['tlp1']);
		$tlp2 = CQ($_REQUEST['tlp2']);
		$tlp3 = CQ($_REQUEST['tlp3']);
		$tlp4 = CQ($_REQUEST['tlp4']);
		$fax1 = CQ($_REQUEST['fax1']);
		$fax2 = CQ($_REQUEST['fax2']);
		if (mysqli_num_rows($result1) > 0) {
			$sql = "UPDATE jbsumum.identitas SET id_departemen='$idDepartemen',nama='$nama', situs='$situs', email='$email', alamat1='$alamat1', alamat2='$alamat2', telp1='$tlp1', telp2='$tlp2', telp3='$tlp3', telp4='$tlp4', fax1='$fax1', fax2='$fax2' WHERE departemen = '$departemen'";
		} else {
			$sql = "INSERT INTO jbsumum.identitas SET id_departemen='$idDepartemen',nama='$nama', situs='$situs', email='$email', alamat1='$alamat1', alamat2='$alamat2', telp1='$tlp1', telp2='$tlp2', telp3='$tlp3', telp4='$tlp4', fax1='$fax1', fax2='$fax2', departemen='$departemen'";
		}
		//echo $sql; exit;
		$result = QueryDb($sql);
		CloseDb();			
		if ($result) { 	
		?>
			<script language="javascript">				
				opener.getfresh();
				window.close();
			</script>
<?		}
}