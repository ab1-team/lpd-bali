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
											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
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
											$sebutan_kec		=$row['sebutan_kec'];
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
											$lo					=$row['lo'];
											$uname				=$row['uname'];
											$pass				=$row['pass'];
											$id_user			=$row['namadepan']. " " .$row['namabelakang'];
											$tgl_now			=date('Y-m-d');
				
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
		
			echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$sebutan_kec $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>
			</td>
			<td height="20" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
			Loan ID. <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?>
			 </div></td>
  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		BERITA ACARA MUSYAWARAH<br>
		<span class="fw-semi-bold">PINJAMAN KELOMPOK <?php echo strtoupper($nama_kelompok);?></p></td>
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
		Pada hari ini <b> <?php if ($kd_prov == '5') {
                          echo"$namahari";
                          } elseif ($kd_prov == '4') {
                            echo"$namahari";
                          }
                          else{
                          echo "$namahari $pasaran[$mod]";
                          } ?> </b>tanggal <b><?php echo ucwords(toTerbilang($tanggal));?></b> bulan <b><?php echo $bulan;?></b> tahun <b><?php echo ucwords(toTerbilang($tahun));?></b>, telah diselenggarakan musyawarah kelompok yang dihadiri oleh anggota kelompok  
            <?php 
		if ($jenis_pinjaman==1){
				echo "Simpan Pinjam Khusus Perempuan (SPP)";
			}else if ($jenis_pinjaman==2){
				echo "Usaha Ekonomi Produktif (UEP)";
			}
			?> 
          <?php echo "$row[nama_lembaga_long] ($row[nama_lembaga_sort])"; ?> <?php echo "$sebutan_kec $nama_kec";?> kepada Kelompok <?php echo $nama_kelompok;?> <?php echo "$row[sebutan_desa] $nama_desa"; ?> 
        <?php echo "$sebutan_kec $nama_kec";?>, sebesar <strong>Rp. <?php echo number_format($alokasi);?>,- (<?php echo ucwords(Toterbilang($alokasi)); ?> Rupiah), </strong>sesuai dengan Register Pinjaman pada Sistem Informasi Manajemen UPK Online nomor : <strong><?php echo $kd_kelompok;?>-<?php echo $id_pinj;?></strong> dan Surat Perjanjian Kredit (SPK) nomor : <strong><?php echo $row['spk_no'];?></strong></p>
         
         
         <p style="line-height: 1.5;">Adapun materi atau topik yang dibahas dalam musyawarah ini adalah sebagai berikut : <br>
          a. Jumlah anggota peminjam dan besar pinjaman yang diajukan<br>
          b. Penetapan bunga pinjaman kepada anggota<br>
          c. Rencana penggunaan selisih angsuran bunga<br>
          d. Rencana pembukaan rekening tabungan beku tanggung renteng<br>
          e. Sanksi kelompok bagi anggota peminjam yang menunggak</p> 
        </div></td>
      </tr>
      
       <tr>
        <td colspan="4" class="style9">
          <p align="justify" style="line-height: 1.5;">Acara Musyawarah dipimpin oleh : <?php echo $ketua;?> <br>
          Notulen                        : <?php echo $sekretaris;?></p>
		  <p align="justify" style="line-height: 1.5;">Dari pinjaman tersebut akan dimanfaatkan oleh anggota kelompok yang berjumlah <?php echo $jml_anggota;?> (<?php echo toTerbilang($jml_anggota);?>) orang, dengan rincian sebagai mana disebutkan pada tanda terima pinjaman yang merupakan bagian yang tidak terpisahkan dari berita acara ini.
          </p>
          <table border="0">
              <tr>
                <td height="18" colspan="4" ><p align="left" class="style9">Setelah dilakukan diskusi dan musyawarah terhadap topik di atas, peserta memutuskan dan telah menyepakati sebagai berikut : </td>
            </tr>
            <tr>
                <td height="18" colspan="4" ><p align="left" class="style9">a. Forum menyepakati pengajuan pinjaman kelompok, adapun rinciannya adalah :  </td>
            </tr>
            <tr>
                <td width="35%" height="18" class="style9">Alokasi Pinjaman</td>
                <td width="350%" height="18"><span class="style9">: Rp. </span><span class="style9"><?php echo number_format($alokasi);?>,-</span></td>
            </tr>
            <tr>
                <td height="18" class="style9">Jumlah Anggota</td>
                <td height="18" class="style9">: <span class="style9"> <?php echo $jum_anggota;?> Orang</span></td>
            </tr>
            <tr>
                <td height="18" class="style9">Tempo/Sistem</td>
                <td height="18"><span class="style9">:</span><span class="style9"> <span class="style9"> <?php echo $jangka;?> / <?php echo $sistem_angsuran;?> </span></span></td>
            </tr>
            <tr>
                <td height="18" class="style9">Prosentase Jasa</td>
                <td height="18"><span class="style9">:</span><span class="style9"> <span class="style9"> <?php echo $pros_jasa;?> %</span></span></td>
            </tr>
	       </table>
	       <table border="0">
             
            <tr>
                <td height="18" colspan="4" ><p align="left" class="style9">b. Forum menyepakati penggunaan selisih angsuran bunga ke UPK akan digunakan untuk : 
                <ol><li class="style9"> aaahahah</li></td>
            </tr>
            <tr>
                <td width="40%" height="18" class="style9">1. Honor Pengurus</td>
                
            </tr>
            <tr>
                <td height="18" class="style9">2. Transport Pengurus</td>
                
            </tr>
            <tr>
                <td height="18" class="style9">3. ATK Kelompok</td>
                
            </tr>
            
	       </table>
	       
          <p align="justify" style="line-height: 1.5;">c. Forum menyepakati besar tabungan beku tanggung renteng, yaitu 10 % dan tabungan beku tanggung renteng tersebut akan disimpan di Rekening Bank.</p>
          <table border="0">
             
            <tr>
                <td height="18" colspan="4" ><p align="left" class="style9">d. Forum menyepakati aturan dan sanksi kelompok bila anggota menunggak, yaitu :</td>
            </tr>
            <tr>
                <td height="18" colspan="4" ><p align="left" class="style9">Aturan : </td>
            </tr>
            <tr>
                <td>
                    <ol><li class="style9"> Setiap kelompok harus membuat proposal sesuai petunjuk </li>
                    <li class="style9"> Wajib melaporkan KK & KTP pada Proposal</li>
                    <li class="style9"> Setiap peminjam wajib melunasi pinjamannya sesuai dengan jangka waktu yang disepakati atau diperjanjikan pokok beserta bunganya.</li>
                    <li class="style9"> Setiap peminjam wajib menyimpan dana pada rekening tabungan beku/ tanggung renteng kelompok sebesar 10 % dari alokasi pinjamannya.</li>
                    <li class="style9"> Apabila Peminjam meninggal dunia dan masih memiliki sisa angsuran tersebut harus dilunasi oleh ahli warisnya yang menandatangani pada surat pernyataan persetujuan pinjaman.</li>
                    <li class="style9"></li>
                    </td>
            </tr>
            <tr>
                <td width="40%" height="18" class="style9">1. </td>
                
            </tr>
            
	       </table>
          <p align="justify" style="line-height: 1.5;">Catatan Pencairan :</p>
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

      

      <tr>
        <td width="49%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p><?php echo "$row[sebutan_level_1] <br>$row[nama_lembaga_sort]";?> </p>
        </div></td>
        <td colspan="2" class="style26"><div align="center" class="style9">
          <p>Ketua Kelompok </p>
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
      <tr>
        <td height="20" colspan="-1" class="style9">&nbsp;</td>
        <td colspan="2" class="style9">&nbsp;</td>
      </tr>
	  <!------------------------------------------------------>
      <?php
	  if($_SESSION['lokasi']=='204'){ ?>
		  <tr>
        <td class="style9" colspan="3"><p>&nbsp;</p></td>
      </tr>
	  <?php
	  }
	  else{
	  ?>
	  <!------------------------------------------------------------->
      <?php if($ttd_mengetahui=="1") { ?> 	  
      <tr>
        <td class="style9" colspan="3"><div align="center">Mengetahui,<br><?php echo "$row[sebutan_kades] $nama_desa"; ?>
        </div></td>
      </tr>
      <tr>
        <td class="style9" colspan="3"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><b><?php echo strtoupper($row['kades']);?></b> <?php if(!empty($row['nip']) or $row['nip']>0) { echo "<b>$row[pangkat]</b> <br> NIP. $row[nip]"; }else{echo"<br><br>";}?></p></div></td>
      </tr>
<?php } else if($ttd_mengetahui=="2") { ?> 	  
      <tr>
        <td class="style9" colspan="3"><div align="center">Mengetahui,<br>Ketua <?php echo $nama_bkad_sort; ?> <?php echo "$sebutan_kec $nama_kec";?>
        </div></td>
      </tr>
      <tr>
        <td class="style9" colspan="3"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><b><?php echo strtoupper("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><b></p></div></td>
      </tr>
<?php } else if($ttd_mengetahui=="3") { ?>
      <tr>
        <td height="20" colspan="3" class="style9"><div align="center">Mengetahui,</div></td>
      </tr>
      <tr>
        <td class="style9"><div align="center"><?php if($_SESSION['lokasi']=="103") { echo "Ketua DAPM $sebutan_kec $nama_kec"; } else{ echo "Ketua $nama_bkad_sort $sebutan_kec $nama_kec"; } ?></div></td>
        <td class="style9" colspan="2"><div align="center"><?php echo "$row[sebutan_kades]<br>$nama_desa"; ?>
        </div></td>
      </tr>
      <tr>
        <th class="style9"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><?php echo strtoupper("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?><br>&nbsp;<br>&nbsp;</p></th>
        <td class="style9" colspan="2"><div align="center"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><b><?php echo strtoupper($row['kades']);?></b> <?php if(!empty($row['nip']) or $row['nip']>0) { echo "<br><b>$row[pangkat]</b> <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></p></div></td>
      </tr>
<?php } else if($ttd_mengetahui=="4") { ?>
      <tr>
        <td>&nbsp;</td>
      </tr>
<?php } ?>
      
      <tr>
        <td height="19" colspan="3" class="style9">&nbsp;</td>
      </tr>
</table>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td height="20" colspan="3" class="bottom"><p align="center" class="style6">
		BERITA ACARA PERTEMUAN<br>
		<span class="fw-semi-bold">KELOMPOK <?php echo strtoupper("$row[deskripsi_jpp] ($nama_jpp)");?></p></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="3" class="style9">&nbsp;</td>
      </tr>
	  <tr>
        <td height="81" colspan="3" class="style9"><div align="justify">
          <p>
		  Pada hari ini<strong> ____________ </strong>tanggal<strong> _____ </strong>bulan<strong> _____________ </strong>tahun<strong> ________ </strong>, bertempat di <?php echo $alamat_kelompok; ?>, Kelompok  <?php echo $nama_kelompok;?> <?php echo "$row[sebutan_desa] $nama_desa"; ?> <?php echo "$sebutan_kec $nama_kec";?> telah  melakukan pertemuan kelompok dan menghasilkan kesepakatan sebagai berikut : 
		  <ol class="style9">
              <li>Pengurus  kelompok (Pembentukan / Penetapan*)
                <ul>
                  <li>Ketua : <?php echo $ketua;?></li>
                  <li>Sekretaris : <?php echo $sekretaris;?></li>
                  <li>Bendahara : <?php echo $bendahara;?></li>
                </ul>
              </li>
              <?php if ($_SESSION['lokasi']=='216') { ?>

              <?php }else {?>
              	<li>Seluruh  anggota kelompok bersedia menabung di kelompok berupa <?php if($_SESSION['lokasi']=="301"){echo "Tabungan sebesar  Rp. &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;,-";}else{?>simpanan Pokok sebesar  Rp. &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;,- dan simpanan Wajib sebesar Rp. &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;,- <?php } ?>setiap Bulan <em>(diisi jika kelompok baru dan atau  mengaktifkan kembali/evaluasi simpanan kelompok);</em></li>
              <?php }?>
              <li>Seluruh  Anggota Kelompok Sepakat untuk mengajukan Proposal Pinjaman <?php echo $nama_jpp;?> ke <?php echo "$row[nama_lembaga_sort]";?> dengan  Daftar Anggota Pemanfaat dan Besaran Pinjaman <em>(Terlampir).</em></li>
		      <li>_</li>
          </ol>
		  <p>&nbsp;</p>
		  <p>&nbsp;</p>
		  <p>&nbsp;</p>
		  <p>Demikian berita acara ini  kami buat dengan sebenar-benarnya dan atas dasar musyawarah kelompok agar dapat  dipergunakan sebagaimana mestinya.</p>
		  <p>Wakil  Anggota/Peserta Musyawarah : </p>
        </div></td>
      </tr>
	  
      <tr>
        <td height="25" class="style9"><p>Nama Lengkap </p>
          <p>1. ______________________________________________</p>
          <p>2.  ______________________________________________</p>
        <p>3. ______________________________________________</p>
        <p>4. ______________________________________________</p></td>
        <td width="21%" height="25" class="style9"><p>Tanda Tangan </p>
          <p>1._______________________</p>
          <p>&nbsp;</p>
        <p>3._______________________</p>
        <p>&nbsp;</p></td>
        <td width="29%" height="25" class="style9"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>2._______________________</p>
          <p>&nbsp;</p>
        <p>4._______________________</p></td>
      </tr>
</table>
<title>6. Berita Acara Pencairan <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>
		<?php }} ?>        
</body>
