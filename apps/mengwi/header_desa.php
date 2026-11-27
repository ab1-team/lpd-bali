<?php
$des=mysql_fetch_array(mysql_query("select * from kecamatan c, desa d, sebutan_desa sd where c.kd_kec=d.kd_kec AND sd.id=d.sebutan AND d.id='$_SESSION[id]' ")); 
	$kd_kab=$des['kd_kab'];
?>

<nav class="page-controls navbar navbar-default" style="background-color:#AD103C;"> <!-- B81B1B 026466 -->
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
											echo "<img class='' alt='...' src='images/$kd_kab.jpg'>";
										?>
                        </span>
						<strong>  <?php  echo strtoupper("$des[sebutan_desa] $des[nama_desa]"); //LENCANA?></strong> | <?php echo $des['kd_desa'];?>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="" data-toggle="modal" data-target="#myModallo"><i class="fa fa-sign-out"></i> &nbsp; Log Out</a>
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
																		Registrasikan nomor anda ke Technical Support kami dengan cara ketik <b>UPK</b>&laquo;spasi&raquo;<b>$_SESSION[kd_kab]-$_SESSION[lokasi]</b>&laquo;spasi&raquo;<b>$_SESSION[namadepan]</b>&laquo;spasi&raquo;<b>$_SESSION[unit]</b> kirim via WA/SMS ke 0822-8088-8820 nomor yang belum teregistrasi tidak akan kami layani, ini semata-mata hanya untuk keamanan data.<br>
																	</li>
																	<li>
																		Jika permasalahan berkaitan dengan transaksi, sertakan ID Transaksi yang dimaksud. Dan jika berkaitan dengan pinjaman, sertakan ID Pinjamannya (Loan ID).
																	</li>
																</ul>
																<br>
																Demikian terimakasih.<br>
																PT. Asta Brata Teknologi<br>
																SIUPKOnline.com
															</div>
															";
												//			}
										?>
									</div>
                                </div>
                            </div>
                        </div>