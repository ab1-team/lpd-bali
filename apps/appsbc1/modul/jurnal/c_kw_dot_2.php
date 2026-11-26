<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/terbilang.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_pinjaman.php";
include "../../js/bar128.php";			 
?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px;  letter-spacing: 5px;}
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; letter-spacing: 5px;}
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; padding:0 0 5px 5px;}
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.pull-right	{float: right; }
-->
</style>
<body onLoad="window.print()">

     	   <?php
		$idt=$_GET['idt'];
		$lokasi=$_SESSION['lokasi'];
		$row=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan c, rekening_$_SESSION[lokasi] r, transaksi_$_SESSION[lokasi] t
							WHERE
							c.id='$_SESSION[lokasi]' AND r.kd_rekening=t.rekening_debit AND idt='$idt' OR
							c.id='$_SESSION[lokasi]' AND r.kd_rekening=t.rekening_kredit AND idt='$idt'"));
							
							
							$ketuaupk			=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='1' AND sejak<='$row[tgl_transaksi]' "));
							$bendaharaupk		=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE lokasi='$lokasi' AND level='1' AND jabatan='3' AND sejak<='$row[tgl_transaksi]' "));
											
		
			?>
	
    <table width="91%" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
			<td height="20" colspan="4" class="bottom">
				<img src="../../images/logo/<?php echo $row['logo'];?>" style="width:20px; margin-right:5px; float:left;"/>
				<div class="style9 text-align-left"><b><?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]";?></b><br>
				<?php echo $row['alamat_kec'];?> <i class="fa fa-phone-square"></i> <?php echo $row['telpon_kec'];?>				</div>			
			</td>
  </tr> 	  
      
	  <tr>
	    <th height="47" colspan="4" class="style6 ">K W I T A N S I<br><span class="style9">Nomor : <?php echo $idt;?> Tanggal : <?php echo tgl_ind($row['tgl_transaksi']);?></span></th>
      </tr>

	  <tr>
	    <td width="116" class="style9">&nbsp;</td>
	    <td width="197" class="style9">Telah Diterima Dari </td>
	    <td colspan="2" class="style9 ">: <strong><?php echo "$row[nama_lembaga_sort] Kecamatan $row[nama_kec]"; ?></strong><p class="bottom"></td>
      </tr>
	  <tr>
	    <td width="116" class="style9">&nbsp;</td>
	    <td class="style9">Uang Sebanyak </td>
	    <td colspan="2" class=" style9">: <strong><?php echo ucwords(toTerbilang($row['jumlah']));?> Rupiah</strong><p class="bottom"></td>
      </tr>
	  <tr>
	    <td width="116" class="style9">&nbsp;</td>
	    <td class="style9">Untuk Pembayaran </td>
	    <td colspan="2" class=" style9">: <strong><?php echo $row['keterangan_transaksi']; ?></strong>
        <p class="bottom"></td>
      </tr>
	  <tr>
	    <td width="116" class="style9">&nbsp;</td>
	    <td class="style9">Kode Akun. </td>
	    <td colspan="2" class=" style9">: <strong><?php echo "$row[rekening_kredit] - $row[nama_rekening]"; ?></strong>
        <p class="bottom"></td>
      </tr>

	  <tr>
	    <td width="116" class="style9">&nbsp;</td>
	    <th class="style9"><hr class="garis">
          Rp. <?php echo number_format($row['jumlah']);?>,-
        <hr class="garis"></th>
	    <td colspan="2" class="style9"><div align="center"><?php echo "$row[nama_kec], ".tgl_indo($row['tgl_transaksi']) ?></div></td>
      </tr>

	  <tr>
	    <td colspan="2" class="style9"><p align="center">Setuju dibayarkan<br>
	      <?php echo "$row[sebutan_level_1]<br> $row[nama_lembaga_sort]";?> </p>
	      <p align="center">&nbsp;</p>
	      <p align="center">&nbsp;</p>
        <p align="center"><span class="style9"><strong><?php echo strtoupper("$ketuaupk[namadepan] $ketuaupk[namabelakang]"); ?></strong></span></p></td>
        <td class="style9"><p align="center">&nbsp;<br>Dikeluarkan oleh <br>
        <?php echo "$row[sebutan_level_3]<br> $row[nama_lembaga_sort]";?> </p>
          <p align="center">&nbsp;</p>
          <p align="center">&nbsp;</p>
        <p align="center"><span class="style9"><strong><?php echo strtoupper("$bendaharaupk[namadepan] $bendaharaupk[namabelakang]"); ?></strong></span></p></td>
        <td class="style9"><p align="center">&nbsp;<br>&nbsp;<br>
			Diterima Oleh,</p>
        <p align="center">&nbsp;</p>
        <p align="center">&nbsp;</p>
        <p align="center"><span class="style9"><strong>___________________</strong></span></p></td>
	  </tr>
	
</table>

<title>Kwitansi Transaksi</title>

	    
</body>
