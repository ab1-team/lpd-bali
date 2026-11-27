<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

$lokasi=$_SESSION[lokasi];

$report				=$_POST['report'];
if (empty($report)) {
	$d					=$_GET['d'];
	$m					=$_GET['m'];
	$y					=$_GET['y'];
}else{
	$d					=$_POST['d'];
	$m					=$_POST['m'];
	$y					=$_POST['y'];
}

$tgl="$y-$m-$d";

if($d=$d){$laporan="Harian"; $jenis="Tanggal";}else if($m=$m){$laporan="Bulanan"; $jenis="Bulan";}else if($y=$y){$laporan="Tahunan"; $jenis="Tahun";}else{$laporan="Global";}

?>

<style type="text/css">
<!--
.style3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 24px;  }
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.style12 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.all	{border: 2px solid #000000; }
.top	{border-top: 2px solid #000000; }
.bottom	{border-bottom: 2px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }


-->
</style>
<body onLoad="window.print()">
		<br>
    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="all" style='font-family: Verdana, Arial, Helvetica, sans-serif;'>
       <?php 
		 $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' ")); 
			$nama_lembaga_long	=$row ['nama_lembaga_long'];
			$nama_kec	=$row ['nama_kec'];
			$alamat_kec	=$row ['alamat_kec'];
			$telpon_kec	=$row ['telpon_kec'];
			$email_kec	=$row ['email_kec'];
			$web_kec	=$row ['web_kec'];
			$visi1		=$row ['visi_misi'];
			if($visi1==$visi1){$visi=$visi1;}else{$visi='';}
			$nama_kab	=$row ['nama_kab'];
			$sebutan1 	=$row ['sebutan_level_1'];
			$sebutan2 	=$row ['sebutan_level_2'];
			$sebutan3 	=$row ['sebutan_level_3'];
			$logo		=$row ['logo'];
			if (empty($logo)) {$clogo="upk.png";}else{$clogo="logo/$logo";}
		?>
		<?php
		$kueri = "SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1'";
		$jalankan = mysql_query($kueri);
		$tampil = mysql_fetch_array($jalankan);
											

				
		?>
		<?php
		$kueri1 = "SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='2'";
		$jalankan1 = mysql_query($kueri1);
		$tampil1 = mysql_fetch_array($jalankan1);
											

				
		?>
		<?php
		$kueri2 = "SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='3'";
		$jalankan2 = mysql_query($kueri2);
		$tampil2 = mysql_fetch_array($jalankan2);
											

				
		?>

		<?php
		$kueri3 = "SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND (jabatan!='1' or jabatan!='2' or jabatan!='3') ";
		$jalankan3 = mysql_query($kueri3);
		$tampil3 = mysql_fetch_array($jalankan3);
		$kueri3 = "SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' and id!='$id_user' AND (jabatan!='1' and jabatan!='2' and jabatan!='3') ORDER BY jabatan ";
		$jalankan3 = mysql_query($kueri3);
		$tampil3 = mysql_fetch_array($jalankan3);
		$id_user = $tampil3['id'];
		$kueri4 = "SELECT * FROM users WHERE lokasi='$lokasi' AND level='1'  and id!='$id_user' AND (jabatan!='1' and jabatan!='2' and jabatan!='3') ORDER BY jabatan ";
		$jalankan4 = mysql_query($kueri4);
		$tampil4 = mysql_fetch_array($jalankan4);
		
				
		?>


      <tr align="center">
        <td colspan="5" class="style6 bottom">
				
		<br>
		<b><?php echo strtoupper($nama_lembaga_long);?></b><br>
		<span class="style3"><?php echo strtoupper($row['sebutan_kec']); echo " ".strtoupper($nama_kec);?></span><br>
		<b>KABUPATEN  <?php echo strtoupper($nama_kab);?></b><br>
		<span class="style9"><?php echo "$alamat_kec $nama_kec $nama_kab <br>Telp. $telpon_kec";?></span>
		</td>
      </tr>
      <?php echo"
      	<tr align='center' height='20'>
	    <td colspan='5' class='style6'>&nbsp;</td>
      </tr>
	  <tr align='center'> 
	    <td colspan='5' class='style3'><strong>LAPORAN ".strtoupper($laporan)."</strong>
		<br>".strtoupper($jenis." ".tgl_indo($tgl))."
		</td>
      </tr>
     <tr height='90'>
     	<td colspan='5'></td>
     </tr>
      <tr>
      	<td colspan='5'>
      		<center><img src='../../../images/logo/$logo' width='40%''></center>
      	</td>
      </tr>
      <tr align='center' height='120'>
        <td class='style6' colspan='5'>".$visi."
		</td>
	  </tr>
	  	  <tr height='70'>
	  	<td colspan='5'></td>
	  </tr>
	  <tr>
	  	<td width='6%' colspan='5' align='center'>Disusun Oleh</td>
	  </tr>
	  <tr height='20'>
	  	<td width='25%'></td>
	  	<td width='50%'></td>
	  	<td width='25%'></td>
	  </tr>
	  <tr class='style12' height='40'>
	  	<td></td>
	  	<td style='text-align: center;'>Pimpinan " . $nama_kec . "</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td style='text-align: center;'>".$tampil1['namadepan']." ".$tampil1['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr height='40' class='style12'>
	  	<td></td>
	  	<td></td>
	  	<td></td>
	  </tr>";
      ?>
	  

	  <tr align="center">
        <td colspan="5" class="style6 top"><br>
		<span class="style9">Diterbitkan Oleh : </span><br>
		<span class="style9">
		<?php echo "HP: $telpon_kec<br>
		Website : $web_kec";?><br>copyright&copy;<?php echo date('Y');?></span><br><br>        </td>
      </tr>
</table>
</body>
<title>Cover Laporan <?php echo $laporan;?></title>
      
</body>
