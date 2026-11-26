<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_keuangan.php";
$table_rekening		="rekening_".$_SESSION[lokasi];
$tgl_kondisi		=date('Y-m-d');
?>
<script type="text/javascript">

	function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
 </script> 
				
	<h4 class="page-title hidden-print"><i class="fa fa-book"></i><span class="fw-semi-bold"> Laporan Keuangan</span>
	<span class="pull-right">Periode : <?php echo tgl_indo(date('Y-m-d'));?></span></h4>
	
		<div class="row">
			<div class="col-md-12">
                <div class="tabbable tabs-left mb-lg">
                    <ul id="tabs2" class="nav nav-tabs hidden-print">
                        <li class="active"><a href="#tab17" data-toggle="tab"><i class="fa fa-book"></i> Rugi Laba</a></li>
                        <li class=""><a href="#tab27" data-toggle="tab"><i class="fa fa-book"></i> Perubahan Modal</a></li>
                        <li class=""><a href="#tab37" data-toggle="tab"><i class="fa fa-book"></i> Neraca</a></li>
                    </ul>
                    <div id="tabs5c" class="tab-content">
						<div class="active tab-pane" id="tab17">
							<div class="row">
								<div class="col-md-6">
								<section class="alert alert-info animated fadeInDown">
									<header>
										<legend><i class="fa fa-book"></i> Laporan Rugi Laba</legend>
									</header>
											<div class="widget-body">
												<div class="table-responsive">
													<table class="table table-hover">
														<thead class="bg-primary text-white">
															<tr><th>Pendapatan</th></tr>
														</thead>
														<tbody>
														
												<?php
													$view=mysql_query("select * from jenis_buku WHERE kd_jr='PD' ORDER by id ASC ");
														while($row=mysql_fetch_array($view)){
																	$data=mysql_query("SELECT * FROM $table_rekening WHERE kd_jb='$row[kd_jb]' AND jenis_mutasi='kredit' ");
														echo "
														<tr>
															<td><strong>$row[kd_jb]. $row[nama_jb]</strong><br> ";
															while($r=mysql_fetch_array($data)){
																$saldo_p=saldoawalK("$tgl_kondisi-".$r['kd_rekening'])+saldoBBK("$tgl_kondisi-".$r['kd_rekening']);
														echo	"$r[kd_rekening]. $r[nama_rekening]<span class='pull-right'>".number_format($saldo_p)."</span><br> ";
															
																$pendapatan=$pendapatan+$saldo_p;
															}
															
														echo "
															</td>
														</tr> 
														";					
														}
														 ?>
														
														</tbody>
														<tfoot class="bg-info-light">
														<tr>
															<th class="text-align-center bg-primary-light">Total Pendapatan<span class="pull-right"><?php echo number_format($pendapatan);?></span></th>
														</tr>
														</tfoot>
													</table>
												</div>
											</div>
								</section>
								</div>
								<div class="col-md-6">
								<section class="alert alert-info animated fadeInDown">
									<header>
										<legend>&nbsp;</legend>
											<div class="widget-controls">
												Periode : <?php echo tgl_indo(date('Y-m-d'));?>
												<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/RL.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a>
											</div>
									</header>
											<div class="widget-body">
												<div class="table-responsive">
													<table class="table table-hover">
														<thead class="bg-primary text-white">
														<tr>
															<th>Biaya</th>
														</tr>
														</thead>
														<tbody>
														
												<?php
													$view=mysql_query("select * from jenis_buku WHERE kd_jr='BY' ORDER by id ASC ");
														while($row=mysql_fetch_array($view)){
																	$data=mysql_query("SELECT * FROM $table_rekening WHERE kd_jb='$row[kd_jb]' AND jenis_mutasi='debit' ");
														echo "
														<tr>
															<td><strong>$row[kd_jb]. $row[nama_jb]</strong><br> ";
															while($r=mysql_fetch_array($data)){
															
																$saldo_b=saldoawalD("$tgl_kondisi-".$r[kd_rekening])+saldoBBD("$tgl_kondisi-".$r[kd_rekening]);
																
														echo	"$r[kd_rekening]. $r[nama_rekening] <span class='pull-right'>".number_format($saldo_b)."</span><br> ";
															
																$biaya=$biaya+$saldo_b;
															}
															
														echo "
															</td>
														</tr> 
														";					
														}
														 ?>
														
														</tbody>
														<tfoot class="bg-info-light">
														<tr>
															<th class="text-align-center bg-primary-light">Total Biaya<span class="pull-right"><?php echo number_format($biaya);?></span></th>
														</tr>
														<tr>
															<td>&nbsp;</td>
														</tr>
														<tr>
															<th class="text-align-center bg-primary">Surplus/Devisit<span class="pull-right"><?php echo number_format($pendapatan-$biaya);?></span></th>
														</tr>
														</tfoot>
													</table>
												</div>
											</div>
								</section>
								</div>
								</div>	
						</div>
						
						<div class="tab-pane" id="tab27">
							<div class="row">
								<div class="col-md-6">
								<section class="alert alert-info animated fadeInDown">
									<header>
										<legend><i class="fa fa-book"></i> Laporan Perubahan Modal</legend>
									</header>
											<div class="widget-body">
												<div class="table-responsive">
													<table class="table table-hover">
														<thead class="bg-primary text-white">
															<tr><th>Modal</th></tr>
														</thead>
														<tbody>
														
												<?php
														$data=mysql_query("SELECT * FROM jenis_buku jb, $table_rekening r WHERE jb.kd_jr='M' AND jb.kd_jb=r.kd_jb AND jenis_mutasi='kredit' ");
														echo "
														<tr>
															<td><strong>Modal Awal 1 Januari ".date('Y')."</strong><br> ";
															while($r=mysql_fetch_array($data)){
																$modal=saldoawalK("$tgl_kondisi-".$r['kd_rekening'])+saldoBBK("$tgl_kondisi-".$r['kd_rekening']);
														echo	"$r[kd_rekening]. $r[nama_rekening]<span class='pull-right'>".number_format($modal)."</span><br> ";
															
																$modalawal=$modalawal+$modal;
															}
															
														echo "
															</td>
														</tr> 
														<tr><td class='bg-primary-light'>Total Modal Awal<span class='pull-right'>".number_format($modalawal)."</span></td></tr> 
														<tr><td><strong>Penambahan Modal</strong><br>
																Surplus s.d. ".tgl_indo(date('Y-m-d'))."<span class='pull-right'>".number_format($pendapatan-$biaya)."</span></td></tr>
														<tr><td class='bg-primary-light'>Total Penambahan Modal<span class='pull-right'>".number_format($pendapatan-$biaya)."</span></td></tr> 
														";					
														
														 ?>
														
														</tbody>
														<tfoot class="bg-info-light">
														<tr>
															<th class="text-align-center">Total Modal<span class="pull-right"><?php echo number_format($modalawal+($pendapatan-$biaya));?></span></th>
														</tr>
														</tfoot>
													</table>
												</div>
											</div>
								</section>
								</div>
								</div>	
						</div>
						
						<div class="tab-pane" id="tab37">
							
							<div class="row">
								<div class="col-md-6">
								<section class="alert alert-info animated fadeInDown">
									<header>
										<legend><i class="fa fa-book"></i> Neraca</legend>
									</header>
											<div class="widget-body">
												<div class="table-responsive">
													<table class="table table-hover">
														<thead class="bg-primary text-white">
														<tr>
															<th>Aktiva</th>
														</tr>
														</thead>
														<tbody>
														
												<?php
													$view=mysql_query("select * from rekening_riil WHERE posisi='1' ORDER by id ASC ");
														while($row=mysql_fetch_array($view)){
																	$data=mysql_query("SELECT * FROM jenis_buku WHERE kd_jr='$row[kd_rr]' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR kd_jr='$row[kd_rr]' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ORDER by kd_jb ASC ");
														echo "
														<tr>
															<td><strong>$row[nama_rr]</strong><br> ";
															while($r=mysql_fetch_array($data)){

																$saldo_aktiva=saldo("$tgl_kondisi-".$r['kd_jb']);
																
														echo	"$r[kd_jb]. $r[nama_jb] <span class='pull-right'>".number_format($saldo_aktiva)."</span><br> ";
															
																$aktiva=$aktiva+$saldo_aktiva;
															}
															
														echo "
															</td>
														</tr> 
														";					
														}
														 ?>
														
														</tbody>
														<tfoot class="bg-info-light">
														<tr>
															<th class="text-align-center bg-primary-light">Total Aktiva<span class="pull-right"><?php echo number_format($aktiva);?></span></th>
														</tr>
														</tfoot>
													</table>
												</div>
											</div>
								</section>
								</div>
								<div class="col-md-6">
								<section class="alert alert-info animated fadeInDown">
									<header>
										<legend>&nbsp;</legend>
											<div class="widget-controls">
												Periode : <?php echo tgl_indo(date('Y-m-d'));?>
												<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/NC.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a>
											</div>
									</header>
											<div class="widget-body">
												<div class="table-responsive">
													<table class="table table-hover">
														<thead class="bg-primary text-white">
														<tr>
															<th>Passiva</th>
														</tr>
														</thead>
														<tbody>
														
												<?php
													$view=mysql_query("select * from rekening_riil WHERE posisi='2' OR posisi='3' ORDER by id ASC ");
														while($row=mysql_fetch_array($view)){
														$data=mysql_query("SELECT * FROM jenis_buku WHERE kd_jr='$row[kd_rr]' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR kd_jr='$row[kd_rr]' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ORDER by kd_jb ASC ");
														echo "
														<tr height='30'>
															<td><strong>$row[nama_rr]</strong><br> ";
															while($r=mysql_fetch_array($data)){

															$saldo_passiva=saldo("$tgl_kondisi-".$r['kd_jb'])*-1;
																																										
															echo	"$r[kd_jb]. $r[nama_jb] <span class='pull-right'>".number_format($saldo_passiva)."</span><br> ";
																																									
															$passiva=$passiva+$saldo_passiva;
															}
															echo "
															</td>
														</tr> 
														";					
														}
														 ?>
														<tr><td><strong>Surplus/Devisit</strong><span class="pull-right"><?php echo number_format($pendapatan-$biaya);?></span></td></tr>
														</tbody>
														<tfoot class="bg-info-light">
														<tr>
															<th class="text-align-center bg-primary-light">Total Passiva<span class="pull-right"><?php echo number_format($passiva+($pendapatan-$biaya));?></span></th>
														</tr>
														</tfoot>
													</table>
												</div>
											</div>
								</section>
								</div>
								</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>