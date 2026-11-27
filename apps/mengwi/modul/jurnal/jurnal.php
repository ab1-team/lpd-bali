<?php

include "inc/fungsi_indotgl.php";
?>
<script type="text/javascript">
<![CDATA[
var htmlobjek;
$(document).ready(function(){
	
	$("#IdTransaksi").focus();
	
  //apabila terjadi event onchange terhadap object <select id=jenis_rekening>
  $("#jenis_rekening").change(function(){
    var jenis_rekening = $("#jenis_rekening").val();
    $.ajax({
        url: "modul/jurnal/ambilkota.php",
        data: "jenis_rekening="+jenis_rekening,
        cache: false,
        success: function(msg){
            //jika data sukses diambil dari server kita tampilkan
            //di <select id=jenis_buku>
            $("#jenis_buku").html(msg);
        }
    });
  });
  $("#jenis_buku").change(function(){
    var jenis_buku = $("#jenis_buku").val();
    $.ajax({
        url: "modul/jurnal/ambilkecamatan.php",
        data: "jenis_buku="+jenis_buku,
        cache: false,
        success: function(msg){
            $("#jenis_mutasi").html(msg);
			$("#TampilSaldo").load('modul/jurnal/tampil_saldo.php');
			$("#FormNominal").load('modul/jurnal/form_nominal.php');
        }
    });
  });

  $("#jenis_mutasi").change(function(){
		var jenis_mutasi = $("#jenis_mutasi").val();
    $.ajax({
        url: "modul/jurnal/ambilkelurahan.php",
        data: "jenis_mutasi="+jenis_mutasi,
        cache: false,
        success: function(msg){
            $("#rekening").html(msg);
        }
    });
  });
  
  
$("#FormNominal").load('modul/jurnal/form_nominal.php');
$("#TampilSaldo").load('modul/jurnal/tampil_saldo.php');
				
				
				$("#rekening").change(function(){
						var cari = $("#rekening").val();
						var tgl_transaksi = $("#tgl_transaksi").val();
						carirekening(cari);
					})
					function carirekening(e){
						var cari = e;
						if(cari==112.01 || cari==112.02 || cari==112.03 || cari==113.01 || cari==113.02 || cari==113.03 || cari==131.02 || cari==132.02 || cari==115.01 || cari==115.02 || cari==115.03){
							$("#FormNominal").load('modul/jurnal/dilarang_angsuran.php');
						}else if(cari==112.07 || cari==113.07 || cari==131.01 || cari==131.03 || cari==132.01 || cari==132.03 || cari==122.07 || cari==123.07){
							$("#FormNominal").load('modul/jurnal/dilarang_pencairan.php');
						}else if(cari==111.28 || cari==513.01 || cari==111.30 || cari==215.02){
							$("#FormNominal").load('modul/jurnal/dilarang_penghapusan.php');
						}else if(cari==111.21 || cari==151.01 || cari==111.20 || cari==141.01 || cari==111.22 || cari==161.01){ //20. Bayar Dimuka, 21. Inventaris, 22.Aktiva tetap
						
						if(cari.length==0){ $("#rekening").focus(); return false; }
						
								$.ajax({
									type	: "POST",
									url		: "modul/jurnal/form_inventaris.php",
									data	: "cari="+cari+
												"&tgl_transaksi="+tgl_transaksi,
									success	: function(data){
										$("#FormNominal").html(data);
									}
								});
						
						}else if(cari==151.03 || cari==512.16){ //Penghapusan Inventaris
						
						if(cari.length==0){ $("#rekening").focus(); return false; }
						
								$.ajax({
									type	: "POST",
									url		: "modul/jurnal/hapus_inventaris.php",
									data	: "cari="+cari+
												"&tgl_transaksi="+tgl_transaksi,
									success	: function(data){
										$("#FormNominal").html(data);
									}
								});
						
						}else{
						$.ajax({
							type	: "POST",
							url		: "modul/jurnal/form_nominal.php",
							data	: "cari="+cari+
										"&tgl_transaksi="+tgl_transaksi,
							success	: function(data){
								$("#FormNominal").html(data);
							}
						});
						
						}
					}
				

		$("#DetailTransaksiUmum").click(function() {
					var tahun		= $("#tahun").val();
					var bulan 		= $("#bulan").val();
					var hari 		= $("#hari").val();
					var jenis_buku 	= $("#jenis_buku").val();
							
                    $.ajax({
                        type: "POST",
                        url: "modul/jurnal/tampil_buku.php",
                        data: 	"tahun="+tahun+
								"&bulan="+bulan+
								"&hari="+hari+
								"&jenis_buku="+jenis_buku,
								
						success: function(data) {
							$("#TampilBuku").html(data);
                        }
                    });

                });
				
				
			
					
			document.querySelector('#IdTransaksi').addEventListener("keyup", function(event)
				{
					if (event.keyCode === 13) 
					{
						var id_trx		= $("#IdTransaksi").val();
								
						$.ajax({
							type: "POST",
							url: "modul/jurnal/cari_transaksi.php",
							data: 	"id_trx="+id_trx,
									
							success: function(data) {
								$("#CariTransaksi").html(data);
							}
						});
					}
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
								<span class="fw-normal">T R A N S A K S I </span>  &nbsp; U M U M <i class="glyphicon glyphicon-th-large"></i> </span>
							</div>
							</div>
						</div>
						
	
		<div class="row">
		
            <div class="col-md-5 col-md-offset hidden-print">
                <section class="widget" style="background-color:#f8f8f8;">
                    <div class="widget-body">
                        <div id="validation-form" class="form-horizontal form-label-left" method="post"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
							<span class="h4 fw-semi-bold">Formulir Transaksi Umum<br>
							<span class="fs-sm fw-normal">Formulir ini dapat digunakan untuk semua transaksi kecuali Transaksi Angsuran dan Pencairan
							</span>
							</span><hr>
								<div class="form-group">
                                    <label class="col-sm-4 control-label" for="default-select">Jenis Buku</label>
                                    <div class="col-sm-8">
                                        <select id="jenis_rekening"  name="jenis_rekening"
                                                data-placeholder="-- Pilih Jenis Buku --"
                                                data-width="auto"
                                                data-minimum-results-for-search="10"
                                                tabindex="-1"
												class="select2 form-control">
												<option value=""></option>
													<?php 
													$view=mysql_query("select * from rekening_riil"); //Buku Kecil
														while($row=mysql_fetch_array($view)){
														echo "<option value='$row[kd_rr]'>$row[nama_rr]</option>";
														} ?>
										</select>
									</div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 control-label" for="default-select">Jenis Sub Buku</label>
                                    <div class="col-sm-8">
                                        <select id="jenis_buku"  name="jenis_buku"
                                                data-placeholder="-- Pilih Jenis Sub Buku --"
                                                data-width="auto"
                                                data-minimum-results-for-search="10"
                                                tabindex="-1"
												class="select2 form-control">
												<option value=""></option>
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
								
								<div id="TampilJurnal"></div>
                            </fieldset>
                                
                        </div>
                    </div>
                </section>
            </div>
			
			<div class="col-md-7">
				<div id="TampilSaldo"></div>
				
				<section class="hidden widget" style="border: 1px solid #5d8fc2;">
					<div class="widget-body">
						<div class="widget-top-overflow windget-padding-md clearfix bg-primary mb">
							<div class="row">
								<div class="col-md-6">
									<span class="hidden h4 text-white">
										Search, Print, Edit, Delete <br>by Transaksi
									</span>
								</div>
								<div class="col-md-6">
									<div class="form-group">
											<div class="input-group input-group-no-border mb-n-md">
											<span class="input-group-addon">
												<i class="fa fa-search"></i>
											</span>
												<input class="form-control" id="IdTransaksi" type="text" placeholder="Search ID Transaksi disini, lalu enter">
											</div>
										</div>
								</div>
							</div>
						</div>
						<div class="row">
								<div id="CariTransaksi"></div>
						</div>
					</div>
				</section>
				
				<section class="widget" style="border: 1px solid #5d8fc2;">
					<div class="widget-body">
						<div class="widget-top-overflow windget-padding-md clearfix bg-primary mb">
							<div class="row">
								<div class="col-md-12">
									<span class="h4 text-white">
										Tampil dan Cetak by Buku
									</span>
								</div>
							</div>
						</div>
						<div class="row">
								<div class="col-md-5">
									<div class="form-group">
										<span><i class="glyphicon glyphicon-calendar"></i></span>
										<label class="fs-sm">Tahunan</label>
										<select id="tahun"  name="tahun"
										data-width="auto"
										data-minimum-results-for-search="10"
										tabindex="-1"
										class="select2 form-control">
										<option value="">-</option>
										<?php
											$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
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
									<div class="form-group">
										<span><i class="glyphicon glyphicon-calendar"></i></span>
										<label class="fs-sm">Bulanan</label>
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
									<div class="form-group">
										<span><i class="glyphicon glyphicon-calendar"></i></span>
										<label class="fs-sm">Harian</label>
										<select id="hari"  name="hari"
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
								</div>
								<div class="col-md-7">
									<div class="alert alert-info fs-sm">
										Fitur ini dapat anda gunakan untuk menampilkan, dan mencetak transaksi periode tertentu (termasuk struk),<br>
										Caranya : pilih Jenis Buku, Jenis Sub Buku, Pilih Tahunan/Bulanan/Harian, kemudian klik tombol dibawah ini.
									</div>
									
									<a href="" data-toggle="modal" data-target="#myModalDetailTransaksiUmum" id="DetailTransaksiUmum" class="btn btn-default width-100"> 
										<h1><i class="glyphicon glyphicon-th"></i></h1>
										<span class="fs-mini fw-semi-bold">Detail<br>Transaksi</span>
									</a>	
									
								</div>
							</div>
					</div>
				</section>
				
				
			</div>
	
	
</div>

                    </div>
                </section>
            </div>
</div>


<!-- MODAL DETAIL TRANSAKSI -->
						<div class="modal fade" id="myModalDetailTransaksiUmum" tabindex="" role="dialog" aria-labelledby="LabelDetailTransaksiUmum" aria-hidden="true">
                            <div class="modal-backdrop">
                                <div class="modal-content">
                                    <div id="TampilBuku"></div>
                                </div>
                            </div>
                        </div>