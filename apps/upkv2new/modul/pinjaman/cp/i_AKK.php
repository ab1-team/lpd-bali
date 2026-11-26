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
.top  {border-top: 1px solid #000000; }
.bottom {border-bottom: 1px solid #000000; }
.left {border-left: 1px solid #000000; }
.right  {border-right: 1px solid #000000; }
.allborder  {border: 1px solid #000000; }
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
    
                      $id_pinj      =$row['id'];
                      $jenis_pp     =$row['jenis_pp'];
                      $tgl_proposal   =$row['tgl_proposal'];
                      $proposal     =number_format($row['proposal']);
                      $tgl_verifikasi   =$row['tgl_verifikasi'];
                      $jenis_pinjaman =$row['jenis_pinjaman'];
                      
                      $tgl_cair     =$row['tgl_cair'];
                      $tanggal       = substr($tgl_cair,8,2);
                      $bulan         = getBulan(substr($tgl_cair,5,2));
                      $tahun         = substr($tgl_cair,0,4);
                      $alokasi      = number_format($row['alokasi']);
                      $pros_jasa      =$row['pros_jasa'];
                      $jenis_jasa     =$row['jenis_jasa'];
                      $deskripsi_jpp  =$row['deskripsi_jpp'];
                      $nama_jj      =$row['nama_jj'];
                      $jangka       =$row['jangka'];
                      $sistem       =$row['sistem'];
                      $tempo        =$jangka/$sistem;
                      $sistem_angsuran  =$row['nama_sistem'];
                      $lu         =$row['lu'];
                      $status       =$row['status'];
                      $user_id      =$row['user_id'];
                      $dus        =mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
                      $nama_user      =$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
                      
                      $nama_lembaga_sort  =$row ['nama_lembaga_sort'];
                      $nama_lembaga_long  =$row ['nama_lembaga_long'];
                      $lokasi       =$row['lokasi'];
                      $nama_kec     =$row['nama_kec'];
                      $nama_kab     =$row['nama_kab'];
                      $nama_desa      =$row['nama_desa'];
                      $sebutan_desa   =$row['sebutan_desa'];
                      $sebutan_kades    =$row['sebutan_kades'];
                      
                      $ttd_pdua     =$row['ttd_pdua'];
                      $ttd_saksi      =$row['ttd_saksi'];
                      $ttd_mengetahui   =$row['ttd_mengetahui'];
                      $ketuaupk     =mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
                      $ketuabkad      =mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
                      
                      
                      $spk_no       =$row['spk_no'];
                      $nik        =$row['nik'];
                      $namadepan      =$row['namadepan'];
                      $alamat       =$row['alamat'];
                      $telpon       =$row['telpon'];
                      $tempat_lahir   =$row['tempat_lahir'];
                      $tgl_lahir      =$row['tgl_lahir'];
                      $nama_jpp     =$row['nama_jpp'];
                      $jenis_usaha    =$row['nama_usaha'];
                      $jenis_kelamin    =$row['jk'];
                      $nomor_kk     =$row['kk'];
                      $penjamin     =$row['penjamin'];
                      $hubungan     =$row['hubungan'];
                      $lo         =$row['lo'];
                      $hp         =$row['hp'];
                      $uname        =$row['uname'];
                      $pass       =$row['pass'];
                      $tgl_now      =date('Y-m-d');
                      
                      $wajibjasaaja   =wajibjasaaja_anggota($id_pinj);
                      $wajibjasa      =($wajibjasaaja*$sistem);
        
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
			Loan ID. <?php echo "$id_pinj";?></div></td>
	  </tr> 
</table>

<p class="style16">
  <br>ANALISA DAN KEPUTUSAN KREDIT <br>
  <span class="style28">Pinjaman <?php if ($jenis_pinjaman == 'I') {
               echo"Perorangan";
              }elseif ($jenis_pinjaman == 'K') {
                echo "Anggota";
              }?> <?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?><br>
  Nomor : <?php echo "$id_pinj";?> <?php echo "".tgl_rom($tgl_cair)."";?><br>
  KREDIT BARU</span>
</p>

    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      
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
        <td height="25" width="50%" colspan="24" class="style6" align="justify"><span class="style28">I. DATA POKOK PEMINJAM</span>
          <div align="justify">
            <ol class="style9">
              <li>Nama</li>
              <li>Tempat dan Tgl Lahir</li>
              <li>Usia</li>
              <li>Pekerjaan/Dinas/Instansi</li>
              <li>Dinas/Instansi</li>
              <li>Golongan</li> 
              <li>NIK</li>  
              <li>NPWP</li> 
              <li>No HP</li> 
              <li>Alamat:</li> 
              <li>Penjamin(<?php echo $row['kekeluargaan'];?>)</li>

      
      </ol>
      </div>
    </td>

    <td height="25" colspan="24" class="style6" align="justify"><span class="style28" style='color:#ffff;'>.</span>
          <div align="justify">
            <ul class="style9" style="list-style:none;">
              <li>: <?php echo $row['namadepan']; ?></li>
              <li>: <?php echo $row['tempat_lahir'];?>, <?php echo tgl_indo($tgl_lahir);?></li>
              <li>: <?php // Convert Ke Date Time
                    $biday = new DateTime ($tgl_lahir);
                    $today = new DateTime();
                    
                    $diff = $today->diff($biday);
                    echo "". $diff->y ." Tahun"; ?></li>
              <li>: <?php echo $row['nama_usaha']; ?></li>
              <li>: Desa <?php echo $nama_desa; ?></li>
              <li>: </li> 
              <li>: <?php echo $row['nik']; ?></li>  
              <li>:</li> 
              <li>: <?php echo $hp; ?></li> 
              <li>: <?php echo $row['alamat']; ?></li> 
              <li>: <?php echo $row['penjamin']; ?></li> 

      
      </ul>
      </div>
    </td>
    </tr> 

      <tr>
        <td height="25" colspan="24" class="style6" align="justify"><span class="style28">II. PERMOHONAN PINJAMAN</span>
          <div align="justify">
            <ol class="style9">
              <li>Plafond diajukan</li>
              <li>Total Pendapatan Keluarga</li>
              <li>Tunjangan</li>
              <li>Take Home Pay</li>
              <li>Angsuran</li>
              <li>Sisa Penghasilan Setelah Angsuran</li> 
      </ol>
      </div>
    </td>

    <td height="25" colspan="24" class="style6" align="justify"><span class="style28" style='color:#fff;'>.</span>
          <div align="justify">
            <ul class="style9" style="list-style:none;">
              <li>: Rp <?php echo number_format($row['proposal']);?></li>
              <li>:</li>
              <li>:</li>
              <li>:</li>
              <li>:</li>
              <li>:</li> 
      </ul>
      </div>
    </td>
    </tr>

    <tr>
        <td height="25" colspan="24" class="style6" align="justify"><span class="style28">III. PERHITUGAN KREDIT/RATE YANG DIGUNAKAN</span>
          <div align="justify">
            <ol class="style9">
              <li>Suku Bungan Flat Rate</li>
              <li>Jangka Waktu</li>
              <li>Maks. Pemberian pinjaman Sesuai Dinas</li>
      </ol>
      </div>
    </td>

    <td height="25" colspan="24" class="style6" align="justify"><span class="style28" style='color:#fff;'>.</span>
          <div align="justify">
            <ul class="style9" style="list-style:none;">
              <li>: <?php echo $row['nama_sistem']; ?> <?php echo $pros_jasa; ?>% per Bulan</li>
              <li>: <?php echo $jangka; ?> Bulan</li>
              <li>: </li>
      </ul>
      </div>
    </td>
    </tr> 

    <tr>
        <td height="25" colspan="24" class="style6" align="justify"><span class="style28">IV. REKOMENDASI PEMBERIAN KREDIT</span>
    </td>

    <td height="25" colspan="24" class="style6" align="justify"><span class="style28" style='color:#fff;'>.</span>
    </td>
      
    </tr>

    <tr>
        <td colspan="25"align="justify"> <p class="style9" style="margin-left:24px;">Berdasarkan hasil perhitungan tersebut diatas, kami simpulkan bahwa yang bersangkutan dapat dipertimbangkan permohonan kreditnya dengan syarat-syarat berikut :</p>
    </td>

    </tr>

    <tr>
        <td colspan="24" align="justify">
            <ol class="style9">
              <li>Jenis Kredit</li>
              <li>Jenis Peningkatan</li>
              <li>Besar plafon Kredit</li>
              <li>Suku Bunga</li>
              <li>Jangka Waktu</li>
              <li>Angsuran</li> 
              <li>Persentase Angsuran</li>  
              <li>Membayar Biaya-Biaya:
              <ol type="a">
                    <li>Provisi Kredit</li>
                    <li>Premi Asuransi</li>
                    <li>Biaya</li>
                    <li>Pelunasan Kredit Lama</li>
                  </ol></li> 
              <li>Lainnya:
              <ol type="a">
                <li>Nilai Pertanggungan Asuransi</li>
                <li>Rencana Realisasi Hari/Tanggal</li>
              </ol>
              </li> 

      
      </ol>
      </div>
    </td>

    <td colspan="24" class="style6" align="justify"><span class="style28" style='color:#fff;'>.</span>
          <div align="justify">
            <ul class="style9" style="list-style:none;">
              <li>: <?php echo $row['deskripsi_jpp']; ?> <?php if ($jenis_pinjaman == 'I') {
               echo"Perorangan";
              }elseif ($jenis_pinjaman == 'K') {
                echo "Anggota";
              }?>

              </li>
              <li>: Dibawah tangan</li>
              <li>: Rp.<?php echo number_format($row['alokasi']);?></li>
              <li>: <?php echo $row['nama_sistem']; ?> <?php echo $pros_jasa; ?>% per Bulan</li>
              <li>: <?php echo $jangka; ?> Bulan</li>
              <li>:</li> 
              <li>:</li>  
              <li>:</li> 
              <li>:</li> 
              <li>:</li> 
              <li>:</li> 
              <li>:</li>
              <li>:</li> 
              <li>:</li> 
              <li>: <?php echo tgl_indo($tgl_cair); ?></li> 
              <li style="color:#fff">:</li> 
              <li style="color:#fff">:</li> 

      
      </ul>
      </div>
    </td>
    </tr> 
    <tr>
      <td colspan="25">
        <ol start="10" class="style9">
          <li>Syarat lainnya sesuai dengan ketentuan pemberian pinjaman yang berlaku di <?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?></li>
        </ol>
      </td>
    </tr>

</table>
      <br>
      <br>
      <br>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">

   <tr>
        <td width="50%" height="36" colspan="1" class="style26"><div align="center" class="style9">
        <p></p>
          <p>Menyetujui,</p>
        </div></td>
        <td colspan="2" class="style26"><div align="center" class="style9"><?php echo $nama_desa;?>, <?php echo tgl_indo($tgl_cair);?>
        </div></td>
    </tr> 

   <tr>
        <td width="50%" height="36" colspan="1" class="style26"><div align="center" class="style9">
        <p></p>
          <p><?php echo "$row[sebutan_level_1]";?> <?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?> </p>
        </div></td>
        <td colspan="2" class="style26"><div align="center" class="style9">
        </div></td>
    </tr> 
  <tr>
      <th height="24" colspan="1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <?php echo strtoupper($ketuaupk['namadepan']); ?> <?php echo strtoupper($ketuaupk['namabelakang']); ?>
        </th>
        <th colspan="2" class="style9"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
        <?php echo $row['namadepan']; ?> <br>
        </th>
  </tr>


      
      <tr>
        <td height="20" colspan="-1" class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
      </tr>
      
</table>

<title>ANALISA DAN KEPUTUSAN KREDIT <?php echo "$row[namadepan] ($id_pinj)";?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>
