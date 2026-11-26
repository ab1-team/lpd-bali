<script type="text/javascript">

$("#individu").focus();
		
		function tandaPemisahTitik(b){
				var _minus = false;
				if (b<0) _minus = true;
				b = b.toString();
				b=b.replace(".","");
				
				c = "";
				panjang = b.length;
				j = 0;
				for (i = panjang; i > 0; i--){
					 j = j + 1;
					 if (((j % 3) == 1) && (j != 1)){
					   c = b.substr(i-1,1) + "." + c;
					 } else {
					   c = b.substr(i-1,1) + c;
					 }
				}
				if (_minus) c = "-" + c ;
				return c;
			}
			
		function numbersonly(ini, e){
				if (e.keyCode>=48){
					if(e.keyCode<=57){
					a = ini.value.toString().replace(".","");
					b = a.replace(/[^\d]/g,"");
					b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
					ini.value = tandaPemisahTitik(b);
					return false;
					}
					else if(e.keyCode<=105){
						if(e.keyCode>=96){
							//e.keycode = e.keycode - 47;
							a = ini.value.toString().replace(".","");
							b = a.replace(/[^\d]/g,"");
							b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
							ini.value = tandaPemisahTitik(b);
							//alert(e.keycode);
							return false;
							}
						else {return false;}
					}
					else {
						return false; }
				}else if (e.keyCode==95){
					a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
					b = a.replace(/[^\d]/g,"");
					if (parseFloat(b)!=0){
						ini.value = tandaPemisahTitik(b);
						return false;
					} else {
						return false;
					}
				}else if (e.keyCode==8 || e.keycode==46){ //Dellete/Backspace
					a = ini.value.replace(".","");
					b = a.replace(/[^\d]/g,"");
					b = b.substr(0,b.length -1);
					if (tandaPemisahTitik(b)!=""){
						ini.value = tandaPemisahTitik(b);
					} else {
						ini.value = "";
					}
					
					return false;
				} else if (e.keyCode==9){ //Tab
					return true;
				} else if (e.keyCode==17){ //Ctrl
					return true;
				} else {
					//alert (e.keyCode);
					return false;
				}

			}
		
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
						$('#pokok').val(tandaPemisahTitik(ui.item.pokok));
						$('#jasa').val(tandaPemisahTitik(ui.item.jasa));
						$('#denda').val(tandaPemisahTitik(ui.item.denda));
						$('#total_bayar').val(ui.item.totalbayar);
						$('#id_pinj').val(ui.item.id_pinj);
						$('#jenis_pp').val(ui.item.jenis_pp);
						$('#tgl_pakai').val(ui.item.tgl_pakai);
						$('#tgl_cair').val(ui.item.tgl_cair);
						$('#alokasi').val(ui.item.alokasi);
						$('#jumpokok').val(ui.item.jumpokok);
						$('#checkbox1').removeAttr('disabled'); //enable input
						
						var id_pinj = $("#id_pinj").val();
						var total_bayar = $("#total_bayar").val();
						document.getElementById("totalbayar").value=tandaPemisahTitik(total_bayar);

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
				
			
			$('#checkbox1').click(function () {
					//check if checkbox is checked
					if ($(this).is(':checked')) {
						$('#SimpanAngsuranIndividu').removeAttr('disabled'); //enable input
					} else {
						$('#SimpanAngsuranIndividu').attr('disabled', true); //disable input
					}
				});
				
				
				
	
	});		
</script>

		<div class="row">
            <div class="col-md-12 col-md-offset hidden-print">
                <section class="widget" style="border: 1px solid #5d8fc2;">
                    <div class="widget-body">
						<div class="widget-top-overflow windget-padding-md clearfix bg-primary mb">
							<div class="row">
							<div class="col-md-5">
								<div class="form-group">
									<div class="input-group input-group-no-border mt">
									<span class="input-group-addon">
										<i class="glyphicon glyphicon-user"></i><i class="fa fa-search"></i>
									</span>
										<input class="form-control" id="individu" type="text" placeholder="Scan ID, atau ketik nama debitur...">
									</div>
								</div>
							</div>
							<div class="col-md-7">
								<span class="h4 fw-bold text-white pull-right mt">
								<span class="fw-normal">FORMULIR ANGSURAN</span> PINJAMAN ANGGOTA <i class="glyphicon glyphicon-th-large"></i> </span>
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
														<input type="text" name="pokok" id="pokok" class="form-control text-align-right" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),changeUnit(this.value);"
													required="required" autocomplete="off" placeholder="Pokok">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4 control-label" for="default-select">Jasa</label>
													<div class="col-sm-8">
														<input type="text" name="jasa" id="jasa" class="form-control text-align-right" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),changeUnit(this.value);"
													required="required" autocomplete="off" placeholder="Jasa">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4 control-label" for="default-select">Denda</label>
													<div class="col-sm-8">
														<input type="text" name="denda" id="denda" class="form-control text-align-right" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this),changeUnit(this.value);"
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
												
												
												<div class="checkbox checkbox-primary">
													<input id="checkbox1" type="checkbox" disabled>
														<label for="checkbox1" class="fs-mini">Saya telah menerima pembayaran ini</label>
												</div>
												
												<button class="btn btn-primary btn-rounded mt-sm btn-block btn-lg" id="SimpanAngsuranIndividu" disabled><i class="fa fa-paper-plane"></i> POSTING ANGSURAN</button>
											
												
												<script type="text/javascript">
												
												function changeUnit(id) {
													var pokok = document.getElementById("pokok").value.split('.').join('');
													var jasa = document.getElementById("jasa").value.split('.').join('');
													var denda = document.getElementById("denda").value.split('.').join('');
													var sumbayar= eval(pokok) + eval(jasa) + eval(denda);
														document.getElementById("totalbayar").value=tandaPemisahTitik(sumbayar);
												}
												</script>
								
											</fieldset>
									
										</div>
									</div>
								</section>
								
							</div>
							<div class="col-md-7">
								<div id="SuksesAngsur"></div>
								<div id="TampilIndividu"></div>
							</div>
						</div>
						
                    </div>
                </section>
            </div>
</div>