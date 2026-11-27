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
											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
											$jangka				=$row['jangka'];
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
											$sebutan_kec		=$row['sebutan_kec'];
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
											$no_hp              =$row['hp'];
											
											$row['nama_kec'] = $_SESSION['unit'];
			                                $nama_kec = $row['nama_kec'];
?>	

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td height="30" >&nbsp;</td>
  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		<img src="../../../images/<?php echo $_SESSION['kd_kab'];?>.jpg" width="77px" style="float:left; margin-left:50px;"/>
		PEMERINTAH DAERAH KABUPATEN <?php echo strtoupper($nama_kab);?> <br>
		 <?php echo strtoupper($row['sebutan_kec']);?> <?php echo strtoupper($nama_kec);?> <br>
		<span class="style3"><?php echo strtoupper("$sebutan_desa $nama_desa");?></span><br>
		<span class="style9"><?php echo ucwords("Alamat :  $sebutan_desa $nama_desa $sebutan_kec $nama_kec Telp.$row[no_kades]");?></span></p></td>
      </tr>
</table>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
      <td colspan="2" class="style9 align-justify"><p align="center" class="style6">&nbsp;</p>
        <p align="center" class="style6"><strong><u>SURAT REKOMENDASI KREDIT <?php echo $nama_jpp;?></u></strong><br><span class="style9">Nomor : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></p>
        <p align="center" class="style6">&nbsp;</p></td>
    </tr>
    <tr>
      <td colspan="2" class="style9 align-justify"><p>Yang bertanda tangan  di bawah ini <span class="style27"><?php echo "$sebutan_kades $nama_desa";?></span> 
	  menerangkan dengan sebenarnya bahwa:</p></td>
    </tr>
	<tr>
      <td class="style9 align-justify">Nama Lengkap <br>Jenis Kelamin<br>N I K<br>Kelahiran<br>Alamat<br>Telpon<br>Jenis Usaha</td>
      <td colspan="2" class="style9 align-justify">
	  : <span class="style27"><?php echo $namadepan;?></span><br>
      : <span class="style27"><?= ($jenis_kelamin == 'L') ? 'Laki-laki':'Perempuan';?></span><br>
      : <span class="style27"><?php echo $nik;?></span><br>
      : <span class="style27"><?php echo "$tempat_lahir, $tgl_lahir";?></span><br>
      : <span class="style27"><?php echo "$alamat $sebutan_desa $nama_desa";?></span><br>
      : <span class="style27"><?php echo $no_hp;?></span><br>
      : <span class="style27"><?php echo $jenis_usaha;?></span><br>
	  </td>
    </tr>
    <tr>
      <td colspan="2" class="style9 align-justify"><p>Benar-benar warga <?php echo "$sebutan_desa $nama_desa";?> dengan berkepribadian baik dan  <strong>
	  <em>Layak </em></strong>direkomendasikan untuk mendapatkan kredit  Modal  <span class="style27"><?php echo "$row[deskripsi_jpp] ($nama_jpp)";?></span> 
	  pada <?php echo "$nama_lembaga_sort";?> Kecamatan <?php echo "$nama_kec Kabupaten $nama_kab";?>.</p>
      <p>Demikian Surat Rekomendasi  ini diberikan kepada  yang bersangkutan untuk dipergunakan seperlunya.</p>
      <p>&nbsp;</p></td>
    </tr>
  <tr>
      <td width="21%" class="style9 align-justify">&nbsp;</td>
      <td width="79%" class="style9 align-justify"><div align="center"><?php echo $nama_desa;?>, <?php echo tgl_indo($tgl_proposal);?> <br>
        <?php echo "$sebutan_kades $nama_desa";?></;?>,
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><span class="style27"><?php echo strtoupper($row['kades']);?></span></p>
      </div></td>
  </tr>
</table>

<?php } ?>        
</body>
<title><?php echo "Surat Rekomendasi Kredit $nama_kelompok $nama_desa"; ?></title>