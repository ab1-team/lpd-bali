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
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.sebutan=sd.id AND d.id=k.desa AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
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
											
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$pros_jasa			=$row['pros_jasa'];
											$jangka				=$row['jangka'];
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											
											
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$ttd_pdua			=$row['ttd_pdua'];
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
		
			echo "<div class='style9'>".strtoupper("<b>PEMERINTAH DAERAH KABUPATEN $row[nama_kab] <br> $row[nama_lembaga_long]<br>KECAMATAN $row[nama_kec] </b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>		</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
			Loan ID. <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?>
			 Lembar-1 </div></td>
		  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		SURAT KUASA <br>
		<span class="fw-semi-bold">PENANDATANGANAN SPK</p></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="4" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="style9"><div align="justify">Yang bertanda tangan dibawah ini, anggota kelompok <span class="style27"><?php echo $nama_kelompok;?></span> (<?php echo $nama_jpp; ?>) Desa <span class="style27"><?php echo $nama_desa;?> </span><span class="style9">Kecamatan <span class="style27"><?php echo $nama_kec;?> </span><span class="style9">memberikan kuasa sepenuhnya kepada : </span></span></div></td>
      </tr>
	  <tr>
        <td height="25" class="style9">Nama Lengkap<br>
			Jabatan <br>
			Alamat </td>
        <td height="25" colspan="23" class="style27">: <?php echo $ketua; ?> <br>: Ketua Kelompok <?php echo $nama_kelompok;?>
        <?php echo "$row[sebutan_desa] $nama_desa"; ?>        <br> : <?php echo $alamat_kelompok;?> <?php echo $nama_desa;?></td>
      </tr>
	  <?php if($ttd_pdua=="2") { ?> 
      <tr>
        <td height="25" class="style9">Nama Lengkap<br>
          Jabatan <br>
          Alamat </td>
        <td height="25" colspan="23" class="style27">: <?php echo $sekretaris; ?> <br>
          : Sekretaris Kelompok <?php echo $nama_kelompok;?>
           <?php echo "$row[sebutan_desa] $nama_desa"; ?>          <br>
          : <?php echo $alamat_kelompok;?> <?php echo $nama_desa;?></td>
      </tr>
      <?php } ?>
      
      <tr>
        <td height="24" colspan="4" class="style9"><div align="justify">Untuk bertindak mewakili Kelompok dalam perjanjian kredit dengan <?php echo "$row[nama_lembaga_long] ($row[nama_lembaga_sort])"; ?> Kecamatan <span class="style27"><?php echo $nama_kec;?></span> sesuai dengan registrasi pinjaman nomor  <strong><?php echo $kd_kelompok;?>-<?php echo $id_pinj;?></strong> dan data pinjaman sebagai berikut : </div></td>
      </tr>
      <tr>
        <td height="25" class="style9">Tanggal Pencairan</td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($tgl_cair); ?></span></td>
        <td height="24" class="style9"> Sistem Angsuran </td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo $sistem_angsuran;?></span></td>
      </tr>
      <tr>
        <td height="24" class="style9">Alokasi Pinjaman</td>
        <td height="24"><span class="style9">:</span><span class="style27"> Rp. <?php echo number_format($alokasi,0,'.',',');?>,-</span></td>
        <td height="25" class="style9">Prosentase Jasa </td>
        <td height="25"><span class="style9">:</span><span class="style27"> <?php echo $pros_jasa;?> % per bulan</span></td>
      </tr>
      <tr>
        <td height="24" class="style9">Nomor SPK. </td>
        <td height="25" colspan="3">: <span class="style27"><?php echo $row['spk_no'];?></span></td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="style9">Demikian surat kuasa ini dibuat untuk dapat dilaksanakan sebagaimana mestinya.</td>
      </tr>
      
      <tr>
        <td height="25" colspan="3" class="style9">&nbsp;</td>
        <td height="25" class="style9"><span class="style9"><?php echo $nama_kec;?>, <?php echo tgl_indo($tgl_cair); ?></span></td>
      </tr>
      <tr>
        <td height="25" colspan="4" class="style9">&nbsp;</td>
      </tr>
</table>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="bottom top">
      <tr>	  
          <th width="55" height="34" class="style9 bottom">No</th>
			<th width="158" class="style9 bottom" >N I K </th>
              <th width="316" class="style9 bottom">Nama Anggota <br>selaku Pemberi Kuasa </th>
              <th width="35" class="style9 bottom">JK</th>
              <th width="222" class="style9 bottom">Alamat Anggota </th>
              <th width="235" class="style9 bottom">Tanda Tangan </th>
        </tr>      
		
<?php 	
		$angg=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$id_pinj'");  /* query hitung jumlah anggota */
		$jml_anggota=mysql_num_rows($angg);
		$no=0;
		while($data=mysql_fetch_array($angg)){
		$nia=$data['nia'];
		
		$anggota=mysql_query("select * from anggota_$_SESSION[kd_kab] where id='$nia' order by namadepan ASC");  /* untuk memunculkan ke tabel tampil */	
		while($row6=mysql_fetch_array($anggota)){
						  
						  $nama_anggota=$row6['namadepan'];
						  $id_anggota=$row6['nik'];
						  $jenis_kelamin=$row6['jk'];
						  $tempat_lahir=$row6['tempat_lahir'];
						  $tgl_lahir=$row6['tgl_lahir'];
						  $alamat_anggota=$row6['alamat'];
						  $nomor_hp=$row6['hp'];
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9"><div align="center" ><?php echo $no=$no+1;?></div></td>
              <td class="style9"><div align="center"><?php echo $id_anggota;?></div></td>
              <td class="style9"><?php echo $nama_anggota; ?></td>
              <td class="style9"><div align="center"><?php echo $jenis_kelamin; ?></div></td>
              <td class="style9"><span class="style9"><?php echo $alamat_anggota;?></span></td>
              <td class="style9"><?php echo $no;?>.</td>
            </tr>
  <?php
  } 
  }
  ?>
		<!-- Menampilkan Jumlah Total pada tabel -->
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      

      
     <?php if($ttd_pdua=="1") { ?>    
    <tr>
        <td width="50%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>&nbsp;</p>
          <p>Mengetahui </p>
        </div></td>
        <td class="style26"><div align="center" class="style9">
            <p>Penerima Kuasa,  </p>
        </div></td>
    </tr>	
	<tr>
	    <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?> <br><?php echo "$row[sebutan_level_1] $row[nama_lembaga_sort]";?></p></th>
        <th class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper($ketua); ?><br>
        Ketua Kelompok </p></th>
  </tr>
<?php } else if($ttd_pdua=="2") { ?> 
     <tr>
        <td width="28%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>Mengetahui </p>
        </div></td>
        <td colspan="2" class="style26"><div align="center" class="style9">
            <p>Penerima Kuasa,  </p>
        </div></td>
    </tr>	
	<tr>
	    <th height="24" colspan="-1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?> <br><?php echo "$row[sebutan_level_1] $row[nama_lembaga_sort]";?></p></th>
        <th width="15%" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper($ketua); ?><br>
        Ketua Kelompok </p></th>
        <th width="15%" class="style9"><p>&nbsp;</p>
          <p>&nbsp;</p>
        <?php echo strtoupper($sekretaris); ?> <br>
        Sekretaris Kelompok </th>
  </tr>
<?php } ?> 

</table>
<title>3. Surat Kuasa <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>
