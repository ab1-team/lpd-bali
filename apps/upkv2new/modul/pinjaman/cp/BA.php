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
.center {text-align:center; }
-->
</style>
<body onLoad="window.print()">

     	    <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk, jenis_jasa jj,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.sebutan=sd.id AND d.id=k.desa AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
							jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND jj.id=pk.jenis_jasa AND
							sa.id=pk.sistem_angsuran AND pk.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		                                    $kd_prov      =$row['kd_prov'];
											$id_pinj			=$row['id'];
											$id_kel				=$row['id_kel'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											$angg=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$id_pinj' and alokasi>1 ");  /* query hitung jumlah anggota */
											$jml_anggota=mysql_num_rows($angg);
											$nama_bkad_sort =$row['nama_bkad_sort'];
		
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
											$nama_ket_upk		=$dus['namadepan']. " " .$dus['namabelakang'];
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$ttd_mengetahui		=$row['ttd_mengetahui'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuadbm			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND jabatan='65' "));
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
			$ttd_saksi	        = $row['ttd_saksi'];
            $ttd_mengetahui		= $row['ttd_mengetahui'];
            $ttd_pdua			= $row['ttd_pdua'];
            $ttd_psatu			= $row['ttd_psatu'];
        if      ($ttd_psatu=="1") {$psatu=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]' AND u.level='1' AND u.jabatan='1' "); }
        else if ($ttd_psatu=="2"){ $psatu=mysql_query("SELECT * FROM users u, jabatan j WHERE u.jabatan=j.id AND u.lokasi='$_SESSION[lokasi]'AND u.jabatan='7' "); }
					
				
			?>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="3" class="bottom">
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
			<td height="20" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
			Loan ID. <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?>
			 </div></td>
  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		BERITA ACARA PENCAIRAN<br>
		<span class="fw-semi-bold">PINJAMAN KELOMPOK <?php echo $nama_jpp;?></p></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="4" class="style9">&nbsp;</td>
      </tr>
	  <tr>
        <td height="81" colspan="4" class="style9"><div align="justify">
          <p>
		  <?php //MENCARI TANGGAL CAIR ITU HARI APA
				$query = "SELECT datediff('$tgl_cair', CURDATE()) as selisih";
				$hasil = mysql_query($query);
				$data  = mysql_fetch_array($hasil);

				$selisih = $data['selisih'];
				 
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
		Pada hari ini <b> <?php if ($kd_prov == '5') {
                          echo"$namahari";
                          } elseif ($kd_prov == '4') {
                            echo"$namahari";
                          }
                          else{
                          echo "$namahari";
                          } ?> </b>tanggal <b><?php echo ucwords(toTerbilang($tanggal));?></b> bulan <b><?php echo $bulan;?></b> tahun <b><?php echo ucwords(toTerbilang($tahun));?></b>, telah diadakan pencairan dana perguliran 
            <?php 
		if ($jenis_pinjaman==1){
				echo "Simpan Pinjam Khusus Perempuan (SPP)";
			}else if ($jenis_pinjaman==2){
				echo "Usaha Ekonomi Produktif (UEP)";
			}
			?> 
          <?php echo "$row[nama_lembaga_long]"; ?> Kecamatan <?php echo $nama_kec; ?> kepada Kelompok <?php echo $nama_kelompok;?> <?php echo "$row[sebutan_desa] $nama_desa"; ?> 
        Kecamatan <?php echo $nama_kec; ?>, sebesar <strong>Rp. <?php echo number_format($alokasi);?>,- (<?php echo ucwords(Toterbilang($alokasi)); ?> Rupiah), </strong>sesuai dengan Register Pinjaman pada Sistem Informasi Manajemen UPK Online nomor : <strong><?php echo $kd_kelompok;?>-<?php echo $id_pinj;?></strong> dan Surat Perjanjian Kredit (SPK) nomor : <strong><?php echo $row['spk_no'];?></strong></p>
          <p>Adapun rincian pinjaman dan data  kelompok (Profil Kelompok) adalah sebagai berikut : </p>
        </div></td>
      </tr>
      <tr>
        <td width="191" height="25" class="style9">1. <?php echo "$row[sebutan_desa]"; ?>  </td>
        <td width="349" height="25"><span class="style9">:</span><span class="style27"> <?php echo $nama_desa;  ?></span></td>
        <td width="224" height="25" class="style9">9. Tingkat Kelompok</td>
        <td width="271" height="25"><span class="style9">:</span><span class="style27"> <?php echo $tingkat_kelompok;?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">2.  Nama Kelompok</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $nama_kelompok;?></span></td>
        <td height="25" class="style9">10. Fungsi Kelompok </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $fungsi_kelompok;?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">3.  Alamat</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $alamat_kelompok;?></span></td>
        <td height="25" class="style9">11. Nama Ketua </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $ketua;?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">4. Tanggal Berdiri </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($tgl_berdiri);?></span></td>
        <td height="25" class="style9">12. Contact Person</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $telpon;?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">5. Jumlah Pemanfaat</td>
        <td height="25"><span class="style9">: </span><span class="style27"><?php echo $jml_anggota;?> orang</span></td>
        <td height="25" class="style9">13. Tanggal Pencairan</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($tgl_cair); ?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">6. Jenis Pinjaman</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $nama_jpp;?></span></td>
        <td height="25" class="style9">14. Alokasi Pinjaman</td>
        <td height="25"><span class="style9">:</span><span class="style27"> Rp. <?php echo number_format($alokasi);?>,-</span></td>
      </tr>
      <tr>
        <td height="25" class="style9">7. Jenis Usaha</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $jenis_usaha;?></span></td>
        <td height="25" class="style9">15. Tempo/Sistem </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo "$tempo/$sistem_angsuran";?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">8. Jenis Kegiatan</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $jenis_kegiatan;?></span></td>
        <td height="25" class="style9">16. Prosentase Jasa </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo "$pros_jasa % $row[nama_jj]";?> /bulan</span></td>
      </tr>
	  <tr>
        <td height="37" colspan="4" class="style9">
		  <p align="justify">Dari pinjaman tersebut akan dimanfaatkan oleh anggota kelompok yang berjumlah <?php echo $jml_anggota;?> (<?php echo toTerbilang($jml_anggota);?>) orang, dengan rincian sebagai berikut : </p>
		  
		  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="3%" height="34" class="style9 bottom top left">No</th>
              <th width="25%" class="style9 left bottom top">Nama Anggota - N I A</th>
              <th width="2%" class="style9 left bottom top">JK</th>
              <th width="25%" class="style9 left bottom top">Alamat Anggota </th>
              <th width="15%" class="style9 left bottom top right">Alokasi Pinjaman Anggota </th>
        </tr>      
		
<?php 	
		$angg=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$id_pinj' AND alokasi>1");  /* query hitung jumlah anggota */
		$jml_anggota=mysql_num_rows($angg);
		$no=0;
		while($data=mysql_fetch_array($angg)){
		$nia=$data['nia'];
		$alok_anggota=$data['alokasi'];
		
		$anggota=mysql_query("select * from  usaha u, anggota_$_SESSION[kd_kab] a WHERE a.id='$nia' AND a.usaha = u.id  order by namadepan ASC");  /* untuk memunculkan ke tabel tampil */	
		while($row6=mysql_fetch_array($anggota)){
						  
						  $nama_anggota=$row6['namadepan'];
						  $id_anggota=$row6['nik'];
						  $jenis_kelamin=$row6['jk'];
							$usaha=$row6['nama_usaha'];  
						  $tempat_lahir=$row6['tempat_lahir'];
						  $tgl_lahir=$row6['tgl_lahir'];
						  $alamat_anggota=$row6['alamat'];
						  $nomor_hp=$row6['hp'];
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left"><div align="center" ><?php echo $no=$no+1;?></div></td>
              <td class="style9 left top"><?php echo $nama_anggota." - ".$row6['id']; ?></td>
              <td class="style9 left top"><div align="center"><?php echo $jenis_kelamin; ?></div></td>
              <td class="style9 left top"><span class="style9"><?php echo substr($alamat_anggota,0,50);?></span></td>
              <td class="style9 left top right"><div align="right"><?php echo number_format($alok_anggota);?>,-</div></td>
            </tr>
  <?php 
  $sum_anggota=$sum_anggota+$alok_anggota;
  } } ?>
			<tr>
              <td height="33" class="style9 top left bottom" colspan="4"><div align="center" >JUMLAH</div></td>
              <td class="style9 left top bottom right"><div align="right"><?php echo number_format($sum_anggota);?>,-</div></td>
            </tr>
		<!-- Menampilkan Jumlah Total pada tabel -->
</table>
		  
          <p align="justify">Catatan Pencairan :</p>
          <p>&nbsp;</p>
          <p>Demikian, berita acara ini dibuat sekaligus sebagai bukti pencairan dana pinjaman diatas. </p></td>
  </tr>
      <tr>
        <td height="25" class="style9">&nbsp;</td>
        <td height="25" class="style27">&nbsp;</td>
        <td height="25" class="style9">&nbsp;</td>
        <td height="25" class="style27">&nbsp;</td>
      </tr>
</table>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">

      <tr>
        <td class="style9">&nbsp;</td>
        <td width="18%" class="style9">Dicairkan di </td>
        <td width="33%" class="style9">: <?php echo substr($row['wt_cair'],6); ?></td>
      </tr>
      <tr>
        <td class="style9">&nbsp;</td>
        <td class="style9">Pada Tanggal </td>
        <td class="style9">: <?php echo tgl_indo($tgl_cair); ?></td>
      </tr>

 </table>
 <?php include "./tanda_tangan_dokumen.php";?>
<title>6. Berita Acara Pencairan <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>
		<?php } ?>  
</table>
</body>
