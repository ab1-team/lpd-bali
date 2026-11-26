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
                      $tgl_tunggu = $row['tgl_tunggu'];
                      $proposal     =$row['proposal'];
                      $tgl_verifikasi   =$row['tgl_verifikasi'];
                      
                      $tgl_cair     =$row['tgl_cair'];
                      $tanggal       = substr($tgl_cair,8,2);
                      $bulan         = getBulan(substr($tgl_cair,5,2));
                      $tahun         = substr($tgl_cair,0,4);
                      $alokasi      =$row['alokasi'];
                      $pros_jasa      =$row['pros_jasa'];
                      $jenis_jasa     =$row['jenis_jasa'];
                      $nama_jj      =$row['nama_jj'];
                      $jangka       =$row['jangka'];
                      $sistem       =$row['sistem'];
                      $tempo        =$jangka/$sistem;
                      $sistem_angsuran  =$row['nama_sistem'];
                      $lu         =$row['lu'];
                      $status       =$row['status'];
                      $user_id      =$row['user_id'];
                      $dus        =mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
                      $nama_user      =$dus['namadepan']. " " .$dus['namabelakang']."";
                      $level = $dus['nama_level'];
                      $jabatan = $dus['nama_jabatan'];
                      
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
                        echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:70; margin-right:5px;'>";
                        }else{
                        echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:70; margin-right:5px;'>";
                        }
                                  
                  $nomor_bh =$row ['nomor_bh'];
                  if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
                
                  echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] KABUPATEN $row[nama_kab]  </b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
                  ?>      
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
			Loan ID. <?php echo "$id_pinj";?></div></td>
	  </tr> 
</table>

<p class="style16">
  <br><u>SURAT PEMBERITAHUAN PERSETUJUAN KREDIT (SP2K)</u> <br>
 
</p>
<hr width="97%" align="center">

    <table width="94%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-left:28px;">
      
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
        <td height="25" width="6%" colspan="26" class="style6" align="justify">
          <div align="justify">
            <ul class="style9" style="list-style:none; margin:0; padding:0;">
              <li>Nomor</li>
              <li>Sifat</li>
              <li>Lampiran</li>
              <li>Perihal</li>
      </ul>
      </div>
    </td>

    <td height="25" colspan="26" class="style6" align="justify">
          <div align="justify">
            <ul class="style9" style="list-style:none; margin:0; padding:0;">
              <li>: <?php echo $id_pinj; ?>/<?php echo $nama_lembaga_sort; ?><?php echo "".tgl_rom($tgl_tunggu)."";?></li>
              <li>: Penting</li>
              <li>: </li>
              <li>: Surat Persetujuan Perjanjian Kredit (SP2K)</li>
      </ul>
      </div>
    </td>

    </tr> 


      <tr>
        <td height="25" colspan="26"  class="style6" align="justify">
          <div align="justify">
            
      </div>
    </td>

    <td height="25" colspan="26"  class="style6" align="justify">
          <div align="justify">
          <ul class="style9" style="list-style:none; padding:0; margin-left:8px; ">
              <li style='color:#fff;'>.</li>
              <li style='color:#fff;'>.</li>
              <li>Kepada Yth. 
              </li>
              
      </ul>
            <ul class="style9" style="list-style:none; padding:0;  margin-left:8px;">
              	<li><?php echo $namadepan; ?></li>
              	<li><?php echo $alamat; ?></li>
              	<li><?php echo $nama_kab; ?></li>
              </ul>
      </div>
    </td>
    </tr>
    <tr>
    	<td height="25" colspan="26"  class="style6" align="justify">
    	</td>


        <td colspan="26"align="justify"> <p class="style9" style="margin-left:8px;">Dengan ini diberitahukan bahwa sesuai dengan surat permohonan kredit saudara dan setelah diadakan verifikasi serta penilaian, maka <?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?> menyetujui permohonan tersebut dengan ketentuan dan syarat- syarat sebagai berikut:</p>
    </td>
    </tr>

    </tr> 


      <tr>
        <td height="25" colspan="26"  class="style6" align="justify">
          <div align="justify">
            
      </div>
    </td>

    <td colspan="25" height="25" width="27%"  class="style6" align="justify">
          <div align="justify">
          <ul class="style9" style="list-style:none; padding:0; margin-left:8px; ">
              <li>Fasilitas Kredit 
              </li>
              
      </ul>
            <ol class="style9" style="margin-bottom:0px;">
              	<li>Jumlah Plafon Kredit</li>
              	<li>Jangka Waktu Kredit</li>
              	<li>Jenis kredit</li>
              	<li>Tujuan Kredit</li>
              	<li>Suku Jasa Kredit</li>
              	<li>Provisi Kredit</li>
              	<li>Cara Penarikan</li>
              	<li>Cara Pembayaran</li>
              	<li style="color:#fff;">hidden</li>
              	<li>Cara Pengikat Kredit</li>
              	<li>Syarat Lainnya</li>
              </ol>
      </div>
    </td>

    <td  colspan="24" height="25" class="style6" align="justify" >
    	<div align="justify">
    	          <ul class="style9" style="list-style:none; padding:0; margin-left:8px; color:#fff; ">
              <li>hidden
              </li>
              
      </ul>
    	<ul class="style9" style="list-style:none; padding:0; margin-bottom:0px;">
              <li>: Rp. <?php echo number_format($alokasi);?></li>
              <li>: <?php echo $jangka;?></li>
              <li>: <?php echo $jenis_pp;?></li>
              <li>: -</li>
              <li>: <?php echo $pros_jasa; ?> %/Bulan</li>
              <li>: Rp.
                      <?php if($_SESSION['lokasi']=='125' OR $_SESSION['lokasi']=='128') { ?>
                      <?php }elseif($_SESSION['lokasi']=='128' or $_SESSION['lokasi']=='134' ) { ?>
                      <?php echo number_format($alokasi/100*0.5);}
                      elseif($_SESSION['lokasi']=='196') {
                      echo number_format($alokasi/100*3);
                      }else{ ?>
                        <?php echo number_format($alokasi/100*1);?>
                      <?php  } ?>
                       </li>
              <li>: Sekaligus</li>
              <li>: Pokok dan jasa diangsur sesuai tabel rencana angsuran sebagai bagian yang </li>
              <li>  <a style="color:#fff;">lll</a>tidak terpisahkan dari surat perjanjian kredit(SPK)</li>
              <li>: Dibawah tanda tangan</li>
              <li>: </li>
      </ul>
    	</div>
    </td>
    </tr>

    <tr>
        <td colspan="26"  class="style6" align="justify">
          <div align="justify">
            
      </div>
    </td>

    <td  colspan="27" width="27%"  class="style6" align="justify">
          <div align="justify"> 
          <ol class="style9" type="a" style="margin-left:15px;" >
          	<li>Suami/Istri turut menandatangani SPK dan diikat dengan penanggung.</li>
          	<li>Tidak memberi imbalan dalam bentuk uang, barang, fasilitas lainnya kepada petugas.</li>
          </ol>
          </td>
    </tr>

    <tr>
        <td colspan="26"  class="style6" align="justify">
          <div align="justify">
            
      </div>
    </td>

    <td  colspan="27" width="27%"  class="style6" align="justify">
          <div align="justify"> 
          <p class="style9" style="margin-left:8px;">Sebagai tanda persetujuan saudara, harap surat SP2K ini  ditanda tangani diatas materai <?php if($tgl_cair<=2020-12-31){echo " Rp. 6.000,-";}else{echo " Rp. 10.000,-";}?> dan diserahkan kembali kepada <?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?> paling lambat dalam waktu 1 (Satu) hari sebelum tanggal pencairan.</p>
          </td>
    </tr>

    <tr>
        <td colspan="26"  class="style6" align="justify">
          <div align="justify">
            
      </div>
    </td>

    <td  colspan="27" width="27%"  class="style6" align="justify">
          <div align="justify"> 
          <p class="style9" style="margin-left:8px;">Demikian agar saudara maklum</p>
          </td>
    </tr>   
</table>
<br>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
   <tr>
        <td width="50%" height="20" colspan="1" class="style26"><div align="center" class="style9">
          <p></p>
        </div></td>
        <td colspan="2" class="style26"><div align="center" class="style9"> <?php echo $nama_kec;?>, <?php echo tgl_indo($tgl_tunggu);?>
        </div></td>
    </tr> 
    
   <tr>
        <td width="50%" height="20" colspan="1" class="style26"><div align="center" class="style9">
          <p>Calon Debitur, </p>
        </div></td>
        <td colspan="2" class="style26"><div align="center" class="style9">
        </div></td>
    </tr> 
  <tr>
      <th height="24" colspan="1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
      
        <?php echo $namadepan; ?>
        </th>
        <th colspan="2" class="style9"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
        <u><?php echo strtoupper($ketuaupk['namadepan']); ?> <?php echo strtoupper($ketuaupk['namabelakang']); ?></u> <br>
       <div style="font-weight:normal;"><?php echo "$row[sebutan_level_1]";?></div>

        </th>
  </tr>


      

</table>

<title>Surat Persetujuan Perjanjian Kredit (SP2K)<?php echo "$row[namadepan] ($id_pinj)";?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>
