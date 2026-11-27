<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan_kab.php";

$kd_kab				=$_SESSION['idb'];
$idf				=substr($_GET['sub_report'],3);
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
$mll				=$m-1; if($ml<10) {$ml="0$mll"; }else{ $ml=$mll; }


	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisibulanlalu="$y-$ml-$d"; $judulL="Kemaren"; $judulC="Hari Ini";  }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $tgl_kondisibulanlalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisibulanlalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten WHERE id='$_SESSION[idb]' "));
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
.pull-right {
  float: right;
  margin-left:120px;
}
-->
</style>
<body onLoad="window.print()">

		<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" class="style9">
			<tr>
				<td height="20" class="bottom">
					<div class="style9"><?php echo "$row[nama_lembaga]<br>Pusat Waeapo Kabupaten $row[nama_kab]";?><br>
					<?php echo $row['alamat_kab'];?> Telp.<?php echo $row['telpon_kab'];?>					</div>				</td>
				<td height="20" class="bottom">
					<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
					Koperasi Jasa LKM</div>				</td>
			</tr> 
            <tr>
				<td height="20" class="style6"><br>NERACA <?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
				<td height="20" class="style6 pull-right"><br>REKAP PUSAT WAEAPO</td>
			</tr>
			<tr>
			  <th height="30" class="left top bottom">AKTIVA</th>
			  <th class="all">PASSIVA</th>
		    </tr>
			<tr>
			  <td class="left top bottom" width="50%">
					<table width='100%' cellpadding="0" cellspacing="0" class="style9">
						<?php
						$view=mysql_query("select * from rekening_kop WHERE posisi='1' ORDER by id ASC ");
						while($row=mysql_fetch_array($view)){
						$data=mysql_query("SELECT * FROM jenis_buku WHERE kd_jr='$row[kd_rr]' AND kd_kab='$kd_kab' ");
						echo "
						<tr>
							<td><strong>$row[nama_rr]</strong><br> ";
							while($r=mysql_fetch_array($data)){

							$saldo_aktiva=saldokab("$tgl_kondisi-$r[kd_jb]-$kd_kab");
																																		
							echo	"
							<table width='100%' class='style9'>
								<tr>
									<td width='70%'>$r[kd_jb]. $r[nama_jb]</td>
									<td width='30%' class='align-right'>".number_format($saldo_aktiva)."</td>
								</tr>
							</table>
							";
																																	
							$aktiva=$aktiva+$saldo_aktiva;
							}
							echo "
							</td>
						</tr> 
						";					
						}
						?>
						<tr><th class="top"><span class='pull-right'><?php echo number_format($aktiva);?></span></th></tr>
					</table>
			  
			  </td>
			  <td class="all"  width="50%">
					<table width='100%' cellpadding="0" cellspacing="0" class="style9">
					<?php
						$view=mysql_query("select * from rekening_kop WHERE posisi='2' OR posisi='3' ORDER by id ASC ");
						while($row=mysql_fetch_array($view)){
						$data=mysql_query("SELECT * FROM jenis_buku WHERE kd_jr='$row[kd_rr]' AND kd_kab='$kd_kab' ");
						echo "
						<tr>
							<td><strong>$row[nama_rr]</strong><br> ";
							while($r=mysql_fetch_array($data)){

							$saldo_passiva=saldokab("$tgl_kondisi-$r[kd_jb]-$kd_kab")*-1;
																																		
							echo	"
							<table width='100%' class='style9'>
								<tr>
									<td width='70%'>$r[kd_jb]. $r[nama_jb]</td>
									<td width='30%' class='align-right'>".number_format($saldo_passiva)."</td>
								</tr>
							</table>
							";
																																	
							$passiva=$passiva+$saldo_passiva;
							}
							echo "
							</td>
						</tr> 
						";					
						}
						?>
						<tr><td><strong>Surplus/Devisit</strong><span class="pull-right">
						<?php echo number_format(surplus("$tgl_kondisi-$kd_kab"));?></span></td></tr>
						<tr>
						<th class="top"><span class='pull-right'><?php echo number_format(surplus("$tgl_kondisi-$kd_kab")+$passiva);?></span></th>
						</tr>
					</table>
			  </td>
		    </tr>
    <?php if($kd_kab==48) {?>
    <?php include "ttd_pusat_waeapo.php"; }?> 
		</table>
	
		
		<title>NC<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>