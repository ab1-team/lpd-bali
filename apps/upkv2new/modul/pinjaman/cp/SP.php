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
							kecamatan kc, desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							kc.id=k.lokasi AND d.id=k.desa AND sd.id=d.sebutan AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
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
											$pros_jasa			=$row['pros_jasa'];
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
											
											$jumangg			=mysql_num_rows(mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] WHERE id_pinkel='$id_pinj' "));

?>	

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td height="30" >&nbsp;</td>
  </tr> 	  
      

      <tr>
        <td height="20" colspan="4" class="bottom"><p align="center" class="style6">
		KELOMPOK <?php echo strtoupper($row['deskripsi_jpp']);?> <br>
		<span class="style3">"<?php echo strtoupper($nama_kelompok);?>"</span><br>
		<span class="style9"><?php echo ucwords("Alamat : $alamat_kelompok $row[sebutan_desa] $nama_desa Kecamatan $nama_kec Telp.$telpon");?></span></p></td>
      </tr>
      
      
      <tr>
        <td height="20" class="style9 top">Nomor </td>
        <td height="20" class="top"><span class="style9">:</span><span class="style27"> <?php echo "______/$kd_kelompok-$id_pinj/$nama_jpp".tgl_rom($tgl_proposal)."";?></span></td>
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
        <td colspan="2" class="style27"><?php if($_SESSION['lokasi']=='270'){ echo "Pengurus <br>$row[nama_lembaga_long]";}else{ echo "$row[sebutan_level_1] <br>$row[nama_lembaga_long]";}?> <br>
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
        <p align="center" class="style6"><strong>SURAT PERMOHONAN KREDIT</strong></p>
      <p align="center" class="style6">&nbsp;</p></td>
    </tr>
    <tr>
      <td colspan="3" class="style9 align-justify"><p>Yang bertanda tangan  di bawah ini:</p></td>
    </tr>
    <tr>
      <td class="style9 align-justify">Nama Lengkap <br>Alamat<br>Jabatan</td>
      <td colspan="2" class="style9 align-justify">: <span class="style27"><?php echo $ketua;?></span><br>
      : <span class="style27"><?php echo $alamat_kelompok;?></span><br>
      : <span class="style27"><?php echo "Ketua Kelompok $nama_kelompok";?></span></td>
    </tr>
    <tr>
      <td class="style9 align-justify">Nama Lengkap <br>
        Alamat<br>
      Jabatan</td>
      <td colspan="2" class="style9 align-justify">: <span class="style27"><?php echo $sekretaris;?></span><br>
: <span class="style27"><?php echo $alamat_kelompok;?></span><br>
: <span class="style27"><?php echo "Sekretaris Kelompok $nama_kelompok";?></span></td>
    </tr>
    <tr>
      <td colspan="3" class="style9 align-justify"><p>Dalam  hal ini bertindak untuk dan atas nama seluruh anggota kelompok <?php echo "$row[deskripsi_jpp] ($nama_jpp) $nama_kelompok";?> (daftar  anggota terlampir), dengan ini bermaksud mengajukan permohonan kredit sebesar  Rp. <span class="style27"><?php echo number_format($proposal);?></span> <span class="style27">(<?php echo ucwords(toTerbilang($proposal));?> Rupiah)</span> untuk  memenuhi kebutuhan tambahan modal usaha&nbsp; bagi <span class="style27"><?php echo $jumangg;?></span> anggota.  Kredit atau pinjaman tersebut di atas, akan kami kembalikan dalam jangka waktu <span class="style27"><?php echo $jangka;?> </span>bulan, dengan  sistem angsuran <span class="style27"><?php echo "$sistem_angsuran ($row[deskripsi_sistem])";?>.</span></p>
        <p>Sebagai bahan  pertimbangan, bersama ini kami lampirkan:</p>
        <p>
		<ol class="style9">
              <li>Fotokopi KTP dan KK dari  <span class="style27"><?php echo $jumangg;?></span> orang anggota kelompok kami  yang mengajukan kredit;</li>
              <li>Surat  Rekomendasi dari Kepala Desa/Lurah;</li>
              <li>Pernyataan  kesediaan tanggung renteng dari seluruh anggota;</li>
              <?php if ($_SESSION['lokasi']=='197') {
               echo "";
             }else{
                echo "<li>Fotokopi bukti  tabungan kelompok di bank;</li>";
             }?> 
		      <li>Rencana  pengembalian kredit.</li>
		</ol>
		</p>
		<p>Demikian permohonan kami, atas perhatiannya kami ucapkan terima kasih.</p>
		<p>&nbsp;</p></td>
  </tr>
  <tr>
      <td width="15%" class="style9 align-justify">&nbsp;</td>
      <td width="34%" class="style9 align-justify"><div align="center"><br>
        Ketua Kelompok,
            <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><span class="style27"><?php echo strtoupper($ketua);?></span></p>
      </div>        </td>
      <td width="51%" class="style9 align-justify"><div align="center"><?php echo $nama_kec;?>, <?php echo tgl_indo($tgl_proposal);?> <br>
        Sekretaris Kelompok,
             <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><span class="style27"><?php echo strtoupper($sekretaris);?></span></p>
      </div></td>
  </tr>
  <?php if ($_SESSION['lokasi']=='115') { ?>
	<tr>
        <td height="20" colspan="3" class="style9"><div align="center">Mengetahui</div></td>
    </tr>
	<tr>
      <td width="15%" class="style9 align-justify">&nbsp;</td>
      <td width="34%" class="style9 align-justify"><div align="center"><br>
        <?php echo "$row[sebutan_kades]<br>$nama_desa"; ?>
            <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><span class="style27"><b><?php echo strtoupper($row['kades']);?></b><br><?php if(!empty($row['nip']) or $row['nip']>0) { echo "$row[pangkat] <br>NIP. $row[nip]"; }else{echo"<br><br>";}?></span></p>
      </div>        </td>
      <td width="51%" class="style9 align-justify"><div align="center">
        Pendamping Kelompok <br> <?php echo "$row[sebutan_desa] $nama_desa"; ?>
             <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><span class="style27"><?php echo strtoupper($row['ked']); ?></span></p>
      </div></td>
  </tr>

  <?php }else if ($_SESSION['kd_kab']=='26'){ ?>
  
  <tr>
  <td width="15%" class="style9 align-justify">&nbsp;</td>
  <td class="style9 align-justify" colspan="2"><div align="center">
        Mengetahui,<br>Pendamping Kelompok/Tim Pendanaan/KED *) <br> <?php echo "$row[sebutan_desa] $nama_desa"; ?>
             <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><span class="style27"><?php echo strtoupper($row['ked']); ?></span></p>
      </div></td>
  </tr>
  <?php } ?>
</table>

<?php } ?>        
</body>
<title><?php echo "Surat Permohonan Kredit $nama_kelompok $nama_desa"; ?></title>