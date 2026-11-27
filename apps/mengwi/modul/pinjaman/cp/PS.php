<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/terbilang.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_pinjaman.php";

?>

<style type="text/css">
<!--
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
.top	{border-top: 1px solid #000000; }
.all	{border: 1px solid #000000; }
.bottom	{border-bottom: 1px solid #000000; }
.left	{border-left: 1px solid #000000; }
.right	{border-right: 1px solid #000000; }
.style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
-->
</style>
<body onLoad="window.print()">
<?php
$lokasi="7";
$kec=mysql_fetch_array(mysql_query("select * from kecamatan WHERE id='$lokasi'"));
?>
<h4><?php echo "$row[nama_lembaga_sort] $sebutan_kec $row[nama_kec]";?>
</h4>
<table>
     	    <?php
			
			$view=mysql_query("select * from level order by id asc");
										$no=0;
										while($row=mysql_fetch_array($view)){ 
										$no=$no+1;
											echo "
											<tr>
												<th class='style27' colspan='2' width='30%'>$row[deskripsi_level] ($row[nama_level])</th>
												<th class='style27' width='10%'>Username</th>
												<th class='style27' width='10%'>Password</th>
												
											</tr> ";
										
												$users=mysql_query("select * from users WHERE level='$row[id]' and lokasi='$lokasi' order by id asc");
												$no=0;
												while($du=mysql_fetch_array($users)){ 
													$jab=mysql_fetch_array(mysql_query("select * from jabatan WHERE id='$du[jabatan]'"));
												$no=$no+1;
													echo "
													<tr>
														<td class='style9'>$jab[nama_jabatan]</td>
														<td class='hidden-xs style9'>: $du[namadepan] $du[namabelakang]</td>
														<td class='hidden-xs style9'>$du[uname]</td>
														<td class='hidden-xs style9'>$du[pass]</td>
														
													</tr> ";
													 }
		
		}
		
		?>
		</table>