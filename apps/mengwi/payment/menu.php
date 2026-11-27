<?php session_start();
include "inc/koneksi_payment.php";
?>

		<ul class="sidebar-nav"> 
            <li class="active"><a href="?p=up_home"><span class="icon"><i class="fa fa-desktop"></i></span>Dashboard</a></li>
			<li><a class="collapsed" href="#sidebar-atur" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="glyphicon glyphicon-th-large"></i></span>PENGATURAN<i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-atur" class="collapse">
					<li><a href="?p=up_">Harga Jual</a></li>
                </ul>
            </li>
			<li><a class="collapsed" href="#sidebar-ppob" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="glyphicon glyphicon-th-large"></i></span>PRODUK<i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-ppob" class="collapse">
					<?php 
					$view=mysql_query("select * from produk_kategori",$koneksi_1); //Menu Produk
						while($row=mysql_fetch_array($view)){
							echo "<li><a href='?p=produk&id=$row[id]'>$row[nama_kategori]</a></li>";
						} ?>
                </ul>
            </li>
			<li><a href="?p=l"><span class="icon"><i class="fa fa-bar-chart-o"></i></span>Pelaporan</a></li>
		</ul>	