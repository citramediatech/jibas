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
$departemen = $_REQUEST["departemen"];
$idPelajaran = $_REQUEST["idPelajaran"];
$idChannel = $_REQUEST["idChannel"];
$idModul = $_REQUEST["idModul"];
?>
<script type="text/javascript">
acceptInfo = function(idMedia, urutan, keterangan)
{
    opener.acceptInfo(idMedia, urutan, keterangan);
};
</script>
<frameset rows="100,*" border="0" frameborder="yes" framespacing="yes">
    <frame src="media.browse.header.php?departemen=<?=$departemen?>&idPelajaran=<?=$idPelajaran?>&idChannel=<?=$idChannel?>&idModul=<?=$idModul?>" name="header" id="header" scrolling="no" style="border:1px; border-bottom-color:#000000; border-bottom-style:solid">
    <frame src="media.browse.blank.php" name="content" id="content">
</frameset><noframes></noframes>