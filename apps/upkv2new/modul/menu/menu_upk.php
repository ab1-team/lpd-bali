		<ul class="sidebar-nav"> 
			
			<?php
			$hak_akses 	= explode(",", $_SESSION['hak_akses']);
			$n0=$hak_akses[0];
			$n1=$hak_akses[1];
			$n2=$hak_akses[2];
			$n3=$hak_akses[3];
			$n4=$hak_akses[4];
			$n5=$hak_akses[5];
			$n6=$hak_akses[6];
			$n7=$hak_akses[7];
			$n8=$hak_akses[8];
			$n9=$hak_akses[9];
			$n10=$hak_akses[10];
			
								$menu = mysql_query("SELECT * FROM menu where 
										id_parent='0' AND id_child='0' AND aktif='Ya' AND id!='$n0' AND id!='$n1' AND id!='$n2' AND id!='$n3' AND id!='$n4' AND id!='$n5'
	AND (
	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR
	lokasi = 0
	)

ORDER BY urutan ASC");
								while($row = mysql_fetch_assoc($menu)){
									$menu_id = $row['id'];
									$submenu = mysql_query("SELECT * FROM menu WHERE id_parent='$menu_id' AND aktif='Ya' 
											 AND id!='$n0' AND id!='$n1' AND id!='$n2' AND id!='$n3' AND id!='$n4' AND id!='$n5' AND id!='$n6' AND id!='$n7' AND id!='$n8' AND id!='$n9' AND id!='$n10'
										AND (
                                    	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR
                                    	lokasi = 0
                                    	)

									ORDER BY urutan ASC");
									if(mysql_num_rows($submenu) == 0){
										echo "
										<li><a href='?p=$row[link]'><span class='icon'><i class='$row[icon]'></i></span>$row[nama_menu]</a></li>";
									
									}else{
										echo "
										<li>
											<a class='collapsed' href='#sidebar-$menu_id' data-toggle='collapse' data-parent='#sidebar-levels'>
												<span class='icon'><i class='$row[icon]'></i></span>$row[nama_menu]
												<i class='toggle fa fa-angle-down'></i>
											</a>
											<ul id='sidebar-$menu_id' class='collapse'> ";
								
											while($r = mysql_fetch_assoc($submenu)){
												
												if ($r['id']==17) {
													echo "
													<li>
													<a class='collapsed' href='#sidebar-sub-pinjaman-$r[id]' data-toggle='collapse' data-parent='#sidebar-levels'>
														$r[nama_menu]
														<i class='toggle fa fa-angle-down'></i>
													</a>
													<ul id='sidebar-sub-pinjaman-$r[id]' class='collapse'>
														<li><a href='?p=pJ&sT=P'>Proposal <span class='badge pull-right animated bounceIn mr-sm'>$_SESSION[jum_prop]</span></a></li>
														<li><a href='?p=pJ&sT=V'>Verified <span class='badge bg-info pull-right animated bounceIn mr-sm'>$_SESSION[jum_ver]</span></a></li>
														<li><a href='?p=pJ&sT=W'>Waiting List <span class='badge bg-danger pull-right animated bounceIn mr-sm'>$_SESSION[jum_wait]</span></a></li>
														<li><a href='?p=pJ&sT=A'>Pinjaman Aktif <span class='badge bg-primary pull-right animated bounceIn mr-sm'>$_SESSION[jum_akt]</span></a></li>
														<li><a href='?p=vL'>Validasi Lunas <span class='badge bg-success pull-right animated bounceIn mr-sm'><i class='glyphicon glyphicon-play-circle'></i></span></a></li>
													</ul></li>
													";
												}else if ($r['id']==18) {
													echo "
													<li>
													<a class='collapsed' href='#sidebar-sub-pinjaman-$r[id]' data-toggle='collapse' data-parent='#sidebar-levels'>
														$r[nama_menu]
														<i class='toggle fa fa-angle-down'></i>
													</a>
													<ul id='sidebar-sub-pinjaman-$r[id]' class='collapse'>
														<li><a href='?p=pJ_i&sT=P'>Proposal <span class='badge pull-right animated bounceIn mr-sm'>$_SESSION[jum_prop_i]</span></a></li>
														<li><a href='?p=pJ_i&sT=V'>Verified <span class='badge bg-info pull-right animated bounceIn mr-sm'>$_SESSION[jum_ver_i]</span></a></li>
														<li><a href='?p=pJ_i&sT=W'>Waiting List <span class='badge bg-danger pull-right animated bounceIn mr-sm'>$_SESSION[jum_wait_i]</span></a></li>
														<li><a href='?p=pJ_i&sT=A'>Pinjaman Aktif <span class='badge bg-primary pull-right animated bounceIn mr-sm'>$_SESSION[jum_akt_i]</span></a></li>
														<li><a href='?p=vL_i'>Validasi Lunas <span class='badge bg-success pull-right animated bounceIn mr-sm'><i class='glyphicon glyphicon-play-circle'></i></span></a></li>
													</ul></li>
													";
												}else{
													$child = mysql_query("SELECT * FROM menu WHERE id_child='$r[id]' AND aktif='Ya'
														AND (
                                                    	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR
                                                    	lokasi = 0
                                                    	)

													ORDER BY urutan ASC");
												if(mysql_num_rows($child) == 0){
													echo "<li><a href='?p=$r[link]'>$r[nama_menu]</a></li>";
												}else{
													echo "
														<li>
															<a class='collapsed' href='#sidebar-$r[id]' data-toggle='collapse' data-parent='#sidebar-levels'>
																$r[nama_menu]
																<i class='toggle fa fa-angle-down'></i>
															</a>
															<ul id='sidebar-$r[id]' class='collapse'> ";
												
															$subchild = mysql_query("SELECT * FROM menu where id_child='$r[id]' AND aktif='Ya'
																AND (
                                                            	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR
                                                            	lokasi = 0
                                                            	)
                                                            
                                                            															
															ORDER BY urutan ASC");
															while($c = mysql_fetch_assoc($subchild)){
																echo "<li><a href='?p=$c[link]'>$c[nama_menu]</a></li>";
															}
														echo "
															</ul>
														</li>";
												
													}
												}
											}
										
										echo "		
											</ul>
										</li>";
										
									}
								}
							
							?>
							
		</ul>	