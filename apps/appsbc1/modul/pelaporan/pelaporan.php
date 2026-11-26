<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
										
?>

<script type="text/javascript">

	<![CDATA[
var htmlobjek;
$(document).ready(function(){
	
  
  $("#GenerateLaporan").click(function() {
					var y		= $("#y").val();
					var m 		= $("#m").val();
					var d 		= $("#d").val();
							
                    $.ajax({
                        type: "POST",
                        url: "modul/pelaporan/tampil_laporan.php",
                        data: 	"y="+y+
								"&m="+m+
								"&d="+d,
								
						success: function(data) {
							$("#TampilLaporan").html(data);
                        }
                    });

                });
  
  });




 ]]>
</script>
		
<div class="row">
	<div class="col-md-12 col-md-offset hidden-print">
        <section class="widget" style="border: 1px solid #5d8fc2;">
			<div class="widget-body">
				<div class="widget-top-overflow windget-padding-md clearfix bg-primary mb">
					<div class="row">
						<div class="col-md-12">
							<span class="h4 fw-bold text-white pull-right mt">
							<span class="fw-normal">HALAMAN </span>  PELAPORAN <i class="glyphicon glyphicon-th-large"></i> </span>
						</div>
					</div>
				</div>

		<div class="row">
                <section class="widget" style="background-color:#f8f8f8;">
                    <div class="widget-body">
                        <div id="validation-form" class="form-horizontal form-label-left" method="post"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="form-group">
										<div class="col-sm-1">
										</div>
										<div class="col-sm-2">
											<span><i class="glyphicon glyphicon-calendar"></i></span>
											<label class="fs-sm">Tahunan</label>
											<select id="y"  name="y"
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
										<div class="col-sm-3">
											<span><i class="glyphicon glyphicon-calendar"></i></span>
											<label class="fs-sm">Bulanan</label>
											<select id="m"  name="m"
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
										<div class="col-sm-2">
											<span><i class="glyphicon glyphicon-calendar"></i></span>
											<label class="fs-sm">Harian</label>
											<select id="d"  name="d"
											data-width="auto"
											data-minimum-results-for-search="10"
											tabindex="-1"
											class="select2 form-control">
												<option value="">-</option>
												<?php
												for($tg=1;$tg<=31;$tg++) 
												{
												if($tg<=9){$tg="0$tg";}else{$tg=$tg;}
												echo "<option value=$tg>$tg</option>";
												}
												?>
											</select>
										</div>
										<div class="col-sm-4">
											<button type="submit" id="GenerateLaporan" class="btn btn-primary width-200 mb-xs" role="button">
												G E N E R A T E<br>LAPORAN
											</button>
										</div>
									</div>
									<legend></legend>
									<div class="col-sm-12">
										<div id="TampilLaporan"></div>
									</div>
							</fieldset>
                        </div>
                    </div>
                </section>
		</div>
 
		

	
			</div>
		</section>
	</div>
</div>