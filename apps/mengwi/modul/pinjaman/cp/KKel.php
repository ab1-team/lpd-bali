<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";
include "../../../js/bar128.php";			 
?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8px; }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 24px; text-align:center; font-weight: bold;}
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
-->
</style>
<body onLoad="window.print()">

     	 <?php
		$rcp=$_GET['rcp'];
		$row=mysql_fetch_array(mysql_query("SELECT * FROM
							kecamatan c, desa d, kelompok_$_SESSION[kd_kab] k
							WHERE
							c.id=k.lokasi AND d.id=k.desa AND k.kd_kelompok=$rcp "));
				
			?>
<h1 class="style1" style="margin-bottom:5px;">Kartu Kelompok</h1> 
<table width="110%" border="0" align="center" cellpadding="1" cellspacing="0" > 	  
      
      <tr>
        <td width="25%" rowspan="6" class="style9">&nbsp;</td>
        <td width="15%" class="style9">Nama Kelompok</td>
        <td width="35%" class="style9">: <?php echo strtoupper($row['nama_kelompok']);?></td>
        <td width="25%" rowspan="6" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td class="style9">Nama Ketua </td>
        <td class="style9">: <b><?php echo strtoupper($row['ketua']);?></b></td>
      </tr>
      <tr>
        <td class="style9">Tanggal Berdiri</td>
        <td class="style9">: <?php echo $row['tgl_berdiri'];?></td>
      </tr>
	  <tr>
        <td class="style9">Alamat</td>
        <td class="style9">: <?php echo "$row[alamat_kelompok]";?></td>
      </tr>
	  <tr>
        <td class="style9">Desa</td>
        <td class="style9">: <?php echo "$row[nama_desa]";?></td>
      </tr>
      <tr>
        <td class="style9">&nbsp;</td>
		<td class="style9" style="padding-left:10px;"><?php		  		 
				echo bar128(stripslashes("$row[kd_kelompok]")); ?></td>
      </tr>
</table>
<footer style="border-top: 5px #999 solid !important; background:#a94442; color:#ffffff; padding: 0px 0px 1px 0px;">
									<p class="style9" align="center" style="margin-top:5px;"><?php echo $row['nama_lembaga_sort'];?> Kecamatan <?php echo "$row[nama_kec]<br>$row[web_kec]";?>
									</p>
								</footer>
       
</body>
