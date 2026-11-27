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
-->
</style>
<body onLoad="window.print()">

     	    <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=k.desa  AND sd.id=d.sebutan AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
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
											$angg=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$id_pinj'");  /* query hitung jumlah anggota */
											$jml_anggota=mysql_num_rows($angg);
		
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
											
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$sebutan_kec		=$row['sebutan_kec'];
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
    			<td height="20" colspan="2" class="bottom" width="9%">
    				<div class="style9 text-align-left"><?php
                        $logo=$row['logo'];
                          if (empty($logo)) {
                            echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
                            }else{
                            echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
                            }
                            echo "</td>";
                            echo"<td class='bottom'>";
                                      
                      $nomor_bh =$row ['nomor_bh'];
                      if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
                    
                      echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$sebutan_kec $row[nama_kec] KABUPATEN $row[nama_kab] </b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
                      ?>      
    				</div>
    			</td>
    			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Proposal<br>
			Loan ID. <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?></div></td>
    	  </tr> 
    </table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td height="20" colspan="3" class="bottom"><p align="center" class="style6">
		BERITA ACARA PERTEMUAN<br>
		<span class="fw-semi-bold">KELOMPOK <?php echo strtoupper("$row[deskripsi_jpp] ($nama_jpp)");?></p></td>
      </tr>
      
      
      <tr>
        <td height="30" colspan="3" class="style9">&nbsp;</td>
      </tr>
	  <tr>
        <td height="81" colspan="3" class="style9"><div align="justify">
          <p> Sehubungan dengan rencana kelompok mengajukan pinjaman kepada <?php echo "$row[nama_lembaga_long] $row[sebutan_kec] $row[nama_kec]";?>, maka 
		  pada hari ini<strong> ____________ </strong>tanggal<strong> _____ </strong>bulan<strong> _____________ </strong>tahun<strong> ________ </strong>, bertempat di  <?php echo $alamat_kelompok; ?>, nama kelompok  <b><?php echo $nama_kelompok;?> </b> <?php echo "$row[sebutan_desa] $nama_desa"; ?> <?php echo "$sebutan_kec $nama_kec";?> telah  diselenggarakan  musyawarah kelompok yang dihadiri oleh anggota kelompok dan unsur lain yang terkait di desa sebagaimana tercantum dalam daftar hadir terlampir.
		  <br>Adapun materi atau topik yang dibahas dalam musyawarah ini adalah sebagai berikut : </br>
          <ol type="a">
          <li>Jumlah anggota peminjam dan besar pinjaman yang diajukan</li>
          <li>Penetapan bunga pinjaman kepada anggota</li>
          <li>Rencana penggunaan selisih angsuran bunga</li>
          <li>Sanksi kelompok bagi anggota peminjam yang menunggak</li></ol></p>
		  
		  <p align="justify" style="line-height: 1.5;">Acara Musyawarah dipimpin oleh : <?php echo $ketua;?> <br>
          Notulen &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: <?php echo $sekretaris;?>
          <br>Narasumber &nbsp; &nbsp;:
          <ul>
              <li>______________________________</li><br>
              <li>______________________________</li>
          </ul>
          </p>
          
          <p>Setelah dilakukan diskusi dan musyawarah terhadap topik di atas, peserta memutuskan dan telah menyepakati sebagai berikut :</p>
          <ol type="a">
              <li>Forum menyepakati jumlah anggota kelompok yang akan mengajukan pinjaman yaitu <?php echo $jml_anggota;?> orang 
                    <br>dan besar pinjaman yang akan diajukan kepada <?php echo "$row[nama_lembaga_sort]";?> sebesar Rp <?php echo number_format($proposal);?>,-</li>
              <li>Forum menyepakati anggota kelompok wajib mengangsur setiap <?php echo $sistem_angsuran;?> sesuai dengan jumlah pinjaman yang diterima dan tanggal yang telah disepakati.</li>
              <li>Forum menyepakati bunga pinjaman yang akan diberlakukan kepada anggota kelompok sebesar <?php echo $pros_jasa;?> % setiap bulan dalam <?php echo $jangka;?> bulan.</li>
              <li>Forum menyepakati penggunaan selisih angsuran bunga ke <?php echo "$row[nama_lembaga_sort]";?> akan digunakan untuk :
              <ol type="1">
                  <li>Honor Pengurus</li>
                  <li>Transport Pengurus</li>
                  <li>ATK Kelompok</li>
              </ol></li>
              <li>Forum menyepakati besar tabungan beku tanggung renteng yaitu _____ % dan tabungan beku tanggung renteng tersebut akan disimpan di Rekening Bank.</li>
              <li>Forum menyepakati aturan dan sanksi kelompok bila anggota menunggak, yaitu : 
              <br> Aturan : 
              <ol>
                  <li>Setiap Kelompok harus membuat proposal sesuai petunjuk</li>
                  <li>Proposal Wajib melampirkan KK dan KTP.</li>
                  <li>Setiap peminjam wajib melunasi pinjamannya sesuai dengan jangka waktu yang disepakati atau diperjanjikan angsuran pokok beserta bunganya</li>
                  <li>Setiap peminjam wajib menyimpan dana pada rekening tabungan beku atau tanggung renteng kelompok sebesar ____ % dari besar pinjamannya</li>
                  <li>Apabila peminjam meninggal dunia dan masih memiliki sisa angsuran, maka sisa angsuran tersebut harus dilunasi oleh Ahli Warisnya atau oleh pribadi yang menandatangani pada surat pernyataann persetujuan pinjaman</li>
                  
              </ol></li>
              <p>Sanksi :</p>
              <ol>
                  <li>Apabila peminjam tidak menyerahkan jaminannya, maka pinjaman kepada yang bersangkutan tidak dapat direalisasikan.</li>
                  <li>Apabila nilai jaminan pinjaman tidak sesuai dengan ketentuan, maka pinjaman tidak dapat direalisasikan.</li>
                  <li>Apabila peminjam tidak melunasi pinjamannya, maka yang bersangkutan akan diberi peringatan dan atau dilakukan proses hukum yang berlaku. Jika ahli waris atau penanggung jawab adalah warga yang tidak mampu, maka bisa mengajukan permohonan Penghapusan Pinjaman sesuai dengan aturan yang berlaku di <?php echo "$row[nama_lembaga_long] $row[sebutan_kec] $row[nama_kec]";?>.</li>
              </ol>
          <p>Keputusan di atas disepakati dengan cara musyawarah mukafat / voting.</p>
          
		  <p>Demikian berita acara ini  kami buat dengan sebenar-benarnya dan atas dasar musyawarah kelompok agar dapat dipergunakan sebagaimana mestinya.</p>
		  <p>Mengetahui dan menyetujui</p>
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

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      
      <tr>
        <td  colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td class="style9">&nbsp;</td>
        <td colspan="2" class="style9"><?php echo $nama_desa; ?>, _______________________________________ </td>
      </tr>
      <tr>
        <td class="style9">&nbsp;</td>
        <td width="18%" class="style9">&nbsp;</td>
        <td width="33%" class="style9">&nbsp;</td>
      </tr>
      

      <tr>
        <td width="49%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>Ketua Kelompok</p>
        </div></td>
        <td colspan="2" class="style26"><div align="center" class="style9">
          <p>Sekretaris Kelompok </p>
        </div></td>
      </tr>	
	<tr>
	    <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper($ketua); ?></p></th>
        <th colspan="2" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper($sekretaris); ?></p></th>
  </tr>
      <tr>
        <td height="20" colspan="-1" class="style9">&nbsp;</td>
        <td colspan="2" class="style9">&nbsp;</td>
      </tr>
      
      <tr>
        <td height="19" colspan="3" class="style9">&nbsp;</td>
      </tr>
</table>
<div style="page-break-after: always;">
</div>
<title>Berita Acara Pertemuan <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> <?php echo "$row[sebutan_desa] $nama_desa";?></title>
<?php } ?>        
</body>
