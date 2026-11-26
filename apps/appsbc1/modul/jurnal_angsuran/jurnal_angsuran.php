<script type="text/javascript">

$("#kelompok").focus();
		
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
		
	$(document).ready(function() {
		
		$("#TampilKelompok").load('modul/jurnal_angsuran/tampil_kelompok.php');
		$("#SuksesAngsur").load('modul/jurnal_angsuran/petunjuk_angsuran.php');
					
			//simpan angsuran		
			$("#SimpanAngsuran").click(function() {
					var kelompok		= $('#kelompok').val();
                    var id_pinj			= $('#id_pinj').val();
                    var jenis_pp		= $('#jenis_pp').val();
                    var datetimepicker1	= $('#datetimepicker1').val();
                    var tgl_pakai		= $('#tgl_pakai').val();
                    var pokok			= $('#pokok').val();
                    var jasa			= $('#jasa').val();
                    var denda			= $('#denda').val();
                    var alokasi			= $('#alokasi').val();
                    var jumpokok		= $('#jumpokok').val();
                    var tgl_cair		= $('#tgl_cair').val();
					var zumpokok		= parseInt(jumpokok)+parseInt(pokok);
					
					if(datetimepicker1 < tgl_pakai){
						$("#SuksesAngsur").load('modul/jurnal_angsuran/dilarang_angsuran.php');
						document.getElementById("SimpanAngsuran").disabled = false;
						$("#datetimepicker1").focus();
						return false;
							}
							
					if(datetimepicker1 < tgl_cair){
						$("#SuksesAngsur").load('modul/jurnal_angsuran/dilarang_tanggal.php');
						document.getElementById("SimpanAngsuran").disabled = false;
						$("#datetimepicker1").focus();
						return false;
							}
					
					if(zumpokok > alokasi){
						$("#SuksesAngsur").load('modul/jurnal_angsuran/dilarang_pokok.php');
						document.getElementById("SimpanAngsuran").disabled = false;
						$("#pokok").focus();
						return false;
							}
							
					if(pokok==0 && jasa==0 && denda==0){
						$("#SuksesAngsur").load('modul/jurnal/dilarang.php');
						document.getElementById("SimpanAngsuran").disabled = false;
						$("#pokok").focus();
						return false;
							}
							
					if(kelompok==0){
						$("#SuksesAngsur").load('modul/jurnal/dilarang.php');
						document.getElementById("SimpanAngsuran").disabled = false;
						$("#kelompok").focus();
						return false;
							}
							
							
                    $.ajax({
                        type: "POST",
                        url: "modul/jurnal_angsuran/simpan_angsuran.php",
                        data: 	"id_pinj="+id_pinj+
								"&jenis_pp="+jenis_pp+
								"&datetimepicker1="+datetimepicker1+
								"&pokok="+pokok+
								"&jasa="+jasa+
								"&denda="+denda,
								
						success: function(data) {
							$("#SuksesAngsur").load('modul/jurnal_angsuran/sukses_angsuran.php');
							$("#TampilBuku").load('modul/jurnal_angsuran/tampil_buku_angsuran.php');
							$("#TampilKelompok").load('modul/jurnal_angsuran/tampil_kelompok.php');
							document.getElementById("SimpanAngsuran").disabled = true;
							$("#kelompok").focus();
							return false;
							
                        }
                    });

                });
				
				
				$("#kelompok").autocomplete({
					source: "modul/jurnal_angsuran/search_kelompok.php",
					minLength:3,
					select:function(event, ui){
						$('#kelompok').val(ui.item.kelompok);
						$('#idpinj').val(ui.item.idpinj);
						$('#pokok').val(ui.item.pokok);
						$('#jasa').val(ui.item.jasa);
						$('#denda').val(ui.item.denda);
						$('#total_bayar').val(ui.item.totalbayar);
						$('#id_pinj').val(ui.item.id_pinj);
						$('#jenis_pp').val(ui.item.jenis_pp);
						$('#tgl_pakai').val(ui.item.tgl_pakai);
						$('#tgl_cair').val(ui.item.tgl_cair);
						$('#alokasi').val(ui.item.alokasi);
						$('#jumpokok').val(ui.item.jumpokok);
						
						var id_pinj = $("#id_pinj").val();
						var total_bayar = $("#total_bayar").val();
						document.getElementById("totalbayar").value=tandaPemisahTitik(total_bayar);
						document.getElementById("SimpanAngsuran").disabled = false;

						$.ajax({
							type	: "POST",
							url		: "modul/jurnal_angsuran/tampil_kelompok.php",
							data	: "kelompok="+id_pinj,
							success	: function(data){
								$("#TampilKelompok").html(data);
								$("#TampilBuku").load('modul/jurnal_angsuran/tampil_buku_angsuran.php');
								$("#SuksesAngsur").load('modul/jurnal_angsuran/petunjuk_angsuran.php');
							}
						});
						
						
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
										<i class="fa fa-search"></i>
									</span>
										<input class="form-control" id="kelompok" type="text" placeholder="Scan ID, ketik nama kelompok, nama desa atau nama ketuanya...">
									</div>
								</div>
							</div>
							<div class="col-md-7">
								<span class="h4 fw-bold text-white pull-right mt">
								<span class="fw-normal">FORMULIR ANGSURAN</span> PINJAMAN KELOMPOK <i class="glyphicon glyphicon-th-large"></i> </span>
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
												
												<div>
													<a class="badge bg-primary" data-toggle="collapse" data-parent="#accordionAnggota" href="#collapseAnggota" ><i class="fa fa-user"></i> Tampilkan angsuran Anggota</a>
												</div>
												<div class="panel-group mb-lg" id="accordionAnggota" data-toggle="collapse">
													<div class="panel panel-default">
														<div id="collapseAnggota" class="panel-collapse collapse">
															<div class="panel-body">
																<table>
																		<tr>
																			<td class="col-sm-4"><i class="glyphicon glyphicon-user"></i></td>
																			<td class="col-sm-3"><h6 class="ml-n-lg mr-n-lg">Pokok</h6></td>
																			<td class="col-sm-3"><h6 class="ml-n-lg mr-n-lg">Jasa</h6></td>
																			<td class="col-sm-2"><h6 class="ml-n-lg mr-n-lg">Jumlah</h6></td>
																		</tr>
																	<?php
																	$data=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE a.id=pa.nia AND pa.id_pinkel='$r[id]'");
																		while($pa=mysql_fetch_array($data)){
																		$alokasia		=$pa['alokasi'];
																		$jangkaa			=$pa['jangka'];
																		$sistem_angsuran=$pa['sistem_angsuran'];
																		$pros_jasaa		=$pa['pros_jasa'];
																		
																		$tempoa=$jangkaa/$sistem_angsuran;
																		
																		$angspokok=$alokasia/$tempoa;
																		$angsjasa=($alokasia*$pros_jasaa)/100;
																		$angsapokok=bulatkan($angspokok);
																		
																	?>
																				<tr>
																				<td class="col-sm-3"><h6 class="ml-n-lg mr-n-lg"><?php echo $pa['namadepan'];?></h6></td>
																				<td><input value="<?php echo $angsapokok;?>" type="text" name="pokoka" id="pokoka" class="form-control input-sm  ml-n-lg text-align-right" required="required" autocomplete="off" placeholder="Pokok"></td>
																				<td><input value="<?php echo $angsjasa;?>" onkeyup="kalkulatorTambah(getElementById('pokoka').value,this.value);" type="text" name="jasaa" id="jasaa" class="form-control input-sm ml-n-lg text-align-right" required="required" autocomplete="off" placeholder="Jasa"></td>
																				<td><h6 class="text-align-right"><?php echo number_format($angsapokok+$angsjasa);?></h6></td>
																				</tr>
																	<?php
																	}
																	?>
																</table>
															</div>
														</div>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-4 control-label" for="default-select">Pokok</label>
													<div class="col-sm-8">
														<input onchange="changeKolom(this.value)" type="text" name="pokok" id="pokok" class="form-control text-align-right" 
													required="required" autocomplete="off" placeholder="Pokok">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4 control-label" for="default-select">Jasa</label>
													<div class="col-sm-8">
														<input onchange="changeKolom(this.value)" type="text" name="jasa" id="jasa" class="form-control text-align-right" 
													required="required" autocomplete="off" placeholder="Jasa">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4 control-label" for="default-select">Denda</label>
													<div class="col-sm-8">
														<input onchange="changeKolom(this.value)" type="text" name="denda" id="denda" class="form-control text-align-right" 
													required="required" autocomplete="off" placeholder="Denda">
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-4 control-label fw-semi-bold" for="default-select">Total Bayar </label>
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
												<button class="btn btn-inverse btn-rounded mt-sm btn-block btn-lg" id="SimpanAngsuran"><i class="fa fa-paper-plane"></i> POSTING ANGSURAN</button>
												
												<script type="text/javascript">  
		
												function changeKolom(id) {
													var pokok = document.getElementById("pokok").value;
													var jasa = document.getElementById("jasa").value;
													var denda = document.getElementById("denda").value;
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
								<div id="TampilKelompok"></div>
							</div>
						</div>
						
                    </div>
                </section>
            </div>
</div>