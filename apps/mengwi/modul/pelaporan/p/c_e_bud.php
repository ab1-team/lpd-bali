<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

$table_rekening		="rekening_".$_SESSION['lokasi'];
$lokasi				=$_SESSION['lokasi'];

$tahun_anggaran		=$_GET['y'];


$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

?>


<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
.align-right {text-align:right; }
-->
</style>
<body onLoad="window.print()">

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" class="style9">
			<tr>
				<td height="20" colspan="3" class="bottom">
					<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$row[sebutan_kec] $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
				</td>
			</tr> 
            <tr>
				<td height="20" colspan="3" class="style6 bottom align-center"><br>E-BUDGETING<BR>TAHUN ANGGARAN <?php echo "$tahun_anggaran";?></td></td>
			</tr>
														<tr height="35">
															<th colspan="2" class="left bottom top">Rekening</th>
															<th class="all" >Rencana Anggaran</th>
														</tr>
														<tr height='25'>
															<td colspan='3' class='left right style27'>4. RENCANA PENDAPATAN</td>
														</tr>
														
												<?php
													$view=mysql_query("select * from jenis_buku WHERE posisi='4' ORDER by id ASC ");
														while($row=mysql_fetch_array($view)){
														
														$data=mysql_query("SELECT * FROM $table_rekening WHERE kd_jb='$row[kd_jb]' AND jenis_mutasi='kredit' ORDER BY kd_rekening ASC ");												
														echo "
														<tr height='25' class='style27'>
															<td colspan='2' class='top bottom left'>$row[kd_jb]. $row[nama_jb]</td>
															<td class='top bottom left right align-right'></td>
														</tr> 
														";			
																while($r=mysql_fetch_array($data)){
																	
																	$s=mysql_fetch_array(mysql_query("SELECT ra_$tahun_anggaran as ra FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$r[kd_rekening]' "));
																	$angkarencana=$s['ra'];
																
																echo "
																<tr>
																	<td class='left'>&nbsp;&nbsp;&nbsp;&nbsp;</td>
																	<td>$r[kd_rekening] $r[nama_rekening]</td>
																	<td class='left right align-right'>".number_format($angkarencana)."</td>
																</tr>
																";																	
																		$sump=$sump+$angkarencana;																
																}	
														}
														 ?>
														<tr height="30">
															<th class="top left  bottom align-center" colspan="2">Total Rencana Pendapatan</th>
															<th class="all align-right"><?php echo number_format($sump);?></th>
														</tr>
														
														<tr height='25'>
															<td colspan='3' class='left right style27'>5. RENCANA BIAYA</td>
														</tr>
														
												<?php
													$view=mysql_query("select * from jenis_buku WHERE posisi='5' ORDER by id ASC ");
														while($row=mysql_fetch_array($view)){
														
														$data=mysql_query("SELECT * FROM $table_rekening WHERE kd_jb='$row[kd_jb]' AND jenis_mutasi='debit' ORDER BY kd_rekening ASC ");												
														echo "
														<tr height='25' class='style27'>
															<td colspan='2' class='top bottom left'>$row[kd_jb]. $row[nama_jb]</td>
															<td class='top bottom left right align-right'></td>
														</tr> 
														";			
																while($r=mysql_fetch_array($data)){
																	
																	$s=mysql_fetch_array(mysql_query("SELECT ra_$tahun_anggaran as ra FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$r[kd_rekening]' "));
																	$angkarencana=$s['ra'];
																
																echo "
																<tr>
																	<td class='left'>&nbsp;&nbsp;&nbsp;&nbsp;</td>
																	<td>$r[kd_rekening] $r[nama_rekening]</td>
																	<td class='left right align-right'>".number_format($angkarencana)."</td>
																</tr>
																";																	
																		$sumb=$sumb+$angkarencana;																
																}	
														}
														 ?>
														<tr height="30">
															<th class="top left  bottom align-center" colspan="2">Total Rencana Biaya</th>
															<th class="all align-right"><?php echo number_format($sumb);?></th>
														</tr>
														<tr height="30">
															<th class="left bottom align-center" colspan="2">Rencana Surplus</th>
															<th class="left bottom right align-right"><?php echo number_format($sump-$sumb);?></th>
														</tr>
		  <tr>
			<td class="style10 top" colspan="5">&nbsp;</td>
		</tr>
	</table>
	
	<?php include "tanda_tangan.php"; ?> 
	
</body>
<title>E-Budgeting<?php echo " $tahun_anggaran";?></title>