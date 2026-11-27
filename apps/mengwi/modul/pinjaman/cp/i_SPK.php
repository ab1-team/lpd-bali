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
											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
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
											$sebutan_kec		=$row['sebutan_kec'];
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
											
											$nama_kec = $_SESSION['unit'];
				
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
                
                  echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$sebutan_kec $_SESSION[unit] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
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
	PINJAMAN UMUM<br>
	<span class="style28">Nomor : <?php echo $spk_no;?><br>Tanggal : <?php echo tgl_indo($tgl_cair);?></span><br><br>
</p>

	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td height="19" colspan="24" class="style9"><p align="justify">
		Dengan memohon rahmat Tuhan Yang Maha Kuasa serta kesadaran akan cita-cita luhur <?php echo "$row[nama_lembaga_sort] $sebutan_kec $_SESSION[unit]";?> untuk mencapai kemajuan ekonomi dan kemakmuran bersama, saya yang bertanda tangan di bawah ini :</p>        </td>
      </tr>
      <tr>
        <td width="197" height="25" class="style9"><p>Nama <br>N I K <br>
          Jabatan <br>Alamat </p>        </td>
        <td height="25" colspan="23" class="style27">: <?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?> <br>
		  : <?php echo "$ketuaupk[nik]";?> <br>
          : <?php echo "$row[sebutan_level_1] $row[nama_lembaga_sort] $sebutan_kec $_SESSION[unit]";?> <br>: <?php echo $row['alamat_kec']; ?></td>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style9"><div align="justify">
		Dalam hal ini bertindak untuk dan atas nama Pengurus <?php echo "$row[nama_lembaga_sort] $sebutan_kec $_SESSION[unit]";?> selaku pengelola pelayanan kredit untuk <?php echo "$row[deskripsi_jpp] ($row[nama_jpp])";?> di <?php echo "$sebutan_kec $_SESSION[unit]";?>, Selanjutnya disebut <b>Pihak Pertama</b>, dan :</div></td>
      </tr>
      <tr>
        <td height="25" class="style9">Nama Lengkap<br>
			Jenis Kelamin<br>
			Tempat, Tanggal Lahir <br>
			N I K <br>
			Berkedudukan di </td>
        <td height="25" colspan="23" class="style27">: <?php echo strtoupper($row['namadepan']); ?> 
			<br>: <?= ($row['jk'] == 'L') ? 'Laki-laki':'Perempuan';?>
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
		    	<b>Pihak Pertama</b> dan <b>Pihak Kedua</b> dalam kedudukan masing-masing seperti telah diterangkan di atas, pada hari <strong><?php echo "$namahari $pasaran[$mod]";?></strong> </b>tanggal <b><?php echo ucwords(toTerbilang($tanggal));?></b> bulan <b><?php echo $bulan;?></b> tahun <b><?php echo ucwords(toTerbilang($tahun));?></b>, bertempat di <strong><?php echo "$row[nama_lembaga_sort] $sebutan_kec $_SESSION[unit]";?> </strong> dengan sadar dan sukarela menyatakan telah membuat perjanjian utang piutang dengan ketentuan-ketentuan yang telah disepakati bersama sebagai berikut :											
</p>
        </div></td>
      </tr>
      <tr>
        <th colspan="24" class="style9">&nbsp;</th>
      </tr>
      <tr>
        <th colspan="24" class="style9">Pasal 1 <br> Jumlah Pinjaman</th>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style6"><div align="justify">
          <ol><li class="style9"><b>Pihak Pertama</b> dengan ini setuju memberikan kredit kepada <b>Pihak Kedua</b> uang sebesar <strong>Rp. <?php echo number_format($alokasi);?>,- (<?php echo ucwords(toTerbilang($alokasi)); ?> Rupiah) </strong> yaitu jumlah yang telah diputuskan bersama Pengurus <?php echo "$row[nama_lembaga_sort] $sebutan_kec $_SESSION[unit]";?>, berdasarkan permohonan dari <b>Pihak Kedua</b> yang dilakukan secara perorangan sesuai Surat Permohonan Kredit tanggal <b><?php echo tgl_indo($tgl_proposal);?></b>.	</li>
            <li class="style9"><b>Pihak Kedua</b> dan Pemberi kuasa, mengaku telah menerima uang dalam jumlah sebagaimana yang diterangkan pada ayat 1 diatas, uang telah dibayarkan sesuai jumlah kelayakan pinjamannya masing-masing dan dibuktikan secara sah dengan daftar tanda terima uang terlampir, yang berlaku sebagai Surat Pengakuan Utang secara perorangan.</li>
          </ol>
        </div></td>
      </tr>
      <tr>
        <th height="25" colspan="24" class="style6"><span class="style9">Pasal 2 <br> Penyerahan Pinjaman </span></th>
      </tr>
      
      <tr>
        <td height="25" colspan="24" class="style6" align="justify"><span class="style9" ></span>
          <div align="justify">
            <ol class="style9">
              <li><b>Pihak Pertama</b> telah menyerahkan uang kepada <b>Pihak Kedua</b> sebagai pinjaman sebesar <b><?php echo number_format($alokasi);?>,- (<?php echo ucwords(toTerbilang($alokasi)); ?> Rupiah)</b> tersebut secara tunai dan sekaligus kepada <b>Pihak Kedua</b> pada saat perjanjian ini dibuat dan ditanda tangani. <b>Pihak Kedua</b> menyatakan telah menerimanya dengan menandatangani bukti penerimaan (kwitansi) yang sah.</li>
              
				 

			</ol>
		  </div>
		</td>
      </tr>
      

      <tr>
        <th height="25" colspan="24" class="style9">Pasal 3 <br>Sistem Pengembalian</th>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style6"><div align="justify">
          <p class="style9"><b>Pihak Kedua</b> wajib membayar utang tersebut kepada Pihak Pertama dengan cara pembayaran angsuran sebesar <b>Rp.<?php echo number_format(wajibpokokaja_anggota($id_pinj));?>,- (<?php echo ucwords(toTerbilang(wajibpokokaja_anggota($id_pinj))); ?> Rupiah)</b> ditambah jasa <b><?php echo $pros_jasa; ?>% <?php echo $nama_jj; ?></b> sebesar <b>Rp.<?php echo number_format(wajibjasaaja_anggota($id_pinj));?>,- (<?php echo ucwords(toTerbilang(bulatkan(wajibjasaaja_anggota($id_pinj)))); ?> Rupiah) </b>   setiap bulan, selama <b><?php echo $jangka;?> bulan</b>, yang dimulai pada hari <b><?php echo "$namahari";?>, <?php echo tgl_indo($tgl_cair);?></b> dan sampai target pelunasan, sebagaimana jadwal angsuran terlampir.</p>
          <?php if ($_SESSION['lokasi']=='239') { ?>
          <p class="style9">Keterlambatan pengembalian pinjaman(pembayaran angsuran) peminjam dikenakan denda sebesar <b>0,1%</b>dari tunggakan pokok. Denda efektif diberlakukan 3 hari sejak jadwal pembayaran angsuran dan tidak diberikan IPTW dan denda denda ini berlaku bagi pinjaman perorangan atau kelompok.</p>
      	  <?php }?>
      	  
      	 <p>
      	     
      	 </ol>
        </div></td>
      </tr>

      <tr>
        <th height="25" colspan="24" class="style9"><br>Pasal 4 <br>Agunan</th>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style6"><div align="justify">
          <p class="style9">Untuk menjamin pembayaran kembali yang tertib dan sebagaimana mestinya atas segala sesuatu yang berdasarkan perjanjian ini masih terutang oleh <b>Pihak Kedua</b> kepada <b>Pihak Pertama</b>, ditambah biaya yang timbul akibat eksekusi Agunan, maka akan dibuat sebuah perjanjian dimana :</p>
          <ol class="style9">
            <li><b>Pihak Kedua</b> akan menyerahkan Agunan kepada <b>Pihak Pertama</b> berupa.
            	<br><b><?php if(substr($row['jaminan'],0,1)=='1') { echo "TANAH" ; echo"<br/>";  echo substr($row['jaminan'],2);?> 

			        <?php } else if(substr($row['jaminan'],0,1)=='2') { echo "TANAH DAN BANGUNAN"; echo"<br/>"; echo substr($row['jaminan'],2);?> 

			        <?php } else if(substr($row['jaminan'],0,1)=='3') { echo "SEPEDA MOTOR"; echo"<br/>"; echo substr($row['jaminan'],2);?>

			        <?php } else if(substr($row['jaminan'],0,1)=='4') { echo "MOBIL"; echo"<br/>"; echo substr($row['jaminan'],2);?>

			        <?php } else if(substr($row['jaminan'],0,1)=='5') { echo "SKP PEGAWAI"; echo"<br/>"; echo substr($row['jaminan'],2);?>   
          			<?php } ?></b>
            	<br>berikut dengan segala hak dan kepentingan yang sekarang atau dikemudian hari akan diperoleh <b>Pihak Pertama</b> atas <b><?php if(substr($row['jaminan'],0,1)=='1') { echo "TANAH" ;?> 

			        <?php } else if(substr($row['jaminan'],0,1)=='2') { echo "TANAH DAN BANGUNAN";?> 

			        <?php } else if(substr($row['jaminan'],0,1)=='3') { echo "SEPEDA MOTOR";?>

			        <?php } else if(substr($row['jaminan'],0,1)=='4') { echo "MOBIL";?>

			        <?php } else if(substr($row['jaminan'],0,1)=='5') { echo "SKP PEGAWAI";?>   
          			<?php } ?></b> tersebut diatas.	
            </li>
            <li><b>Agunan</b> diikat sesuai dengan ketentuan peraturan perundang-undangan yang berlaku sesuai dengan jenis <b>Agunan</b> yang diberikan.</li>
            <li>Bukti pemilikan, izin-izin atau dokumen-dokumen yang berkaitan dengan Agunan serta akta-akta berkenaan dengan pengikatan barang agunan yang diagunkan sebagaimana tersebut dalam ayat 2 pasal ini, dikuasai oleh <b><?php echo "$row[nama_lembaga_sort] $sebutan_kec $_SESSION[unit]";?></b> sampai kredit dinyatakan lunas. Jika karena sebab apapun, Agunan diserahkan menjadi tidak sah atau berkurang nilainya, maka Pihak Kedua wajib menyerahkan Agunan Pengganti yang bentuk dan nilainya sama dan dapat disetujui oleh <b><?php echo "$row[nama_lembaga_sort] $sebutan_kec $_SESSION[unit]";?></b>.</b></li>
            <li>Barang jaminan tersebut <b>Sah</b> milik <b>Pihak Kedua</b> dan sedang tidak dalam keadaan sengketa.</li>
          </ol>
        </div></td>
      </tr>

      <tr>
        <th height="25" colspan="24" class="style9">Pasal 5 <br>Pengalihan Kuasa Khusus atas Agunan</th>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style6"><div align="justify">
          <ol class="style9">
            <li><b>Pihak Kedua</b> dengan ini memberikan kuasa kepada <b>Pihak Pertama</b> untuk mengambil dan menguasai obyek yang disebutkan sebagai barang jaminan atau agunan dimaksud dalam pasal 5 secara sah dan memiliki hak sepenuhnya untuk menjual atau melakukan lelang													
			atau memiliki sendiri atas barang jaminan/agunan tersebut dalam rangka melunasi hutang <b>Pihak Kedua</b>.</li>
			<li>
				Kuasa yang diberikan oleh <b>Pihak Kedua</b> kepada <b>Pihak Pertama</b> didalam atau berdasarkan perjanjian ini, merupakan bagian yang terpenting dan tidak terpisahkan dari perjanjian ini, kuasa mana tidak dapat ditarik kembali dan juga tidak akan berakhir karena meninggal dunianya <b>Pihak Kedua</b> atau karena sebab apapun juga.									
			</li>
			<li>
				Dalam rangka menjalankan Kuasa Khusus Penjualan dan/atau melakukan pelelangan barang jaminan/agunan sebagaimana disebut dalam Pasal 6 Ayat 1 juncto Pasal 5, maka nilai penjualan dan/atau pelelangan setelah dikurangi biaya eksekusi barangjaminan/agunan beserta biaya yang timbul dari proses penjualan/pelelangan barang jaminan/agunan akan diperhitungkan sebagai kelebihan atau kekurangan bayar yang tetap menjadi hak/kewajiban <b>Pihak Kedua</b>.									
			</li>
            </ol>
        </div></td>
      </tr>


            <tr>
        <th height="25" colspan="24" class="style9">Pasal 6 <br>Penyelesaian Perselisihan</th>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style6"><div align="justify">
          <ol class="style9">
            <li>Apabila ada hal-hal yang tidak atau belum diatur dalam perjanjian ini dan juga jika terjadi perbedaan penafsiran atas seluruh atau sebagian dari perjanjian ini maka kedua belah pihak sepakat untuk menyelesaikannya secara musyawarah untuk mufakat.</li>
            <li>Jika penyelesaian secara musyawarah untuk mufakat juga ternyata tidak menyelesaikan perselisihan tersebut maka perselisihan tersebut akan diselesaikan secara hukum yang berlaku di Indonesia dan oleh karena itu kedua belah pihak setuju menunjuk Pengadilan Negeri <?php echo $row['nama_kab'];?> sebagai upaya hukum dalam menyelesaikan persengketaan tersebut.</li>

          </ol>
        </div></td>
      </tr>

            <tr>
        <th height="25" colspan="24" class="style9">Pasal 7 <br>Lain-Lain</th>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style6"><div align="justify">
          <p class="style9">
            Hal-hal yang belum atau belum cukup diatur dalam perjanjian ini akan diatur lebih lanjut dalam bentuk surat menyurat dan atau addendum perjanjian yang ditandatangani oleh para pihak yang merupakan satu kesatuan dan bagian yang tidak terpisahkan dari perjanjian ini.

          </p>
        </div></td>
      </tr>
      <br>
     <tr>
        <th height="25" colspan="24" class="style9">Pasal 8 <br>Penutup</th>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style6"><div align="justify">
          <p class="style9">
            Perjanjian Utang Piutang uang ini dibuat rangkap 2 (dua) di atas kertas bermaterai cukup untuk masing-masing pihak yang mempunyai kekuatan hukum yang sama dan ditanda tangani oleh kedua belah pihak dalam keadaan sehat jasmani dan rohani, serta tanpa unsur paksaan dari pihak manapun.

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
        <p><?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?> <br><?php echo "$row[sebutan_level_1] $_SESSION[unit]";?></p></th>
        <th width="15%" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper($row['namadepan']); ?><br>
        Debitur </p></th>
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

<!--<?php if($ttd_saksi=="1") { ?> 	  -->
<!--      <tr>-->
<!--        <td class="style9" colspan="2"><div align="center"><?php echo "$row[sebutan_kades] $nama_desa"; ?> <br>Selaku Saksi-->
<!--        </div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--        <p><b><?php echo strtoupper($row['kades']);?></b><br><?php if(!empty($row['nip']) or $row['nip']>0) { echo "$row[pangkat] <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p></div></td>-->
<!--      </tr>-->
<!--<?php } else if($ttd_saksi=="2") { ?> 	  -->
<!--      <tr>-->
<!--        <td class="style9" colspan="2"><div align="center">Ketua <?php echo $nama_bkad_sort; ?> <?php echo "$sebutan_kec $nama_kec";?><br>Selaku Saksi-->
<!--        </div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--        <p><b><?php echo strtoupper("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><b></p></div></td>-->
<!--      </tr>-->
<!--<?php } else if($ttd_saksi=="3") { ?>-->
<!--      <tr>-->
<!--        <td height="20" colspan="3" class="style9"><div align="center">Saksi-Saksi</div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <td class="style9"><div align="center">Ketua <?php echo $nama_bkad_sort; ?> <br> <?php echo "$sebutan_kec $nama_kec";?></div></td>-->
<!--        <td class="style9" colspan="2"><div align="center"><?php echo "$row[sebutan_kades]<br>$nama_desa"; ?>-->
<!--        </div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <th class="style9"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--        <p><?php echo strtoupper("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><br>&nbsp;<br>&nbsp;</p></th>-->
<!--        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--        <p><b><?php echo strtoupper($row['kades']);?></b><br><?php if(!empty($row['nip']) or $row['nip']>0) { echo "$row[pangkat] <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p></div></td>-->
<!--      </tr>-->
<!--<?php } else if($ttd_saksi=="4") { ?>-->
<!--      <tr>-->
<!--        <td height="20" colspan="3" class="style9"><div align="center">Saksi-Saksi</div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <td class="style9"><div align="center"><?php echo "$row[sebutan_kades]<br>$nama_desa"; ?></div></td>-->
<!--        <td class="style9" colspan="2"><div align="center">Ketua LPMD <br> <?php echo "$row[sebutan_desa] $nama_desa"; ?>-->
<!--        </div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <th class="style9"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--		<p><b><?php echo strtoupper($row['kades']);?></b><br><?php if(!empty($row['nip']) or $row['nip']>0) { echo "$row[pangkat] <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p>-->
<!--        </th>-->
<!--        <th class="style9" colspan="2"><div align="center"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--        <p><?php echo strtoupper($row['ked']); ?><br>&nbsp;<br>&nbsp;</p></div></th>-->
<!--      </tr>-->
<!--<?php } else if($ttd_saksi=="5") { ?>-->
<!--      <tr>-->
<!--        <td height="20" colspan="3" class="style9"><div align="center">Saksi-Saksi</div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <td class="style9"><div align="center">Saksi 1</div></td>-->
<!--        <td class="style9" colspan="2"><div align="center">Saksi 2</div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <td class="style9"><div align="center"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--        <p>___________________</p></div></td>-->
<!--        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--        <p>___________________</p></div></td>-->
<!--      </tr>-->
<!--<?php } else if($ttd_saksi=="6") { echo "<br>"; ?>-->

<!--<?php } else if ($ttd_saksi=='7') { ?>-->
<!--		<tr>-->
<!--        <td height="20" colspan="3" class="style9"><div align="center">Saksi-Saksi</div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <td class="style9"><div align="center">Ketua <?php echo $nama_bp_sort; ?> <?php if ($_SESSION['lokasi']=='204') {echo'DAPM'; } ?></div></td>-->
<!--        <td class="style9" colspan="2"><div align="center">Ketua <?php echo $nama_bkad_sort; ?>-->
<!--        </div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <th class="style9"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--		<p><b><?php echo strtoupper("$ketuabp[namadepan] $ketuabp[namabelakang]"); ?></p>-->
<!--        </th>-->
<!--        <th class="style9" colspan="2"><div align="center"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--        <p><?php echo strtoupper("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><br>&nbsp;<br>&nbsp;</p></div></th>-->
<!--      </tr>-->

<!--<?php } ?>-->


<!--<?php if($ttd_mengetahui=="1") { ?> 	  -->
<!--      <tr>-->
<!--        <td class="style9" colspan="2"><div align="center">Mengetahui,<br><?php echo "$row[sebutan_kades] $nama_desa"; ?>-->
<!--        </div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--        <p><b><?php echo strtoupper($row['kades']);?></b><br><?php if(!empty($row['nip']) or $row['nip']>0) { echo "$row[pangkat] <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p></div></td>-->
<!--      </tr>-->
<!--<?php } else if($ttd_mengetahui=="2" OR $_SESSION['lokasi']==95) { ?> 	  -->
<!--      <tr>-->
<!--        <td class="style9" colspan="3"><div align="center">Mengetahui,<br>Ketua <?php echo $nama_bkad_sort; ?> <?php echo "$sebutan_kec $nama_kec";?>-->
<!--        </div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <td class="style9" colspan="3"><div align="center"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--        <p><b><?php echo strtoupper("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><b></p></div></td>-->
<!--      </tr>-->
<!--<?php } else if($ttd_mengetahui=="3") { if($_SESSION['lokasi']==112){ ?>-->
<!--	      <tr>-->
<!--        <td class="style9" colspan="2"><div align="center">Mengetahui,<br><?php echo "$row[sebutan_kades]<br>$nama_desa"; ?>-->
<!--        </div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--         <p><b><?php echo strtoupper($row['kades']);?></b><br><?php if(!empty($row['nip']) or $row['nip']>0) { echo "$row[pangkat] <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p></div></td>-->
<!--      </tr>-->
<!--<?php }else{ ?>-->
<!--      <tr>-->
<!--        <td height="20" colspan="3" class="style9"><div align="center">Mengetahui,</div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <td class="style9"><div align="center">Ketua <?php echo $nama_bkad_sort; ?> <br> <?php echo "$sebutan_kec $nama_kec";?></div></td>-->
<!--        <td class="style9" colspan="2"><div align="center"><?php echo "$row[sebutan_kades]<br>$nama_desa"; ?>-->
<!--        </div></td>-->
<!--      </tr>-->
<!--      <tr>-->
<!--        <th class="style9"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--        <p><?php echo strtoupper("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><br>&nbsp;<br>&nbsp;</p></th>-->
<!--        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>-->
<!--        <p>&nbsp;</p>-->
<!--        <p><b><?php echo strtoupper($row['kades']);?></b><br><?php if(!empty($row['nip']) or $row['nip']>0) { echo "$row[pangkat] <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p></div></td>-->
<!--      </tr>-->
<!--<?php }} else if($ttd_mengetahui=="4") { ?>-->
<!--      <tr>-->
<!--        <td>&nbsp;</td>-->
<!--      </tr>-->
<!--<?php } ?>-->
	  
      <tr>
        <td height="20" colspan="-1" class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" colspan="-1" class="style9"><div align="left"><?php echo "$row[nama_lembaga_sort] $sebutan_kec $_SESSION[unit]";?></div></td>
        <td colspan="2" class="style9"><div align="right">Loan ID. <?php echo "$id_pinj";?></div></td>
      </tr>
</table>

<title>1. SPK <?php echo "$row[namadepan] ($id_pinj)";?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>