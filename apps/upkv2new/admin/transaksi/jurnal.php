
<script type="text/javascript">
<![CDATA[
var htmlobjek;
$(document).ready(function(){
  //apabila terjadi event onchange terhadap object <select id=jenis_rekening>

  $("#jenis_buku").change(function(){
    var jenis_buku = $("#jenis_buku").val();
    $.ajax({
        url: "admin/transaksi/ambilkecamatan.php",
        data: "jenis_buku="+jenis_buku,
        cache: false,
        success: function(msg){
            $("#jenis_mutasi").html(msg);
			$("#TampilBuku").load('admin/transaksi/tampil_buku.php');
			$("#TampilSaldo").load('admin/transaksi/tampil_saldo.php');
        }
    });
  });

  $("#jenis_mutasi").change(function(){
		var jenis_mutasi = $("#jenis_mutasi").val();
    $.ajax({
        url: "admin/transaksi/ambilkelurahan.php",
        data: "jenis_mutasi="+jenis_mutasi,
        cache: false,
        success: function(msg){
            $("#rekening").html(msg);
        }
    });
  });
  
  
					  
				
$("#TampilJurnal").load('admin/transaksi/tampil_jurnal.php');
$("#FormNominal").load('admin/transaksi/form_nominal.php');
$("#TampilBuku").load('admin/transaksi/tampil_buku.php');
$("#TampilSaldo").load('admin/transaksi/tampil_saldo.php');
				
				
				$("#rekening").change(function(){
						var cari = $("#rekening").val();
						var tgl_transaksi = $("#tgl_transaksi").val();
						carirekening(cari);
					})
					function carirekening(e){
						var cari = e;
						if(cari==111.1001 || cari==121.1001){
							$("#FormNominal").load('admin/transaksi/dilarang_trx.php');
						}else{
						$.ajax({
							type	: "POST",
							url		: "admin/transaksi/form_nominal.php",
							data	: "cari="+cari+
										"&tgl_transaksi="+tgl_transaksi,
							success	: function(data){
								$("#FormNominal").html(data);
							}
						});
						
						}
					}
				

				
});

 ]]>

</script>

  
	
		<div class="row">
		
            <div class="col-md-5 col-md-offset hidden-print">
                <section class="widget">
									<legend>Form Transaksi Umum</legend>
                    <div class="widget-body">
                        <div id="validation-form" class="form-horizontal form-label-left" method="post"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
								<div class="form-group">
                                    <label class="col-sm-4 control-label" for="default-select">Jenis Buku</label>
                                    <div class="col-sm-8">
                                        <select id="jenis_buku"  name="jenis_buku"
                                                data-placeholder="-- Pilih Jenis Buku --"
                                                data-width="auto"
                                                data-minimum-results-for-search="10"
                                                tabindex="-1"
												class="select2 form-control">
												<option value=""></option>
													<?php 
													$view=mysql_query("select * from admin_buku"); //Buku Kecil
														while($row=mysql_fetch_array($view)){
														echo "<option value='$row[id]'>$row[nama_jb]</option>";
														} ?>
										</select>
									</div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 control-label" for="default-select">Jenis Mutasi</label>
                                    <div class="col-sm-8">
                                        <select id="jenis_mutasi"  name="jenis_mutasi"
                                                data-placeholder="-- Pilih Jenis Mutasi --"
                                                data-width="auto"
                                                data-minimum-results-for-search="10"
                                                tabindex="-1"
												class="select2 form-control">
												<option value=""></option>
										</select>
									</div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 control-label" for="default-select">Nama Rekening</label>
                                    <div class="col-sm-8">
                                        <select id="rekening"  name="rekening"
                                                data-placeholder="-- Pilih Nama Rekening --"
                                                data-width="auto"
                                                data-minimum-results-for-search="10"
                                                tabindex="-1"
												class="select2 form-control">
												<option value=""></option>
										</select>
									</div>
                                </div>
								
								<div class="form-group">
									<label class="control-label col-sm-4">Tanggal</label>
									<div class="col-sm-8"><input type="text" name="tgl_transaksi" id="tgl_transaksi" class="form-control" 
										value="<?php echo date('Y-m-d');?>" required="required" autocomplete="off" placeholder="-- Tanggal Transaksi --"> </div>
								</div>
							
							
								<div id="FormNominal"></div>
                            </fieldset>
                                
                        </div>
                    </div>
                </section>
            </div>
			
			<div class="col-md-7">
				<h1 class="page-title hidden-print"><span class="fw-semi-bold">Transaksi Jurnal Umum</span></h1>
				<legend class="mt-n-sm">Jurnal umum ini dapat digunakan untuk semua transaksi kecuali Transaksi Invoice</legend>
				<legend><div id="TampilJurnal"></div></legend>
				 <div id="TampilSaldo"></div>
			</div>
			
	
	
	<div class="col-md-12">
            <div id="TampilBuku"></div>
	</div>		
	
</div>