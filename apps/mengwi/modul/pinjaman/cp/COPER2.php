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
		<span class="style3"> <?php echo strtoupper($row['sebutan_kec']);?> <?php echo strtoupper($nama_kec);?></span><br>
		<b>KABUPATEN  <?php echo strtoupper($nama_kab);?></b><br>
		<span class="style9"><?php echo "$alamat_kec $nama_kec $nama_kab <br>Telp. $telpon_kec";?></span>
		</td>
      </tr>
		<?php
		$id	= $_SESSION['idprop'];
		$row=mysql_fetch_array(mysql_query("select * from kecamatan kc, desa d, sebutan_desa sd, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj,
											kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE kc.id=k.lokasi AND d.id=k.desa AND sd.id=d.sebutan AND jpp.id=pk.jenis_pp AND sa.id=pk.sistem_angsuran AND jj.id=pk.jenis_jasa AND k.id=pk.id_kel AND pk.id='$id'"));
     		 $id_pinkel		=$row ['id'];
		 $dus=mysql_fetch_array(mysql_query("SELECT COUNT('id_pinkel') AS jumlahanggota FROM pinjaman_anggota_$_SESSION[kd_kab] pa WHERE pa.id_pinkel='$id_pinkel'"));
			$jumlah 	= $dus['jumlahanggota']; ?>
			  <tr align="center" height='150'> 
			    <td colspan="5" class="style3 left right"><strong>DOKUMEN PENCAIRAN</strong>
				<br><?php  echo strtoupper($row['deskripsi_jpp']); ?>
				<br/> Kelompok <?php  echo ucwords($row['nama_kelompok']); ?>
				 <?php  echo ucwords($row['sebutan_desa']); ?> <?php  echo ucwords($row['nama_desa']); ?>
				 <div class="style6"><b>No. SPK : </b>
			  	 <?php echo ucwords($row['spk_no']);?> </div>
				</td>
		      </tr>
			      <tr height="300">
			      	<td colspan='5'  class="left right">
			      		<center><img src="i.png" width="7%" height="300px;"></center>
			      	</td>
			      </tr>
			  <tr>
			  	<td width="6%" colspan="5" align="center" height="1px" class="left right"></td>

			  </tr>
			  
			  
			  <tr height='12'>
			  	<td width="10%" class="left"></td>
			  	<td width="7%"></td>
			  	<td class="style99" width="10%" align="center"><b>Tanggal Cair</b>
			  	<br/><?php echo tgl_indO($row['tgl_cair']);?>
			  	</td>
			  	<td width="7%"></td>
			  	<td width="10%" class="right"></td>
			  </tr>

			  <tr height='15'>
			  	<td width="10%" class="left"></td>
			  	<td width="7%"></td>
			  	<td class="style99" width="10%" align="center"><b>Alokasi</b>
			  	<br/>Rp.<?php echo number_format($row['alokasi']);?>
			  	</td>
			  	<td width="7%"></td>
			  	<td width="10%" class="right"></td>
			  </tr>
			  
			  <tr height='12'>
			  	<td width="10%" class="left"></td>
			  	<td width="7%"></td>
			  	<td class="style99" width="10%" align="center"><b>Tempo Angsuran</b>
			  	<br/><?php echo ($row['jangka']);?>
			  	</td>
			  	<td width="7%"></td>
			  	<td width="10%" class="right"></td>
			  </tr>
			  <?php
			  ?>
				<tr height='12'>
			  	<td width="10%" class="left"></td>
			  	<td width="7%"></td>
				
			  	<td class="style99" width="15%" align="center"><b>Jumlah Anggota Pemanfaat</b>
			  	<br/><?php echo "$jumlah";?>
			  	</td>
			  	<td width="7%"></td>
			  	<td width="10%" class="right"></td>
			  </tr>


			  
			  
			  <tr height="10">
			  	<td colspan="5" class="right left"></td>
			  </tr>

	  

	  <tr align="center">
        <td colspan="5" class="style6 all"><br>
		<span class="style9">Diterbitkan Oleh : </span><br>
		<b><?php echo $nama_lembaga_long; ?> <br><?php echo "$sebutan_kec $nama_kec";?> Kabupaten <?php echo $nama_kab;?></b><br>
		<span class="style9">
		<?php echo "$alamat_kec $nama_kec $nama_kab<br>Telp.$telpon_kec E-mail. $email_kec<br>
		Website : $web_kec";?><br>copyright&copy;<?php echo date('Y');?></span><br><br>        </td>
      </tr>
</table>
</body>
<title>Cover Laporan <?php echo $laporan;?></title>
      
</body>
