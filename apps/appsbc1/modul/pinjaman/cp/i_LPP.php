<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";
include "../../../inc/phpqrcode/qrlib.php"; //Library Pembuat QR-Code	

$idp	=$_GET['idp'];

$kec=mysql_fetch_array(mysql_query("SELECT * FROM sebutan_desa sd, desa d where sd.id=d.sebutan AND d.id='$_SESSION[lokasi]' "));

$row=mysql_fetch_array(mysql_query("SELECT * FROM desa d, sebutan_desa sd, anggota_$_SESSION[kd_kab] a, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE jpp.id=pi.jenis_pp AND sd.id=d.sebutan AND jj.id=pi.jenis_jasa AND sa.id=pi.sistem_angsuran AND a.desa=d.id and a.id=pi.nia AND a.lokasi='$_SESSION[lokasi]' AND pi.status='A' AND pi.id= '$idp' "));
	
$jum_angsuran	=@($row['jangka']/$row['sistem']);
$id_pinj		=$row['id'];
$_SESSION['id_pinj']	=$row['id'];
$sistem			=$row['sistem'];
$alokasi			=$row['alokasi'];
$tgl_cair			=$row['tgl_cair'];
$pros_jasa			=$row['pros_jasa'];
$jenis_jasa			=$row['jenis_jasa'];
$nama_jj			=$row['nama_jj'];
$jangka				=$row['jangka'];
$sistem				=$row['sistem'];
$tempo				=@($jangka/$sistem);
$datenow		=date('Y-m-d');
$tottargetpokok	=targetpokok("$datenow-$id_pinj");
$tottargetjasa		=targetjasa("$datenow-$id_pinj");
$sumpokok		=sumpokok("$datenow-$id_pinj");
$sumjasa		=sumjasa("$datenow-$id_pinj");
$totsaldopinjaman	=saldopinjaman("$datenow-$id_pinj");
$totnunggakpokok	=nunggakpokok("$datenow-$id_pinj");
$totnunggakjasa	=nunggakjasa("$datenow-$id_pinj");
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
.green {color:green; }
.red {color:red; }
-->
</style>
<body onLoad="window.print()">

<?php 
if($idp=="") {
	echo "<p align='center' class='style6'>
		<br><br>SILAHKAN PILIH NAMA PEMANFAAT TERLEBIH DAHULU :)</p>";
}else{
?>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="4" class="bottom">
				<?php
			echo "<img class='' alt='...' src='../../../images/logo_lpd.gif' style='float:left; width:50; margin-right:5px;'>";

											
			$nomor_bh	=$kec ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="SK Gubernur Bali No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>LPD $kec[sebutan_desa] $kec[nama_desa]<br>KECAMATAN $kec[nama_kec]</b>")."<br>$bh $kec[alamat_desa] Telp. $kec[telpon_desa] </div>"; 
			?>	
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pinjaman<br>
			Loan ID. <?php echo $row['nik'];?>-<?php echo $row['id'];?>
			 </div></td>
		  </tr> 	  
      

      <tr>
        <td height="20" colspan="6" class="bottom"><p align="center" class="style6">
		LAPORAN PERKEMBANGAN PINJAMAN<br>
		NAMA DEBITUR : <b><?php echo strtoupper($row['namadepan']);?></b></p></td>
      </tr>
      <tr>
        <td width="15%" rowspan="6">
		<?php											
				$foto="../../../foto_anggota/$row[nik].jpg";
					if (!file_exists($foto)) { 
						echo "<img  src='../../../img/avatar.png' alt='...' style='width:110px; margin-left:30px;' >";
					}else{
						echo "<img  alt='' src='$foto' style='width:110px; margin-left:30px;'>";
					} 
										?>
		</td>
        <td width="15%" height="15" class="style9">NIK</td>
        <td width="27%" height="15"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($row['nik']);?></span></td>
        <td width="15%" height="15" class="style9">Loan ID</td>
        <td width="28%" height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[nama_jpp]-$row[id]"; ?></span></td>
		<td width="15%" rowspan="6">
		<?php											
		//Membuat QR-Code
		$qr="../../../images/qrcode/$row[nik].png";
		$tempdir = "../../../images/qrcode/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
		if (!file_exists($qr)) { 
			
				$isi_teks = $row['nik'];
				$namafile = $row['nik'].".png";
				$quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
				$ukuran = 5; //batasan 1 paling kecil, 10 paling besar
				$padding = 3;
				 
				QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
		}
	
	echo "<img  alt='' src='$qr' style='width:110px; margin-right:15px;'>";

	?>
		</td>
	  </tr>
	  <tr>
        <td height="15" class="style9">Nama Pemanfaat</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($row['namadepan']);?></span></td>
        <td height="15" class="style9">Tanggal Cair</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($row['tgl_cair']); ?></span></td>
      </tr>
      <tr>
        <td height="15" class="style9">Alamat</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[alamat]";?></span></td>
        <td height="15" class="style9"> Alokasi Pinjaman </td>
        <td height="15"><span class="style9">:</span><span class="style27"> Rp. <?php echo number_format($row['alokasi']);?>,-</span></td>
      </tr>
	  <tr>
        <td height="15" class="style9">Desa</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[nama_desa]";?></span></td>
        <td height="15" class="style9">Prosentase, Jenis Jasa</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[pros_jasa] %/bulan, $row[nama_jj]";?></span></td>
      </tr>
      <tr>
        <td height="15" class="style9">Telpon</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[hp]";?></span></td>
        <td height="15" class="style9">Sistem Angsuran</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[nama_sistem] ($row[jangka] bulan)";?> </span></td>
      </tr>
	  <tr>
        <td height="15" class="style9">Nama Penjamin</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[penjamin]";?></span></td>
        <td height="15" class="style9">Jumlah Angsuran</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "Rp. ".number_format(wajibpokokaja($id_pinj)+(wajibjasaaja($id_pinj)*$sistem))." x $jum_angsuran";?> </span></td>
      </tr> 
</table>

<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<thead>
	<tr>
	    <th width="4%" height="30" class="style9 all" rowspan="2">KE</th>
	    <th width="10%" class="style9 top bottom right" rowspan="2">BULAN</th>
	    <th class="style9 top bottom right" colspan="2">TARGET</th>
	    <th class="style9 top bottom right" colspan="2">REALISASI</th>
	    <th width="10%" class="style9 top bottom right" rowspan="2">SALDO PINJAMAN</th>
	    <th class="style9 right top bottom" colspan="2">TUNGGAKAN</th>
    </tr>
	<tr>
	    <th width="10%" class="style9 right bottom" >POKOK</th>
        <th width="10%" class="style9 right bottom">JASA</th>
		<th width="10%" class="style9 right bottom" >POKOK</th>
        <th width="10%" class="style9 right bottom">JASA</th>
		<th width="10%" class="style9 right bottom" >POKOK</th>
        <th width="10%" class="style9 right bottom">JASA</th>
	</tr>
	</thead>
	
	<tbody>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>			  
			  <td class="style9 left bottom right align-center"><?php 
			  
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			
				$tanggal  			 = substr($tgl_cair,8,2);
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  

			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
			  
			    $date	="$th-$bln";
				$datenow=date('Y-m');
			
			if($date == $datenow) {
			  echo "<div class='green style27'>$noo</div><br>"; 
			  }else{
			  echo "$noo<br><br>"; 
			  }


			  } ?> ></td>
			  
			  <td class="style9 bottom right"><?php 
			  
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			
				$tanggal  			 = substr($tgl_cair,8,2);
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  

			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
			  
			    $date	="$th-$bln";
				$datenow=date('Y-m');
				
				$bulan=strtoupper(tgl_indo($date));
			
			if($date == $datenow) {
			  echo "<div class='green style27'>$bulan</div><br>"; 
			  }else{
			  echo "$bulan<br><br>"; 
			  }


			  } ?> >>>>> </td>
			  
			  
			  <td class="style9 bottom right align-right"><?php 
			  
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			  
				$tanggal			 = "31";
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  

			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
			
			  $date	="$th-$bln";
				$datenow=date('Y-m');
			
			$targetpokok=targetpokok("$th-$bln-$tanggal-$id_pinj");	
			
			if($date == $datenow) {
			  echo "<div class='green style27'>".number_format($targetpokok)."</div><br>"; 
			  }else{
			  echo "".number_format($targetpokok)."<br><br>"; 
			  }


			  } ?> - </td>
			  
			<td class="style9 bottom right align-right"><?php 
			  
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			  
				$tanggal			 = "31";
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  

			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
			$date	="$th-$bln";
			$datenow=date('Y-m');
			
			$targetjasa=targetjasa("$th-$bln-$tanggal-$id_pinj");	
			
			if($date == $datenow) {
			  echo "<div class='green style27'>".number_format($targetjasa)."</div><br>"; 
			  }else{
			  echo "".number_format($targetjasa)."<br><br>"; 
			  }
			  
			  } ?> -- </td>
			  
			  <td class="style9 bottom right align-right"><?php 
			  
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			  
				$tanggal			 = "31";
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  

			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
			$date	="$th-$bln";
			$datenow=date('Y-m');
				
			$realisasiinipokok=realisasiinipokok("$th-$bln-$tanggal-M-$id_pinj");
			if($date <= $datenow and $date != $datenow) {
			  echo "".number_format($realisasiinipokok)."<br><br>"; 
			  }else if($date <= $datenow and $date == $datenow) {
			  echo "<div class='green style27'>".number_format($realisasiinipokok)."</div><br><br>"; 
			  }else{
			  echo "0<br><br>"; 
			  }
			 
			 } ?></td>
			  
			<td class="style9 bottom right align-right"><?php 
			  
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			  
				$tanggal			 = "31";
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  

			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
			$date	="$th-$bln";
			$datenow=date('Y-m');
				
			$realisasiinijasa=realisasiinijasa("$th-$bln-$tanggal-M-$id_pinj");
			if($date <= $datenow and $date != $datenow) {
			  echo "".number_format($realisasiinijasa)."<br><br>"; 
			  }else if($date <= $datenow and $date == $datenow) {
			  echo "<div class='green style27'>".number_format($realisasiinijasa)."</div><br><br>"; 
			  }else{
			  echo "0<br><br>"; 
			  }
			 
			 } ?></td>
			  
			<td class="style9 bottom right align-right"><?php 
			  
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			  
				$tanggal			 = "31";
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  

			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
			$date	="$th-$bln";
			$datenow=date('Y-m');
				
			$saldopinjaman=saldopinjaman("$th-$bln-$tanggal-$id_pinj");
			if($date <= $datenow and $date != $datenow) {
			  echo "".number_format($saldopinjaman)."<br><br>"; 
			  }else if($date <= $datenow and $date == $datenow) {
			  echo "<div class='green style27'>".number_format($saldopinjaman)."</div><br><br>"; 
			  }else{
			  echo "0<br><br>"; 
			  }
			 
			 } ?></td>
			  
			<td class="style9 bottom right align-right"><?php 
			  
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			  
				$tanggal			 = "31";
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  

			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
			$date	="$th-$bln";
			$datenow=date('Y-m');
				
			$nunggakpokok=nunggakpokok("$th-$bln-$tanggal-$id_pinj");
			if($nunggakpokok>0) {$warna="red";}
			if($date <= $datenow and $date != $datenow) {
			  echo "<span class=$warna>".number_format($nunggakpokok)."</span><br><br>"; 
			  }else if($date <= $datenow and $date == $datenow) {
			  echo "<div class='green style27'>".number_format($nunggakpokok)."</div><br><br>"; 
			  }else{
			  echo "0<br><br>"; 
			  }
			 
			 } ?></td>
			  
			<td class="style9 bottom right align-right"><?php 
			  
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			  
				$tanggal			 = "31";
				$bulan  			 = substr($tgl_cair,5,2);
				$tahun  			 = substr($tgl_cair,0,4);
			  
			  $b=$bulan+$sistem*$noo;
			  
			  if ($b>12 and $b<=24){
			  $bl=$b-12;
			  $th=$tahun+1;
			  }else if ($b>24){
			  $bl=$b-24;
			  $th=$tahun+2;
			  }else{
			  $bl=$b;
			  $th=$tahun;
			  }
			  

			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
			$date	="$th-$bln";
			$datenow=date('Y-m');
				
			$nunggakjasa=nunggakjasa("$th-$bln-$tanggal-$id_pinj");
			if($nunggakjasa>0) {$warna="red";}
			if($date <= $datenow and $date != $datenow) {
			  echo "<span class=$warna>".number_format($nunggakjasa)."</span><br><br>"; 
			  }else if($date <= $datenow and $date == $datenow) {
			  echo "<div class='green style27'>".number_format($nunggakjasa)."</div><br><br>"; 
			  }else{
			  echo "0<br><br>"; 
			  }
			 
			 } ?></td>
			  
			
			  
			  
			  
			  
            </tr>

		
		<!-- Menampilkan Jumlah Total pada tabel -->
		 <tr>	  
          <th width="2%" height="28px" colspan="2" class="style27 left bottom right align-right">REKAPITULASI</th>
              <th width="10%" class="style27 bottom right align-right"><?php echo number_format($tottargetpokok); ?></th>
              <th width="10%" class="style27 bottom right align-right"><?php echo number_format($tottargetjasa); ?></th>
			  <th width="10%" class="style27 bottom right align-right"><?php echo number_format($sumpokok); ?></th>
			  <th width="10%" class="style27 bottom right align-right"><?php echo number_format($sumjasa); ?></th>
			  <th width="10%" class="style27 bottom right align-right"><?php echo number_format($totsaldopinjaman); ?></th>
			  <th width="10%" class="style27 bottom right align-right"><?php echo number_format($totnunggakpokok); ?></th>
			  <th width="10%" class="style27 bottom right align-right"><?php echo number_format($totnunggakjasa); ?></th>
        </tr> 
	</tbody>
	
	<?php
}
	?>           
</body>
<title>Laporan Perkembangan Pinajaman Individu | By Name</title>