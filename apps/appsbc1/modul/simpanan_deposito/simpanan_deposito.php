<?php session_start(); 
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_simpanan_individu.php";

?>
<head>
	<script>
		$(document).ready(function(){
		  $(".preloader").fadeOut("slow");
		})
	</script>
</head>
<div class="preloader">
	<div class="loading">
		<img src="images/animation.gif" width="280">
	</div>
</div>
<script type="text/javascript">	

$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
		
function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
function DetailSimpananDeposito(ID){
		var ids = ID;
		$.ajax({
			type	: "POST",
			url	:"modul/simpanan_deposito/detail_simpanan_deposito.php",
			data	: "ids="+ids,
			success: function(data) {
				$("#TampilDetailSimpananDeposito").html(data);
			}
		});
		
	}

$(document).ready(function() {

	$("#TampilHitungBungaDeposito").click(function(){
		var tahun = $("#tahun").val();
		var bulan = $("#bulan").val();
		var tanggal = $("#tanggal").val();
			$.ajax({
			type	: "POST",
			url		: "modul/simpanan_deposito/tampil_hitung_bunga_simpanan_deposito.php",
			data	: "tahun="+tahun+
			"&bulan="+bulan+
			"&tanggal="+tanggal,
			success	: function(data){
				$("#TampilHitungBungaSimpananDeposito").html(data);
			}
			});
	});

				
});	

	
</script>
<section class="widget">
 <div class="widget-body">
	<legend>
		
				<div class="row">
                <section class="widget" style="background-color:#f8f8f8;">
                    <div class="widget-body">
                        <div id="validation-form" class="form-horizontal form-label-left" method="post"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="form-group">
										<div class="col-sm-4">
											<label class='fw-normal h3'><i class="glyphicon glyphicon-th"></i> Simpanan Deposito</label>
										</div>
										<div class="col-sm-2">
											<span><i class="glyphicon glyphicon-calendar"></i></span>
											<label class="fs-sm">Tahun</label>
											<select id="tahun"  name="tahun"
											data-width="auto"
											data-minimum-results-for-search="10"
											tabindex="-1"
											class="select2 form-control">
											<?php
												$tp=mysql_fetch_array(mysql_query("SELECT * FROM desa WHERE id='$_SESSION[lokasi]' "));
													$tgl_pakai		=$tp['tgl_pakai'];
													$th_pakai   	= substr($tgl_pakai,0,4);
												$th=date('Y');
												for($t=$th_pakai;$t<=$th;$t++) 
												{
												echo "<option selected value=$t>$t</option>";
												}
												?>
											</select>
										</div>
										<div class="col-sm-2">
											<span><i class="glyphicon glyphicon-calendar"></i></span>
											<label class="fs-sm">Bulan</label>
											<select id="bulan"  name="bulan"
											data-width="auto"
											data-minimum-results-for-search="10"
											tabindex="-1"
											class="select2 form-control">
												<option value="<?php $bln=date('m'); echo $bln;?>"><?php echo strtoupper(bln_indo(date('Y-m')));?></option>
												<option value="01">JANUARI</option>
												<option value="02">FEBRUARI</option>
												<option value="03">MARET</option>
												<option value="04">APRIL</option>
												<option value="05">MEI</option>
												<option value="06">JUNI</option>
												<option value="07">JULI</option>
												<option value="08">AGUSTUS</option>
												<option value="09">SEPTEMBER</option>
												<option value="10">OKTOBER</option>
												<option value="11">NOVEMBER</option>
												<option value="12">DESEMBER</option>
											</select>
										</div>
										<div class="col-sm-1">
											<span><i class="glyphicon glyphicon-calendar"></i></span>
											<label class="fs-sm">Tanggal</label>
											<select id="tanggal"  name="tanggal"
											data-width="auto"
											data-minimum-results-for-search="10"
											tabindex="-1"
											class="select2 form-control">
												<option value="<?php $tgl=date('d'); echo $tgl;?>"><?php $tgl=date('d'); echo $tgl;?></option>
												<?php
												for($tg=1;$tg<=31;$tg++) 
												{
												if($tg<=9){$tg="0$tg";}else{$tg=$tg;}
												echo "<option value=$tg>$tg</option>";
												}
												?>
											</select>
										</div>
										<div class="col-sm-3">
											<label class="fs-sm">Action</label>
											<div>
												<a href='#' data-toggle='modal' data-target='#myModalHitungBungaSimpananDeposito' id="TampilHitungBungaDeposito" class="btn btn-primary"><i class="glyphicon glyphicon-refresh"></i> Hitung Bunga</a>
												<a href="modul/pelaporan/p/SD.php?&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=<?php echo date('d');?>"   class="btn btn-primary" target="_target" data-toggle="tooltip" data-placement="top" title="Cetak"><i class="glyphicon glyphicon-print"></i> Cetak</a>
											</div>
										</div>
							</fieldset>
                        </div>
                    </div>
                </section>
		</div>
				
		
	</legend>
			<div class="table-responsive">
                    <table id="datatable-table" class="table table-hover table-emails">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>CIF</th>
                            <th>Tgl Buka</th>
                            <th>NOREK</th>
                            <th class="hidden-xs">Nama Kreditur</th>
                            <th class="hidden-xs">Saldo</th>
                            <th class="hidden-xs">Tempo</th>
                            <th class="hidden-xs">Bunga</th>
                            <th class="hidden-xs">target</th>
                            <th class="hidden-xs">Paid</th>
                            <th class="hidden-xs">UNPaid</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						$view=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, status_simpanan ss, simpanan_anggota_$_SESSION[kd_kab] si
																WHERE
																a.id=si.nia AND ss.kd_status=si.status AND si.lokasi='$_SESSION[lokasi]' AND si.jenis_simpanan='2' order by si.id asc");
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$idsimp			=$row['id'];
								$tgl_now		=date('Y-m-d');
								$sumnabung		=sumnabung("$tgl_now-$idsimp");
								$sumambil		=sumambil("$tgl_now-$idsimp");
								$saldosimpanan	=saldosimpanan("$tgl_now-$idsimp");
								$bulanke		=bulankeSD("$tgl_now-$idsimp");
								$targetbungaSD	=targetbungaSD("$tgl_now-$idsimp");
								$bungapaidSD	=bungapaidSD("$tgl_now-$idsimp");
								$bungaunpaidSD	=$targetbungaSD-$bungapaidSD;
								$sts			=$row['status'];
								
									?>
						
						<?php echo "<tr style='cursor: pointer;' href='#' data-toggle='modal' data-target='#myModalDetailSimpananDeposito' onclick='javascript:DetailSimpananDeposito(\"{$row['id']}\")' >"; ?>
							<td><span class="toggle badge bg-default"><?php echo $no;?></span></td>
							<td class="subject fw-normal hidden-xs"><?php echo $row['id'];?></td>
							<td class="subject fw-normal hidden-xs"><?php echo tgl_ind($row['tgl_buka']);?></td>
							<td class="subject fw-normal hidden-xs"><?php echo $row['nomor_rekening'];?></td>
							<td class="name fw-normal hidden-xs"><?php echo strtoupper($row['namadepan']);?></td>
							<td class="name fw-normal hidden-xs text-align-right"><?php echo number_format($saldosimpanan);?></td>
							<td class="name fw-normal hidden-xs text-align-center"><?php echo $row['jangka'];?> bln</td>
							<td class="name fw-normal hidden-xs text-align-center"><?php echo $row['pros_jasa'];?> %</td>
							<td class="name fw-normal hidden-xs text-align-right"><?php echo number_format($targetbungaSD);?></td>
							<td class="name fw-normal hidden-xs text-align-right"><?php echo number_format($bungapaidSD);?></td>
							<td class="name fw-normal hidden-xs text-align-right"><?php echo number_format($bungaunpaidSD);?></td>
							<td class="text-align-center"><span class="label label-<?php echo $row['warna_status'];?>"><?php echo $row['nama_status'];?></span></td>
                        </tr>
						 
						 
						 
						
								<?php } ?>
                        </tbody>
                    </table>
					<center class="fs-mini text-muted">* Klik untuk Detail Simpanan </center>
            </div>
	</div>
</section>

<div class="modal fade" id="myModalDetailSimpananDeposito" tabindex="" role="dialog" aria-labelledby="LabelDetailSimpananIndividu" aria-hidden="true">
	<div class="modal-content">
		<div id="TampilDetailSimpananDeposito"></div>
	</div>
</div>

<div class="modal fade" id="myModalHitungBungaSimpananDeposito" tabindex="" role="dialog" aria-labelledby="LabelHitungBungaSimpananUmum" aria-hidden="true">
	<div class="modal-content">
		<div id="TampilHitungBungaSimpananDeposito"></div>
	</div>
</div>	
