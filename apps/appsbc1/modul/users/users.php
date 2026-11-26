<?php session_start(); ?> 
    
		
		<div class="row">
			<div class="col-md-7">
				<section class="widget">
							<header>
								<legend><i class="glyphicon glyphicon-user"></i> Daftar Users</legend>
								<div class="widget-controls">
									<a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
									<a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
									<a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
								</div>
							</header>
					<div class="widget-body">
						<div class="table-responsive">
							<table class="table table-hover">
								<tbody>
								<?php
								ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
								include "../../inc/inc.koneksi.php";
								$view=mysql_query("select * from level order by urutan asc");
										$no=0;
										while($row=mysql_fetch_array($view)){ 
										$no=$no+1;
											echo "
											<tr> <th class='bg-primary' colspan='3'>";
												echo "$row[deskripsi_level] ($row[nama_level])";
												

											echo" </th></tr> ";
										
												$users=mysql_query("select * from users WHERE level='$row[id]' and lokasi='$_SESSION[lokasi]' order by jabatan asc");
												$no=0;
												while($du=mysql_fetch_array($users)){ 
													$jab=mysql_fetch_array(mysql_query("SELECT * FROM jabatan where id='$du[jabatan]'"));
												$no=$no+1;
													echo "
													<tr>";
												echo "		<td class='hidden-xs'>";

												echo"$jab[nama_jabatan]";

												echo "</td>
														<td class='hidden-xs'>: $du[namadepan] $du[namabelakang]</td>
													</tr> ";
													 }
								 } ?>
								</tbody>
							</table>
						</div>
					</div>
				</section>
			</div>
            <div class="col-md-5 col-md-offset">
                <div id="DetailUser"></div>
            </div>
	
</div>