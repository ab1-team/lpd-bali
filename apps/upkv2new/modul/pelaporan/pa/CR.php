<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

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

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date('Y-m-t', strtotime("$y-$m-01")); }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='$idf' "));
$jpp=$jp['nama_jpp'];

$sumkolek1	=sumkolek1("$tgl_kondisi-$idf");
$sumkolek2	=sumkolek2("$tgl_kondisi-$idf");
$sumkolek3	=sumkolek3("$tgl_kondisi-$idf");
$sumkolek4	=sumkolek4("$tgl_kondisi-$idf");
$sumkolek5	=sumkolek5("$tgl_kondisi-$idf");

if ($_SESSION['lokasi']=='96') { //khusus KEBUMEN
$cr1		=$sumkolek1*1/100;
$cr2		=$sumkolek2*10/100;
$cr3		=$sumkolek3*15/100;
$cr4		=$sumkolek4*25/100;
$cr5		=$sumkolek5*100/100;
} elseif ($_SESSION['lokasi']=='72') { //khusus KECAMATAN SERIRIT
$cr1		=$sumkolek1*1/100;
$cr2		=$sumkolek2*10/100;
$cr3		=$sumkolek3*25/100;
$cr4		=$sumkolek4*50/100;
$cr5		=$sumkolek5*100/100;
} else { 
$cr1		=$sumkolek1*1/100;
$cr2		=$sumkolek2*10/100;
$cr3		=$sumkolek3*25/100;
$cr4		=$sumkolek4*50/100;
$cr5		=$sumkolek5*100/100;
}
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
				<td height="20" colspan="4" class="bottom">
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
				<td height="20" class="bottom">
					<div align="right" class="style9">Dok. Laporan <?php echo $laporan;?><br>
					Kd.Doc. CR-<?php echo $idf;?></div>
				</td>
			</tr> 
            <tr>
				<td height="20" colspan="4" class="style6 bottom"><br>LAPORAN CADANGAN RESIKO <?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
				<td class="style6 bottom align-right"><br><?php echo $jpp;?></td>
			</tr>
			<tr align="center" height="40px">
              <th width="2" class="left bottom top">NO</th>
              <th width="20" class="left bottom top">TINGKAT KOLEKTIBILITAS</th>
              <th width="63" class="left bottom top">CADANGAN RESIKO PENGHAPUSAN</th>
              <th width="91" class="left bottom top">SALDO PINJAMAN</th>
              <th width="86" class="all">JUMLAH CADANGAN RESIKO</th>
			</tr>
			<tr align="center" height="15px" style="background:rgba(0,0,0, 0.4);">
              <td class="left bottom">1</td>
              <td class="left bottom">2</td>
              <td class="left bottom">3</td>
              <td class="left bottom">4</td>
              <td class="left bottom right">5 = 3 * 4</td>
            </tr>
			<tr>
              <td class="left bottom" height="20px" align="center">1</td>
              <td class="left bottom">KOLEKTIBILITAS I</td>
              <td class="left bottom" align="center">1 %</td>
              <td class="left bottom" align="right"><?php echo number_format_koma($sumkolek1);?></td>
              <td class="left bottom right" align="right"><?php echo number_format_koma($cr1);?></td>
            </tr>
			<tr>
			<td class="left bottom" height="20px" align="center">2</td>
              <td class="left bottom">KOLEKTIBILITAS II</td>
              <td class="left bottom" align="center">10 %</td>
              <td class="left bottom" align="right"><?php echo number_format_koma($sumkolek2);?></td>
              <td class="left bottom right" align="right"><?php echo number_format_koma($cr2);?></td>
			</tr>
			<tr>
			<td class="left bottom" height="20px" align="center">3</td>
              <td class="left bottom">KOLEKTIBILITAS III</td>
              <td class="left bottom" align="center"><?php if ($_SESSION['lokasi']=='96') {echo "15 %";}else{echo "25 %";} ?></td>
              <td class="left bottom" align="right"><?php echo number_format_koma($sumkolek3);?></td>
              <td class="left bottom right" align="right"><?php echo number_format_koma($cr3);?></td>
			</tr>
			<tr>
			<td class="left bottom" height="20px" align="center">4</td>
              <td class="left bottom">KOLEKTIBILITAS IV</td>
              <td class="left bottom" align="center"><?php if ($_SESSION['lokasi']=='96') {echo "25 %";}else{echo "50 %";} ?></td>
              <td class="left bottom"  align="right"><?php echo number_format_koma($sumkolek4);?></td>
              <td class="left bottom right"  align="right"><?php echo number_format_koma($cr4);?></td>
			</tr>
			<tr>
			<td class="left bottom" height="20px" align="center">5</td>
			  <td class="left bottom">KOLEKTIBILITAS V</td>
			  <td class="left bottom" align="center">100 %</td>
			  <td class="left bottom" align="right"><?php echo number_format_koma($sumkolek5);?></td>
			  <td class="left bottom right" align="right"><?php echo number_format_koma($cr5);?></td>
		  </tr>
			<tr align="center" height="30px">
              <th colspan="3" class="left bottom">T O T A L</th>
			  <th class="left bottom" align="right"><?php echo number_format_koma($sumkolek1+$sumkolek2+$sumkolek3+$sumkolek4+$sumkolek5);?></th>
			  <th class="left bottom right" align="right"><?php echo number_format_koma($cr1+$cr2+$cr3+$cr4+$cr5);?></th>
		  </tr>
			<tr align="center" height="30px">
              <th colspan="3" class="left bottom">PERSENTASE CADANGAN RESIKO</th>
			  <th colspan="2" class="left bottom right" align="right"><?php echo number_format_koma(($cr1+$cr2+$cr3+$cr4+$cr5)/($sumkolek1+$sumkolek2+$sumkolek3+$sumkolek4+$sumkolek5)*100);?>% </th>
		  </tr>
			<tr align="center" height="30px">
              <th colspan="3" class="left bottom">Non-Performing Loan (NPL) Gross <br> [K3+K4+K5 / Saldo * 100%]</th>
			  <th colspan="2" class="left bottom right" align="right"><?php echo number_format_koma(($sumkolek3+$sumkolek4+$sumkolek5)/($sumkolek1+$sumkolek2+$sumkolek3+$sumkolek4+$sumkolek5)*100);?>% </th>
		  </tr>
			<tr align="center" height="30px">
              <th colspan="3" class="left bottom">Non-Performing Loan (NPL) Nett <br> [K5 / Saldo * 100%]</th>
			  <th colspan="2" class="left bottom right" align="right"><?php echo number_format_koma(($sumkolek5)/($sumkolek1+$sumkolek2+$sumkolek3+$sumkolek4+$sumkolek5)*100);?>% </th>
		  </tr>
	</table>
	
<?php include "tanda_tangan.php"; ?> 

</body>
<title>CR<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>