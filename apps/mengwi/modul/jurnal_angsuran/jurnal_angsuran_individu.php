<script type="text/javascript">
$("#individu").focus();
		function tandaPemisahTitik(b) {
                var _minus = false;
                if (b < 0) _minus = true;
                b = b.toString();
                b = b.replace(".", "");

                c = "";
                panjang = b.length;
                j = 0;
                for (i = panjang; i > 0; i--) {
                    j = j + 1;
                    if (((j % 3) == 1) && (j != 1)) {
                        c = b.substr(i - 1, 1) + "." + c;
                    } else {
                        c = b.substr(i - 1, 1) + c;
                    }
                }
                if (_minus) c = "-" + c;
                return c;
            }
            
            $('.form-hitung').keyup(function() {
                var jumlah_lama = $(this).val();
                var i = 0
				while(i <= jumlah_lama.length) {
				    jumlah_lama = jumlah_lama.toString().replace('.','')
				    i++
				}
                
                $(this).val(tandaPemisahTitik(jumlah_lama))
                
                var jumlah = $(this).val()
                changeUnit(jumlah)
            })
	$(document).ready(function() {
		$("#TampilIndividu").load('modul/jurnal_angsuran/tampil_individu.php');
		$("#SuksesAngsur").load('modul/jurnal_angsuran/petunjuk_angsuran_individu.php');
	
			//simpan angsuran		
			$("#SimpanAngsuranIndividu").click(function() {
                    var individu		= $('#individu').val();
                    var id_pinj			= $('#id_pinj').val();
                    var jenis_pp		= $('#jenis_pp').val();
                    var tgl_transaksi	= $('#datetimepicker1').val();
                    var tgl_pakai		= $('#tgl_pakai').val();
                    var pokok			= $('#pokok').val();
                    var jasa			= $('#jasa').val();
                    var denda			= $('#denda').val();
					var alokasi			= $('#alokasi').val();
                    var jumpokok		= $('#jumpokok').val();
                    var tgl_cair		= $('#tgl_cair').val();
					var zumpokok		= parseInt(jumpokok)+parseInt(pokok);
					
					var i = 0
    				while(i <= pokok.length) {
    				    pokok = pokok.toString().replace('.','')
    				    i++
    				}
    				
					var i = 0
    				while(i <= jasa.length) {
    				    jasa = jasa.toString().replace('.','')
    				    i++
    				}
    				
					var i = 0
    				while(i <= denda.length) {
    				    denda = denda.toString().replace('.','')
    				    i++
    				}
					
					if(tgl_transaksi < tgl_pakai){
						$("#SuksesAngsur").load('modul/jurnal_angsuran/dilarang_angsuran.php');
						document.getElementById("SimpanAngsuranIndividu").disabled = false;
						$("#tgl_transaksi").focus();
						return false;
							}
							
					if(tgl_transaksi < tgl_cair){
						$("#SuksesAngsur").load('modul/jurnal_angsuran/dilarang_tanggal.php');
						document.getElementById("SimpanAngsuranIndividu").disabled = false;
						$("#tgl_transaksi").focus();
						return false;
							}
					
					if(zumpokok > alokasi){
						$("#SuksesAngsur").load('modul/jurnal_angsuran/dilarang_pokok.php');
						document.getElementById("SimpanAngsuranIndividu").disabled = false;
						$("#pokok").focus();
						return false;
							}
					
					if(individu==0){
						$("#SuksesAngsur").load('modul/jurnal/dilarang.php');
						document.getElementById("SimpanAngsuranIndividu").disabled = false;
						$("#individu").focus();
						return false;
							}
							
                    $.ajax({
                        type: "POST",
                        url: "modul/jurnal_angsuran/simpan_angsuran_individu.php",
                        data: 	"id_pinj="+id_pinj+
								"&jenis_pp="+jenis_pp+
								"&tgl_transaksi="+tgl_transaksi+
								"&pokok="+pokok+
								"&jasa="+jasa+
								"&denda="+denda,
								
						success: function(data) {
							$("#SuksesAngsur").load('modul/jurnal_angsuran/sukses_angsuran_individu.php');
							$("#TampilBuku").load('modul/jurnal_angsuran/tampil_buku_angsuran_individu.php');
							$("#TampilIndividu").load('modul/jurnal_angsuran/tampil_individu.php');
							document.getElementById("SimpanAngsuranIndividu").disabled = true;
							$("#individu").focus();

                        }
                    });

                });
				
				
				$("#individu").autocomplete({
					source: "modul/jurnal_angsuran/search_individu.php",
					minLength:3,
					select:function(event, ui){
						$('#individu').val(ui.item.individu);
						$('#idpinj').val(ui.item.idpinj);
						
				// 		$('#pokok').val(ui.item.pokok);
				// 		$('#jasa').val(ui.item.jasa);
				// 		$('#denda').val(ui.item.denda);
				// 		$('#total_bayar').val(ui.item.totalbayar);
				
				        $('#pokok').val(tandaPemisahTitik(ui.item.pokok));
						$('#jasa').val(tandaPemisahTitik(ui.item.jasa));
						$('#denda').val(tandaPemisahTitik(ui.item.denda));
						
						var total_bayar = tandaPemisahTitik(ui.item.totalbayar)
						var i = 0
        				while(i <= total_bayar.length) {
        				    total_bayar = total_bayar.toString().replace('.','')
        				    i++
        				}
				// 		total_bayar = tandaPemisahTitik(total_bayar)
						$('#total_bayar').val(total_bayar);
						
						$('#id_pinj').val(ui.item.id_pinj);
						$('#jenis_pp').val(ui.item.jenis_pp);
						$('#tgl_pakai').val(ui.item.tgl_pakai);
						$('#tgl_cair').val(ui.item.tgl_cair);
						$('#alokasi').val(ui.item.alokasi);
						$('#jumpokok').val(ui.item.jumpokok);
						
						var id_pinj = $("#id_pinj").val();
						var total_bayar = $("#total_bayar").val();
						document.getElementById("totalbayar").value = tandaPemisahTitik(total_bayar);
						document.getElementById("SimpanAngsuranIndividu").disabled = false;

						$.ajax({
							type	: "POST",
							url		: "modul/jurnal_angsuran/tampil_individu.php",
							data	: "individu="+id_pinj,
							success	: function(data){
								$("#TampilIndividu").html(data);
								$("#TampilBuku").load('modul/jurnal_angsuran/tampil_buku_angsuran_individu.php');
								$("#SuksesAngsur").load('modul/jurnal_angsuran/petunjuk_angsuran_individu.php');
							}
						});
						
						
					  }
					 
				});
				
				
				// $('#individu').change(function() {
				//     alert($(this).val())
				// })
	
	});		
</script>

		<div class="row">
            <div class="col-md-12 col-md-offset hidden-print">
                <section class="widget" style="border: 1px solid #228B22;">
                    <div class="widget-body">
						<div class="widget-top-overflow windget-padding-md clearfix bg-success mb">
							<div class="row">
							<div class="col-md-5">
								<div class="form-group">
									<div class="input-group input-group-no-border mt">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i><i class="fa fa-search"></i>
									</span>
										<input class="form-control" id="individu" type="text" placeholder="Scan ID, ketik nama desa atau ketik nama debitur...">
									</div>
								</div>
							</div>
							<div class="col-md-7">
								<span class="h4 fw-bold text-white pull-right mt">
								<span class="fw-normal">FORMULIR ANGSURAN</span> PINJAMAN UMUM <i class="glyphicon glyphicon-th-large"></i> </span>
							</div>
							</div>
						</div>
												
						<div class="row">
							<div class="col-md-5 col-md-offset hidden-print">
								<section class="widget">
									<div class="widget-body">
										<div id="validation-form" class="form-horizontal form-label-left" method="post"
											  data-parsley-priority-enabled="false"
											  novalidate="novalidate">
											<fieldset>												
												
												<div class="form-group">
													<label class="control-label col-md-4">Tanggal Transaksi</label>
													<div class="col-md-8"><input id="datetimepicker1" type="text" value="<?php echo date('Y-m-d');?>" data-date-format="YYYY-MM-DD" class="form-control" /></div>
												</div>

												<div class="form-group">
													<label class="col-sm-4 control-label" for="default-select">Pokok</label>
													<div class="col-sm-8">
														<input type="text" name="pokok" id="pokok" class="form-hitung form-control text-align-right" 
													required="required" autocomplete="off" placeholder="Pokok">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4 control-label" for="default-select">Jasa</label>
													<div class="col-sm-8">
														<input type="text" name="jasa" id="jasa" class="form-hitung form-control text-align-right" 
													required="required" autocomplete="off" placeholder="Jasa">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4 control-label" for="default-select">Denda</label>
													<div class="col-sm-8">
														<input type="text" name="denda" id="denda" class="form-hitung form-control text-align-right" 
													required="required" autocomplete="off" placeholder="Denda">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4 control-label fw-semi-bold" for="default-select">Total Bayar</label>
													<div class="col-sm-8">
														<input type="text" disabled="disabled" name="totalbayar" id="totalbayar" class="form-control input-lg fw-semi-bold text-align-right">
													</div>
												</div>
												
												<input type="hidden" name="id_pinj" id="id_pinj"/>
												<input type="hidden" name="jenis_pp" id="jenis_pp"/>
												<input type="hidden" name="tgl_pakai" id="tgl_pakai"/>
												<input type="hidden" name="tgl_cair" id="tgl_cair"/>
												<input type="hidden" name="alokasi" id="alokasi"/>
												<input type="hidden" name="jumpokok" id="jumpokok"/>
												<input type="hidden" name="total_bayar" id="total_bayar"/>
												<div id="SuksesAngsur"></div>
												<button class="btn btn-inverse btn-rounded mt-sm btn-block btn-lg" id="SimpanAngsuranIndividu"><i class="fa fa-paper-plane"></i> POSTING ANGSURAN</button>
											
												
												<script type="text/javascript">
												
												function changeUnit(id) {
													var pokok = document.getElementById("pokok").value;
													var jasa = document.getElementById("jasa").value;
													var denda = document.getElementById("denda").value;
													
													var i = 0
                                    				while(i <= pokok.length) {
                                    				    pokok = pokok.toString().replace('.','')
                                    				    i++
                                    				}
                                    				
													var i = 0
                                    				while(i <= jasa.length) {
                                    				    jasa = jasa.toString().replace('.','')
                                    				    i++
                                    				}
                                    				
													var i = 0
                                    				while(i <= denda.length) {
                                    				    denda = denda.toString().replace('.','')
                                    				    i++
                                    				}
                                    				
													var sumbayar= parseInt(pokok) + parseInt(jasa) + parseInt(denda);
												    document.getElementById("totalbayar").value=tandaPemisahTitik(sumbayar);
												}
												</script>
								
											</fieldset>
									
										</div>
									</div>
								</section>
								
							</div>
							<div class="col-md-7">
								<div id="TampilIndividu"></div>
							</div>
						</div>
						
                    </div>
                </section>
            </div>
</div>