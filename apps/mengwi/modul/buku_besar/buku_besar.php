<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_keuangan.php";
$table_rekening		="rekening_".$_SESSION[lokasi];

$tgl_kondisi	=date('Y-m-d');
 ?>

<script type="text/javascript">

$(document).ready(function() {

	$("#TampilListJurnal").load('modul/buku_besar/list_jurnal.php');

});
</script>

	<h4 class="page-title hidden-print"><i class="glyphicon glyphicon-book"></i><span class="fw-semi-bold"> Buku Besar</span>
	<span class="pull-right">Status : <?php echo tgl_indo(date('Y-m-d'));?></span></h4>
	
		<div class="row">
			<div class="col-md-12">
                <div class="tabbable tabs-left mb-lg">
                    <ul id="tabs2" class="nav nav-tabs hidden-print">
                        <li class="active"><a href="#tab16" data-toggle="tab"><i class="fa fa-exchange"></i> List Jurnal</a></li>
							<?php 
							$view=mysql_query("select * from jenis_buku WHERE lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ORDER BY kd_jb ASC ");
								while($row=mysql_fetch_array($view)){
									echo "<li class=''><a href='#tab$row[kd_jb]b' data-toggle='tab'>$row[icon] $row[nama_jb]</a></li>";
							} ?>
                        
                    </ul>
                    <div id="tabs5c" class="tab-content">
						<div class="active tab-pane" id="tab16">
							<div id="TampilListJurnal"></div>	
						</div>
				
						<?php //AWAL BUKU BESAR
							$dabuk=mysql_query("select * from jenis_buku WHERE lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' ORDER BY kd_jb ASC ");
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
				
						<div class="tab-pane" id="tab<?php echo $r['kd_jb'];?>b">
							<div class="row">
								<header class="ml-lg mr-lg">
										<legend><strong><?php echo $r['icon'];?> <?php echo $ketsaldo;?></strong> <?php echo $r['nama_jb'];?></legend>
										<p class="mt-n-md fs-sm ml-lg mb-md text-muted">Nomor Rekening : <?php echo $r['kd_jb'];?> <span class="h3 mt-0 pull-right text-gray-darker"><?php echo number_format($totsaldo);?></span><p>
								</header>
								<div class="col-md-6">
								<section class="alert alert-info animated fadeInDown">
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
															$saldodebit=saldoawalD("$tgl_kondisi-".$row[kd_rekening])+saldoBBD("$tgl_kondisi-".$row[kd_rekening]);
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
															$saldokredit=saldoawalK("$tgl_kondisi-".$row[kd_rekening])+saldoBBK("$tgl_kondisi-".$row[kd_rekening]);
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