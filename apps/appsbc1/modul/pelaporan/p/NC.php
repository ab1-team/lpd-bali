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
$mll				=$m-1; if($ml<10) {$ml="0$mll"; }else{ $ml=$mll; }


	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisibulanlalu="$y-$ml-$d"; $judulL="Kemaren"; $judulC="Hari Ini";  }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $tgl_kondisibulanlalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisibulanlalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten b, kecamatan c, sebutan_desa sd, desa d where b.id=c.kd_kab and c.id=d.kd_kec and sd.id=d.sebutan AND d.id='$lokasi' "));
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
.pull-right {
  float: right;
  margin-left:120px;
}
-->
</style>
<body onLoad="window.print()">

		<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" class="style9">
			<tr>
				<td height="20" colspan="2" class="bottom">
					<div class="style9 text-align-left"><?php
                    
                        echo "<img class='' alt='...' src='../../../images/logo_lpd.gif' style='float:left; width:70; margin-right:5px;'>";
                        
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  if (empty($nomor_bh)) {$bh="";}else{$bh="SK Gubernur Bali No.$nomor_bh<br>";}
                
                  echo "<div class='style9'>".strtoupper("<b>LEMBAGA PERKREDITAN DESA (LPD) <br> $row[sebutan_desa] $row[nama_desa]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab] </b>")."<br>$bh $row[alamat_desa] Telp. $row[telpon_desa] </div>"; 
                  ?>      
				</div>		
				</td>

			</tr> 
            <tr>
				<td height="20" colspan="2" class="style6 bottom align-center"><br>N E R A C A <br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
			</tr>
			<tr>
			  <th height="30" class="left top bottom">AKTIVA</th>
			  <th class="all">PASSIVA</th>
		    </tr>
			<tr>
			  <td class="left top bottom" width="50%" valign="top">
					<table width='100%' cellpadding="0" cellspacing="0" class="style9">
						<?php
						$view=mysql_query("select * from rekening_riil WHERE posisi='1' ORDER by id ASC ");
						while($row=mysql_fetch_array($view)){
						$data=mysql_query("SELECT * FROM jenis_buku WHERE kd_jr='$row[kd_rr]' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' AND lokasi='0' OR kd_jr='$row[kd_rr]' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ORDER by kd_jb ASC ");
						echo "
						<tr>
							<td><strong>$row[nama_rr]</strong><br> ";
							while($r=mysql_fetch_array($data)){

							$saldo_aktiva=saldo("$tgl_kondisi-".$r['kd_jb']);
																																		
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
					</table>
			  
			  </td>
			  <td class="all"  width="50%"  valign="top">
					<table width='100%' cellpadding="0" cellspacing="0" class="style9">
					<?php
						$view=mysql_query("select * from rekening_riil WHERE posisi='2' OR posisi='3' ORDER by id ASC ");
						while($row=mysql_fetch_array($view)){
						$data=mysql_query("SELECT * FROM jenis_buku WHERE kd_jr='$row[kd_rr]' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' AND lokasi='0' OR kd_jr='$row[kd_rr]' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ORDER by kd_jb ASC ");
						echo "
						<tr>
							<td><strong>$row[nama_rr]</strong><br> ";
							while($r=mysql_fetch_array($data)){

							$saldo_passiva=saldo("$tgl_kondisi-".$r['kd_jb'])*-1;
																																		
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
						<?php echo number_format(surplus($tgl_kondisi));?></span></td></tr>
					</table>
			  </td>
		    </tr>		
		    <tr>
			  <th height="30" class="left top bottom"><span class='pull-right'><?php echo number_format($aktiva);?></span></th>
			  <th class="all"><span class='pull-right'><?php echo number_format(surplus($tgl_kondisi)+$passiva);?></span></th>
		    </tr>
			
			<tr>
			  <td class="top bottom">&nbsp;</td>
			  <th class="top">&nbsp;</td>
		    </tr>
			<?php
			$ma=modalawal("$tgl_kondisi");
			$ap=asetproduktif("$tgl_kondisi");
			$pd=$ap-$ma;
			$pr=@($pd/$ma*100);
			?>
			<tr><td class="left top  right">Modal Awal SPP/UEP<span class='pull-right'><?php echo number_format($ma);?></span></td><td>&nbsp;</td></tr>
			<tr><td class="left top  right">Aset Produktif<span class='pull-right'><?php echo number_format($ap);?></span></td><td>&nbsp;</td></tr>
			<tr><td class="left top  right">Perkembangan Dana<span class='pull-right'><?php echo number_format($pd);?></span></td><td>&nbsp;</td></tr>
			<tr><td class="left top bottom right">Prosentase Perkembangan<span class='pull-right'><?php echo number_format($pr);?>%</span></td><td>&nbsp;</td></tr>
		</table>
		
		<?php include "tanda_tangan.php"; ?> 
		
		<title>NC<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>