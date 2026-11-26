<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

$lokasi=$_SESSION[lokasi];
$d=$_GET['d'];
$m=$_GET['m'];
$y=$_GET['y'];
$tgl="$y-$m-$d";

if($d=$d){$laporan="Harian"; $jenis="Tanggal";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun";}else{$laporan="Global";}

?>

<style type="text/css">
<!--
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 24px;  }
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style99 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 13px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.all	{border: 1px solid #000000; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }


-->
</style>
<body onLoad="window.print()">
		<br>
    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="all">
       <?php 
		 $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' ")); 
			$nama_lembaga_long	=$row ['nama_lembaga_long'];
			$nama_kec	=$row ['nama_kec'];
			$alamat_kec	=$row ['alamat_kec'];
			$telpon_kec	=$row ['telpon_kec'];
			$email_kec	=$row ['email_kec'];
			$web_kec	=$row ['web_kec'];
			$visi		=$row ['visi_misi'];
			$nama_kab	=$row ['nama_kab'];

		?>

	    <tr align="center">
	        <td colspan="5" class="style6 all">
		<?php
			$logo=$row['logo'];
			if (empty($logo)) {
			echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:100; margin:10px 0 10px 20px;'>";
			}else{
			echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:100; margin:10px 0 10px 20px;'>";
			}
			?>		
		<br>
		<b><?php echo strtoupper($nama_lembaga_long);?></b><br>
		<span class="style3">KECAMATAN <?php echo strtoupper($nama_kec);?></span><br>
		<b>KABUPATEN  <?php echo strtoupper($nama_kab);?></b><br>
		<span class="style9"><?php echo "$alamat_kec $nama_kec $nama_kab <br>Telp. $telpon_kec";?></span>
		</td>
      </tr>
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
				
			?>
		<tr align="center" height="20">
			    <td colspan="5" class="style6 left right">&nbsp;</td>
		      </tr>
			  <tr align="center" height='200'> 
			    <td colspan="5" class="style3 left right"><strong>DOKUMEN PENCAIRAN</strong>
				<br><?php 
				if($_SESSION['lokasi']==122 or $_SESSION['lokasi']==1){
				    echo $row['nama_jpp'];
				}else{
				echo strtoupper($row['deskripsi_jpp']); 
				}?>
				<br/>  <u><?php  echo ucwords($row['namadepan']); ?></u>
				<br/> <span style="font-size: 20px;">NIK:<?php  echo ucwords($row['nik']); ?></span>
				<br/> <?php echo strtoupper("$r[sebutan_desa] $r[nama_desa]");?>
				</td>
		      </tr>
			      <tr height="330">
			      	<td colspan='5'>
			      		<center><img src="i.png" width="7%" height="300px;"></center>
			      	</td>
			      </tr>
			  <tr>
			  	<td width="6%" colspan="5" align="center" height="70px;"><b><?php echo "No. SPK : $spk_no"; ?></b></td>

			  </tr>
			  <tr height='12'>
			  	<td width="10%"></td>
			  	<td width="7%"></td>
			  	<td class="style99" width="10%" align="center"><b>Tanggal Cair</b>
			  	<br/><?php echo tgl_indO($row['tgl_cair']);?>
			  	</td>
			  	<td width="7%"></td>
			  	<td width="10%"></td>
			  </tr>

			  <tr height='15'>
			  	<td width="10%"></td>
			  	<td width="7%"></td>
			  	<td class="style99" width="10%" align="center"><b>Alokasi</b>
			  	<br/>Rp.<?php echo number_format($row['alokasi']);?>
			  	</td>
			  	<td width="7%"></td>
			  	<td width="10%"></td>
			  </tr>
			  <tr height="10">
			  	<td></td>
			  </tr>

	  

	  <tr align="center">
        <td colspan="5" class="style6 all"><br>
		<span class="style9">Diterbitkan Oleh : </span><br>
		<b><?php echo $nama_lembaga_long; ?> <br>Kecamatan <?php echo $nama_kec;?> Kabupaten <?php echo $nama_kab;?></b><br>
		<span class="style9">
		<?php echo "$alamat_kec $nama_kec $nama_kab<br>Telp.$telpon_kec E-mail. $email_kec<br>
		Website : $web_kec";?><br>copyright&copy;<?php echo date('Y');?></span><br><br>        </td>
      </tr>
</table>
</body>
<title>Cover Laporan <?php echo $laporan;?></title>
<?php } ?>  
</body>
