<nav class="page-controls navbar navbar-default" style="background-color:#245269;"> <!-- B81B1B 026466 -->
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
		<!--
            <ul class="nav navbar-nav navbar-left">
				<form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <div class="input-group input-group-no-border">
                    <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </span>
                        <input class="form-control" type="text" placeholder="Search Dashboard">
                    </div>
                </div>
            </form>
            </ul>
		-->
		<?php 
		 $j_in=mysql_num_rows(mysql_query("Select * From admin_invoice Where lokasi=$_SESSION[lokasi] AND status='UNPAID' "));
		
		?>
            <ul class="nav navbar-nav navbar-right">
				<li>
                    <a href="main.php">
						<i class="glyphicon glyphicon-th fa-lg"></i>
                    </a>
                </li>
                <li class="dropdown">            
                    <a href="#" class="dropdown-toggle dropdown-toggle-notifications" id="notifications-dropdown-toggle" data-toggle="dropdown">
                       
						<span class="thumb-sm avatar img-user pull-left">
							<?php
										$foto=$_SESSION['foto'];
										if (empty($foto)) {
											echo "<img class='img-circle' src='images/avatar.png' alt='...'>";
											}else{
											echo "<img class='img-circle' alt='...' src='foto_users/$foto'>";
											}
										?>
                        </span>
					
                        &nbsp;
                        <?php $kel=$_SESSION['jk']; 
							if($kel=="L" AND $_SESSION['level']!="camat") { $jk="Mr."; }else if($kel=="P" AND $_SESSION['level']!="camat") { $jk="Mrs."; } echo "$jk";
							?>
						<strong> <?php echo "$_SESSION[namadepan]";?></strong> <?php echo "$_SESSION[namabelakang]";?>
                        <b class="caret"></b> <?php if($j_in>0) { ?>
                        <span class="badge bg-danger animated bounceIn"><?php echo $j_in ;?></span> <?php }?></a>
						<ul class="dropdown-menu animated fadeInDown">
						 <?php 
							if($_SESSION['level']!="camat") {
							?>
                        <li><a href="?p=account"><i class="glyphicon glyphicon-user"></i> &nbsp; My Account [<?php echo "$_SESSION[id]";?>]</a></li>
						<?php 
							}
							?>
                        <li class="divider"></li>
                        <li><a href="?p=invoice&sts="><i class="glyphicon glyphicon-tags"></i> &nbsp; Invoice&nbsp;&nbsp; 
								<?php
								$jumpaid=mysql_num_rows(mysql_query("select * from admin_invoice WHERE status='UNPAID' AND lokasi='$_SESSION[lokasi]' ")); 
								if($jumpaid>0){
									echo "<span class='badge bg-danger animated bounceIn'>$jumpaid</span></a></li>";
								}else{
									echo "";
								}
								?>
                        <!--<li><a href="#" data-toggle="chat-sidebar"><i class="fa fa-comments"></i> &nbsp; E-Chat</a></li>-->
                        <!--<li><a href="v3/administrator/index.php" target="_blank"><i class="fa fa-globe"></i> &nbsp; Kelola Website&nbsp;&nbsp;<span class="badge bg-danger animated bounceIn">New</span></a></li>-->
                        <li><a href="?p=uG"><i class="fa fa-graduation-cap"></i> &nbsp; User Guides</a></li>
                        <li><a href="?p=uF"><i class="fa fa-edit"></i> &nbsp; Update Fitur </a></li>
                        <li><a href="" data-toggle="modal" data-target="#myModalTS"><i class="fa fa-envelope"></i> &nbsp; Technical Support</a></li>
						
                        <li class="divider"></li>
                        <li><a href="main.php"><i class="glyphicon glyphicon-th"></i> &nbsp; Main Page </a></li>
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
                                        <h4 class="modal-title text-align-center fw-bold mt" id="myModalLabel18">Terimakasih <?php echo "$jk $_SESSION[namadepan]";?>,</h4>
                                        <p class="text-align-center fs-mini text-muted mt-sm">
                                            Terimakasih Anda telah menggunakan Sistem Informasi Managemen Keuangan LKM Online.<br>
											Saat ini anda akan keluar dari SIMKoperasi...
                                        </p>
                                    </div>
									<div class="modal-footer">
										<p class="text-align-left fs-mini pull-left">
											Beri penilaian untuk kami,<br> bagaimana kinerja SIMKoperasi hari ini?
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
											<img src="images/LKM.png" width="160px">
										</div>
											<h3>&nbsp;</h3>
											<h3><i class="fa fa-phone-square"></i> 0822-8088-8820</h3>
											<h3><i class="fa fa-facebook-square"></i> facebook.com/upkonline</h3>
											<h3>&nbsp;</h3>
										<?php
										//if 	($_SESSION['lokasi']!=1) {
											echo "
											<div class='alert alert-default alert-sm'>
																Jika terdapat kendala teknis, silahkan menghubungi Technical Support kami melalui WA/Telpon/SMS <span class='fw-semi-bold'>0822-8088-8820</span> <br>
																Demi keamanan, anda harus mematuhi aturan berikut:<br>
																<ul>
																	<li>
																		Registrasikan nomor anda ke Technical Support kami dengan cara ketik <b>LKM</b>&laquo;spasi&raquo;<b>$_SESSION[kd_kab]-$_SESSION[lokasi]</b>&laquo;spasi&raquo;<b>$_SESSION[namadepan]</b>&laquo;spasi&raquo;<b>$_SESSION[unit]</b> kirim via WA/SMS ke 0822-8088-8820 nomor yang belum teregistrasi tidak akan kami layani, ini semata-mata hanya untuk keamanan data.<br>
																	</li>
																	<li>
																		Jika permasalahan berkaitan dengan transaksi, sertakan ID Transaksi yang dimaksud. Dan jika berkaitan dengan pinjaman, sertakan ID Pinjamannya (Loan ID).
																	</li>
																</ul>
																<br>
																Demikian terimakasih.<br>
																PT. Asta Brata Teknologi<br>
																SILKMOnline.com
															</div>
															";
												//			}
										?>
									</div>
                                </div>
                            </div>
                        </div>