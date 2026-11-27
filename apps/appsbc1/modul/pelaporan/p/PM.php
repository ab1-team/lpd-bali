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


$tgl				="$y-$m-$d";
$mll				=$m-1; if($mll<10) {$ml="0$mll"; }else{ $ml=$mll; }
$dll				=$d-1; if($dll<10) {$dl="0$dll"; }else{ $dl=$dll; }


	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisibulanlalu="$y-$m-$dl"; $judulL="Kemarin"; $judulC="Hari Ini";  }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $tgl_kondisibulanlalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisibulanlalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));


$pendapatan	=pendapatan("$tgl_kondisi");
$biaya		=biaya("$tgl_kondisi");
$surplus	=surplus("$tgl_kondisi");

$pendapatanbulanlalu	=pendapatan("$tgl_kondisibulanlalu");
$biayabulanlalu			=biaya("$tgl_kondisibulanlalu");
$surplusbulanlalu		=surplus("$tgl_kondisibulanlalu");

$pendapatanbulanini		=$pendapatan-$pendapatanbulanlalu;
$biayabulanini			=$biaya-$biayabulanlalu;
$surplusbulanini		=$surplus-$surplusbulanlalu;


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
					<div class="style9 text-align-left"><?php
                    
                        echo "<img class='' alt='...' src='../../../images/logo_bumdes.png' style='float:left; width:70; margin-right:5px;'>";
                        
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  $bh="";
                
                  echo "<div class='style9'>".strtoupper("<b>".LEMBAGA_LONG." <br> $row[sebutan_desa] $row[nama_desa]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab] </b>")."<br>$bh $row[alamat_desa] Telp. $row[telpon_desa] </div>"; 
                  ?>      
				</div>
				</td>
				<td height="20" colspan="2" class="bottom">
					<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
					Kd.Doc. PM-<?php echo $idf;?> Lembar-1 </div>
				</td>
			</tr> 
            <tr>
				<td height="20" colspan="5" class="style6 bottom align-center"><br>LAPORAN PERUBAHAN MODAL <br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?><br><br></td></td>
			</tr>
														<tr height="35">
															<th colspan="2" class="left bottom top">REKENING MODAL</th>
															<th class="left bottom top">s.d. <?php echo $judulL;?></th>
															<th class="left bottom top"><?php echo $judulC;?></th>
															<th class="all" >s.d. <?php echo $judulC;?></th>
														</tr>
		
														
												<?php
													$view=mysql_query("select * from jenis_buku WHERE posisi='3' AND lokasi='0' or posisi='3' AND lokasi='$_SESSION[lokasi]' ORDER by id ASC ");
														while($row=mysql_fetch_array($view)){
														$posisi=$row['posisi'];
														
														$saldop=saldo("$tgl_kondisi-".$row['kd_jb']);		//menggunakan fungsi Saldo by buku
														$saldoplalu=saldo("$tgl_kondisibulanlalu-".$row['kd_jb']);		//menggunakan fungsi Saldo by buku
														$data=mysql_query("SELECT * FROM $table_rekening WHERE kd_jb='$row[kd_jb]' ORDER BY kd_rekening ASC ");												
														echo "
														<tr height='25' class='style27'>
															<td colspan='2' class='top bottom left'>$row[kd_jb]. $row[nama_jb]</td>
															<td class='top bottom left align-right'>".number_format($saldoplalu*-1)."</td>
															<td class='top bottom left align-right'>".number_format(($saldop*-1)-($saldoplalu*-1))."</td>
															<td class='top bottom left right align-right'>".number_format($saldop*-1)."</td>
														</tr> 
														";			
																while($r=mysql_fetch_array($data)){
																$saldo_pbulanlalu=saldoawalK("$tgl_kondisibulanlalu-".$r['kd_rekening'])+saldoBBK("$tgl_kondisibulanlalu-".$r['kd_rekening']);
																$saldo_p=saldoawalK("$tgl_kondisi-".$r['kd_rekening'])+saldoBBK("$tgl_kondisi-".$r['kd_rekening']);
																
																echo "
																<tr>
																	<td class='left'>&nbsp;&nbsp;&nbsp;&nbsp;</td>
																	<td>$r[kd_rekening] $r[nama_rekening]</td>
																	<td class='left align-right'>".number_format($saldo_pbulanlalu)."</td>
																	<td class='left align-right'>".number_format($saldo_p-$saldo_pbulanlalu)."</td>
																	<td class='left right align-right'>".number_format($saldo_p)."</td>
																</tr>
																";	
																		$sumpl=$sumpl+$saldo_pbulanlalu;																
																		$sump=$sump+$saldo_p;																
																}	
														}
														
														
														echo "
																<tr height='25' class='style27'>
																	<td colspan='2' class='top bottom left'>411. Surplus/Devisit Berjalan</td>
																	<td class='top bottom left align-right'>".number_format($surplusbulanlalu)."</td>
																	<td class='top bottom left align-right'>".number_format($surplusbulanini)."</td>
																	<td class='top bottom left right align-right'>".number_format($surplus)."</td>
																</tr> 
																<tr>
																	<td class='left'>&nbsp;&nbsp;&nbsp;&nbsp;</td>
																	<td>411.01 Pendapatan</td>
																	<td class='left align-right'>".number_format($pendapatanbulanlalu)."</td>
																	<td class='left align-right'>".number_format($pendapatanbulanini)."</td>
																	<td class='left right align-right'>".number_format($pendapatan)."</td>
																</tr>
																<tr>
																	<td class='left'>&nbsp;&nbsp;&nbsp;&nbsp;</td>
																	<td>411.02 Biaya</td>
																	<td class='left align-right'>".number_format($biayabulanlalu)."</td>
																	<td class='left align-right'>".number_format($biayabulanini)."</td>
																	<td class='left right align-right'>".number_format($biaya)."</td>
																</tr>
																";	
														 ?>
														
			
														<tr height="50">
															<th class="left top bottom align-center" colspan="2">TOTAL MODAL</th>
															<th class="left top bottom align-right"><?php echo number_format($sumpl+$surplusbulanlalu);?></th>
															<th class="left top bottom align-right"><?php echo number_format(($sump-$sumpl)+$surplusbulanini);?></th>
															<th class="left top bottom right align-right"><?php echo number_format($sump+$surplus);?></th>
														</tr>
		  <tr>
			<td class="style10 top" colspan="5">&nbsp;</td>
		</tr>
	</table>
	
<?php include "tanda_tangan.php"; ?> 
	
</body>
<title>PM<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>