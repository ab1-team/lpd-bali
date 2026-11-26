<?php
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";



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
$yll				=$y-1;
$mll				=$m-1; if($mll<10) {$ml="0$mll"; }else{ $ml=$mll; }
$dll				=$d-1; if($dll<10) {$dl="0$dll"; }else{ $dl=$dll; }
$thn_kondisi		="$y-01-01";
$thn_kondisi_lalu	="$yll-12-31";

if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $kc="D"; $tgl_kondisilalu="$y-$m-$dl"; $judulL="Kemaren"; $judulC="Hari Ini"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date("Y-m-t", strtotime("$y-$m-01")); $kc="M"; $tgl_kondisilalu=date("Y-m-t", strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='$idf' "));
$jpp=$jp['nama_jpp'];

$kd_kec=$row['kd_kec'];

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
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
		</td>
		<td height="20" colspan="8" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. PK-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
    <tr>
        <td height="20" colspan="18" class="style6 bottom align-center"><br>LAPORAN PERKEMBANGAN PINJAMAN <?php echo $idf;?> REKAP KELOMPOK <br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
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
		$data=mysql_query("SELECT d.id, d.nama_desa FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$lokasi' ORDER BY d.id ASC");
		$no=0;
		while($r=mysql_fetch_array($data)){
			$salokasi       =0;
        	$stargetpokok   =0;
        	$stargetjasa    =0;
        	$sreallalu      =0;
        	$sreallalujasa  =0;
        	$srealpokok     =0;
        	$srealjasa      =0;
        	$sspokok        =0;
        	$ssjasa         =0;
        	$ssaldopinjaman =0;
        	$snunggakpokok  =0;
        	$snunggakjasa   =0;
		$idd=$r['id'];
		$no=$no+1;

		?>
		<tr>
			<td class="style27 left top right" colspan="18"><?php echo "$no. ".strtoupper($r['nama_desa']);?></td>
		</tr>
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
		$pros_jasa 		=$row["pros_jasa"];
		$tgl_lunas		=$row['tgl_lunas'];
		$status			=$row['status'];
		$targetpokok	=targetpokok($tgl_kondisi."-".$idp);
		$targetjasa		=targetjasa($tgl_kondisi."-".$idp);
		$reallalu		=sumpokok("$tgl_kondisilalu-$idp");
		$reallalujasa	=sumjasa("$tgl_kondisilalu-$idp");
		$realpokok		=realisasiinipokok("$tgl_kondisi-$kc-$idp");
		$realjasa		=realisasiinijasa("$tgl_kondisi-$kc-$idp");
		//$sumpokok		=sumpokok("$tgl_kondisi-$idp"); //01.19.25
		$sumpokok		=$reallalu+$realpokok;
		//$sumjasa		=sumjasa($tgl_kondisi."-".$idp);
		$sumjasa		=$reallalujasa+$realjasa;
		//$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$idp);
		$saldopinjaman	=$alokasi-$sumpokok;
		//$nunggakpokok	=nunggakpokok($tgl_kondisi."-".$idp);
		//$nunggakjasa	=nunggakjasa($tgl_kondisi."-".$idp);
		$nunggakp			=$targetpokok-$sumpokok;
		if($nunggakp<0) { $nunggakpokok="0"; }else{ $nunggakpokok=$nunggakp; }
		$nunggakj			=$targetjasa-$sumjasa;
		if($nunggakj<=0 OR $status=="L" AND $tgl_lunas<$tgl_kondisi ) { $nunggakjasa="0"; } else{ $nunggakjasa=$nunggakj; }
		
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
              <td class="left top">					<?php $pros=round(@($sumpokok/$targetpokok*100),2); if($pros>=100) {echo "100";}else{echo number_format($pros);}?>%</td>
			
	<?php if($tgl_lunas<=$tgl_kondisi and $status=="L") { 
	$nunggakpokok=0;
	$nunggakjasa=0;?>
			  <td class="left top right align-center" colspan="3">V-LUNAS <?php echo tgl_ind($tgl_lunas); ?></td>
	<?php } else if($tgl_lunas<=$tgl_kondisi and $status=="R") { 
	$nunggakpokok=0;
	$nunggakjasa=0;?>
			  <td class="left top right align-center" colspan="3">Rescedulling <?php echo tgl_ind($tgl_lunas); ?></td>
	<?php } else if($tgl_lunas<=$tgl_kondisi and $status=="H") { 
	$nunggakpokok=0;
	$nunggakjasa=0;?>
			  <td class="left top right align-center" colspan="3">Penghapusan <?php echo tgl_ind($tgl_lunas); ?></td>
	<?php }else{ ?>
			<td class="left top">					<?php echo number_format($nunggakpokok);?></td>
			<td class="left top right">				<?php echo number_format($nunggakjasa);?></td>
	<?php } 

	
	$salokasi       =$salokasi+$alokasi;
	$stargetpokok   =$stargetpokok+$targetpokok;
	$stargetjasa    =$stargetjasa+$targetjasa;
	$sreallalu      =$sreallalu+$reallalu;
	$sreallalujasa  =$sreallalujasa+$reallalujasa;
	$srealpokok     =$srealpokok+$realpokok;
	$srealjasa      =$srealjasa+$realjasa;
	$sspokok        =$sspokok+$sumpokok;
	$ssjasa         =$ssjasa+$sumjasa;
	$ssaldopinjaman =$ssaldopinjaman+$saldopinjaman;
	$snunggakpokok  =$snunggakpokok+$nunggakpokok;
	$snunggakjasa   =$snunggakjasa+$nunggakjasa;
	
	$sumalokasi =$sumalokasi+$alokasi;
	$sumtargetpokok =$sumtargetpokok+$targetpokok;
	$sumtargetjasa =$sumtargetjasa+$targetjasa;
	$sumreallalu =$sumreallalu+$reallalu;
	$sumreallalujasa =$sumreallalujasa+$reallalujasa;
	$sumrealpokok =$sumrealpokok+$realpokok;
	$sumrealjasa =$sumrealjasa+$realjasa;
	$sumsumpokok =$sumsumpokok+$sumpokok;
	$sumsumjasa =$sumsumjasa+$sumjasa;
	$sumsaldopinjaman =$sumsaldopinjaman+$saldopinjaman;
	$sumnunggakpokok =$sumnunggakpokok+$nunggakpokok;
	$sumnunggakjasa =$sumnunggakjasa+$nunggakjasa;
	
		}
		$jkel=mysql_num_rows($view);
		if($jkel>0){ ?>
		
		<tr align="right" height="15px" class="style9">
		<th class="left top bottom" align="center" colspan=4>Jumlah</th>
			  <th class="left top bottom">					<?php echo number_format($salokasi);?></th>
			  <th class="left top bottom">				</th>
              <th class="left top bottom">					<?php echo number_format($stargetpokok);?></th>
              <th class="left top bottom">					<?php echo number_format($stargetjasa);?></th>
			  <th class="left top bottom">					<?php echo number_format($sreallalu);?></th>              
              <th class="left top bottom">					<?php echo number_format($sreallalujasa);?></th>
			  <th class="left top bottom">					<?php echo number_format($srealpokok);?></th>
              <th class="left top bottom">					<?php echo number_format($srealjasa);?></th>
              <th class="left top bottom">					<?php echo number_format($sspokok);?></th>
              <th class="left top bottom">					<?php echo number_format($ssjasa);?></th>
              <th class="left top bottom">					<?php echo number_format($ssaldopinjaman);?></th>
              <th class="left top bottom">					<?php $spros=round(@($sreallalu/$stargetpokok*100),2); if($spros>=100) {echo "100";}else{echo number_format($spros,2);}?>%</th>
			<th class="left top bottom">					<?php echo number_format($snunggakpokok);?></th>
			<th class="left top  bottom right">				<?php echo number_format($snunggakjasa);?></th>    
		</tr>
		
		<?php }}
		?>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="center" colspan="4">Komulatif Tahun Berjalan (<?php echo $y;?>)</td>
			  <td class="left top">					<?php echo number_format($sumalokasi);?></td>
			  <td class="left top">					</td>
              <td class="left top">					<?php echo number_format($sumtargetpokok);?></td>
              <td class="left top">					<?php echo number_format($sumtargetjasa);?></td>
			  <td class="left top">					<?php echo number_format($sumreallalu);?></td>              
              <td class="left top">					<?php echo number_format($sumreallalujasa);?></td>
			  <td class="left top">					<?php echo number_format($sumrealpokok);?></td>
              <td class="left top">					<?php echo number_format($sumrealjasa);?></td>
              <td class="left top">					<?php echo number_format($sumsumpokok);?></td>
              <td class="left top">					<?php echo number_format($sumsumjasa);?></td>
              <td class="left top">					<?php echo number_format($sumsaldopinjaman);?></td>
              <td class="left top">					<?php $pross=round(@($sumreallalu/$sumtargetpokok*100),2); if($pross>=100) {echo "100";}else{echo number_format($pross,2);}?>%</td>
			  <td class="left top">					<?php echo number_format($sumnunggakpokok);?></td>
			  <td class="left top right">			<?php echo number_format($sumnunggakjasa);?></td>	
		</tr>
		
		<?php 
		$kolom = "tb$yll";
		$clalu=mysql_query("SELECT kd_rekening, $kolom as jumlah FROM rekening_$_SESSION[lokasi] WHERE kd_jb=''"); 
		    while($cl=mysql_fetch_array($clalu)){
		        ?>
		        <?php
		        if($cl['kd_rekening']=="999.01"){
		            $sumalokasiCL=$cl['jumlah'];
		        }elseif($cl['kd_rekening']=="999.02"){
		            $sumtargetpokokCL=$cl['jumlah'];
		        }elseif($cl['kd_rekening']=="999.03"){
		            $sumtargetjasaCL=$cl['jumlah'];
		        }elseif($cl['kd_rekening']=="999.04"){
		            $sumreallaluCL=$cl['jumlah'];
		        }elseif($cl['kd_rekening']=="999.05"){
		            $sumreallalujasaCL=$cl['jumlah'];
		        }
		            $isi=$cl['kd_rekening'];
		    }
		?>
		
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="center" colspan="4">Komulatif s.d Tahun Lalu (<?php echo $yll;?>) </td>
			  <td class="left top">					<?php echo number_format($sumalokasiCL);?></td>
			  <td class="left top">					</td>
              <td class="left top">					<?php echo number_format($sumtargetpokokCL);?></td>
              <td class="left top">					<?php echo number_format($sumtargetjasaCL);?></td>
			  <td class="left top">					<?php echo number_format($sumreallaluCL);?></td>              
              <td class="left top">					<?php echo number_format($sumreallalujasaCL);?></td>
			  <td class="left top">					0</td>
              <td class="left top">					0</td>
              <td class="left top">					<?php echo number_format($sumreallaluCL);?></td>
              <td class="left top">					<?php echo number_format($sumreallalujasaCL);?></td>
              <td class="left top">					<?php echo number_format(0);?></td>
              <td class="left top">					100%</td>
			  <td class="left top">					<?php echo number_format(0);?></td>
			  <td class="left top right">			<?php echo number_format(0);?></td>	
		</tr>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="center" colspan="4">Komulatif s.d. Tahun Berjalan (<?php echo $y;?>)</td>
		      <td class="left top">					<?php echo number_format($sumalokasi+$sumalokasiCL);?></td>
			  <td class="left top">					</td>
              <td class="left top">					<?php echo number_format($sumtargetpokok+$sumtargetpokokCL);?></td>
              <td class="left top">					<?php echo number_format($sumtargetjasa+$sumtargetjasaCL);?></td>
			  <td class="left top">					<?php echo number_format($sumreallalu+$sumreallaluCL);?></td>              
              <td class="left top">					<?php echo number_format($sumreallalujasa+$sumreallalujasaCL);?></td>
			  <td class="left top">					<?php echo number_format($sumrealpokok);?></td>
              <td class="left top">					<?php echo number_format($sumrealjasa);?></td>
              <td class="left top">					<?php echo number_format($sumsumpokok+$sumreallaluCL);?></td>
              <td class="left top">					<?php echo number_format($sumsumjasa+$sumreallalujasaCL);?></td>
              <td class="left top">					<?php echo number_format($sumsaldopinjaman);?></td>
              <td class="left top">					<?php $prosss=round(($pross+100)/2,2);echo number_format($prosss,2);?>%</td>
			  <td class="left top">					<?php echo number_format($sumnunggakpokok);?></td>
			  <td class="left top right">			<?php echo number_format($sumnunggakjasa);?></td>	
		
		</tr>
		<td class="style10 top" colspan="18"><b>Keterangan</b> : Data yang ditampilkan diatas merupakan kelompok aktif pada tahun berjalan (<?php echo $y;?>), untuk menampilkan data kelompok aktif tahun lalu dapat memilih mode tahun lalu (<?php echo $yll;?>).</td>
</table>



<?php include "tanda_tangan.php"; ?> 
	          
</body>
// <title>PK<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title> 