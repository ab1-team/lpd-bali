<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/terbilang.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman_individu.php";
include "../../js/bar128.php";
include "../../inc/fungsi_keuangan.php";			 
?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; padding:0 0 5px 5px;}
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.pull-right	{float: right; }
.rotasi	{font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 20px; transform: rotate(270deg); }
-->
</style>
<body onLoad="window.print()">

     	   <?php
		$idt=$_GET['idt'];
		$lokasi=$_SESSION['lokasi'];
		$row=mysql_fetch_array(mysql_query("SELECT * FROM desa d, rekening_$_SESSION[lokasi] r, transaksi_$_SESSION[lokasi] t
							WHERE
							d.id='$_SESSION[lokasi]' AND r.kd_rekening=t.rekening_debit AND idt='$idt' OR
							d.id='$_SESSION[lokasi]' AND r.kd_rekening=t.rekening_kredit AND idt='$idt'"));
							
							
							$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$row[tgl_transaksi]' "));
							$bendaharaupk		=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='3' AND sejak<='$row[tgl_transaksi]' "));
											
		
			?>
	
    <table width="91%" border="0" align="center" cellpadding="3" cellspacing="0">	  

	  <tr>
		<td height="20" colspan="3" class="top left bottom">
				<img src="../../images/logo_lpd.gif" style="width:30px; margin-right:5px; float:left;"/>
				<div class="style9 text-align-left"><b><?php echo strtoupper("LPD Desa $row[nama_desa]");?></b><br>
				<?php echo $row['alamat_desa'];?> Telp.<?php echo $row['telpon_desa'];?>				</div>			
		</td>
	    <td class="style9 top bottom right" width="27%" align="right">
	      <?php echo bar128(stripslashes("$idt")); ?>
		</td>
      </tr>
	  <tr>
	    <td height="47" colspan="4" class="style6 left right" align="center"><strong>K W I T A N S I</strong><br><span class="style9">Nomor: <strong><?php echo $idt;?></strong> Tanggal: <strong><?php echo tgl_ind($row['tgl_transaksi']);?></strong></span></td>
      </tr>
	  <tr>
	    <td width="15%" class="left" rowspan="7"><div class="rotasi">&nbsp;</div></td>
	    <td width="30%" class="style9">Telah Diterima Dari </td>
	    <td width="55%" colspan="2" class="style9 right">: <strong><?php echo strtoupper("LPD Desa $row[nama_desa] Kecamatan $row[nama_kec]"); ?></strong><p class="bottom"></td>
      </tr>
	  <tr>
	    <td class="style9">Uang Sebanyak </td>
	    <td colspan="2" class="right style9">: <strong><?php echo strtoupper(toTerbilang($row['jumlah']));?> RUPIAH</strong><p class="bottom"></td>
      </tr>
	  <tr>
	    <td class="style9">Untuk Pembayaran </td>
	    <td colspan="2" class="right style9">: <strong><?php echo strtoupper($row['keterangan_transaksi']); ?></strong>
        <p class="bottom"></td>
      </tr>
	  <tr>
	    <td class="style9">Kode Akun. </td>
	    <td colspan="2" class="right style9">: <strong><?php echo strtoupper("$row[rekening_debit] - ".namarek($row['rekening_debit']).""); ?></strong>
        <p class="bottom"></td>
      </tr>

	  <tr>
	    <td class="style6" align="center" rowspan="2"><hr class="garis">
          Rp. <?php echo number_format($row['jumlah'],0,',','.');?>,-
        <hr class="garis"></td>
	    <td colspan="2" class="style9 right" align="center"><?php echo strtoupper("$row[nama_desa], ".tgl_indo($row['tgl_transaksi'])) ?></td>
	  </tr>
	  <tr>
	    <td class="style9" align="center">Dikeluarkan oleh <br>Bag.Keuangan,</td>
	    <td class="style9 right" align="center">Setuju dibayarkan<br>Kepala,</td>
	  </tr>
	  <tr>
	    <td  class="style9" align="center">Diterima Oleh,
			<p align="center">&nbsp;</p>
			<p align="center"><span class="style9"><strong>___________________</strong></span></p>
		</td>
        <td class="style9" align="center">
          <p align="center">&nbsp;</p>
          <p align="center">&nbsp;</p>
			<p align="center"><span class="style9"><strong><?php echo strtoupper("$bendaharaupk[namadepan] $bendaharaupk[namabelakang]"); ?></strong></span></p>
		</td>
        <td class="style9 right" align="center">
			<p align="center">&nbsp;</p>
			<p align="center">&nbsp;</p>
			<p align="center"><strong><?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?></strong></p>
		</td>
	  </tr>
	  <tr><td colspan="4" class="style9 right left bottom">&nbsp;</td></tr>
</table>

<title>Kwitansi Transaksi</title>

	    
</body>
