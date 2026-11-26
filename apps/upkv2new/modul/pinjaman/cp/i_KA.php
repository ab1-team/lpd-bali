<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";
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
	border-bottom: 1px solid black;
}
-->
</style>
<body onLoad="window.print()">

     	 <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us, users u, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND
																sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
																a.id=pi.nia AND u.id=a.petugas AND pi.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = substr($tgl_cair,5,2);
											$tahun  			 = substr($tgl_cair,0,4);
											
											$pros_jasa			=$row['pros_jasa'];
											
											$jenis_jasa			=$row['jenis_jasa'];
											$nama_jj			=$row['nama_jj'];
											$jangka				=$row['jangka'];
											$sa_pokok			=$row['sistem'];
											
											//Sistem Angsuran
			$sj	=mysql_fetch_array(mysql_query("SELECT * FROM  sistem_angsuran sa, pinjaman_anggota_$_SESSION[kd_kab] pi WHERE sa.id=pi.sa_jasa AND pi.id='$id_pinj' "));
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
			}else{
			$tempo_pokok		=$jangka/$sa_pokok;
			}
			$temp_pokok			=$tempo_pokok/2;
			if($temp_pokok<=1) {$tempe_pokok="1"; $bulangs=$bulan+$sa_pokok;} elseif($temp_pokok<=3) {$tempe_pokok="3"; $bulangs=$bulan+$sa_pokok;} else{$tempe_pokok=$temp_pokok; $bulangs=$bulan+1;}
				
											$sistem_angsuran	=$row['nama_sistem'];
											
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$_SESSION[lokasi]' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											
				
			?>

<table width="110%" border="0" align="center" cellpadding="1" cellspacing="0" style="margin-top:10px; "> 	  
      
      <tr>
        <th width="38%" class="style9"><?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?></th>
        <td width="13%" class="style9">Nama Anggota / L.ID </td>
        <td colspan="2" class="style9">: <b><?php echo strtoupper($row['namadepan']);?> / <?php echo $id_pinj;?></b></td>
        <td width="11%" rowspan="7" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td rowspan="2" class="style9" align="center"><?php echo $row['alamat_kec'];?><br>Telp. <?php echo $row['telpon_kec'];?></td>
        <td class="style9">Alamat </td>
        <td colspan="2" class="style9">: <?php echo "$row[alamat] $row[nama_desa]";?></td>
      </tr>
      <tr>
        <td class="style9">Telpon</td>
        <td height="5" colspan="2" class="style9">: <?php echo $row['hp'];?></td>
      </tr>
      <tr>
        <td rowspan="4" align="center" class="style9"><?php		  		 
				echo bar128(stripslashes("$row[nik]")); ?></td>
        <td class="style9">Jenis Usaha</td>
        <td colspan="2" class="style9">: <?php echo $row['nama_usaha'];?></td>
      </tr>
      <tr>
        <td class="style9">Tanggal Cair </td>
        <td width="17%" class="style9">: <?php echo tgl_ind($tgl_cair);?></td>
        <td width="21%" class="style9">Jangka : <?php echo "$jangka bulan";?></td>
      </tr>
      <tr>
        <td class="style9">Alokasi</td>
         <td class="style9"> : Rp. <?php echo number_format($alokasi);?></td>
         <td class="style9">Jasa : <?php echo "$pros_jasa %, $nama_jj"; ?></td>
      </tr>
      <tr>
        <td class="style9">Angsuran</td>
        <td colspan="2" class="style9">: Rp. <b><?php echo number_format(wajibpokokaja($id_pinj)+(wajibjasaaja($id_pinj)*$sistem)); ?></b><?php echo " /$sistem_angsuran"; ?></td>
      </tr>  
</table>
<div class="style1 top bottom">KARTU ANGSURAN INDIVIDU</div>
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
				
			  echo "$tanggal/$bln/$th<br>"; } ?></div>
              <div align="center"></div></td>
			  
              <td width="12%" class="style9 left top bottom"><div align="right"><?php	
				for($nu=1;$nu<=$tempe;$nu++) //POKOK
			  {
			  
			  $b=$bulan+$sistem*$nu;
			  $bagi_b=floor($b/12);
			  
			  if ($b>=12 ){
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
				
				$adaangsurankah=adaangsurankah_anggota("$th-$bln-$tanggal-$id_pinj");
				$wapok		=wajibpokokaja_anggota("$id_pinj");
				
				$sumpok=$wapok*($tempo_pokok-1);
				
				if ($nu<$tempo AND $adaangsurankah==0){
					$pok=number_format($wapok);
			  }elseif ($nu>=$tempo AND $adaangsurankah==0){
					$pok=number_format($alokasi-$sumpok, 0, ',', '.');
			  }else{
				  $pok="0";
			  }
				
			  echo "$pok<br>"; } ?>
			  </div></td>
			  
              <td width="12%" class="style9 left top bottom"><div align="right"><?php for($j=1;$j<=$tempe;$j++) {
			  $jasa=wajibjasaaja_anggota($id_pinj)*$sistem;
			  if($j<=$tempo){
			  $js=$jasa;
			  }else{
			  $js="-";
			  }
			  
			  $saldo=$alokasi-($wapok*($j-1));
			  if ($jenis_jasa==1){$bayar_jasa=$js;}else if ($jenis_jasa==2) {$bayar_jasa=$saldo*($pros_jasa/100);} else{$bayar_jasa=$js;}
			  $bulat_jasa=bulatkan($bayar_jasa);
			  
			  echo "".number_format($bulat_jasa)."<br>"; } ?></div></td>
			  
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
				
			  
				if ($bl<10){
				$bln="0$bl";
				}else{
				$bln=$bl;
				}
				
				$adaangsurankah=adaangsurankah_anggota("$th-$bln-$tanggal-$id_pinj");
				$wapok		=wajibpokokaja_anggota("$id_pinj");
				
				$sumpok=$wapok*($tempo_pokok-1);
				
				if ($nu<$tempo AND $adaangsurankah==0){
			  $pok=number_format($wapok);
			  }elseif ($nu>=$tempo AND $adaangsurankah==0){
			  $pok=number_format($alokasi-$sumpok, 0, ',', '.');
			  }else{
				  $pok="0";
			  }
				
			  echo "$pok<br>"; } ?>
			  </div></td>
			  
              <td width="12%" class="style9 left top bottom"><div align="right"><?php for($j=$tempe+1;$j<=$tempo;$j++) {
			  if($j<=$tempo){
			  $js=$jasa;
			  }else{
			  $js="-";
			  }
			  $saldo=$alokasi-($wapok*($j-1));
			  if ($jenis_jasa==1){$bayar_jasa=$js;}else if ($jenis_jasa==2) {$bayar_jasa=$saldo*($pros_jasa/100);} else{$bayar_jasa=$js;}
			  $bulat_jasa=bulatkan($bayar_jasa);
			  
			  echo "".number_format($bulat_jasa)."<br>"; } ?></div></td>
            </tr>
</table>
<?php
$angs=mysql_query("select t.idtp, t.tgl_transaksi, u.ins from transaksi_$_SESSION[lokasi]  t, users u where t.id_user=u.id AND t.idtp!='0' AND t.id_pinj_i='$rcp' GROUP BY t.idtp, t.tgl_transaksi, u.ins"); 
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
              <th width="13%" rowspan="2" class="style9 left top bottom">TANGGAL</th>
              <th colspan="2" class="style9 left top">POKOK</th>
              <th colspan="2" class="style9 left top">JASA</th>
              <th width="13%" rowspan="2" class="style9 left top bottom">SALDO</th>
              <th width="6%" rowspan="2" class="style9 left top bottom">SIGN</th>
              <td width="9%" class="style9 left">&nbsp;</td>
            </tr>
            <tr>
              <td height="15" class="style9">&nbsp;</td>
              <th width="12%" class="style9 left top bottom">Dibayar</th>
              <th width="12%" class="style9 left top bottom">Tunggakan</th>
              <th width="12%" class="style9 left top bottom">Dibayar</th>
              <th width="12%" class="style9 left top bottom">Tunggakan</th>
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
			$saldo			=saldopinjaman("$r[tgl_transaksi]-$id_pinj");
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
				<td class="text-right left">'.number_format($nunggakjasa).'</td>
				<td class="text-right left">'.number_format($saldo).'</td>
				<td class="left">'.$row['ins'].'-'.$r['idtp'].'</td>
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
				<td class="left">&nbsp;</td>
				<td class="left">&nbsp;</td>
				<td class="left">&nbsp;</td>
				<td class="left">&nbsp;</td>
			</tr>';
		}
	echo '
	</table>
	';	
}else{
?>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="">   
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td width="6%" class="style9">&nbsp;</td>
              <td height="29" colspan="12" class="style27">REALISASI PEMBAYARAN ANGSURAN </td>
            </tr>
            <tr>
              <td height="10" class="style9">&nbsp;</td>
              <th width="5%" rowspan="2" class="style9 top left bottom">NO</th>
              <th width="13%" rowspan="2" class="style9 left top bottom">TANGGAL</th>
              <th colspan="2" class="style9 left top">POKOK</th>
              <th colspan="2" class="style9 left top">JASA</th>
              <th width="13%" rowspan="2" class="style9 left top bottom">SALDO</th>
              <th width="6%" rowspan="2" class="style9 left top bottom">SIGN</th>
              <td width="9%" class="style9 left">&nbsp;</td>
            </tr>
            <tr>
              <td height="15" class="style9">&nbsp;</td>
              <th width="12%" class="style9 left top bottom">Dibayar</th>
              <th width="12%" class="style9 left top bottom">Tunggakan</th>
              <th width="12%" class="style9 left top bottom">Dibayar</th>
              <th width="12%" class="style9 left top bottom">Tunggakan</th>
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
              <td class="left">&nbsp;</td>
              <td class="left">&nbsp;</td>
              <td class="left">&nbsp;</td>
            </tr>
			<?php 
			}
			?>
</table>
<?php 
}
?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0"> 
	<tr>
	<td width="6.1%">&nbsp;</td>
	  <td width="22%" class="style9 top"><span class="style6">
	  Lembar 1 : Untuk Anggota<br>
      Lembar 2 : Arsip UPK</span></td>
	    <th width="33%" height="24" class="style9 top"><p align="center">&nbsp;</p>
	      <p align="center"><?php echo "$row[sebutan_level_1] $row[nama_lembaga_sort]";?></p>
	      <p align="center">&nbsp;</p>
	      <p align="center">&nbsp;</p>
      <p><?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?></p>      </th>
		<th width="30.4%" colspan="2" class="style9 top"><p align="center">&nbsp;</p>
		  <p align="center">Anggota </p>
		  <p align="center">&nbsp;</p>
          <p align="center">&nbsp;</p>
      <p><?php echo strtoupper($row['namadepan']); ?></p></th>
      <td width="">&nbsp;</td>
  </tr>
	<tr>
	  <td height="15" colspan="5" class="style6">
	  
		<ol><b>Perhatian:</b>
		<li>Bayarlah angsuran tepat waktu sesuai dengan jadwal diatas</li>
		<li>Untuk memudahkan pelayanan, bawalah kartu ini dan slip pembayaran terakhir setiap melakukan angsuran</li>
		<li>Jagalah keutuhan kartu dan tidak melipatnya, jika hilang segera lapor UPK</li>
		<li>Jika lembar ini tidak mencukupi, cetak pada lembar baliknya dengan dibubuhi stempel UPK</li>
		<li>Cek Status Pinjaman anda secara online di <b><?php echo strtolower($row['web_kec']); ?></b></b></li>
		<li>Username: <b><?php echo $row['uname']; ?></b> Password: <b><?php echo $row['pass']; ?></b></li>
		</ol>
	  </td>
  </tr>
</table>
<?php } ?>        
</body>