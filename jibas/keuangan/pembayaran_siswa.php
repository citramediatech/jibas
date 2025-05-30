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
$idtahunbuku = $_REQUEST['idtahunbuku'];
$idkategori = $_REQUEST['idkategori'];
$idpenerimaan = $_REQUEST['idpenerimaan'];
$departemen = $_REQUEST['departemen'];

$status = "";
if ($idkategori == "CSWJB" || $idkategori == "CSSKR") 
	$status = "Calon"

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<link href="script/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="script/SpryTabbedPanels.js" type="text/javascript"></script>
<script language="JavaScript" src="script/tables.js"></script>
<script src="script/SpryValidationTextField.js" type="text/javascript"></script>
<link href="script/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="script/SpryValidationSelect.js" type="text/javascript"></script>
<link href="script/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="script/ajax.js" type="text/javascript"></script>
<script src="script/jquery-1.9.0.js" type="text/javascript"></script>
<script language="javascript">

function pilih(id) {	
	parent.content.location.href = "pembayaran_decide.php?id="+id+"&idkategori=<?=$idkategori?>&idpenerimaan=<?=$idpenerimaan?>&idtahunbuku=<?=$idtahunbuku?>&status=<?=$status?>";		
}

function scanBarcode(e)
{
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode != 13)
        return;

    var kode = $.trim($('#txBarcode').val());
    if (kode.length == 0)
        return;

    var data = "idkategori=<?=$idkategori?>&departemen=<?=$departemen?>&kode=" + kode;

    $('#spScanInfo').html("");

    $.ajax({
        url: "library/scanbarcode.ajax.php",
        type: 'GET',
        data: data,
        success: function (response)
        {
            $('#txBarcode').val('');

            var data = $.parseJSON(response);
            if (data.status == "1")
            {
                parent.content.location.href = "pembayaran_decide.php?id="+data.userid+"&idkategori=<?=$idkategori?>&idpenerimaan=<?=$idpenerimaan?>&idtahunbuku=<?=$idtahunbuku?>&status=<?=$status?>";
            }
            else
            {
                $('#spScanInfo').html(data.message);
                parent.content.location.href = "blank_pembayaran.php";
            }
        },
        error: function (xhr, response, error)
        {
            alert(xhr.responseText);
        }
    });
}

$( document ).ready(function() {
    setTimeout(function () {
        $('#txBarcode').focus();
    }, 300);

});


</script>
</head>

<body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0" style="background-color:#FFFFFF" onclick="document.getElementById('txBarcode').value = ''">
<input type="hidden" id="idtahunbuku" value="<?=$idtahunbuku ?>" />
<input type="hidden" id="idkategori" value="<?=$idkategori ?>" />
<input type="hidden" id="idpenerimaan" value="<?=$idpenerimaan ?>" />
<input type="hidden" id="status" value="<?=$status ?>" />
<table border="0" width="100%" align="center" cellspacing="2" cellpadding="2">
<tr><td align="left">
 	<table border="0" cellpadding="2" bgcolor="#FFFFFF" cellspacing="0">
    <tr>
        <td align="left">
            <fieldset>
<?
$info = "NIS";
if ($idkategori == "CSWJB" || $idkategori == "CSSKR") $info = "No Calon Siswa";
?>
                <legend><strong>Scan Barcode <?=$info?>:</strong></legend>
            <input name="txBarcode" id="txBarcode" type="text" style="width: 200px; font-size: 18px;"
                   onfocus="this.style.background = '#27d1e5'"
                   onblur="this.style.background = '#FFFFFF'"
                   onkeyup="return scanBarcode(event)">
            <br>
            <span id="spScanInfo" name="spScanInfo" style="color: red"></span>
            <br>
            </fieldset>
            <br>
        </td>
    </tr>
    <tr height="500">
    	<td valign="top" bgcolor="#FFFFFF">
        <div id="TabbedPanels1" class="TabbedPanels">
      		<ul class="TabbedPanelsTabGroup">
            	<li class="TabbedPanelsTab" tabindex="0"><font size="1">Pilih <?=$status?> Siswa</font></li>
            	<li class="TabbedPanelsTab" tabindex="0"><font size="1">Cari <?=$status?> Siswa</font></li>
          	</ul>
      		<div class="TabbedPanelsContentGroup">
                <div class="TabbedPanelsContent" id="panel0"></div>
                <div class="TabbedPanelsContent" id="panel1"></div>
      		</div>
        </div>
		</td>
    </tr>
    </table>
     <!-- END OF CONTENT //--->
    </td>
</tr>
</table>
<script type="text/javascript">

var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var status = document.getElementById('status').value;
if (status == "Calon") { 		
	sendRequestText("library/pilih_calonsiswa.php", show_panel0, "departemen=<?=$departemen?>");
	sendRequestText("library/cari_calonsiswa.php", show_panel1, "departemen=<?=$departemen?>");
} else {
	
	sendRequestText("library/pilih_siswa.php", show_panel0, "departemen=<?=$departemen?>");
	sendRequestText("library/cari_siswa.php", show_panel1, "departemen=<?=$departemen?>");
}

function show_panel0(x) {
	document.getElementById("panel0").innerHTML = x;
	Tables('table', 1, 0);
	if (status == "Calon") {
		//var spryselect1 = new Spry.Widget.ValidationSelect("depart2");
		var spryselect2 = new Spry.Widget.ValidationSelect("proses");
		document.getElementById('proses').focus();
		var spryselect3 = new Spry.Widget.ValidationSelect("kelompok");
	} else {
		var spryselect2 = new Spry.Widget.ValidationSelect("angkatan");
		document.getElementById('angkatan').focus();
		var spryselect3 = new Spry.Widget.ValidationSelect("tingkat");
		var spryselect4 = new Spry.Widget.ValidationSelect("kelas");	
	}
}
		
function show_panel1(x) {
	document.getElementById("panel1").innerHTML = x;
	var sprytextfield1 = new Spry.Widget.ValidationTextField("nama");
	document.getElementById('nama').focus();	
	if (status == "Calon") {
		//var spryselect1 = new Spry.Widget.ValidationSelect("depart3");
		var sprytextfield2 = new Spry.Widget.ValidationTextField("no");
	} else 	{
		//var spryselect1 = new Spry.Widget.ValidationSelect("depart1");
		var sprytextfield2 = new Spry.Widget.ValidationTextField("nis");
	}
}

function show_panel2(x) {
	document.getElementById("panel1").innerHTML = x;
	Tables('table1', 1, 0);
}

function carilah(){
	var nis = document.getElementById('nis').value;
	var nama = document.getElementById('nama').value;
	var departemen = document.getElementById('depart1').value;
	
	if (nis == "" && nama == "") {
		alert ('NIS atau Nama Siswa tidak boleh kosong!');
		document.getElementById("nama").focus();	
		return false;
	}	
	sendRequestText("library/cari_siswa.php", show_panel2, "submit=1&nis="+nis+"&nama="+nama+"&departemen="+departemen);
	parent.content.location.href="blank_pembayaran.php";
	
}

function carilah1(){
	var no = document.getElementById('no').value;
	var nama = document.getElementById('nama').value;
	var departemen = document.getElementById('depart3').value;
	
	if (no == "" && nama == "") {
		alert ('No Pendaftaran atau Nama Calon tidak boleh kosong!');
		document.getElementById("nama").focus();	
		return false;
	}	
	sendRequestText("library/cari_calonsiswa.php", show_panel2, "submit=1&no="+no+"&nama="+nama+"&departemen="+departemen);
	parent.content.location.href="blank_pembayaran.php";
}

/*
function change_departemen(tipe){	
	if (tipe == 0) {
		var departemen = document.getElementById('depart').value;
		sendRequestText("pilih_siswa.php", show_panel0, "departemen="+departemen);	
	} else if (tipe == 1) {
		var departemen = document.getElementById('depart1').value;		
		sendRequestText("cari_siswa.php", show_panel1, "departemen="+departemen);	
	} else if (tipe == 2) {		
		var departemen = document.getElementById('depart2').value;			
		sendRequestText("pilih_calonsiswa.php", show_panel0, "departemen="+departemen);	
	} else if (tipe == 3) {		
		var departemen = document.getElementById('depart3').value;			
		sendRequestText("cari_calonsiswa.php", show_panel1, "departemen="+departemen);	
	}
}
*/
function change(){
	var departemen = document.getElementById('depart').value;
	var angkatan = document.getElementById('angkatan').value;
	var tingkat = document.getElementById('tingkat').value;
	sendRequestText("library/pilih_siswa.php", show_panel0, "departemen="+departemen+"&angkatan="+angkatan+"&tingkat="+tingkat);
	parent.content.location.href="blank_pembayaran.php";	
}

function change_kelas(){
	var departemen = document.getElementById('depart').value;
	var angkatan = document.getElementById('angkatan').value;
	var tingkat = document.getElementById('tingkat').value;
	var kelas = document.getElementById('kelas').value;
	sendRequestText("library/pilih_siswa.php", show_panel0, "departemen="+departemen+"&angkatan="+angkatan+"&tingkat="+tingkat+"&kelas="+kelas);	
	parent.content.location.href="blank_pembayaran.php";
}

function change_proses(){
	var departemen = document.getElementById('depart2').value;
	var proses = document.getElementById('proses').value;
	sendRequestText("library/pilih_calonsiswa.php", show_panel0, "departemen="+departemen+"&proses="+proses);	
	parent.content.location.href="blank_pembayaran.php";
}

function change_kelompok(){
	var departemen = document.getElementById('depart2').value;
	var proses = document.getElementById('proses').value;
	var kelompok = document.getElementById('kelompok').value;
	sendRequestText("library/pilih_calonsiswa.php", show_panel0, "departemen="+departemen+"&proses="+proses+"&kelompok="+kelompok);	
	parent.content.location.href="blank_pembayaran.php";
}


function cari(x) {
	document.getElementById("caritabel").innerHTML = x;		
}

function focusNext(elemName, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode :
        ((evt.which) ? evt.which : evt.keyCode);
    if (charCode == 13) {
		document.getElementById(elemName).focus();
        return false;
    } else {		
		sendRequestText("get_blank.php", cari, "");
	}
    return true;
}

function focusNext1(elemName, evt, st, no, aktif) {
  	evt = (evt) ? evt : event;	
    var charCode = (evt.charCode) ? evt.charCode :
  		((evt.which) ? evt.which : evt.keyCode);
   	if (charCode == 13) {	
		var point = parseInt(no);		
		var mundur = point-1;
		var maju = point+1;
		
		if (aktif == 1) {
			mod = point % 2;
				if (mod != 0 && point != 1) 
					document.getElementById(elemName+st+mundur).style.background = "#E7E7CF";
				else if (mod == 0 && point != 1)
					document.getElementById(elemName+st+mundur).style.background = "#FFFFFF";
			document.getElementById(st+elemName+maju).focus();
			document.getElementById(elemName+st+no).style.background = "#FFFF00";
			
		} else {
			document.getElementById(st+elemName+no).focus();
			document.getElementById(elemName+st+no).style.background = "#FFFF00";
			
		}
		
        return false;
   	} 
	return true;
}

function change_urut(urut,urutan,tipe) {
	if (tipe == "daftar") 	{
		var departemen = document.getElementById('depart').value;
		var angkatan = document.getElementById('angkatan').value;
		var tingkat = document.getElementById('tingkat').value;
		var kelas = document.getElementById('kelas').value;		
		if (urutan =="ASC"){
			urutan="DESC"
		} else {
			urutan="ASC"
		}
		
		sendRequestText("library/pilih_siswa.php", show_panel0, "departemen="+departemen+"&angkatan="+angkatan+"&tingkat="+tingkat+"&kelas="+kelas+"&urut="+urut+"&urutan="+urutan);
	} else if (tipe == "cari") {
		var departemen=document.getElementById("depart1").value;
		var nis=document.getElementById("nis").value;
		var nama=document.getElementById("nama").value;	
		
		if (urutan =="ASC"){
			urutan="DESC"
		} else {
			urutan="ASC"
		}
		
		sendRequestText("library/cari_siswa.php", show_panel2, "submit=1&nis="+nis+"&nama="+nama+"&departemen="+departemen+"&urut1="+urut+"&urutan1="+urutan);
		
	} else if (tipe == "daftarcalon") {		
		var departemen = document.getElementById('depart2').value;
		var proses = document.getElementById('proses').value;
		var kelompok = document.getElementById('kelompok').value;
		
		if (urutan =="ASC"){
			urutan="DESC"
		} else {
			urutan="ASC"
		}
		
		sendRequestText("library/pilih_calonsiswa.php", show_panel0, "departemen="+departemen+"&proses="+proses+"&kelompok="+kelompok+"&urut2="+urut+"&urutan2="+urutan);
		
	} else {		
		var departemen = document.getElementById('depart3').value;
		var no = document.getElementById('no').value;
		var nama = document.getElementById('nama').value;
		
		if (urutan =="ASC"){
			urutan="DESC"
		} else {
			urutan="ASC"
		}
		sendRequestText("library/cari_calonsiswa.php", show_panel2, "submit=1&no="+no+"&nama="+nama+"&departemen="+departemen+"&urut3="+urut+"&urutan3="+urutan);
	
	}
}

</script>
</body>
</html>