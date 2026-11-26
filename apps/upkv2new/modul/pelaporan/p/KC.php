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
$thn_kondisi		=$y;

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date("Y-m-t", strtotime("$y-$m-01")); }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));
if($idf=="1"){ $jpp="SPP"; } else if($idf=="2"){ $jpp="UEP"; } else if($idf=="3"){ $jpp="LAINNYA"; }

if($_SESSION['level']=='kab' and $lokasi<=0 OR $_SESSION['level']=='pusat' and $lokasi<=0){
	$levelc="WHERE kd_kab='$_SESSION[kd_kab]'";
}else if ($lokasi>0){
	$levelc="WHERE id='$lokasi' ";
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

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">

     <tr>
        <td height="20" colspan="9" class="style6 bottom align-center"><br>LAPORAN KOLEKTIBILITAS PINJAMAN <?php echo $jpp;?> REKAP KECAMATAN<br>
		<?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
        </td>
    </tr>
			<tr align="center" height="40px" class="style9">
              <th class="left bottom" width="3%">NO</th>
              <th class="left bottom" width="20%">KECAMATAN</th>
              <th class="left bottom" width="10%">SALDO PINJAMAN </th>
              <th class="left bottom" width="10%">&Sigma; TUNGGAKAN<br>POKOK</th>
              <th class="left bottom" width="10%">KOLEK I<br>Tanpa Tunggakan</th>
              <th class="left bottom" width="10%">KOLEK II<br>Tunggakan 1-2</th>
              <th class="left bottom" width="10%">KOLEK III<br>Tunggakan 3-4</th>
              <th class="left bottom" width="10%">KOLEK IV <br>Tunggakan 5-6</th>
              <th class="left bottom right" width="10%">KOLEK V <br>Tunggakan &gt; 6</th>
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
		<td height='27' colspan='2' class='style9 left top'>$noc. KECAMATAN ".strtoupper($rc['nama_kec'])."</td>
		<td class='style9 left top align-right'>".number_format(saldopinjamanC("$tgl_kondisi-$idf-$kd_kec"))."</td>
		<td class='style9 left top align-right'>".number_format(nunggakpokokC("$tgl_kondisi-$idf-$kd_kec"))."</td>
		<td class='style9 left top align-right'>".number_format(kolek1C("$tgl_kondisi-$idf-$kd_kec"))."</td>
		<td class='style9 left top align-right'>".number_format(kolek2C("$tgl_kondisi-$idf-$kd_kec"))."</td>
		<td class='style9 left top align-right'>".number_format(kolek3C("$tgl_kondisi-$idf-$kd_kec"))."</td>
		<td class='style9 left top align-right'>".number_format(kolek4C("$tgl_kondisi-$idf-$kd_kec"))."</td>
		<td class='style9 left top right align-right'>".number_format(kolek5C("$tgl_kondisi-$idf-$kd_kec"))."</td>

	</tr>
	";
	

		$sumsaldopinjaman	=$sumsaldopinjaman+saldopinjamanC("$tgl_kondisi-$idf-$kd_kec");
		$sumnunggakpokok	=$sumnunggakpokok+nunggakpokokC("$tgl_kondisi-$idf-$kd_kec");
		$sumkolek1			=$sumkolek1+kolek1C("$tgl_kondisi-$idf-$kd_kec");
		$sumkolek2			=$sumkolek2+kolek2C("$tgl_kondisi-$idf-$kd_kec");
		$sumkolek3			=$sumkolek3+kolek3C("$tgl_kondisi-$idf-$kd_kec");
		$sumkolek4			=$sumkolek4+kolek4C("$tgl_kondisi-$idf-$kd_kec");
		$sumkolek5			=$sumkolek5+kolek5C("$tgl_kondisi-$idf-$kd_kec");
		}
		?>
		<tr align="right" height="30px" class="style27">
              <td class="left top bottom" align="center" colspan="2">J U  M L A H</td>
              <td class="left top bottom">					<?php echo number_format($sumsaldopinjaman);?></td>
			  <td class="left top bottom">					<?php echo number_format($sumnunggakpokok);?></td>	
			  <td class="left top bottom">					<?php echo number_format($sumkolek1);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek2);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek3);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek4);?></td>			
			  <td class="all">			<?php echo number_format($sumkolek5);?></td>			
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
<title>KD<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title>