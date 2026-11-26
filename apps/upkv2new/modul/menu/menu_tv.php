<?php session_start();
include "inc/inc.koneksi.php";

$_SESSION['jum_kel']=$jum_kel;	
$_SESSION['jum_prop']=$jum_prop;
$_SESSION['jum_ver']=$jum_ver;
$_SESSION['jum_wait']=$jum_wait;
$_SESSION['jum_akt']=$jum_akt;
$_SESSION['jum_lns']=$jum_lns;


$_SESSION['jum_prop_i']=$jum_prop_i;
$_SESSION['jum_ver_i']=$jum_ver_i;
?>
		<ul class="sidebar-nav"> 
            <li class="active"><a href="?p=1"><span class="icon"><i class="fa fa-desktop"></i></span>Dashboard</a></li>
			
			<li><a class="collapsed" href="#sidebar-kelompok" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="fa fa-group"></i></span>Kelompok<i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-kelompok" class="collapse">
					<li><a href="?p=pJ&sT=P">Proposal <span class="badge pull-right animated bounceIn mr-sm bg-danger"><?php echo $jum_prop;?></span></a></li>
					<li><a href="?p=pJ&sT=V">Verified <span class="badge pull-right animated bounceIn mr-sm bg-warning"><?php echo $jum_ver;?></span></a></li>
                </ul>
            </li>
			
			<li><a class="collapsed" href="#sidebar-individu" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="glyphicon glyphicon-user"></i></span>Individu<i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-individu" class="collapse">
					<li><a href="?p=pJ_i&sT=P">Proposal <span class="badge pull-right animated bounceIn mr-sm bg-danger"><?php echo $jum_prop_i;?></span></a></li>
					<li><a href="?p=pJ_i&sT=V">Verified <span class="badge pull-right animated bounceIn mr-sm bg-warning"><?php echo $jum_ver_i;?></span></a></li>
                </ul>
            </li>
	<?php if ($_SESSION['lokasi']=="11" and $_SESSION['level']=="4" ) { //Khusus Gajah Demak ?>
	
	<li><a class="collapsed" href="#sidebar-basis" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="glyphicon glyphicon-cloud"></i></span>Basis Data<i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-basis" class="collapse">
                    <li><a href="?p=k">Data Kelompok</a></li>
					<li>
                        <a class="collapsed" href="#sidebar-sub-levels" data-toggle="collapse" data-parent="#sidebar-levels">
                            Keanggotaan
                            <i class="toggle fa fa-angle-down"></i>
                        </a>
                        <ul id="sidebar-sub-levels" class="collapse">
                            <li><a href="?p=rp">Register Penduduk</a></li>
                            <li><a href="?p=dp">Data Penduduk</a></li>
                            <li><a href="?p=a">Data Anggota UPK</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
	
	<?php } ?>
			<li><a href="?p=l"><span class="icon"><i class="fa fa-bar-chart-o"></i></span>Pelaporan</a></li>
		</ul>