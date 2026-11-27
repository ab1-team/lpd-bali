<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

$lokasi=$_SESSION['lokasi'];

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
		$row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c, sebutan_desa sd, desa d where k.id=c.kd_kab AND c.id=d.kd_kec AND sd.id=d.sebutan AND d.id='$lokasi' ")); 
		
											
				
			?>
		<tr align="center" height="20">
			    <td colspan="5" class="style6 left right top">&nbsp;</td>
		      </tr>
			  <tr height="330">
			      	<td colspan='5'  class="left right">
			      		<center><?php
							echo "<img class='' alt='...' src='../../../images/logo_bumdes.png' width='25%'>";
							
							?>
							</center>			      	</td>
			      </tr>
			  <tr align="center" height='200'> 
			    <td colspan="5" class="style3 left right"><p><strong>LAPORAN <?php echo strtoupper($laporan);?></strong>
			      <br>
			      <?php  echo strtoupper($jenis." ".tgl_indo($tgl)); ?>
			      <br>
			      <br>
			      </p>
			      <p>&nbsp;</p>
			      <p><br>
			        <span class="style99">Disusun Oleh:</span><br>
	                <br/>
			        <strong class="style99">
		            <?php  
					$dat=mysql_query("SELECT * FROM users where lokasi='$lokasi' and level='1' "); 
						while($u=mysql_fetch_array($dat)) {
					echo strtoupper("$u[namadepan] $u[namabelakang]<br>"); 
						}
					?>
					</strong>
	                </p>
		        <p>&nbsp;</p>
		        <p>&nbsp;</p>
		        <p>&nbsp;</p></td>
		      </tr>
			      
			  <tr>
			  	<td  class="left right" width="6%" colspan="5" align="center" height="80px;"></td>
			  </tr>

			  <tr height='15'>
			  	<td width="10%" class="left"></td>
			  	<td width="7%"></td>
			  	<td class="style99" width="10%" align="center">&nbsp;</td>
			  	<td width="7%"></td>
			  	<td width="10%"  class="right"></td>
			  </tr>


	  

	  <tr align="center">
        <td colspan="5" class="style6 all"><br>
		<span class="style9">Diterbitkan Oleh : </span><br><br>
		<b><?php echo strtoupper(LEMBAGA_LONG); ?><BR><?php echo strtoupper("$row[sebutan_desa] $row[nama_desa]"); ?></b><br>
		<span class="style9">
		<?php echo "Office: $row[alamat_desa] $row[nama_desa] $row[nama_kec] $row[nama_kab]<br>Telp.$row[telpon_desa] E-mail. $row[email_desa]";?><br>copyright&copy;<?php echo date('Y');?></span><br><br>        </td>
      </tr>
</table>
</body>
<title>Cover Laporan</title>
  
</body>
