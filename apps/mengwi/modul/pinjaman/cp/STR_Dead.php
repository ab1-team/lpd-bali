<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style16 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; text-align:center; }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: none; }
.style11 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.allborder	{border: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.style28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.center {text-align:center; }
.matrai{
	font-size: 10px;
	font-weight: normal;

}
-->
</style>
<body onLoad="window.print()">

     	   <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=k.desa AND sd.id=d.sebutan AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
							jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND 
							sa.id=pk.sistem_angsuran AND pk.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
											$kd_prov 			=$row['kd_prov'];
											$id_pinj			=$row['id'];
											$id_kel				=$row['id_kel'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											
											$spk_no				=$row['spk_no'];
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
											$jangka				=$row['jangka'];
											$sistem				=$row['sistem'];
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											$wajibjasaaja		=wajibjasaaja($id_pinj);
											$wajibjasa			=bulatkan($wajibjasaaja*$sistem);
											
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$sebutan_kec		=$row['sebutan_kec'];
											$ttd_pdua			=$row['ttd_pdua'];
											$ttd_saksi			=$row['ttd_saksi'];
											$ttd_mengetahui		=$row['ttd_mengetahui'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
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
											$bendahara			=$row['bendahara'];
											$lo					=$row['lo'];
											$uname				=$row['uname'];
											$pass				=$row['pass'];
											$id_user			=$row['namadepan']. " " .$row['namabelakang'];
											$tgl_now			=date('Y-m-d');
				
			?>
	
    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
			<td height="20" colspan="2" class="bottom" width="5%">
				<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
						echo "</td>";
						echo"<td class='bottom'>";
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>PEMERINTAH DAERAH KABUPATEN $row[nama_kab] <br> $row[nama_lembaga_long]<br>$sebutan_kec $row[nama_kec] </b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
			Loan ID. <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?>
			 Lembar-1 </div></td>
	  </tr> 
</table>

<p class="style16">
	<br>SURAT PERJANJIAN 
IURAN TANGGUNG RENTENG KEMATIAN<br>
	
</p>

<!--
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <th height="37" colspan="24" class="style6"><br>Surat Perjanjian Kredit (SPK)</th>
      </tr>
      <tr>
        <th height="25" class="style9">&nbsp;</th>
        <th class="style9">1</th>
        <th class="style9">2</th>
        <th class="style9">3</th>
        <th class="style9">&nbsp;</th>
        <th class="style9">4</th>
        <th class="style9">5</th>
        <th class="style9">&nbsp;</th>
        <th class="style9">6</th>
        <th class="style9">7</th>
        <th class="style9">8</th>
        <th class="style9">&nbsp;</th>
        <th class="style9">9</th>
        <th class="style9">10</th>
        <th class="style9">&nbsp;</th>
        <th class="style9">11</th>
        <th class="style9">12</th>
        <th class="style9">&nbsp;</th>
        <th class="style9">13</th>
        <th class="style9">14</th>
        <th class="style9">15</th>
        <th class="style9">16</th>
        <th class="style9">&nbsp;</th>
      </tr>
      <tr class="style9">
        <th width="197" height="25" class="style9">Nomor : </th>
        <th width="26" class="allborder">&nbsp;</th>
        <th width="26" class="top bottom">&nbsp;</th>
        <th width="26" class="allborder">&nbsp;</th>
        <th width="10" class="style9">&nbsp;</th>
        <th width="26" class="allborder">&nbsp;</th>
        <th width="26" class="top bottom right">&nbsp;</th>
        <th width="10" class="style9">&nbsp;</th>
        <th width="26" class="allborder">&nbsp;</th>
        <th width="26" class="top bottom">&nbsp;</th>
        <th width="26" class="allborder">&nbsp;</th>
        <th width="10" class="style9">&nbsp;</th>
        <th width="26" class="allborder"><?php echo substr($tgl_cair,8,1);?></th>
        <th width="26" class="top bottom right"><?php echo substr($tgl_cair,9,1);?></th>
        <th width="10" class="style9">&nbsp;</th>
        <th width="26" class="allborder"><?php echo substr($tgl_cair,5,1);?></th>
        <th width="26" class="top bottom right"><?php echo substr($tgl_cair,6,1);?></th>
        <th width="10" class="style9">&nbsp;</th>
        <th width="26" class="allborder"><?php echo substr($tgl_cair,0,1);?></th>
        <th width="26" class="top bottom"><?php echo substr($tgl_cair,1,1);?></th>
        <th width="26" class="allborder"><?php echo substr($tgl_cair,2,1);?></th>
        <th width="26" class="top bottom right"><?php echo substr($tgl_cair,3,1);?></th>
        <th width="30" class="style9">&nbsp;</th>
      </tr>
      <tr>
        <th height="37" colspan="24" class="style6">&nbsp;</th>
      </tr>
</table>

-->
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
	  <tr>
        <td width="197" height="25" class="style9"><p>Tanggal </td>
        <td height="25" colspan="23" class="style27">: <?php echo tgl_indo($tgl_cair); ?></td>
      </tr>

      <tr>
        <td height="19" colspan="24" class="style9"><p align="justify">Kami yang bertanda tangan dibawah ini:</p>        </td>
      </tr>
      <tr>
        <td width="197" height="25" class="style9"><p>Nama <br>N I K <br>
          Jabatan <br>Alamat </p>        </td>
        <td height="25" colspan="23" class="style27">: <?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?> <br> : <?php echo "$ketuaupk[nik]"; ?> <br>
          : <?php echo "$row[sebutan_level_1] $row[nama_lembaga_sort] $sebutan_kec $row[nama_kec]";?> <br>: <?php echo $row['alamat_kec']; ?></td>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style9"><div align="justify">
		Dalam hal ini bertindak untuk dan atas nama UPK selaku pengelola dana iuran tanggung renteng kematian bagi pemanfaat <?php echo $row['nama_jpp']; ?>, selanjutnya disebut <b>Pihak Pertama</b>, dan</div></td>
      </tr>
      <tr>
        <td height="25" class="style9">Nama <br>
			Jabatan <br>
			Berkedudukan di </td>
        <td height="25" colspan="23" class="style27">: <?php echo strtoupper($ketua); ?> <br>: Ketua Kelompok <?php echo $nama_kelompok;?>
        <?php echo "$row[sebutan_desa] $nama_desa"; ?>        <br> : <?php echo $alamat_kelompok;?> <?php echo $nama_desa;?></td>
      </tr>
	  
	   <?php //MENCARI TANGGAL CAIR ITU HARI APA
				$query = "SELECT datediff('$tgl_cair', CURDATE()) as selisih";
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
				  
				$pecah2 = explode("-", $tgl_cair);  
				$date2 = $pecah2[2];  
				$month2 = $pecah2[1];  
				$year2 =  $pecah2[0];  
				  
				$jd1 = GregorianToJD($month1, $date1, $year1);  
				$jd2 = GregorianToJD($month2, $date2, $year2);  
				  
				$selisih = $jd2 - $jd1;  
				  
				// hitung modulo 5 dari selisih harinya  
				$mod = $selisih % 5;  
				?>
		   
      
      <tr>
        <td height="37" colspan="24" class="style9">
        	<div align="justify">
		Dalam hal ini bertindak untuk dan atas nama diri sendiri dan anggota-anggota kelompok peminjam <b><?php echo $row['nama_jpp']; ?> <?php echo $nama_kelompok;?></b> yang telah memberikan kuasa secara tertulis sebagaimana Surat Kuasa terlampir yang menjadi bagian tidak terpisahkan dari  dokumen perjanjian iuran tanggung renteng kematian ini, selanjutnya disebut <b>Pihak Kedua</b>.
	      
	      <p><b>Pihak Pertama</b> dan <b>Pihak Kedua</b> dalam kedudukan masing-masing seperti telah diterangkan diatas, pada hari ini <b>
		    <?php if ($kd_prov == '5') {
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
		    </b>tanggal <b><?php echo ucwords(toTerbilang($tanggal));?></b> bulan <b><?php echo $bulan;?></b> tahun <b><?php echo ucwords(toTerbilang($tahun));?></b>, bertempat di  <strong><?php echo substr($row['wt_cair'],6); ?></strong> sadar dan suka rela menyatakan telah membuat perjanjian iuran tanggung renteng kematian bagi anggota kelompok pemanfaat <b><?php echo $row['nama_jpp']; ?> </b> yang meninggal dunia dengan ketentuan-ketentuan yang disepakati.</p>

	      <p> <b>Pihak Kedua</b> menyatakan secara sadar dan suka rela telah menanda-tangani akad atau perjanjian iuran tanggung renteng kematian ini, setelah terlebih dahulu membaca isi perjanjian ini kepada para Pemberi kuasa dengan sejelas-jelasnya dan tidak seorangpun diantaranya menyatakan keberatan.</p>
		    
</table>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">

    
    <tr>
        <td width="50%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>&nbsp;</p>
          <p>Pihak PERTAMA, </p>
          <p> <?php echo "$row[nama_lembaga_sort] $sebutan_kec $row[nama_kec]";?></p>
		  <p align="center">&nbsp;</p>
		  <p align="center">&nbsp;</p>
        </div></td>
        <td class="style26"><div align="center" class="style9"><?php echo $nama_kec;?>, <?php echo tgl_indo($tgl_cair);?>
            <p>Pihak KEDUA,  </p>
            <p><?php echo $row['nama_jpp']; ?> <?php echo $nama_kelompok;?></p>
			<p align="center">&nbsp;</p>
			<p align="center">&nbsp;</p>
        </div></td>
    </tr>	
	<tr>
	    <th height="24" colspan="1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?> <br>(<?php echo "$row[sebutan_level_1] $row[nama_lembaga_sort])";?></p></th>
        <th class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper($ketua); ?><br>
        (Ketua Kelompok) </p></th>
  </tr>

	  
      <tr>
        <td height="300" colspan="1" class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" colspan="1" class="style9"><div align="left"><?php echo "$row[nama_lembaga_sort] $sebutan_kec $row[nama_kec]";?></div></td>
        <td colspan="2" class="style9"><div align="right">Loan ID. <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?></div></td>
      </tr>
</table>


<title>1. SPK <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>