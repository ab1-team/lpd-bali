<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";

$lokasi=$_SESSION['lokasi'];
$id_pinj=$_GET['rcp'];

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
.mt-n-lg {margin-top: -30px;}
-->
</style>
<body onLoad="window.print()">
		<br>
    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="all">
       <?php 
		 $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten k, kecamatan c where k.id=c.kd_kab AND c.id='$lokasi' ")); 
			$nama_kec	=$row ['nama_kec'];
			$nama_lembaga_sort	=$row ['nama_lembaga_sort'];
			$nama_lembaga_long	=$row ['nama_lembaga_long'];
			$alamat_kec	=$row ['alamat_kec'];
			$telpon_kec	=$row ['telpon_kec'];
			$email_kec	=$row ['email_kec'];
			$web_kec	=$row ['web_kec'];
			$visi		=$row ['visi_misi'];
			$nama_kab	=$row ['nama_kab'];
			$logo		=$row ['logo'];
			if (empty($logo)) {$clogo="upk.png";}else{$clogo="logo/$logo";}
			
			$nomor_bh	=$row ['nomor_bh'];
			if (empty($nomor_bh)) {$bh="";}else{$bh="BADAN HUKUM NOMOR. $nomor_bh<br>";}
			
			$rcp=$_GET['rcp'];
		$r=mysql_fetch_array(mysql_query("SELECT * FROM
							kecamatan kc, desa d, sebutan_desa sd, kelompok_$_SESSION[kd_kab] k, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
							fungsi_kelompok fgs, users u, sistem_angsuran sa, pinjaman_kelompok_$_SESSION[kd_kab] pk
							WHERE
							kc.id=k.lokasi AND d.id=k.desa AND sd.id=d.sebutan AND pk.id_kel=k.id AND jpp.id=pk.jenis_pp AND ju.id=k.jenis_usaha AND 			
							jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND 
							sa.id=pk.sistem_angsuran AND pk.id='$rcp'"));

		?>

      <tr align="center">
        <td colspan="3" class="style6 all">
		<img src="../../../images/header_cover.png" style="width:750;"/><br>
		<div class="mt-n-lg">
		<span class="style3"><?php echo strtoupper("$nama_lembaga_long");?></span><br>
		<b><?php echo strtoupper("KECAMATAN $nama_kec KABUPATEN $nama_kab");?></b><br>
		<span class="style9">
		<?php echo "$bh $alamat_kec $nama_kec $nama_kab Telp.$telpon_kec <br>E-mail. $email_kec Website : $web_kec";?></span>
		</div>
		</td>
      </tr>
	  <tr align="center" height="50">
	    <td colspan="3" class="style6 left right">&nbsp;</td>
      </tr>
	  <tr align="center">
	    <td colspan="3" class="style3 left right"><strong>PROPOSAL/USULAN KEGIATAN</strong>
		<br><?php echo strtoupper($r['deskripsi_jpp']); ?>
		<br>KELOMPOK <?php echo strtoupper($r['nama_kelompok']);?><br><?php echo strtoupper("$r[sebutan_desa] $r[nama_desa]");?>
		</td>
      </tr>
	  <tr align="center" height="380">
		<td colspan="3" class="style6 left right"><img src="../../../images/<?php echo $clogo;?>" width="200px"/></td>
	  </tr>
	  <tr align="center">
	    <td class="style6 left"></td>
        <td class="style6">
		<span class="style6">Tanggal Proposal :<br><b><?php echo tgl_indo($r['tgl_proposal']);?></b><br><br>Alokasi :<br><b><?php echo number_format($r['proposal']);?></b></span><br><br><br>
		</td>
        <td class="style6 right">&nbsp;</td>
	  </tr>
	  <tr align="center">
        <td colspan="3" class="style6 all"><br>
		<span class="style9">Diajukan Oleh : </span><br>
		<?php echo strtoupper("Kelompok $r[nama_kelompok] $r[sebutan_desa]  $r[nama_desa] <br>$nama_kec $nama_kab<br>Tahun ".substr($r['tgl_proposal'],0,4)."<br><br>");?> </td>
      </tr>
</table>
</body>
<title>Cover Proposal <?php echo "Kelompok $r[nama_kelompok] $r[sebutan_desa]  $r[nama_desa]";?></title>
      
</body>
