<?php session_start();
include "inc/inc.koneksi.php";
?>

		<ul class="sidebar-nav"> 
            <li class="active"><a href="?p=up_home"><span class="icon"><i class="fa fa-desktop"></i></span>DASHBOARD</a></li>
			<li><a class="collapsed" href="#sidebar-ppob" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="glyphicon glyphicon-th-large"></i></span>UNIT P4<i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-ppob" class="collapse">
					<li><a href="?p=register_penduduk">REGISTER PROPOSAL</a></li>
					<li><a href="?p=proposal&sT=P">Proposal <span class="badge pull-right animated bounceIn mr-sm"><?php echo $_SESSION['jum_prop'];?></span></a></li>
					<li><a href="?p=proposal&sT=V">Verified <span class="badge bg-info pull-right animated bounceIn mr-sm"><?php echo $_SESSION['jum_ver'];?></span></a></li>
					<li><a href="?p=proposal&sT=W">Waiting List <span class="badge bg-danger pull-right animated bounceIn mr-sm"><?php echo $_SESSION['jum_wait'];?></span></a></li>
					<li><a href="?p=proposal&sT=A">Pinjaman Aktif <span class="badge bg-primary pull-right animated bounceIn mr-sm"><?php echo $_SESSION['jum_akt'];?></span></a></li>
					<li><a href="?p=vL">Validasi Lunas <span class="badge bg-success pull-right animated bounceIn mr-sm"><i class="glyphicon glyphicon-play-circle"></i></span></a></li>
                </ul>
            </li>
			<li><a href="?p=l"><span class="icon"><i class="fa fa-bar-chart-o"></i></span>PELAPORAN</a></li>
		</ul>	