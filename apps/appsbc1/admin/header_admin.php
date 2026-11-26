<nav class="page-controls navbar navbar-default" style="background-color:#AD103C;"> <!-- 026466 003366-->
    <div class="container-fluid">
        <!-- .navbar-header contains links seen on xs & sm screens -->
        <div class="navbar-header">
            <ul class="nav navbar-nav">
                <li>
                    <!-- whether to automatically collapse sidebar on mouseleave. If activated acts more like usual admin templates -->
                    <a class="hidden-sm hidden-xs" id="nav-state-toggle" href="#" title="Show/hide sidebar" data-placement="bottom">
                        <i class="fa fa-bars fa-lg"></i>
                    </a>
                    <!-- shown on xs & sm screen. collapses and expands navigation -->
                    <a class="visible-sm visible-xs" id="nav-collapse-toggle" href="#" title="Show/hide sidebar" data-placement="bottom">
                        <span class="rounded rounded-lg bg-gray text-white visible-xs"><i class="fa fa-bars fa-lg"></i></span>
                        <i class="fa fa-bars fa-lg hidden-xs"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right visible-xs">
                <li>
                    <!-- toggles chat -->
                    <a href="#" data-toggle="chat-sidebar">
                        <span class="rounded rounded-lg bg-gray text-white"><i class="fa fa-globe fa-lg"></i></span>
                    </a>
                </li>
            </ul>

        </div>

        <!-- this part is hidden for xs screens -->
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-left">
                <li class="dropdown">            
                    <a href="#" class="dropdown-toggle dropdown-toggle-notifications" >
						<span class="thumb-sm avatar pull-left">
							<?php
											echo "<img class='' alt='...' src='images/upk.png'>";
										?>
                        </span>
						<strong> SUPER ADMIN</strong> | <?php echo $_SESSION['email'];?>
                    </a>
                </li>
            </ul>
           <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">            
                    <a href="#" class="dropdown-toggle dropdown-toggle-notifications" id="notifications-dropdown-toggle" data-toggle="dropdown">
                       
						<span class="thumb-sm avatar img-user pull-left">
							<?php
										$foto=$_SESSION['foto'];
										if (empty($foto)) {
											echo "<img class='img-circle' src='images/user.png' alt='...'>";
											}else{
											echo "<img class='img-circle' alt='...' src='foto_users/$foto'>";
											}
										?>
                        </span>
					
                        &nbsp;
                        <?php $kel=$_SESSION['jk']; 
							if($kel=="L") { $jk="Mr."; }else{ $jk="Mrs."; } echo "$jk";?>
						<strong> <?php echo "$_SESSION[namadepan]";?></strong> <?php echo "$_SESSION[namabelakang]";?>
                        <b class="caret"></b></a>
						<ul class="dropdown-menu animated fadeInDown">
                        <li><a href="?p=account"><i class="glyphicon glyphicon-user"></i> &nbsp; My Account [<?php echo "$_SESSION[id]";?>]</a></li>
                        <li class="divider"></li>
                        <li><a href="#" data-toggle="chat-sidebar"><i class="fa fa-comments"></i> &nbsp; E-Chat</a></li>
                        <li><a href="?p=uG"><i class="fa fa-graduation-cap"></i> &nbsp; User Guides &nbsp;&nbsp;</a></li>
                        <li><a href="" data-toggle="modal" data-target="#myModalTS"><i class="glyphicon glyphicon-headphones"></i> &nbsp; Technical Support</a></li>
                        <li><a href="?p=uF"><i class="fa fa-laptop"></i> &nbsp; Update Fitur &nbsp;&nbsp;<span class="badge bg-danger animated bounceIn">New</span></a></li>
                        <li class="divider"></li>
                        <li><a href="" data-toggle="modal" data-target="#myModallo"><i class="fa fa-sign-out"></i> &nbsp; Log Out</a></li>
                    </ul>
                   
                </li>
				
                <li>
                    <a href="#" data-toggle="chat-sidebar" class="fs-larger">
                        <i class="fa fa-comments"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
						<!-- MODAL LOGOUT -->
						<div class="modal fade" id="myModallo" tabindex="" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title text-align-center fw-bold mt" id="myModalLabel18">Terimakasih <?php echo "$_SESSION[nama_kab]";?></h4>
                                        <p class="text-align-center fs-mini text-muted mt-sm">
                                            Terimakasih Anda telah menggunakan Sistem Informasi Managemen Keuangan UPK Online.<br>
											Saat ini anda akan keluar dari SI UPK Online...
                                        </p>
                                    </div>
									<div class="modal-footer">
										<p class="text-align-left fs-mini pull-left">
											Beri penilaian untuk kami,<br> bagaimana kinerja SI UPK Online hari ini?
                                        </p>
										<a href="logout.php?n=1" class="btn btn-info btn-rounded"><i class="fa fa-thumbs-up"></i> Bagus</a>
										<a href="logout.php?n=0" class="btn btn-info btn-rounded"><i class="fa fa-thumbs-down"></i> Jelek</a>
										<button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Batal</button>
									</div>
                                </div>
                            </div>
                        </div>
						
						
						<!-- MODAL KONTAK -->
						<div class="modal fade" id="myModalTS" tabindex="" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title text-align-center fw-bold mt" id="myModalLabel18">Technical Support</h4>
                                    </div>
                                    <div class="modal-body">
										<div class="col-xs-4 mt">
											<img src="images/upk.png" width="160px">
										</div>
											<h3>&nbsp;</h3>
											<h3><i class="fa fa-phone-square"></i> 081 56 777 2008</h3>
											<h3><i class="fa fa-facebook-square"></i> facebook.com/upkonline</h3>
											<h3>&nbsp;</h3>
									</div>
                                </div>
                            </div>
                        </div>