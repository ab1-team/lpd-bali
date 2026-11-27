		<ul class="sidebar-nav"> 
            <li class="active"><a href="?p=up_home"><span class="icon"><i class="fa fa-desktop"></i></span>Dashboard</a></li>
			<li><a class="collapsed" href="#sidebar-pinjaman" data-toggle="collapse" data-parent="#sidebar">
                    <span class="icon"><i class="glyphicon glyphicon-th-large"></i></span>Pinjaman<i class="toggle fa fa-angle-down"></i>
				</a>
                <ul id="sidebar-pinjaman" class="collapse">
					<li><a href="?p=p1">REGISTER PROPOSAL</a></li>
					<li>
                        <a class="collapsed" href="#sidebar-sub-pinjaman-K" data-toggle="collapse" data-parent="#sidebar-levels">
                            KELOMPOK
                            <i class="toggle fa fa-angle-down"></i>
                        </a>
                        <ul id="sidebar-sub-pinjaman-K" class="collapse">
							<li><a href="?p=pJ&sT=P">Proposal <span class="badge pull-right animated bounceIn mr-sm"><?php echo $_SESSION['jum_prop'];?></span></a></li>
							<li><a href="?p=pJ&sT=V">Verified <span class="badge bg-info pull-right animated bounceIn mr-sm"><?php echo $_SESSION['jum_ver'];?></span></a></li>
							<li><a href="?p=pJ&sT=W">Waiting List <span class="badge bg-danger pull-right animated bounceIn mr-sm"><?php echo $_SESSION['jum_wait'];?></span></a></li>
							<li><a href="?p=pJ&sT=A">Pinjaman Aktif <span class="badge bg-primary pull-right animated bounceIn mr-sm"><?php echo $_SESSION['jum_akt'];?></span></a></li>
							<li><a href="?p=vL">Validasi Lunas <span class="badge bg-success pull-right animated bounceIn mr-sm"><i class="glyphicon glyphicon-play-circle"></i></span></a></li>
						</ul>
                    </li>
                </ul>
            </li>
			<li><a href="?p=l"><span class="icon"><i class="fa fa-bar-chart-o"></i></span>Pelaporan</a></li>
		</ul>	