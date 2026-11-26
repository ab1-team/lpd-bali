<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";


$lokasi=$_SESSION[lokasi];
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

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
.all	{border: 1px solid #000000; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
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
		$kueri3 = "SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='16'";
		$jalankan3 = mysql_query($kueri3);
		$tampil3 = mysql_fetch_array($jalankan3);
		$kueri3 = "SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='16'";
		$jalankan3 = mysql_query($kueri3);
		$tampil3 = mysql_fetch_array($jalankan3);
		$id_user = $tampil3['id'];
		$kueri4 = "SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='16' AND id!='$id_user'";
		$jalankan4 = mysql_query($kueri4);
		$tampil4 = mysql_fetch_array($jalankan4);
		$kueri5 = "SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='4'";
		$jalankan5 = mysql_query($kueri5);
		$tampil5 = mysql_fetch_array($jalankan5);
		$kueri6 = "SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='7'";
		$jalankan6 = mysql_query($kueri6);
		$tampil6 = mysql_fetch_array($jalankan6);
		
				
		?>


      <tr align="center">
        <td colspan="5" class="style6 all">
		<?php
											 $logo=$row['logo'];
											if (empty($logo)) {
											echo "<img class='' alt='...' src='../../../images/upk.png' style='float:left; width:100; margin:20px 0 20px 20px;'>";
											}else{
											echo "<img class='' alt='...' src='../../../images/logo/$logo' style='float:left; width:100; margin:20px 0 20px 20px;'>";
											}
										?>		
		<br>
		<b><?php echo strtoupper($nama_lembaga_long);?></b><br>
		<span class="style3">KECAMATAN <?php echo strtoupper($nama_kec);?></span><br>
		<b>KABUPATEN  <?php echo strtoupper($nama_kab);?></b><br>
		<span class="style9"><?php echo "$alamat_kec $nama_kec $nama_kab <br>Telp. $telpon_kec";?></span>
		</td>
      </tr>
      <?php if ($_SESSION['lokasi']=='177') {
      	echo"

      	<tr align='center' height='20'>
	    <td colspan='5' class='style6 left right'>&nbsp;</td>
      </tr>
	  <tr align='center'> 
	    <td colspan='5' class='style3 left right'><strong>LAPORAN ".strtoupper($laporan)."</strong>
		<br>".strtoupper($jenis." ".tgl_indo($tgl))."
		</td>
      </tr>
     <tr height='40'>
     	<td colspan='5'></td>
     </tr>
      <tr>
      	<td colspan='5'>
      		<center><img src='icon.png' width='60%''></center>
      	</td>
      </tr>
      <tr align='center' height='50'>
        <td class='style6' colspan='5'>".$visi."
		</td>
	  </tr>
	  	  <tr height='70'>
	  	<td colspan='5'></td>
	  </tr>
	  <tr>
	  	<td width='6%' colspan='5' align='center'>Disusun Oleh</td>

	  </tr>

	    <tr height='15'>
	  	<td width='13%'></td>
	  	<td width='18%'></td>
	  	<td width='1%'></td>
	  	<td width='25%'></td>
	  	<td width='5%'></td>
	  </tr>
	  <tr class='style12' height='40'>
	  	<td></td>
	  	<td>".$sebutan1."</td>
	  	<td>:</td>
	  	<td>".$tampil['namadepan']." ".$tampil['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td>".$sebutan2."</td>
	  	<td>:</td>
	  	<td>".$tampil1['namadepan']." ".$tampil1['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td>".$sebutan3."</td>
	  	<td>:</td>
	  	<td>".$tampil2['namadepan']." ".$tampil2['namabelakang']."</td>
	  	<td></td>
	  </tr>	 
	  <tr class='style12'>
	  	<td></td>
	  	<td>Staff UPK</td>
	  	<td>:</td>
	  	<td>".$tampil3['namadepan']." ".$tampil3['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td></td>
	  	<td></td>
	  	<td>".$tampil4['namadepan']." ".$tampil4['namabelakang']."</td>
	  	<td></td>
	  </tr>


      	";
      } else if ($_SESSION['lokasi']=='176') {
      	echo"

      	<tr align='center' height='20'>
	    <td colspan='5' class='style6'>&nbsp;</td>
      </tr>
	  <tr align='center'> 
	    <td colspan='5' class='style3'><strong>LAPORAN ".strtoupper($laporan)."</strong>
		<br>".strtoupper($jenis." ".tgl_indo($tgl))."
		</td>
      </tr>
     <tr height='40'>
     	<td colspan='5'></td>
     </tr>
      <tr>
      	<td colspan='5'>
      		<center><img src='kerambitan.jpg' width='50%''></center>
      	</td>
      </tr>
      <tr align='center' height='50'>
        <td class='style6' colspan='5'>".$visi."
		</td>
	  </tr>
	  	  <tr height='80'>
	  	<td colspan='5'></td>
	  </tr>
	  <tr>
	  	<td width='6%' colspan='5' align='center'>Disusun Oleh</td>

	  </tr>

	   <tr height='15'>
	  	<td width='13%'></td>
	  	<td width='18%'></td>
	  	<td width='1%'></td>
	  	<td width='25%'></td>
	  	<td width='5%'></td>
	  </tr>
	  <tr  class='style12' height='40'>
	  	<td></td>
	  	<td>".$sebutan1."</td>
	  	<td>:</td>
	  	<td>".$tampil['namadepan']." ".$tampil['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td>".$sebutan2."</td>
	  	<td>:</td>
	  	<td>".$tampil1['namadepan']." ".$tampil1['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td>".$sebutan3."</td>
	  	<td>:</td>
	  	<td>".$tampil2['namadepan']." ".$tampil2['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td>Staff UPK</td>
	  	<td>:</td>
	  	<td>".$tampil3['namadepan']." ".$tampil3['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td></td>
	  	<td></td>
	  	<td>".$tampil4['namadepan']." ".$tampil4['namabelakang']."</td>
	  	<td></td>
	  </tr>
      	";
      }else if ($_SESSION['lokasi']=='204') {
      	echo"
      	<tr align='center' height='140'>
	    <td colspan='5' class='style6 left right'>&nbsp;</td>
      </tr>
	  <tr align='center'> 
	    <td colspan='5' class='style3 left right'><strong>LAPORAN ".strtoupper($laporan)."</strong>
		<br>".strtoupper($jenis." ".tgl_indo($tgl))."
		</td>
      </tr>
     <tr height='40'>
     	<td colspan='5'></td>
     </tr>
      <tr align='center' height='300'>
        <td class='style6' colspan='5'>".$visi."
		</td>
	  </tr>

	  <tr>
	  	<td width='6%' colspan='5' align='center'>Disusun Oleh</td>

	  </tr>

	   <tr height='15'>
	  	<td width='24%'></td>
	  	<td width='13%'></td>
	  	<td width='1%'></td>
	  	<td width='24%'></td>
	  	<td width='10%'></td>
	  </tr>
	  <tr class='style12' height='40'>
	  	<td></td>
	  	<td>".$sebutan1."</td>
	  	<td>:</td>
	  	<td>".$tampil['namadepan']." ".$tampil['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td >".$sebutan2."</td>
	  	<td>:</td>
	  	<td>".$tampil1['namadepan']." ".$tampil1['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td>".$sebutan3."</td>
	  	<td>:</td>
	  	<td>".$tampil2['namadepan']." ".$tampil2['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td>Staff UPK</td>
	  	<td>:</td>
	  	<td>".$tampil3['namadepan']." ".$tampil3['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td></td>
	  	<td></td>
	  	<td>".$tampil4['namadepan']." ".$tampil4['namabelakang']."</td>
	  	<td></td>
	  </tr>

	";
      }else{
      	echo "

      <tr align='center' height='80'>
	    <td colspan='5' class='style6 left right'>&nbsp;</td>
      </tr>
	  <tr align='center'> 
	    <td colspan='5' class='style3 left right'><strong>LAPORAN ".strtoupper($laporan)."</strong>
		<br>".strtoupper($jenis." ".tgl_indo($tgl))."
		</td>
      </tr>
     <tr height='40'>
     	<td colspan='5'><center><br><br>";
				$logo=$row['logo'];
				if (empty($logo)) {
				echo "<img class='' alt='...' src='../../../images/upk.png' style=' width:20%;'>";
				}else{
				echo "<img class='' alt='...' src='../../../images/logo/$logo' style=' width:20%;'>";
											}
											
	echo "</center></td>
     </tr>
      <tr align='center' height='230'>
        <td class='style6' colspan='5'>".$visi."
		</td>
	  </tr>

	  <tr>
	  	<td width='6%' colspan='5' align='center'>Disusun Oleh</td>

	  </tr>

	   <tr height='35'>
	  	<td width='24%'></td>
	  	<td width='13%'></td>
	  	<td width='1%'></td>
	  	<td width='24%'></td>
	  	<td width='10%'></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td>".$sebutan1."</td>
	  	<td>:</td>
	  	<td>".$tampil['namadepan']." ".$tampil['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td >".$sebutan2."</td>
	  	<td>:</td>
	  	<td>".$tampil1['namadepan']." ".$tampil1['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td>".$sebutan3."</td>
	  	<td>:</td>
	  	<td>".$tampil2['namadepan']." ".$tampil2['namabelakang']."</td>
	  	<td></td>
	  </tr>";
	  if ($_SESSION['lokasi']=='220' OR $_SESSION['lokasi']=='200' ) {echo "<br>";} //lokasi sruweng dan sodonghilir
	  elseif ($_SESSION['lokasi']=='138' ) { //talun
	      echo "<tr class='style12'>
	  	<td></td>
	  	<td>MANAGER DANA BERGULIR</td>
	  	<td>:</td>
	  	<td>".$tampil5['namadepan']." ".$tampil5['namabelakang']."</td>
	  	<td></td>
	  </tr>
	";} elseif ($_SESSION['lokasi']=='144' OR $_SESSION['lokasi']=='107' ) { //ponggok
	      echo "<tr class='style12'>
	  	<td></td>
	  	<td>".$row['sebutan_level_7']."</td>
	  	<td>:</td>
	  	<td>".$tampil6['namadepan']." ".$tampil6['namabelakang']."</td>
	  	<td></td>
	  </tr>
	";}
	  else{
	  echo "<tr class='style12'>
	  	<td></td>
	  	<td>Staff UPK</td>
	  	<td>:</td>
	  	<td>".$tampil3['namadepan']." ".$tampil3['namabelakang']."</td>
	  	<td></td>
	  </tr>
	  <tr class='style12'>
	  	<td></td>
	  	<td></td>
	  	<td></td>
	  	<td>".$tampil4['namadepan']." ".$tampil4['namabelakang']."</td>
	  	<td></td>
	  </tr>

	";
      }}

      ?>
	  

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
      
</body>
