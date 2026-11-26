<?php session_start(); 
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";

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

$(document).ready(function() {
	
	$("#SimpananIndividuTampil").load('modul/simpanan/simpanan_individu_tampil.php');

	$("#TampilData").click(function(){
		var tahun = $("#tahun").val();
		var bulan = $("#bulan").val();
			$.ajax({
			type	: "POST",
			url		: "modul/simpanan/simpanan_individu_tampil.php",
			data	: "tahun="+tahun+
			"&bulan="+bulan,
			success	: function(data){
				$("#SimpananIndividuTampil").html(data);
			}
			});
	});
	
	$("#TampilHitungBunga").click(function(){
		var tahun = $("#tahun").val();
		var bulan = $("#bulan").val();
			$.ajax({
			type	: "POST",
			url		: "modul/simpanan/tampil_hitung_bunga_simpanan_umum.php",
			data	: "tahun="+tahun+
			"&bulan="+bulan,
			success	: function(data){
				$("#TampilHitungBungaSimpananUmum").html(data);
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
											<label class='fw-normal h3'><i class="glyphicon glyphicon-th"></i> Simpanan Umum</label>
										</div>
										<div class="col-sm-2">
											<span><i class="glyphicon glyphicon-calendar"></i></span>
											<label class="fs-sm">Tahun</label>
											<select id="tahun"  name="tahun"
											data-width="auto"
											data-minimum-results-for-search="10"
											tabindex="-1"
											class="select2 form-control">
											<option value="">-</option>
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
												<option value="">-</option>
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
										<div class="col-sm-4">
											<label class="fs-sm">Action</label>
											<div>
												<a href='#' data-toggle='modal' data-target='#myModalHitungBungaSimpananUmum' id="TampilHitungBunga" class="btn btn-primary"><i class="glyphicon glyphicon-refresh"></i> Hitung Bunga</a>
												<button id="TampilData" class="btn btn-primary"><i class="glyphicon glyphicon-th"></i> Tampil Data</button>
												<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=<?php echo $sT;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Cetak"><i class="glyphicon glyphicon-print"></i> Cetak</a>
											</div>
										</div>
									</div>
							</fieldset>
						</div>
                    </div>
                </section>
		</div>
				
		
	</legend>
	
			<div id="SimpananIndividuTampil"></div>
			
	</div>
</section>


<div class="modal fade" id="myModalHitungBungaSimpananUmum" tabindex="" role="dialog" aria-labelledby="LabelHitungBungaSimpananUmum" aria-hidden="true">
	<div class="modal-content">
		<div id="TampilHitungBungaSimpananUmum"></div>
	</div>
</div>	
