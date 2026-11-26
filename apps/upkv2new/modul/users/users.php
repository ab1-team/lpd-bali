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
								$view=mysql_query("select * from level order by id asc");
								$kec_1=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE  id='$_SESSION[lokasi]'"));
										$no=0;
										while($row=mysql_fetch_array($view)){ 
										$no=$no+1;
											echo "
											<tr> <th class='bg-primary' colspan='3'>";
											if ($row['id']=='1') {
												echo "$kec_1[nama_lembaga_long] ($kec_1[nama_lembaga_sort])";
											}else if ($row['id']=='2') {
												echo "$kec_1[nama_bkad_long] ($kec_1[nama_bkad_sort])";
												
											}else if ($row['id']=='3') {
												echo "$kec_1[nama_bp_long] ($kec_1[nama_bp_sort])";
												
											}else if ($row['id']=='4') {
												echo "$kec_1[nama_tv_long] ($kec_1[nama_tv_sort])";	}
											else{
												echo "$row[deskripsi_level] ($row[nama_level])";
											}
												

											echo" </th></tr> ";
										
												$users=mysql_query("select * from users WHERE level='$row[id]' and lokasi='$_SESSION[lokasi]' order by jabatan asc");
												$no=0;
												while($du=mysql_fetch_array($users)){ 
													$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE  id='$_SESSION[lokasi]'"));
													$jab=mysql_fetch_array(mysql_query("SELECT * FROM jabatan where id='$du[jabatan]'"));
												$no=$no+1;
													echo "
													<tr>";
												echo "		<td class='hidden-xs'>";

												if ($du['jabatan']=='1' AND $du['level']=='1') {
													echo "$kec[sebutan_level_1]";
												} else if ($du['jabatan']=='2' AND $du['level']=='1') {
													echo "$kec[sebutan_level_2]";
												}else if ($du['jabatan']=='3' AND $du['level']=='1') {
													echo "$kec[sebutan_level_3]";
												}else{

												echo"$jab[nama_jabatan]";
											}

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