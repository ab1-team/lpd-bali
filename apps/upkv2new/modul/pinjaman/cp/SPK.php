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
											$jad				=$row['jadwal_angsuran_desa'];
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$pros_jasa			=$row['pros_jasa'];
											$jangka				=$row['jangka'];
											$sistem				=$row['sistem'];
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											$wajibjasaaja		=wajibjasaaja($id_pinj);
											$wajibjasa			=bulatkan($wajibjasaaja);
											
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$ttd_pdua			=$row['ttd_pdua'];
											$ttd_saksi			=$row['ttd_saksi'];
											$ttd_mengetahui		=$row['ttd_mengetahui'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuadbm			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND jabatan='7' "));
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
				                            $ttd_mengetahui		= $row['ttd_mengetahui'];
                                            $ttd_pdua			= $row['ttd_pdua'];
                                            $ttd_psatu			= $row['ttd_psatu'];
			?>
	
    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
			<td height="20" colspan="2" class="bottom">
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
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
			Loan ID. <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?>
			 Lembar-1 </div></td>
	  </tr> 
</table>

<p class="style16">
	<br>SURAT PERJANJIAN KREDIT (SPK)<br>
	<span class="style28">Nomor : <?php echo $spk_no;?><br>Tanggal : <?php echo tgl_indo($tgl_cair);?></span><br><br>
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
        <td height="19" colspan="24" class="style9"><p align="justify">
		Dengan memohon rahmat Tuhan Yang Maha Kuasa serta  kesadaran akan cita-cita luhur pemberdayaan masyarakat desa  untuk mencapai kemajuan ekonomi dan kemakmuran bersama, saya yang bertanda  tangan dibawah ini,</p>        </td>
      </tr>
      
      <?php if($ttd_psatu=="1"){ ?>
      <tr>
        <td width="197" height="25" class="style9"><p>Nama <br>N I K <br>
          Jabatan <br>Alamat </p>        </td>
        <td height="25" colspan="23" class="style27">: <?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?> <br> : <?php echo "$ketuaupk[nik]"; ?> <br>
          : <?php echo "$row[sebutan_level_1] $row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?> <br>: <?php echo $row['alamat_kec']; ?></td>
      </tr>
      <?php }else if($ttd_psatu=="2"){ ?>
      <tr>
        <td width="197" height="25" class="style9"><p>Nama <br>N I K <br>
          Jabatan <br>Alamat </p>        </td>
        <td height="25" colspan="23" class="style27">: <?php echo strtoupper("$ketuadbm[namadepan] $ketuadbm[namabelakang]"); ?> <br> : <?php echo "$ketuadbm[nik]"; ?> <br>
          : <?php echo "$row[sebutan_level_7] Kecamatan $row[nama_kec]";?> <br>: <?php echo $row['alamat_kec']; ?></td>
      </tr>
      <?php } ?>
      
      <tr>
        <td height="25" colspan="24" class="style9"><div align="justify">
		Dalam hal ini bertindak untuk dan atas nama <?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?> selaku pengelola  pelayanan kredit untuk <?php echo "$row[deskripsi_jpp] ($row[nama_jpp])";?> Pemberdayaan Masyarakat di Kecamatan <?php echo $nama_kec;?>, Selanjutnya disebut&nbsp; <strong>Pihak Pertama</strong>, dan</div></td>
      </tr>
      <tr>
        <td height="25" class="style9">Nama <br>
			Jabatan <br></td>
        <td height="25" colspan="23" class="style27">: <?php echo strtoupper($ketua); ?> <br>: Ketua Kelompok <?php echo $nama_kelompok;?>
        <?php echo "$row[sebutan_desa] $nama_desa"; ?>        <br></td>
      </tr>
	  
	  <?php if($ttd_pdua=="2") { ?> 
      <tr>
        <td height="25" class="style9">Nama <br>
          Jabatan <br></td>
        <td height="25" colspan="23" class="style27">: <?php echo strtoupper($sekretaris); ?> <br>
          : Sekretaris Kelompok <?php echo $nama_kelompok;?>
           <?php echo "$row[sebutan_desa] $nama_desa"; ?>          <br></td>
      </tr>
	  
	  <?php }else if($ttd_pdua=="3") { ?> 
      <tr>
        <td height="25" class="style9">Nama <br>
          Jabatan <br></td>
        <td height="25" colspan="23" class="style27">: <?php echo strtoupper($sekretaris); ?> <br>
          : Sekretaris Kelompok <?php echo $nama_kelompok;?>
           <?php echo "$row[sebutan_desa] $nama_desa"; ?>          <br></td>
      </tr>
	  
	  <tr>
        <td height="25" class="style9">Nama <br>
          Jabatan <br></td>
        <td height="25" colspan="23" class="style27">: <?php echo strtoupper($bendahara); ?> <br>
          : Bendahara Kelompok <?php echo $nama_kelompok;?>
           <?php echo "$row[sebutan_desa] $nama_desa"; ?>          <br></td>
      </tr>
	  
	  
      <?php } ?>
      
      <tr>
        <td height="37" colspan="24" class="style9"><div align="justify">
		Dalam hubungan ini bertindak untuk dan atas nama kelompok <strong>
	      <?php echo "$nama_jpp $nama_kelompok";?> yang berkedudukan di <?php echo $alamat_kelompok;?> <?php echo $nama_desa;?>
	      <span class="style27"><?php echo "$row[sebutan_desa] $nama_desa"; ?></span> Kecamatan <?php echo $nama_kec; ?></strong>,<strong> </strong>dan beserta anggota yang kepadanya memberikan kuasa secara tertulis  sebagaimana Surat Kuasa terlampir yang menjadi bagian tidak terpisahkan dari  dokumen perjanjian kredit ini, selanjutnya disebut&nbsp; <strong>Pihak Kedua</strong>.
	      <p>Pihak Pertama dan Pihak Kedua dalam kedudukan  masing-masing seperti telah diterangkan diatas,
		    <?php //MENCARI TANGGAL CAIR ITU HARI APA
				$query = "SELECT datediff('$tgl_cair', CURDATE()) as selisih";
				$hasil = mysql_query($query);
				$data  = mysql_fetch_array($hasil);

				$selisih = $data['selisih']-1;
				 
				$day = date('D', strtotime($row['tgl_cair']));
				$x  = mktime(0, 0, 0, date("m"), date("d")+$selisih, date("Y"));
				$namahari = date("l", $x);
				 
				if ($day == "Sun") $namahari = "Minggu";
				else if ($day == "Mon") $namahari = "Senin";
				else if ($day == "Tue") $namahari = "Selasa";
				else if ($day == "Wed") $namahari = "Rabu";
				else if ($day == "Thu") $namahari = "Kamis";
				else if ($day == "Fri") $namahari = "Jumat";
				else if ($day == "Sat") $namahari = "Sabtu";
				
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
		    Pada hari ini <b>
		    <?php if ($kd_prov == '5') {
					echo"$namahari";
					} elseif ($kd_prov == '4') {
						echo"$namahari";
					} elseif ($kd_prov == '6') {
						echo"$namahari";
					} else {
					echo "$namahari";
					}
					?>
		    </b>tanggal <b><?php echo ucwords(toTerbilang($tanggal));?></b> bulan <b><?php echo $bulan;?></b> tahun <b><?php echo ucwords(toTerbilang($tahun));?></b>, bertempat di  <strong><?php echo substr($row['wt_cair'],6); ?></strong> dengan sadar dan<strong> </strong>sukarela menyatakan telah membuat  perjanjian utang piutang dengan ketentuan-ketentuan yang disepakati bersama  sebagai berikut :</p>
        </div></td>
      </tr>
      <tr>
        <th colspan="24" class="style9">&nbsp;</th>
      </tr>
      <tr>
        <th colspan="24" class="style9">Pasal 1</th>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style6"><div align="justify">
          <ol><li class="style9"> Pihak Pertama setuju memberikan kredit kepada Pihak Kedua sebesar&nbsp;<strong>Rp. <?php echo number_format($alokasi);?>,- (<?php echo ucwords(toTerbilang($alokasi)); ?> Rupiah) </strong> Yaitu jumlah yang telah diputuskan dalam rapat penetapan pencairan kelompok, berdasarkan permohonan dari  Pihak Kedua dan para pemberi kuasa yang dilakukan secara kelompok sesuai Surat  Permohonan kredit tanggal <b><?php echo tgl_indo($tgl_proposal);?></b>.</li>
            <li class="style9">Pihak Kedua dan Pemberi kuasa, mengaku telah menerima uang dalam jumlah  sebagaimana yang diterangkan pada ayat 1 diatas, uang telah  dibayarkan sesuai jumlah kelayakan kreditnya masing-masing dan dibuktikan  secara sah dengan daftar tanda terima uang terlampir, yang berlaku sebagai  Surat Pengakuan Utang, baik perorangan maupun kelompok secara tanggung-rentang.</li>
          </ol>
        </div></td>
      </tr>
      <tr>
        <th height="25" colspan="24" class="style6"><span class="style9">Pasal 2 </span></th>
      </tr>
      
      <tr>
        <td height="25" colspan="24" class="style6" align="justify"><span class="style9" >Kedua belah Pihak secara sukarela menerima syarat-syarat perjanjian  utang-piutang sebagaimana dinyatakan dalam ketentuan-ketentuan dibawah ini</span>
          <div align="justify">
            <ol class="style9">
              <li>Dana kredit <?php echo $row['nama_jpp'];?> akan dipergunakan untuk kegiatan usaha guna meningkatkan  pendapatan dan mutu kehidupan keluarga. Dengan demikian kredit ini akan  memberikan manfaat sebesar-besarnya bagi pertumbuhan ekonomi serta perkembangan  seluruh anggota keluarga Pihak Kedua dan para Pemberi Kuasa. Dan dana kredit <?php echo $row['nama_jpp'];?> ini akan dipergunakan untuk kegiatan usaha atau bukan usaha  demi memberikan manfaat sebesar-besarnya bagi keluarga pihak kedua dan para  pemberi kuasa.</li>
              <li>Atas kredit tersebut dikenakan jasa (bagi hasil)  <strong><?php echo $pros_jasa; ?> %</strong> flat per-bulan dari pokok  pinjaman yang dicairkan.</li>
              <li>Pihak Kedua dan para pemberi kuasa mengerti dan menyadari bahwa jasa (bagi hasil)  pinjaman yang dibayar akan dipergunakan untuk biaya pelayanan dan pengelolaan  yang sehat serta pemupukan modal dana pinjaman bergulir milik bersama agar  dapat berkembang dan lestari sebagai sumber kredit yang bermanfaat bagi warga  masyarakat desa.</li>
              <li>Kredit akan dibayar kembali dalam jangka waktu<strong> <?php echo $jangka;?> <span class="style27">(<?php echo ucwords(toTerbilang($jangka)); ?>)</span> </strong>bulan,  dengan cara angsuran <strong><?php echo "$row[nama_sistem]</strong> ($row[deskripsi_sistem])";?>, yaitu pokok kredit sebesar <strong>Rp. <?php echo number_format(wajibpokokaja($id_pinj));?>,- <span class="style27">(<?php echo ucwords(toTerbilang(wajibpokokaja($id_pinj))); ?> Rupiah)</span> </strong> ditambah jasa sebesar <strong>Rp. <?php echo number_format($wajibjasa);?>,- <span class="style27">(<?php echo ucwords(toTerbilang($wajibjasa)); ?> Rupiah)</span></strong> 
				 <?php if($sistem==1) { ?>
				 setiap tanggal <span class="style27"><?php if($jad=="" OR $jad==NULL){$tglsebut=$tanggal;}else{$tglsebut=$jad;} echo $tglsebut; ?> (<?php echo ucwords(toTerbilang($tglsebut)); ?>)</span>  sampai target pelunasan,
				 <?php } ?>
				 sebagaimana jadwal angsuran  terlampir. <strong></strong></li>
				 <?php echo $row['redaksi_spk'];?>
			</ol>
		  </div>
		</td>
      </tr>
      
      <tr>
        <th height="25" colspan="24" class="style9">Pasal 3 </th>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style6"><div align="justify">
          <ol class="style9">
            <li>Pihak pertama berkewajiban mendampingi pihak kedua dan para pemberi  kuasa, agar dapat menggunakan dana kreditnya untuk mengembangkan usaha, meningkatkan mutu kehidupan keluarga dan memperbaiki pengaturan keuangan  rumah tangga. Dengan demikian, kredit dapat dibayar kembali secara lancar  sambil tetap memberikan manfaat yang setinggi-tingginya bagi kemajuan ekonomi  dan perkembangan seluruh anggota keluarga.</li>
            <li>Pihak kedua dan pemberi kuasa sadar dan mengerti  bahwa mengembalikan kredit secara lancar sesuai jadwal yang disepakati,  merupakan kewajiban hukum sekaligus menunjukkan budi pekerti luhur untuk  mengembangkan semangat tolong menolong dengan saudaranya sesama warga desa  lain. Pengembalian kredit secara lancar akan memperluas kesempatan untuk  memeproleh kredit berikutnya serta membuka peluang bagi orang lain mendapatkan  giliran pelayanan.</li>
            <li>Apabila terjadi saling selisih berkenaan dengan hak serta kewajiban yang  timbul atas perjanjian utang-piutang ini, akan diselesaikan secara musyawarah  untuk mencapai kata sepakat. Apabila tidak dapat dicapai kata sepakat, kedua  belah pihak setuju untuk menunjuk Pengadilan Negeri <?php echo $row['nama_kab'];?> sebagai upaya  hukum menyelesaikan persengketaan tersebut.</li>
            <li>Pihak kedua menyatakan secara sadar dan sukarela telah menanda tangani  akad atau perjanjian kredit ini, setelah terlebih dahulu membacakan isi perjanjian  ini kepada para pemberi kuasa dengan sejelas-jelasnya dan tidak seorangpun  diantaranya menyatakan keberatan.</li>
          </ol>
        </div></td>
      </tr>
      <tr>
          <td></td>
          <td></td>
          <td class="style26"><div align="right" class="style9"><br><?php echo $nama_kec;?>, <?php echo tgl_indo($tgl_cair);?></td>
      </tr>
</table>

<?php include "./tanda_tangan_dokumen.php";?>

<title>1. SPK <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>