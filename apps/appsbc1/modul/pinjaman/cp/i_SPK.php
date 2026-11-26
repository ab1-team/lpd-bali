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
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.allborder	{border: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.style28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.center {text-align:center; }
-->
</style>
<body onLoad="window.print()">

     	   <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us, keluarga k,
													anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND k.id=a.hubungan AND 
																sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
																a.id=pi.nia AND pi.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											$nama_bkad_sort     =$row['nama_bkad_sort'];
											
											$tgl_cair			=$row['tgl_cair'];
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$alokasi			=$row['alokasi'];
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
											
											$nama_lembaga_sort	=$row ['nama_lembaga_sort'];
											$nama_lembaga_long	=$row ['nama_lembaga_long'];
											$nama_bp_sort		=$row ['nama_bp_sort'];

											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$nama_kab			=$row['nama_kab'];
											$nama_desa			=$row['nama_desa'];
											$sebutan_desa		=$row['sebutan_desa'];
											$sebutan_kades		=$row['sebutan_kades'];
											
											$ttd_pdua			=$row['ttd_pdua'];
											$ttd_saksi			=$row['ttd_saksi'];
											$ttd_mengetahui		=$row['ttd_mengetahui'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabp			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='3' AND jabatan='1' AND sejak<='$tgl_cair' "));

											
											
											$spk_no				=$row['spk_no'];
											$nik				=$row['nik'];
											$namadepan			=$row['namadepan'];
											$alamat				=$row['alamat'];
											$telpon				=$row['telpon'];
											$tempat_lahir		=$row['tempat_lahir'];
											$tgl_lahir			=$row['tgl_lahir'];
											$nama_jpp			=$row['nama_jpp'];
											$jenis_usaha		=$row['nama_usaha'];
											$jenis_kelamin		=$row['jk'];
											$nomor_kk			=$row['kk'];
											$penjamin			=$row['penjamin'];
											$hubungan			=$row['hubungan'];
											$lo					=$row['lo'];
											$uname				=$row['uname'];
											$pass				=$row['pass'];
											$tgl_now			=date('Y-m-d');
											
											$wajibjasaaja		=wajibjasaaja_anggota($id_pinj);
											$wajibjasa			=($wajibjasaaja*$sistem);
				
			?>
	
    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
			<td height="20" colspan="2" class="bottom">
				<div class="style9 text-align-left"><?php
                    $logo=$row['logo'];
                      if (empty($logo)) {
                        echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:70; margin-right:5px;'>";
                        }else{
                        echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:70; margin-right:5px;'>";
                        }
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
                
                  echo "<div class='style9'>".strtoupper("<b>PEMERINTAH DAERAH KABUPATEN $row[nama_kab] <br> $row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] </b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
                  ?>      
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
			Loan ID. <?php echo "$row[id_pinkel]-$id_pinj";?>
			 SPK-Anggota </div></td>
	  </tr> 
</table>

<p class="style16">
	<br>SURAT PERJANJIAN KREDIT (SPK)<br>
	PINJAMAN INDIVIDU<br>
	<span class="style28">Nomor : <?php echo $spk_no;?><br>Tanggal : <?php echo tgl_indo($tgl_cair);?></span><br><br>
</p>

	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td height="19" colspan="24" class="style9"><p align="justify">
		Dengan memohon rahmat Tuhan Yang Maha Kuasa serta  kesadaran akan cita-cita luhur <?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?> dalam pemberdayaan masyarakat desa/kelurahan  untuk mencapai kemajuan ekonomi, pendidikan, kesehatan, sosial kemasyaraktan dan 
		kemakmuran bersama, saya yang bertanda  tangan dibawah ini,</p>        </td>
      </tr>
      <tr>
        <td width="197" height="25" class="style9"><p>Nama <br>N I K <br>
          Jabatan <br>Alamat </p>        </td>
        <td height="25" colspan="23" class="style27">: <?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?> <br>
		  : <?php echo "$ketuaupk[nik]";?> <br>
          : <?php echo "$row[sebutan_level_1] $row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?> <br>: <?php echo $row['alamat_kec']; ?></td>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style9"><div align="justify">
		Dalam hal ini bertindak untuk dan atas nama Pengurus <?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?> selaku pengelola  pelayanan 
		kredit untuk Pinjaman Individu pada <?php echo "$row[deskripsi_jpp] ($row[nama_jpp])";?> Pemberdayaan Masyarakat di Kecamatan <?php echo $nama_kec;?>, 
		Selanjutnya disebut&nbsp; <strong>PIHAK PERTAMA</strong>, dan</div></td>
      </tr>
      <tr>
        <td height="25" class="style9">Nama Lengkap<br>
			Jenis Kelamin<br>
			Tempat, Tanggal Lahir <br>
			N I K <br>
			Berkedudukan di </td>
        <td height="25" colspan="23" class="style27">: <?php echo strtoupper($row['namadepan']); ?> 
			<br>: <?php echo $row['jk'];?>
			<br>: <?php echo $row['tempat_lahir'];?>, <?php echo tgl_indo($row['tgl_lahir']);?>
			<br>: <?php echo $row['nik'];?>
			<br> : <?php echo $row['alamat'];?> <?php echo $nama_desa;?></td>
      </tr>
	  <tr>
        <td height="25" class="style9">Nama Lengkap<br>
			N I K / KK<br>
			Hubungan Keluarga<br>
			Berkedudukan di <br>
			
			</td>
        <td height="25" colspan="23" class="style27">: <?php echo strtoupper($row['penjamin']); ?> 
			<br>: <?php echo $row['kk'];?>
			<br>: <?php echo $row['kekeluargaan'];?>
			<br> : <?php echo $row['alamat'];?> <?php echo $nama_desa;?></td>
      </tr>
      
      <tr>
        <td height="37" colspan="24" class="style9"><div align="justify">
		Dalam hubungan ini bertindak untuk dan atas nama diri sendiri yang telah memberikan kuasa secara tertulis sebagaimana surat kuasa terlampir yang menjadi bagian  tidak terpisahkan dari dokumen perjanjian kredit ini, selanjutnya disebut <strong>PIHAK KEDUA</strong>.
	      <p>Pihak Pertama dan Pihak Kedua dalam kedudukan  masing-masing seperti telah diterangkan diatas,
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
		    Pada hari ini <b> <?php echo "$namahari $pasaran[$mod]";?> </b>tanggal <b><?php echo ucwords(toTerbilang($tanggal));?></b> bulan <b><?php echo $bulan;?></b> tahun <b><?php echo ucwords(toTerbilang($tahun));?></b>, bertempat di Kantor  <strong>   <?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?> </strong> dengan sadar dan<strong> </strong>sukarela menyatakan telah membuat  perjanjian hutang piutang dengan ketentuan-ketentuan yang disepakati bersama  sebagai berikut :</p>
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
          <ol><li class="style9"> Pihak Pertama setuju memberikan kredit kepada Pihak Kedua sebesar&nbsp;<strong>Rp. <?php echo number_format($alokasi);?>,- (<?php echo ucwords(toTerbilang($alokasi)); ?> Rupiah) </strong> Yaitu jumlah yang telah diputuskan dalam Rekomendasi rapat Tim Pendanaan mendasar pada surat rekomendasi dari Tim  Verifikasi dan <?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?> sesuai Mandat <?php echo $nama_bkad_sort; ?>, berdasarkan permohonan dari  Pihak Kedua dan para pemberi kuasa yang dilakukan secara kelompok sesuai Surat  Permohonan kredit tanggal <b><?php echo tgl_indo($tgl_proposal);?></b>.</li>
            <li class="style9">Pihak Kedua mengaku telah menerima uang dalam jumlah  sebagaimana yang diterangkan pada ayat 1 diatas, 
			uang telah  dibayarkan sesuai jumlah tersebut dan dibuktikan  secara sah dengan kwitansi tanda terima uang terlampir, 
			yang berlaku sebagai  Surat Pengakuan Hutang.</li>
          </ol>
        </div></td>
      </tr>
      <tr>
        <th height="25" colspan="24" class="style6"><span class="style9">Pasal 2 </span></th>
      </tr>
      
      <tr>
        <td height="25" colspan="24" class="style6" align="justify"><span class="style9" >Kedua belah Pihak secara sukarela menerima syarat-syarat perjanjian  hutang piutang sebagaimana dinyatakan dalam ketentuan-ketentuan dibawah ini</span>
          <div align="justify">
            <ol class="style9">
              <li>Dana kredit <?php echo $row['nama_jpp'];?> akan dipergunakan untuk kegiatan usaha guna meningkatkan  pendapatan dan mutu kehidupan keluarga. Dengan demikian kredit ini akan  memberikan manfaat sebesar-besarnya bagi pertumbuhan ekonomi serta perkembangan  seluruh anggota keluarga Pihak Kedua dan para Pemberi Kuasa. Dan dana kredit <?php echo $row['nama_jpp'];?> ini akan dipergunakan untuk kegiatan usaha atau bukan usaha  demi memberikan manfaat sebesar-besarnya bagi keluarga pihak kedua dan para  pemberi kuasa.</li>
              <li>Atas kredit tersebut dikenakan jasa (bagi hasil)  <strong><?php echo $pros_jasa; ?> %</strong> flat per-bulan dari pokok  pinjaman yang dicairkan.</li>
              <li>Pihak Kedua mengerti dan menyadari bahwa jasa (bagi hasil)  pinjaman yang dibayar akan dipergunakan untuk biaya pelayanan dan pengelolaan  yang sehat serta pemupukan modal dana pinjaman bergulir milik bersama agar  dapat berkembang dan lestari sebagai sumber kredit yang bermanfaat bagi warga  masyarakat desa.</li>
              <li>Kredit akan dibayar kembali dalam jangka waktu<strong> <?php echo $jangka;?> <span class="style27">(<?php echo ucwords(toTerbilang($jangka)); ?>)</span> </strong>bulan,  dengan cara angsuran <strong><?php echo "$row[nama_sistem]</strong> ($row[deskripsi_sistem])";?>, yaitu pokok kredit sebesar <strong>Rp. <?php echo number_format(wajibpokokaja_anggota($id_pinj));?>,- <span class="style27">(<?php echo ucwords(toTerbilang(bulatkan(wajibpokokaja_anggota($id_pinj)))); ?> Rupiah)</span> </strong> ditambah jasa sebesar <strong>Rp. <?php echo number_format($wajibjasa);?>,- <span class="style27">(<?php echo ucwords(toTerbilang($wajibjasa)); ?> Rupiah)</span></strong> 
				 <?php if($sistem==1) { ?>
				 setiap tanggal <span class="style27"><?php echo $tanggal; ?> (<?php echo ucwords(toTerbilang($tanggal)); ?>)</span>  sampai lunas,
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
            <li>Pihak pertama berkewajiban mendampingi pihak kedua agar dapat menggunakan dana kreditnya untuk mengembangkan usaha, meningkatkan mutu kehidupan keluarga dan memperbaiki pengaturan keuangan  rumah tangga. Dengan demikian, kredit dapat dibayar kembali secara lancar  sambil tetap memberikan manfaat yang setinggi-tingginya bagi kemajuan ekonomi  dan perkembangan seluruh anggota keluarga.</li>
            <li>Pihak kedua sadar dan mengerti  bahwa mengembalikan kredit secara lancar sesuai jadwal yang disepakati,  merupakan kewajiban hukum sekaligus menunjukkan budi pekerti luhur untuk  mengembangkan semangat tolong menolong dengan saudaranya sesama warga desa  lain. Pengembalian kredit secara lancar akan memperluas kesempatan untuk  memeproleh kredit berikutnya serta membuka peluang bagi orang lain mendapatkan  giliran pelayanan.</li>
            <li>Apabila terjadi saling selisih berkenaan dengan hak serta kewajiban yang  timbul atas perjanjian utang-piutang ini, akan diselesaikan secara musyawarah  untuk mencapai kata sepakat. Apabila tidak dapat dicapai kata sepakat, kedua  belah pihak setuju untuk menunjuk Pengadilan Negeri <?php echo $row['nama_kab'];?> sebagai upaya  hukum menyelesaikan persengketaan tersebut.</li>
            <li>Pihak kedua menyatakan secara sadar dan sukarela telah menanda tangani  akad atau perjanjian kredit ini, setelah terlebih dahulu membacakan isi perjanjian  ini kepada para pemberi kuasa dengan sejelas-jelasnya dan tidak seorangpun  diantaranya menyatakan keberatan.</li>
            <?php if($_SESSION['lokasi']=='199') { ?>
            	<li>Kredit akan dibayar kembali dalam jangka waktu : 10/12/18/24 Bulan</li>
					  <li>Beban Biaya Asuransi sebesar 2% (persen) dari total Pinjaman / Kredit yaitu pokok dan Jasa</li>
					  <li>Dana kredit akan dipergunakan untuk kegiatan usaha guna meningkatkan pendapatan dan mutu kehidupan keluarga. Dengan demikian kredit ini akan memberikan manfaat sebesar-besarnya bagi pertumbuhan ekonomi serta perkembangan seluruh anggota keluarga Pihak Kedua dengan batas Usia untuk peminjam maksimal 58 Tahun.</li> <?php } ?>
          </ol>
        </div></td>
      </tr>
</table>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
   
   <tr>
        <td width="28%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>&nbsp;</p>
          <p>Pihak PERTAMA, </p>
        </div></td>
        <td colspan="2" class="style26"><div align="center" class="style9">Ditanda tangani di <?php echo $nama_desa;?>, <?php echo tgl_indo($tgl_cair);?>
            <p>Pihak KEDUA,  </p>
        </div></td>
    </tr>	
	<tr>
	    <th height="24" colspan="1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?> <br><?php echo "$row[sebutan_level_1] $row[nama_lembaga_sort]";?></p></th>
        <th width="15%" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper($row['namadepan']); ?><br>
        Pemanfaat </p></th>
        <th width="15%" class="style9"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
        <?php echo strtoupper($row['penjamin']); ?> <br>
        Penjamin </th>
  </tr>


      <tr>
        <td height="20" colspan="-1" class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
      </tr>

<?php if($ttd_saksi=="1") { ?> 	  
      <tr>
        <td class="style9" colspan="2"><div align="center"><?php echo "$row[sebutan_kades] $nama_desa"; ?> <br>Selaku Saksi
        </div></td>
      </tr>
      <tr>
        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><b><?php echo strtoupper($row['kades']);?></b><br><?php if(!empty($row['nip']) or $row['nip']>0) { echo "$row[pangkat] <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p></div></td>
      </tr>
<?php } else if($ttd_saksi=="2") { ?> 	  
      <tr>
        <td class="style9" colspan="2"><div align="center">Ketua <?php echo $nama_bkad_sort; ?> Kecamatan <?php echo $nama_kec; ?><br>Selaku Saksi
        </div></td>
      </tr>
      <tr>
        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><b><?php echo strtoupper("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><b></p></div></td>
      </tr>
<?php } else if($ttd_saksi=="3") { ?>
      <tr>
        <td height="20" colspan="3" class="style9"><div align="center">Saksi-Saksi</div></td>
      </tr>
      <tr>
        <td class="style9"><div align="center">Ketua <?php echo $nama_bkad_sort; ?> <br> Kecamatan <?php echo $nama_kec; ?></div></td>
        <td class="style9" colspan="2"><div align="center"><?php echo "$row[sebutan_kades]<br>$nama_desa"; ?>
        </div></td>
      </tr>
      <tr>
        <th class="style9"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><?php echo strtoupper("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><br>&nbsp;<br>&nbsp;</p></th>
        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><b><?php echo strtoupper($row['kades']);?></b><br><?php if(!empty($row['nip']) or $row['nip']>0) { echo "$row[pangkat] <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p></div></td>
      </tr>
<?php } else if($ttd_saksi=="4") { ?>
      <tr>
        <td height="20" colspan="3" class="style9"><div align="center">Saksi-Saksi</div></td>
      </tr>
      <tr>
        <td class="style9"><div align="center"><?php echo "$row[sebutan_kades]<br>$nama_desa"; ?></div></td>
        <td class="style9" colspan="2"><div align="center">Ketua LPMD <br> <?php echo "$row[sebutan_desa] $nama_desa"; ?>
        </div></td>
      </tr>
      <tr>
        <th class="style9"><p>&nbsp;</p>
        <p>&nbsp;</p>
		<p><b><?php echo strtoupper($row['kades']);?></b><br><?php if(!empty($row['nip']) or $row['nip']>0) { echo "$row[pangkat] <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p>
        </th>
        <th class="style9" colspan="2"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><?php echo strtoupper($row['ked']); ?><br>&nbsp;<br>&nbsp;</p></div></th>
      </tr>
<?php } else if($ttd_saksi=="5") { ?>
      <tr>
        <td height="20" colspan="3" class="style9"><div align="center">Saksi-Saksi</div></td>
      </tr>
      <tr>
        <td class="style9"><div align="center">Saksi 1</div></td>
        <td class="style9" colspan="2"><div align="center">Saksi 2</div></td>
      </tr>
      <tr>
        <td class="style9"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>___________________</p></div></td>
        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>___________________</p></div></td>
      </tr>
<?php } else if($ttd_saksi=="6") { echo "<br>"; ?>

<?php } else if ($ttd_saksi=='7') { ?>
		<tr>
        <td height="20" colspan="3" class="style9"><div align="center">Saksi-Saksi</div></td>
      </tr>
      <tr>
        <td class="style9"><div align="center">Ketua <?php echo $nama_bp_sort; ?></div></td>
        <td class="style9" colspan="2"><div align="center">Ketua <?php echo $nama_bkad_sort; ?>
        </div></td>
      </tr>
      <tr>
        <th class="style9"><p>&nbsp;</p>
        <p>&nbsp;</p>
		<p><b><?php echo strtoupper("$ketuabp[namadepan] $ketuabp[namabelakang]"); ?></p>
        </th>
        <th class="style9" colspan="2"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><?php echo strtoupper("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><br>&nbsp;<br>&nbsp;</p></div></th>
      </tr>

<?php } ?>


<?php if($ttd_mengetahui=="1") { ?> 	  
      <tr>
        <td class="style9" colspan="2"><div align="center">Mengetahui,<br><?php echo "$row[sebutan_kades] $nama_desa"; ?>
        </div></td>
      </tr>
      <tr>
        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><b><?php echo strtoupper($row['kades']);?></b><br><?php if(!empty($row['nip']) or $row['nip']>0) { echo "$row[pangkat] <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p></div></td>
      </tr>
<?php } else if($ttd_mengetahui=="2") { ?> 	  
      <tr>
        <td class="style9" colspan="2"><div align="center">Mengetahui,<br>Ketua <?php echo $nama_bkad_sort; ?> Kecamatan <?php echo $nama_kec; ?>
        </div></td>
      </tr>
      <tr>
        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><b><?php echo strtoupper("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><b></p></div></td>
      </tr>
<?php } else if($ttd_mengetahui=="3") { ?>
      <tr>
        <td height="20" colspan="3" class="style9"><div align="center">Mengetahui,</div></td>
      </tr>
      <tr>
        <td class="style9"><div align="center">Ketua <?php echo $nama_bkad_sort; ?> <br> Kecamatan <?php echo $nama_kec; ?></div></td>
        <td class="style9" colspan="2"><div align="center"><?php echo "$row[sebutan_kades]<br>$nama_desa"; ?>
        </div></td>
      </tr>
      <tr>
        <th class="style9"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><?php echo strtoupper("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><br>&nbsp;<br>&nbsp;</p></th>
        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><b><?php echo strtoupper($row['kades']);?></b><br><?php if(!empty($row['nip']) or $row['nip']>0) { echo "$row[pangkat] <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p></div></td>
      </tr>
<?php } else if($ttd_mengetahui=="4") { ?>
      <tr>
        <td>&nbsp;</td>
      </tr>
<?php } ?>
	  
      <tr>
        <td height="20" colspan="-1" class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" colspan="-1" class="style9"><div align="left"><?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?></div></td>
        <td colspan="2" class="style9"><div align="right">Loan ID. <?php echo "$id_pinj";?></div></td>
      </tr>
</table>

<title>1. SPK Anggota <?php echo "$row[namadepan] ($id_pinj)";?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>
