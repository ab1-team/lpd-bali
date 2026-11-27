<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";

$lokasi				=$_SESSION[lokasi];

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

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

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
				<td height="20" colspan="4" class="bottom">
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
				<td height="20" colspan="3" class="bottom">
					<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
					Kd.Doc. NP-<?php echo $idf;?> Lembar-1 </div>
				</td>
			</tr> 
            <tr>
				<td height="20" colspan="7" class="style6 bottom align-center"><br>NERACA PERCOBAAN <br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td></td>
			</tr>
														<tr>
															<th  class="left bottom top" rowspan="2">Rekening</th>
															<th class="left top" colspan="2">Neraca Saldo</th>
															<th class="left top" colspan="2">Rugi Laba</th>
															<th class="left  top right" colspan="2">Neraca</th>
														</tr>
														<tr>
															<th class="bottom left top">Debit</th>
															<th class="bottom left top">Kredit</th>
															<th class="bottom left top">Debit</th>
															<th class="bottom left top">Kredit</th>
															<th class="bottom left top">Debit</th>
															<th class="all">Kredit</th>
														</tr>
														
												<?php
													$view=mysql_query("SELECT * FROM jenis_buku WHERE kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' AND lokasi='0' OR lokasi like '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ORDER by kd_jb ASC");
														while($row=mysql_fetch_array($view)){
														$posisi=$row['posisi'];
														
														$saldo=saldo("$tgl_kondisi-".$row['kd_jb']);		//menggunakan fungsi Saldo by buku
														if($saldo>=0) {
														$debit=$saldo;
														$kredit="0";
														}elseif($saldo<=0){
														$debit="0";
														$kredit=$saldo*-1;
														}
														
														if($posisi=='1' OR $posisi=='2' OR $posisi=='3') {
															$rldebit="0";
															$rlkredit="0";
															$nrcdebit=$debit;
															$nrckredit=$kredit;
															}elseif($posisi=='4' OR $posisi=='5') {
															$rldebit=$debit;
															$rlkredit=$kredit;
															$nrcdebit="0";
															$nrckredit="0";
															}
														
																	
														echo "
														<tr height='25'>
															<td class='left'>$row[kd_jb]. $row[nama_jb]</td>
															<td class='left align-right'>".number_format($debit)."</td>
															<td class='left align-right'>".number_format($kredit)."</td>
															<td class='left align-right'>".number_format($rldebit)."</td>
															<td class='left align-right'>".number_format($rlkredit)."</td>
															<td class='left align-right'>".number_format($nrcdebit)."</td>
															<td class='left right align-right'>".number_format($nrckredit)."</td>
														</tr> 
														";					
														$sumdebit=$sumdebit+$debit;
														$sumkredit=$sumkredit+$kredit;
														
														$sumrldebit=$sumrldebit+$rldebit;
														$sumrlkredit=$sumrlkredit+$rlkredit;
														
														$sumnrcdebit=$sumnrcdebit+$nrcdebit;
														$sumnrckredit=$sumnrckredit+$nrckredit;
														}
														 ?>
														
														<tr height="30">
															<th class="top left  bottom align-center">Surplus/Devisit</th>
															<th class="top left  bottom" colspan="2">&nbsp;</th>
															<th class="top left  bottom align-right"><?php echo number_format($sumrlkredit-$sumrldebit);?></th>
															<th class="top left bottom" >&nbsp;</th>
															<th colspan="2" class="bottom top right align-right"><?php echo number_format($sumrlkredit-$sumrldebit);?></th>
														</tr>
														<tr height="30">
															<th class="left bottom align-center">Jumlah</th>
															<th class="left bottom align-right"><?php echo number_format($sumdebit);?></th>
															<th class="left bottom align-right"><?php echo number_format($sumkredit);?></th>
															<th class="left bottom align-right"><?php echo number_format($sumrldebit+($sumrlkredit-$sumrldebit));?></th>
															<th class="left bottom align-right"><?php echo number_format($sumrlkredit);?></th>
															<th class="left bottom align-right"><?php echo number_format($sumnrcdebit);?></th>
															<th class="left bottom right align-right"><?php echo number_format($sumnrckredit+($sumrlkredit-$sumrldebit));?></th>
														</tr>
	</table>
	
<?php if($_SESSION['lokasi']==351) {?>
    <?php include "ttd_pusat_waeapo.php"; ?> 
<?php } else if ($_SESSION['lokasi']==352 or $_SESSION['lokasi']==353 or$_SESSION['lokasi']==354) {?>
    <?php include "ttd_cab_waeapo.php"; ?> 
<?php } else {?>
    <?php include "tanda_tangan.php"; }?>

	
</body>
<title>NP<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>