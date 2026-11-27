<?php session_start(); 	

	$_SESSION['nia'] = NULL;

?>
        <script type="text/javascript">
		
		$("#nik").focus();

					
			$(document).ready(function() {
				$("#form_register").load('modul/simpanan/register/cari_penduduk.php');
				
				$("#nik").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
							
				$("#nik").keyup(function(){
						var cari = $("#nik").val();
						cariAnggota(cari);
					})
					function cariAnggota(e){
						var cari = e;
						
					if(cari.length==16){
						
						$.ajax({
							type	: "POST",
							url		: "modul/simpanan/register/cari_penduduk.php",
							data	: "nik="+cari,
							success	: function(data){
								$("#form_register").html(data);
								
							}
						});
					}
					
					}
				
            });
        </script>       

		<div class="row">
        <div class="col-md-12">
            <div id="tabs1c" class="tab-content mb-lg">
                <div class="tab-pane active" id="tabk12">
                    <section class="widget">
                        <div class="widget-body">
                            <div class="widget-top-overflow windget-padding-md clearfix bg-primary">
                                <span class="h5 fw-bold text-white"><i class="glyphicon glyphicon-th-large"></i> FORM BUKA SIMPANAN</span>
                            </div>
                        </div>
                        <div id="validation-form" class="form-horizontal form-label-left" data-parsley-priority-enabled="false" novalidate="novalidate">
                            <fieldset>
                                <div class="col-md-7">
                                    <div class="form-group mt">
                                        <label class="control-label col-sm-4">Masukkan NIK</label>
                                        <div class="col-sm-8"><input type="text" name="nik" maxlength="16" class="form-control input-lg fw-semi-bold" id="nik" value="<?php echo $_GET['q']; ?>" required="required" autocomplete="off" placeholder="Masukkan Nomor Induk Kependudukan (NIK)"> </div>
                                    </div>
                                </div>
                                <div id="form_register"></div>
                            </fieldset>
                        </div>
                    </section>
                </div>
                <div class="tab-pane" id="tabp2">
                    <div id="DetailProposal"></div>
                </div>
            </div>
        </div>
    </div>
