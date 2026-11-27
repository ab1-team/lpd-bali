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
.style57{font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; font-color:#222}
.align-right {text-align:right; }
.all	{border: 1px solid #000000; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
-->
</style>
<body onLoad="window.print()">

     	    <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, sebutan_desa sd, desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND sd.id=d.sebutan AND d.id=k.desa AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
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
	                                    	$tgl_dana           =$row['tgl_dana'];
											
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$pros_jasa			=$row['pros_jasa'];
											$jangka				=$row['jangka'];
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											$nama_ket_upk		=$dus['namadepan']. " " .$dus['namabelakang'];
											$nik_ket_upk		=$dus['nik'];
											$lokasi				=$row['lokasi'];
											$nama_kab			=$row['nama_kab'];
											$nama_kec			=$row['nama_kec'];
											$sebutan_kec		=$row['sebutan_kec'];
											$nama_bkad_sort     =$row['nama_bkad_sort'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$nama_desa			=$row['nama_desa'];
											$nip_kades			=$row['nip'];
											$pangkat			=$row['pangkat'];
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
											
											$desa			=$row['desa'];
											
											if($status='P') {$tanggal=$tgl_proposal;}else{$tanggal=$tgl_cair;}



				
			?>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td width="70%" height="20" class="bottom">
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
			?>		</td>
			<td width="30%" height="20" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
			Loan ID. <?php echo $id_pinj;?>
			 Lamp-5 </div></td>
  </tr> 	  
      

      <tr>
        <td height="20" colspan="2" class="bottom"><p align="center" class="style6">BERITA ACARA<br>
		<span class="fw-semi-bold">RAPAT TIM PENDANAAN</p></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="2" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="2" class="style9 align-justify"><p><span class="style9">Dalam rangka pelaksanaan kegiatan dana bergulir maka Pada hari ini <b>
        <?php //MENCARI TANGGAL CAIR ITU HARI APA
				$query = "SELECT datediff('$tgl_dana', CURDATE()) as selisih";
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

				// array urutan nama hari pasaran dimulai dari 'Pon'  
				$pasaran = array('Pon', 'Wage', 'Kliwon', 'Legi', 'Pahing');  
				  
				// proses mencari selisih hari antara kedua tanggal  
				$pecah1 = explode("-", $tgl1);  
				$date1 = $pecah1[2];  
				$month1 = $pecah1[1];  
				$year1 = $pecah1[0];  
				  
				$pecah2 = explode("-", $tgl_dana);  
				$date2 = $pecah2[2];  
				$month2 = $pecah2[1];  
				$year2 =  $pecah2[0];  
				  
				$jd1 = GregorianToJD($month1, $date1, $year1);  
				$jd2 = GregorianToJD($month2, $date2, $year2);  
				  
				$selisih = $jd2 - $jd1;  
				  
				// hitung modulo 5 dari selisih harinya  
				$mod = $selisih % 5;  
			if ($kd_prov == '5') {
					echo"$namahari";
					} elseif ($kd_prov == '4') {
						echo"$namahari";
					} elseif ($kd_prov == '6') {
						echo"$namahari";
					}
					else{
					echo "$namahari $pasaran[$mod]";
					}
					?>
		    </b>tanggal <b><?php echo ucwords(toTerbilang($date2));?></b> bulan <b><?php echo getBulan($month2);?></b> tahun <b><?php echo ucwords(toTerbilang($year2));?></b>,  
		    telah diadakan <b>Rapat Tim Pendanaan</b> yang dihadiri oleh Pengurus <?php echo "$nama_bkad_sort" ;?> serta unsur lain yang terkait dengan Kegiatan Dana Bergulir sebagaimana tercantum dalam lampiran daftar hadir.

Materi atau topik yang dibahas dalam Forum ini serta yang bertindak selaku unsur pimpinan rapat dan narasumber adalah :
<ol class="style9 align-justify">
A. Materi atau Topik :
<li>Pembahasan Rekomendasi Pendanaan </li>
<li>_______________________________________________________________________</li>
<li>_______________________________________________________________________</li></ol>
<ol class="style9 align-justify">
B.Hasil yang disepakati:
</ol>
Setelah dilakukan pembahasan dan diskusi terhadap materi atau topik di atas, selanjutnya seluruh peserta memutuskan dan dapat menyepakati beberapa hal yang berketetapan menjadi Keputusan Akhir Pendanaan adalah sebagai berikut :</p><br></td>
      </tr>
      <!----------<tr>
        <td height="25" class="style9">Anggota Kelompok : </td>
        <td height="25" class="style9"><div align="right"><span class="style9"><?php echo "$nama_kec, ".tgl_indo($tanggal) ?></span></div></td>
      </tr> ------->
</table>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="40" height="34" class="style9 bottom top left">No</th>
			<th width="230" class="style9 left bottom top" >Nama Kelompok </th>
              <th width="240" class="style9 left bottom top">Alamat</th>
              <th width="32" class="style9 left bottom top">Jenis Pinjaman</th>
              <th width="36" class="style9 left bottom top">Anggota</th>
              <th width="164" class="style9 left bottom top">Ketua Kelompok</th>
              <th width="135" class="style9 left bottom top right">Alokasi Penetapan </th>
        </tr>      
		
<?php 	
		$kelover=mysql_query("select * from desa d,jenis_produk_pinjaman jpp, kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE 
		pk.jenis_pp=jpp.id AND d.id=k.desa AND pk.id_kel=k.id AND tgl_dana='$tgl_dana' AND k.lokasi=$_SESSION[lokasi]");  
		$no=0;
		while($row6=mysql_fetch_array($kelover)){
		    $id_pinkelver              =$row6['id'];
		    $angg=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$id_pinkelver'");  /* query hitung jumlah anggota */
	    	$jml_anggota=mysql_num_rows($angg);
		    $nama_kelompok              =$row6['nama_kelompok'];
		    $desa                       =$row6['nama_desa'];
		    $alamat                     =$row6['alamat_kelompok'];
		    $jppkel                     =$row6['nama_jpp'];
		    $ketua_kel                  =$row6['ketua'];
		    $alokasi_kel                =$row6['alokasi'];
		    $jum_alokasi                =$jum_alokasi+$alokasi_kel;
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left"><div align="center" ><?php echo $no=$no+1;?></div></td>
              <td class="style9 left top"><?php echo $nama_kelompok;?></td>
              <td class="style9 left top"><?php echo "$alamat [$desa]"; ?></td>
              <td class="style9 left top"><div align="center"><?php echo $jppkel; ?></div></td>
              <td class="style9 left top"><span class="style9"><div align="center"><?php echo $jml_anggota;?></div></span></td>
              <td class="style9 left top"><?php echo $ketua_kel;?></td>
              <td class="style9 left top right align-right"><?php echo @(number_format($alokasi_kel));?></td>
            </tr>
  <?php } ?>
		<!-- Menampilkan Jumlah Total pada tabel -->
            <tr>
                <th colspan=6 class="style9 left top"><div align="center">Total</div></td>
              <th class="style9 left top right align-right"><?php echo @(number_format($jum_alokasi));?></td>
            </tr>
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">

<tr><td colspan=3 class="style9 top"><br>Demikian Berita Acara ini dibuat untuk menjadikan periksa bagi yang berkepentingan. </td></tr>
      <tr>
        <td height="25" class="style9">&nbsp;</td>
        <td height="25" class="style9"><div align="right"><span class="style9"><?php echo "$nama_kec, ".tgl_indo($tgl_dana) ?></span></div></td>
      </tr>
      <tr>
          
        <td width="50%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>Pemimpin Rapat</p>
        </div></td>

        <td colspan="3" class="style26"><div align="center" class="style9">
          <p>Notulis/Sekretaris</p>
        </div></td>
      </tr>	
	<tr>
	    <th height="24" class="style9">
		<p align="center">&nbsp;</p>
		<p align="center">&nbsp;</p>
		<p align="center">&nbsp;</p>
		<p align="center">_________________</p>
		
        </th>
		<th height="24" class="style9">
		<p align="center">&nbsp;</p>
		<p align="center">&nbsp;</p>
		<p align="center">&nbsp;</p>
		<p align="center">_________________</p>
		
        </th>
  </tr>
</table>
<div style="page-break-after: always;">
</div>
<title>Berita Acara Pendanaan  <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> <?php echo "$row[sebutan_desa] $nama_desa";?></title>
<?php } ?>        
</body>
