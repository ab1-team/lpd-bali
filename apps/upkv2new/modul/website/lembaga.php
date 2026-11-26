<section class="widget windget-padding-lg">
	<div class="widget-body">
		<h3>KE<span class="fw-semi-bold">LEMBAGA</span>AN</h3>
							<table class="table" width="100%">
								<?php
								$view=mysql_query("select * from level order by id asc");
										$no=0;
										while($row=mysql_fetch_array($view)){ 
										$no=$no+1;
											echo "
											<tr>
												<th height='35px' class='bg-primary fw-semi-bold h4 text-align-center' colspan='2'>$row[deskripsi_level] ($row[nama_level])</th>
											</tr> ";
										
												$users=mysql_query("select * from users WHERE level='$row[id]' AND lokasi='$_SESSION[lokasi]' order by id asc");
												$no=0;
												while($du=mysql_fetch_array($users)){ 
													$jab=mysql_fetch_array(mysql_query("select * from jabatan WHERE id='$du[jabatan]'"));
												$no=$no+1;
													echo "
													<tr>
														<td width='20%' class='h4'>
														<div class='fileinput-new thumbnail mt-md ml-xlg' style='width: 130px; height:130px;'>";
														
															$foto=$du['foto'];
															if (empty($foto)) {
																echo "<img src='images/avatar.png' alt='...'>";
																}else{
																echo "<img alt='...' src='foto_users/$foto'>";
																}
													echo "
														</div>
														</td>
														<td  width='80%' class='h4 text-align-center'><br><br><span class='fw-semi-bold'>$du[namadepan] $du[namabelakang]</span><br>$jab[nama_jabatan]</td>
													</tr>
														
													";
													 }
								 } ?>
							</table>
							
	</div>
</section>