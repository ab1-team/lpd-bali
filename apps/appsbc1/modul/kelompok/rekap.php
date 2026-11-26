<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.top	{border-top: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.text-right {text-align:right; }

-->
</style>
<?php
@session_start();
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
include "../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
?>



<body onLoad="window.print()">
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
			<td height="20" colspan="8" class="bottom">
				<div class="style9 text-align-left"><?php echo "$kec[nama_lembaga_sort] Kecamatan $kec[nama_kec]";?><br>
				<?php echo $kec['alamat_kec'];?> <i class="fa fa-phone-square"></i> <?php echo $kec['telpon_kec'];?>
				</div>
			</td>
		  </tr> 	  
</table>
<p align="center" class="style6">REKAP DATA KELOMPOK<br>  </p>

                    <table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" class="top bottom left right" >

                        <tr>
                            <th height="34" class="style9 bottom top left">No</th>
                            <th class="style9 left bottom top">Kode Kelompok</th>
                            <th class="style9 left bottom top">Nama Kelompok</th>
                            <th class="style9 left bottom top">Alamat Domisili</th>
                            <th class="style9 left bottom top"> Telpon</th>
							<th class="style9 left bottom top right">Status</th>
                        </tr>
                        <?php
						$view=mysql_query("select * from desa d, kelompok_$_SESSION[kd_kab] k WHERE d.id=k.desa and k.lokasi='$_SESSION[lokasi]' order by k.id DESC");
								$no=0;
								while($row=mysql_fetch_array($view)){ 
								$no=$no+1;
								
								$dpa=mysql_query("select * from status_pinjaman s, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE s.kd_status=pk.status AND pk.id_kel='$row[id]'");
									$pa	=mysql_num_rows($dpa);
									if ($pa > 0){
										$r = mysql_fetch_array($dpa);
										$status =$r['kd_status']; $bg=$r['warna_status'];
										}else{ $status ="N"; $bg="default"; }
								
								$jpp=$row['jenis_produk_pinjaman']; if ($jpp=="1") { $gb="female";}else{ $gb="male";}
						echo "
						<tr>
                            <td height='33' class='style9 left top' align='center'>$no</td>
							<td class='style9 left top' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[kd_kelompok]</td>
							<td class='style9 left top' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[nama_kelompok]<span class='pull-right'><i class='fa fa-$gb fa-lg'></i> </span></td>
							<td class='style9 left top' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[alamat_kelompok] $row[nama_desa]</td>
							<td class='style9 left top' onclick='javascript:DetailKelompok(\"{$row[id]}\")' data-toggle='tab'>$row[telpon]</td>
                            <td class='style9 left top right' align='center' >$status</td>
                        </tr> ";
						 } ?>
                    </table>
					

         
</body>
<title>REKAP DATA KELOMPOK</title>