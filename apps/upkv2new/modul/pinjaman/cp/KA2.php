<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";
include "../../../js/bar128.php";			 
?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 24px; text-align:center; font-weight: bold;}
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.text-center {text-align: center; }
.text-right {text-align: right; }
.style10 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
<body onLoad="window.print()">

     	 <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("SELECT * FROM
							kecamatan kc, desa d, users u, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk, jenis_jasa jj,
							fungsi_kelompok fgs, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							kc.id=k.lokasi AND d.id=k.desa AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
							jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND jj.id=pk.jenis_jasa AND 
							sa.id=pk.sistem_angsuran AND pk.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
										
		
											$id_pinj			=$row['id'];
											$id_kel				=$row['id_kel'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											$jad 				=$row['jadwal_angsuran_desa'];
											$angg=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$id_pinj'");  /* query hitung jumlah anggota */
											$jml_anggota=mysql_num_rows($angg);
		
		
		
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];
											if($jad=="" OR $jad==NULL){
											$tanggal			 = substr($tgl_cair,8,2);}
											else{
											$tanggal			 = $jad;}
											$bulan  			 = substr($tgl_cair,5,2);
											$tahun  			 = substr($tgl_cair,0,4);
											$pros_jasa			=$row['pros_jasa'];
											$jenis_jasa			=$row['jenis_jasa'];
											$nama_jj			=$row['nama_jj'];
											$jangka				=$row['jangka'];
											$sa_pokok			=$row['sistem'];
											
			//Sistem Angsuran
			$sj	=mysql_fetch_array(mysql_query("SELECT * FROM  sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE sa.id=pk.sa_jasa AND pk.id='$id_pinj' "));
				$sa_jasa	=$sj['sistem'];
				if ($sa_pokok>=$sa_jasa) {$sistem=$sa_jasa;}elseif ($sa_jasa>$sa_pokok) {$sistem=$sa_pokok;}
											
											
											$tempo				=$jangka/$sistem;
											$temp2				=$tempo%2;
											if($temp2==0){
												$temp			=$tempo/2;
											}
											else{
												$temp			=($tempo+1)/2;
											}
											if($temp<=1) {$tempe="1"; $bulangs=$bulan+$sistem;} elseif($temp<=3) {$tempe="3"; $bulangs=$bulan+$sistem;} else{$tempe=$temp; $bulangs=$bulan+1;}
											
			//Tempo Pokok
			if($row['sistem_angsuran']==11){
			$tempo_pokok		=($row['jangka'])-24/$sa_pokok; 
			}else if($row['sistem_angsuran']==14){
			$tempo_pokok		=($row['jangka'])-3/$sa_pokok;   
			}else if($row['sistem_angsuran']==15){
			$tempo_pokok		=($row['jangka'])-2/$sa_pokok;   
			}else if($row['sistem_angsuran']==20){
			$tempo_pokok		=($row['jangka'])-12/$sa_pokok;   
			}else{
			$tempo_pokok		=$jangka/$sa_pokok;
			}
			$temp_pokok			=$tempo_pokok/2;
			if($temp_pokok<=1) {$tempe_pokok="1"; $bulangs=$bulan+$sa_pokok;} elseif($temp_pokok<=3) {$tempe_pokok="3"; $bulangs=$bulan+$sa_pokok;} else{$tempe_pokok=$temp_pokok; $bulangs=$bulan+1;}
											
											
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											
											$lokasi				=$_SESSION['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$alamat_kec			=$row['alamat_kec'];
											$telpon_kec			=$row['telpon_kec'];
											$web_kec			=$row['web_kec'];
											$sebutan_kec		=$row['sebutan_kec'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1'"));
											$bendaharaupk		=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='3' AND sejak<='$tgl_cair' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabp			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='3' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$nama_desa			=$row['nama_desa'];
											$kd_kelompok		=$row['kd_kelompok'];
											$nama_kelompok		=$row['nama_kelompok'];
											$alamat_kelompok	=$row['alamat_kelompok'];
											$telpon				=$row['telpon'];
											$tgl_berdiri		=$row['tgl_berdiri'];
											$nama_jpp			=$row['nama_jpp'];
											$jenis_usaha		=$row['nama_ju'];
											$jenis_kegiatan		=$row['nama_jk'];
											$tingkat_kelompok	=$row['nama_tk'];
											$fungsi_kelompok	=$row['nama_fgs'];
											$ketua				=$row['ketua'];
											$sekretaris			=$row['sekretaris'];
											$lo					=$row['lo'];
											$uname				=$row['uname'];
											$pass				=$row['pass'];
											$id_user			=$row['namadepan']. " " .$row['namabelakang'];
											$tgl_now			=date('Y-m-d');
				
			?>

<table width="110%" border="0" align="center" cellpadding="1" cellspacing="0" style="margin-top:10px; "> 	  
      
      <tr>
        <th width="35%" class="style9"><?php echo strtoupper("$row[nama_lembaga_sort] $row[nama_kec]");?></th>
        <td width="15%" class="style9">Jenis Pinjaman </td>
        <td width="20%" class="style9">: <?php echo $nama_jpp;?></td>
        <td width="22%" class="style9">Loan.ID : <?php echo $id_pinj;?></td>
        <td width="11%" rowspan="7" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td rowspan="2" class="style9" align="center"><?php echo $alamat_kec;?><br>Telp. <?php echo $telpon_kec;?></td>
        <td class="style9">Nama Kelompok </td>
        <td colspan="2" class="style9">: <b><?php echo strtoupper($nama_kelompok);?></b></td>
      </tr>
      <tr>
        <td class="style9">Alamat</td>
        <td height="5" colspan="2" class="style9">: <?php echo "$alamat_kelompok $nama_desa";?></td>
      </tr>
      <tr>
        <td rowspan="4" align="center" class="style9"><?php		  		 
				echo bar128(stripslashes("$kd_kelompok")); ?></td>
        <td class="style9">Telpon/SMS</td>
        <td class="style9">: <?php echo $telpon;?></td>
		<td class="style9">Anggota : <?php echo "$jml_anggota org";?></td>
      </tr>
      <tr>
        <td class="style9">Tanggal Cair </td>
        <td class="style9">: <?php echo tgl_indo($tgl_cair);?></td>
        <td class="style9">Jangka : <?php echo "$jangka bulan";?></td>
      </tr>
      <tr>
        <td class="style9">Alokasi</td>
         <td class="style9"> : Rp. <?php echo number_format($alokasi);?></td>
         <td class="style9">Jasa : <?php echo "$pros_jasa %, $nama_jj"; ?>/bln</td>
      </tr>
      <tr>
        <td class="style9">Angsuran</td>
        <td class="style9">: Rp. <b><?php echo number_format(wajibpokokaja($id_pinj)+(wajibjasaaja($id_pinj))); ?></b><?php echo " /$sistem_angsuran"; ?></td>
		<td class="style9">setiap tanggal <b><?php echo number_format("$tanggal");?></b></td>
      </tr>  
</table>
<div class="style1 top bottom">KARTU ANGSURAN</div>
	  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">   
	  
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td width="6%" rowspan="3" class="style9">&nbsp;</td>
              <td height="29" colspan="10" class="style27">TABEL KEWAJIBAN PEMBAYARAN ANGSURAN </td>
            </tr>
            <tr>
              <th height="29" class="style9 top left">KE</th>
              <th class="style9 left top">TANGGAL</th>
              <th class="style9 left top">POKOK</th>
              <th class="style9 left top">JASA</th>
              <td class="style9 left">&nbsp;</td>
              <th height="29" class="style9 top left">KE</th>
              <th class="style9 left top">TANGGAL</th>
              <th class="style9 left top">POKOK</th>
              <th class="style9 left top">JASA</th>
              <td width="9%" rowspan="2" class="style9 left">&nbsp;</td>
            </tr>
            <tr>
              <td width="5%" height="33" class="style9 top left bottom"><div align="center" ><?php for($no=1;$no<=$tempe;$no++) {echo "$no<br>"; } ?></div></td>
              <td width="13%" class="style9 left top bottom"><div align="center"><?php 			  
			   //for($t1=$bulangs;$t1<=$tempe+$bulangs-1;$t1++) 
			  for($noo=1;$noo<=$tempe;$noo++) 
			  { 
			  $b=$bulan+$sistem*$noo;
			  $bagi_b=floor($b/12);
			  
			  if ($b>12 ){
				  if($b%12==0){
			  $bl=$b-(12*$bagi_b)+12;
				  }
				else{
			  $bl=$b-(12*$bagi_b);
			  $th=$tahun+$bagi_b;
			  }
			  }
			  else{
			  $bl=$b;
			  $th=$tahun;
			  }
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
			  echo "$tanggal/$bln/$th<br>"; } ?></div></td>
              <div align="center"></div></td>
			  
              <td width="12%" class="style9 left top bottom"><div align="right"><?php 			  
			    
			  for($nu=1;$nu<=$tempe;$nu++) //POKOK
			  {
			  
			  $b=$bulan+$sistem*$nu;
			  $bagi_b=floor($b/12);
			  
			  if ($b>12 ){
				  if($b%12==0){
			  $bl=$b-(12*$bagi_b)+12;
				  }
				else{
			  $bl=$b-(12*$bagi_b);
			  $th=$tahun+$bagi_b;
			  }
			  }
			  else{
			  $bl=$b;
			  $th=$tahun;
			  }
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
				$adaangsurankah=adaangsurankah("$th-$bln-$tanggal-$id_pinj");
				$wapok		=wajibpokokaja("$id_pinj");
				
				$sumpok=$wapok*($tempo_pokok-1);
				
				if ($nu<$tempo AND $adaangsurankah==0){
					$pok=number_format($wapok);
			  }elseif ($nu>=$tempo AND $adaangsurankah==0){
					$pok=number_format($alokasi-$sumpok, 0, ',', '.');
			  }else{
				  $pok="0";
			  }
				
			  echo "$pok<br>"; } ?></div></td>
			  
              <td width="12%" class="style9 left top bottom"><div align="right"><?php for($j=1;$j<=$tempe;$j++) {

			$b=$bulan+$sistem*$j;
			  $bagi_b=floor($b/12);
			  
			  if ($b>12 ){
				  if($b%12==0){
			  $bl=$b-(12*$bagi_b)+12;
				  }
				else{
			  $bl=$b-(12*$bagi_b);
			  $th=$tahun+$bagi_b;
			  }
			  }
			  else{
			  $bl=$b;
			  $th=$tahun;
			  }
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
				$wajibjasa=wajibjasa("$th-$bln-$tanggal-$id_pinj");
				
				$saldo=$alokasi-($wapok*($j-1));
			  if ($jenis_jasa==1){$bayar_jasa=$wajibjasa;}else if ($jenis_jasa==2) {$bayar_jasa=$saldo*($pros_jasa/100);} else{$bayar_jasa=$wajibjasa;}
			  
			  echo number_format($bayar_jasa)."<br>";


			  }
			  ?></div></td>
			  <td width="2%" class="style9 left">&nbsp;</td>
			  <!---->
              <td width="5%" height="33" class="style9 top left bottom"><div align="center" ><?php for($no=$tempe+1;$no<=$tempo;$no++) {echo "$no<br>"; } ?></div></td>
              <td width="12%" class="style9 left top bottom"><div align="center"><?php 			  
			  for($noe=$tempe+1;$noe<=$tempo;$noe++) 
			  {
			  $b=$bulan+$sistem*$noe;
			  $bagi_b=floor($b/12);
			  
			  if ($b>12 ){
				  if($b%12==0){
			  $bl=$b-(12*$bagi_b)+12;
				  }
				else{
			  $bl=$b-(12*$bagi_b);
			  $th=$tahun+$bagi_b;
			  }
			  }
			  else{
			  $bl=$b;
			  $th=$tahun;
			  }
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
			  echo "$tanggal/$bln/$th<br>"; } ?></div></td>
              <td width="12%" class="style9 left top bottom"><div align="right"><?php	
				
			  
			    
			  for($nu=$tempe+1;$nu<=$tempo;$nu++) //POKOK
			  {
			  
			  $b=$bulan+$sistem*$nu;
			  $bagi_b=floor($b/12);
			  
			  if ($b>12 ){
				  if($b%12==0){
			  $bl=$b-(12*$bagi_b)+12;
				  }
				else{
			  $bl=$b-(12*$bagi_b);
			  $th=$tahun+$bagi_b;
			  }
			  }
			  else{
			  $bl=$b;
			  $th=$tahun;
			  }
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
				$adaangsurankah=adaangsurankah("$th-$bln-$tanggal-$id_pinj");
				$wapok		=wajibpokokaja("$id_pinj");
				
				$sumpok=$wapok*($tempo_pokok-1);
				
				if ($nu<$tempo AND $adaangsurankah==0){
			  $pok=number_format($wapok);
			  }elseif ($nu>=$tempo AND $adaangsurankah==0){
			  $pok=number_format($alokasi-$sumpok, 0, ',', '.');
			  }else{
				  $pok="0";
			  }
				
			  echo "$pok<br>"; } ?></div></td>
              <td width="12%" class="style9 left top bottom"><div align="right"><?php for($j=$tempe+1;$j<=$tempo;$j++) {
			  $b=$bulan+$sistem*$j;
			  $bagi_b=floor($b/12);
			  
			  if ($b>12 ){
				  if($b%12==0){
			  $bl=$b-(12*$bagi_b)+12;
				  }
				else{
			  $bl=$b-(12*$bagi_b);
			  $th=$tahun+$bagi_b;
			  }
			  }
			  else{
			  $bl=$b;
			  $th=$tahun;
			  }
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
				$wajibjasa=wajibjasa("$th-$bln-$tanggal-$id_pinj");
				
				$saldo=$alokasi-($wapok*($j-1));
			  if ($jenis_jasa==1){$bayar_jasa=$wajibjasa;}else if ($jenis_jasa==2) {$bayar_jasa=$saldo*($pros_jasa/100);} else{$bayar_jasa=$wajibjasa;}
			  
			  
			  echo number_format($bayar_jasa)."<br>"; } ?></div></td>
            </tr>
</table>

<?php
$angs=mysql_query("select * from transaksi_$_SESSION[lokasi] t, users u where t.idtp!='0' AND t.id_pinj='$rcp' AND t.id_user=u.id GROUP BY idtp"); 
$jtrans=mysql_num_rows($angs);

if($jtrans>0) {
	echo '
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">   
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td width="6%" class="style9">&nbsp;</td>
              <td height="29" colspan="12" class="style27">REALISASI PEMBAYARAN ANGSURAN </td>
            </tr>
            <tr>
              <td height="10" class="style9">&nbsp;</td>
              <th width="5%" rowspan="2" class="style9 top left bottom">NO</th>
              <th width="10%" rowspan="2" class="style9 left top bottom">TANGGAL</th>
              <th colspan="2" class="style9 left top">POKOK</th>
              <th colspan="2" class="style9 left top">JASA</th>';
			  if($_SESSION['lokasi']==1 OR $_SESSION['kd_kab']==12){echo '<th width="10%" rowspan="2" class="style9 left top bottom">Denda</th>';}
			  echo '<th width="10%" rowspan="2" class="style9 left top bottom">SALDO</th>
              <th width="10%" rowspan="2" class="style9 left top bottom">SIGN</th>
              <td width="6%" class="style9 left">&nbsp;</td>
            </tr>
            <tr>
              <td height="15" class="style9">&nbsp;</td>
              <th width="10%" class="style9 left top bottom">Dibayar</th>
              <th width="10%" class="style9 left top bottom">Tunggakan</th>
              <th width="10%" class="style9 left top bottom">Dibayar</th>
              <th width="10%" class="style9 left top bottom">Tunggakan</th>
              <td class="style9 left">&nbsp;</td>
            </tr>
	';
	
	$no=0;
		while($r=mysql_fetch_array($angs)){
			$no=$no+1;
			$idtp			=$r['idtp'];
			$pokok			=pokok($idtp);
			$jasa			=jasa($idtp);
			$denda			=denda($idtp);
			$bln_transaksi	=substr($r['tgl_transaksi'],0,7);
			$tgl_kondisi	=date('Y-m-t', strtotime("$bln_transaksi-01"));
			$saldo1			=saldopinjaman("$r[tgl_transaksi]-$id_pinj");
			$saldo2			=saldo_jasa("$r[tgl_transaksi]-$id_pinj");
			$saldo			=$saldo1+$saldo2;
			$nunggakpokok	=nunggakpokok("$r[tgl_transaksi]-$id_pinj");
			$nunggakjasa	=nunggakjasa("$r[tgl_transaksi]-$id_pinj");
	echo '		
			<tr class="style10">
				<td>&nbsp;</td>
				<td class="text-center left">'.$no.'</td>
				<td class="text-center left">'.tgl_ind($r['tgl_transaksi']).'</td>
				<td class="text-right left">'.number_format($pokok).'</td>
				<td class="text-right left">'.number_format($nunggakpokok).'</td>
				<td class="text-right left">'.number_format($jasa).'</td>
				<td class="text-right left">'.number_format($nunggakjasa).'</td>';
			  if($_SESSION['lokasi']==1 OR $_SESSION['kd_kab']==12){echo '<td class="text-right left">'.number_format($denda).'</td>';}
		  echo '<td class="text-right left">'.number_format($saldo).'</td>
				<td class="left">'.$r['ins'].'-'.$r['idtp'].'</td>
				<td class="left">&nbsp;</td>
			</tr>
	
	';
		}
		FOR($no=1;$no<=16-$jtrans;$no++) {
	echo '
			<tr class="style10">
				<td>&nbsp;</td>
				<td class="left">&nbsp;</td>
				<td class="left">&nbsp;</td>
				<td class="left">&nbsp;</td>
				<td class="left">&nbsp;</td>
				<td class="left">&nbsp;</td>
				<td class="left">&nbsp;</td>';
			  if($_SESSION['lokasi']==1 OR $_SESSION['kd_kab']==12){echo '<td class="left">&nbsp;</td>';}
			  echo '<td class="left">&nbsp;</td>
				<td class="left">&nbsp;</td>
				<td class="left">&nbsp;</td>
			</tr>';
		}/////////////////////////////BORDER BAGIAN BAWAH
	echo '
	<tr class="style10">
              <td>&nbsp;</td>
              <td class="top">&nbsp;</td>
              <td class="top">&nbsp;</td>
              <td class="top">&nbsp;</td>
              <td class="top">&nbsp;</td>
              <td class="top">&nbsp;</td>
              <td class="top">&nbsp;</td>';
			  if($_SESSION['lokasi']==1 OR $_SESSION['kd_kab']==12){echo '<td class="top">&nbsp;</td>';}
			  echo '
              <td class="top">&nbsp;</td>
              <td class="top">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
	</table>
	';	
}else{
?>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">   
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td width="6%" class="style9">&nbsp;</td>
              <td height="29" colspan="12" class="style27">REALISASI PEMBAYARAN ANGSURAN </td>
            </tr>
            <tr>
              <td height="10" class="style9">&nbsp;</td>
              <th width="5%" rowspan="2" class="style9 top left bottom">NO</th>
              <th width="10%" rowspan="2" class="style9 left top bottom">TANGGAL</th>
              <th colspan="2" class="style9 left top">POKOK</th>
              <th colspan="2" class="style9 left top">JASA</th>
			  <?php
			  if($_SESSION['lokasi']==1 OR $_SESSION['kd_kab']==12){echo '<th width="10%" rowspan="2" class="style9 left top bottom">Denda</th>';}
			  ?>
              <th width="10%" rowspan="2" class="style9 left top bottom">SALDO</th>
              <th width="6%" rowspan="2" class="style9 left top bottom">SIGN</th>
              <td width="9%" class="style9 left">&nbsp;</td>
            </tr>
            <tr>
              <td height="15" class="style9">&nbsp;</td>
              <th width="10%" class="style9 left top bottom">Dibayar</th>
              <th width="10%" class="style9 left top bottom">Tunggakan</th>
              <th width="10%" class="style9 left top bottom">Dibayar</th>
              <th width="10%" class="style9 left top bottom">Tunggakan</th>
              <td class="style9 left">&nbsp;</td>
            </tr>
<?php FOR($no=1;$no<=16;$no++) { ?>
            <tr class="style10">
              <td>&nbsp;</td>
              <td class="left">&nbsp;</td>
              <td class="left">&nbsp;</td>
              <td class="left">&nbsp;</td>
              <td class="left">&nbsp;</td>
              <td class="left">&nbsp;</td>
              <td class="left">&nbsp;</td>
			  <?php
			  if($_SESSION['lokasi']==1 OR $_SESSION['kd_kab']==12){echo '<td class="left">&nbsp;</td>';}
			  ?>
              <td class="left">&nbsp;</td>
              <td class="left">&nbsp;</td>
              <td class="left">&nbsp;</td>
            </tr>
			<?php 
			}
			?>
			<!----------------------------BORDER BAGIAN BAWAH--------------------------------->
			<tr class="style10">
              <td>&nbsp;</td>
              <td class="top">&nbsp;</td>
              <td class="top">&nbsp;</td>
              <td class="top">&nbsp;</td>
              <td class="top">&nbsp;</td>
              <td class="top">&nbsp;</td>
              <td class="top">&nbsp;</td>
			  <?php
			  if($_SESSION['lokasi']==1 OR $_SESSION['kd_kab']==12){echo '<td class="top">&nbsp;</td>';}
			  ?>
              <td class="top">&nbsp;</td>
              <td class="top">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
</table>
<?php 
}
?>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0"> 
	<tr>
	<td width="6%">&nbsp;</td>
	  <td width="22%" class="style9 "><span class="style6">
	  Lembar 1 : Untuk Kelompok<br>
      Lembar 2 : Arsip <?php echo $row['sebutan_kec']; ?></span></td>
	    <th width="33%" height="24" class="style9 "><p align="center">&nbsp;</p>
	      <p align="center"><?php echo "$row[sebutan_level_1] $row[nama_lembaga_sort]";?></p>
	      <p align="center">&nbsp;</p>
	      <p align="center">&nbsp;</p>
      <p><?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?></p>      </th>
		<th width="30%" colspan="2" class="style9 "><p align="center">&nbsp;</p>
		  <p align="center">Ketua Kelompok </p>
		  <p align="center">&nbsp;</p>
          <p align="center">&nbsp;</p>
      <p><?php echo strtoupper($ketua); ?></p></th>
	  <td width="9%" rowspan="2" >&nbsp;</td>
  </tr>
	<tr>
	  <td height="15" colspan="5" class="style6">
	  
		<ol><b>Perhatian:</b>
		<li>Bayarlah angsuran tepat waktu sesuai dengan jadwal diatas</li>
		<li>Untuk memudahkan pelayanan, bawalah kartu ini dan slip pembayaran terakhir setiap melakukan angsuran</li>
		<li>Jagalah keutuhan kartu dan tidak melipatnya, jika hilang segera lapor <?php echo $row['nama_lembaga_sort']; ?></li>
		<li>Jika lembar ini tidak mencukupi, cetak pada lembar baliknya dengan dibubuhi stempel <?php echo $row['nama_lembaga_sort']; ?></li>
		<li>Cek Status Pinjaman anda secara online di <b><?php echo strtolower($row['web_kec']); ?></b></b></li>
		<li>Username: <b><?php echo $row['uname']; ?></b> Password: <b><?php echo $row['pass']; ?></b></li>
		</ol>
	  </td>
  </tr>
</table>
<?php } ?>        
</body>
