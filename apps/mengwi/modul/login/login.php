<script type="text/javascript" src="js/jquery-1.2.3.min.js"></script>
<script type="text/javascript">
	window.onload = function() {
		var input = document.getElementById("uname").focus();
		}
		
	$(document).ready(function() {
	
			$("#login").click(function() {
                    var uname			= $('#uname').val();
                    var pass			= $('#pass').val();
					
					if(uname.length==0){ $("#Konfirmasi").load('modul/login/dilarang_uname.php'); $("#uname").focus(); return false; }
					if(pass.length==0){ $("#Konfirmasi").load('modul/login/dilarang_pass.php'); $("#pass").focus(); return false; }
							


                });	
	
	});	
</script>
				<section class="widget animated fadeInDown">
                    <div class="widget-body">
						<div id="validation-form" class="form-horizontal form-label-left" method="post"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
                                <legend class="h4 text-muted">
                                    <i class="glyphicon glyphicon-circle-arrow-right"></i> Login SI UPK Online <span class="toggle badge bg-danger pull-right">New</span>
                                </legend>
							<form action="modul/login/cek_login.php" method="post">
                                <div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="text" class="form-control input-lg" autocomplete="off" name="uname" id="uname" placeholder="Username">
                                </div>
								<div class="input-group mt">
									<span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="password" class="form-control input-lg" autocomplete="off" name="pass" id="pass" placeholder="Password">
                                </div>
								<div class="clearfix">
									<div class="btn-toolbar pull-right">
										<button type="button" class="btn btn-default btn-lg" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Demo</button>
										<button class="btn btn-inverse btn-lg width-150" name="submit" type="submit" id="login">Login</button>
									</div>
								</div>
							</form>
                            </fieldset>
                        </div>
                    </div>
                </section>
				
				<div class="panel-group mb-lg" id="accordion" data-toggle="collapse">
                    <div class="panel panel-default">
                        <div id="collapseOne" class="panel-collapse collapse">
                            <div class="panel-body">
								<p>Untuk demo aplikasi silahkan kunjungi <a href="http://demo.siupkonline.com">demo.siupkonline.com</a> 
								kemudian masukkan username dan password dibawah ini sesuai dengan demo yang anda inginkan. Selamat mencoba!
								</p>
                                <table class="table table-hover">
								<tbody>
								<?php
								ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
								include "../../inc/inc.koneksi.php";
								$view=mysql_query("select * from level order by id asc");
										$no=0;
										while($row=mysql_fetch_array($view)){ 
										$no=$no+1;
											echo "
											<tr>
												<th class='bg-primary' width='30%'>$row[nama_level]</th>
												<th class='bg-primary'>Uname</th>
												<th class='bg-primary'>Pass</th>
												<th class='bg-primary'>&Sigma; Demo</th>
											</tr> ";
										
												$users=mysql_query("select * from users WHERE level='$row[id]' and lokasi='1' order by id asc");
												$no=0;
												while($du=mysql_fetch_array($users)){ 
													$jab=mysql_fetch_array(mysql_query("select * from jabatan WHERE id='$du[jabatan]'"));
												$no=$no+1;
													echo "
													<tr>
														<td class='hidden-xs'>$jab[nama_jabatan]</td>
														<td class='hidden-xs'>$du[uname]</td>
														<td class='hidden-xs'>$du[pass]</td>
														<td class='hidden-xs text-align-right'>$du[kunjungan] kali</td>
													</tr> ";
													 }
								 } ?>
								</tbody>
							</table>
                            </div>
                        </div>
                    </div>

                </div>