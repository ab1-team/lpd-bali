<?php

include "inc/fungsi_indotgl.php";
?>
<script type="text/javascript">
<![CDATA[
var htmlobjek;
$(document).ready(function(){
	
	$("#IdTransaksi").focus();
  
  
$("#FormNominal").load('modul/jurnal/form_nominal.php');
$("#TampilSaldo").load('modul/jurnal/tampil_saldo.php');
				
				
				$("#rekening").change(function(){
						var cari = $("#rekening").val();
						var tgl_transaksi = $("#tgl_transaksi").val();
						carirekening(cari);
					})
					function carirekening(e){
						var cari = e;
						if(cari==111.01 || cari==111.02 || cari==111.03 || cari==131.02 || cari==411.01 || cari==411.02){
							$("#FormNominal").load('modul/jurnal/dilarang_angsuran.php');
						}else if(cari==111.04 || cari==211.01 || cari==111.05 || cari==212.01 || cari==111.17 || cari==211.02 || cari==111.18 || cari==212.02){
							$("#FormNominal").load('modul/jurnal/dilarang_tabungan.php');
						}else if(cari==111.14 || cari==131.01){
							$("#FormNominal").load('modul/jurnal/dilarang_pencairan.php');
						}else if(cari==111.27 || cari==315.02){
							$("#FormNominal").load('modul/jurnal/dilarang_penghapusan.php');
						}else if(cari==111.29 || cari==141.01 || cari==111.30 || cari==151.01 || cari==111.31 || cari==161.01){ //20. Bayar Dimuka, 21. Inventaris, 22.Aktiva tetap
						
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
						
						}else if(cari==151.03 || cari==513.07){ //Penghapusan Inventaris
						
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
					var rekening_1 	= $("#rekening_1").val();
							
                    $.ajax({
                        type: "POST",
                        url: "modul/jurnal/tampil_buku.php",
                        data: 	"tahun="+tahun+
								"&bulan="+bulan+
								"&hari="+hari+
								"&rekening_1="+rekening_1,
								
						success: function(data) {
							$("#TampilBuku").html(data);
                        }
                    });

                });
				

				
});

 ]]>

</script>



<script type="text/javascript">

$(document).ready(function(){
  //apabila terjadi event onchange terhadap object <select id=jenis_rekening>
$("#InfoTrx").html('Disimpan ke');

  $("#jenis_transaksi").change(function(){
    var jenis_transaksi = $("#jenis_transaksi").val();
	
		 if(jenis_transaksi==1){$("#InfoTrx").html('Disimpan ke');}
	else if(jenis_transaksi==2){$("#InfoTrx").html('Untuk Keperluan');}
	else if(jenis_transaksi==3){$("#InfoTrx").html('Rekening Tujuan');}
	
    $.ajax({
        url: "modul/jurnal/ambil_rekening_1.php",
        data: "jenis_transaksi="+jenis_transaksi,
        cache: false,
        success: function(msg){
            $("#rekening_1").html(msg);
        }
    });
	
	$.ajax({
        url: "modul/jurnal/ambil_rekening_2.php",
        data: "jenis_transaksi="+jenis_transaksi,
        cache: false,
        success: function(msg){
            $("#rekening_2").html(msg);
        }
    });
	
  });
  
  
					  
				
//$("#TampilJurnal").load('modul/jurnal/tampil_jurnal.php');
$("#FormNominal").load('modul/jurnal/form_nominal.php');
//$("#TampilSaldo").load('modul/jurnal/tampil_saldo.php');
				
					
					
	$("#rekening_1").change(function(){
		var rekening_1 = $("#rekening_1").val();
		var rekening_2 = $("#rekening_2").val();
		var jenis_transaksi = $("#jenis_transaksi").val();
		
		$.ajax({
			type	: "POST",
			url		: "modul/jurnal/form_nominal.php",
			data	: "rekening_1="+rekening_1+
						"&rekening_2="+rekening_2+
						"&jenis_transaksi="+jenis_transaksi,
			success: function(data){
				$("#TampilSaldo").load('modul/jurnal/tampil_saldo.php');
				$("#FormNominal").html(data);
			}
		});
		
	  });
	  
	  
	  
	  $("#rekening_2").change(function(){
		var rekening_1 = $("#rekening_1").val();
		var rekening_2 = $("#rekening_2").val();
		var jenis_transaksi = $("#jenis_transaksi").val();
		
		$.ajax({
			type	: "POST",
			url		: "modul/jurnal/form_nominal.php",
			data	: "rekening_1="+rekening_1+
						"&rekening_2="+rekening_2+
						"&jenis_transaksi="+jenis_transaksi,
			success: function(data){
				$("#FormNominal").html(data);
			}
		});
		
	  });
					
				

				
});

</script>

<script type="text/javascript">

			$(document).ready(function() {
				
                $("#SimpanJurnal").click(function() {
                    var idt = $('#idt').val();
                    var tgl_transaksi = $('#datepicker').val();
                    var jenis_transaksi = $('#jenis_transaksi').val();
                    var rekening_1 = $('#rekening_1').val();
                    var rekening_2 = $('#rekening_2').val();
                    var invoice_beli = $('#invoice_beli').val();
                    var invoice_jual = $('#invoice_jual').val();
                    var keterangan_transaksi = $('#keterangan_transaksi').val();
                    var nominal = $('#nominal').val();
                    var urutan = $('#urutan').val();
					
					if(tgl_transaksi.length==0){ $("#konfirmasi").html('Masukkan Tanggal Transaksi!!!'); $("#datepicker").focus(); return false; }
					if(jenis_transaksi.length==0){ $("#konfirmasi").html('Pilih Jenis Transaksi!!!'); $("#jenis_transaksi").focus(); return false; }
					if(rekening_1.length==0){ $("#konfirmasi").html('Pilih Sumber Dana!!!'); $("#rekening_1").focus(); return false; }
					if(rekening_2.length==0){ $("#konfirmasi").html('Pilih Rekening Tujuan!!!'); $("#rekening_2").focus(); return false; }
					if(keterangan_transaksi.length==0){ $("#konfirmasi").html('Masukkan Keterangan Transaksi!!!'); $("#keterangan_transaksi").focus(); return false; }
					if(nominal.length==0){ $("#konfirmasi").html('Masukkan Nominal!!!'); $("#nominal").focus(); return false; }

                    $.ajax({
                        type: "POST",
                        url: "modul/jurnal/simpan_jurnal.php",
                        data: "idt="+idt+
								"&tgl_transaksi="+tgl_transaksi+
								"&jenis_transaksi="+jenis_transaksi+
								"&rekening_1="+rekening_1+
								"&rekening_2="+rekening_2+
								"&invoice_beli="+invoice_beli+
								"&invoice_jual="+invoice_jual+
								"&keterangan_transaksi="+keterangan_transaksi+
								"&nominal="+nominal+
								"&urutan="+urutan,
                        success: function(data) {
							$("#TampilJurnal").load('modul/jurnal/tampil_jurnal.php');
							$("#TampilBuku").load('modul/jurnal/tampil_buku.php');
							$("#TampilSaldo").load('modul/jurnal/tampil_saldo.php');
							document.getElementById("SimpanJurnal").disabled = false;

                        }
                    });

                });
				
            });
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
							<span class="h4 fw-semi-bold">Formulir Transaksi Umum
							</span><hr>
								<div class="form-group">
								  <label class="col-sm-4 control-label">Tanggal Transaksi</label>
									<div class="col-sm-8">
										<input type="text" class="form-control pull-right" id="datepicker" placeholder="-- Contoh: 2020-11-02 --" value="<?php echo date('Y-m-d');?>">
										<input type="hidden" id="idt" value="">
										<input type="hidden" id="urutan" value="0">
									</div>
								</div>
								<div class="form-group">
								  <label class="col-sm-4 control-label">Jenis Transaksi</label>
									<div class="col-sm-8">
										<select id="jenis_transaksi"  name="jenis_transaksi"
										data-placeholder="-- Pilih Jenis Buku --"
                                                data-width="auto"
                                                data-minimum-results-for-search="10"
                                                tabindex="-1"
												class="select2 form-control">
											<option value="">-- Pilih Jenis Transaksi --</option>
											<?php 
												$view=mysql_query("select * from jenis_transaksi"); //Buku Kecil
												while($row=mysql_fetch_array($view)){
													echo "<option value='$row[id]'>$row[nama_jt]</option>";
											} ?>
										</select>
									</div>
								</div>
								<div class="form-group">
												<label class="col-sm-4 control-label" for="default-select">Sumber Dana</label>
												<div class="col-sm-8">
													<select id="rekening_1"  name="rekening_1"
															data-placeholder="-- Pilih Sumber Dana --"
															data-width="auto"
															data-minimum-results-for-search="10"
															tabindex="-1"
															class="select2 form-control">
															<option value=""></option>
													</select>
												</div>
								</div>
								<div class="form-group">
												<label class="col-sm-4 control-label" for="default-select"><div id="InfoTrx"></div></label>
												<div class="col-sm-8">
													<select id="rekening_2"  name="rekening_2"
															data-placeholder="-- Pilih Rekening Tujuan --"
															data-width="auto"
															data-minimum-results-for-search="10"
															tabindex="-1"
															class="select2 form-control">
															<option value=""></option>
													</select>
												</div>
								</div>
								<div id="FormNominal"></div>
								<div id="konfirmasi"></div>
								
								<button class="btn btn-primary mb btn-block btn-lg" id="SimpanJurnal"><i class="fa fa-paper-plane"></i> POSTING TRANSAKSI</button>
                            </fieldset>
                                
                        </div>
                    </div>
                </section>
            </div>
			
			<div class="col-md-7">
				<div id="TampilSaldo"></div>
				<div id="TampilJurnal"></div>
				
				<section class="widget" style="border: 1px solid #5d8fc2;">
					<div class="widget-body">
						<div class="widget-top-overflow windget-padding-md clearfix bg-primary mb">
							<div class="row">
								<div class="col-md-12">
									<span class="h4 text-white">
										Tampil dan Cetak by Buku Bantu
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
										Caranya : pilih Jenis Transaksi, pilih Sumber Dana, pilih Tahunan/Bulanan/Harian, kemudian klik tombol dibawah ini.
									</div>
									
									<a href="" data-toggle="modal" data-target="#myModalDetailTransaksiUmum" id="DetailTransaksiUmum" class="btn btn-default width-150"> 
										<h1><i class="glyphicon glyphicon-th"></i></h1>
										<span class="fs-mini fw-semi-bold">Detail Transaksi</span>
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