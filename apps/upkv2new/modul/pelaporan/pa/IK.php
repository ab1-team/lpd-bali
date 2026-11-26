<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_keuangan.php";
include "../../../inc/fungsi_pinjaman_individu.php";
$table_rekening		="rekening_".$_SESSION['lokasi'];
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
$mll				=$m-1; if($mll<10) {$ml="0$mll"; }else{ $ml=$mll; }
$dll				=$d-1; if($dll<10) {$dl="0$dll"; }else{ $dl=$dll; }


	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisibulanlalu="$y-$m-$dl"; $judulL="Kemaren"; $judulC="Hari Ini";  }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date('Y-m-t', strtotime("$y-$m-01")); $tgl_kondisibulanlalu=date('Y-m-t', strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini";}
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisibulanlalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

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

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0" class="style9">
			<tr>
				<td height="20" colspan="8" class="bottom">
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
				<td height="20" colspan="11" class="bottom">
					<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
					Kd.Doc. IK-<?php echo $idf;?> Lembar-1 </div>
				</td>
			</tr> 
            <tr>
				<td align="center" height="20" colspan="18" class="style6 bottom"><br>LAPORAN BARANG KREDIT INDIVIDU <br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?><br></td>
			</tr>
    </tr>
			<tr align="center" height="30px" class="style9">
              <th width="2%" class="left bottom">No</th>
              <th width="4%" class="left bottom">Loan ID</th>
              <th width="5%" class="left bottom">Tgl Cair</th>
			  <th width="15%" class="left bottom">Pemanfaat</th>
			  <th width="10%" class="left bottom">Barang Kredit</th>
              <th width="8%" class="left bottom">Alokasi</th>
              <th width="3%" class="left bottom">Tempo</th>
              <th width="8%" class="left bottom">Kewajiban Pokok</th>
              <th width="8%" class="left bottom">Kewajiban Jasa</th>
              <th width="8%" class="left bottom">No. HP</th>
              <th width="10%" class="left bottom right">Penjamin</th>
            </tr>
		<?php
		$data=mysql_query("SELECT *, d.id AS id_desa FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='189' ORDER BY d.id ASC");
		while($r=mysql_fetch_array($data)){
		$idd=$r['id_desa'];
		$no=$no+1;
		$view2=mysql_query("SELECT * FROM anggota_32 a, sistem_angsuran sa, pinjaman_anggota_32 pi WHERE a.id=pi.nia AND pi.sistem_angsuran=sa.id AND jenis_pp='13' AND pi.tgl_cair >0 AND pi.tgl_cair <= '$tgl_kondisi' AND pi.jenis_pinjaman='I' AND pi.status='A' AND a.desa=$idd"); 
		$noo=0;
		?>
		<tr>
			<td class="style27 left top right" colspan="11"><?php echo "$no. ".strtoupper($r['nama_desa']);?></td>
		</tr>
		<?php
		while($row2=mysql_fetch_array($view2)){
		$noo=$noo+1;
		$idp			=$row2['id'];
		$alokasi        =$row2['alokasi'];
		$jangka         =$row2['jangka'];
		$pok            =$alokasi/$jangka;
		$tampilpokok	= bulatkan($pok);
		$pros           =$row2['pros_jasa'];
		$jasa           =$alokasi*$pros/100;
		$tampiljasa     = bulatkan($jasa);
		?>
			  <tr align="right" height="15px" class="style9">
					  <td class="left top" align="center">	<?php echo $noo;?></td>
					  <td class="left top" align="center">	<?php echo $idp;?></td>
					  <td class="left top" align="center">	<?php echo tgl_ind($row2['tgl_cair']); ?></td>
					  <td class="left top" align="left">	<?php echo "$row2[nik] $row2[namadepan] ";?></td>
					  <td class="left top" align="left">	<?php echo "$row2[nama_barang]";?></td>
					  <td class="left top" align="right">	<?php echo number_format_koma($alokasi);?></td>
					  <td class="left top" align="center">	<?php echo "$row2[jangka]/$row2[sistem]";?></td>
					  <td class="left top" align="right">	<?php echo number_format_koma($tampilpokok);?></td>
					  <td class="left top" align="right">	<?php echo number_format_koma($tampiljasa);?></td>
					  <td class="left top" align="center">	<?php echo "$row2[hp]";?></td>
					  <td class="left top right" align="left">	<?php echo "$row2[penjamin]";?></td>
		</tr>
		<?php
		}
		}
		?>
		
		  <tr>
			<td class="style10 top" colspan="11">&nbsp;</td>
		</tr>
	</table>
	
		<?php include "tanda_tangan.php"; ?> 
	
</body>
<title>IK<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>