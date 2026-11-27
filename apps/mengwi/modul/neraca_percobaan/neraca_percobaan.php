<?php 
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_keuangan.php";

$tgl_kondisi	=date('Y-m-d');
 ?>

						<div class="row">
								<div class="col-md-12">
								<section class="alert alert-info animated fadeInDown">
									<header>
										<legend><i class="fa fa-book"></i> Neraca Percobaan</legend>
										<div class="widget-controls">
												Periode : <?php echo tgl_indo(date('Y-m-d'));?>
												<a href="javascript:;" data-toggle='tooltip' data-placement='left' title='Standart Akuntansi' onclick="MM_openBrWindow('modul/pelaporan/p/NP.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=<?php echo date('d');?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a>
											</div>
									</header>
											<div class="widget-body">
												<div class="table-responsive">
													<table class="table table-hover">
														<thead class="bg-primary text-white">
														<tr>
															<th rowspan="2">Rekening</th>
															<th colspan="2">Neraca Saldo</th>
															<th colspan="2">Rugi Laba</th>
															<th colspan="2">Neraca</th>
														</tr>
														<tr>
															<th>Debit</th>
															<th>Kredit</th>
															<th>Debit</th>
															<th>Kredit</th>
															<th>Debit</th>
															<th>Kredit</th>
														</tr>
														</thead>
														<tbody>
														
												<?php
													$view=mysql_query("select * from jenis_buku WHERE lokasi='0' OR lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ORDER BY kd_jb ASC ");
														while($row=mysql_fetch_array($view)){
														$posisi=$row['posisi'];
														
														$saldo=saldo("$tgl_kondisi-".$row['kd_jb']);		//menggunakan fungsi Saldo by buku
														if($saldo>=0) {
														$debit=$saldo;
														$kredit="0";
														}elseif($saldo<=0){
														$debit="0";
														$kredit=$saldo*-1;
														}
														
														if($posisi=='1' OR $posisi=='2' OR $posisi=='3') {
															$rldebit="0";
															$rlkredit="0";
															$nrcdebit=$debit;
															$nrckredit=$kredit;
															}elseif($posisi=='4' OR $posisi=='5') {
															$rldebit=$debit;
															$rlkredit=$kredit;
															$nrcdebit="0";
															$nrckredit="0";
															}
														
																	
														echo "
														<tr>
															<td>$row[kd_jb]. $row[nama_jb]</td>
															<td class='text-align-right'>".number_format($debit)."</td>
															<td class='text-align-right'>".number_format($kredit)."</td>
															<td class='text-align-right'>".number_format($rldebit)."</td>
															<td class='text-align-right'>".number_format($rlkredit)."</td>
															<td class='text-align-right'>".number_format($nrcdebit)."</td>
															<td class='text-align-right'>".number_format($nrckredit)."</td>
														</tr> 
														";					
														$sumdebit=$sumdebit+$debit;
														$sumkredit=$sumkredit+$kredit;
														
														$sumrldebit=$sumrldebit+$rldebit;
														$sumrlkredit=$sumrlkredit+$rlkredit;
														
														$sumnrcdebit=$sumnrcdebit+$nrcdebit;
														$sumnrckredit=$sumnrckredit+$nrckredit;
														}
														 ?>
														
														</tbody>
														<tfoot class="bg-info-light">
														<tr>
															<th class="text-align-center">Surplus/Devisit</th>
															<th colspan="2">&nbsp;</th>
															<th class="text-align-right"><?php echo number_format($sumrlkredit-$sumrldebit);?></th>
															<th>&nbsp;</th>
															<th colspan="2" class="text-align-right"><?php echo number_format($sumrlkredit-$sumrldebit);?></th>
														</tr>
														<tr>
															<th class="text-align-center bg-primary-light">Jumlah</th>
															<th class="text-align-right bg-primary-light"><?php echo number_format($sumdebit);?></th>
															<th class="text-align-right bg-primary-light"><?php echo number_format($sumkredit);?></th>
															<th class="text-align-right bg-primary-light"><?php echo number_format($sumrldebit+($sumrlkredit-$sumrldebit));?></th>
															<th class="text-align-right bg-primary-light"><?php echo number_format($sumrlkredit);?></th>
															<th class="text-align-right bg-primary-light"><?php echo number_format($sumnrcdebit);?></th>
															<th class="text-align-right bg-primary-light"><?php echo number_format($sumnrckredit+($sumrlkredit-$sumrldebit));?></th>
														</tr>
														</tfoot>
													</table>
												</div>
											</div>
								</section>
								</div>
						</div>	