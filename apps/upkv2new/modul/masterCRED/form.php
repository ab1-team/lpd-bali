 <script type="text/javascript" src="js/jquery-1.2.3.min.js"></script>
        <script type="text/javascript">
			$(document).ready(function() {

				$("#kd_kas").keyup(function(e){
						var isi = $(e.target).val();
						$(e.target).val(isi.toUpperCase());
					});
	
				$("#TampilData").load('modul/jeniskas/tampil.php');
                $("#FormSubmit").click(function() {
                    var kd_kas = $('#kd_kas').val();
                    var nama_kas = $('#nama_kas').val();
                    var deskripsi = $('#deskripsi').val();
						if(kd_kas.length==0){
						alert('Kode Kas tidak boleh kosong!');
						$("#kd_kas").focus();
						return false;
							}
						if(nama_kas.length==0){
						alert('Nama Kas tidak boleh kosong!');
						$("#nama_kas").focus();
						return false;
							}
						if(deskripsi.length==0){
						alert('Deskripsi tidak boleh kosong!');
						$("#deskripsi").focus();
						return false;
							}

							
                    $.ajax({
                        type: "POST",
                        url: "modul/jeniskas/simpan.php",
                        data: "kd_kas="+kd_kas+
								"&nama_kas="+nama_kas+
								"&deskripsi="+deskripsi,
                        success: function(data) {
                            $("#TampilData").load('modul/jeniskas/tampil.php');
							alert('Berhasil !');

                        }
                    });

                });
				
            });
        </script>       
		
		<div class="row">
            <div class="col-md-5 col-md-offset">
                <section class="widget">
                    <header>
                        <legend><i class="fa fa-cog"></i> Form Setup Jenis Kas</legend>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
                    <div class="widget-body">
                        <div id="validation-form" class="form-horizontal form-label-left" method="post"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Kode Kas</label>
                                        <div class="col-sm-9"><input type="text" name="kd_kas" id="kd_kas" maxlength="2" class="form-control" 
										required="required" autocomplete="off" placeholder="Kode Panggil Kas"> </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Nama Kas</label>
                                        <div class="col-sm-9"><input type="text" name="nama_kas" id="nama_kas" class="form-control" 
										required="required" autocomplete="off" placeholder="Nama Singkat Kas"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-3">Deskripsi</label>
                                        <div class="col-sm-9"><input type="text" name="deskripsi" id="deskripsi" class="form-control" 
										required="required" autocomplete="off" placeholder="Nama Panjang Kas"> </div>
                                    </div>
                            </fieldset>
                           
                            <div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="FormSubmit"><i class="fa fa-floppy-o"></i> Simpan</button>
                                <button type="button" class="btn btn-default btn-rounded">Cancel</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
			
	<div class="col-md-7">
		<section class="widget">
					<header>
                        <legend><i class="fa fa-th-list"></i> Daftar Jenis Kas</legend>
                        <div class="widget-controls">
                            <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                            <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                            <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                    </header>
            <div id="TampilData"></div>
        </section>
	</div>
</div>