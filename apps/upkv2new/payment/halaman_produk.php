<?php session_start();
include "inc/koneksi_payment.php";

$prod=mysql_fetch_array(mysql_query("select * from produk_kategori where id='$_GET[id]' ",$koneksi_1)); 
?>
	<div class="row">
        <div class="col-md-12 col-md-offset hidden-print">
            <section class="widget">
					<legend><h3><span class="fw-semi-bold"><?php echo $prod['nama_kategori'];?></span></h3></legend>
                <div class="widget-body">
					<div class="row">
						<div class="col-md-6 col-md-offset hidden-print">
							<div id="validation-form" class="form-horizontal form-label-left" method="post"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
								<fieldset>
									<div class="form-group">
										<label class="col-sm-4 control-label" for="default-select">Pilih Produk</label>
										<div class="col-sm-8">
											<select id="kode"  name="kode"
													data-placeholder="-- Pilih Produk <?php echo $prod['nama_kategori'];?> --"
													data-width="auto"
													data-minimum-results-for-search="10"
													tabindex="-1"
													class="select2 form-control">
													<option value=""></option>
														<?php 
														$view=mysql_query("select * from produk WHERE kategori='$_GET[id]' ",$koneksi_1); //Buku Kecil
															while($row=mysql_fetch_array($view)){
															echo "<option value='$row[kode]'>$row[nama_produk]</option>";
															} ?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-sm-4">ID. Pelanggan</label>
										<div class="col-sm-8"><input type="text" name="id_pel" id="id_pel" class="form-control" 
											value="" required="required" autocomplete="off" placeholder="-- ID Pelanggan max 14 digit --"> </div>
									</div>
									
									<div class="form-group">
										<label class="control-label col-sm-4">Nomor HP</label>
										<div class="col-sm-8"><input type="text" name="hp" id="hp" class="form-control" 
											value="" required="required" autocomplete="off" placeholder="-- Nomor HP --"> </div>
									</div>
									
									<div class="form-group">
										<div class="col-sm-12"><button class="btn btn-primary btn-rounded pull-right" id="CekTagihan"><i class="fa fa-paper-plane"></i> Cek Harga / Tagihan</button></div>
									</div>
								</fieldset>
                                
							</div>
                        </div>
						
						<div class="col-md-6 col-md-offset hidden-print">
							<div id="TampilTagihan"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
			
	<div class="col-md-12">
        <div id="TampilOrder"></div>
	</div>
				
	
</div>



<script type="text/javascript">
<![CDATA[
var htmlobjek;
$(document).ready(function(){
	
	function myFunction() {
    var x = document.getElementById("CekTagihan");
    x.disabled = true;
}
	
$("#TampilOrder").load('payment/tampil_order.php');
	
	
	//CekTagihan
				$("#CekTagihan").click(function() {
                    var kode	= $('#kode').val();
                    var id_pel	= $('#id_pel').val();
                    var hp		= $('#hp').val();
					
					
					$("#id_pel").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
					
					$("#hp").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
					
					if(id_pel.length==0){
						document.getElementById("CekTagihan").disabled = false; $("#id_pel").focus();
						return false;
							}
					if(hp.length==0){
						document.getElementById("CekTagihan").disabled = false; $("#hp").focus();
						return false;
							}
							
			
                    $.ajax({
                        type: "POST",
                        url: "payment/tampil_cek.php",
                        data: 	"kode="+kode+
								"&id_pel="+id_pel+
								"&hp="+hp,
						success: function(data) {
							$("#TampilTagihan").html(data);
							document.getElementById("CekTagihan").disabled = false;

                        }
                    });
					
					
					
  

                });
	
	});
 ]]>
</script>