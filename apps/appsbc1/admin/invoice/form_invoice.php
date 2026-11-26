<script type="text/javascript">
<![CDATA[
var htmlobjek;
	$(document).ready(function() {	

			 $("#FormNominal").load('admin/invoice/form_nominal.php');	
					
					 $("#jenis_pembayarana").change(function(){
						var jenis_pembayarana = $("#jenis_pembayarana").val();
						var nomora = $("#nomora").val();
						var tgl_invoicea = $("#tgl_invoicea").val();
						var lokasia = $("#lokasia").val();
						$.ajax({
							url: "admin/invoice/form_nominal.php",
							data: "jenis_pembayarana="+jenis_pembayarana+
								"&tgl_invoicea="+tgl_invoicea+
								"&lokasia="+lokasia+
								"&nomora="+nomora,
							cache: false,
							success: function(msg){
								$("#FormNominal").html(msg);
							}
						});
					  });
					  
					  
					  $("#lokasia").change(function(){
						var jenis_pembayarana = $("#jenis_pembayarana").val();
						var nomora = $("#nomora").val();
						var tgl_invoicea = $("#tgl_invoicea").val();
						var lokasia = $("#lokasia").val();
						$.ajax({
							url: "admin/invoice/form_nominal.php",
							data: "jenis_pembayarana="+jenis_pembayarana+
								"&tgl_invoicea="+tgl_invoicea+
								"&lokasia="+lokasia+
								"&nomora="+nomora,
							cache: false,
							success: function(msg){
								$("#FormNominal").html(msg);
							}
						});
					  });
					
				 
				  
				  
				  
				  
				 
				
    });
			
]]>
</script>  

<?php 
		$jum=mysql_fetch_array(mysql_query("select max(idv) as maxidv from admin_invoice")); 
		$nomor=$jum['maxidv']+1;
		if($nomor<10) {
			$nomor_invoice="00000$nomor";
		}else if($nomor>=10 AND $nomor<100) {
			$nomor_invoice="0000$nomor";
		}else if($nomor>=100 AND $nomor<1000) {
			$nomor_invoice="000$nomor";
		}else if($nomor>=1000 AND $nomor<10000) {
			$nomor_invoice="00$nomor";
		}else if($nomor>=10000 AND $nomor<100000) {
			$nomor_invoice="0$nomor";
		}else if($nomor>100000) {
			$nomor_invoice="$nomor";
		}
?>		

		<div class="row">
            <div class="col-md-7 col-md-offset">
                <section class="widget">
                    <div class="widget-body">
					<legend>
						<h3 class="fw-semi-bold"><i class="fa fa-edit"></i> Form Pembuatan Invoice Baru / Tagihan</h3>
					</legend>
                        <div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4">Nomor Invoice</label>
                                        <div class="col-sm-8"><input type="text" class="form-control"  name="nomor_invoice" id="nomor_invoice" value="#<?php echo $nomor_invoice; ?>" disabled
										required="required" autocomplete="off" placeholder="-- Nomor Invoice --"> </div>
										<input type="hidden" name="nomora" id="nomora" value="<?php echo $nomor; ?>" >
                                    </div>

									<div class="form-group">
                                        <label class="control-label col-sm-4">Tanggal Invoice</label>
                                        <div class="col-sm-8"><input type="text" name="tgl_invoicea" id="tgl_invoicea" class="form-control" value="<?php echo date('Y-m-d'); ?>"
										required="required" autocomplete="off" placeholder="Tanggal Invoice"> </div>
                                    </div>
									<div class="form-group">
                                    <label class="col-sm-4 control-label" for="lokasi">Lokasi/Kecamatan</label>
                                    <div class="col-sm-8">
											<select id="lokasia"  name="lokasia"
                                                data-placeholder="-- Pilih Lokasi/Kecamatan --"
                                                class="select2 form-control"
                                                tabindex="-1">
												<option value=""></option>
													<?php 
													$kec=mysql_query("select * from kabupaten b, kecamatan c WHERE b.id=c.kd_kab order by nama_kec asc"); //DESA
														while($row=mysql_fetch_array($kec)){
														echo "<option value='$row[id]'>$row[nama_kec] - $row[nama_kab] - $row[nama_prov]</option>";
														} ?>
											</select>
										</div>
									</div>
									
									<div class="form-group">
                                    <label class="col-sm-4 control-label" for="jenis">Jenis Pembayaran</label>
                                    <div class="col-sm-8">
											<select id="jenis_pembayarana"  name="jenis_pembayarana"
                                                data-placeholder="-- Pilih Jenis Pembayaran --"
                                                class="select2 form-control"
                                                tabindex="-1">
												<option value=""></option>
													<?php 
													$kec=mysql_query("select * from admin_jenis_pembayaran"); //DESA
														while($row=mysql_fetch_array($kec)){
														echo "<option value='$row[id]'>$row[nama_jp]</option>";
														} ?>
											</select>
										</div>
									</div>
									
									<div id="FormNominal"></div>
									
                            </fieldset>
							

                            
                        </div>
                    </div>
                </section>
            </div>
			
			
</div>
			