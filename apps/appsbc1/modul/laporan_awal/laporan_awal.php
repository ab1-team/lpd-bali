<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_keuangan.php";
$table_rekening		="rekening_".$_SESSION['lokasi'];
$table_transaksi		="transaksi_".$_SESSION['lokasi'];

$tg=mysql_fetch_array(mysql_query("SELECT * FROM $table_rekening"));
$tgl_awal=$tg['tgl_awal'];
$tgl_kondisi=$tg['tgl_awal'];

$tahun	=substr($tgl_awal,0,4);
$thawal_ttpbuku	=$tahun-1;
$bulan	=substr($tgl_awal,5,2);
 ?>
<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}

$(document).ready(function() {

	$("#TampilJurnalAwal").load('modul/laporan_awal/jurnal_awal.php');

});
</script>

	<h4 class="page-title hidden-print"><i class="glyphicon glyphicon-cog"></i><span class="fw-semi-bold"> Laporan Keuangan</span> Awal
	<span class="pull-right">Periode : <?php echo tgl_indo($tg['tgl_awal']);?></span></h4>
	
		<div class="row">
			<div class="col-md-12">
                <div class="tabbable tabs-left mb-lg">
                    <ul id="tabs2" class="nav nav-tabs hidden-print">
                        <li class="active"><a href="#tab15" data-toggle="tab"><i class="fa fa-book"></i> Jurnal Awal</a></li>
                        <li class=""><a href="#tab25" data-toggle="tab"><i class="fa fa-book"></i> Rugi Laba</a></li>
                        <li class=""><a href="#tab35" data-toggle="tab"><i class="fa fa-book"></i> Neraca</a></li>
							<?php 
							$view=mysql_query("SELECT * FROM jenis_buku WHERE lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ORDER by kd_jb ASC");
								while($row=mysql_fetch_array($view)){
									echo "<li class=''><a href='#tab$row[kd_jb]a' data-toggle='tab'>$row[icon] $row[nama_jb]</a></li>";
							} ?>
                        
                    </ul>
                    <div id="tabs5c" class="tab-content">
						<div class="active tab-pane" id="tab15">
							<div id="TampilJurnalAwal"></div>	
						</div>
						<div class="tab-pane" id="tab25">
							<div class="row">
								<div class="col-md-6">
								<section class="alert alert-info animated fadeInDown">
									<header>
										<legend><i class="fa fa-book"></i> Rugi Laba Awal</legend>
									</header>
											<div class="widget-body">
												<div class="table-responsive">
													<table class="table table-hover">
														<thead class="bg-primary text-white">
														<tr>
															<th>Pendapatan</th>
														</tr>
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
																$kr=mysql_fetch_array(mysql_query("SELECT sum(awal)+sum(tb$thawal_ttpbuku) AS sumkredit FROM $table_rekening WHERE kd_rekening='$r[kd_rekening]' "));
																$saldo_p=$kr['sumkredit'];
																$kd_rekening	=$r['kd_rekening'];
																
															
																
														echo	"$kd_rekening. $r[nama_rekening]<span class='pull-right'>".number_format($saldo_p)."</span><br> ";
															
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
												Periode : <?php echo tgl_indo($tg['tgl_awal']);?>
												<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/RL.php?idf=&y=<?php echo $tahun;?>&m=<?php echo $bulan;?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a>
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
																$db=mysql_fetch_array(mysql_query("SELECT sum(awal)+sum(tb$thawal_ttpbuku) AS sumdebit FROM $table_rekening WHERE kd_rekening='$r[kd_rekening]' "));
																$saldo_b=$db['sumdebit'];
																
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
						
						<div class="tab-pane" id="tab35">
							
							<div class="row">
								<div class="col-md-6">
								<section class="alert alert-info animated fadeInDown">
									<header>
										<legend><i class="fa fa-book"></i> Neraca Awal</legend>
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
															
																$saldo_kas=saldo("$tg[tgl_awal]-$r[kd_jb]");

														echo	"$r[kd_jb]. $r[nama_jb] <span class='pull-right'>".number_format($saldo_kas)."</span><br> ";
															
																$aktiva=$aktiva+$saldo_kas;
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
												Periode : <?php echo tgl_indo($tg['tgl_awal']);?>
												<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/NC.php?idf=&y=<?php echo $tahun;?>&m=<?php echo $bulan;?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class="glyphicon glyphicon-print hidden-print"></i></a>
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
														$data=mysql_query("SELECT * FROM jenis_buku WHERE kd_jr='$row[kd_rr]' AND lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR kd_jr='$row[kd_rr]' AND lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ORDER by kd_jb ASC");
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
														<tr><td><strong>Surplus/Devisit tb2014</strong><span class="pull-right"><?php echo number_format($pendapatan-$biaya);?></span></td></tr>
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
				
						<?php //AWAL BUKU BESAR
							$dabuk=mysql_query("select * from jenis_buku order by id");
								while($r=mysql_fetch_array($dabuk)){
								$totdebit	=saldoATD("$tgl_kondisi-".$r['kd_jb'])+saldoABKD("$tgl_kondisi-".$r['kd_jb'])+saldoD("$tgl_kondisi-".$r['kd_jb']);
								$totkredit	=saldoATK("$tgl_kondisi-".$r['kd_jb'])+saldoABKK("$tgl_kondisi-".$r['kd_jb'])+saldoK("$tgl_kondisi-".$r['kd_jb']);

								$saldo=saldo("$tgl_kondisi-".$r['kd_jb']);
									if($saldo>0) {
										$ketsaldo="Saldo Debit";
										$totsaldo=$saldo;
									}elseif($saldo<0){
										$totsaldo=$saldo*-1;
										$ketsaldo="Saldo Kredit";
									}else{
										$ketsaldo="Tidak Ada Saldo";
										$totsaldo="0";
										}
						?>
				
						<div class="tab-pane" id="tab<?php echo $r['kd_jb'];?>a">
							<div class="row">
								<header class="ml-lg mr-lg">
										<legend><strong><?php echo $r['icon'];?> <?php echo $ketsaldo;?></strong> <?php echo $r['nama_jb'];?></legend>
										<p class="mt-n-md fs-sm ml-lg mb-md text-muted">Nomor Rekening : <?php echo $r['kd_jb'];?> <span class="h3 mt-0 pull-right text-gray-darker"><?php echo number_format($saldo);?></span><p>
								</header>
								<div class="col-md-6">
								<section class="alert alert-info animated fadeInDown">
									<header>
										<legend><?php echo $r['icon'];?></i> <?php echo $r['nama_jb'];?></legend>
									</header>
											<div class="widget-body">
												<div class="table-responsive">
													<table class="table table-hover">
														<thead class="bg-primary text-white">
														<tr>
															<th>Debit</th>
														</tr>
														</thead>
														<tbody>
														
												<?php
												$data=mysql_query("SELECT * FROM $table_rekening WHERE kd_jb='$r[kd_jb]' AND jenis_mutasi='debit' ");
															while($row=mysql_fetch_array($data)){
															$saldodebit=saldoawalD("$tgl_awal-".$row['kd_rekening'])+saldoBBD("$tgl_awal-".$row['kd_rekening']);
												echo "<tr><td>$row[kd_rekening]. $row[nama_rekening]<span class='pull-right'>".number_format($saldodebit)."</span></td></tr>";
														
														}
														
														 ?>
														</tbody>
														<tfoot class="bg-info-light">
														<tr>
															<th class="text-align-center bg-primary-light">Total Debit<span class="pull-right"><?php echo number_format($totdebit);?></span></th>
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
												Nomor Rekening : <?php echo $r['kd_jb'];?>
												<a href="#" id="print"><i class="glyphicon glyphicon-print hidden-print"></i></a>
											</div>
									</header>
											<div class="widget-body">
												<div class="table-responsive">
													<table class="table table-hover">
														<thead class="bg-primary text-white">
														<tr>
															<th>Kredit</th>
														</tr>
														</thead>
														<tbody>
														
												<?php
												$data=mysql_query("SELECT * FROM $table_rekening WHERE kd_jb='$r[kd_jb]' AND jenis_mutasi='kredit' ");
															while($row=mysql_fetch_array($data)){
															$saldokredit=saldoawalK("$tgl_awal-".$row['kd_rekening'])+saldoBBK("$tgl_awal-".$row['kd_rekening']);
												echo "<tr><td>$row[kd_rekening]. $row[nama_rekening]<span class='pull-right'>".number_format($saldokredit)."</span></td></tr>";
														
														}
														
														 ?>
														</tbody>
														<tfoot class="bg-info-light">
														<tr>
															<th class="text-align-center bg-primary-light">Total Kredit<span class="pull-right"><?php echo number_format($totkredit);?></span></th>
														</tr>
														</tfoot>
													</table>
												</div>
											</div>
								</section>
								</div>
							</div>	
						</div>
						<?php
						} //END BUKU BESAR
						?>
						
                    </div>
                </div>
            </div>
        </div>