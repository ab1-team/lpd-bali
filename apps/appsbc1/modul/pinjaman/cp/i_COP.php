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
		 $row=mysql_fetch_array(mysql_query("SELECT * FROM kabupaten a, kecamatan c where a.id=c.kd_kab AND c.id='$lokasi' ")); 
			$nama_kec	=$row ['nama_kec'];
			$nama_lembaga_sort	=$row ['nama_lembaga_sort'];
			$nama_lembaga_long	=$row ['nama_lembaga_long'];
			$alamat_kec	=$row ['alamat_kec'];
			$telpon_kec	=$row ['telpon_kec'];
			$email_kec	=$row ['email_kec'];
			$web_kec	=$row ['web_kec'];
			$visi		=$row ['visi_misi'];
			$nama_kab	=$row ['nama_kab'];
			
			$rcp=$_GET['rcp'];
		$r=mysql_fetch_array(mysql_query("select * from kecamatan kc, desa d, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, 
													anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																kc.id=a.lokasi AND d.id=a.desa AND jpp.id=pi.jenis_pp AND
																sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND
																a.id=pi.nia AND pi.id='$rcp'"));

		?>

      <tr align="center">
        <td colspan="3" class="style6 all">
		<img src="../../../images/header_cover.png" style="width:750;"/><br>
		<div class="mt-n-lg">
		<b><?php echo strtoupper("$nama_lembaga_long");?></b><br>
		<span class="style3"><?php echo strtoupper("$nama_lembaga_sort KECAMATAN $nama_kec");?></span><br>
		<b>KABUPATEN  <?php echo strtoupper($nama_kab);?></b><br>
		<span class="style9">
		<?php echo "$alamat_kec $nama_kec $nama_kab Telp.$telpon_kec <br>E-mail. $email_kec Website : $web_kec";?></span>
		</div>
		</td>
      </tr>
	  <tr align="center" height="160">
	    <td colspan="3" class="style6 left right">&nbsp;</td>
      </tr>
	  <tr align="center">
	    <td colspan="3" class="style3 left right"><strong>PROPOSAL PINJAMAN INDIVIDU</strong>
		<br><?php echo strtoupper($r['deskripsi_jpp']); ?><br>
		<br><strong><?php echo strtoupper($r['namadepan']);?></strong><br>NIK. <?php echo strtoupper($r['nik']);?><br><?php echo strtoupper("DESA $r[nama_desa]");?>
		</td>
      </tr>
	  <tr align="center" height="400">
	    <td class="style6 left">&nbsp;</td>
        <td class="style6">
		<span class="style6">Tanggal Proposal :<br><strong><?php echo tgl_indo($r['tgl_proposal']);?></strong></span>
		</td>
        <td class="style6 right">&nbsp;</td>
	  </tr>
	  <tr align="center">
        <td colspan="3" class="style6 all"><br>
		<?php echo strtoupper("$nama_lembaga_sort KECAMATAN $nama_kec<br>Tahun ".substr($r['tgl_proposal'],0,4)."<br><br>");?> </td>
      </tr>
</table>
</body>
<title>Cover Proposal <?php echo "Kelompok $r[nama_kelompok] Desa $r[nama_desa]";?></title>
      
</body>
