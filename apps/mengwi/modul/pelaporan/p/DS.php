<?php  session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

$lokasi				=$_SESSION['lokasi'];

$report				=$_POST['report'];
$kd_desa			=$_POST['pilih_desa'];
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
if (empty($kd_desa)) {
    $kd_desa=$_SESSION['kd_desa'];
}

$tgl				="$y-$m-$d";
$yll				=$y-1;
$mll				=$m-1; if($mll<10) {$ml="0$mll"; }else{ $ml=$mll; }
$dll				=$d-1; if($dll<10) {$dl="0$dll"; }else{ $dl=$dll; }
$thn_kondisi		="$y-01-01";
$thn_kondisi_lalu	="$yll-12-31";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $kc="D"; $tgl_kondisilalu="$y-$m-$dl"; $judulL="Kemaren"; $judulC="Hari Ini"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $kc="M"; $tgl_kondisilalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='$idf' "));
$jpp=$jp['nama_jpp'];

$kd_kec=$row['kd_kec'];
$sd=mysql_fetch_array(mysql_query("SELECT * FROM desa d, sebutan_desa sd where d.sebutan=sd.id AND kd_desa='$kd_desa'"));
$sebutan_desa	= $sd['sebutan_desa'];
$nama_desa		= $sd['nama_desa'];
?>


<style type="text/css">
<!--
.style6 {font-family: Arial, Helvetica, sans-serif; font-size: 16px;font-weight: bold;  }
.style9 {font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style10 {font-family: Arial, Helvetica, sans-serif; font-size: 10px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style26 {font-family: Arial, Helvetica, sans-serif}
.style27 {font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
.align-right {text-align:right; }
-->
</style>
<body onLoad="window.print()">

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td height="20" colspan="10" class="bottom">
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
		<td height="20" colspan="8" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. DS-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
    <tr>
        <td height="20" colspan="18" class="style6 bottom align-center"><br>LAPORAN PERKEMBANGAN PINJAMAN <?php echo $jpp;?> REKAP KELOMPOK <br><?php echo strtoupper("$sebutan_desa $nama_desa");?><br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
    </tr>
			<tr align="center" height="30px" class="style9">
              <th width="2%" rowspan="2" class="left bottom">No</th>
              <th width="20%" rowspan="2" class="left bottom">Kelompok - Loan ID</a></th>
			  <th width="4%" rowspan="2" class="left bottom">Tgl Cair</a></th>
              <th width="3%" rowspan="2" class="left bottom">Tem<br>po</a></th>
              <th width="7%" rowspan="2" class="left bottom">Alokasi</a></th>
			  <th width="3%" rowspan="2" class="left bottom">Pros Jasa</a></th>
              <th colspan="2" class="left bottom">Target Pengembalian</a></th>
              <th colspan="2" class="left bottom">Realisasi s.d. <?php echo $judulL;?> </a></th>
              <th colspan="2" class="left bottom">Realisasi <?php echo $judulC;?> </a></th>
              <th colspan="2" class="left bottom">Realisasi s.d. <?php echo $judulC;?> </a></th>
              <th width="8%" rowspan="2" class="left bottom">Saldo Pinjaman </th>
              <th width="2%" rowspan="2" class="left bottom">%</th>
              <th colspan="2" class="left bottom right">Tunggakan Pengembalian</th>
            </tr>
            <tr align="center"  height="30px" class="style9">
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom">Jasa</th>
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom">Jasa</th>
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom">Jasa</th>
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom">Jasa</th>
			  <th width="5%" class="left bottom">Pokok</th>
              <th width="5%" class="left bottom right">Jasa</th>
            </tr>
	  <?php
		$data=mysql_query("SELECT d.id, d.nama_desa FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$lokasi' AND d.kd_desa='$kd_desa' ORDER BY d.id ASC");
		$no=0;
		while($r=mysql_fetch_array($data)){
		$idd=$r['id'];
		$no=$no+1;

		?>
		<?php
		$view=mysql_query("SELECT pk.id, 
								  pk.alokasi, 
								  k.nama_kelompok, 
								  pk.tgl_cair, 
								  pk.tgl_lunas, 
								  pk.pros_jasa,
								  pk.`status`, 
								  pk.jangka, 
								  sa.sistem, 
								  k.kd_kelompok	
								  
		FROM 
			kelompok_$_SESSION[kd_kab] k, 
			sistem_angsuran sa, 
			pinjaman_kelompok_$_SESSION[kd_kab] pk 
		WHERE 
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.`status`='A' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='L' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='L' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='R' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='R' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='H' OR
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='H'
		ORDER BY k.kd_kelompok ASC"); 
		$noo=0;
		while($row=mysql_fetch_array($view)){
		$noo=$noo+1;
		$idp	=$row['id'];
		$alokasi		=$row['alokasi'];
		$pros_jasa 		=number_format($row['pros_jasa']/$row['jangka'],2);
		$tgl_lunas		=$row['tgl_lunas'];
		$status			=$row['status'];
		$targetpokok	=targetpokok($tgl_kondisi."-".$idp);
		$targetjasa		=targetjasa($tgl_kondisi."-".$idp);
		$reallalu		=sumpokok("$tgl_kondisilalu-$idp");
		$reallalujasa	=sumjasa("$tgl_kondisilalu-$idp");
		$realpokok		=realisasiinipokok("$tgl_kondisi-$kc-$idp");
		$realjasa		=realisasiinijasa("$tgl_kondisi-$kc-$idp");
		$sumpokok		=sumpokok("$tgl_kondisi-$idp");
		$sumjasa		=sumjasa($tgl_kondisi."-".$idp);
		$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$idp);
		$nunggakpokok	=nunggakpokok($tgl_kondisi."-".$idp);
		$nunggakjasa	=nunggakjasa($tgl_kondisi."-".$idp);
		
		$angsuranke		=angsuranke("$tgl_kondisi-P-$idp");
		
		?>
		<tr align="right" height="15px" class="style9">
              <td class="left top" align="center">	<?php echo $noo;?></td>
			  <td class="left top" align="left">	<?php echo "$row[kd_kelompok] $row[nama_kelompok] -$idp"; ?></td>
              <td class="left top" align="center">	<?php echo tgl_ind($row['tgl_cair']); ?></td>
			  <td class="left top" align="center">	<?php echo "$row[jangka]/$row[sistem]*$angsuranke";?></td>
			  <td class="left top">					<?php echo number_format($alokasi);?></td>
			  <td class="left top">					<?php echo substr($pros_jasa,0,4);?>%</td>
              <td class="left top">					<?php echo number_format($targetpokok);?></td>
              <td class="left top">					<?php echo number_format($targetjasa);?></td>
			  <td class="left top">					<?php echo number_format($reallalu);?></td>              
              <td class="left top">					<?php echo number_format($reallalujasa);?></td>
			  <td class="left top">					<?php echo number_format($realpokok);?></td>
              <td class="left top">					<?php echo number_format($realjasa);?></td>
              <td class="left top">					<?php echo number_format($sumpokok);?></td>
              <td class="left top">					<?php echo number_format($sumjasa);?></td>
              <td class="left top">					<?php echo number_format($saldopinjaman);?></td>
              <td class="left top">					<?php $pros=@($sumpokok/$targetpokok*100); if($pros>=100) {echo "100";}else{echo number_format($pros);}?>%</td>
			
	<?php if($tgl_lunas<=$tgl_kondisi and $status=="L") { ?>
			  <td class="left top right align-center" colspan="3">V-LUNAS <?php echo tgl_ind($tgl_lunas); ?></td>
	<?php } else if($tgl_lunas<=$tgl_kondisi and $status=="R") { ?>
			  <td class="left top right align-center" colspan="3">Rescedulling <?php echo tgl_ind($tgl_lunas); ?></td>
	<?php } else if($tgl_lunas<=$tgl_kondisi and $status=="H") { ?>
			  <td class="left top right align-center" colspan="3">
			      <?php if($_SESSION['lokasi']==274 OR $_SESSION['lokasi']==1){echo "Pemindahbukuan ";} else {?>
			      Penghapusan
			      <?php } echo tgl_ind($tgl_lunas); ?></td>
	<?php }else{ ?>
			<td class="left top">					<?php echo number_format($nunggakpokok);?></td>
			<td class="left top right">				<?php echo number_format($nunggakjasa);?></td>
	<?php } ?>
		
		<?php 

		}
		?>
		<tr>
			<td class="style27 left top" align="center" colspan="4">Komulatif Tahun Berjalan (<?php echo $_GET['y'];?>)</td>
			<td class="style27 left top align-right"><?php echo number_format(alokasiD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top align-right">						</td>
			<td class="style27 left top align-right"><?php echo number_format(targetpokokD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top align-right"><?php echo number_format(targetjasaD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top align-right"><?php echo number_format(sumrealpokokD("$tgl_kondisilalu-$idf-$idd"));?></td>
			<td class="style27 left top align-right"><?php echo number_format(sumrealjasaD("$tgl_kondisilalu-$idf-$idd"));?></td>
			<td class="style27 left top align-right"><?php echo number_format(sumrealpokokD("$tgl_kondisi-$idf-$idd")-sumrealpokokD("$tgl_kondisilalu-$idf-$idd"));?></td>
			<td class="style27 left top align-right"><?php echo number_format(sumrealjasaD("$tgl_kondisi-$idf-$idd")-sumrealjasaD("$tgl_kondisilalu-$idf-$idd"));?></td>
			<td class="style27 left top align-right"><?php echo number_format(sumrealpokokD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top align-right"><?php echo number_format(sumrealjasaD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top align-right"><?php echo number_format(saldopinjamanD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top align-right"><?php $pros=@(sumrealpokokD("$tgl_kondisi-$idf-$idd")/targetpokokD("$tgl_kondisi-$idf-$idd")*100); if($pros>=100) {echo "100";}else{echo number_format($pros);}?>%</td>
			<td class="style27 left top align-right"><?php echo number_format(nunggakpokokD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top right align-right"><?php echo number_format(nunggakjasaD("$tgl_kondisi-$idf-$idd"));?></td>
		</tr>
		<?php
		}
		 
		?>
		</tr>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="center" colspan="4">Komulatif s.d Tahun Lalu (<?php echo $yll;?>)</td>
			  <td class="left top">					<?php echo number_format(alokasiDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
			  <td class="left top">					</td>
              <td class="left top">					<?php echo number_format(targetpokokDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
              <td class="left top">					<?php echo number_format(targetjasaDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
			  <td class="left top">					<?php echo number_format(sumrealpokokDL("$thn_kondisi_lalu-$idf-$idd"));?></td>              
              <td class="left top">					<?php echo number_format(sumrealjasaDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
			  <td class="left top">					0</td>
              <td class="left top">					0</td>
              <td class="left top">					<?php echo number_format(sumrealpokokDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
              <td class="left top">					<?php echo number_format(sumrealjasaDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
              <td class="left top">					<?php echo number_format(saldopinjamanDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
              <td class="left top">					<?php $pros=@(sumrealpokokDL("$thn_kondisi_lalu-$idf-$idd")/targetpokokCL("$thn_kondisi_lalu-$idf-$idd")*100); if($pros>=100) {echo "100";}else{echo number_format($pros);}?>%</td>
			  <td class="left top">					<?php echo number_format(nunggakpokokDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
			  <td class="left top right">			<?php echo number_format(nunggakjasaDL("$thn_kondisi_lalu-$idf-$idd"));?></td>	
		</tr>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="center" colspan="4">Komulatif s.d. Tahun Berjalan (<?php echo $_GET['y'];?>)</td>
			  <td class="left top">					<?php echo number_format(alokasiD("$tgl_kondisi-$idf-$idd")+alokasiDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
			  <td class="left top">					</td>
              <td class="left top">					<?php echo number_format(targetpokokD("$tgl_kondisi-$idf-$idd")+targetpokokDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
              <td class="left top">					<?php echo number_format(targetjasaD("$tgl_kondisi-$idf-$idd")+targetjasaDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
			  <td class="left top">					<?php echo number_format(sumrealpokokD("$tgl_kondisi-$idf-$idd")+sumrealpokokDL("$thn_kondisi_lalu-$idf-$idd"));?></td>              
              <td class="left top">					<?php echo number_format(sumrealjasaD("$tgl_kondisi-$idf-$idd")+sumrealjasaDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
			  <td class="left top">					<?php echo number_format(sumrealpokokD("$tgl_kondisi-$idf-$idd")-sumrealpokokD("$tgl_kondisilalu-$idf-$idd"));?></td>
              <td class="left top">					<?php echo number_format(sumrealjasaD("$tgl_kondisi-$idf-$idd")-sumrealjasaD("$tgl_kondisilalu-$idf-$idd"));?></td>
              <td class="left top">					<?php echo number_format(sumrealpokokD("$tgl_kondisi-$idf-$idd")+sumrealpokokDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
              <td class="left top">					<?php echo number_format(sumrealjasaD("$tgl_kondisi-$idf-$idd")+sumrealjasaDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
              <td class="left top">					<?php echo number_format(saldopinjamanD("$tgl_kondisi-$idf-$idd")+saldopinjamanDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
              <td class="left top">					<?php $pros=@(((sumrealpokokD("$tgl_kondisi-$idf-$idd"))+(sumrealpokokDL("$thn_kondisi_lalu-$idf-$idd")))/((targetpokokD("$tgl_kondisi-$idf-$idd"))+(targetpokokDL("$thn_kondisi_lalu-$idf-$idd")))*100); if($pros>=100) {echo "100";}else{echo number_format($pros);}?>%</td>
			  <td class="left top">					<?php echo number_format(nunggakpokokD("$tgl_kondisi-$idf-$idd")+nunggakpokokDL("$thn_kondisi_lalu-$idf-$idd"));?></td>
			  <td class="left top right">			<?php echo number_format(nunggakjasaD("$tgl_kondisi-$idf-$idd")+nunggakjasaDL("$thn_kondisi_lalu-$idf-$idd"));?></td>	
		</tr>
		<td class="style10 top" colspan="18"><b>Keterangan</b> : Data yang ditampilkan diatas merupakan kelompok aktif pada tahun berjalan (<?php echo $_GET['y'];?>), untuk menampilkan data kelompok aktif tahun lalu dapat memilih mode tahun lalu (<?php echo $yll;?>).</td>
</table>



<?php include "tanda_tangan.php"; ?> 
	          
</body>
<title>DS<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>