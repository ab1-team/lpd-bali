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
.style57{font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; font-color:#222}
.align-right {text-align:right; }
.all	{border: 1px solid #000000; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
-->
</style>
<body onLoad="window.print()">

     	    <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, sebutan_desa sd, desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND sd.id=d.sebutan AND d.id=k.desa AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
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
											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
											$jangka				=$row['jangka'];
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											$nama_ket_upk		=$dus['namadepan']. " " .$dus['namabelakang'];
											$nik_ket_upk		=$dus['nik'];
											$lokasi				=$row['lokasi'];
											$nama_kab			=$row['nama_kab'];
											$nama_kec			=$row['nama_kec'];
											$sebutan_kec		=$row['sebutan_kec'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$nama_desa			=$row['nama_desa'];
											$nip_kades			=$row['nip'];
											$pangkat			=$row['pangkat'];
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
											
											$desa			=$row['desa'];
											
											if($status='P') {$tanggal=$tgl_proposal;}else{$tanggal=$tgl_cair;}



				
			?>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td width="70%" height="20" class="bottom">
				<?php
				$logo=$row['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:70; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:70; margin-right:5px;'>";
						}
											
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>PEMERINTAH DAERAH KABUPATEN $row[nama_kab] <br> $row[nama_lembaga_long]<br>$sebutan_kec $row[nama_kec] </b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
			?>		</td>
			<td width="30%" height="20" class="bottom"><div align="right" class="style9">Dokumen Proposal<br>
			Loan ID. <?php echo $id_pinj;?>
			 Lamp-5 </div></td>
  </tr> 	  
      

      <tr>
        <td height="20" colspan="2" class="bottom"><p align="center" class="style6">SURAT  PERNYATAAN<br>
		<span class="fw-semi-bold">TANGGUNG RENTENG DAN PERNYATAAN</span><br>TABUNGAN KELOMPOK</p></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="2" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="2" class="style9 align-justify"><p><span class="style9">Yang  bertanda tangan di bawah ini, kami para anggota Kelompok <span class="style27"><?php echo $nama_kelompok;?></span> alamat <span class="style27"><?php echo $alamat;?></span> <span class="style27"><?php echo "$row[sebutan_desa] $nama_desa";?></span> </span><?php echo $row['sebutan_kec']; ?> <?php echo $nama_kec; ?> Kabupaten <?php echo $nama_kab;?>, masing-masing dalam kedudukan sebagai pribadi  anggota kelompok, secara sadar dan penuh tanggung jawab menyatakan kesanggupan  untuk saling menanggung kewajiban dari anggota kelompok yang tidak dapat  membayar kembali pinjaman kepada <?php echo "$row[nama_lembaga_sort]";?> &nbsp;sebagaimana diperjanjikan dengan cara:
		</p>
          <ol class="style9 align-justify">
              <li>Memberikan  kewenangan kepada <?php echo "$row[nama_lembaga_sort]";?> dan pengurus kelompok untuk membekukan dan  mencairkan tabungan para anggota kelompok yang menunggak sebesar kekurangan  angsuran pokok dan bunga pada saat jatuh tempo angsuran;</li>
              <li>Memberikan  kewenangan kepada <?php echo "$row[nama_lembaga_sort]";?> dan pengurus kelompok untuk membekukan dan  membayarkan seluruh tabungan kelompok guna menutup sisa kewajiban pokok dan  bunga kredit <?php echo "$row[nama_lembaga_sort]";?>  yang telah jatuh tempo pelunasannya;</li>
              <li>Apabila  tabungan kelompok pada poin 1 dan 2 tidak mencukupi untuk melunasi sisa pokok  dan bunga kredit <?php echo "$row[nama_lembaga_sort]";?> yang telah jatuh tempo pelunasannya, maka:
                <ul>
                  <li>Ketua  atau pengurus kelompok akan menjual jaminan anggota-anggota yang tidak memenuhi  kewajiban tersebut dan akan memperhitungkan hasilnya untuk melunasi sisa pokok  dan bunga kredit. Kelebihan dari jumlah tersebut akan dikembalikan kepada  masing-masing yang bersangkutan;</li>
                  <li>Apabila  anggota penunggak tidak memiliki jaminan atau hasil penjualan tersebut tidak  mencukupi untuk melunasi sisa pokok dan bunga kredit, maka setiap anggota  kelompok diwajibkan untuk membayar sama banyaknya sisa kewajiban tersebut. Ketua  atau pengurus kelompok bertanggung jawab atas kelancaran penyetoran ini sesuai dengan  batas waktu yang telah disepakati dengan pihak <?php echo "$row[nama_lembaga_sort]";?>.</li>
                </ul>
              </li>
          </ol>
		<p>Demikian surat pernyataan kesanggupan  tanggung renteng ini dibuat secara sadar dan penuh tanggung jawab untuk  dipergunakan sebagaimana mestinya.</p></td>
      </tr>
      <tr>
        <td height="25" class="style9">Anggota Kelompok : </td>
        <td height="25" class="style9"><div align="right"><span class="style9"><?php echo "$nama_kec, ".tgl_indo($tanggal) ?></span></div></td>
      </tr>
</table>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right">
      <tr>	  
          <th width="40" height="34" class="style9 bottom top left">No</th>
			<th width="110" class="style9 left bottom top" >N I K </th>
              <th width="210" class="style9 left bottom top">Nama Anggota</th>
              <th width="32" class="style9 left bottom top">JK</th>
              <th width="186" class="style9 left bottom top">Alamat</th>
              <th width="164" class="style9 left bottom top">Jaminan</th>
              <th width="132" class="style9 left bottom top">Nilai</th>
              <th width="135" class="style9 left bottom top right">Tanda Tangan </th>
        </tr>      
		
<?php 	
		$angg=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$id_pinj'");  /* query hitung jumlah anggota */
		$jml_anggota=mysql_num_rows($angg);
		$no=0;
		while($data=mysql_fetch_array($angg)){
		$nia=$data['nia'];
		$alok_anggota=$data['alokasi'];
		
		$anggota=mysql_query("select * from anggota_$_SESSION[kd_kab] where id='$nia' order by namadepan ASC");  /* untuk memunculkan ke tabel tampil */	
		while($row6=mysql_fetch_array($anggota)){
						  
						  $nama_anggota		=$row6['namadepan'];
						  $id_anggota		=$row6['nik'];
						  $jenis_kelamin	=$row6['jk'];
						  $tempat_lahir		=$row6['tempat_lahir'];
						  $tgl_lahir		=$row6['tgl_lahir'];
						  $alamat_anggota	=$row6['alamat'];
						  $nomor_hp			=$row6['hp'];
						  $jaminan 			= explode(",", $row6['jaminan']);
						  $jj=mysql_fetch_array(mysql_query("select * from jenis_jaminan WHERE id='$jaminan[0]' ")); 
						  $jenis_jaminan	=$jj['nama_jaminan'];
							$nomor_milik	=$jaminan[1];
							$merk			=$jaminan[2];
							$alamat_jaminan	=$jaminan[3];
						    $nilai_jaminan	=$jaminan[4];
						
						   ?>
		
		
		<!-- Menampilkan data pada tabel -->
            <tr>
              <td height="33" class="style9 top left"><div align="center" ><?php echo $no=$no+1;?></div></td>
              <td class="style9 left top"><div align="center"><?php echo $id_anggota;?></div></td>
              <td class="style9 left top"><?php echo $nama_anggota; ?></td>
              <td class="style9 left top"><div align="center"><?php echo $jenis_kelamin; ?></div></td>
              <td class="style9 left top"><span class="style9"><?php echo $alamat_anggota;?></span></td>
              <td class="style9 left top"><?php echo "$jenis_jaminan <b>$merk</b>";?><br /><div class="style57"><?php echo $nomor_milik;?></div></td>
              <td class="style9 left top align-right"><?php echo @(number_format($nilai_jaminan));?></td>
              <td class="style9 left top right"><?php echo $no;?>.</td>
            </tr>
  <?php } } ?>
		<!-- Menampilkan Jumlah Total pada tabel -->
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      

      
      <tr>
       <?php if ($_SESSION['lokasi']=='207' or $_SESSION['kd_kab']=='43' ) { ?>
        <td width="50%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p><br></p>
        </div></td>
    	<?php } else if ($_SESSION['lokasi']=='184') { ?>
        	<td width="50%" height="36" colspan="1" class="style26"><div align="center" class="style9">
         
        </div></td>
        <?php } else if ($_SESSION['lokasi']=='197') { ?>
        <td width="50%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p><br>Sekretaris Kelompok</p>
        </div></td>

 		<?php } else { ?>
        <td width="50%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>Mengetahui,<br> <?php 
		if($_SESSION['lokasi']=='258'){
		echo "Ketua UPK"; 
		}else{
		echo "$row[sebutan_kades] $nama_desa"; 
		}?></p>
		
        </div></td>
        <?php }?>

        <td colspan="3" class="style26"><div align="center" class="style9">
          <p>Ketua Kelompok </p>
        </div></td>
      </tr>	
	<tr>
	    <th height="24" colspan="-1" rowspan="4" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        
        <?php if ($_SESSION['lokasi']=='207' or $_SESSION['kd_kab']=='43') { ?>
        <p></p>
   		
   		<?php } else if ($_SESSION['lokasi']=='184') { ?>
   		<p></p>
        <?php } else if ($_SESSION['lokasi']=='197') { ?>
   		<p><?php echo $sekretaris; ?></p>
        <?php } else { ?>
        <p><?php 
		if($_SESSION['lokasi']=='258'){ //khusus lokasi 258
			echo strtoupper ("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?><?php
		}
		else{
			echo ($row['kades']); ?>, <?php if($pangkat=$pangkat){echo "<br>$pangkat";}?> <br><?php if($nip_kades=="" OR $nip_kades==NULL){}else{?>NIP. <?php echo $nip_kades; }}?></p>
        
        <?php }?>
        </th>
        <td width="7%" rowspan="3" class="style9">&nbsp;</td>
        <td width="13%" rowspan="3" class="style9">&nbsp;</td>
        <th width="30%" class="style9">&nbsp;</th>
  </tr>
	<tr>
	  <th class="style9">&nbsp;</th>
  </tr>
	<tr>
	  <th class="style9">&nbsp;</th>
  </tr>
	<tr>
	  <th colspan="3" class="style9"><?php echo ($ketua); ?></th>
  </tr>
</table>
<div style="page-break-after: always;">
</div>
<title>Surat Pernyataan Tanggung Renteng  <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> <?php echo "$row[sebutan_desa] $nama_desa";?></title>
<?php } ?>        
</body>
