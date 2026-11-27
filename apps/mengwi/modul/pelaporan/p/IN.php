<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_inventaris.php";

$lokasi				=$_SESSION['lokasi'];
$tabel				="inventaris_$_SESSION[kd_kab]";

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
$th_lalu			="".($y-1)."-12-31";

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$lokasi' "));
$tgl_open		=$kec['tgl_open'];
$tgl_close		=$kec['tgl_close'];
$bln_lalu		=mktime(0, 0, 0, $m-1, $tgl_open, $y);
if($tgl_open>$tgl_close) { $tgl_awal=date("Y-m-d", $bln_lalu); }else{ $tgl_awal="$y-$m-$tgl_open"; }

if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $kondisi="tgl_beli='$tgl'"; $tgl_kondisi=$tgl;}
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $kondisi="tgl_beli <= '$y-$m-$tgl_close' "; $tgl_kondisi="$y-$m-$tgl_close"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $kondisi="tgl_beli <= '$y-12-31' "; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

if($idf=="10") {
	$idjenis="2";
	$namajenis="Biaya Dibayar Dimuka";
	$kolom="AMORTISASI";
}else if($idf=="11") {
	$idjenis="1";
	$namajenis="Daftar Inventaris";
	$kolom="SUSUT";
}else if($idf=="12") {
	$idjenis="3";
	$namajenis="Aktifa Tetap";
	$kolom="AMORTISASI";
}
?>


<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
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
		<td height="20" colspan="5" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. IN01 Lembar-1 </div>
		</td>
	</tr> 
     <tr>
        <td height="20" colspan="15" class="style6 bottom align-center"><br>LAPORAN <?php echo strtoupper("$namajenis<br>$jenis".tgl_indo($tgl));?></td>
    </tr>
	<tr>
	    <th width="2%" height="30" class="style9 all" rowspan="2">NO</th>
	    <th width="7%" class="style9 top bottom" rowspan="2">TANGGAL BELI</th>
	    <th width="25%" class="style9 all" rowspan="2">NAMA BARANG</th>
	    <th width="3%" class="style9 top bottom right" rowspan="2">ID</th>
	    <th width="3%" class="style9 top bottom right" rowspan="2">KON<br>DISI</th>
	    <th width="3%" class="style9 top bottom" rowspan="2">UNIT</th>
	    <th width="7%" class="style9 all" rowspan="2">HARGA SATUAN</th>
	    <th width="8%" class="style9 top bottom" rowspan="2">HARGA PEROLEHAN</th>
	    <th width="3%" class="style9 all" rowspan="2">UMUR<br>EKO.</th>
	    <th width="5%" class="style9 top bottom right" rowspan="2">SATUAN<BR><?php echo $kolom;?></th>
	    <th class="style9 top bottom right" colspan="2">TAHUN INI</th>
	    <th class="style9 top bottom right" colspan="2">S.D. TAHUN INI</th>
	    <th width="10%" class="style9 top bottom right" rowspan="2">NILAI BUKU</th>
    </tr>
	<tr>
		<th width="2%" class="style9 bottom right">UMUR PAKAI</th>
	    <th width="5%" class="style9 bottom right">BIAYA<BR><?php echo $kolom;?></th>
		<th width="2%" class="style9 bottom right">UMUR PAKAI</th>
	    <th width="7%" class="style9 bottom right">AKUM.<BR><?php echo $kolom;?></th>
    </tr>
	  <?php
		$data=mysql_query("SELECT * FROM $tabel WHERE $kondisi AND lokasi='$lokasi' AND jenis='$idjenis' order by tgl_beli asc");
		while($ju=mysql_fetch_array($data)){
		$no=$no+1;
		$id				=$ju['id'];
		$tgl_beli		=$ju['tgl_beli'];
		$nama_barang	=$ju['nama_barang'];
		$unit			=$ju['unit'];
		$harsat			=$ju['harsat'];
		$status			=$ju['status'];
		$tgl_validasi	=$ju['tgl_validasi'];
		$harga			=$unit*$harsat;
		$umur_ekonomis	=$ju['umur_ekonomis'];
		$penyusutan		=floor(@($harga/$umur_ekonomis));
		$pakai_lalu		=bulan($tgl_beli,$th_lalu);
		$nilaibuku		=nilaibuku("$tgl_kondisi-$id");
		
		if($status!="Baik" AND $tgl_kondisi>$tgl_validasi) {
			$ak_umur		=bulan($tgl_beli,$tgl_validasi);
			$namabarang		="$nama_barang <span style='color:red;'>($status $tgl_validasi)</span>";
		}else{
			$ak_umur		=bulan($tgl_beli,$tgl_kondisi);
			$namabarang		=$nama_barang;
		}
			
		$ak_susut		=@($penyusutan*$ak_umur);
		
		if($ak_umur>=$umur_ekonomis and $harga>0 and $idf!="10") {
			$ak_umurpakai	=$umur_ekonomis; 
			$ak_penyusutan	=$harga-1; 
			$nilai_buku		=1;
		}else if($ak_umur>=$umur_ekonomis and $harga>0 and $idf=="10") {
			$ak_umurpakai	=$umur_ekonomis; 
			$ak_penyusutan	=$harga; 
			$nilai_buku		="0";
		}else{
			$ak_umurpakai	=$ak_umur; 
			$ak_penyusutan	=$ak_susut; 
			$nilai_buku		=$nilaibuku; 
		}
		
		if($status=="Rusak" AND $tgl_kondisi>$tgl_validasi) {
			$ak_penyusutan	=$harga-1; 
			$nilai_buku		=1;
		}else if($status=="Hilang" AND $tgl_kondisi>$tgl_validasi OR $status=="Dijual" AND $tgl_kondisi>$tgl_validasi OR $status=="Hapus" AND $tgl_kondisi>$tgl_validasi) {
			$ak_penyusutan	=$harga; 
			$nilai_buku		=0;
		}
		
		$umurpakai		=$ak_umurpakai-$pakai_lalu;
		$susut			=@($penyusutan*$umurpakai);
		if($umurpakai>=0 and $harga>0){$umur_pakai=$umurpakai; $biaya_susut=$susut; }else{$umur_pakai=0; $biaya_susut=0; }
		
		if($idf=="10") {
			$ak_penyusutan=$ak_penyusutan;
			$nilai_buku=$nilai_buku;
		}else if($idf=="11") {
			$ak_penyusutan=$ak_penyusutan;
			$nilai_buku=$nilai_buku;
		}else if($idf=="12") {
			$ak_penyusutan="0";
			$nilai_buku=$harga;
		}

		?>
	<tr>
	    <td height="25" class="style9 left right bottom"><div align="center"><?php echo $no;?></div></td>
	    <td class="style9 bottom align-center"><?php echo $ju['tgl_beli'];?></td>
	    <td class="style9 left right bottom"><?php echo $namabarang;?></td>
	    <td class="style9 right bottom align-center"><?php echo $id;?></td>
	    <td class="style9 right bottom align-center"><?php echo $status;?></td>
	    <td class="style9 bottom align-center"><?php echo $unit;?></td>
	    <td class="style9 left bottom right align-right"><?php echo number_format($harsat);?></td>
	    <td class="style9 bottom align-right"><?php echo number_format($harga);?></td>
	    <td class="style9 left bottom right align-center"><?php echo $umur_ekonomis;?></td>
	    <td class="style9 bottom right align-right"><?php echo number_format($penyusutan);?></td>
	    <td class="style9 bottom right align-center"><?php echo $umur_pakai; ?></td>
	    <td class="style9 bottom right align-right"><?php echo number_format($biaya_susut);?></td>
	    <td class="style9 bottom right align-center"><?php echo $ak_umurpakai; ?></td>
	    <td class="style9 bottom right align-right"><?php echo number_format($ak_penyusutan); ?></td>
	    <td class="style9 bottom right align-right"><?php echo number_format($nilai_buku); ?></td>
	</tr>
  <?php 
  $totunit=$totunit+$unit;
  $totharga=$totharga+$harga;
  $totbiaya_susut=$totbiaya_susut+$biaya_susut;
  $totak_penyusutan=$totak_penyusutan+$ak_penyusutan;
  $totnilai_buku=$totnilai_buku+$nilai_buku;
  
  } ?>
	<tr>
	    <th height="25" class="style9 left right bottom" colspan="5"><div align="center">JUMLAH</div></th>
	    <th class="style9 bottom align-center"><?php echo $totunit;?></th>
	    <th class="style9 left bottom right align-right">&nbsp;</th>
	    <th class="style9 bottom align-right"><?php echo number_format($totharga);?></th>
	    <th class="style9 left bottom right align-center">&nbsp;</th>
	    <th class="style9 bottom right align-right">&nbsp;</th>
	    <th class="style9 bottom right align-center">&nbsp;</th>
	    <th class="style9 bottom right align-right"><?php echo number_format($totbiaya_susut); ?></th>
	    <th class="style9 bottom right align-center">&nbsp;</th>
	    <th class="style9 bottom right align-right"><?php echo number_format($totak_penyusutan); ?></th>
	    <th class="style9 bottom right align-right"><?php echo number_format($totnilai_buku); ?></th>
	</tr>
</table>

<?php if($_SESSION['lokasi']==351) {?>
    <?php include "ttd_pusat_waeapo.php"; ?> 
<?php } else if ($_SESSION['lokasi']==352 or $_SESSION['lokasi']==353 or$_SESSION['lokasi']==354) {?>
    <?php include "ttd_cab_waeapo.php"; ?> 
<?php } else {?>
    <?php include "tanda_tangan.php"; }?>

</body>
<title>IN01. Inventaris <?php echo "$jenis ".tgl_indo($tgl);?></title>