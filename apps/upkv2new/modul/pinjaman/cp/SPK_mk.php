<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";

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
											$nama_tv_long		=$row ['nama_tv_long'];

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
				
			?>
	
   <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
			<td height="20" colspan="2" class="bottom">
				<div class="style9 text-align-left"><?php
                    $logo=$row['logo'];
                      if (empty($logo)) {
                        echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
                        }else{
                        echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
                        }
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
                
                  echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
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
	MANUNGGAL KARYA<br>
	<span class="style28">Nomor : <?php echo $spk_no;?><br>Tanggal : <?php echo tgl_indo($tgl_cair);?></span><br><br>
</p>

	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td height="19" colspan="24" class="style9"><p align="justify">
		<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td height="19" colspan="24" class="style9"><p align="justify">
		Dengan memohon rahmat Tuhan Yang Maha Kuasa serta kesadaran akan cita-cita luhur <?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?> untuk mencapai kemajuan ekonomi dan kemakmuran bersama, saya yang bertanda tangan dibawah ini :</p>        </td>
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
		Dalam hal ini bertindak untuk dan atas nama Pengurus <?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?> selaku pengelola pelayanan kredit untuk <?php echo "$row[deskripsi_jpp] ($row[nama_jpp])";?> dan Mandiri Pemberdayaan Masyarakat di <?php echo "Kecamatan $row[nama_kec]";?>, Selanjutnya disebut <b>Pihak Pertama</b>, dan :</div></td>
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
        <td height="37" colspan="24" class="style9"><div align="justify">
		Dalam hubungan ini bertindak untuk dan atas nama diri sendiri yang menjadi bagian tidak terpisahkan dari dokumen perjanjian kredit ini, selanjutnya disebut <strong>Pihak Kedua</strong>.
	      <p>
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
		    	<b>Pihak Pertama</b> dan <b>Pihak Kedua</b> dalam kedudukan masing-masing seperti telah diterangkan diatas, Pada hari <strong><?php echo "$namahari $pasaran[$mod]";?></strong> </b>tanggal <b><?php echo ucwords(toTerbilang($tanggal));?></b> bulan <b><?php echo $bulan;?></b> tahun <b><?php echo ucwords(toTerbilang($tahun));?></b>, bertempat di <strong><?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?> </strong> dengan sadar dan sukarela menyatakan telah membuat perjanjian utang piutang dengan ketentuan-ketentuan yang telah disepakati bersama sebagai berikut :										
</p>
        </div></td>
      </tr>
      <tr>
        <th colspan="24" class="style9">&nbsp;</th>
      </tr>
      <tr>
        <th colspan="24" class="style9">Pasal 1 <br></th>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style6"><div align="justify">
          <ol><li class="style9"><b>Pihak Pertama</b> dengan ini setuju memberikan kredit kepada <b>Pihak Kedua</b> uang sebesar <strong>Rp. <?php echo number_format($alokasi);?>,- (<?php echo ucwords(toTerbilang($alokasi)); ?> Rupiah) </strong> Yaitu jumlah yang telah diputuskan dalam Rekomendasi rapat <b>Tim Pendanaan</b> mendasar pada surat Rekomendasi dari <b><?php echo $nama_tv_long; ?></b> dan <b><?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?></b>, berdasarkan permohonan dari sesuai mandat PPM Manunggal Makmur Kecamatan Pejagoan, berdasarkan permohonan dari <b>Pihak Kedua</b> dan para pemberi kuasa yang dilakukan secara pribadi sesuai Surat Permohonan kredit tanggal <b><?php echo tgl_indo($tgl_proposal);?></b>.	</li>
            <li class="style9"><b>Pihak Kedua</b> dan Pemberi kuasa, mengaku telah menerima uang dalam jumlah sebagaimana yang diterangkan pada ayat 1 diatas, uang telah dibayarkan sesuai jumlah kelayakan pinjamannya masing-masing dan dibuktikan secara sah dengan daftar tanda terima uang terlampir, yang berlaku sebagai Surat Pengakuan Utang secara perorangan.</li>
          </ol>
        </div></td>
      </tr>
      </tr>
      

      <tr>
        <th height="25" colspan="24" class="style9">Pasal 2 <br></th>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style6"><div align="justify">
          <p class="style9">Kedua belah pihak secara sukarela menerima syarat-syarat perjanjian utang piutang sebagaimana dinyatakan dalam ketentuan-ketentuan dibawah ini :</p>
          <ol class="style9">
          	<li>Dana kredit Cash Tempo akan dipergunakan untuk kegiatan usaha guna meningkatkan pendapatan dan untuk peningkatan mutu kehidupan keluarga. Dengan demikian kredit ini akan memberikan manfaat sebesar-besarnya bagi pertumbuhan ekonomi serta perkembangan seluruh anggota keluarga pihak kedua dan para pemberi kuasa. </li>
          	<li>Atas kredit tersebut dikenakan jasa (bagi hasil) 1% flat per bulan dari pokok pinjaman yang  dicairkan.</li>
          	<li>Pihak kedua dan para pemberi kuasa mengerti dan menyadari bahwa jasa (bagi hasil) pinjaman yang dilbayar akan dipergunakan untuk biaya pelayanan dan pengelolaan yang sehat serta pemupukan modal dana pinjaman bergulir milik bersama agar dapat berkembang dan lestari sebagai sumber kredit yang bermafaat bagi warga masyarakat desa.</li>
          	<li><b>Pihak Kedua</b> wajib membayar hutang tersebut kepada Pihak Pertama dengan cara pembayaran angsuran sebesar <b>Rp.<?php echo number_format(wajibpokokaja_anggota($id_pinj));?>,- (<?php echo ucwords(toTerbilang(wajibpokokaja_anggota($id_pinj))); ?> Rupiah)</b> ditambah jasa <b><?php echo $pros_jasa; ?>% <?php echo $nama_jj; ?></b> sebesar <b>Rp.<?php echo number_format(wajibjasaaja_anggota($id_pinj));?>,- (<?php echo ucwords(toTerbilang(wajibjasaaja_anggota($id_pinj))); ?> Rupiah) </b>   setiap bulan, selama <b><?php echo $jangka;?> bulan</b>, yang dimulai pada hari <b><?php echo "$namahari";?>, <?php echo tgl_indo($tgl_cair);?></b> dan sampai target pelunasan, sebagaimana jadwal angsuran terlampir.</li>
            <li><b>Pihak Kedua</b> akan memberikan barang jaminan kepada Pihak Pertama dengan rincian sebagai berikut :
            	<br><b><?php if(substr($row['jaminan'],0,1)=='1') { echo "TANAH" ; echo"<br/>";  echo substr($row['jaminan'],3);?> 

			        <?php } else if(substr($row['jaminan'],0,1)=='2') { echo "TANAH DAN BANGUNAN"; echo"<br/>"; echo substr($row['jaminan'],3);?> 

			        <?php } else if(substr($row['jaminan'],0,1)=='3') { echo "SEPEDA MOTOR"; echo"<br/>"; echo substr($row['jaminan'],3);?>

			        <?php } else if(substr($row['jaminan'],0,1)=='4') { echo "MOBIL"; echo"<br/>"; echo substr($row['jaminan'],3);?>

			        <?php } else if(substr($row['jaminan'],0,1)=='5') { echo "SKP PEGAWAI"; echo"<br/>"; echo substr($row['jaminan'],3);?>   
          			<?php } ?></b>
            	<br>berikut dengan segala hak dan kepentingan yang sekarang atau dikemudian hari akan diperoleh <b>Pihak Pertama</b> atas <b><?php if(substr($row['jaminan'],0,1)=='1') { echo "TANAH" ;?> 

			        <?php } else if(substr($row['jaminan'],0,1)=='2') { echo "TANAH DAN BANGUNAN";?> 

			        <?php } else if(substr($row['jaminan'],0,1)=='3') { echo "SEPEDA MOTOR";?>

			        <?php } else if(substr($row['jaminan'],0,1)=='4') { echo "MOBIL";?>

			        <?php } else if(substr($row['jaminan'],0,1)=='5') { echo "SKP PEGAWAI";?>   
          			<?php } ?></b> tersebut diatas.	
            </li>
            <li>Bilamana di kemudian hari Pihak Kedua tidak dapat membayar hutangnya maka Pihak Pertama mempunyai hak penuh atas barang yang dijaminkan kepada Pihak Pertama  untuk dijual, hasil penjualan akan digunakan untuk menutup kekurangan angsuran sampai dengan lunas.</li>
            <li>Jika hasil penjualan setelah dikurangi untuk melunasi UPK ada sisa, maka sisanya akan dikembalikan lagi ke Pihak Kedua.</li>
          </ol>
        </div></td>
      </tr>

      <tr>
        <th height="25" colspan="24" class="style9">Pasal 3 <br></th>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style6"><div align="justify">
          <ol class="style9">
            <li>Apabila terjadi wanprestasi oleh salah satu pihak yang timbul atas perjanjian utang piutang ini, akan diselesaikan secara musyawarah untuk mencapai kata sepakat apabila tidak dapat dicapai kata sepakat, kedua belah pihak setuju untuk menunjuk pengadilan negeri kebumen sebagai upaya hukum menyelesaikan persengketaan tersebut.</li>
			<li>
				Pihak kedua menyatakan secara sadar dan sukarela telah menandatangani akad atau perjanjian kredit ini, setelah terlebih dahulu membacakan isi perjanjian ini kepada para pemberi kuasa dengan sejelas-jelasnya dan tidak seorang pun diantaranya menyatakan keberatan.								
			</li>
            </ol>
            <p class="style9">Surat Perjanjian ini dibuat 2 (dua) rangkap bermeterai cukup dan masing-masing rangkap memiliki kekuatan hukum yang baik itu untuk Pihak Pertama serta Pihak Kedua. Surat Perjanjian ini dibuat serta ditanda tangani oleh kedua belah pihak tanpa adanya paksaan dari pihak manapun.

          </p>
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
        <td class="style9"><div align="center">Ketua <?php echo $nama_bp_sort; ?> <?php if ($_SESSION['lokasi']=='204') {echo'DAPM'; } ?></div></td>
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
