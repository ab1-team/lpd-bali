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
$tgl_t = date('Y-m-t', strtotime($tgl));
if($tgl_open>$tgl_close) { $tgl_awal=date("Y-m-d", $bln_lalu); }else{ $tgl_awal="$y-$m-$tgl_open"; }

if($d=$d){$laporan="Harian"; $jenis="Tanggal";  $tgl_kondisi=$tgl;}
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan";  $tgl_kondisi = date('Y-m-t', strtotime("$y-$m-01")); }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}
$kondisi="tgl_beli <= $tgl_kondisi "; 

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
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
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
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
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
	  $fil =0;
	  for($kat=1;$kat<=3;$kat++){
	      $no=0;
	   if($idjenis==1){
	   if($kat==1){ ?>
	       <tr>
	       <td class="style9 top bottom left right align-left" colspan="15"><strong>1. Gedung Dan Bangunan</strong></td>
	       </tr>
	   <?php }
	   elseif($kat==2){ ?>
	       <tr>
	       <td class="style9 top bottom left right align-left" colspan="15"><strong>2. Kendaraan Dan Alat Berat</strong></td>
	       </tr>
	   <?php }
	   else{ ?>
	       <tr>
	       <td class="style9 top bottom left right align-left" colspan="15"><strong>3. Umum</strong></td>
	       </tr>
	   <?php }
		$data=mysql_query("SELECT * FROM $tabel WHERE tgl_beli <= '$tgl_kondisi' AND lokasi='$lokasi' AND jenis='$idjenis' AND kategori='$kat' OR tgl_beli <= '$tgl_kondisi' AND lokasi='$lokasi' AND jenis='$idjenis' AND kategori=NULL order by tgl_beli asc");
	   }elseif($fil==0){
	   	$data=mysql_query("SELECT * FROM $tabel WHERE tgl_beli <= '$tgl_kondisi' AND lokasi='$lokasi' AND jenis='$idjenis' order by tgl_beli asc");
	   	$fil=1;
	   }
	   
		while($ju=mysql_fetch_array($data)){
		$id				=$ju['id'];
		$tgl_beli		=$ju['tgl_beli'];
		$tgl_toleransi_b=tgl_toleransi($tgl_beli);
		$nama_barang	=$ju['nama_barang'];
		$unit			=$ju['unit'];
		$harsat			=$ju['harsat'];
		$status			=$ju['status'];
		$tgl_validasi	=$ju['tgl_validasi'];
		$tgl_toleransi_v=tgl_toleransi($tgl_validasi);
		$harga			=$unit*$harsat;
		$umur_ekonomis	=$ju['umur_ekonomis'];
		$penyusutan		=floor(@($harga/$umur_ekonomis));
		$pakai_lalu		=bulan($tgl_toleransi_b,$th_lalu);
		$nilaibuku		=nilaibuku("$tgl_kondisi-$id");
		
		if($status!="Baik" AND $tgl_kondisi>=$tgl_toleransi_v) {
			$ak_umur		=bulan($tgl_toleransi_b,$tgl_toleransi_v);
			$namabarang		="$nama_barang <span style='color:red;'>($status $tgl_validasi)</span>";
		}else{
			$ak_umur		=bulan($tgl_toleransi_b,$tgl_kondisi);
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
		
		if($status=="Rusak" AND $tgl_kondisi>=$tgl_toleransi_v) {
			$ak_penyusutan	=$harga-1; 
			$nilai_buku		=1;
		}else if($status=="Hilang" AND $tgl_kondisi>=$tgl_toleransi_v OR $status=="Dijual" AND $tgl_kondisi>=$tgl_toleransi_v OR $status=="Hapus" AND $tgl_kondisi>=$tgl_toleransi_v) {
			$ak_penyusutan	=$harga; 
			$nilai_buku		=0;
		}
		
		$umurpakai		=$ak_umurpakai-$pakai_lalu;
		if($umurpakai<$ak_umurpakai){
		    $umurpakai1 = $umurpakai+1;
		}else{
		    $umurpakai1 = $umurpakai;
		}
		
		$susut			=@($penyusutan*$umurpakai1);
		if($umurpakai>=0 and $harga>0){
		  //  if($nilai_buku>1){
		        $umur_pakai=$umurpakai; $biaya_susut=$susut; 
		        
		  //  }else{$umur_pakai=$umurpakai; $biaya_susut=0; }}
		}else{$umur_pakai=0; $biaya_susut=0; }
		
		
		if($idf=="10") {
			$ak_penyusutan=$ak_penyusutan;
			$nilai_buku=$nilai_buku;
		}else if($idf=="11") {
			$ak_penyusutan=$ak_penyusutan;
			$nilai_buku=$nilai_buku;
		}else if($idf=="12" AND $status!="Dijual") {
			$ak_penyusutan="0";
			$nilai_buku=$harga;
		}else if($idf=="12" AND $status=="Dijual") {
			$ak_penyusutan="0";
			$nilai_buku="0";
		}
		$tahunval = substr($tgl_toleransi_v,0,4);
		
        if($idf!=10 AND $nilai_buku==0 AND $tahunval<$y){
  $totunit1=$totunit1+$unit;
  $totharga1=$totharga1+$harga;
        }else{
		$no=$no+1;
		?>
	<tr>
	    <td height="25" class="style9 left right bottom"><div align="center"><?php echo $no;?></div></td>
	    <td class="style9 bottom align-center"><?php echo $ju['tgl_beli'];?></td>
	    <td class="style9 left right bottom"><?php echo $namabarang;?></td>
	    <td class="style9 right bottom align-center"><?php echo "$id";?></td>
	    <td class="style9 right bottom align-center"><?php echo $status;?></td>
	    <td class="style9 bottom align-center"><?php echo $unit;?></td>
	    <td class="style9 left bottom right align-right"><?php echo number_format_koma($harsat);?></td>
	    <td class="style9 bottom align-right"><?php echo number_format_koma($harga);?></td>
	    <td class="style9 left bottom right align-center"><?php echo $umur_ekonomis;?></td>
	    <td class="style9 bottom right align-right"><?php echo number_format_koma($penyusutan);?></td>
	    <td class="style9 bottom right align-center"><?php echo $umur_pakai; ?></td>
	    <td class="style9 bottom right align-right"><?php echo number_format_koma($biaya_susut);?></td>
	    <td class="style9 bottom right align-center"><?php echo $ak_umurpakai; ?></td>
	    <td class="style9 bottom right align-right"><?php echo number_format_koma($ak_penyusutan); ?></td>
	    <td class="style9 bottom right align-right"><?php echo number_format_koma($nilai_buku); ?></td>
	</tr>
  <?php 
  $totunit=$totunit+$unit;
  $totharga=$totharga+$harga;
  $totbiaya_susut=$totbiaya_susut+$biaya_susut;
  $totak_penyusutan=$totak_penyusutan+$ak_penyusutan;
  $totnilai_buku=$totnilai_buku+$nilai_buku;
  $jum_unit=$totunit+$totunit1;
	}
  
  }} ?>
	<tr>
	    <th height="25" class="style9 left right bottom" colspan="5"><div align="left">4. Jumlah Inventaris Tahun Ini </div></th>
	    <th class="style9 bottom align-center"><?php echo $totunit;?></th>
	    <th class="style9 left bottom right align-right">&nbsp;</th>
	    <th class="style9 bottom align-right"><?php echo number_format_koma($totharga);?></th>
	    <th class="style9 left bottom right align-center">&nbsp;</th>
	    <th class="style9 bottom right align-right">&nbsp;</th>
	    <th class="style9 bottom right align-center">&nbsp;</th>
	    <th class="style9 bottom right align-right">&nbsp;</th>
	    <th class="style9 bottom right align-center">&nbsp;</th>
	    <th class="style9 bottom right align-right"><?php echo number_format_koma($totak_penyusutan);?></th>
	    <th class="style9 bottom right align-right"><?php echo number_format_koma($totnilai_buku); ?></th>
	</tr>
	<tr>
	    <th height="25" class="style9 left right bottom" colspan="5"><div align="left">5. Jumlah Inventaris (Hapus, Hilang, Jual) s.d. Tahun <?php echo $y-1; ?></div></th>
	    <th class="style9 bottom align-center"><?php echo $totunit1;?></th>
	    <th class="style9 left bottom right align-right">&nbsp;</th>
	    <th class="style9 bottom align-right"><?php echo number_format_koma($totharga1);?></th>
	    <th class="style9 left bottom right align-center">&nbsp;</th>
	    <th class="style9 bottom right align-right">&nbsp;</th>
	    <th class="style9 bottom right align-center">&nbsp;</th>
	    <th class="style9 bottom right align-right">&nbsp;</th>
	    <th class="style9 bottom right align-center">&nbsp;</th>
	    <th class="style9 bottom right align-right"><?php echo number_format_koma($totharga1);?></th>
	    <th class="style9 bottom right align-right">0</th>
	</tr>
	<tr>
	    <th height="25" class="style9 left right bottom" colspan="5"><div align="center">Jumlah Inventaris s.d. Tahun Ini</div></th>
	    <th class="style9 bottom align-center"><?php echo $jum_unit;?></th>
	    <th class="style9 left bottom right align-right">&nbsp;</th>
	    <th class="style9 bottom align-right"><?php echo number_format_koma($totharga+$totharga1);?></th>
	    <th class="style9 left bottom right align-center">&nbsp;</th>
	    <th class="style9 bottom right align-right">&nbsp;</th>
	    <th class="style9 bottom right align-center">&nbsp;</th>
	    <th class="style9 bottom right align-right">&nbsp;</th>
	    <th class="style9 bottom right align-center">&nbsp;</th>
	    <th class="style9 bottom right align-right"><?php echo number_format_koma($totak_penyusutan+$totharga1); ?></th>
	    <th class="style9 bottom right align-right"><?php echo number_format_koma($totnilai_buku); ?></th>
	</tr>
</table>
<!--<div class="no-print">*untuk pembelian dan penghapusan di tanggal diatas 25, <br>akan dihitung sebagai tanggal 1 bulan berikutnya</div>-->
<?php include "tanda_tangan.php"; ?> 
	          
</body>
<title>IN01. Inventaris <?php echo "$jenis ".tgl_indo($tgl);?></title>