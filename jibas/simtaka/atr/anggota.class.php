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
class CAnggota{
	function OnStart(){
		$op=$_REQUEST['op'];
		if ($op=="del"){
			$sql = "DELETE FROM anggota WHERE replid='$_REQUEST[id]'";
			QueryDb($sql);
		}
		if ($op=="nyd6j287sy388s3h8s8"){
			$sql = "UPDATE anggota SET aktif='$_REQUEST[newaktif]' WHERE replid='$_REQUEST[replid]'";
			QueryDb($sql);
		}
	}
	function OnFinish(){
		?>
		<script language='JavaScript'>
			Tables('table', 1, 0);
		</script>
		<?
    }
    function Content(){
		$sql = "SELECT * FROM anggota ORDER BY nama";
		$result = QueryDb($sql);
		$num = @mysqli_num_rows($result);
		?>
		<link href="../sty/style.css" rel="stylesheet" type="text/css">
        <div class="funct">
        	<a href="javascript:getfresh()"><img src="../img/ico/refresh.png" border="0">&nbsp;Refresh</a>&nbsp;&nbsp;
			<a href="javascript:cetak()"><img src="../img/ico/print1.png" border="0">&nbsp;Cetak</a>&nbsp;&nbsp; 
			<a href="javascript:tambah()"><img src="../img/ico/tambah.png" border="0">&nbsp;Tambah&nbsp;Anggota</a>&nbsp;        
		</div>
        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab" id="table">
          <tr>
            <td height="30" align="center" class="header">No. Registrasi</td>
            <td height="30" align="center" class="header">Nama</td>
            <td height="30" align="center" class="header">Email</td>
            <td height="30" align="center" class="header">Telepon</td>
            <td height="30" align="center" class="header">Keterangan</td>
  			   <td align="center" class="header">&nbsp;</td>
            <td height="30" align="center" class="header">&nbsp;</td>
		  </tr>
          <?
		  if ($num>0){
			  while ($row=@mysqli_fetch_array($result)){
			  ?>
			  <tr>
				<td height="25" align="center"><?=stripslashes($row['noregistrasi'])?></td>
				<td height="25" align="center">&nbsp;<?=stripslashes($row['nama'])?></td>
				<td height="25" align="center">&nbsp;<?=stripslashes($row['email'])?></td>
				<td height="25" align="center">&nbsp;<?=stripslashes($row['telpon'])?></td>
				<td height="25" align="center">&nbsp;<?=stripslashes($row['keterangan'])?></td>
				<td align="center">
                	<? if ($row['aktif']==1) { ?>
						<a href="javascript:setaktif(<?=$row['replid']?>,'0')"><img src="../img/ico/aktif.png" width="16" height="16" border="0" /></a>
					<? } else { ?>    
						<a href="javascript:setaktif(<?=$row['replid']?>,'1')"><img src="../img/ico/nonaktif.png" width="16" height="16" border="0" /></a>
					<? } ?>
				</td>
				<td height="25" align="center" bgcolor="#FFFFFF"><a href="javascript:ubah('<?=$row['replid']?>')"><img src="../img/ico/ubah.png" width="16" height="16" border="0"></a>&nbsp;<a href="javascript:hapus('<?=$row['replid']?>')"><img src="../img/ico/hapus.png" border="0"></a></td>
			  </tr>
			  <?
			  }
		  } else {
		  ?>
          <tr>
            <td height="25" colspan="7" align="center" class="nodata">Tidak ada data</td>
          </tr>
		  <?
		  }
		  ?>	
        </table>

        <?
	}
}
?>