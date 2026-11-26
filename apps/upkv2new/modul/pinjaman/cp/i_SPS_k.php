<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style16 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; text-align:center; }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.allborder	{border: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.style28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.center {text-align:center; }
-->
</style>
<body>

     	   <?php
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
											$pros_jasa			=$row['pros_jasa'];
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
											$nama_kab			=$row['nama_kab'];
											$nama_desa			=$row['nama_desa'];
											$sebutan_desa		=$row['sebutan_desa'];
											$sebutan_kades		=$row['sebutan_kades'];
											
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
											$nik_penjamin		=$row['nik_penjamin'];
											$wajibjasaaja		=wajibjasaaja_anggota($id_pinj);
											$wajibjasa			=($wajibjasaaja*$sistem);
				
			?>
	
    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tr>
			<td height="20" colspan="2" class="bottom">
				<div class="style9 text-align-left"><?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?><br>
				<?php echo $row['alamat_kec'];?> <i class="fa fa-phone-square"></i> <?php echo $row['telpon_kec'];?>
				</div>
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9">Dokumen Pencairan<br>
			Loan ID. <?php echo "$id_pinj";?>
			 </div></td>
	  </tr> 
</table>

<p class="style16">
	<br>SURAT PERNYATAAN <?php echo strtoupper($row['kekeluargaan']);?><br>
	<br>
	<br>
</p>

	  <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" style="margin-left:30px;">
      <tr>
        <td height="19" colspan="24" class="style9"><p align="justify">
		Saya yang bertanda tangan di bawah ini :</p>        </td>
      </tr>
      <tr>
      	<td height="25" class="style9" width="24%">
        <ul style="list-style:none; margin-left:15px; padding:0px;">
	        <li>Nama</li> 
			<li>Alamat </li> 
			<li>No KTP </li> 
		</ul>
		</td>

        <td height="25" colspan="23" class="style27">
        <ul style="list-style:none; margin-left:0px; padding:0px;">
        	<li>: <?php echo strtoupper($row['penjamin']); ?> <br> </li> 
			<li>: </li> 
			<li>: <?php echo strtoupper($row['nik_penjamin']); ?></li> 
		</ul>
		</td>

      </tr>
      <tr>
      	<td colspan="24"></td>
      </tr>
      <tr>
        <td height="25" colspan="24" class="style9"><div align="justify">
		Adalah <?php echo $row['kekeluargaan'];?> dari :</div></td>
      </tr>
      <tr>
        <td height="25" class="style9" width="24%">
        <ul style="list-style:none; margin-left:15px; padding:0px;">
	        <li>Nama</li> 
			<li>Alamat </li> 
			<li>Pekerjaan</li> 
			<li>No KTP </li> 
			<li>Kedudukan dalam kelompok</li> 
		</ul>
		</td>

        <td height="25" colspan="23" class="style27">
        <ul style="list-style:none; margin-left:0px; padding:0px;">
        	<li>: <?php echo strtoupper($row['namadepan']); ?> </li> 
			<li>: <?php echo $row['alamat'];?></li> 
			<li>: <?php echo $row['nama_usaha'];?></li> 
			<li>: <?php echo $row['nik'];?></li> 
			<li>: </li> 
		</ul>
		</td>
      </tr>

        <td height="37" colspan="24" class="style9"><div align="justify">
        <ul style="list-style:none; margin-left:15px; padding:0px;">
		<li>Menerangkan dengan sebenarnya, bahwa saya mengetahui dan menyetujui pinjaman sebesar Rp.<?php echo number_format($row['alokasi']);?> ,- (<?php echo ucwords(toTerbilang($alokasi)); ?> Rupiah) pada Kelompok <?php echo "$nama_jpp $nama_kelompok";?> yang akan di ajukan ke <?php echo $row['nama_lembaga_sort']; ?> Kecamatan <?php echo $row['nama_kec']; ?> Sebagai salah satu syarat pengajuan pinjaman. Apabila pinjaman tersebut bisa dicairkan maka dana itu akan kami pergunakan untuk ............................................
		<br>................................................................................................................................
		<br>Sebagai bentuk tanggung jawab saya sebagai <?php echo $row['kekeluargaan'] ?>, maka saya akan turut bertanggung jawab dalam melaksanakan kewajiban pengembalian dana tersebut.
		<br><br>Demikan surat penytaan ini saya buat dengan sebenarnya tanpa ada unsur paksaan dari siapapun.
</li>
		</ul>
        </div></td>
      </tr>
      
 
</table>
<br>
<br>
<br>


<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
   
   <tr>
        <td width="28%" height="36" colspan="1" class="style26"><div align="center" class="style9">
          <p>&nbsp;</p>
          <p></p>
        </div></td>
        <td colspan="2" class="style26"><div align="center" class="style9"><?php echo $nama_kec;?>, <?php echo tgl_indo($tgl_proposal);?>
            <p>Yang membuat pernyataan</p>
        </div></td>
    </tr>	
	<tr>
	    <th height="24" colspan="1" class="style9"><p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p></p></th>
        <th width="15%" colspan="2" class="style9"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
        <?php echo strtoupper($row['penjamin']); ?> <br>
        Penjamin </th>
  </tr>


      <tr>
        <td height="20" colspan="-1" class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
      </tr>
  
      <tr>
        <td height="20" colspan="-1" class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
        <td class="style9">&nbsp;</td>
      </tr>
      
</table>

<title>1. Surat Pernyataan Penjamin <?php echo "$row[namadepan] ($id_pinj)";?> Desa <?php echo $nama_desa;?></title>
<?php } ?>        
</body>
