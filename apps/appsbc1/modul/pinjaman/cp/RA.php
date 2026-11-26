<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
-->
</style>
<body onLoad="window.print()">

     	   <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk, jenis_jasa jj,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=k.desa AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
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
											
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];

											$pros_jasa			=$row['pros_jasa'];
											$jenis_jasa			=$row['jenis_jasa'];
											$nama_jj			=$row['nama_jj'];
											$jangka				=$row['jangka'];
											$sistem				=$row['sistem'];
											$tempo				=$jangka/$sistem;
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											
											
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											
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
											
											if($status=="P"){$tglstatus=$tgl_proposal; $ket="Tanggal Proposal"; $dok="Proposal";
											}else if($status=="V"){$tglstatus=$tgl_verifikasi; $ket="Tanggal Verifikasi"; $dok="Verifikasi";
											}else if($status=="W" or $status=="A"){$tglstatus=$tgl_cair; $ket="Tanggal Cair"; $dok="Pencairan";
											}
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tglstatus' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tglstatus' "));
				
			?>			
		

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="3" class="bottom">
				<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:70; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:70; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>PEMERINTAH DAERAH KABUPATEN $row[nama_kab] <br> $row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] </b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
			</td>
			<td height="20" class="bottom"><div align="right" class="style9">Dokumen <?php echo $dok;?><br>
			Loan ID. <?php echo $id_pinj;?>
			 Lamp-8 </div></td>
		  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		RENCANA ANGSURAN<br>
		<span class="fw-semi-bold">PENCAIRAN PINJAMAN  <?php echo $nama_jpp;?></p></td>
      </tr>
      <tr>
        <td width="19%" height="24" class="style9">Nama Kelompok</td>
        <td width="32%" height="24"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($nama_kelompok);?></span></td>
        <td width="19%" height="24" class="style9">Alokasi Pinjaman</td>
        <td width="30%" height="24"><span class="style9">:</span><span class="style27"> Rp. <?php echo number_format($alokasi);?>,-</span></td>
      </tr>
      <tr>
        <td height="24" class="style9">Alamat</td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo $alamat_kelompok;?></span></td>
        <td height="24" class="style9"> Sistem Angsuran </td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo "$sistem_angsuran ($jangka bulan)";?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9"><?php echo $ket;?></td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($tglstatus); ?></span></td>
        <td height="25" class="style9">Sistem Bagi Hasil </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo "$pros_jasa %/bulan, $nama_jj";?> </span></td>
      </tr>  
</table>
<br>
	  <table width="97%" border="0" align="center" cellpadding="5" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="2%" height="34" class="style9 bottom top left right">Ansuran Ke</th>
			<th width="10%" class="style9 bottom top">Tanggal</th>
              <th width="10%" class="style9 left bottom top">Pokok</th>
              <th width="10%" class="style9 left bottom top">Jasa <?php echo $pros_jasa;?>%</th>
              <th width="10%" class="style9 left bottom top">Jumlah</th>
              <th width="10%" class="style9 left bottom top">Total Target Pengembalian</th>
              <th width="10%" class="style9 left bottom top  right">Saldo Pinjaman</th>
        </tr>      
	
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left right"><div align="center" ><?php for($no=1;$no<=$tempo;$no++) {echo "$no<br><br>"; } ?></div></td>
              <td class="style9 top"><div align="center"><?php 
			  //TANGGAL
			  for($noo=1;$noo<=$tempo;$noo++) 
			  {
			  
				$tanggal			 = substr($tglstatus,8,2);
				$bulan  			 = substr($tglstatus,5,2);
				$tahun  			 = substr($tglstatus,0,4);
			  
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
				
			  echo "$tanggal/$bln/$th<br><br>"; } ?></div></td>
              <td class="style9 left top"><div align="right"><?php	
				
				//KOLOM POKOK
				
				$wapok=wajibpokokaja($id_pinj);
				$sumpok=$wapok*($tempo-1);
			  for($nu=1;$nu<=$tempo;$nu++) 
			  {
			  if ($nu<$jangka){
			  $pok=number_format($wapok);
			  }else{
			  $pok=number_format($alokasi-$sumpok);
			  }
			  echo "$pok<br><br>";} ?>
			  </div></td>
			  
              <td class="style9 left top"><div align="right"><?php for($j=1;$j<=$tempo;$j++) {
				 
				//KOLOM JASA
				
				  $tanggal			 = substr($tglstatus,8,2);
					$bulan  			 = substr($tglstatus,5,2);
					$tahun  			 = substr($tglstatus,0,4);
			  
					  $b=$bulan+$sistem*$j;
					  
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
						
					  $tgl_kondisi="$th-$bln-$tanggal";
					  
		
			  
			
			  $jasa=wajibjasa("$tgl_kondisi-$id_pinj");
			  
			  $saldo=$alokasi-($wapok*($j-1));
			  if ($jenis_jasa==1){$bayar_jasa=$jasa;}else if ($jenis_jasa==2) {$bayar_jasa=$saldo*($pros_jasa/100);} else{$bayar_jasa=$jasa;}
			  
			  echo "".number_format($bayar_jasa)."<br><br>"; } ?></div></td>
			  
			  
              <td class="style9 left top"><div align="right"><?php 
				
				//KOLOM JUMLAH
				
			  for($s=1;$s<=$tempo;$s++) 
			  {
				  $tanggal			 = substr($tglstatus,8,2);
					$bulan  			 = substr($tglstatus,5,2);
					$tahun  			 = substr($tglstatus,0,4);
			  
					  $b=$bulan+$sistem*$s;
					  
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
						
					  $tgl_kondisi="$th-$bln-$tanggal";
					  
		
			  
			
			  $jasa=wajibjasa("$tgl_kondisi-$id_pinj");
			  
			  $saldo=$alokasi-($wapok*($s-1));
			  if ($jenis_jasa==1){$bayar_jasa=$jasa;}else if ($jenis_jasa==2) {$bayar_jasa=$saldo*($pros_jasa/100);} else{$bayar_jasa=$jasa;}
					
					$sumjasa=$sumjasa+$bayar_jasa;
			  
				$sumpok=$wapok*($tempo-1);
			  	$pokok2=$alokasi-$sumpok;
				$jum1=$wapok+$bayar_jasa;
				$jum2=$pokok2+$bayar_jasa;
				
			  if ($s<$tempo){
			  $jumlah=number_format($jum1);
			  }else{
			  $jumlah=number_format($jum2);
			  }
			  echo "$jumlah<br><br>";}
			  
			  ?></div></td>
			  
			  <td class="style9 left top"><div align="right"><?php 
				
				//TOTAL TARGET Pengembalian
				
			  for($t=1;$t<=$tempo;$t++) 
			  {
			  
			  
			   $tanggal			 = substr($tglstatus,8,2);
					$bulan  			 = substr($tglstatus,5,2);
					$tahun  			 = substr($tglstatus,0,4);
			  
					  $b=$bulan+$sistem*$t;
					  
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
						
					  $tgl_kondisi="$th-$bln-$tanggal";
					  
		
			  
			
			  $jasa=wajibjasa("$tgl_kondisi-$id_pinj");
			  
			  $saldo=$alokasi-($wapok*($t-1));
			  if ($jenis_jasa==1){$bayar_jasa=$jasa;}else if ($jenis_jasa==2) {$bayar_jasa=$saldo*($pros_jasa/100);} else{$bayar_jasa=$jasa;}
				
				if ($t<$tempo){
							  $tot=$wapok*$t;
							  }else{
							  $tot=$alokasi;
							  }
			  
			  $totjs=$totjs+$bayar_jasa;
			  echo "".number_format($tot+$totjs)."<br><br>";} //Total Target Pengembalian
			  ?></div></td>
			  
			  <td class="style9 left top right"><div align="right"><?php 
			  for($u=1;$u<=$tempo;$u++) 
			  {
			  if ($u<$tempo){
			  $saldo=number_format($alokasi-($wapok*$u));
			  }else{
			  $saldo=0;
			  }
			  echo "$saldo<br><br>";}
			  ?></div></td>
            </tr>
		<!-- Menampilkan Jumlah Total pada tabel -->
		 <tr>	  
          <th width="2%" colspan="2" height="34" class="style9 left bottom top">Total</th>
              <th width="10%" class="style9 left bottom top"><?php echo number_format($alokasi); ?></th>
              <th width="10%" class="style9 left bottom top"><?php echo number_format($sumjasa); ?></th>
              <th width="10%" class="style9 left bottom top"><?php echo number_format($alokasi+($sumjasa)); ?></th>
              <th width="10%" colspan="2" class="style9 left bottom top right">&nbsp;</th>
        </tr> 
</table>
<br>	  
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0"> 
      <tr>
      <td align="center" colspan="3" class="style9">Menyetujui,</td>
      </tr>
      <tr>
        <td width="50%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p><?php echo "$row[sebutan_level_1] <br>$row[nama_lembaga_sort]";?></p>
        </div></td>
        <td width="50%" colspan="2" class="style26"><div align="center" class="style9">
          <p>Ketua Kelompok</p>
        </div></td>
      </tr>	
	<tr>
	    <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?></p></th>
        <th colspan="2" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper($ketua); ?></p></th>
  </tr>
</table>
<title>5. Rencana Ansuran <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>
