<?php
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

$lokasi				=$_SESSION['lokasi'];

$report				=$_POST['report'];
if (empty($report)) {
	$idf				=$_GET['idf'];
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$idf				=2;
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
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date("Y-m-t", strtotime("$y-$m")); $kc="M"; $tgl_kondisilalu=date('Y-m-t', strtotime("$y-$ml-01")); $judulL="Bulan Lalu"; $judulC="Bulan Ini"; }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; $kc="Y"; $tgl_kondisilalu="$y-12-31"; $judulL="Tahun Lalu"; $judulC="Tahun Ini"; }
else{$laporan="Global";}

$tgl_kon="$y-$m-15";
$tgl_last=date('Y-m-t', strtotime("$tgl_kon"));

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c, lkm l where k.id=c.kd_kab AND c.id=l.lokasi AND l.lokasi='$lokasi' "));
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
		<td height="20" colspan="4" class="bottom">
			<?php
			    $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c, lkm l where k.id=c.kd_kab  AND c.id=l.lokasi AND l.lokasi='$lokasi'")); 
											$alamat_lkm =$row ['alamat'];
											$exp	    = explode("#", $alamat_lkm);    
	                                        $alamat1    = $exp[0];
			                                $desa1      = $exp[1];
			                                $kodepos1   = $exp[2];
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$ijin_usaha	=$row ['ijin_usaha'];
			if (empty($ijin_usaha)) {$ijin="";}else{$ijin="Badan Hukum No.$ijin_usaha<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$row[jenis_lkm] LKM $row[nama_lkm_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$ijin $alamat1 $desa1 $kodepos1 Telp. $row[telpon_kec] </div>"; 
			?>
		</td>
		<td height="20" colspan="5" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. H3 Lembar-1 </div>
		</td>
	</tr> 
    <tr>
        <td height="20" colspan="10" class="style6 bottom align-center"><br>DAFTAR RINCIAN PINJAMAN YANG DITERIMA <br><br></td>
    </tr>
    <tr>
            <td colspan="2" width="30%" class="style9">NAMA LKM</td>
            <td colspan="6"  width="60%" class="style9">: <?php echo "$row[nama_lkm_long]" ;?></td>
	    </tr>
	     <tr>
            <td colspan="2" width="30%" class="style9">SANDI LKM</td>
            <td colspan="6"  width="60%" class="style9">: <?php echo "$row[sandi_lkm]" ;?></td>
	     </tr>
	     <tr>
            <td colspan="2" width="30%" class="style9 bottom">PERIODE LAPORAN</td>
            <td colspan="6" width="60%" class="style9 bottom">: <?php echo tgl_indo($tgl_kondisi) ;?></td>
	        </tr>
			<tr align="center" height="30px" class="style9 ">
              <th width="2%" rowspan="2" class="left bottom">No</th>
              <th width="15%" rowspan="2" colspan="2" class="left bottom">Nama Pemberi Pinjaman - Loan ID</a></th>
			  <th colspan="2" class="left bottom">Jangka Waktu</a></th>
			  <th colspan="2" class="left bottom">Suku Bunga</a></th>
			  <th width="8%" rowspan="2" class="left bottom right">Jumlah </a></th>
			  
            </tr>
            
            <tr align="center"  height="30px" class="style9">
			  <th width="5%" class="left bottom">Mulai </th>
              <th width="5%" class="left bottom">Jatuh Tempo</th>
			  <th width="5%" class="left bottom">%</th>
              <th width="5%" class="left bottom">Keterangan</th>
			  
            </tr>
	  
		<tr>
			<td class="style27 left top right" colspan="8"><?php echo "$no. ".strtoupper($r['nama_desa']);?></td>
		</tr>
		
			<tr align="right" height="15px" class="style9">
              <td class="left top" align="center">	</td>
			  <td colspan="2" class="left top" align="left">	</td>
              <td class="left top" align="center">	</td>
              <td class="left top">					</td>
              <td class="left top" align="center">	</td>
              <td class="left top">					</td>
			  <td class="left top  right">			</td>
			  
			   

		
		
		<tr>
		<td class="style10 top" colspan="8"><b>Keterangan</b> : Data yang ditampilkan diatas merupakan Tabungan pada tahun berjalan (<?php echo $y;?>), untuk menampilkan data Individu aktif tahun lalu dapat memilih mode tahun lalu (<?php echo $yll;?>).</td>
		</tr>
</table>

<?php include "tanda_tangan.php"; ?> 
<title>H3<?php echo tgl_indo($tgl);?></title> 