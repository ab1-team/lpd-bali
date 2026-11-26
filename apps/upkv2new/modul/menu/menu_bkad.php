<?php session_start();
include "inc/inc.koneksi.php";

$_SESSION['jum_kel']=$jum_kel;	
$_SESSION['jum_prop']=$jum_prop;
$_SESSION['jum_ver']=$jum_ver;
$_SESSION['jum_wait']=$jum_wait;
$_SESSION['jum_akt']=$jum_akt;
$_SESSION['jum_lns']=$jum_lns;

$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
?>
<h5 class="sidebar-nav-title">Unit Dana Bergulir <a class="action-link" href=""><i class="glyphicon glyphicon-refresh"></i></a></h5>
		<ul class="sidebar-nav"> 
            <li class="active"><a href="?p=1"><span class="icon"><i class="fa fa-desktop"></i></span>Dashboard</a></li>
            <li><a href="?p=l"><span class="icon"><i class="fa fa-bar-chart-o"></i></span>Pelaporan</a></li>
		</ul>
		
<h5 class="sidebar-nav-title">Manajemen <?php echo $kec['nama_bkad_sort'] ;?> <a class="action-link" href="#"><i class="glyphicon glyphicon-refresh"></i></a></h5>
		<ul class="sidebar-nav"> 
			<li><a href="?p=trx_bkad"><span class="icon"><i class="glyphicon glyphicon-th-large"></i></span>Transaksi</a></li>
			<li><a href="?p=lap_bkad"><span class="icon"><i class="glyphicon glyphicon-th-large"></i></span>Laporan</a></li>
		</ul>