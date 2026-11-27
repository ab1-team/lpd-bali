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
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
-->
</style>
<body onLoad="window.print()">

     	   <?php
		$rcp=$_GET['rcp'];
		
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=k.desa AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
							jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND 
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
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
											$jangka				=$row['jangka'];
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											$anggota=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$id_pinj' and alokasi>1 ");
		                                    $jum_anggota=mysql_num_rows($anggota);
											
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$sebutan_kec		=$row['sebutan_kec'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$sebutan_desa		=mysql_fetch_array(mysql_query("SELECT * FROM desa d, sebutan_desa sd WHERE kd_desa=$row[kd_desa] AND sd.id=d.sebutan"));
											$nama_desa			=$row['nama_desa'];
											$kades  			=$row['kades'];
											$kd_kelompok		=$row['kd_kelompok'];
											$nama_kelompok		=$row['nama_kelompok'];
											$alamat         	=$row['alamat_kelompok'];
											$telpon				=$row['telpon'];
											$tgl_berdiri		=$row['tgl_berdiri'];
											$nama_jpp			=$row['nama_jpp'];
											$jenis_usaha		=$row['nama_ju'];
											$jenis_kegiatan		=$row['nama_jk'];
											$tingkat_kelompok	=$row['nama_tk'];
											$fungsi_kelompok	=$row['nama_fgs'];
											$ketua				=$row['ketua'];
											$sekretaris			=$row['sekretaris'];
											$bendahara			=$row['bendahara'];
											$lo					=$row['lo'];
											$uname				=$row['uname'];
											$pass				=$row['pass'];
											$id_user			=$row['namadepan']. " " .$row['namabelakang'];
											$tgl_now			=date('Y-m-d');
											
                      $no = 1;
			
	
			?>	
			<?php //MENCARI TANGGAL CAIR ITU HARI APA
				$query = "SELECT datediff('$tgl_pakai', CURDATE()) as selisih";
				$hasil = mysql_query($query);
				$data  = mysql_fetch_array($hasil);

				$selisih = $data['selisih'];
				 
				$x  = mktime(0, 0, 0, date("m"), date("d")+$selisih, date("Y"));
				$namahari = date("l", $x);
				 
				if ($namahari == "Sunday") $namahari = "Minggu";
				else if ($namahari == "Monday") $namahari = "Senin";
				else if ($namahari == "Tuesday") $namahari = "Selasa";
				else if ($namahari == "Wednesday") $namahari = "Rabu";
				else if ($namahari == "Thursday") $namahari = "Kamis";
				else if ($namahari == "Friday") $namahari = "Jumat";
				else if ($namahari == "Saturday") $namahari = "Sabtu";
				
				// dipilih tanggal 1 Maret 2010 sebagai acuan  
				// hari pasaran tanggal 1 Maret 2010 adalah 'Pon'  
				$tgl1 = "2010-03-01";  
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
		
			echo "<div class='style9'>".strtoupper("<b>PEMERINTAH DAERAH KABUPATEN $row[nama_kab] <br> $row[nama_lembaga_long]<br>$sebutan_kec $row[nama_kec] </b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>	
			</td>
			<td height="20" class="bottom"><div align="right" class="style9">Dokumen Pencairan-ProfKel<?php echo $dok;?><br>
			Loan ID. <?php echo $id_pinj;?>
			 <?php echo $lembar;?> </div></td>
		  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6"><b>PROFIL KELOMPOK</b></td>
      </tr>
      <tr>
    <td height="10" colspan="4" ><p align="left" class="style9"><b>1. Identitas Kelompok </b> </td>

      </tr>
      <tr>
        <td width="37%" height="15" class="style9">Kode Kelompok </td>
        <td width="33%" height="15"><span class="style9">: </span><span class="style10"><?php echo $kd_kelompok;?>-<?php echo $id_pinj;?></span></td>
        
      </tr>
      <tr>
        <td height="15" class="style9">Kelompok </td>
        <td height="15" ><span class="style9">:</span><span class="style10"> <?php echo $nama_kelompok;?></span></td>
      </tr>
      <tr>
        <td height="15" class="style9">Telp</td>
        <td height="15" class="style9"><span class="style9">: </span><span class="style10"> <?php echo $telpon;?></span></td>
      </tr>
      <tr>
        <td height="15" class="style9">Alamat</td>
        <td height="15"><span class="style9">:</span><span class="style10"> <span class="style9"> <?php echo $alamat;?> <?php echo $nama_desa; ?></span></span></td>
        
      </tr>
      <tr>
        <td height="15" class="style9">Jenis Usaha</td>
        <td height="15"><span class="style9">:</span><span class="style10"> <span class="style9"> <?php echo $jenis_usaha; ?></span></span></td>
        
      </tr>
	  <tr>
        <td colspan="4" height="5" class="style6 "></td>
      </tr>
      <td height="15" colspan="4" ><p align="left" class="style9"><b>2. Pengurus Kelompok </b></td>
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
    
		<tr>	  
          <th width="32" height="20" class="style9  top left">NO</th>
			<th width="194" class="style9 left  top">JABATAN</th>
              <th width="194" class="style9 left  top right">NAMA PENGURUS</th>
              <th width="194" class="style9 top right">ALAMAT</th>
        </tr>
		<tr>
              <td height="20" class="style9 left  top"><div align="center"><?php echo $no++; ?></div></td>
              <td class="style9 left  top">Ketua Kelompok</td>
              <td class="style9 left  top right"><?php echo "$ketua";?></td>
              <td class="style9   top right"><?php echo "$alamat";?></td>
		</tr>
		
		<tr>
              <td height="20" class="style9 left  top"><div align="center"><?php echo $no++; ?></div></td>
              <td class="style9 left  top">Sekretaris Kelompok</td>
              <td class="style9 left  top right"><?php echo $sekretaris;?></td>
              <td class="style9   top right"><?php echo "$alamat";?></td>
		</tr>
		
		<tr>
              <td height="20" class="style9 left bottom top"><div align="center"><?php echo $no++; ?></div></td>
              <td class="style9 left bottom top">Bendahara Kelompok</td>
              <td class="style9 left bottom top right"><?php echo $bendahara;?></td>
              <td class="style9  bottom top right"><?php echo "$alamat";?></td>
		</tr>
		
</table>
<table width="97%" border="0" align="center" cellspacing="0">
    <tr>
    <td height="15" colspan="4" ><p align="left" class="style9"><br><b>3. Realisasi Pinjaman </b> </td>

      </tr>
      <tr>
        <td width="20%" height="18" class="style9">Alokasi Pinjaman</td>
        <td width="33%" height="18"><span class="style9">: <b>Rp. </span><span class="style10"><?php echo number_format($alokasi);?>,-</b></span></td>
        
      </tr>
      <tr>
        <td height="18" class="style9">Tanggal Cair </td>
        <td height="18" ><span class="style9">:</span><span class="style10"> <?php echo tgl_indo($tgl_cair); ?></span></td>
      </tr>
      <tr><td height="18" class="style9">Jumlah Anggota</td>
        <td height="18" class="style9">: <span class="style10"> <?php echo $jum_anggota;?> Orang</span></td>
      </tr>
      <tr>
        <td height="18" class="style9">Jangka</td>
        <td height="18"><span class="style9">:</span><span class="style10"> <span class="style9"> <?php echo $jangka;?> bulan </span></span></td>
      </tr>
      <tr>
        <td height="18" class="style9">Pros Jasa</td>
        <td height="18"><span class="style9">:</span><span class="style10"> <span class="style9"> <?php echo $pros_jasa;?> %</span></span></td>
      </tr>
	  <tr>
        <td colspan="4" height="5" class="style6 "></td>
      </tr>
    <tr>
        <td height="15" colspan="4" ><p align="left" class="style9"><br><b>4. Waktu Pencairan </b> </td> </td>
    </tr>
    <tr>
        <td  width="20%"  height="18" class="style9">Hari, Tanggal </td>
        <td height="18" ><span class="style9"></span><span class="style10">: <?php echo $namahari;?>, <?php echo tgl_indo($tgl_cair);?></span></td>
    </tr>
     <tr>
        <td height="18" class="style9">Waktu </td>
        <td height="18" ><span class="style9"></span><span class="style10">: <?php echo substr($row['wt_cair'],0,5); ?></span></td>
    </tr>
     <tr>
        <td height="18" class="style9">Tempat</td>
        <td height="18" ><span class="style9"></span><span class="style10">: <?php echo substr($row['wt_cair'],6); ?></span></td>
    </tr>
        
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      
      <tr>
        <td width="49%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>&nbsp;</p>
        </div></td>
        <td class="style26"><div align="center" class="style9">
		 <p>&nbsp;</p>
          <p><?php echo "$nama_kec , ".tgl_indo($tgl_cair);?></p>
		  <p>Ketua Kelompok </p>
		  
        </div></td>
      </tr>	
	<tr>
	    <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p>&nbsp;</p></th>
        <th class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo $ketua;?></p></th>
  </tr>
      
</table>

<title>Profil Kelompok <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>
