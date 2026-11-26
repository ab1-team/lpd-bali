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
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi="$y-$m-31"; $tgl_kondisilalu="$y-$ml-31"; $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten where id='$_SESSION[kd_kab]' "));

if($idf=="1"){ $jpp="SPP"; } else if($idf=="2"){ $jpp="UEP"; } else if($idf=="3"){ $jpp="LAINNYA"; }

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
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
		</td>
		<td height="20" colspan="6" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. PC-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 

     <tr>
        <td height="20" colspan="18" class="style6 bottom align-center"><br>LAPORAN PERKEMBANGAN PINJAMAN <?php echo $jpp;?> REKAP KECAMATAN
		<BR><?php echo strtoupper("$jenis ".tgl_indo($tgl));?><br>&nbsp;</td>
    </tr>
			<tr align="center" height="30px" class="style9">
              <th width="2%" rowspan="2" class="left bottom">No</th>
              <th width="20%" rowspan="2" class="left bottom">Kecamatan</a></th>
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
	$kec=mysql_query("SELECT * FROM kecamatan where kd_kab='$_SESSION[kd_kab]' "); // KEC
	$noc=0;
	while($rc=mysql_fetch_array($kec)){
	$noc=$noc+1;
	$_SESSION['lokasi']=$rc['id'];
	$kd_kec	=$rc['kd_kec'];
	echo"
	<tr>
		<td height='27' class='style9 left top'>$noc</td>
		<td class='style9 left top'>KECAMATAN ".strtoupper($rc['nama_kec'])."</td>
		<td class='style9 left top align-right'>".number_format(alokasiC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style9 left top align-right'>".number_format(targetpokokC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style9 left top align-right'>".number_format(targetjasaC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style9 left top align-right'>".number_format(sumrealpokokC("$tgl_kondisilalu-$idf-$rc[kd_kec]"))."</td>
		<td class='style9 left top align-right'>".number_format(sumrealjasaC("$tgl_kondisilalu-$idf-$rc[kd_kec]"))."</td>
		<td class='style9 left top align-right'>".number_format(sumrealpokokC("$tgl_kondisi-$idf-$rc[kd_kec]")-sumrealpokokC("$tgl_kondisilalu-$idf-$rc[kd_kec]"))."</td>
		<td class='style9 left top align-right'>".number_format(sumrealjasaC("$tgl_kondisi-$idf-$rc[kd_kec]")-sumrealjasaC("$tgl_kondisilalu-$idf-$rc[kd_kec]"))."</td>
		<td class='style9 left top align-right'>".number_format(sumrealpokokC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style9 left top align-right'>".number_format(sumrealjasaC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style9 left top align-right'>".number_format(saldopinjamanC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style9 left top align-right'>".number_format(proskembaliC("$tgl_kondisi-$idf-$rc[kd_kec]"))."%</td>
		<td class='style9 left top align-right'>".number_format(nunggakpokokC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
		<td class='style9 left top right align-right'>".number_format(nunggakjasaC("$tgl_kondisi-$idf-$rc[kd_kec]"))."</td>
	</tr>
	";
	
		$sumalokasi			=$sumalokasi+alokasiC("$tgl_kondisi-$idf-$kd_kec");
		$sumtargetpokok		=$sumtargetpokok+targetpokokC("$tgl_kondisi-$idf-$kd_kec");
		$sumtargetjasa		=$sumtargetjasa+targetjasaC("$tgl_kondisi-$idf-$kd_kec");
		$sumreallalu		=$sumreallalu+sumrealpokokC("$tgl_kondisilalu-$idf-$kd_kec");
		$sumreallalujasa	=$sumreallalujasa+sumrealjasaC("$tgl_kondisilalu-$idf-$kd_kec");
		$sumrealpokok		=$sumrealpokok+(sumrealpokokC("$tgl_kondisi-$idf-$kd_kec")-sumrealpokokC("$tgl_kondisilalu-$idf-$kd_kec"));
		$sumrealjasa		=$sumrealjasa+(sumrealjasaC("$tgl_kondisi-$idf-$kd_kec")-sumrealjasaC("$tgl_kondisilalu-$idf-$kd_kec"));
		$sumsumpokok		=$sumsumpokok+sumrealpokokC("$tgl_kondisi-$idf-$kd_kec");
		$sumsumjasa			=$sumsumjasa+sumrealjasaC("$tgl_kondisi-$idf-$kd_kec");
		$sumsaldopinjaman	=$sumsaldopinjaman+saldopinjamanC("$tgl_kondisi-$idf-$kd_kec");
		$sumnunggakpokok	=$sumnunggakpokok+nunggakpokokC("$tgl_kondisi-$idf-$kd_kec");
		$sumnunggakjasa		=$sumnunggakjasa+nunggakjasaC("$tgl_kondisi-$idf-$kd_kec");
		}
		?>
		<tr align="right" height="30px" class="style27">
              <td class="left top" align="center" colspan="2">J U M L A H</td>
			  <td class="left top">					<?php echo number_format($sumalokasi);?></td>
              <td class="left top">					<?php echo number_format($sumtargetpokok);?></td>
              <td class="left top">					<?php echo number_format($sumtargetjasa);?></td>
			  <td class="left top">					<?php echo number_format($sumreallalu);?></td>              
              <td class="left top">					<?php echo number_format($sumreallalujasa);?></td>
			  <td class="left top">					<?php echo number_format($sumrealpokok);?></td>
              <td class="left top">					<?php echo number_format($sumrealjasa);?></td>
              <td class="left top">					<?php echo number_format($sumsumpokok);?></td>
              <td class="left top">					<?php echo number_format($sumsumjasa);?></td>
              <td class="left top">					<?php echo number_format($sumsaldopinjaman);?></td>
              <td class="left top">					<?php $pros=@($sumsumpokok/$sumtargetpokok*100); if($pros>=100) {echo "100";}else{echo number_format($pros);}?>%</td>
			  <td class="left top">					<?php echo number_format($sumnunggakpokok);?></td>
			  <td class="left top right">			<?php echo number_format($sumnunggakjasa);?></td>	
		</tr>
	<tr>
	<td class="style10 top" colspan="16">&nbsp;</td>
	</tr>
</table>

	          
</body>
<title>PC<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>