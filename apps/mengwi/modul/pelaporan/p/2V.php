<?php
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

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
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date("Y-m-t", strtotime("$y-$m")); $kc="M"; $tgl_kondisilalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$tgl_last=date('Y-m-t', strtotime("$tgl_kondisi"));

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c, lkm l where k.id=c.kd_kab AND c.id=l.lokasi AND l.lokasi='$lokasi' "));
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
			    $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c, lkm l where k.id=c.kd_kab  AND c.id=l.lokasi AND l.lokasi='$lokasi'")); 
											$alamat_lkm =$row ['alamat'];
											$exp	    = explode("#", $alamat_lkm);    
	                                        $alamat1    = $exp[0];
			                                $desa1      = $exp[1];
			                                $kodepos1   = $exp[2];
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$ijin_usaha	=$row ['ijin_usaha'];
			if (empty($ijin_usaha)) {$ijin="";}else{$ijin="Badan Hukum No.$ijin_usaha<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[jenis_lkm] LKM $row[nama_lkm_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$ijin $alamat1 $desa1 $kodepos1 Telp. $row[telpon_kec] </div>"; 
			?>
		</td>
		<td height="20" colspan="8" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. I2 Lembar-1 </div>
		</td>
	</tr> 
    <tr>
        <td height="20" colspan="14" class="style6 bottom align-center"><br>DAFTAR RINCIAN PINJAMAN INDIVIDU YANG DIBERIKAN (Aktif) <br><br></td>
    </tr>
    <tr>
            <td colspan="2" width="30%" class="style9">NAMA LKM</td>
            <td colspan="10"  width="60%" class="style9">: <?php echo "$row[nama_lkm_long]" ;?></td>
	    </tr>
	     <tr>
            <td colspan="2" width="30%" class="style9">SANDI LKM</td>
            <td colspan="10"  width="60%" class="style9">: <?php echo "$row[sandi_lkm]" ;?></td>
	    </tr>
	     <tr>
            <td colspan="2" width="30%" class="style9 bottom">PERIODE LAPORAN</td>
            <td colspan="10" width="60%" class="style9 bottom">: <?php echo tgl_indo($tgl_kondisi) ;?></td>
	    </tr>
			<tr align="center" height="30px" class="style9 ">
              <th width="2%" rowspan="2" class="left bottom">No</th>
              <th width="20%" rowspan="2" class="left bottom">Peminjam - Loan ID</a></th>
              <th width="10%" rowspan="2" class="left bottom">Jenis Penggunaan</a></th>
			  <th width="7%" rowspan="2" class="left bottom">Periode Pembayaran</a></th>
			  <th colspan="2" class="left bottom">Jangka Waktu</a></th>
			  <th colspan="2" class="left bottom">Suku Bunga</a></th>
              <th width="3%" rowspan="2" class="left bottom">Plafon</a></th>
              <th width="7%" rowspan="2" class="left bottom">Baki Debet</a></th>
			  <th width="3%" rowspan="2" class="left bottom">Jumlah Tunggakan (X)</a></th>
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
$view=mysql_query("SELECT pa.id, 
								  pa.alokasi, 
								  a.namadepan, 
								  pa.tgl_cair, 
								  pa.tgl_lunas, 
								  pa.pros_jasa,
								  pa.`status`, 
								  pa.jangka, 
								  sa.sistem, 
								  sa.nama_sistem, 
								  a.nik	
								  
		FROM 
			anggota_$_SESSION[kd_kab] a, 
			sistem_angsuran sa, 
			pinjaman_anggota_$_SESSION[kd_kab] pa 
		WHERE 
			a.id=pa.nia AND pa.sistem_angsuran=sa.id AND a.desa='$r[id]' AND pa.tgl_lunas >0  AND pa.tgl_lunas <= '$tgl_kondisi' AND pa.jenis_pinjaman='I' AND pa.tgl_lunas >= '$thn_kondisi' AND pa.status='L' OR 
			a.id=pa.nia AND pa.sistem_angsuran=sa.id AND a.desa='$r[id]' AND pa.tgl_lunas >0  AND pa.tgl_lunas <= '$tgl_kondisi' AND pa.jenis_pinjaman='I' AND pa.tgl_lunas >= '$thn_kondisi' AND pa.status='R' OR
			a.id=pa.nia AND pa.sistem_angsuran=sa.id AND a.desa='$r[id]' AND pa.tgl_lunas >0  AND pa.tgl_lunas <= '$tgl_kondisi' AND pa.jenis_pinjaman='I' AND pa.tgl_lunas >= '$thn_kondisi' AND pa.status='H'
		ORDER BY a.nik ASC"); 
		$noo=0;
		$jind=mysql_num_rows($view);
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
			<td class="style27 left top right" colspan="14"><?php echo "$no. ".strtoupper($r['nama_desa']);?></td>
		</tr>
		<?php
		
		while($row=mysql_fetch_array($view)){
		$noo=$noo+1;
		$idp	=$row['id'];
		$alokasi		=$row['alokasi'];
		$tgl1 = $row['tgl_cair'];
		$penambahan ="+".$row['jangka']." month";
        $tgl2 = date('Y-m-d', strtotime($penambahan, strtotime($tgl1)));
		$pros_jasa 		=number_format($row['pros_jasa']);
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
		if($saldopinjaman==0){
		    $jum_nunggak	=0; 
		}else{
		        $jum_nunggak	=jum_nunggak($tgl_kondisi."-".$idp); 
		    if($jum_nunggak<=0){
		        $jum_nunggak	=0; 
		    }
		}
		
		?>
			<tr align="right" height="15px" class="style9">
              <td class="left top" align="center">	<?php echo $noo;?></td>
			  <td class="left top" align="left">	<?php echo "$row[nik] $row[namadepan] -$idp"; ?></td>
			  <td class="left top" align="left">	Pinjaman Modal Kerja</td>
			  <td class="left top" align="center">	<?php echo "$row[nama_sistem]";?></td>
              <td class="left top" align="center">	<?php echo tgl_ind($tgl1); ?></td>
              <td class="left top" align="center">	<?php echo tgl_ind($tgl2); ?></td>
			  <td class="left top">					<?php echo $pros_jasa;?>%</td>
              <td class="left top" align="center">	<?php echo "per bulan"; ?></td>
			  <td class="left top">					<?php echo number_format($alokasi);?></td>
              <td class="left top">					<?php echo number_format($saldopinjaman);?></td>
			  <td class="left top">					<?php echo "$jum_nunggak";?></td>
			  <td class="left top right" align="left">			
			  <?php
			  if($jum_nunggak<=3){
			      echo "Lancar";
			      $lancar=$lancar+$saldopinjaman;
			  }elseif($jum_nunggak<=5){
			      echo "Diragukan";
			      $diragukan=$diragukan+$saldopinjaman;
			  }else{
			      echo "Macet";
			      $macet=$macet+$saldopinjaman;
			  }
			  
			  ?>
			  
			  </td> 

	<?php $sumalokasi			=$sumalokasi+$alokasi;
	       $sumsaldopinjaman   =$sumsaldopinjaman+$saldopinjaman;
	       $jumlah              =1;
	       $jumlahanggota       =$jumlahanggota+$jumlah;
		}
		/*
lancar = <?php echo "$lancar"; ?> <br>
Diragukan = <?php echo "$diragukan"; ?> <br>
Macet = <?php echo "$macet"; ?> <br>
*/
		
		if($jind>0){
		?>
		
		<?php }}
		?>
		<tr class="style9">
		    <th colspan="8" class="left top" align="center">TOTAL (<?php echo $jumlahanggota;?> Anggota)</th>
		    <th class="left top" align="right"><?php echo number_format($sumalokasi) ;?></th>
		    <th class="left top" align="right"><?php echo number_format($sumsaldopinjaman) ;?></th>
		    <th colspan="2" class="left right top" align="right"></th>
		</tr>
		<tr>
		<td class="style10 top" colspan="13"><b>Keterangan</b> : Data yang ditampilkan diatas merupakan Individu aktif pada tahun berjalan (<?php echo $y;?>), untuk menampilkan data Individu aktif tahun lalu dapat memilih mode tahun lalu (<?php echo $yll;?>).</td>
		</tr>
</table>

<?php include "tanda_tangan.php"; ?> 
<title>PI 2<?php echo tgl_indo($tgl);?></title> 