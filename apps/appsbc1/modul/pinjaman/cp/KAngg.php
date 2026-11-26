<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
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
							kecamatan c, desa d, anggota_$_SESSION[kd_kab] a, usaha u
							WHERE
							c.id=a.lokasi AND u.id=a.usaha AND d.id=a.desa AND a.nik=$rcp "));
				
			?>
<h1 class="style1" style="margin-bottom:5px;">Kartu Anggota</h1> 
<table width="110%" border="0" align="center" cellpadding="1" cellspacing="0" > 	  
      
      <tr>
        <td width="15%" rowspan="6" class="style9">&nbsp;</td>
        <td width="10%" rowspan="6" class="style9">
		
							<?php
								
											echo "<img  src='../../../foto_anggota/$row[nik].jpg' alt='...' style='width:110px; margin-right:5px;' >";
										
										?>
          
		</td>
        <td width="15%" class="style9">Nama Anggota</td>
        <td width="35%" class="style9">: <?php echo strtoupper($row['namadepan']);?></td>
        <td width="25%" rowspan="6" class="style9">&nbsp;</td>
      </tr>
      <tr>
        <td class="style9">Kelahiran</td>
        <td class="style9">: <?php echo "$row[tempat_lahir],"?> <?php echo tgl_ind($row['tgl_lahir']);?></td>
      </tr>
      <tr>
        <td class="style9">Jenis Usaha</td>
        <td class="style9">: <?php echo $row['nama_usaha'];?></td>
      </tr>
	  <tr>
        <td class="style9">Alamat</td>
        <td class="style9">: <?php echo "$row[alamat]";?></td>
      </tr>
	  <tr>
        <td class="style9">Desa</td>
        <td class="style9">: <?php echo "$row[nama_desa]";?></td>
      </tr>
      <tr>
        <td class="style9">&nbsp;</td>
		<td class="style9" style="padding-left:10px;"><?php		  		 
				echo bar128(stripslashes("$row[nik]")); ?></td>
      </tr>
</table>
<footer style="border-top: 5px #999 solid !important; background:#a94442; color:#ffffff; padding: 0px 0px 1px 0px;">
									<p class="style9" align="center" style="margin-top:5px;"><?php echo $row['nama_lembaga_sort'];?> Kecamatan <?php echo "$row[nama_kec]<br>$row[web_kec]";?>
									</p>
								</footer>
       
</body>
