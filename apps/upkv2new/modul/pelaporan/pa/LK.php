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

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_tampil="$y-$m-$d"; $tgl_kondisi="$y-$m-$d"; $kc="D"; $tgl_kondisilalu="$y-$m-$dl"; $judulL="Kemaren"; $judulC="Hari Ini"; $tgl_sql="tgl_cair=$tgl_kondisi";}
elseif($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_tampil="$y-$m"; $tgl_kondisi="$y-$m-00"; $kc="M"; $tgl_kondisilalu=date('Y-m-t', strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini"; $tgl_sql="month(pk.tgl_cair) = '$m' AND year(pk.tgl_cair) = '$y'"; }
elseif($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_tampil="$y"; $tgl_kondisi="$y-00-00"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; $tgl_sql="year(pk.tgl_cair) = '$y'"; }
else{$laporan="Global"; $tgl_sql="1=1"; $jenis="Seluruh Waktu"; $tgl_kondisi="";}

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
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
		</td>
		<td height="20" colspan="8" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. LK-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
    <tr>
        <td height="20" colspan="9" class="style6 bottom align-center"><br>PELAPORAN KHUSUS PENCAIRAN KELOMPOK <?php echo $jpp;?><BR>
		PADA <?php echo strtoupper("$jenis ".tgl_indo($tgl_tampil));?></td>
    </tr>
			<tr align="center" height="30px" class="style9">
              <th width="2%" rowspan="2" class="left bottom">No</th>
              <th width="20%" rowspan="2" class="left bottom">Kelompok - Loan ID</th>
			  <th width="7%" rowspan="2" class="left bottom">Nomor SPK</th>
              <th width="5%" rowspan="2" class="left bottom">Ketua Kelompok</th>
              <th width="2%" rowspan="2" class="left bottom">&sum;A</th>
			  <th width="5%" rowspan="2" class="left bottom">Tgl. Cair</th>
              <th width="3%" rowspan="2" class="left bottom">T/S</th>
              <th colspan="2" class="left bottom right">Alokasi</th>
            </tr>
            <tr align="center"  height="30px" class="style9">
			  <th width="5%" class="left bottom">Pengajuan</th>
              <th width="5%" class="left bottom right">Pencairan</th>
            </tr>
	  <?php
		$data=mysql_query("SELECT d.id, d.nama_desa FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$lokasi' ORDER BY d.kd_desa ASC");
		$no=0;
		while($r=mysql_fetch_array($data)){
		$idd=$r['id'];
		$no=$no+1;
		
		$jpdesa=0;
		$jadesa=0;
		?>
		<tr>
			<td class="style27 left top right" colspan="9"><?php echo "$no. ".strtoupper($r['nama_desa']);?></td>
			<!--<td class="style27 left top align-right"><?php echo number_format_koma(PropAD("$thn_kondisi-$idf-$idd"));?></td>-->
			<!--<td class="style27 left top right align-right"><?php echo number_format_koma(AloAD("$thn_kondisi-$idf-$idd"));?></td>-->
		</tr>
		<?php
		$view=mysql_query("SELECT pk.id, 
								  pk.alokasi,
								  pk.proposal,
								  k.nama_kelompok, 
								  pk.tgl_cair, 
								  pk.spk_no, 
								  k.ketua,
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
			k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND $tgl_sql AND sumber='1'
		ORDER BY pk.tgl_cair ASC"); 
		$noo=0;
		while($row=mysql_fetch_array($view)){
		$noo			=$noo+1;
		$idp			=$row['id'];
		$kd_kelompok	=$row['kd_kelompok'];
		$nama_kelompok	=$row['nama_kelompok'];
		$spk_no			=$row['spk_no'];
if($spk_no==NULL){
		$no_spk			="-";
}else{
		$no_spk			=$spk_no;
}
		$ketua			=$row['ketua'];
		$ja=mysql_num_rows(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$idp' "));
		$tgl_cair		=$row['tgl_cair'];
		$tempo			=$row['jangka'];
		$sistem_angsuran=$row['sistem'];
		$pengajuan		=$row['proposal'];
		$alokasi		=$row['alokasi'];
		$jpdesa = $pengajuan+$jpdesa;
		$jadesa = $alokasi+$jadesa;
		?>
		<tr class="style9">
			<td class="left top" align="center">	<?php echo $noo;?></td>
			<td class="left top" align="left">		<?php echo "$kd_kelompok $nama_kelompok -$idp"; ?></td>
			<td class="left top" align="center">	<?php echo "$no_spk"; ?></td>
			<td class="left top" align="left">		<?php echo "$ketua"; ?></td>
			<td class="left top" align="center">	<?php echo "$ja"; ?></td>
			<td class="left top" align="center">	<?php echo tgl_ind($tgl_cair); ?></td>
			<td class="left top" align="center">	<?php echo "$tempo/$sistem_angsuran"; ?></td>
            <td class="left top" align="right">					<?php echo number_format_koma($pengajuan);?></td>
            <td class="left top right" align="right">			<?php echo number_format_koma($alokasi);?></td>
		<?php
		}
		if($jpdesa+$jadesa>0){
		?>
		<tr>
			<td class="style27 left top" align="center" colspan="7">Jumlah <?php echo strtoupper($r['nama_desa']);?></td>
			<td class="style27 left top align-right"><?php echo number_format_koma($jpdesa);?></td>
			<td class="style27 left top right align-right"><?php echo number_format_koma($jadesa);?></td>
		</tr>
		<?php
		}
		$jjpdesa = $jjpdesa+$jpdesa;
		$jjadesa = $jjadesa+$jadesa;
		}
		?>
		</tr>
		<tr align="right" height="1px">
              <td class="left top right" align="center" colspan="9"></td>
		</tr>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="center" colspan="7"> JUMLAH PADA  <?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
			  <td class="left top">					<?php echo number_format_koma($jjpdesa);?></td>
			  <td class="left top right">			<?php echo number_format_koma($jjadesa);?></td>	
		</tr>
		<td class="style10 top" colspan="18"><b>Keterangan</b> : Data yang ditampilkan diatas merupakan kelompok aktif pada tahun berjalan (<?php echo $y;?>), untuk menampilkan data kelompok aktif tahun lalu dapat memilih mode tahun lalu (<?php echo $yll;?>).</td>
</table>



<?php include "tanda_tangan.php"; ?> 
	          
</body>
<title>LK<?php echo "-$idf $jenis ".tgl_indo($tgl_tampil);?></title>