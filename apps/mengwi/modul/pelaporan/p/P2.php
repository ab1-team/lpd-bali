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
	$idf				=2;
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
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $kc="M"; $tgl_kondisilalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
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
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$row[sebutan_kec] $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
		</td>
		<td height="20" colspan="8" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. PK-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
    <tr>
        <td height="20" colspan="18" class="style6 bottom align-center"><br>LAPORAN PERKEMBANGAN PINJAMAN REKAP KELOMPOK <br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
    </tr>
			<tr align="center" height="30px" class="style9">
              <th width="2%" rowspan="2" class="left bottom">No</th>
              <th width="20%" rowspan="2" class="left bottom">Peminjam - Loan ID</a></th>
			  <th width="4%" rowspan="2" class="left bottom">Musiman</a></th>
			  <th colspan="2" class="left bottom">Jangka Waktu</a></th>
			  <th colspan="2" class="left bottom">Suku Bunga</a></th>
              <th width="3%" rowspan="2" class="left bottom">Jumlah Pinjaman</a></th>
              <th width="7%" rowspan="2" class="left bottom">Sisa Pokok Pinjaman</a></th>
			  <th width="3%" rowspan="2" class="left bottom">Angsuran Yang Sudah Dibayar (X)</a></th>
			  <th width="3%" rowspan="2" class="left bottom">Jumlah Tunggakan  Angsuran Musiman (X)</a></th>
			  <th width="3%" rowspan="2" class="left bottom">Tanggal Pelaporan</a></th>
			  <th width="3%" rowspan="2" class="left right bottom">Kolektibilitas</a></th>
            </tr>
            <tr align="center"  height="30px" class="style9">
			  <th width="5%" class="left bottom">Mulai </th>
              <th width="5%" class="left bottom">Jatuh Tempo</th>
			  <th width="5%" class="left bottom">%</th>
              <th width="5%" class="left bottom">Keterangan</th>
			  
            </tr>
	  <?php
		$data=mysql_query("SELECT d.id, d.nama_desa FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$lokasi' ORDER BY d.id ASC");
		$no=0;
		while($r=mysql_fetch_array($data)){
		$idd=$r['id'];
		$no=$no+1;
$view=mysql_query("SELECT pk.id, 
								  pk.alokasi, 
								  k.nama_kelompok, 
								  pk.tgl_cair, 
								  pk.tgl_lunas, 
								  pk.pros_jasa,
								  pk.`status`, 
								  pk.jangka, 
								  sa.sistem, 
								  sa.nama_sistem, 
								  k.kd_kelompok	
								  
		FROM 
			kelompok_$_SESSION[kd_kab] k, 
			sistem_angsuran sa, 
			pinjaman_kelompok_$_SESSION[kd_kab] pk 
		WHERE 
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND pk.tgl_cair <= '$tgl_kondisi' AND pk.`status`='A'
		ORDER BY k.kd_kelompok ASC"); 
		$noo=0;
		$jkel=mysql_num_rows($view);
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
		?>
		<tr>
			<td class="style27 left top right" colspan="13"><?php echo "$no. ".strtoupper($r['nama_desa']);?></td>
		</tr>
		<?php
		
		while($row=mysql_fetch_array($view)){
		$noo=$noo+1;
		$idp	=$row['id'];
		$alokasi		=$row['alokasi'];
		$tgl1 = $row['tgl_cair'];
		$penambahan ="+".$row['jangka']." month";
        $tgl2 = date('Y-m-d', strtotime($penambahan, strtotime($tgl1)));
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
		$pokokaja       =wajibpokokaja($idp);
		$angsuranke		=angsuranke("$tgl_kondisi-P-$idp");
		$dibayar        =floor($sumpokok/$pokokaja);
		$menunggak      =ceil($nunggakpokok/$pokokaja);
		
		?>
			<tr align="right" height="15px" class="style9">
              <td class="left top" align="center">	<?php echo $noo;?></td>
			  <td class="left top" align="left">	<?php echo "$row[kd_kelompok] $row[nama_kelompok] -$idp"; ?></td>
			  <td class="left top" align="center">	<?php echo "$row[nama_sistem]";?></td>
              <td class="left top" align="center">	<?php echo tgl_ind($tgl1); ?></td>
              <td class="left top" align="center">	<?php echo tgl_ind($tgl2); ?></td>
			  <td class="left top">					<?php echo substr($pros_jasa,0,4);?>%</td>
              <td class="left top" align="center">	<?php echo "per bulan"; ?></td>
			  <td class="left top">					<?php echo number_format($alokasi);?></td>
              <td class="left top">					<?php echo number_format($saldopinjaman);?></td>
              <td class="left top">					<?php echo $dibayar;?></td>
			<td class="left top">					<?php echo $menunggak;?></td>
              <td class="left top" align="center">	<?php echo tgl_ind($tgl_kondisi); ?></td>
			  <td class="left top right" align="left">			
			  <?php
			  if($menunggak<=3){
			      echo "Lancar";
			  }elseif($menunggak<=5){
			      echo "Diragukan";
			  }else{
			      echo "Macet";
			  }
			  
			  ?>
			  
			  </td> 

	<?php
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
		
		if($jkel>0){
		?>
		
		<?php }}
		?><tr>
		<td class="style10 top" colspan="13"><b>Keterangan</b> : Data yang ditampilkan diatas merupakan kelompok aktif pada tahun berjalan (<?php echo $y;?>), untuk menampilkan data kelompok aktif tahun lalu dapat memilih mode tahun lalu (<?php echo $yll;?>).</td>
		</tr>
</table>



<?php include "tanda_tangan.php"; ?> 
	          
</body>
// <title>PK<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title> 