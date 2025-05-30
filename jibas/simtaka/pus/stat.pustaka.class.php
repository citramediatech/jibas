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
class CStat
{
	function OnStart()
	{
		$this->Limit=10;
		if (isset($_REQUEST['Limit']))
			$this->Limit = $_REQUEST['Limit'];
		$this->perpustakaan = $_REQUEST['perpustakaan'];
		$this->BlnAwal = $_REQUEST['BlnAwal'];
		$this->ThnAwal = $_REQUEST['ThnAwal'];
		$this->BlnAkhir = $_REQUEST['BlnAkhir'];
		$this->ThnAkhir = $_REQUEST['ThnAkhir'];
	}
	
	function reload_page()
	{
		?>
		<script language='JavaScript'>
			document.location.href="pustaka.baru.php";
        </script>
		<?
	}
	
	function OnFinish()
	{
		?>
		<script language='JavaScript'>
			Tables('table', 1, 0);
		</script>
		<?
    }
	
	function GetPerpus()
	{
		if (SI_USER_LEVEL()==2)
			$sql = "SELECT replid, nama
					  FROM perpustakaan
					 WHERE replid='".SI_USER_IDPERPUS()."'
					 ORDER BY nama";
		else
			$sql = "SELECT replid, nama
					  FROM perpustakaan
					 ORDER BY nama";
		$result = QueryDb($sql);
		?>
		
		<select name="perpustakaan" id="perpustakaan" class="cmbfrm"  onchange="chg()">
		<?
		if (SI_USER_LEVEL()!=2)
			echo "<option value='-1' ".IntIsSelected('-1',$this->perpustakaan).">(Semua)</option>";
		
		while ($row = @mysqli_fetch_row($result))
		{
			if ($this->perpustakaan=="")
				$this->perpustakaan = $row[0];	?>
			<option value="<?=$row[0]?>" <?=IntIsSelected($row[0],$this->perpustakaan)?>><?=$row[1]?></option>
<?		}	?>
		</select>
		<?
	}
	
    function Content()
	{
		global $G_START_YEAR; ?>
		
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top">
           	<div align="left">
                <table width="100%" border="0" cellspacing="2" cellpadding="2">
				<tr>
                    <td width="20">Perpustakaan </td>
                    <td width="200"><?=$this->GetPerpus()?></td>
                    <td width="66%" rowspan="3">
						<a href="javascript:show()"><img src="../img/view.png" width="48" height="48" border="0" /></a>
					</td>
                </tr>
                <tr>
                    <td>Bulan</td>
                    <td width="*">
<?						$yearnow = date('Y');	?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="1">
                        <tr>
                        <td>
<?							echo "<select name='BlnAwal' id='BlnAwal' class='cmbfrm' onchange='chg()'>";
                            for ($i=1;$i<=12;$i++)
							{
                                if ($this->BlnAwal=="")
                                    $this->BlnAwal = $i;
                                echo "<option value='".$i."' ".IntIsSelected($i,$this->BlnAwal).">".NamaBulan($i)."</option>";
							}
                            echo "</select>"; ?>
						</td>
                        <td>
<?							echo "<select name='ThnAwal' id='ThnAwal' class='cmbfrm' onchange='chg()'>";
                            for ($i=$yearnow;$i>=$G_START_YEAR;$i--)
							{
                                if ($this->ThnAwal=="")
                                    $this->ThnAwal = $i;
                                echo "<option value='".$i."' ".IntIsSelected($i,$this->ThnAwal).">".$i."</option>";
                            }
                            echo "</select>"; ?>
						</td>
                        <td>
<?							echo "&nbsp;s.d.&nbsp;";	?>
						</td>
						<td>
<?							echo "<select name='BlnAkhir' id='BlnAkhir' class='cmbfrm' onchange='chg()'>";
                            for ($i=1;$i<=12;$i++)
							{
                                if ($this->BlnAkhir=="")
                                    $this->BlnAkhir = $i;
                                echo "<option value='".$i."' ".IntIsSelected($i,$this->BlnAkhir).">".NamaBulan($i)."</option>";
                            }
                            echo "</select>";	?>
						</td>
                        <td>
<?							echo "<select name='ThnAkhir' id='ThnAkhir' class='cmbfrm' onchange='chg()'>";
                            for ($i=$yearnow;$i>=$G_START_YEAR;$i--)
							{
                                if ($this->ThnAkhir=="")
                                    $this->ThnAkhir = $i;
                                echo "<option value='".$i."' ".IntIsSelected($i,$this->ThnAkhir).">".$i."</option>";
                            }
                            echo "</select>"; ?>
						</td>
						</tr>
						</table>
					</td>
                </tr>
                <tr>
                    <td>Jumlah&nbsp;data&nbsp;yang&nbsp;ditampilkan</td>
                    <td>
<?						echo "<select name='Limit' id='Limit' class='cmbfrm' onchange='chg()'>";
						for ($i=5;$i<=20;$i+=5)
						{
							if ($this->Limit=="")
								$this->Limit = $i;
							echo "<option value='".$i."' ".IntIsSelected($i,$this->Limit).">".$i."</option>";
						}
						echo "</select>";	?>
					</td>
                </tr>
                </table>
        </div>
		</td>
        <td valign="top">
        <div id="title" align="right">
            <font style="color:#FF9900; font-size:30px;"><strong>.:</strong></font>
            <font style="font-size:18px; color:#999999">Statistik Pustaka Favorit</font><br />
            <a href="pustaka.php" class="welc">Pustaka</a><span class="welc"> > Statistik Pustaka Favorit</span><br /><br /><br />
        </div>
        </td>
    </tr>
    <tr>
        <td colspan="2" valign="top">
<? 			if (isset($_REQUEST['ShowState']))
			{
				echo $this->ShowStatistik();
			}
			else
			{
				echo "&nbsp;";	
			} ?>
        </td>
    </tr>
    </table>
    <br />
<?
	}
	
	function ShowStatistik()
	{
		$filter="";
		if ($this->perpustakaan!='-1')
			$filter=" AND d.perpustakaan=".$this->perpustakaan;
			
		$sql = "SELECT count(*) AS num, judul, pu.replid
				  FROM pinjam p, daftarpustaka d, pustaka pu
				 WHERE p.tglpinjam BETWEEN '".$this->ThnAwal."-".$this->BlnAwal."-01' AND '".$this->ThnAkhir."-".$this->BlnAkhir."-31'
				   AND d.kodepustaka=p.kodepustaka
				   AND pu.replid=d.pustaka $filter
				 GROUP BY judul
				 ORDER BY num DESC
				 LIMIT ".$this->Limit;		 
		$result = QueryDb($sql);
		$cnt=1;
		$key = $this->ThnAwal."-".$this->BlnAwal."-01,".$this->ThnAkhir."-".$this->BlnAkhir."-31";
		?>
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
<? 		if (@mysqli_num_rows($result)>0)
		{ ?>
        <tr>
		    <td colspan="2" align="center" valign="top"><a href="javascript:Cetak()"><img src="../img/ico/print1.png" width="16" height="16" border="0" />&nbsp;Cetak</a></td>
	    </tr>
        <tr>
			<td width="50%" align="center" valign="top">
            	<img src="<?="statimage.php?type=bar&key=$key&Limit=$this->Limit&krit=2&perpustakaan=$this->perpustakaan" ?>" />
            </td>
			<td align="center" valign="top">
            	<img src="<?="statimage.php?type=pie&key=$key&Limit=$this->Limit&krit=2&perpustakaan=$this->perpustakaan" ?>" />
            </td>
		</tr>
<? 		} ?>
		<tr>
			<td colspan="2" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="350" valign="top">
					<table width="100%" border="1" cellspacing="0" cellpadding="5" class="tab">
					<tr height="25">
						<td width='10%' align="center" class="header">No</td>
						<td width='*' align="center" class="header">Judul</td>
						<td width='17%' align="center" class="header">Jumlah</td>
						<td width='10%' align="center" class="header">&nbsp;</td>
					</tr>
<? 					if (@mysqli_num_rows($result)>0)
					{
						while ($row = @mysqli_fetch_row($result))
						{ 
							$this->judul = $row[1]; ?>
							<tr height="20">
								<td align="center"><?=$cnt?></td>
								<td align='left'><?=$this->judul?></td>
								<td align="center"><?=$row[0]?></td>
								<td align="center">
									<a href="javascript:ViewList('<?=$row[2]?>')"><img src="../img/ico/lihat.png" width="16" height="16" border="0" /></a>
								</td>
							</tr>
<?	 						$cnt++; 
                        }
					}
					else
					{ ?>
					<tr>
						<td height="20" align="center" colspan="4" class="nodata">Tidak ada data</td>
					</tr>	
<? 					} ?>
					</table>
				</td>
				<td valign="top">
                   	<div id="ListInfo" style="padding-left:15px"></div>
                </td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
<?	}
}
?>