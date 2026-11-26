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
$thn_kondisi		="$y-01-01";

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date("Y-m-t", strtotime("$y-$m-01")); }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='$idf' "));
$jpp=$jp['nama_jpp'];
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
.align-left {text-align:left; }
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
		<td height="20" colspan="3" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. KK-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
     <tr>
        <td height="20" colspan="10" class="style6 bottom align-center"><br>LAPORAN KOLEKTIBILITAS PINJAMAN <?php echo $jpp;?> REKAP DESA<br><?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
    </tr>
			<tr align="center" height="40px" class="style9">
              <th class="left bottom" width="3%">NO</th>
              <th class="left bottom" width="20%">DESA</th>
              <th class="left bottom" width="10%">SALDO PINJAMAN </th>
              <th class="left bottom" width="10%">&Sigma; TUNGGAKAN<br>POKOK</th>
              <th class="left bottom" width="10%">KOLEK I<br>Tanpa Tunggakan</th>
              <th class="left bottom" width="10%">KOLEK II<br>Menunggak 1-2</th>
              <th class="left bottom" width="10%">KOLEK III<br>Menunggak 3-4</th>
              <th class="left bottom" width="10%">KOLEK IV <br>Menunggak 5-6</th>
              <th class="left bottom right" width="10%">KOLEK V <br>Menunggak &gt; 6</th>
            </tr>
	  <?php
		$nod=0;
		$data=mysql_query("SELECT * FROM kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND c.id='$lokasi' ORDER BY d.id ASC");
		while($r=mysql_fetch_array($data)){
		$nod=$nod+1;
		$idd=$r['id'];
		$no=$no+1;
		$row=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$r[user_id]' "));
		$ja=mysql_num_rows(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$r[id]' "));
		?>
		<?php
		$view=mysql_query("SELECT * FROM kelompok_$_SESSION[kd_kab] k, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.status='A' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='L' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='R' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_cair >0 AND pk.tgl_cair <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H' OR
		k.id=pk.id_kel AND pk.sistem_angsuran=sa.id AND k.desa='$r[id]' AND jenis_pp='$idf'  AND pk.tgl_lunas >0 AND pk.tgl_lunas <= '$tgl_kondisi'  AND pk.tgl_lunas >= '$thn_kondisi' AND pk.status='H'
		ORDER BY k.kd_kelompok ASC"); 
		$noo=0;
		$sumsaldopinjaman	=0;
		$sumnunggakpokok	=0;
		$sumkolek1			=0;
		$sumkolek2			=0;
		$sumkolek3			=0;
		$sumkolek4			=0;
		$sumkolek5			=0;
		while($row=mysql_fetch_array($view)){
		$noo=$noo+1;
		$idp	=$row['id'];
		$saldopinjaman	=saldopinjaman($tgl_kondisi."-".$idp);
		$nunggakpokok	=nunggakpokok($tgl_kondisi."-".$idp);
		$jum_nunggak	=jum_nunggak($tgl_kondisi."-".$idp);
		$kolek1			=kolek1($tgl_kondisi."-".$idp);
		$kolek2			=kolek2($tgl_kondisi."-".$idp);
		$kolek3			=kolek3($tgl_kondisi."-".$idp);
		$kolek4			=kolek4($tgl_kondisi."-".$idp);
		$kolek5			=kolek5($tgl_kondisi."-".$idp);
		
		$jangka			=jangka($idp);
		
		if($jum_nunggak>0 and $jum_nunggak<$jangka){$sig_nunggak=floor($jum_nunggak)."+";}elseif($jum_nunggak>$jangka){$sig_nunggak=$jangka."+";}else{$sig_nunggak=$jum_nunggak;}
		
		?>
		<?php
		$sumsaldopinjaman	=$sumsaldopinjaman+$saldopinjaman;
		$sumnunggakpokok	=$sumnunggakpokok+$nunggakpokok;
		$sumkolek1			=$sumkolek1+$kolek1;
		$sumkolek2			=$sumkolek2+$kolek2;
		$sumkolek3			=$sumkolek3+$kolek3;
		$sumkolek4			=$sumkolek4+$kolek4;
		$sumkolek5			=$sumkolek5+$kolek5;
		$sumsaldopinjaman1	=$sumsaldopinjaman1+$saldopinjaman;
		$sumnunggakpokok1	=$sumnunggakpokok1+$nunggakpokok;
		$sumkolek11			=$sumkolek11+$kolek1;
		$sumkolek21			=$sumkolek21+$kolek2;
		$sumkolek31			=$sumkolek31+$kolek3;
		$sumkolek41			=$sumkolek41+$kolek4;
		$sumkolek51			=$sumkolek51+$kolek5;
		}
		?>


		<tr align="right" height="15px" class="style9">
			<td class="style9 left top align-center" ><?php echo $nod;?></td>
			<td class="style9 left top align-left" ><?php echo strtoupper($r['nama_desa']);?></td>
              <td class="left top ">					<?php echo number_format($sumsaldopinjaman);?></td>
			  <td class="left top ">					<?php echo number_format($sumnunggakpokok);?></td>	
			  <td class="left top ">					<?php echo number_format($sumkolek1);?></td>			
			  <td class="left top ">					<?php echo number_format($sumkolek2);?></td>			
			  <td class="left top ">					<?php echo number_format($sumkolek3);?></td>			
			  <td class="left top ">					<?php echo number_format($sumkolek4);?></td>			
			  <td class="left top right">			                    <?php echo number_format($sumkolek5);?></td>	
		</tr>
		<?php
		} 
		?>
		<tr align="right" height="30px" class="style27">
              <td class="left top bottom" align="center" colspan="2">J U  M L A H</td>
              <td class="left top bottom">					<?php echo number_format($sumsaldopinjaman1);?></td>
			  <td class="left top bottom">					<?php echo number_format($sumnunggakpokok1);?></td>	
			  <td class="left top bottom">					<?php echo number_format($sumkolek11);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek21);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek31);?></td>			
			  <td class="left top bottom">					<?php echo number_format($sumkolek41);?></td>			
			  <td class="all">			                    <?php echo number_format($sumkolek51);?></td>			
		</tr>
</table>

<?php include "tanda_tangan.php"; ?> 		
	          
<?php /* session_start();
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

	 if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $tgl_kondisi="$y-$m-$d"; }
else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $tgl_kondisi=date("Y-m-t", strtotime("$y-$m-01")); }
else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $tgl_kondisi="$y-12-31"; }
else{$laporan="Global";}

$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' "));
$u=mysql_fetch_array(mysql_query("SELECT * FROM users where id='$_SESSION[id]' "));

$jp=mysql_fetch_array(mysql_query("SELECT * FROM jenis_produk_pinjaman where id='$idf' "));
$jpp=$jp['nama_jpp'];

if($_SESSION['level']=='kab' and $lokasi<=0 OR $_SESSION['level']=='pusat' and $lokasi<=0){
	$levelc="WHERE kd_kab='$_SESSION[kd_kab]'";
}else{
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
<?php
if($_SESSION['level']=='kab' and $lokasi<=0 OR $_SESSION['level']=='pusat' and $lokasi<=0){
	?>
	<tr>
		<td height="20" colspan="5" class="bottom">
			<?php
				$logo=$row['kd_kab'];
						echo "<img class='' alt='...' src='../../../images/$logo.jpg' style='float:left; width:50; margin-right:5px;'>";
			echo "<div class='style9'>".strtoupper("<b>PEMERINTAH KABUPATEN $row[nama_kab]<br>$row[nama_lembaga]</b>")."<br>$row[alamat_kab] Telp. $row[telpon_kab] </div>"; 
			?>
		</td>
		<td height="20" colspan="4" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. KD-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
<?php
}else{
?>
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
		<td height="20" colspan="4" class="bottom">
			<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
			Kd.Doc. KD-<?php echo $idf;?> Lembar-1 </div>
		</td>
	</tr> 
<?php } ?>
     <tr>
        <td height="20" colspan="9" class="style6 bottom align-center"><br>LAPORAN KOLEKTIBILITAS PINJAMAN <?php echo $jpp;?> REKAP DESA<br>
		<?php echo strtoupper("$jenis ".tgl_indo($tgl));?></td>
        </td>
    </tr>
			<tr align="center" height="40px" class="style9">
              <th class="left bottom" width="3%">NO</th>
              <th class="left bottom" width="20%">KELOMPOK</th>
              <th class="left bottom" width="10%">SALDO PINJAMAN </th>
              <th class="left bottom" width="10%">&Sigma; TUNGGAKAN<br>POKOK</th>
              <th class="left bottom" width="10%">KOLEK I<br>Tanpa Tunggakan</th>
              <th class="left bottom" width="10%">KOLEK II<br>Menunggak 1-2</th>
              <th class="left bottom" width="10%">KOLEK III<br>Menunggak 3-4</th>
              <th class="left bottom" width="10%">KOLEK IV <br>Menunggak 5-6</th>
              <th class="left bottom right" width="10%">KOLEK V <br>Menunggak &gt; 6</th>
            </tr>
	  <?php
	$kec=mysql_query("SELECT * FROM kecamatan $levelc "); // KEC
	$noc=0;
	while($rc=mysql_fetch_array($kec)){
	$noc=$noc+1;
	$_SESSION['lokasi']=$rc['id'];
	$kd_kec	=$rc['kd_kec'];
	echo"
	<tr>
		<td height='27' colspan='2' class='style27 left top'>$noc. KECAMATAN ".strtoupper($rc['nama_kec'])."</td>
		<td class='style27 left top align-right'>".number_format(saldopinjamanC("$tgl_kondisi-$idf-$kd_kec"))."</td>
		<td class='style27 left top align-right'>".number_format(nunggakpokokC("$tgl_kondisi-$idf-$kd_kec"))."</td>
		<td class='style27 left top align-right'>".number_format(kolek1C("$tgl_kondisi-$idf-$kd_kec"))."</td>
		<td class='style27 left top align-right'>".number_format(kolek2C("$tgl_kondisi-$idf-$kd_kec"))."</td>
		<td class='style27 left top align-right'>".number_format(kolek3C("$tgl_kondisi-$idf-$kd_kec"))."</td>
		<td class='style27 left top align-right'>".number_format(kolek4C("$tgl_kondisi-$idf-$kd_kec"))."</td>
		<td class='style27 left top right align-right'>".number_format(kolek5C("$tgl_kondisi-$idf-$kd_kec"))."</td>

	</tr>
	";
	
		$des=mysql_query("SELECT * FROM desa WHERE kd_kec='$rc[kd_kec]' ORDER by id ASC"); //START DESA
		$nod=0;
		while($r=mysql_fetch_array($des)){
		$idd=$r['id'];
		$nod=$nod+1;
		?>
		<tr>
			<td class="style9 left top align-center" ><?php echo $nod;?></td>
			<td class="style9 left top" ><?php echo strtoupper($r['nama_desa']);?></td>
			<td class="style9 left top align-right"><?php echo number_format(saldopinjamanD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format(nunggakpokokD("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format(kolek1D("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format(kolek2D("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format(kolek3D("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style9 left top align-right"><?php echo number_format(kolek4D("$tgl_kondisi-$idf-$idd"));?></td>
			<td class="style9 left top right align-right"><?php echo number_format(kolek5D("$tgl_kondisi-$idf-$idd"));?></td>
		</tr>

		<?php
		$sumsaldopinjaman	=$sumsaldopinjaman+saldopinjamanD("$tgl_kondisi-$idf-$idd");
		$sumnunggakpokok	=$sumnunggakpokok+nunggakpokokD("$tgl_kondisi-$idf-$idd");
		$sumkolek1			=$sumkolek1+kolek1D("$tgl_kondisi-$idf-$idd");
		$sumkolek2			=$sumkolek2+kolek2D("$tgl_kondisi-$idf-$idd");
		$sumkolek3			=$sumkolek3+kolek3D("$tgl_kondisi-$idf-$idd");
		$sumkolek4			=$sumkolek4+kolek4D("$tgl_kondisi-$idf-$idd");
		$sumkolek5			=$sumkolek5+kolek5D("$tgl_kondisi-$idf-$idd");
		} }
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
 */
 ?> 		
	          
</body>
<title>KD<?php echo "-$idf $jenis ".tgl_indo($tgl);?></title> 