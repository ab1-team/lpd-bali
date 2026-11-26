<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

?>


<style type="text/css">
<!--
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 24px; font-weight: bold; }
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.align-justify {text-align:justify; }
.align-center {text-align:center; }
-->
</style>
<body onLoad="window.print()">

<?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us,
													anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND
																sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
																a.id=pi.nia AND pi.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											
											$alokasi			=$row['alokasi'];
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
											$nama_kab			=$row['nama_kab'];
											$nama_desa			=$row['nama_desa'];
											$sebutan_desa		=$row['sebutan_desa'];
											$sebutan_kades		=$row['sebutan_kades'];
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
    <td height="30" >&nbsp;</td>
  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		<?php echo strtoupper($row['deskripsi_jpp']);?> <br>
		<span class="style3">"<?php echo strtoupper($namadepan);?>"</span><br>
		<span class="style9"><?php echo ucwords("Alamat : $alamat Desa $nama_desa Kecamatan $nama_kec Telp.$telpon");?></span></p></td>
      </tr>
      
      
      <tr>
        <td height="20" class="style9 top">Nomor </td>
        <td height="20" class="top"><span class="style9">:</span><span class="style27"> <?php echo "______/$nik-$id_pinj/$nama_jpp".tgl_rom($tgl_proposal)."";?></span></td>
        <td colspan="2" rowspan="2" class="style9 top">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" class="style9">Tanggal</td>
        <td height="20"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo($tgl_proposal);?></span></td>
      </tr>
      <tr>
        <td width="98" height="20" class="style9">Perihal</td>
        <td width="382" height="20"><span class="style9">:</span><span class="style27"> Permohonan Kredit <?php echo $nama_jpp;?></span></td>
        <td colspan="2" rowspan="2" class="style27">Kepada Yth.</td>
      </tr>
      <tr>
        <td colspan="2" rowspan="3" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="style27"><?php echo "$row[sebutan_level_1] <br>$row[nama_lembaga_long]";?> <br>
Kecamatan <?php echo $nama_kec;?></td>
      </tr>
      <tr>
        <td colspan="2" class="style27">Di <?php echo $nama_kec;?></td>
      </tr>
</table>
<br>  
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
      <td colspan="3" class="style9 align-justify"><p align="center" class="style6">&nbsp;</p>
        <p align="center" class="style6"><strong>SURAT PERMOHONAN KREDIT INDIVIDU</strong></p>
      <p align="center" class="style6">&nbsp;</p></td>
    </tr>
    <tr>
      <td colspan="3" class="style9 align-justify"><p>Yang bertanda tangan  di bawah ini:</p></td>
    </tr>
	
    <tr>
      <td class="style9 align-justify">Nama Lengkap <br>Jenis Kelamin<br>N I K<br>Kelahiran<br>Alamat<br>Telpon<br>Jenis Usaha</td>
      <td colspan="2" class="style9 align-justify">
	  : <span class="style27"><?php echo $namadepan;?></span><br>
      : <span class="style27"><?php echo $jenis_kelamin;?></span><br>
      : <span class="style27"><?php echo $nik;?></span><br>
      : <span class="style27"><?php echo "$tempat_lahir, $tgl_lahir";?></span><br>
      : <span class="style27"><?php echo "$alamat $sebutan_desa $nama_desa";?></span><br>
      : <span class="style27"><?php echo $telpon;?></span><br>
      : <span class="style27"><?php echo $jenis_usaha;?></span><br>
	  </td>
    </tr>

    <tr>
      <td colspan="3" class="style9 align-justify"><p>Dalam  hal ini bertindak untuk dan atas nama diri sendiri, dengan ini bermaksud mengajukan 
	  permohonan kredit sebesar  Rp. <span class="style27"><?php echo number_format($proposal);?></span> 
	  <span class="style27">(<?php echo ucwords(toTerbilang($proposal));?> Rupiah)</span> untuk  memenuhi kebutuhan tambahan modal usaha saya. <br><br>
	  Kredit atau pinjaman tersebut di atas, akan kami kembalikan dalam jangka waktu <span class="style27"><?php echo $jangka;?> </span>bulan, 
	  dengan  sistem angsuran <span class="style27"><?php echo "$sistem_angsuran ($row[deskripsi_sistem])";?>.</span></p>
        <p>Sebagai bahan  pertimbangan, bersama ini kami lampirkan:</p>
        <p>
		<ol class="style9">
              <li>Fotokopi KTP dan KK;</li>
			  <?php if($_SESSION['lokasi']=="72") { //SERIRIT BULELENG
				  echo "<li>Surat Rekomendasi Badan Pengurus Perkumpulan(BPP);</li>";
			  } ?>
              <li>Surat  Rekomendasi dari Kepala Desa/Lurah;</li>
              <li>Bukti Angunan / Jaminan;</li>
              <li>Surat  Pernyataan Peminjam;</li>
		      <li>Rencana  pengembalian kredit.</li>
		</ol>
		</p>
		<p>Demikian permohonan kami, atas perhatiannya kami ucapkan terima kasih.</p>
		<p>&nbsp;</p></td>
  </tr>
  <tr>
      <td width="15%" class="style9 align-justify">&nbsp;</td>
      <td width="34%" class="style9 align-justify">&nbsp;</td>
      <td width="51%" class="style9 align-justify"><div align="center"><?php echo $nama_kec;?>, <?php echo tgl_indo($tgl_proposal);?> <br>
        Yang Mengajukan,
             <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><span class="style27"><?php echo strtoupper($namadepan);?><br>NIK. <?php echo $nik;?></span></p>
      </div></td>
  </tr>
</table>

<?php } ?>        
</body>
<title><?php echo "Surat Permohonan Kredit $namadepan $nama_desa"; ?></title>