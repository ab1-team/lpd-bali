<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

$lokasi=$_SESSION['lokasi'];
$d					=$_POST['d'];
$m					=$_POST['m'];
$y					=$_POST['y'];
$tgl="$y-$m-$d";

if($d=$d){$laporan="Harian"; $jenis="Tanggal"; $kl="LH"; }else if($m=$m){$laporan="Bulanan"; $jenis="Bulan"; $kl="LB";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun"; $kl="LT";}else{$laporan="Global";}

?>
		       <?php 
		 $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' ")); 
			$nama_kec	    =$row ['nama_kec'];
			$alamat_kec	    =$row ['alamat_kec'];
			$telpon_kec	    =$row ['telpon_kec'];
			$email_kec	    =$row ['email_kec'];
			$web_kec	    =$row ['web_kec'];
			$visi		    =$row ['visi_misi'];
			$nama_kab	    =$row ['nama_kab'];
			$nomor_bh	    =$row ['nomor_bh'];
			$sebutan_kec	=$row ['sebutan_kec'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="BADAN HUKUM NOMOR : $nomor_bh<br>";}
		
		
		?>

<style type="text/css">
<!--
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 24px; font-weight: bold; }
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9,.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
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
		<br>
		<?php if ($_SESSION['lokasi']=='68') { ?>
	<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">


      <tr align="center">
        <td colspan="3" width="10%" class="style6 bottom">
										<img class='' alt='...' src='../../../images/DAPM.png' style='float:left; width:100; margin:10px 10px 10px 10px;'>
											
											<?php
											echo"
												</td>
												<td width='80%' class='style6 bottom'>

											";
													?>
													<br>
													<span class="style33"><?php echo strtoupper($row['nama_lembaga_long']);?></span><br>
													<span class="style3">(<?php echo strtoupper($row['nama_lembaga_sort']);?>)</span><br>
													 <span class="style333"><?php echo strtoupper("$sebutan_kec $nama_kec");?><br></span>
													<span class="style9"><?php echo "$bh $alamat_kec $nama_kec $nama_kab Telp. $telpon_kec";?><br>
													<?php echo "E-mail: $email_kec Website: $web_kec";?></span>
												</td>
												<td class="style6 bottom">
											<?php
											 $logo=$row['logo'];
											if (empty($logo)) {
											echo "<img class='' alt='...' src='../../../images/upk.png' style=' width:100; margin:10px 10px 10px 10px;'>";
											}else{
											echo "<img class='' alt='...' src='../../../images/logo/$logo' style=' width:100; margin:10px 10px 10px 10px;'>";
											} ?>

									</td>
			     				 </tr>	
								</table>
		<?php }else { ?>	

				<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
					<tr align="center">
				        <td colspan="3" class="style6 bottom">
						<?php
															 $logo=$row['logo'];
															if (empty($logo)) {
															echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:100; margin:10px 0 10px 20px;'>";
															}else{
															echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:100; margin:10px 0 10px 20px;'>";
															}
						?>
						<br>
						<span class="style3"><?php echo strtoupper($row['nama_lembaga_long']);?></span><br>
						 <?php echo strtoupper("$sebutan_kec $nama_kec KABUPATEN $nama_kab");?><br>
						<span class="style9"><?php echo "$bh $alamat_kec $nama_kec $nama_kab Telp. $telpon_kec";?><br>
						<?php echo "E-mail: $email_kec Website: $web_kec";?></span></td>
				      </tr>	
				  </table>
		<?php  } ?>
    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <?php 
		 $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' ")); 
			$nama_kec	    =$row ['nama_kec'];
			$alamat_kec	    =$row ['alamat_kec'];
			$telpon_kec	    =$row ['telpon_kec'];
			$email_kec	    =$row ['email_kec'];
			$web_kec	    =$row ['web_kec'];
			$visi		    =$row ['visi_misi'];
			$nama_kab	    =$row ['nama_kab'];
			$nomor_bh	    =$row ['nomor_bh'];
			$sebutan_kec	=$row ['sebutan_kec'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="BADAN HUKUM NOMOR : $nomor_bh<br>";}
		
		
		?>
  

		  <tr>
			<td width="15%" height="20" class="style9 top">Nomor </td>
			<td width="35%" height="20" class="top"><span class="style9">:</span><span class="style27"> <?php echo "______/$kl/ARTHAMARI".tgl_rom($tgl)."";?></span></td>
			<td width="50%" colspan="2" rowspan="3" class="style9 top">&nbsp;</td>
		  </tr>
		  <tr>
			<td height="20" class="style9">Tanggal</td>
			<td height="20"><span class="style9">:</span><span class="style27"> <?php echo tgl_indo(date('Y-m-d'));?></span></td>
		  </tr>
		  <tr>
		    <td height="20" class="style9">Perihal</td>
		    <td height="20"><span class="style9">:</span><span class="style27"> Laporan <?php echo $laporan;?></span></td>
      </tr>
		  <tr>
			<td height="20" class="style9">&nbsp;</td>
			<td height="20"><span class="style27">&nbsp;&nbsp;<?php echo $jenis;?> <?php echo tgl_indo($tgl);?></span></td>
		    <td colspan="2" class="style9">KEPADA YTH. </td>
		  </tr>
		  <tr>
			<td colspan="2" rowspan="2" class="style9">&nbsp;</td>
		    <td colspan="2" class="style27">
				<ol>
					<li>Bupati <?php echo $nama_kab;?><br>cq. <?php echo $row['nama_lembaga'];?></li>
					<li><?php if($row['sebutan_kec']=='Kapanewon'){echo "Panewu";}else{ echo "Camat";}?> <?php echo $nama_kec;?></li>
				</ol>
			</td>
		  </tr>
		  <tr>
			<td colspan="2" class="style27">Di
            <p class="align-center">T E M P A T</td>
		  </tr>
		  <tr>
		    <td colspan="5" class="style9 align-justify"><p>&nbsp;</p>
	        <p>&nbsp;</p></td>
      </tr>
		  <tr>
		  <td class="style9 align-justify">&nbsp;</td>
      <td colspan="4" class="style9 align-justify"><p>Dengan hormat,</p>
        <p>Bersama ini kami sampaikan laporan <span class="style27"></span><?php echo $jenis;?> <?php echo tgl_indo($tgl);?> <?php echo $row['nama_lembaga_long'];?> <?php echo "$row[sebutan_kec] $nama_kec";?> sebagai bentuk pertanggungjawaban kami dalam pengelolaan dana di <?php echo "$row[sebutan_kec] $nama_kec";?>.</p>
        <p>Adapun laporan yang akan kami sampaikan meliputi : </p>
        <p>
		<ol class="style9">
              <li>Jurnal Transaksi, yaitu seluruh rekaman transaksi selama   <span class="style27"></span><?php echo $jenis;?> <?php echo tgl_indo($tgl);?>;</li>
              <li>Buku Besar meliputi Kas, Bank, Pinjaman, Dibayar Dimuka, Inventaris, Aktifa Tetap, Hutang, Modal, dan Surplus;</li>
              <li>Laporan Perkembangan Pinjaman per Kelompok dan Rekapitulasi Tingkat Desa  sampai dengan   <span class="style27"></span><?php echo $jenis;?> <?php echo tgl_indo($tgl);?>;</li>
		      <li>Laporan Kolektibilitas Pinjaman per Kelompok dan Rekapitulasi Tingkat Desa   sampai dengan <span class="style27"></span><?php echo $jenis;?> <?php echo tgl_indo($tgl);?>;</li>
		      <li>Daftar Inventaris dengan penyusutan sampai dengan <?php echo $jenis;?> <?php echo tgl_indo($tgl);?>;</li>
		      <li>Laporan Rugi Laba, Laporan Perubahan Modal, dan Neraca <?php echo $jenis;?> <?php echo tgl_indo($tgl);?>;</li>
        </ol>
		<p>Adapun laporan softcopy dapat diakses secara online melalui <?php echo $web_kec;?> dengan memasukkan username dan password sesuai dengan level user dan jabatannya.</p>
		<p>Demikian laporan ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
		<p>&nbsp;</p></td>
  </tr>
  </table>
   <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  
<?php if($_SESSION['lokasi']==351) {?>
    <?php include "ttd_pusat_waeapo.php"; ?> 
<?php } else if ($_SESSION['lokasi']==352 or $_SESSION['lokasi']==353 or$_SESSION['lokasi']==354) {?>
    <?php include "ttd_cab_waeapo.php"; ?> 
<?php } else {?>
    <?php include "tanda_tangan.php"; }?>
	</table>
</body>
<title>Pengantar Laporan <?php echo $laporan;?></title>
      
</body>
