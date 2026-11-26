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
			Loan ID. <?php echo "$id_pinj";?>
			I BA</div></td>
	  </tr> 
</table>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		BERITA ACARA PENCAIRAN<br>
		<span class="fw-semi-bold">PINJAMAN INDIVIDU <?php echo $nama_jpp;?></p></td>
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
		Pada hari ini <b> <?php echo "$namahari $pasaran[$mod]";?> </b>tanggal <b><?php echo ucwords(toTerbilang($tanggal));?></b> bulan <b><?php echo $bulan;?></b> tahun <b><?php echo ucwords(toTerbilang($tahun));?></b>, telah diadakan pencairan dana perguliran 
            <?php 
		if ($jenis_pinjaman==1){
				echo "Simpan Pinjam Khusus Perempuan (SPP)";
			}else if ($jenis_pinjaman==2){
				echo "Usaha Ekonomi Produktif (UEP)";
			}
			?> 
          UPK Kecamatan <?php echo $nama_kec; ?> kepada identitas yang telah sidebutkan dibawah ini, dengan pinjaman 
		  sebesar <strong>Rp. <?php echo number_format($alokasi);?>,- (<?php echo ucwords(Toterbilang($alokasi)); ?> Rupiah), </strong>
		  sesuai dengan Register Pinjaman pada Sistem Informasi Manajemen UPK Online nomor : <strong><?php echo $id_pinj;?></strong> dan Surat Perjanjian Kredit (SPK) nomor : <strong><?php echo $row['spk_no'];?></strong></p>
          <p>Adapun detail identitas pemanfaat dan dentitas pinjaman adalah sebagai berikut : </p>
        </div></td>
      </tr>
      <tr>
        <td width="191" height="25" class="style9">1. N I K  </td>
        <td width="349" height="25"><span class="style9">:</span><span class="style27"> <?php echo $row['nik'];  ?></span></td>
        <td width="224" height="25" class="style9">9. Nama Penjamin</td>
        <td width="271" height="25"><span class="style9">:</span><span class="style27"> <?php echo $row['penjamin'];?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">2.  Nama Pemanfaat</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo strtoupper($row['namadepan']);?></span></td>
        <td height="25" class="style9">10. KK/NIK Penjamin </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $row['kk'];?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">3. Jenis Kelamin </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $row['jk'];?></span></td>
        <td height="25" class="style9">11. Hubungan Keluarga </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $row['kekeluargaan'];?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">4. Kelahiran </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $row['tempat_lahir'];?>, <?php echo tgl_ind($row['tgl_lahir']);?></span></td>
        <td height="25" class="style9">12. Jenis Pinjaman</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $nama_jpp;?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">5. Jenis Usaha</td>
        <td height="25"><span class="style9">: </span><span class="style27"><?php echo $jenis_usaha;?></span></td>
        <td height="25" class="style9">13. Tanggal Pencairan</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($tgl_cair); ?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">6. Contact Person</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $row['hp'];?></span></td>
        <td height="25" class="style9">14. Alokasi Pinjaman</td>
        <td height="25"><span class="style9">:</span><span class="style27"> Rp. <?php echo number_format($alokasi);?>,-</span></td>
      </tr>
      <tr>
        <td height="25" class="style9">7. Alamat</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $row['alamat'];?></span></td>
        <td height="25" class="style9">15. Tempo/Sistem </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo "$tempo/$sistem_angsuran";?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">8. <?php echo "$row[sebutan_desa]"; ?> </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $nama_desa;?></span></td>
        <td height="25" class="style9">16. Prosentase Jasa </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo "$pros_jasa % $row[nama_jj]";?> /bulan</span></td>
      </tr>
	  <tr>
        <td height="37" colspan="4" class="style9">
		  <p align="justify">Catatan Pencairan :</p>
          <p>&nbsp;</p>
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
        <td width="33%" class="style9">: <?php echo $nama_desa; ?></td>
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
          <p>Pemanfaat </p>
        </div></td>
      </tr>	
	<tr>
	    <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?></p></th>
        <th colspan="2" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper($row['namadepan']); ?></p></th>
  </tr>
      <tr>
        <td height="20" colspan="-1" class="style9">&nbsp;</td>
        <td colspan="2" class="style9">&nbsp;</td>
      </tr>
      
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
        <td height="19" colspan="3" class="style9">&nbsp;</td>
      </tr>
</table>
<title>6. Berita Acara Pencairan <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>
