<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";
include "../../../js/bar128.php";			 
?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; padding:0 0 5px 5px;}
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.pull-right	{float: right; }
-->
</style>
<body onLoad="window.print()">

     	   <?php
		$rcp=$_GET['rcp'];
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, desa d, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=k.desa AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
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
											$angg=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where id_pinkel='$id_pinj'");  /* query hitung jumlah anggota */
											$jml_anggota=mysql_num_rows($angg);
											$nama_bkad_sort     =$row['nama_bkad_sort'];
		
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$pros_jasa			=$row['pros_jasa'];
											$jangka				=$row['jangka'];
											$sistem				=$row['sistem'];
											$tempo				=$jangka/$sistem;
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$bendaharaupk		=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='3' AND sejak<='$tgl_cair' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabp			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='3' AND jabatan='1' AND sejak<='$tgl_cair' "));
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
	
    <table width="91%" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
			<td height="20" colspan="4" class="bottom">
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
			?>			</td>
			<td width="342" height="20" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
			Loan ID. <?php echo $id_pinj;?>
		  </div></td>
  </tr> 	  
      

      <tr>
        <td height="20" colspan="5" class="bottom"><p align="center" class="style6">
		BUKTI TRANSAKSI<br>
		<span class="fw-semi-bold">PINJAMAN KELOMPOK <?php echo $nama_jpp;?></p></td>
      </tr>
	  <tr>
        <td height="0" colspan="5">&nbsp;</td>
      </tr>
	  <tr>
        <th colspan="5" class="style6 bottom"><BR></th>
      </tr>
	  <tr>
	    <th height="47" colspan="5" class="style6  left right"><span class="style9 pull-right">
	      <?php echo bar128(stripslashes("$kd_kelompok $idpinj")); ?></span></th>
      </tr>
	  <tr>
	    <th height="47" colspan="5" class="style6  left right">K W I T A N S I</th>
      </tr>
	  <tr>
	    <td width="149" class="style9 left">&nbsp;</td>
	    <td width="155" height="25" class="style9">&nbsp;</td>
	    <td colspan="3" class="right">&nbsp;</td>
      </tr>
	  <tr>
	    <td width="149" class="style9 left">&nbsp;</td>
	    <td class="style9">Telah Diterima Dari </td>
	    <td colspan="3" class="style9 right">: <strong><?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?></strong><p class="bottom"></td>
      </tr>
	  <tr>
	    <td width="149" class="style9 left">&nbsp;</td>
	    <td class="style9">Uang Sebanyak </td>
	    <td colspan="3" class="right style9">: <strong><?php echo ucwords(toTerbilang($alokasi));?> Rupiah</strong><p class="bottom"></td>
      </tr>
	  <tr>
	    <td width="149" class="style9 left">&nbsp;</td>
	    <td class="style9">Untuk Pembayaran </td>
	    <td colspan="3" class="right style9">: <strong>Pinjaman Kegiatan  <?php echo $nama_jpp; ?>  Kelompok <?php echo "$nama_kelompok"; ?></strong>
        <p class="bottom"></td>
      </tr>
	  <tr>
	    <td width="149" class="style9 left">&nbsp;</td>
	    <th class="style9">&nbsp;</th>
	    <td colspan="3" class="right style9"> <strong>&nbsp;&nbsp;Beralamat di <?php echo "$alamat_kelompok $nama_desa $nama_kec"; ?></strong>
          <p class="bottom"></td>
      </tr>
	  <tr>
	    <td width="149" class="style9 left">&nbsp;</td>
	    <th class="style9">&nbsp;</th>
	    <td colspan="3" class="right style9"><strong>&nbsp;&nbsp;Loan ID. <span class="style9"> <?php echo $id_pinj;?> - SPK No. <?php echo $row['spk_no'];?></span></strong>
            <p class="bottom"></td>
	  </tr>
	  <tr>
	    <td width="149" class="style9 left">&nbsp;</td>
	    <th class="style9"><hr class="garis">
          Rp. <?php echo number_format($alokasi);?>,-
        <hr class="garis"></th>
	    <td colspan="3" class="style9 right"><br>
          <br>
          <br>
          <br>
          <br></td>
      </tr>
	  
	  <tr>
	    <td class="style9 left">&nbsp;</td>
	    <td class="style9">&nbsp;</td>
	    <td width="325" class="style9">&nbsp;</td>
	    <td class="style9 right" colspan="2"><div align="center"><?php echo "$nama_kec, ".tgl_indo($tgl_cair) ?><br><br></div></td>
      </tr>
	  <tr>
	    <td colspan="2" class="style9 left"><p align="center">Setuju dibayarkan<br>
			<?php echo "$row[sebutan_level_1] <br>$row[nama_lembaga_sort]";?></p>
			  <p align="center">&nbsp;</p>
			  <p align="center">&nbsp;</p>
			  <p align="center">&nbsp;</p>
			<p align="center"><strong><?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?></strong></p>
		</td>
        <td class="style9" width="25%">
			<p align="center"><br>Dikeluarkan oleh <br><?php echo "$row[sebutan_level_3] <br>$row[nama_lembaga_sort]";?></p>
			<p align="center">&nbsp;</p>
			<p align="center">&nbsp;</p>
			<p align="center">&nbsp;</p>
			<p align="center"><span class="style9"><strong><?php echo strtoupper("$bendaharaupk[namadepan] $bendaharaupk[namabelakang]"); ?></strong></span></p>
		</td>
		<td class="style9" width="20%">
			<p align="center"><br>Petugas<br>Yang Menyerahkan,</p>
			<p align="center">&nbsp;</p>
			<p align="center">&nbsp;</p>
			<p align="center">&nbsp;</p>
			<p align="center"><span class="style9"><strong>______________</strong></span></p>
		</td>
		<?php if ($_SESSION['lokasi']=='200') { ?>
		
        <td class="style9 right" width="25%">
			<p align="center">Diterima oleh <br>
			Perwakilan Kelompok<br>
			  Ketua Kelompok,</p>
			<p align="center">&nbsp;</p>
			<p align="center"><div style="font-size: 8px; text-align: center;">Materai 6000</div></p>
			<p align="center">&nbsp;</p>
			<p align="center"><strong><?php echo strtoupper($ketua); ?></strong></p>
		</td>
	<?php } else {?>
		<td class="style9 right" width="25%">
			<p align="center">Diterima oleh <br>
			Perwakilan Kelompok<br>
			  Ketua Kelompok,</p>
			<p align="center">&nbsp;</p>
			<p align="center">&nbsp;</p>
			<p align="center">&nbsp;</p>
			<p align="center"><strong><?php echo strtoupper($ketua); ?></strong></p>
		</td>

	<?php }?>

	  </tr>
	  <tr>
	    <td colspan="5" class="style9 left right"><p>&nbsp;</p>
        <p>&nbsp;</p></td>
      </tr>
	  <tr>
	    <td colspan="5" class="style9 left right"><div align="center"><span class="style9">Mengetahui,</span></div></td>
      </tr>
	  <tr>
	    <td <?php if($_SESSION['lokasi']=="96" OR $_SESSION['lokasi']=="109") { echo "colspan='5' "; }else{ echo "colspan='2'"; } ?>  class="style9 left"><p align="center"><?php echo $nama_bkad_sort; ?></p>
	      <p align="center">&nbsp;</p>
	      <p align="center">&nbsp;</p>
	      <p align="center">&nbsp;</p>
        <p align="center"><strong><?php echo strtoupper("$ketuabkad[namadepan] $ketuabkad[namabelakang]"); ?></strong></p>	      </td>
	    <td class="style9">&nbsp;</td>
	<?php if($_SESSION['lokasi']=="12") { //KHUSUS KARANGANYAR DEMAK ?>
	    <td  colspan="2" class="style9 right"><p align="center">PDB</p>
	      <p align="center">&nbsp;</p>
	      <p align="center">&nbsp;</p>
	      <p align="center">&nbsp;</p>
			<p align="center">
			<strong>
			<?php 
			$pdb=mysql_fetch_array(mysql_query("SELECT * FROM desa WHERE id='$row[desa]' "));
												echo strtoupper($pdb['ked']); ?>
			</strong></p>
		</td>
	<?php }else if($_SESSION['lokasi']=="108" OR $_SESSION['lokasi']=="98" OR $_SESSION['lokasi']=="102") { //KADES KHUSUS PURING, ALIAN, ADIMULYO KAB.KEBUMEN 
	$kd=mysql_fetch_array(mysql_query("SELECT * FROM desa d, sebutan_desa sd WHERE d.sebutan=sd.id AND d.id='$row[desa]' "));?>
	    <td  colspan="2" class="style9 right"><p align="center"><?php echo "$kd[sebutan_kades] $kd[nama_desa]"; ?> </p>
	      <p align="center">&nbsp;</p>
	      <p align="center">&nbsp;</p>
	      <p align="center">&nbsp;</p>
			<p align="center">
			<strong>
			<?php 
			
												echo strtoupper($kd['kades']); ?>
			</strong></p>
		</td>
	<?php }else if($_SESSION['lokasi']=="96" OR $_SESSION['lokasi']=="109" ) { echo ""; //KHUSUS KEC KEBUMEN, klirong BP Hilang
	
	}else{ ?>
	    <td  colspan="2" class="style9 right"><p align="center">Badan Pengawas</p>
	      <p align="center">&nbsp;</p>
	      <p align="center">&nbsp;</p>
	      <p align="center">&nbsp;</p>
        <p align="center"><strong><?php echo strtoupper("$ketuabp[namadepan] $ketuabp[namabelakang]"); ?></strong></p></td>
	<?php } ?>
      </tr>
	  <tr>
	    <td colspan="5" class="style9 right left">&nbsp;</td>
      </tr>
	  <tr><td colspan="5" class="style9 right bottom left">&nbsp;</td></tr>
</table>

<title>7. Kwitansi <?php echo $kd_kelompok;?>-<?php echo $id_pinj;?> Kelompok <?php echo $nama_kelompok;?> Desa <?php echo $nama_desa;?></title>

	  <?php } ?>        
</body>
