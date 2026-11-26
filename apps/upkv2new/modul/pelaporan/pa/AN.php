<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan_admin.php";
$table_rekening		="admin_rekening";
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
$mll				=$m-1; if($ml<10) {$ml="0$mll"; }else{ $ml=$mll; }


	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisibulanlalu="$y-$ml-$d"; $judulL="Kemaren"; $judulC="Hari Ini";  }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date('Y-m-t', strtotime("$y-$m-01")); $tgl_kondisibulanlalu=date('Y-m-t', strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisibulanlalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$u=mysql_fetch_array(mysql_query("SELECT * FROM pusat where id='$_SESSION[id]' "));
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
					<div class="style9">PT. ASTA BRATA TEKNOLOGI<br>
			JALAN RAYA KOPENG KM 1.5 BANYUURIP II, TEGALREJO MAGELANG</div>				</td>
				<td height="20" class="bottom">
					<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
					Kd.Doc. AN-<?php echo $idf;?> </div>				</td>
			</tr> 
            <tr>
				<td height="20" colspan="2" class="style6 bottom"><br>NERACA <?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
			</tr>
			<tr>
			  <th height="30" class="left top bottom">AKTIVA</th>
			  <th class="all">PASSIVA</th>
		    </tr>
			<tr>
			  <td class="left top bottom" width="50%">
					<table width='100%' cellpadding="0" cellspacing="0" class="style9">
						<?php

						$data=mysql_query("SELECT * FROM admin_buku WHERE posisi='1' ORDER by id ASC ");
						
							while($r=mysql_fetch_array($data)){

							$saldo_aktiva=saldo("$tgl_kondisi-".$r['id']);
																																		
							echo	"<tr>
										<td width='70%' height='20px'>$r[id]. $r[nama_jb]</td>
										<td width='30%' class='align-right'>".number_format_koma($saldo_aktiva)."</td>
									</tr>
							";
																																	
							$aktiva=$aktiva+$saldo_aktiva;
							}				
						
						?>
						<tr><th class="top" colspan="2"><span class='pull-right'><?php echo number_format_koma($aktiva);?></span></th></tr>
					</table>
			  
			  </td>
			  <td class="all"  width="50%">
					<table width='100%' cellpadding="0" cellspacing="0" class="style9">
					<?php

						$data=mysql_query("SELECT * FROM admin_buku WHERE posisi='2' OR  posisi='3'  ORDER by id ASC ");
						
							while($r=mysql_fetch_array($data)){

							$saldo_passiva=saldo("$tgl_kondisi-".$r['id'])*-1;
																																		
							echo	"<tr>
										<td width='70%' height='20px'>$r[id]. $r[nama_jb]</td>
										<td width='30%' class='align-right'>".number_format_koma($saldo_passiva)."</td>
									</tr>
							";
																																	
							$passiva=$passiva+$saldo_passiva;
							}				
						
						?>
						<tr><td>---> SHU Berjalan</td>
							<td class='align-right'><?php echo number_format_koma(surplus($tgl_kondisi));?></td></tr>
						<tr>
						<th class="top" colspan="2"><span class='pull-right'><?php echo number_format_koma(surplus($tgl_kondisi)+$passiva);?></span></th>
						</tr>
					</table>
			  </td>
		    </tr>		
		</table>
		
		<?php include "tanda_tangan.php"; ?> 
		
		<title>NC<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>