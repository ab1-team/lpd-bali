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
			
			$row	=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$nama_kec=$row['nama_kec'];
			
			$rcp=$_GET['rcp'];


			$data=mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us,
													keluarga k, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND
																k.id=a.hubungan AND sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
																a.id=pi.nia AND pi.id='$rcp'");
			$no=1;
			while($r=mysql_fetch_array($data)){
				
				
				$nama_desa=$r['nama_desa'];
			$nama_kab=$r['nama_kab'];
			$nik=$r['nik'];
			$tgl_proposal=$r['tgl_proposal'];
				
			$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$_SESSION[lokasi]' AND level='1' AND jabatan='1' AND sejak<='$tgl_proposal' "));
												
			
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
                
                  echo "<div class='style9'>".strtoupper("<b>$row[nama_lembaga_long]<br>$sebutan_kec $row[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $row[alamat_kec] Telp. $row[telpon_kec] </div>"; 
                  ?>      
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Proposal<br>
			Loan ID. <?php echo "$rcp";?></div></td>
	  </tr> 
</table>

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td height="50" colspan="3" class="bottom"><p align="center" class="style6">SURAT PERSETUJUAN DAN KUASA
        </p></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="3" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="3" class="style9">Yang bertanda tangan dan/atau membubuhkan cap jempol dibawah ini,</td>
      </tr>
      <tr>
        <td height="25" class="style9">Nama Lengkap </td>
        <td class="style27">: <?php echo strtoupper($r['penjamin']);?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
	  <tr>
        <td height="25" class="style9">NIK/KK</td>
        <td class="style27">: <?php echo $r['kk'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td width="20%" height="25" class="style9">Alamat</td>
        <td width="42%" class="style27">: <?php echo "$r[alamat] $r[nama_desa]";?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
	  <tr>
        <td height="25" class="style9">Hubungan</td>
        <td class="style27">: <?php echo $r['kekeluargaan'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>

	  
      <tr>
        <td height="25" colspan="3" class="style9">Dengan ini memberikan persetujuan dan kuasa sepenuhnya kepada,</td>
      </tr>
      <tr>
        <td height="25" class="style9">Nama Lengkap </td>
        <td class="style27">: <?php echo strtoupper($r['namadepan']);?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9">Jenis Kelamin </td>
        <td class="style27">: <?= ($r['jk'] == 'L') ? 'Laki-laki':'Perempuan';?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
	   <tr>
        <td height="25" class="style9">NIK</td>
        <td class="style27">: <?php echo $r['nik'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9">Tempat, Tanggal Lahir </td>
        <td class="style27">: <?php echo $r['tempat_lahir'];?>, <?php echo tgl_indo($r['tgl_lahir']);?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td width="20%" height="25" class="style9">Alamat</td>
        <td width="42%" class="style27">: <?php echo "$r[alamat] $r[nama_desa]";?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" class="style9">Jenis Usaha</td>
        <td class="style27">: <?php echo $r['nama_usaha'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
	  <tr>
        <td height="25" class="style9">Nomor HP</td>
        <td class="style27">: <?php echo $r['hp'];?></td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="3" class="style9 align-justify">
		<h2 align="center"><br><u>KHUSUS</u></h2>
		<p>
		Menjaminkan / menggunakan sebagai jaminan kredit pinjaman yang akan diterima dari <?php echo "$r[nama_lembaga_long] ($r[nama_lembaga_sort]) Kecamatan $r[nama_kec]";?>, atas Tanah pertanian / Kebun / Perumahan / Hak Milik / Hak Guna Bangunan / BPKB kendaraan Bermotor / Mobil / SK / Slip Gaji Kepegawaian / Serifikat Hak Milik *)
		</p>
		</td>
      </tr>
	  <tr>
        <td height="25" class="style9">Nomor</td>
        <td class="style9">:</td>
        <td height="25" class="style9">&nbsp;</td>
      </tr>
	  <tr><td height="25" class="style9">Atas Nama</td><td class="style9">:</td><td height="25" class="style9">&nbsp;</td></tr>
	  <tr><td height="25" class="style9">Gambar situasi surat ukur tanggal</td><td class="style9">:</td><td height="25" class="style9">&nbsp;</td></tr>
	  <tr><td height="25" class="style9">Luas</td><td class="style9">:</td><td height="25" class="style9">&nbsp;</td></tr>
	  <tr><td height="25" class="style9">Lokasi</td><td class="style9">:</td><td height="25" class="style9">&nbsp;</td></tr>
	  <tr><td height="25" class="style9">Kecamatan</td><td class="style9">:</td><td height="25" class="style9">&nbsp;</td></tr>
	  <tr><td height="25" class="style9">Kabupaten</td><td class="style9">:</td><td height="25" class="style9">&nbsp;</td></tr>
	  <tr><td height="25" class="style9">Propinsi</td><td class="style9">:</td><td height="25" class="style9">&nbsp;</td></tr>
	   <tr>
        <td height="25" colspan="3" class="style9 align-justify">
		<p>
		Untuk keperluan tersebut menghadap dimana perlu, memberi dan / atau meminta keterangan-keterangan membuat atau menyuruh, membuat dan menandatangani semua surat / akta yang diperlukan.<br>
		Demikian surat persetujuan ini saya buat dengan sebenarnya untuk dapat dipergunakan dimana perlu
		</p>
		</td>
      </tr>
      <tr>
        <td height="25" colspan="2" class="style9">&nbsp;</td>
        <td height="25" class="style9"><div align="right"><span class="style9"><br><?php echo $nama_desa;?>, ____________________________</span></div></td>
      </tr>
</table>
	  
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
        <td width="32%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p><?php echo "$r[nama_lembaga_sort] $_SESSION[unit]"; ?><br><?php echo $r['sebutan_level_1']; ?>  </p>
        </div></td>
		 <td class="style26"><div align="center" class="style9">
          <p>Penerima Kuasa </p>
        </div></td>
        <td class="style26"><div align="center" class="style9">
          <p>Pemberi Kuasa</p>
        </div></td>
      </tr>	
	<tr>
	    <th height="24" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?></p></th>
		
        <th width="32%" class="style9"><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><?php echo strtoupper("$r[namadepan]<br>NIK. $r[nik]"); ?></p></th>
		
		<th height="24" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p><?php echo strtoupper("$r[penjamin]<br>NIK/KK. $r[kk]"); ?></p></th>
		
  </tr>
</table>
<div style="height:250px;">
</div>

<?php 

}
?>        
</body>
<title>Surat Pernyataan Anggota  <?php echo $nik;?>-<?php echo $rcp;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>