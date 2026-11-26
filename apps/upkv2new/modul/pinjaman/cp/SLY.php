<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

$lokasi=$_SESSION['lokasi'];
$rcp=$_GET['rcp'];
		$rcp=$_GET['rcp'];
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=k.desa AND d.sebutan=sd.id AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
							jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND 
							sa.id=pk.sistem_angsuran AND pk.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
											$kd_prov 			=$row['kd_prov'];
											$id_pinj			=$row['id'];
											$id_kel				=$row['id_kel'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$sebutan_kades		=$row['sebutan_kades'];
											$sebutan_desa		=$row['sebutan_desa'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											$angg=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$id_pinj'");  /* query hitung jumlah anggota */
											$jml_anggota=mysql_num_rows($angg);
		
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$pros_jasa			=$row['pros_jasa'];
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
											$nama_kec	=$row ['nama_kec'];
											$alamat_kec	=$row ['alamat_kec'];
											$telpon_kec	=$row ['telpon_kec'];
											$email_kec	=$row ['email_kec'];
											$web_kec	=$row ['web_kec'];
											$visi		=$row ['visi_misi'];
											$nama_kab	=$row ['nama_kab'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
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
				
			//MENCARI TANGGAL CAIR ITU HARI APA
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

<style type="text/css">
<!--
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 24px; font-weight: bold; }
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
-->
</style>
<body onLoad="window.print()">
		<?php if ($_SESSION['lokasi']=='68') { ?>
	<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">

      <tr align="center">
        <td colspan="3" width="10%" class="style6 bottom">
										<img class='' alt='...' src='../../../images/DAPM.png' style='float:left; width:100; margin:10px 10px 10px 10px;'>
											
											<?php
											echo"
												</td>
												<td width='80%' class='style6 bottom'>

											";
											
											$nomor_bh	=$row ['nomor_bh'];
											if (empty($nomor_bh)) {$bh="";}else{$bh="BADAN HUKUM NOMOR: $nomor_bh<br>";}
													?>
													<br>
													<span class="style33"><?php echo strtoupper($row['nama_lembaga_long']);?></span><br>
													<span class="style3">(<?php echo strtoupper($row['nama_lembaga_sort']);?>)</span><br>
													 <span class="style333"><?php echo strtoupper("KECAMATAN $nama_kec");?><br></span>
													<span class="style9"><?php echo "$bh $alamat_kec $nama_kec $nama_kab Telp. $telpon_kec";?><br>
													<?php echo "E-mail: $email_kec Website: $web_kec";?></span>
												</td>
												<td class="style6 bottom">
											<?php
											 $logo=$row['logo'];
											if (empty($logo)) {
											echo "<img class='' alt='...' src='../../../images/upk.png' style=' width:100; margin:10px 10px 10px 10px;'>";
											}else{
											echo "<img class='' alt='...' src='../../../images/logo/$logo' style=' width:100; margin:10px 10px 10px 10px;'>";
											} ?>

									</td>
			     				 </tr>	
								</table>
		<?php }else { ?>	

				<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
					<tr align="center">
				        <td colspan="3" class="style6 bottom">
						<?php
															 $logo=$row['logo'];
															if (empty($logo)) {
															echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:75; margin:10px 0 10px 20px;'>";
															}else{
															echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:75; margin:10px 0 10px 20px;'>";
															}
															
															$nomor_bh	=$row ['nomor_bh'];
							if (empty($nomor_bh)) {$bh="";}else{$bh="BADAN HUKUM NOMOR: $nomor_bh<br>";}
						?>
						<br>
						<span class="style3"><?php echo strtoupper($row['nama_lembaga_long']);?></span><br>
						 <?php echo strtoupper("KECAMATAN $nama_kec KABUPATEN $nama_kab");?><br>
						<span class="style9"><?php echo "$bh $alamat_kec $nama_kec $nama_kab Telp. $telpon_kec";?><br>
						<?php echo "E-mail: $email_kec Website: $web_kec";?></span></td>
				      </tr>	
				  </table>
		<?php  } ?>
    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">


 

		  <tr>
			<td height="20" class="style9 top">Nomor </td>
			<td height="20" class="top"><span class="style9">:</span><span class="style27"> <?php echo "______/".$row['nama_lembaga_sort'].tgl_rom($tgl_cair)."";?></span></td>
			<td width="578" colspan="2" rowspan="3" class="style9 top">&nbsp;</td>
		  </tr>
		  <tr>
			<td height="20" class="style9">Tanggal</td>
			<td height="20"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo(date('Y-m-d'));?></span></td>
		  </tr>
		  <tr>
			<td height="20" class="style9">Sifat</td>
			<td height="20"><span class="style9">:</span><span class="style27"> Penting dan Rahasia</span></td>
		  </tr>
		  <tr>
		    <td height="20" class="style9">Perihal</td>
		    <td height="20"><span class="style9">:</span><span class="style27"> Kelayakan Pinjaman </span></td>
      </tr>
		  <tr>
			<td width="120" height="20" class="style9">&nbsp;</td>
			<td width="343" height="20"><span class="style27">&nbsp;&nbsp;<?php echo $jenis;?> <?php echo tgl_indo($tgl);?></span></td>
		    <td colspan="2" class="style9">KEPADA YTH. </td>
		  </tr>
		  <tr>
			<td colspan="2" rowspan="2" class="style9">&nbsp;</td>
		    <td colspan="2" class="style27"> <?php if($_SESSION['kd_kab']=="18") {  echo "Ketua Kelompok $nama_kelompok<br>$alamat_kelompok"; }else{ echo "$sebutan_kades $nama_desa<br>Kecamatan $nama_kec"; } ?></td>
		  </tr> 
		  <tr>
			<td colspan="2" class="style27">Di
            <p class="align-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper("$nama_desa $nama_kec");?></td>
		  </tr>
		  <tr>
		    <td colspan="5" class="style9 align-justify"><p>&nbsp;</p>
	        <p>&nbsp;</p></td>
      </tr>
	<tr>
		  <td class="style9 align-justify">&nbsp;</td>
      <td colspan="4" class="style9 align-justify">
	  <p>Dengan hormat,</p>
        <p>
			Mendasar proposal pengajuan pinjaman kelompok dengan mempertimbangkan <u>hasil verifikasi oleh Tim Verifikasi dan keputusan rapat Tim Pendanaan</u>  <b><?php echo "$nama_lembaga_sort Kecamatan $nama_kec";?></b>, bersama ini kami
			beritahukan bahwa :
		</p>
		</td>
  </tr>
  </table>
  <table width="100%">
  <tr class="style9 align-justify">
	<td width="135">&nbsp;</td>
	<td width="20%">Nama Kelompok</td><td>:<b> <?php echo "$nama_kelompok $sebutan_desa $nama_desa";?>  </b></td>
  </tr>
  <tr class="style9 align-justify">
	<td width="135">&nbsp;</td>
	<td width="20%">Tanggal Proposal </td><td>: <b><?php echo tgl_indo($tgl_proposal);?></b></td>
  </tr>
  <tr class="style9 align-justify">
	<td width="135">&nbsp;</td>
	<td width="20%">Alokasi Pengajuan</td><td>: <b>Rp. <?php echo number_format($row['proposal']);?>,-</b></td>
  </tr>
  
  <tr>
	<td class="style9 align-justify">&nbsp;</td>
    <td colspan="4" class="style9 align-justify">
        <p>Berdasarkan hasil keputusan <?php echo "$row[nama_lembaga_long] $row[nama_kec]";?> pengajuan kelompok tersebut dinyatakan <b>LAYAK / TIDAK LAYAK *)  </b> untuk diberikan Pinjaman sebagaimana telah disebutkan di atas.
		</p>
		<p>Adapun alasannya sebagai berikut :</p>
		<p><?php echo "$row[catatan_verifikasi] ";?></p>
		<p>Demikian surat ini dibuat dengan mempertimbangkan dari berbagai hal sehingga dapat dipergunakan sebagaimana mestinya.</p>
	</td>
  </tr>
  </table>
  
   <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  
  <tr>
	<?php
	$upk=mysql_fetch_array(mysql_query("SELECT * FROM users where lokasi='$lokasi' AND level='1' AND jabatan='1' "));   
	?>
      <td width="462" class="style9 align-justify"></td>
	  <td width="440" class="style9 align-justify"><div align="center">
        <p><br><?php echo "$row[sebutan_level_1] $row[nama_lembaga_sort]";?>,<br>
          <?php echo "Kecamatan $row[nama_kec]";?></p>
        <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><span class="style27"><?php echo strtoupper("$upk[namadepan] $upk[namabelakang]");?></span></p>
      </div></td>
  </tr>
	</table>
	
	<?php if ($_SESSION['kd_kab']=="18") { ?> 	<!--Pejagoan -->

	<br>

	</table>
  <table width="100%" border="0">
  <tr class="style9 align-justify">
	<td width="135">&nbsp;</td>
	<td width="20%">Tembusan :</td><td></td>
  </tr>

  <tr class="style9 align-justify">
	<td width="135">&nbsp;</td>
	<td width="20%">1. Kepala Desa</td><td><b></b></td>
  </tr>
  <tr class="style9 align-justify">
	<td width="135">&nbsp;</td>
	<td colspan="2">2. Arsip</td>
  </tr>
  </table>
<?php  } ?>
</body>
<title>Pengantar Laporan <?php echo $laporan;?></title>
      
</body>
		<?php } ?>