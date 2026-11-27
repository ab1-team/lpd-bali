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
.style69 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; text-align: justify; vertical-align: top; white-space: pre-line;}
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; text-align: justify; vertical-align: top; }
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
		$lokasi=$_SESSION['lokasi'];
		
		$view=mysql_query("SELECT * FROM
							kabupaten b, kecamatan kc, desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk, jenis_jasa jj,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							b.id=kc.kd_kab AND kc.id=k.lokasi AND d.id=k.desa AND d.sebutan=sd.id AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
							jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND jj.id=pk.jenis_jasa AND
							sa.id=pk.sistem_angsuran AND pk.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$id_kel				=$row['id_kel'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];
											$nama_bkad_sort     =$row['nama_bkad_sort'];
											
											$alokasi			=$row['alokasi'];
											$tgl_cair			=$row['tgl_cair'];
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
											$jenis_jasa			=$row['nama_jj'];
											$jangka				=$row['jangka'];
											$sistem_angsuran	=$row['nama_sistem'];
											$lu					=$row['lu'];
											$status				=$row['status'];
											$user_id			=$row['user_id'];
											$dus				=mysql_fetch_array(mysql_query("SELECT * FROM users u, level l WHERE u.level=l.id AND u.id='$user_id' "));
											$nama_user			=$dus['namadepan']. " " .$dus['namabelakang']." (".$dus['nama_level'].")";
											$pelogin			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id=$_SESSION[id]"));
											
											$lokasi				=$row['lokasi'];
											$nama_kec			=$row['nama_kec'];
											$ttd_saksi			=$row['ttd_saksi'];
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


$catatan_bp	=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan kc, catatan_bp bp, users u WHERE bp.id='$rcp' AND bp.id_sender=u.id AND kc.id=bp.lokasi"));
								$bulan_laporan	= $catatan_bp['bulan_laporan'];
								$bulan_bp 			= getBulan(substr($bulan_laporan,5,2));
								$tahun_bp			= substr($bulan_laporan,0,4);	
								$nama_kec			=$catatan_bp['nama_kec'];
			?>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="style9">
			<tr>
				<td height="20" colspan="4" class="bottom">
					<?php
				$logo=$catatan_bp['logo'];
					if (empty($logo)) {
						echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:50; margin-right:5px;'>";
						}else{
						echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:50; margin-right:5px;'>";
						}
											
			$nomor_bh	=$catatan_bp ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="Badan Hukum No.$nomor_bh<br>";}
		
			echo "<div class='style9'>".strtoupper("<b>$catatan_bp[nama_lembaga_long]<br>KECAMATAN $catatan_bp[nama_kec] KABUPATEN $row[nama_kab]</b>")."<br>$bh $catatan_bp[alamat_kec] Telp. $catatan_bp[telpon_kec] </div>"; 
			?>
				</td>
				<td height="20" colspan="3" class="bottom">
					<div align="right" class="style9">Dokumen Laporan <?php echo $laporan;?><br>
					Kd.Doc. BP-<?php echo $idf;?> Lembar-1 </div>
				</td>
			</tr> 
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td height="20" colspan="2" class="bottom"><p align="center" class="style6">
		CATATAN PEMERIKSAAN<br>
		<span class="fw-semi-bold"><?php echo strtoupper($row['nama_bp_long']) ?></p></td>
      </tr>
      
      
      <tr>
        <td height="25" colspan="2" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td width="20%" height="24" class="style9">Hasil Pemeriksaan</td>
        <td width="80%" height="24"><span class="style9">:</span><span class="style27"> <?php echo ucwords($catatan_bp['namadepan']);?> <?php echo ucwords($catatan_bp['namabelakang']);?>(<?php echo ucwords($catatan_bp['ins']);?>)</span></td>
      </tr>
      <tr>
        <td height="24" class="style9">Bulan Laporan</td>
        <td height="24"><span class="style9">:</span><span class="style27"> <?php echo $bulan_bp;?> <?php echo $tahun_bp;?></span></td>
      </tr>
      <tr>
        <td height="25" class="style9">Catatan </td>
        <td height="25" class="style9">: <span class="style27"> BP-<?php echo $rcp;?></span></td>
      </tr>
</table>
	  <table width="70%" border="0" align="center" cellpadding="3" cellspacing="0">
	      <tr>
	  <td class="style69 top bottom"> <?php echo $catatan_bp['isi'];?> </td>
	      </tr>
	   <tr>
	  <td height="30" class="style9">&nbsp;</td>
	   </tr></table>
	  <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
      <td width="45%" class="style10"><p><span class="style27"> <?php echo strtoupper($row['nama_bp_long']) ?> Sign:</span><br>
        <?php echo strtoupper($catatan_bp['nama_bp_long']) ?> <?php echo strtoupper($catatan_bp['nama_lembaga_long']) ?> <?php echo "$row[sebutan_kec] $nama_kec"; ?> menyatakan kebenaran yang dapat dipertanggungjawabkan atas hasil pemeriksaan laporan dan/atau kondisi lapangan atas obyek pemeriksaan sebagaimana diuraikan dalam catatan pemeriksaan di atas.</p></td>
	    <td width="5%" height="20" colspan="-1" class="style9 align-justify"><p>&nbsp;</p>      </td>
        <td width="50%" colspan="2" class="style9"><p>Diperiksa Oleh,<br><?php echo strtoupper($row['nama_bp_long']) ?> Kecamatan  <?php echo $nama_kec; ?><br>
        </p>
		<?php
		$dbp=mysql_query("SELECT * FROM jabatan j, users u WHERE j.id=u.jabatan AND u.lokasi=$_SESSION[lokasi] AND u.level='3' AND u.hingga<=0 AND u.status='1' ");
		while($bp=mysql_fetch_array($dbp)){
		echo "
			<table width='100%'>
				<tr>
				<td width='50%' class='style27'>".strtoupper($bp['namadepan'])." ".strtoupper($bp['namabelakang'])."<br>
				<span class='style9'>(".$bp['nama_jabatan'].")</span></td>
				<td width='40%' class='bottom'></td>
				</tr>
				<tr><td height='10'>$nbsp</td></tr>
			</table>";
		}
		?>      </td>
  </tr>
</table>
	  

<title>BP<?php echo "-$rcp ";?></title>
<?php } ?>        
</body>
