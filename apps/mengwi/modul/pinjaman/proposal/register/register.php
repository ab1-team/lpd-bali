<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_pinjaman.php";
include "modul/kelompok/form_registrasi.php";
	
?> 
        <script type="text/javascript">
		
		$("#nik").focus();

					
			$(document).ready(function() {
				
				$("#kelompok").load('modul/pinjaman/register/pilih_kelompok.php');
				
				$("#nik").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
							
				$("#nik").keyup(function(){
						var nik = $("#nik").val();
					if(nik.length==16){
						$.ajax({
							type	: "POST",
							url		: "modul/penduduk/cari_penduduk.php",
							data	: "nik="+nik,
							success	: function(data){
								$("#form_register").html(data);
							}
						});
					}else{
						$("#form_register").load('modul/penduduk/blank.php');
					}
					});
					
				$("#kelompok").click(function(){
						var kelompok = $("#kelompok").val();

						$.ajax({
							type	: "POST",
							url		: "modul/pinjaman/register/input_pinjaman.php",
							data	: "kelompok="+kelompok,
							success	: function(data){
								$("#form_proposal").html(data);
							}
						});
					
					});
					

				
            });
        </script>       

		<div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <div class="widget-body">
					
				<div class="clearfix">
                    <ul id="tabs1" class="nav nav-tabs">
						<li class="pull-right"><a><i>*) Jenis Pinjaman</i></a></li>
                        <li class="active"><a href="#tab1" data-toggle="tab"><span class="badge"><i class="fa fa-group"></i></span> <b>Pinjaman Kelompok</b></a></li>
                        <li class=""><a href="#tab2" data-toggle="tab"><span class="badge"><i class="glyphicon glyphicon-user"></i></span> <b>Pinjaman Individu/Cek dan Register Penduduk</b></a></li>
                    </ul>
                </div>
                <div id="tabs1c" class="tab-content">
                    <div class="tab-pane active clearfix" id="tab1">
                        <div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
								<div class="col-md-12">
                                    <div class="input-group">

												<select id="kelompok"  name="kelompok"
													data-placeholder="Cari Kelompok dari Basis Data..."
													class="select2 form-control"
													tabindex="-1">
													<option value=""></option>
														
												</select>
												<span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#FormInputKelompok">Belum Terdaftar? <b>Buat Kelompok Baru</b></button>
                                                </span>

												<!--MODAL REGISTRASI KELOMPOK ADA DI modul/kelompok/form_registrasi.php-->
									</div>
                                </div>
									<div id="form_proposal"></div>
							</fieldset>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2">
                         <div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
								<div class="col-md-7">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4">Masukkan NIK</label>
                                        <div class="col-sm-8"><input type="text" name="nik"  maxlength="16" class="form-control input-lg" id="nik" value="<?php echo $_GET['q'];?>"
										required="required" autocomplete="off" placeholder="Masukkan Nomor Induk Kependudukan (NIK)"> </div>
                                    </div>
                                </div>
									<div id="form_register"></div>
							</fieldset>
                        </div>
                    </div>

                </div>
					
                        
                    </div>
                </section>
            </div>
			
		</div>	
