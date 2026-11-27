<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

$id=$_SESSION['idb'];

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
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
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
		 $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten where id='$id' ")); 
			$nama_kab	=$row ['nama_kab'];
			$nama_lembaga	=$row ['nama_lembaga'];
			$alamat_kab	=$row ['alamat_kab'];
			$telpon_kab	=$row ['telpon_kab'];
			$email_kab	=$row ['email_kab'];
			$web_kab	=$row ['web_kab'];

		?>

      <tr align="center">
        <td colspan="3" class="style6 all">
		
		<b><?php echo strtoupper($nama_lembaga);?></b><br>
		<span class="style3">PUSAT WAEAPO</span><br><br>
		<span class="style9"><?php echo $row['no_bh'];?></span><br>
		<span class="style9"><?php echo "$alamat_kab, Kabupaten $nama_kab Telp. $telpon_kab";?></span>
		</td>
      </tr>
	 
	  <?php echo"
      	<tr align='center' height='20'>
	    <td colspan='5' class='style6 left right'>&nbsp;</td>
      </tr>
	  <tr align='center'> 
	    <td colspan='5' class='style3 left right'><strong>LAPORAN ".strtoupper($laporan)."</strong>
		<br>".strtoupper($jenis." ".tgl_indo($tgl))."
		</td>
      </tr>
     <tr height='90'>
     	<td class='style6 left right' colspan='5'></td>
     </tr>
      <tr>
      	<td colspan='5' class='style6 left right'>
      		<center><img src='../../../images/upk.png' width='40%''></center>
      	</td>
      </tr>
      <tr align='center' height='120'>
        <td class='style6 left right' colspan='5'>".$visi."
		</td>
	  
	  
	  ";
      ?>
	  <tr align="center">
        <td colspan="3" class="style6 all"><br>
		<span class="style9">Diterbitkan Oleh : </span><br>
		<b><?php echo strtoupper($nama_lembaga);?><br> PUSAT WAEAPO</b><br>
		<span class="style9">
		<?php echo "$alamat_kab $nama_kab<br>Telp.$telpon_kab E-mail. $email_kab<br>
		Website : $web_kab";?><br>copyright&copy;<?php echo date('Y');?></span><br><br></td>
      </tr>
</table>
</body>
<title>Cover Laporan <?php echo $laporan;?></title>
      
</body>
