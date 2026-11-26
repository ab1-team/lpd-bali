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
		<td height="20" colspan="3" class="bottom">
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
		<td height="20" colspan="2" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. PH-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
    <tr>
        <td height="20" colspan="5" class="style6 bottom align-center"><br>LAPORAN  <?php if($_SESSION['lokasi']==274 OR $_SESSION['lokasi']==1){echo "PEMINDAHBUKUAN";}else{echo "PENGHAPUSAN";} ?> PINJAMAN <?php echo $jpp;?> REKAP KELOMPOK <br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
    </tr>
			<tr align="center" height="30px" class="style9">
              <th width="2%" class="left bottom">No</th>
              <th width="20%" class="left bottom">Kelompok - Loan ID</a></th>
			  <th width="10%" class="left bottom">Tanggal <?php if($_SESSION['lokasi']==274 OR $_SESSION['lokasi']==1){echo "Pemindahbukuan";}else{echo "Penghapusan";} ?></a></th>
              <th width="10%" class="left bottom">Jumlah  <?php if($_SESSION['lokasi']==274 OR $_SESSION['lokasi']==1){echo "Pemindahbukuan";}else{echo "Penghapusan";} ?></a></th>
              <th width="20%" class="left bottom right">Keterangan</th>
			</tr>
	  <?php
		$data=mysql_query("SELECT d.id, d.nama_desa FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$lokasi' ORDER BY d.id ASC");
		$no=0;
		while($r=mysql_fetch_array($data)){
		$idd=$r['id'];
		$no=$no+1;

		?>
		<tr>
			<td class="style27 left top" colspan="3"><?php echo "$no. ".strtoupper($r['nama_desa']);?></td>
			<td class="style27 left top align-right"><?php echo number_format(penghapusanD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style27 left top right align-right"> </td>
		</tr>
		<?php
		$view=mysql_query("SELECT pk.catatan_verifikasi, pk.id, k.nama_kelompok, pk.tgl_lunas, k.kd_kelompok  
		FROM kelompok_$_SESSION[kd_kab] k, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$thn_kondisi' AND pk.`status`='H'
		ORDER BY pk.tgl_cair ASC"); 
		$noo=0;
		while($row=mysql_fetch_array($view)){
		$noo=$noo+1;
		$idp	=$row['id'];
		$tgl_lunas		=$row['tgl_lunas'];
		$catatan_verifikasi	= $row['catatan_verifikasi'];
		$hapus				= penghapusan("$tgl_kondisi-$idp");
		?>
		<tr align="left" height="15px" class="style9">
              <td class="left top" align="center">	<?php echo $noo;?></td>
			  <td class="left top" align="left">	<?php echo "$row[kd_kelompok] $row[nama_kelompok] -$idp"; ?></td>
              <td class="left top" align="center">	<?php echo tgl_ind($tgl_lunas); ?></td>
			  <td class="left top " align="right">					<?php echo number_format($hapus);?></td>
			  <?php if($catatan_verifikasi!=NULL OR $catatan_verifikasi!=""){?>
				  <td class="left top right align-left"><?php echo $catatan_verifikasi; ?></td>
			  <?php }else{ ?>
			  <td class="left top right align-left"> <?php if($_SESSION['lokasi']==274 OR $_SESSION['lokasi']==1){echo "Pemindahbukuan";}else{echo "Penghapusan";} ?> pada tanggal <?php echo tgl_ind($tgl_lunas); ?></td>
				<?php } ?>
		
		<?php 

		}
		} 
		?>
		</tr>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="left" colspan="3">Komulatif Tahun Berjalan (<?php echo $_GET['y'];?>)</td>
			  <td class="left top ">		<?php echo number_format(penghapusanC("$tgl_kondisi-$idf-$kd_kec"));?></td>
              <td class="left top right">					</td>
		</tr>
		<?php /*
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="left" colspan="3">Komulatif s.d Tahun Lalu (<?php echo $yll;?>)</td>
			  <td class="left top right">		<?php echo number_format(alokasiC("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
              <td class="left top right">					</td>
		</tr>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="left" colspan="3">Komulatif s.d. Tahun Berjalan (<?php echo $_GET['y'];?>)</td>
			  <td class="left top right">		<?php echo number_format(alokasiC("$tgl_kondisi-$idf-$kd_kec")+alokasiCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
              <td class="left top right">					</td>
		</tr>
		*/?>
		<td class="style10 top" colspan="18"><b>Keterangan</b> : Data yang ditampilkan diatas merupakan kelompok aktif pada tahun berjalan (<?php echo $_GET['y'];?>), untuk menampilkan data kelompok aktif tahun lalu dapat memilih mode tahun lalu (<?php echo $yll;?>).</td>
</table>



<?php include "tanda_tangan.php"; ?> 
	          
</body>
<title>PH<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>