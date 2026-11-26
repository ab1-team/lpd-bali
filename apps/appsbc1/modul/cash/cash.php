<?php session_start(); 
include "inc/fungsi_keuangan.php";

$tgl_kondisi	=date('Y-m-d');
$saldo=saldoR("$tgl_kondisi-1-10001");
?> 
    
		
		<div class="row">
			<div class="col-md-12">
				<section class="widget">
						<div class="widget-top-overflow windget-padding-md clearfix bg-primary mb">
							<div class="row">
							<div class="col-md-12">
								<span class="h4 fw-bold text-white"><i class="glyphicon glyphicon-th-large"></i> CASH </span>OPNAME 
								<span class="pull-right"><input id="tanggal" type="text" value="<?php echo date('Y-m-d');?>" data-date-format="YYYY-MM-DD" class="form-control input-sm" /></span>
							</div>
							</div>
						</div>
					<div class="widget-body" style="overflow: scroll; height:400px;">
						<div class="table-responsive">
							<table class="table table-hover">
								<tbody>
									<tr>
										<td width="15%" class='bg-primary'>Uang Kertas (Rp.)</td>
										<td width="15%">Jumlah (Lembar)</td>
										<td width="15%">Total (Rp.)</td>
										<td width="55%">Catatan :</td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">100.000</td>
										<td><input type="text" name="k100K" id="k100K" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 100.000 --"></td>
										<td><input type="text" name="sumk100K" id="sumk100K" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="notek100K" id="notek100K" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">50.000</td>
										<td><input type="text" name="k50K" id="k50K" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 50.000 --"></td>
										<td><input type="text" name="sumk50K" id="sumk50K" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="notek50K" id="notek50K" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">20.000</td>
										<td><input type="text" name="k20K" id="k20K" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 20.000 --"></td>
										<td><input type="text" name="sumk20K" id="sumk20K" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="notek20K" id="notek20K" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">10.000</td>
										<td><input type="text" name="k10K" id="k10K" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 10.000 --"></td>
										<td><input type="text" name="sumk10K" id="sumk10K" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="notek10K" id="notek10K" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">5.000</td>
										<td><input type="text" name="k5K" id="k5K" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 5.000 --"></td>
										<td><input type="text" name="sumk5K" id="sumk5K" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="notek5K" id="notek5K" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">2.000</td>
										<td><input type="text" name="k2K" id="k2K" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 2.000 --"></td>
										<td><input type="text" name="sumk2K" id="sumk2K" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="notek2K" id="notek2K" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">1.000</td>
										<td><input type="text" name="k1K" id="k1K" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 1.000 --"></td>
										<td><input type="text" name="sumk1K" id="sumk1K" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="notek1K" id="notek1K" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">500</td>
										<td><input type="text" name="k500" id="k500" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 500 --"></td>
										<td><input type="text" name="sumk500" id="sumk500" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="notek500" id="notek500" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">100</td>
										<td><input type="text" name="k100" id="k100" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 100 --"></td>
										<td><input type="text" name="sumk100" id="sumk100" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="notek100" id="notek100" class="form-control input-sm"></td>
									</tr>
									
									<tr>
										<td width="15%" class='bg-primary'>Uang Logam (Rp.)</td>
										<td width="15%">Jumlah (Keping)</td>
										<td width="15%">Total (Rp.)</td>
										<td width="55%">Catatan :</td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">1.000</td>
										<td><input type="text" name="L1K" id="L1K" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 1.000 --"></td>
										<td><input type="text" name="sumL1K" id="sumL1K" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="noteL1K" id="noteL1K" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">500</td>
										<td><input type="text" name="L500" id="L500" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 500 --"></td>
										<td><input type="text" name="sumL500" id="sumL500" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="noteL500" id="noteL500" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">200</td>
										<td><input type="text" name="L200" id="L200" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 200 --"></td>
										<td><input type="text" name="sumL200" id="sumL200" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="noteL200" id="noteL200" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">100</td>
										<td><input type="text" name="L100" id="L100" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 100 --"></td>
										<td><input type="text" name="sumL100" id="sumL100" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="noteL100" id="noteL100" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">50</td>
										<td><input type="text" name="L50" id="L50" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 50 --"></td>
										<td><input type="text" name="sumL50" id="sumL50" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="noteL50" id="noteL50" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">25</td>
										<td><input type="text" name="L25" id="L25" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 25 --"></td>
										<td><input type="text" name="sumL25" id="sumL25" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="noteL25" id="noteL25" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">5</td>
										<td><input type="text" name="L5" id="L5" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 5 --"></td>
										<td><input type="text" name="sumL5" id="sumL5" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="noteL5" id="noteL5" class="form-control input-sm"></td>
									</tr>
									<tr>
										<td class="fw-bold text-align-right">1</td>
										<td><input type="text" name="L1" id="L1" class="form-control input-sm" onkeyup="changeKolom(this.value)" placeholder="-- 1 --"></td>
										<td><input type="text" name="sumL1" id="sumL1" class="form-control input-sm text-align-right" disabled="disabled" ></td>
										<td><input type="text" name="noteL1" id="noteL1" class="form-control input-sm"></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="widget-footer-overflow windget-padding-md clearfix bg-primary">
							<div class="row">
							<div class="col-md-3">
								TOTAL NERACA PERCOBAAN : <span class="h4 text-white fw-bold "><br><?php echo number_format($saldo,0,',','.'); ?></span> 
							</div>
							<div class="col-md-3">
								TOTAL CASH OPNAME : <span class="h4 text-white fw-bold "><div id="total"></div></span> 
							</div>
							<div class="col-md-3">
								<div id="Notifikasi"></div>
							</div>
							<div class="col-md-3">
								<button class="btn btn-default btn-lg width-300" id="SimpanCashOpname">SIMPAN CASH OPNAME</button>
							</div>
							</div>
						</div>
				</section>
			</div>
	
</div>


<script type="text/javascript"> 

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

				
				function changeKolom(id) {
					var k100K = $("#k100K").val(); var sumk100K= k100K * 100000; document.getElementById("sumk100K").value=tandaPemisahTitik(sumk100K);
					var k50K = $("#k50K").val(); var sumk50K= k50K * 50000; document.getElementById("sumk50K").value=tandaPemisahTitik(sumk50K);
					var k20K = $("#k20K").val(); var sumk20K= k20K * 20000; document.getElementById("sumk20K").value=tandaPemisahTitik(sumk20K);
					var k10K = $("#k10K").val(); var sumk10K= k10K * 10000; document.getElementById("sumk10K").value=tandaPemisahTitik(sumk10K);
					var k5K = $("#k5K").val(); var sumk5K= k5K * 5000; document.getElementById("sumk5K").value=tandaPemisahTitik(sumk5K);
					var k2K = $("#k2K").val(); var sumk2K= k2K * 2000; document.getElementById("sumk2K").value=tandaPemisahTitik(sumk2K);
					var k1K = $("#k1K").val(); var sumk1K= k1K * 1000; document.getElementById("sumk1K").value=tandaPemisahTitik(sumk1K);
					var k500 = $("#k500").val(); var sumk500= k500 * 500; document.getElementById("sumk500").value=tandaPemisahTitik(sumk500);
					var k100 = $("#k100").val(); var sumk100= k100 * 100; document.getElementById("sumk100").value=tandaPemisahTitik(sumk100);
					
					var L1K = $("#L1K").val(); var sumL1K= L1K * 1000; document.getElementById("sumL1K").value=tandaPemisahTitik(sumL1K);
					var L500 = $("#L500").val(); var sumL500= L500 * 500; document.getElementById("sumL500").value=tandaPemisahTitik(sumL500);
					var L200 = $("#L200").val(); var sumL200= L200 * 200; document.getElementById("sumL200").value=tandaPemisahTitik(sumL200);
					var L100 = $("#L100").val(); var sumL100= L100 * 100; document.getElementById("sumL100").value=tandaPemisahTitik(sumL100);
					var L50 = $("#L50").val(); var sumL50= L50 * 50; document.getElementById("sumL50").value=tandaPemisahTitik(sumL50);
					var L25 = $("#L25").val(); var sumL25= L25 * 25; document.getElementById("sumL25").value=tandaPemisahTitik(sumL25);
					var L5 = $("#L5").val(); var sumL5= L5 * 5; document.getElementById("sumL5").value=tandaPemisahTitik(sumL5);
					var L1 = $("#L1").val(); var sumL1= L1 * 1; document.getElementById("sumL1").value=tandaPemisahTitik(sumL1);
					
					var total= eval(sumk100K) + eval(sumk50K) + eval(sumk20K) + eval(sumk10K) + eval(sumk5K) + eval(sumk2K) + eval(sumk1K) + eval(sumk500) + eval(sumk100) + eval(sumL1K) + eval(sumL500) + eval(sumL200) + eval(sumL100) + eval(sumL50) + eval(sumL25) + eval(sumL5) + eval(sumL1);
						document.getElementById("total").innerHTML=tandaPemisahTitik(total);
				}
				
				
$(document).ready(function() {
	
	$("#SimpanCashOpname").click(function() {
		var tanggal = $("#tanggal").val();
		var k100K = $("#k100K").val();
		var k50K = $("#k50K").val();
		var k20K = $("#k20K").val();
		var k10K = $("#k10K").val();
		var k5K = $("#k5K").val();
		var k2K = $("#k2K").val();
		var k1K = $("#k1K").val();
		var k500 = $("#k500").val();
		var k100 = $("#k100").val();
							
		var L1K = $("#L1K").val();
		var L500 = $("#L500").val();
		var L200 = $("#L200").val();
		var L100 = $("#L100").val();
		var L50 = $("#L50").val();
		var L25 = $("#L25").val();
		var L5 = $("#L5").val();
		var L1 = $("#L1").val();
				
			$.ajax({
				type: "POST",
				url: "modul/cash/simpan_cash.php",
				data: 	"tanggal="+tanggal+
						"&k100K="+k100K+
						"&k50K="+k50K+
						"&k20K="+k20K+
						"&k10K="+k10K+
						"&k5K="+k5K+
						"&k2K="+k2K+
						"&k1K="+k1K+
						"&k500="+k500+
						"&k100="+k100+
						"&L1K="+L1K+
						"&L500="+L500+
						"&L200="+L200+
						"&L100="+L100+
						"&L50="+L50+
						"&L25="+L25+
						"&L5="+L5+
						"&L1="+L1,
				success: function(data) {
					$("#Notifikasi").html('<a href="modul/pelaporan/pdf/CN.php" target="_blank"  class="btn btn-default btn-lg width-300"><i class="glyphicon glyphicon-print"></i> Cetak Cash Opname</a>');
				}
			});
		
	});	

});
				
				
</script>