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
$idtabungan = $_REQUEST['idtabungan'];
$departemen = $_REQUEST['departemen'];
?>
<frameset border="1" cols="23%,*" frameborder="1">
	<frame name="siswa" src="tabungan.trans.pegawai.php?idtahunbuku=<?=$idtahunbuku?>&idtabungan=<?=$idtabungan?>&departemen=<?=$departemen?>" scrolling="auto"
           style="border-width:1px; border-right-color:#000000; border-right-style:solid"/>
    <frame name="content" src="tabungan.trans.input.blank.php" scrolling="auto" />
</frameset>
<noframes></noframes>