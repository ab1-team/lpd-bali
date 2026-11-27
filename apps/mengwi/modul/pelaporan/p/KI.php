<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

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
$thn_kondisi		="$y-01-01";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
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
						echo "<img class='' alt='...' src='../../../images/upa.png' style='float:left; width:50; margin-right:5px;'>";
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
			Kd.Doc. KI-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
     <tr>
        <td height="20" colspan="10" class="style6 bottom align-center"><br>LAPORAN KOLEKTIBILITAS PINJAMAN <?php echo $jpp;?> REKAP INDIVIDU<br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
    </tr>
			<tr align="center" height="40px" class="style9">
              <th class="left bottom" width="3%">NO</th>
              <th class="left bottom" width="20%">NAMA LENGKAP </th>
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
		$data=mysql_query("SELECT * FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$lokasi' ORDER BY d.id ASC");
		while($r=mysql_fetch_array($data)){
		$idd=$r['id'];
		$no=$no+1;
		$row=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$r[user_id]' "));
		$ja=mysql_num_rows(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] where id='$r[id]' AND jenis_pinjaman='I' "));
		?>
		<tr>
			<td class="style27 left top" colspan="2"><?php echo "$no. ".strtoupper($r['nama_desa']);?></td>
			<td class="style27 left top align-right"><?php echo number_format(saldopinjamanD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top align-right"><?php echo number_format(nunggakpokokD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top align-right"></td>
			<td class="style27 left top align-right"><?php echo number_format(kolek1D("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top align-right"><?php echo number_format(kolek2D("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top align-right"><?php echo number_format(kolek3D("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top align-right"><?php echo number_format(kolek4D("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top right align-right"><?php echo number_format(kolek5D("$tgl_kondisi-$idf-$idd"));?></td>
		</tr>
		<?php
		$view=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE 
		a.id=pi.nia AND pi.sistem_angsuran=sa.id AND a.desa='$r[id]' AND jenis_pp='$idf'  AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.jenis_pinjaman='I' AND pi.status='A' OR
		a.id=pi.nia AND pi.sistem_angsuran=sa.id AND a.desa='$r[id]' AND jenis_pp='$idf'  AND pi.tgl_cair >0  AND pi.tgl_cair <= '$tgl_kondisi' AND pi.jenis_pinjaman='I' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R' OR
		a.id=pi.nia AND pi.sistem_angsuran=sa.id AND a.desa='$r[id]' AND jenis_pp='$idf'  AND pi.tgl_lunas >0  AND pi.tgl_lunas <= '$tgl_kondisi' AND pi.jenis_pinjaman='I' AND pi.tgl_lunas >= '$thn_kondisi' AND pi.status='R'
		ORDER BY a.nik ASC"); 
		$noo=0;
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
			  <td class="left top" align="left">	<?php echo "$row[nik] $row[namadepan] - $row[id]"; ?></td>
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
		} 
		?>
		<tr align="right" height="30px" class="style27">
              <td class="left top bottom" align="center" colspan="2">J U  M L A H</td>
              <td class="left top bottom">					<?php echo number_format($sumsaldopinjaman);?></td>
			  <td class="left top bottom">					<?php echo number_format($sumnunggakpokok);?></td>	
			  <td class="left top bottom"></td>	
			  <td class="left top bottom">					<?php echo number_format($sumkolek1);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek2);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek3);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek4);?></td>			
			  <td class="all">			<?php echo number_format($sumkolek5);?></td>			
		</tr>
</table>

<?php if($_SESSION['lokasi']==351) {?>
    <?php include "ttd_pusat_waeapo.php"; ?> 
<?php } else if ($_SESSION['lokasi']==352 or $_SESSION['lokasi']==353 or$_SESSION['lokasi']==354) {?>
    <?php include "ttd_cab_waeapo.php"; ?> 
<?php } else {?>
    <?php include "tanda_tangan.php"; }?>
	
	          
</body>
<title>KI<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>