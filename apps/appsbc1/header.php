<nav class="page-controls navbar navbar-default"> <!-- B81B1B 026466 -->
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
		<!--
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-left">
				<form method="get" action="" class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <div class="input-group input-group-no-border">
                    <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </span>
                        <input class="form-control" id="search" type="text" placeholder="Search Dashboard">
                    </div>
                </div>
            </form>
            </ul>
			 -->
			
            <ul class="nav navbar-nav navbar-right">
				<li>
                    <a href="" data-toggle="modal" data-target="#myModalSMS"><i class="glyphicon glyphicon-envelope fa-lg"></i></a>
                </li>
                <li class="dropdown">            
                    <a href="#" class="dropdown-toggle dropdown-toggle-notifications" id="notifications-dropdown-toggle" data-toggle="dropdown">
                       
						<span class="thumb-sm avatar img-user pull-left">
							<?php
							$row=mysql_fetch_array(mysql_query("select * from users u, jabatan j WHERE j.id=u.jabatan AND u.id='$_SESSION[id]' ")); 
								
										$foto=$row['foto'];
										if (empty($foto)) {
											echo "<img class='img-circle' src='images/avatar.png' alt='...'>";
											}else{
											echo "<img class='img-circle' alt='...' src='foto_users/$foto'>";
											}
										?>
                        </span>
					
                        &nbsp;
                        <?php $kel=$row['jk']; 
							if($kel=="L") { $jk="Mr."; }else if($kel=="P") { $jk="Mrs."; } echo "$jk";
							?>
						<strong> <?php echo "$row[namadepan]";?></strong> <?php echo "$row[namabelakang] ($row[nama_jabatan])";?>
                        <b class="caret"></b></a>
						<ul class="dropdown-menu animated fadeInDown">

                        <li><a href="?p=account"><i class="glyphicon glyphicon-user"></i> &nbsp; My Account [<?php echo "$row[id]";?>]</a></li>

                        <li class="divider"></li>
                        <li><a href="?p=uG"><i class="fa fa-graduation-cap"></i> &nbsp; User Guides</a></li>
                        <li><a href="" data-toggle="modal" data-target="#myModalTS"><i class="fa fa-envelope"></i> &nbsp; Technical Support</a></li>

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
                                        <h4 class="modal-title text-align-center fw-bold mt" id="myModalLabel18">Terimakasih <?php echo "$jk $_SESSION[namadepan]";?>,</h4>
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
						
						<!-- MODAL SMS TAGIHAN -->
						<div class="modal fade" id="myModalSMS" tabindex="" role="dialog" aria-labelledby="myModalLabel19" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
								<form method="POST" target='_blank' action='modul/pinjaman/cp/SMSTag.php'>
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title text-align-center fw-bold mt" id="myModalLabel19"><i class="glyphicon glyphicon-envelope"></i> SMS Tagihan</h4>
                                    </div>
                                    <div class="modal-body">
										<div id="validation-form" class="form-horizontal form-label-left" method="post"
											  data-parsley-priority-enabled="false"
											  novalidate="novalidate">
											<fieldset>
											
												<div class="form-group">
													<label class="control-label col-md-8 text-muted fs-mini">Kirim SMS Tagihan berdasarkan tanggal jatuh tempo angsuran sesuai dengan yang anda inginkan mendasar pada SOP yang berlaku.<br><br>
													Pastikan nomor HP kelompok penerima SMS telah terisi dan valid (dapat menerima SMS).<br><br>
													Mohon untuk disampaikan kepada penerima SMS untuk tidak membalas SMS ke nomor pengirim.<br><br>
													SMS ini tidak dikenakan pulsa, baik pengirim maupun penerima, gunakanlah secara bijak.</label>
													<div class="col-md-4 text-align-center">Tanggal Jatuh Tempo :<br><input name="tgl_tagihan" id="datetimepicker1" type="text" value="<?php echo date('Y-m-d');?>" data-date-format="YYYY-MM-DD" class="form-control input-lg" /><br><br>
														<button type="submit" name="perintah" value="preview" class="badge bg-danger" role="button">
															<span class="fs-sm"><i class="glyphicon glyphicon-print"></i> Preview Dulu Aja</span>
														</button>
															<br><br>
														<button type="submit" name="perintah" value="terkirim" class="badge bg-success" role="button">
															<span class="fs-sm"><i class="glyphicon glyphicon-envelope"></i> Cek SMS Terkirim</span>
														</button>
													</div>
												</div>
											
											</fieldset>
										</div>
									</div>
									<div class="modal-footer text-align-center bg-primary">
										<button type="submit" name="perintah" value="kirim" class="btn btn-primary btn-block" >KIRIMKAN SMS TAGIHAN UNTUK JATUH TEMPO DIATAS</button>
									</div>
								</form>
                                </div>
                            </div>
                        </div>
						
						
						<!-- MODAL KONTAK -->
						<div class="modal fade" id="myModalTS" tabindex="" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<img src="images/ts.png" width="350px">
                                    </div>
                                    <div class="modal-body">
											<h3>&nbsp;</h3>
											<h3><i class="fa fa-phone-square"></i> 081 227 650 411</h3>
											<h3>&nbsp;</h3>
										<?php
										//if 	($_SESSION['lokasi']!=1) {
											echo "
											<div class='alert alert-default alert-sm'>
																Jika terdapat kendala teknis, silahkan menghubungi Technical Support kami melalui WA/Telpon/SMS <span class='fw-semi-bold'>082 280 888 820</span> <br>
																Demi keamanan, anda harus mematuhi aturan berikut:<br>
																<ul>
																	<li>
																		Registrasikan nomor anda ke Technical Support kami dengan cara ketik <b>LPD</b>&laquo;spasi&raquo;<b>$_SESSION[kd_kab]-$_SESSION[lokasi]</b>&laquo;spasi&raquo;<b>$_SESSION[namadepan]</b>&laquo;spasi&raquo;<b>$_SESSION[unit]</b> kirim via WA/SMS ke 081 56 777 2008 nomor yang belum teregistrasi tidak akan kami layani, ini semata-mata hanya untuk keamanan data.<br>
																	</li>
																	<li>
																		Jika permasalahan berkaitan dengan transaksi, sertakan ID Transaksi yang dimaksud. Dan jika berkaitan dengan pinjaman, sertakan ID Pinjamannya (Loan ID).
																	</li>
																</ul>
																<br>
																Demikian terimakasih.<br>
																PT. Asta Brata Teknologi<br>
																sim.lpd-bali.id.com
															</div>
															";
												//			}
										?>
									</div>
                                </div>
                            </div>
                        </div>
						
