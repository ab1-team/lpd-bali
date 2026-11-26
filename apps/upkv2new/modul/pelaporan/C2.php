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

$sumkolekl	=sumkolekl("$tgl_kondisi");
$sumkolekd	=sumkolekd("$tgl_kondisi");
$sumkolekm	=sumkolekm("$tgl_kondisi");

$crl		=$sumkolekl*0/100;
$crd		=$sumkolekd*50/100;
$crm		=$sumkolekm*100/100;
$tkolek     =$sumkolekl+$sumkolekd+$sumkolekm;
$tcr        =$crl+$crd+$crm;
$npl        =($sumkolekd+$sumkolekm)/$tkolek*100;
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
				<td height="20" colspan="5" class="bottom">
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
					Kd.Doc. CRK-<?php echo $idf;?></div>
				</td>
			</tr> 
            <tr>
				<td height="20" colspan="5" class="style6 bottom"><br>LAPORAN CADANGAN RESIKO KREDIT <?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
				<td class="style6 bottom align-right"><br><?php echo $jpp;?></td>
			</tr>
			<tr align="center" height="100%">
              <th width="2%" class="left bottom top">NO</th>
              <th width="20%" class="left bottom top">TINGKAT KOLEKTIBILITAS</th>
              <th width="5%%" class="left bottom top">%</th>
              <th width="30%" class="left bottom top">SALDO PINJAMAN</th>
              <th width="20%" class="left bottom top">BEBAN PENYISIHAN PENGHAPUSAN PINJAMAN</th>
              <th width="20%" class="left right bottom top">NPL</th>
			</tr>
			<tr align="center" height="100%" style="background:rgba(0,0,0, 0.4);">
              <td class="left bottom">a</td>
              <td class="left bottom">b</td>
              <td class="left bottom">c</td>
              <td class="left bottom">d</td>
              <td class="left bottom">e = c * d</td>
              <td class="left bottom right">f=(2+3)/Saldo</td>
            </tr>
			<tr>
              <td class="left bottom" height="100%" align="center">1</td>
              <td class="left bottom">Lancar</td>
              <td class="left bottom" align="center">0 %</td>
              <td class="left bottom" align="right"><?php echo number_format($sumkolekl);?></td>
              <td class="left bottom" align="right"><?php echo number_format($crl);?></td>
              <th class="left bottom right" align="center" rowspan=4><?php echo number_format($npl,2);?>%</td>
            </tr>
			<tr>
			<td class="left bottom" height="100%" align="center">2</td>
              <td class="left bottom">Diragukan</td>
              <td class="left bottom" align="center">50 %</td>
              <td class="left bottom" align="right"><?php echo number_format($sumkolekd);?></td>
              <td class="left bottom" align="right"><?php echo number_format($crd);?></td>
			</tr>
			<tr>
			<td class="left bottom" height="100%" align="center">3</td>
              <td class="left bottom">Macet</td>
              <td class="left bottom" align="center">100%</td>
              <td class="left bottom" align="right"><?php echo number_format($sumkolekm);?></td>
              <td class="left bottom" align="right"><?php echo number_format($crm);?></td>
			</tr>
			
			<tr align="center" height="100%">
              <th colspan="3" class="left bottom">T O T A L</th>
			  <th class="left bottom" align="right"><?php echo number_format($tkolek);?></th>
			  <th class="left bottom" align="right"><?php echo number_format($tcr);?></th>
		  </tr>
			
	</table>
	
<?php include "tanda_tangan.php"; ?> 

</body>
<title>CR<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>