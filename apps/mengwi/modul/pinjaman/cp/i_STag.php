<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman_individu.php";


		$rcp=$_GET['rcp'];
		$view=mysql_query("select * from kabupaten b, kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, usaha us, keluarga k,
													anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																b.id=kc.kd_kab AND kc.id=a.lokasi AND d.id=a.desa AND sd.id=d.sebutan AND jpp.id=pi.jenis_pp AND k.id=a.hubungan AND 
																sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND us.id=a.usaha AND
																a.id=pi.nia AND pi.id='$rcp'");
		$no=0;
		while($row=mysql_fetch_array($view)){
		
											$id_pinj			=$row['id'];
											$jenis_pp			=$row['jenis_pp'];
											$tgl_proposal		=$row['tgl_proposal'];
											$proposal			=$row['proposal'];
											$tgl_verifikasi		=$row['tgl_verifikasi'];

											
											$tgl_cair			=$row['tgl_cair'];
											
										
											$tanggal			 = substr($tgl_cair,8,2);
											$bulan  			 = getBulan(substr($tgl_cair,5,2));
											$tahun  			 = substr($tgl_cair,0,4);
											$alokasi			=$row['alokasi'];
											$pros_jasa			=number_format($row['pros_jasa']/$row['jangka'],2);
											$jenis_jasa			=$row['jenis_jasa'];
											$nama_jj			=$row['nama_jj'];

											$sistem				=$row['sistem'];
											$jangka				=$row['jangka'];
											$tempo				=$jangka/$sistem;
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
											$nama_kec	=$row ['nama_kec'];
											$alamat_kec	=$row ['alamat_kec'];
											$telpon_kec	=$row ['telpon_kec'];
											$email_kec	=$row ['email_kec'];
											$web_kec	=$row ['web_kec'];
											$visi		=$row ['visi_misi'];
											$nama_kab	=$row ['nama_kab'];
											
											$ttd_pdua			=$row['ttd_pdua'];
											$ttd_saksi			=$row['ttd_saksi'];
											$ttd_mengetahui		=$row['ttd_mengetahui'];
											$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$tgl_cair' "));
											$ketuabkad			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='2' AND jabatan='1' AND sejak<='$tgl_cair' "));
											
											
											$spk_no				=$row['spk_no'];
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

			
				
				
	$nunggakpokok	=nunggakpokok("$tgl_now-$id_pinj");
	$nunggakjasa	=nunggakjasa("$tgl_now-$id_pinj");
	
    $row['nama_kec'] = $_SESSION['unit'];
	$nama_kec = $row['nama_kec'];
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
											
											$nomor_bh	=$row ['nomor_bh'];
											if (empty($nomor_bh)) {$bh="";}else{$bh="BADAN HUKUM NOMOR: $nomor_bh<br>";}
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
															echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:130; margin:10px 0 10px 20px;'>";
															}else{
															echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:130; margin:10px 0 10px 20px;'>";
															}
															
															$nomor_bh	=$row ['nomor_bh'];
							if (empty($nomor_bh)) {$bh="";}else{$bh="BADAN HUKUM NOMOR: $nomor_bh<br>";}
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

		  <tr>
			<td height="20" class="style9 top" width="11%">Nomor </td>
			<td height="20" class="top"><span class="style9">:</span><span class="style27"> <?php echo "_________________";?></span></td>
			<td  colspan="2" class="style9 top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo("$nama_kec");?>, <?php echo tgl_indo(date('Y-m-d'));?></td>
		  </tr>
		  <tr>
			<td height="20" class="style9">Sifat</td>
			<td height="20"><span class="style9">:</span><span class="style27"> Penting dan Rahasia</span></td>
		  </tr>
		  <tr>
		    <td height="20" class="style9">Perihal</td>
		    <td height="20"><span class="style9">:</span><span class="style27"> <u>SURAT TAGIHAN</u></span></td>
      </tr>
		  <tr>
			<td width="120" height="20" class="style9">&nbsp;</td>
			<td width="343" height="20"><span class="style27">&nbsp;&nbsp;<?php echo $jenis;?> <?php echo tgl_indo($tgl);?></span></td>
		    <td colspan="2" class="style9" align="center">KEPADA YTH. </td>
		  </tr>
		  <tr>
			<td colspan="2" rowspan="2" class="style9">&nbsp;</td>
		    <td colspan="2" class="style27" align="center"> Bapak/Ibu <?php echo strtoupper($namadepan); ?></td>
		  </tr>
		  <tr>
			<td colspan="2" class="style27"  style="font-weight: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Di
            <p class="align-left" style="font-weight: normal;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper("$nama_desa $nama_kec");?></td>
		  </tr>
		  <tr>
		    <td colspan="5" class="style9 align-justify"><p>&nbsp;</p>
	        <p>&nbsp;</p></td>
      </tr>
	<tr>
		  <td class="style9 align-justify">&nbsp;</td>
      <td colspan="4" class="style9 align-justify">
	  <p>&nbsp;</p>
      </td>
  </tr>
  </table>
  

<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="style9 align-justify">
    <td width="126" rowspan="12">&nbsp;</td>
    <td colspan="4"><p>Dengan hormat,</p>
      <p> Mendasar kepada Surat Perjanjian Kredit (SPK) antara <?php echo "$namadepan";?> dengan <?php echo strtoupper($row['nama_lembaga_sort']);?> <?php echo "$sebutan_kec $nama_kec";?> Tanggal <?php echo tgl_indo($tgl_cair);?> Nomor : <?php echo $row['spk_no'];?>, dengan rincian pinjaman sebagai berikut :</p></td>
  </tr>
  <tr class="style9 align-justify">
    <td colspan="3">&nbsp;</td>
    <td width="468" rowspan="11">&nbsp;</td>
  </tr>
  <tr class="style9 align-justify">
	<td width="177">Alokasi Pinjaman</td>
	<td width="5">:</td>
	<td> <b><?php echo number_format($alokasi);?>,-</b></td>
  </tr>
  <tr class="style9 align-justify">
	<td width="177">Tanggal Pencairan</td>
	<td>:</td><td> <b>Rp. <?php echo tgl_indo($tgl_cair);?></b></td>
  </tr>
  <tr class="style9 align-justify">
	<td width="177">Prosentase Jasa </td>
	<td>:</td><td> <b><?php echo $pros_jasa;?> % per bulan</b></td>
  </tr>
  <tr class="style9 align-justify">
	<td width="177">Masa Angsuran</td>
	<td>:</td><td> <b><?php echo $jangka;?> bulan</b></td>
  </tr>
  <tr class="style9 align-justify">
	<td width="177">Sistem Angsuran Pokok</td>
	<td>:</td><td> <b><?php echo $sistem_angsuran;?> </b></td>
  </tr>
  <tr class="style9 align-justify">
	<td width="177" colspan="4" height="35px">dan mendasar pada catatan pembukuan kami, bahwa Pinjaman a.n.  <b><?php echo "$namadepan";?></b> sampai dengan diterbitkannya <u>Surat Tagihan</u> ini masih tercatat memiliki tunggakan sebagai berikut :</td>
  </tr>

  <tr class="style9 align-justify">
	<td width="177">Tunggakan Pokok</td>
	<td>:</td><td align="right"><b><?php echo number_format($nunggakpokok);?>,-</b></td>
  </tr>
  <tr class="style9 align-justify">
	<td width="177" class="bottom">Tunggakan Jasa</td>
	<td class="bottom">:</td>
	<td width="283" class="bottom" align="right"><b><?php echo number_format($nunggakjasa);?>,-</b></td>
  </tr>
  <tr class="style9 align-justify">
	<td width="177"><strong>Total Tunggakan</strong></td>
	<td>:</td><td align="right"> <b><?php echo number_format($nunggakpokok+$nunggakjasa);?>,-</b></td>
  </tr>
  <tr class="style9 align-justify">
	<td colspan="4"><br>Demikian surat ini kami sampaikan, apabila terjadi perbedaan hasil perhitungan angsuran/ tunggakan mohon untuk melakukan klarifikasi dengan <?php echo strtoupper($row['nama_lembaga_sort']);?> <?php echo "$sebutan_kec $nama_kec";?> dan terima kasih untuk segera melakukan pelunasan tunggakan pinjamannya.</td>
  </tr>
  </table>
   <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
          
          <p>&nbsp;</p>
  </tr>
  <tr>
	<?php
	$upk=mysql_fetch_array(mysql_query("SELECT * FROM users where lokasi='$lokasi' AND level='1' AND jabatan='1' "));   
	?>
      <td width="462" class="style9 align-justify"></td>
	  <td width="440" class="style9 align-justify"><div align="center">
        <p><br><?php echo "$row[sebutan_level_1] $row[nama_lembaga_sort]";?><br>
          <?php echo "$sebutan_kec $row[nama_kec]";?>,</p>
        <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><span class="style27"><?php echo strtoupper("$upk[namadepan] $upk[namabelakang]");?></span></p>
      </div></td>
  </tr>
  <tr height='140px';></tr>
<!--  <tr class="style9 align-justify">-->
<!--	<td colspan="4"><li style="margin-left: 70px; list-style: none;">Tembusan : <br/></li>-->
<!--<br>-->
<!--		<li style="margin-left: 70px;">-->

<!--		Kepala Desa <?php echo ("$nama_desa $nama_kec");?>-->
<!--	</li>-->
<!--</td>-->
<!--  </tr>-->
</table>
</body>
<title>Surat Tagihan</title>
      
</body>
		<?php } ?>