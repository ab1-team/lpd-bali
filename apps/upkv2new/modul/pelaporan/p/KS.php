<?php session_start();
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
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date("Y-m-t", strtotime("$y-$m-01")); $kc="M"; $tgl_kondisilalu=date("Y-m-t", strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='$idf' "));
$jpp=$jp['nama_jpp'];
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

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td height="20" colspan="7" class="bottom">
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
			Kd.Doc. KK-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
     <tr>
        <td height="20" colspan="10" class="style6 bottom align-center"><br>LAPORAN KOLEKTIBILITAS PINJAMAN <?php echo $jpp;?> REKAP KELOMPOK <br><?php echo strtoupper("$sebutan_desa $nama_desa");?><br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
    </tr>
			<tr align="center" height="40px" class="style9">
              <th class="left bottom" width="3%">NO</th>
              <th class="left bottom" width="20%">KELOMPOK</th>
              <th class="left bottom" width="10%">SALDO PINJAMAN </th>
              <th class="left bottom" width="10%">&Sigma; TUNGGAKAN<br>POKOK</th>
              <th class="left bottom" width="3%">&Sigma;</th>
              <th class="left bottom" width="10%">KOLEK I<br>Tanpa Tunggakan</th>
              <th class="left bottom" width="10%">KOLEK II<br>Menunggak 1-2</th>
              <th class="left bottom" width="10%">KOLEK III<br>Menunggak 3-4</th>
              <th class="left bottom" width="10%">KOLEK IV <br>Menunggak 5-6</th>
              <th class="left bottom right" width="10%">KOLEK V <br>Menunggak &gt; 6</th>
            </tr>
	  <?php
		$data=mysql_query("SELECT d.id, d.nama_desa FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$lokasi' AND d.kd_desa='$kd_desa' ORDER BY d.id ASC");
		while($r=mysql_fetch_array($data)){
		$idd=$r['id'];
		$no=$no+1;
		$row=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$r[user_id]' "));
		$ja=mysql_num_rows(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$r[id]' "));
		?>
		<tr>
			<td class="style27 left top right" colspan="10"><?php echo "$no. ".ucfirst($r['nama_desa']);?></td>
		</tr>
		<?php
		$view=mysql_query("SELECT * FROM kelompok_$_SESSION[kd_kab] k, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H'
		ORDER BY k.kd_kelompok ASC"); 
		$noo=0;
		
		$sumsaldopinjaman	= 0;
		$sumnunggakpokok	= 0;
		$sumkolek1			= 0;
		$sumkolek2			= 0;
		$sumkolek3			= 0;
		$sumkolek4			= 0;
		$sumkolek5			= 0;
		
		while($row=mysql_fetch_array($view)){
		$noo=$noo+1;
		$idp	=$row['id'];
		$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$idp);
		$nunggakpokok	=nunggakpokok($tgl_kondisi."-".$idp);
		$jum_nunggak	=jum_nunggak($tgl_kondisi."-".$idp);
		$kolek1			=kolek1($tgl_kondisi."-".$idp);
		$kolek2			=kolek2($tgl_kondisi."-".$idp);
		$kolek3			=kolek3($tgl_kondisi."-".$idp);
		$kolek4			=kolek4($tgl_kondisi."-".$idp);
		$kolek5			=kolek5($tgl_kondisi."-".$idp);
		
		$jangka			=jangka($idp);
		
		if($jum_nunggak>0 and $jum_nunggak<$jangka){$sig_nunggak=floor($jum_nunggak)."+";}elseif($jum_nunggak>$jangka){$sig_nunggak=$jangka."+";}else{$sig_nunggak=$jum_nunggak;}
		
		?>
		<tr align="right" height="15px" class="style9">
              <td class="left top" align="center">	<?php echo $noo;?></td>
			  <td class="left top" align="left">	<?php echo "$row[kd_kelompok] $row[nama_kelompok] - $row[id]"; ?></td>
			  <td class="left top">					<?php echo number_format($saldopinjaman);?></td>
              <td class="left top">					<?php echo number_format($nunggakpokok);?></td>
              <td class="left top align-center">	<?php echo $sig_nunggak;?></td>
              <td class="left top">					<?php echo number_format($kolek1);?></td>
              <td class="left top">					<?php echo number_format($kolek2);?></td>
              <td class="left top">					<?php echo number_format($kolek3);?></td>
              <td class="left top">					<?php echo number_format($kolek4);?></td>
              <td class="left top right">			<?php echo number_format($kolek5);?></td>
		</tr>
		<?php
		$sumsaldopinjaman	=$sumsaldopinjaman+$saldopinjaman;
		$sumnunggakpokok	=$sumnunggakpokok+$nunggakpokok;
		$sumkolek1			=$sumkolek1+$kolek1;
		$sumkolek2			=$sumkolek2+$kolek2;
		$sumkolek3			=$sumkolek3+$kolek3;
		$sumkolek4			=$sumkolek4+$kolek4;
		$sumkolek5			=$sumkolek5+$kolek5;
		}
		$jsumsaldopinjaman	=$jsumsaldopinjaman+$sumsaldopinjaman;
		$jsumnunggakpokok	=$jsumnunggakpokok+$sumnunggakpokok;
		$jsumkolek1			=$jsumkolek1+$sumkolek1;
		$jsumkolek2			=$jsumkolek2+$sumkolek2;
		$jsumkolek3			=$jsumkolek3+$sumkolek3;
		$jsumkolek4			=$jsumkolek4+$sumkolek4;
		$jsumkolek5			=$jsumkolek5+$sumkolek5;
		?>
		<tr align="right" height="30px" class="style27">
              <td class="left top bottom" align="center" colspan="2">Jumlah Desa <?php echo strtoupper($r['nama_desa']); ?></td>
              <td class="left top bottom">					<?php echo number_format($sumsaldopinjaman);?></td>
			  <td class="left top bottom">					<?php echo number_format($sumnunggakpokok);?></td>	
			  <td class="left top bottom"></td>	
			  <td class="left top bottom">					<?php echo number_format($sumkolek1);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek2);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek3);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek4);?></td>			
			  <td class="all">			<?php echo number_format($sumkolek5);?></td>			
		</tr>
		
		<?php
		} 
		?>
		<tr align="right" height="30px" class="style27">
              <td class="left top bottom" align="center" colspan="2">J U M L A H</td>
              <td class="left top bottom">					<?php echo number_format($jsumsaldopinjaman);?></td>
			  <td class="left top bottom">					<?php echo number_format($jsumnunggakpokok);?></td>	
			  <td class="left top bottom"></td>	
			  <td class="left top bottom">					<?php echo number_format($jsumkolek1);?></td>			
			  <td class="left top bottom">					<?php echo number_format($jsumkolek2);?></td>			
			  <td class="left top bottom">					<?php echo number_format($jsumkolek3);?></td>			
			  <td class="left top bottom">					<?php echo number_format($jsumkolek4);?></td>			
			  <td class="all">			<?php echo number_format($jsumkolek5);?></td>			
		</tr>
</table>

<?php include "tanda_tangan.php"; ?> 		
	          
</body>
<title>KK<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>