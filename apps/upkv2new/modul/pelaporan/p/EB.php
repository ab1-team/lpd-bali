<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

$table_rekening		="rekening_".$_SESSION['lokasi'];
$lokasi				=$_SESSION['lokasi'];

$report				=$_POST['report'];
if (empty($report)) {
	$idf				=$_GET['idf'];
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$idf				=substr($_POST['sub_report'],3);
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
}

$tgl				= "$y-$m-$d";
	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisibulanlalu="$y-$ml-$d"; $judulL="Kemaren"; $judulC="Hari Ini";  }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date("Y-m-t", strtotime("$y-$m-01")); $tgl_kondisibulanlalu=date("Y-m-t", strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisibulanlalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}
if (empty($report)) {
	$tahun_anggaran		=$_GET['y'];
}else{
	$tahun_anggaran		=$_POST['y'];
}



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
				<td height="20" colspan="17" class="bottom">
					<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
				</td>
			</tr> 
            <tr>
				<td height="20" colspan="17" class="style6 bottom align-center"><br>LAPORAN PENGGUNAAN DANA (<i>E-BUDGETING</i>)<BR>TAHUN ANGGARAN <?php echo "$tahun_anggaran";?></td></td>
			</tr>
														<tr height="25">
															<th width="25%" colspan="2" rowspan="2" class="left bottom top">Rekening</th>
															<th width="6%" class="all" rowspan="2">Rencana</th>
															<th class="top right bottom" colspan="12">Realisasi Penggunaan Dana</th>
															<th width="6%" class="top right bottom" rowspan="2">TOTAL</th>
															<th width="2%" class="top right bottom" rowspan="2">%</th>
														</tr>
														<tr height="25">
															<th width="5%" class="right bottom" >Jan</th>
															<th width="5%" class="right bottom" >Feb</th>
															<th width="5%" class="right bottom" >Mar</th>
															<th width="5%" class="right bottom" >Apr</th>
															<th width="5%" class="right bottom" >Mei</th>
															<th width="5%" class="right bottom" >Jun</th>
															<th width="5%" class="right bottom" >Jul</th>
															<th width="5%" class="right bottom" >Ags</th>
															<th width="5%" class="right bottom" >Sep</th>
															<th width="5%" class="right bottom" >Okt</th>
															<th width="5%" class="right bottom" >Nov</th>
															<th width="5%" class="right bottom" >Des</th>
														</tr>
														<tr height='25'>
															<td colspan='17' class='left right style27'>4. REALISASI PENDAPATAN</td>
														</tr>
														
												<?php
													$view=mysql_query("select * from jenis_buku WHERE posisi='4' ORDER by id ASC ");
														while($row=mysql_fetch_array($view)){
														
														$data=mysql_query("SELECT * FROM $table_rekening WHERE kd_jb='$row[kd_jb]' AND jenis_mutasi='kredit' ORDER BY kd_rekening ASC ");												
														echo "
														<tr height='25' class='style27'>
															<td colspan='17' class='all'>$row[kd_jb]. $row[nama_jb]</td>
														</tr> 
														";			
																while($r=mysql_fetch_array($data)){
																	
																	$s=mysql_fetch_array(mysql_query("SELECT ra_$tahun_anggaran as ra FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$r[kd_rekening]' "));
																	$angkarencana=$s['ra'];
																
																echo "
																<tr>
																	<td class='left'>&nbsp;&nbsp;&nbsp;&nbsp;</td>
																	<td>$r[kd_rekening] $r[nama_rekening]</td>
																	<td class='left right align-right'>".number_format_koma($angkarencana)."</td>
																	<td class='right align-right'>".number_format_koma(saldoRB("$tahun_anggaran-01-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRB("$tahun_anggaran-02-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRB("$tahun_anggaran-03-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRB("$tahun_anggaran-04-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRB("$tahun_anggaran-05-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRB("$tahun_anggaran-06-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRB("$tahun_anggaran-07-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRB("$tahun_anggaran-08-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRB("$tahun_anggaran-09-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRB("$tahun_anggaran-10-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRB("$tahun_anggaran-11-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRB("$tahun_anggaran-12-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRT("$tahun_anggaran-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".floor(@(saldoRT("$tahun_anggaran-$r[kd_rekening]")/$angkarencana*100))."%</td>
																</tr>
																";																	
																		$sumrp=$sumrp+$angkarencana;
																		$sum1	=$sum1+saldoRB("$tahun_anggaran-01-$r[kd_rekening]");
																		$sum2	=$sum2+saldoRB("$tahun_anggaran-02-$r[kd_rekening]");
																		$sum3	=$sum3+saldoRB("$tahun_anggaran-03-$r[kd_rekening]");
																		$sum4	=$sum4+saldoRB("$tahun_anggaran-04-$r[kd_rekening]");
																		$sum5	=$sum5+saldoRB("$tahun_anggaran-05-$r[kd_rekening]");
																		$sum6	=$sum6+saldoRB("$tahun_anggaran-06-$r[kd_rekening]");
																		$sum7	=$sum7+saldoRB("$tahun_anggaran-07-$r[kd_rekening]");
																		$sum8	=$sum8+saldoRB("$tahun_anggaran-08-$r[kd_rekening]");
																		$sum9	=$sum9+saldoRB("$tahun_anggaran-09-$r[kd_rekening]");
																		$sum10	=$sum10+saldoRB("$tahun_anggaran-10-$r[kd_rekening]");
																		$sum11	=$sum11+saldoRB("$tahun_anggaran-11-$r[kd_rekening]");
																		$sum12	=$sum12+saldoRB("$tahun_anggaran-12-$r[kd_rekening]");
																		$sump	=$sump+saldoRT("$tahun_anggaran-$r[kd_rekening]");
																}	
														}
														 ?>
														<tr height="30">
															<th class="top left  bottom align-center" colspan="2">Total Realisasi Pendapatan</th>
															<th class="all align-right"><?php echo number_format_koma($sumrp);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum1);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum2);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum3);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum4);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum5);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum6);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum7);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum8);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum9);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum10);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum11);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum12);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sump);?></th>
															<th class="top right bottom align-right"><?php echo floor(@($sump/$sumrp*100));?>%</th>
														</tr>
														
														<tr height='25'>
															<td colspan='3' class='left right style27'>5. REALISASI BIAYA</td>
														</tr>
														
												<?php
													$views=mysql_query("select * from jenis_buku WHERE posisi='5' ORDER by id ASC ");
														while($rows=mysql_fetch_array($views)){
														
														$data=mysql_query("SELECT * FROM $table_rekening WHERE kd_jb='$rows[kd_jb]' AND jenis_mutasi='debit' ORDER BY kd_rekening ASC ");												
														echo "
														<tr height='25' class='style27'>
															<td colspan='17' class='all'>$rows[kd_jb]. $rows[nama_jb]</td>
														</tr> 
														";			
																while($r=mysql_fetch_array($data)){
																	
																	$s=mysql_fetch_array(mysql_query("SELECT ra_$tahun_anggaran as ra FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$r[kd_rekening]' "));
																	$angkarencana=$s['ra'];
																
																echo "
																<tr>
																	<td class='left'>&nbsp;&nbsp;&nbsp;&nbsp;</td>
																	<td>$r[kd_rekening] $r[nama_rekening]</td>
																	<td class='left right align-right'>".number_format_koma($angkarencana)."</td>
																	<td class='right align-right'>".number_format_koma(saldoRBB("$tahun_anggaran-01-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRBB("$tahun_anggaran-02-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRBB("$tahun_anggaran-03-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRBB("$tahun_anggaran-04-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRBB("$tahun_anggaran-05-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRBB("$tahun_anggaran-06-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRBB("$tahun_anggaran-07-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRBB("$tahun_anggaran-08-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRBB("$tahun_anggaran-09-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRBB("$tahun_anggaran-10-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRBB("$tahun_anggaran-11-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRBB("$tahun_anggaran-12-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".number_format_koma(saldoRBT("$tahun_anggaran-$r[kd_rekening]"))."</td>
																	<td class='right align-right'>".floor(@(saldoRBT("$tahun_anggaran-$r[kd_rekening]")/$angkarencana*100))."%</td>
																</tr>
																";																	
																		$sumrb=$sumrb+$angkarencana;
																		$sum1p	=$sum1p+saldoRBB("$tahun_anggaran-01-$r[kd_rekening]");
																		$sum2p	=$sum2p+saldoRBB("$tahun_anggaran-02-$r[kd_rekening]");
																		$sum3p	=$sum3p+saldoRBB("$tahun_anggaran-03-$r[kd_rekening]");
																		$sum4p	=$sum4p+saldoRBB("$tahun_anggaran-04-$r[kd_rekening]");
																		$sum5p	=$sum5p+saldoRBB("$tahun_anggaran-05-$r[kd_rekening]");
																		$sum6p	=$sum6p+saldoRBB("$tahun_anggaran-06-$r[kd_rekening]");
																		$sum7p	=$sum7p+saldoRBB("$tahun_anggaran-07-$r[kd_rekening]");
																		$sum8p	=$sum8p+saldoRBB("$tahun_anggaran-08-$r[kd_rekening]");
																		$sum9p	=$sum9p+saldoRBB("$tahun_anggaran-09-$r[kd_rekening]");
																		$sum10p	=$sum10p+saldoRBB("$tahun_anggaran-10-$r[kd_rekening]");
																		$sum11p	=$sum11p+saldoRBB("$tahun_anggaran-11-$r[kd_rekening]");
																		$sum12p	=$sum12p+saldoRBB("$tahun_anggaran-12-$r[kd_rekening]");
																		$sumb	=$sumb+saldoRBT("$tahun_anggaran-$r[kd_rekening]");
																}	
														}
														 ?>
														<tr height="30">
															<th class="top left  bottom align-center" colspan="2">Total Realisasi Biaya</th>
															<th class="all align-right"><?php echo number_format_koma($sumrb);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum1p);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum2p);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum3p);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum4p);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum5p);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum6p);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum7p);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum8p);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum9p);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum10p);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum11p);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sum12p);?></th>
															<th class="top right bottom align-right"><?php echo number_format_koma($sumb);?></th>
															<th class="top right bottom align-right"><?php echo floor(@($sumb/$sumrb*100));?>%</th>
														</tr>
														<tr height="30">
															<th class="left bottom align-center" colspan="2">Surplus/Devisit/SHU</th>
															<th class="left bottom right align-right"><?php echo number_format_koma($sumrp-$sumrb);?></th>
															<th class="bottom right align-right"><?php echo number_format_koma($sum1-$sum1p);?></th>
															<th class="bottom right align-right"><?php echo number_format_koma($sum2-$sum2p);?></th>
															<th class="bottom right align-right"><?php echo number_format_koma($sum3-$sum3p);?></th>
															<th class="bottom right align-right"><?php echo number_format_koma($sum4-$sum4p);?></th>
															<th class="bottom right align-right"><?php echo number_format_koma($sum5-$sum5p);?></th>
															<th class="bottom right align-right"><?php echo number_format_koma($sum6-$sum6p);?></th>
															<th class="bottom right align-right"><?php echo number_format_koma($sum7-$sum7p);?></th>
															<th class="bottom right align-right"><?php echo number_format_koma($sum8-$sum8p);?></th>
															<th class="bottom right align-right"><?php echo number_format_koma($sum9-$sum9p);?></th>
															<th class="bottom right align-right"><?php echo number_format_koma($sum10-$sum10p);?></th>
															<th class="bottom right align-right"><?php echo number_format_koma($sum11-$sum11p);?></th>
															<th class="bottom right align-right"><?php echo number_format_koma($sum12-$sum12p);?></th>
															<th class="bottom right align-right"><?php echo number_format_koma($sump-$sumb);?></th>
															<th class="bottom right align-right"><?php echo floor(@(($sump-$sumb)/($sumrp-$sumrb)*100));?>%</th>
														</tr>
		  <tr>
			<td class="style10 top" colspan="5">&nbsp;</td>
		</tr>
	</table>
	
	<?php include "tanda_tangan.php"; ?> 
	
</body>
<title>E-Budgeting<?php echo " $tahun_anggaran";?></title>