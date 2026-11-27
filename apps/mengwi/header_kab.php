<nav class="page-controls navbar navbar-default" style="background-color:#003366;"> <!-- 026466 -->
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
						<strong> <?php  echo strtoupper($_SESSION['nama_lembaga']); //LENCANA?></strong> | <?php echo $_SESSION['alamat_kab'];?>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="http://arthamari.com/k.php?p=1">
						<i class="glyphicon glyphicon-th fa-lg"></i>
                    </a>
                </li>
                <li class="dropdown">            
                    <a href="#" class="dropdown-toggle dropdown-toggle-notifications" id="notifications-dropdown-toggle" data-toggle="dropdown">
                       
						My Account
                        <b class="caret"></b></a>
						<ul class="dropdown-menu animated fadeInDown">
                        <li class="divider"></li>
                        <li><a href="?p=kab_account"><i class="glyphicon glyphicon-user"></i> &nbsp; My Account [<?php echo "$_SESSION[id]";?>]</a></li>
                        <!--<li><a href="#" data-toggle="chat-sidebar"><i class="fa fa-comments"></i> &nbsp; E-Chat</a></li>-->
                        <!--<li><a href="?p=news"><i class="fa fa-globe"></i> &nbsp; News</a></li>-->
                        <li><a href="?p=uG"><i class="fa fa-graduation-cap"></i> &nbsp; User Guides &nbsp;&nbsp;<span class="badge bg-danger animated bounceIn">New</span></a></li>
                        <li><a href="" data-toggle="modal" data-target="#myModalTS"><i class="fa fa-envelope"></i> &nbsp; </a></li>
                        <li class="divider"></li>
                        <li><a href="" data-toggle="modal" data-target="#myModallo"><i class="fa fa-sign-out"></i> &nbsp; Log Out</a></li>
                    </ul>
                   
                </li>
				
                <!--<li>-->
                <!--    <a href="#" data-toggle="chat-sidebar" class="fs-larger">-->
                <!--        <i class="fa fa-comments"></i>-->
                <!--    </a>-->
                <!--</li>-->
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
                                            Terimakasih Anda telah menggunakan Sistem Informasi Managemen Keuangan Koperasi.<br>
											Saat ini anda akan keluar dari SIM KOPERASI ...
                                        </p>
                                    </div>
									<div class="modal-footer">
										<p class="text-align-left fs-mini pull-left">
											Beri penilaian untuk kami,<br> bagaimana kinerja SIM KOPERASI hari ini?
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
											<img src="images/pin_bb.jpg" width="160px">
											<img src="images/pin_line.jpg" width="160px">
										</div>
										
											<h3><i class="fa fa-stumbleupon-circle"></i> 59970A34</h3>
											<h3><i class="fa fa-phone-square"></i> +62-85 743 07 1234</h3>
											<h3><i class="fa fa-facebook-square"></i> Maarif Nurhamim Ar-rafi</h3>
											<h3><i class="fa fa-twitter"></i> @maarif_nurhamim</h3>
											<h3><i class="fa fa-skype"></i> maarifnurhamimar-rafi</h3>
											
											<h3><i class="fa fa-google-plus"></i> maarifnurhamim@gmail.com</h3>
											<h3><i class="fa fa-instagram"></i> maarifarrafi</h3>
										<div class="alert alert-info animated fadeInDown text-justify">
											Untuk bantuan teknik silahkan dapat menghubungi  salah satu kontak diatas, dan guna mempermudah respon sertakan selalu angka
											<strong><?php echo "$_SESSION[lokasi]";?></strong> pada setiap pesan yang anda sampaikan.
										</div>
									</div>
                                </div>
                            </div>
                        </div>