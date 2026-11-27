<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

$idp	=$_GET['idp'];

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$_SESSION[lokasi]' "));

$row=mysql_fetch_array(mysql_query("SELECT * FROM desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE jpp.id=pk.jenis_pp AND sd.id=d.sebutan AND jj.id=pk.jenis_jasa AND sa.id=pk.sistem_angsuran AND k.desa=d.id and k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.id='$idp' "));
	
$jum_angsuran	=@($row['jangka']/$row['sistem']);
$id_pinj		=$row['id'];
$_SESSION['id_pinj']	=$row['id'];
$sistem			=$row['sistem'];
$sa_jasa			=$row['sa_jasa'];
$rowss=mysql_fetch_array(mysql_query("SELECT * FROM sistem_angsuran WHERE id=$sa_jasa"));
$sa_jasa			=$row['jangka']/$rowss['sistem'];
$alokasi			=$row['alokasi'];
$tgl_cair			=$row['tgl_cair'];
$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
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
		<br><br>SILAHKAN PILIH NAMA KELOMPOK TERLEBIH DAHULU :)</p>";
}else{
?>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="3" class="bottom">
				<?php
				$logo=$kec['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$kec ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$kec[nama_lembaga_long]<br>$kec[sebutan_kec] $kec[nama_kec] KABUPATEN $kec[nama_kab]</b>")."<br>$bh $kec[alamat_kec] Telp. $kec[telpon_kec] </div>"; 
			?>	
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pinjaman<br>
			Loan ID. <?php echo $row['kd_kelompok'];?>-<?php echo $row['id'];?>
			 </div></td>
		  </tr> 	  
      

      <tr>
        <td height="20" colspan="5" class="bottom"><p align="center" class="style6">
		LAPORAN PERKEMBANGAN PINJAMAN PER KELOMPOK<br>
		<b><?php echo strtoupper("KELOMPOK $row[nama_jpp] $row[nama_kelompok] $row[sebutan_desa] $row[nama_desa]");?></b></p></td>
      </tr>
      <tr>
        <td width="15%" rowspan="7">
			&nbsp;
		</td>
        <td width="15%" height="15" class="style9">ID. Kelompok</td>
        <td width="27%" height="15"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($row['kd_kelompok']);?></span></td>
        <td width="15%" height="15" class="style9">Loan ID</td>
        <td width="28%" height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[nama_jpp]-$row[id]"; ?></span></td>
      </tr>
	  <tr>
        <td height="15" class="style9">Nama Kelompok</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($row['nama_kelompok']);?></span></td>
        <td height="15" class="style9">Nomor SPK</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[spk_no]"; ?></span></td>
      </tr>
      <tr>
        <td height="15" class="style9">Alamat</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[alamat_kelompok]";?></span></td>
        <td height="15" class="style9"> Tanggal Cair </td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($row['tgl_cair']); ?></span></td>
      </tr>
	  <tr>
        <td height="15" class="style9"><?php echo "$row[sebutan_desa]";?></td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[nama_desa]";?></span></td>
        <td height="15" class="style9">Alokasi Pinjaman</td>
        <td height="15"><span class="style9">:</span><span class="style27">  Rp. <?php echo number_format($row['alokasi']);?>,-</span></td>
      </tr>
      <tr>
        <td height="15" class="style9">Telpon/SMS</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[telpon]";?></span></td>
        <td height="15" class="style9">Prosentase, Jenis Jasa</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$pros_jasa %/bulan, $row[nama_jj]";?> </span></td>
      </tr>
	  <tr>
        <td height="15" class="style9">Nama Ketua</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[ketua]";?></span></td>
        <td height="15" class="style9">Sistem Angsuran</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[nama_sistem] ($row[jangka] bulan)";?> </span></td>
      </tr>
	  <tr>
        <td height="15" class="style9">Nama Sekretaris</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "$row[sekretaris]";?></span></td>
        <td height="15" class="style9">Jumlah Angsuran</td>
        <td height="15"><span class="style9">:</span><span class="style27"> <?php echo "Rp. ".number_format(wajibpokokaja($id_pinj)+(wajibjasaaja($id_pinj)*$sa_jasa))." x $jum_angsuran";?> </span></td>
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
          <th width="2%" height="36px" colspan="2" class="style27 left bottom right align-center">REKAPITULASI</th>
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
<title>Laporan Perkembangan Pinjaman by Kelompok</title>