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
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, sebutan_desa sd, desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=k.desa AND sd.id=d.sebutan AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
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
											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
											$jangka				=$row['jangka'];
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											
											
											$nama_lembaga_sort				=$row['nama_lembaga_sort'];
											$lokasi				=$row['lokasi'];
											$nama_kab			=$row['nama_kab'];
											$nama_kec			=$row['nama_kec'];
											$sebutan_kec		=$row['sebutan_kec'];
											$desa			=$row['desa'];
											$nama_desa			=$row['nama_desa'];
											$nip_kades			=$row['nip'];
											$pangkat			=$row['pangkat'];
											$alamat_desa		=$row['alamat_desa'];
											$telp_desa			=$row['telp_desa'];
											$sebutan_desa		=$row['sebutan_desa'];
											$sebutan_kades		=$row['sebutan_kades'];
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
											
											$jumangg			=mysql_num_rows(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] WHERE id_pinkel='$id_pinj' "));

?>	

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td height="30" >&nbsp;</td>
  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
            <?php if($_SESSION['lokasi']!=177) { ?>
		<img src="../../../images/<?php echo $_SESSION['kd_kab'];?>.jpg" width="77px" style="float:left; margin-left:50px;"/>
		<?php } ?>
		PEMERINTAH KABUPATEN <?php echo strtoupper($nama_kab);?> <br>
		KECAMATAN <?php echo strtoupper($nama_kec);?> <br>
		<span class="style3"><?php echo strtoupper("$sebutan_desa $nama_desa");?></span><br>
		<span class="style9"><?php echo ucwords("Alamat : $alamat_desa  $sebutan_desa $nama_desa Kecamatan $nama_kec Telp.$telp_desa");?></span></p></td>
      </tr>
</table>


<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
      <td colspan="2" class="style9 align-justify"><p align="center" class="style6">&nbsp;</p>
        <p align="center" class="style6"><strong><u>SURAT REKOMENDASI KREDIT <?php echo $nama_jpp;?></u></strong><br><span class="style9">Nomor : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></p>
        <p align="center" class="style6">&nbsp;</p></td>
    </tr>
    <tr>
      <td colspan="3" class="style9 ">Yang bertanda tangan  di bawah ini : </td>
    </tr>
    <tr>
     <td class="style9 ">Nama<br> Jabatan</td>
     <td class="style9 ">: <?php echo  ($row['kades']);?><br>: <?php echo ucwords("$sebutan_kades $nama_desa");?>
    </tr>
    <tr>
      <td colspan="3" class="style9 ">Dengan ini menerangkan bahwa :  </td>
    </tr>
    <tr>
      <td  width="21%" class="style9 align-justify">Nama Lengkap/Jabatan<br>      <br></td>
      <td class="style9 align-justify">: <span class="style27"><?php echo $ketua;?></span> /Ketua<br>
      : <span class="style27"><?php echo $sekretaris;?></span> /Sekretaris<br></td>
    </tr>
    <tr>
      <td class="style9 align-justify">Nama Kelompok <br>
        Alamat<br>
      Jumlah Anggota<br>Jumlah Pengajuan </td>
      <td class="style9 align-justify">: <span class="style27"><?php echo  $nama_kelompok;?></span><br>
: <span class="style27"><?php echo ucwords("$alamat_kelompok $nama_desa");?></span><br>
: <span class="style27"><?php echo "$jumangg (".toTerbilang($jumangg).") Orang";?></span><br>
: <span class="style27"><?php echo "".number_format($proposal)." (".ucwords(toTerbilang($proposal))." Rupiah)";?></span></td>
    </tr>
    <tr>
      <td colspan="2" class="style9 align-justify"><p>Benar keberadaannya dan  <strong><em>Layak </em></strong>direkomendasikan untuk mendapatkan kredit  Modal  <span class="style27"><?php echo "$row[deskripsi_jpp] ($nama_jpp)";?></span> pada <?php echo "$nama_lembaga_sort";?> <?php echo "$sebutan_kec";?> <?php echo "$nama_kec Kabupaten $nama_kab";?>.</p>
      <p>Demikian Surat Rekomendasi  ini diberikan kepada  yang bersangkutan untuk dipergunakan seperlunya.</p>
      <p>&nbsp;</p></td>
    </tr>
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
      <td width="47%" class="style9 align-justify"><div align="center"><?php
	  if($_SESSION['lokasi']=='125') { //Khusus Kec. Karangjaya Tasikmalaya
		  echo "<br>Kepala Dusun __________________<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>______________________________</p>";
	  }else if($_SESSION['lokasi']=='8'){
	  	  echo"BPD<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p> <b>$row[sekdes]</b></p>";
	  }else{echo"";}
	  ?></div></td>
      <td width="50%" class="style9 align-justify"><div align="center"><?php echo $nama_desa;?>, <?php echo tgl_indo($tgl_proposal);?> <br>
        <?php 
		echo "$sebutan_kades $nama_desa"; ?>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><span class="style27"><?php  echo ($row['kades']); ?> <br> <?php echo $row['pangkat']; ?> <br>
        	<?php if($nip_kades==''){ ?>

        	   </span></p>
        <?php } else { ?>
        		NIP. <?php echo $nip_kades; ?></span></p>
        <?php }?>



      </div></td>
  </tr>
</table>

<?php } ?>        
</body>
<title><?php echo "Surat Rekomendasi Kredit $nama_kelompok $nama_desa"; ?></title>