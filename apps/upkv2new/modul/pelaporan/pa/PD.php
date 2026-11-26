<?php session_start();
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
$mll				=$m-1; if($mll<10) {$ml="0$mll"; }else{ $ml=$mll; }
$dll				=$d-1; if($dll<10) {$dl="0$dll"; }else{ $dl=$dll; }

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; $tgl_kondisilalu="$y-$m-$dl"; $judulL="Kemaren"; $judulC="Hari Ini"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date('Y-m-t', strtotime("$y-$m-01")); $tgl_kondisilalu=date('Y-m-t', strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='$idf' "));
$jpp=$jp['nama_jpp'];
$yll				=$y-1;
$thn_kondisi_lalu	="$yll-12-31";
$id_kec =$row['kd_kec'];

if($_SESSION['level']=='kab' and $lokasi<=0 OR $_SESSION['level']=='pusat' and $lokasi<=0){
	$levelc="WHERE kd_kab='$_SESSION[kd_kab]'";
}else if ($lokasi>0){
	$levelc="WHERE id='$lokasi' ";
}
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
<?php
if($_SESSION['level']=='kab' and $lokasi<=0){ 
	echo"<br>";
}else{
?>
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
		<td height="20" colspan="6" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. PD-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
<?php } ?>
     <tr>
        <td height="20" colspan="18" class="style6 bottom align-center"><br>LAPORAN PERKEMBANGAN PINJAMAN <?php echo $jpp;?> REKAP DESA
		<BR><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
    </tr>
			<tr align="center" height="30px" class="style9">
              <th width="2%" rowspan="2" class="left bottom">No</th>
              <th width="19%" rowspan="2" class="left bottom">Desa</a></th>
              <th width="1%" rowspan="2" class="left bottom">&sum;</a></th>
              <th width="7%" rowspan="2" class="left bottom">Alokasi</a></th>
              <th colspan="2" class="left bottom">Target Pengembalian</a></th>
              <th colspan="2" class="left bottom">Realisasi s.d. <?php echo $judulL;?> </a></th>
              <th colspan="2" class="left bottom">Realisasi <?php echo $judulC;?> </a></th>
              <th colspan="2" class="left bottom">Realisasi s.d. <?php echo $judulC;?> </a></th>
              <th width="8%" rowspan="2" class="left bottom">Saldo Pinjaman </th>
              <th width="2%" rowspan="2" class="left bottom">%</th>
              <th colspan="2" class="left bottom right">Tunggakan Pengembalian</th>
            </tr>
            <tr align="center"  height="30px" class="style9">
			  <th width="8%" class="left bottom">Pokok</th>
              <th width="8%" class="left bottom">Jasa</th>
			  <th width="8%" class="left bottom">Pokok</th>
              <th width="8%" class="left bottom">Jasa</th>
			  <th width="8%" class="left bottom">Pokok</th>
              <th width="8%" class="left bottom">Jasa</th>
			  <th width="8%" class="left bottom">Pokok</th>
              <th width="8%" class="left bottom">Jasa</th>
			  <th width="8%" class="left bottom">Pokok</th>
              <th width="8%" class="left bottom right">Jasa</th>
            </tr>
	  <?php
	$kec=mysql_query("SELECT id, kd_kec, nama_kec FROM kecamatan $levelc "); // KEC
	$noc=0;
	while($rc=mysql_fetch_array($kec)){
		$sumKelC=mysql_num_rows(mysql_query("SELECT * FROM kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
WHERE 
k.id=pk.id_kel AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.`status`='A' AND k.lokasi='$rc[id]' OR
			k.id=pk.id_kel AND k.lokasi='$rc[id]' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$tgl_kondisi' AND pk.`status`='L' OR
			k.id=pk.id_kel AND k.lokasi='$rc[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$tgl_kondisi' AND pk.`status`='L' OR
			k.id=pk.id_kel AND k.lokasi='$rc[id]' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$tgl_kondisi' AND pk.`status`='R' OR
			k.id=pk.id_kel AND k.lokasi='$rc[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$tgl_kondisi' AND pk.`status`='R' OR
			k.id=pk.id_kel AND k.lokasi='$rc[id]' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$tgl_kondisi' AND pk.`status`='H' OR
			k.id=pk.id_kel AND k.lokasi='$rc[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$tgl_kondisi' AND pk.`status`='H'
				"));

	$noc=$noc+1;
	
	$_SESSION['lokasi']=$rc['id'];
	echo"
	<tr>
		<td height='27' colspan='2' class='style27 left top'>$noc. KECAMATAN ".strtoupper($rc['nama_kec'])."</td>
		<td class='style27 left top align-right'>$sumKelC</td>
		<td class='style27 left top align-right'>".number_format_koma(alokasiC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style27 left top align-right'>".number_format_koma(targetpokokC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style27 left top align-right'>".number_format_koma(targetjasaC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style27 left top align-right'>".number_format_koma(sumrealpokokC("$tgl_kondisilalu-$idf-$rc[kd_kec]"))."</td>
		<td class='style27 left top align-right'>".number_format_koma(sumrealjasaC("$tgl_kondisilalu-$idf-$rc[kd_kec]"))."</td>
		<td class='style27 left top align-right'>".number_format_koma(sumrealpokokC("$tgl_kondisi-$idf-$rc[kd_kec]")-sumrealpokokC("$tgl_kondisilalu-$idf-$rc[kd_kec]"))."</td>
		<td class='style27 left top align-right'>".number_format_koma(sumrealjasaC("$tgl_kondisi-$idf-$rc[kd_kec]")-sumrealjasaC("$tgl_kondisilalu-$idf-$rc[kd_kec]"))."</td>
		<td class='style27 left top align-right'>".number_format_koma(sumrealpokokC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style27 left top align-right'>".number_format_koma(sumrealjasaC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style27 left top align-right'>".number_format_koma(saldopinjamanC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style27 left top align-right'>".number_format_koma(proskembaliC("$tgl_kondisi-$idf-$rc[kd_kec]"),2)."%</td>
		<td class='style27 left top align-right'>".number_format_koma(nunggakpokokC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style27 left top right align-right'>".number_format_koma(nunggakjasaC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
	</tr>
	";
	
		$des=mysql_query("SELECT id, nama_desa FROM desa WHERE kd_kec='$rc[kd_kec]' ORDER by id ASC"); //START DESA
		$nod=0;
		while($r=mysql_fetch_array($des)){
		$idd=$r['id'];
		$sumKelD=mysql_num_rows(mysql_query("SELECT * FROM kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
WHERE 
            k.id=pk.id_kel AND k.desa='$idd' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.`status`='A' OR
			k.id=pk.id_kel AND k.desa='$idd' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$tgl_kondisi' AND pk.`status`='L' OR
			k.id=pk.id_kel AND k.desa='$idd' AND jenis_pp='$idf'  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$tgl_kondisi' AND pk.`status`='L' OR
			k.id=pk.id_kel AND k.desa='$idd' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$tgl_kondisi' AND pk.`status`='R' OR
			k.id=pk.id_kel AND k.desa='$idd' AND jenis_pp='$idf'  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$tgl_kondisi' AND pk.`status`='R' OR
			k.id=pk.id_kel AND k.desa='$idd' AND jenis_pp='$idf'  AND pk.tgl_cair <= '$tgl_kondisi' AND pk.tgl_lunas >= '$tgl_kondisi' AND pk.`status`='H' OR
			k.id=pk.id_kel AND k.desa='$idd' AND jenis_pp='$idf'  AND pk.tgl_lunas <= '$tgl_kondisi' AND pk.tgl_lunas >= '$tgl_kondisi' AND pk.`status`='H'
"));
		
		$nod=$nod+1;
		?>
		<tr>
			<td class="style9 left top align-center"><?php echo $nod;?></td>
			<td class="style9 left top"><?php echo strtoupper($r['nama_desa']);?></td>
			<td class="style9 left top align-right"><?php echo $sumKelD; ?></td>
			<td class="style9 left top align-right"><?php echo number_format_koma(alokasiD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format_koma(targetpokokD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format_koma(targetjasaD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format_koma(sumrealpokokD("$tgl_kondisilalu-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format_koma(sumrealjasaD("$tgl_kondisilalu-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format_koma(sumrealpokokD("$tgl_kondisi-$idf-$idd")-sumrealpokokD("$tgl_kondisilalu-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format_koma(sumrealjasaD("$tgl_kondisi-$idf-$idd")-sumrealjasaD("$tgl_kondisilalu-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format_koma(sumrealpokokD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format_koma(sumrealjasaD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format_koma(saldopinjamanD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php $prosD=@(sumrealpokokD("$tgl_kondisi-$idf-$idd")/targetpokokD("$tgl_kondisi-$idf-$idd")*100); if($prosD>=100) {echo "100";}else{echo number_format_koma($prosD,2);}?>%</td>
			<td class="style9 left top align-right"><?php echo number_format_koma(nunggakpokokD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style9 left top right align-right">		<?php echo number_format_koma(nunggakjasaD("$tgl_kondisi-$idf-$idd"));?></td>
		</tr>
		
		<?php 
		$sumalokasi			=$sumalokasi+alokasiD("$tgl_kondisi-$idf-$idd");
		$sumtargetpokok		=$sumtargetpokok+targetpokokD("$tgl_kondisi-$idf-$idd");
		$sumtargetjasa		=$sumtargetjasa+targetjasaD("$tgl_kondisi-$idf-$idd");
		$sumreallalu		=$sumreallalu+sumrealpokokD("$tgl_kondisilalu-$idf-$idd");
		$sumreallalujasa	=$sumreallalujasa+sumrealjasaD("$tgl_kondisilalu-$idf-$idd");
		$sumrealpokok		=$sumrealpokok+(sumrealpokokD("$tgl_kondisi-$idf-$idd")-sumrealpokokD("$tgl_kondisilalu-$idf-$idd"));
		$sumrealjasa		=$sumrealjasa+(sumrealjasaD("$tgl_kondisi-$idf-$idd")-sumrealjasaD("$tgl_kondisilalu-$idf-$idd"));
		$sumsumpokok		=$sumsumpokok+sumrealpokokD("$tgl_kondisi-$idf-$idd");
		$sumsumjasa			=$sumsumjasa+sumrealjasaD("$tgl_kondisi-$idf-$idd");
		$sumsaldopinjaman	=$sumsaldopinjaman+saldopinjamanD("$tgl_kondisi-$idf-$idd");
		$sumnunggakpokok	=$sumnunggakpokok+nunggakpokokD("$tgl_kondisi-$idf-$idd");
		$sumnunggakjasa		=$sumnunggakjasa+nunggakjasaD("$tgl_kondisi-$idf-$idd");
		} }
		?>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="center" colspan="2">Komulatif Tahun Berjalan (<?php echo $_GET['y'];?>)</td>
			  <td class="left top">					<?php echo number_format_koma($sumKelC);?></td>
			  <td class="left top">					<?php echo number_format_koma($sumalokasi);?></td>
              <td class="left top">					<?php echo number_format_koma($sumtargetpokok);?></td>
              <td class="left top">					<?php echo number_format_koma($sumtargetjasa);?></td>
			  <td class="left top">					<?php echo number_format_koma($sumreallalu);?></td>              
              <td class="left top">					<?php echo number_format_koma($sumreallalujasa);?></td>
			  <td class="left top">					<?php echo number_format_koma($sumrealpokok);?></td>
              <td class="left top">					<?php echo number_format_koma($sumrealjasa);?></td>
              <td class="left top">					<?php echo number_format_koma($sumsumpokok);?></td>
              <td class="left top">					<?php echo number_format_koma($sumsumjasa);?></td>
              <td class="left top">					<?php echo number_format_koma($sumsaldopinjaman);?></td>
              <td class="left top">					<?php $pros=@($sumsumpokok/$sumtargetpokok*100); if($pros==100) {echo "100";}else{echo number_format_koma($pros,2);}?>%</td>
			  <td class="left top">					<?php echo number_format_koma($sumnunggakpokok);?></td>
			  <td class="left top right">			<?php echo number_format_koma($sumnunggakjasa);?></td>	
		</tr>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="center" colspan="2">Komulatif s.d Tahun Lalu (<?php echo $yll;?>)</td>
			  <td class="left top">					</td>
			  <td class="left top">					<?php echo number_format_koma(alokasiCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
              <td class="left top">					<?php echo number_format_koma(targetpokokCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
              <td class="left top">					<?php echo number_format_koma(targetjasaCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
			  <td class="left top">					<?php echo number_format_koma(sumrealpokokCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>              
              <td class="left top">					<?php echo number_format_koma(sumrealjasaCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
			  <td class="left top">					0</td>
              <td class="left top">					0</td>
              <td class="left top">					<?php echo number_format_koma(sumrealpokokCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
              <td class="left top">					<?php echo number_format_koma(sumrealjasaCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
              <td class="left top">					<?php echo number_format_koma(saldopinjamanCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
              <td class="left top">					<?php $pros=@(sumrealpokokCL("$thn_kondisi_lalu-$idf-$lokasi")/targetpokokCL("$thn_kondisi_lalu-$idf-$lokasi")*100); if($pros>=100) {echo "100";}else{echo number_format_koma($pros,2);}?>%</td>
			  <td class="left top">					<?php echo number_format_koma(nunggakpokokCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
			  <td class="left top right">			<?php echo number_format_koma(nunggakjasaCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>	
		</tr>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="center" colspan="2">Komulatif s.d. Tahun Berjalan (<?php echo $_GET['y'];?>)</td>
			  <td class="left top">					</td>
			  <td class="left top">					<?php echo number_format_koma($sumalokasi+alokasiCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
              <td class="left top">					<?php echo number_format_koma($sumtargetpokok+targetpokokCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
              <td class="left top">					<?php echo number_format_koma($sumtargetjasa+targetjasaCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
			  <td class="left top">					<?php echo number_format_koma($sumreallalu+sumrealpokokCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>              
              <td class="left top">					<?php echo number_format_koma($sumreallalujasa+sumrealjasaCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
			  <td class="left top">					<?php echo number_format_koma($sumrealpokok-sumrealpokokC("$tgl_kondisilalu-$idf-$kd_kec"));?></td>
              <td class="left top">					<?php echo number_format_koma($sumrealjasa-sumrealjasaC("$tgl_kondisilalu-$idf-$kd_kec"));?></td>
              <td class="left top">					<?php echo number_format_koma($sumsumpokok+sumrealpokokCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
              <td class="left top">					<?php echo number_format_koma($sumsumjasa+sumrealjasaCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
              <td class="left top">					<?php echo number_format_koma($sumsaldopinjaman+saldopinjamanCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
              <td class="left top">					<?php $pros=@(sumrealpokokC("$tgl_kondisi-$idf-$id_kec")/targetpokokC("$tgl_kondisi-$idf-$id_kec")*100); if($pros>=100) {echo "100";}else{echo number_format_koma($pros,2);}?>%</td>
			  <td class="left top">					<?php echo number_format_koma($sumnunggakpokok+nunggakpokokCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>
			  <td class="left top right">			<?php echo number_format_koma($sumnunggakjasa+nunggakjasaCL("$thn_kondisi_lalu-$idf-$lokasi"));?></td>	
		</tr> 
	<tr>
	<td class="style10 top" colspan="16">&nbsp;</td>
	</tr>
</table>

<?php
if($_SESSION['level']=='kab' and $lokasi<=0){ 
	echo"<br>";
}else{
 include "tanda_tangan.php"; 
 }
 ?>
	          
</body>
<title>PD<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>