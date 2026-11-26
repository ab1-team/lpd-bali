<script type="text/javascript">
			$(document).ready(function() {

                $("#TahunAnggaran").click(function() {
                    var tahun = $('#tahun').val();
					
						if(tahun.length==0){ $("#Dilarang").load('modul/kelompok/dilarang.php'); $("#tahun").focus(); return false; }

                    $.ajax({
                        type: "POST",
                        url: "modul/e_bud/insert_kolom.php",
                        data: "tahun="+tahun,
                        success: function(data) {
							$("#Step2").load('modul/e_bud/step2.php');
                        }
                    });

                });
				
            });
        </script>

<h3><i class="glyphicon glyphicon-plane"></i> E-Budgeting / Rencana Anggaran dan Biaya</h3>

<section class="widget">
	<div class="widget-body">
		<form role="form">
			<fieldset>
				<legend class="h4"><strong> Step 1 :</strong>  Tentukan Tahun Anggaran</legend>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<div class="input-group">
									<input type="text" class="form-control input-lg" id="tahun" name="tahun" value="<?php echo date('Y'); ?>" 
										required="required" autocomplete="off" placeholder="Tahun Anggaran">
									<span class="input-group-btn">
										<button type="button" class="btn btn-success input-lg" id="TahunAnggaran"><i class="glyphicon glyphicon-retweet text-white"></i> Create / View</button>
									</span>
								</div>
								<div id="Dilarang"></div>
							</div>
						</div>
					</div>
			</fieldset>
		</form>
	</div>
</section>

<section class="widget">
	<div class="widget-body">
		<form role="form">
			<fieldset>
				<div id="Step2"></div>
			</fieldset>
		</form>
	</div>
</section>