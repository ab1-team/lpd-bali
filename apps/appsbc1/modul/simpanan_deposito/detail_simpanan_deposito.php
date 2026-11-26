<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_simpanan_individu.php";

ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table_transaksi="transaksi_$_SESSION[lokasi]";
$table_rekening="rekening_$_SESSION[lokasi]";

$ids			=$_POST['ids'];
$_SESSION['ids']=$ids; //Dikirim ke modul/simpanan/tampil_data_simpanan_individu

$r		=mysql_fetch_array(mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, simpanan_anggota_$_SESSION[kd_kab] si WHERE a.id=si.nia AND si.id='$ids' "));


	$tgl_kondisi=date('Y-m-d');
			$saldoo=saldosimpanan("$tgl_kondisi-$ids");
									if($saldoo>0) {
									$saldo=$saldoo;
									$ketsaldo="Saldo Kredit";
									}elseif($saldoo<0){
									$saldo=$saldoo*-1;
									$ketsaldo="Saldo Debet";
									}
?>
<head>
	<script>
		$(document).ready(function(){
		  $(".preloader").fadeOut("slow");
		})
	</script>
</head>
<div class="preloader">
	<div class="loading">
		<img src="images/animation.gif" width="280">
	</div>
</div>


<div class="modal-content">
	<div class="modal-header bg-primary">
		<h5 class="modal-title fw-bold" id="LabelDetailSimpananIndividu">
			<i class="fa fa-book"></i> DETAIL SIMPANAN DEPOSITO [<?php echo $ids; ?>] <?php echo strtoupper($r['namadepan']);?>
				<ul class="tags pull-right">
				<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/c_sertifikat_1.php?&ids=<?php echo $r['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" > <span class="fs-mini"><i class="glyphicon glyphicon-print"></i> Sert. ASLI Hal-1</span></a></li>
				<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/c_sertifikat_hal_2.php?&ids=<?php echo $r['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" > <span class="fs-mini"><i class="glyphicon glyphicon-print"></i> Sert. ASLI Hal-2</span></a></li>
				<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/c_sertifikat_2.php?&ids=<?php echo $r['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" > <span class="fs-mini"><i class="glyphicon glyphicon-print"></i> Sert. COPY Hal-1</span></a></li>
				<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/c_sertifikat_hal_copy_2.php?&ids=<?php echo $r['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" > <span class="fs-mini"><i class="glyphicon glyphicon-print"></i> Sert. COPY Hal-2</span></a></li>
				<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/RKD.php?&ids=<?php echo $r['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" > <span class="fs-mini"><i class="glyphicon glyphicon-print"></i> Rekening Koran</span></a></li>
				<li><a href="#" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i> Close</span></a></li>
			</ul>
		</h5>
	</div>

<div class="modal-body" style="overflow: scroll; height: 530px;">
	<div class="col-md-3" style="background-color:#f8f8f8;">
	
	<div id="SuksesSimpanan"></div>
	
			<div class="form-group mt-sm">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="50%"><label class="fs-sm">Nomor Rekening</label><br>
						<span class="h4 fw-normal"><?php echo $r['nomor_rekening'];?></span>
					</td>
					<td width="20%" class="text-align-center"><label class="fs-sm">CIF</label><br>
						<span class="h4 fw-normal"><?php echo $r['id'];?></span>
					</td>
					<td width="15%" class="text-align-center"><label class="fs-sm">JW</label><br>
						<span class="h4 fw-normal"><?php echo "$r[jangka]";?></span>
					</td>
					<td width="15%" class="text-align-center"><label class="fs-sm">BG</label><br>
						<span class="h4 fw-normal"><?php echo "$r[pros_jasa]";?><span class="fs-mini">%</span></span>
					</td>
				</tr>
				<tr>
					<td colspan="4"><label class="fs-sm"><br>Nama Kreditur</label><br>
						<span class="h4 fw-normal"><?php echo strtoupper($r['namadepan']);?></span>
					</td>
				</tr>
			</table>
			</div>

			<div class="form-group">
				<label class="fs-mini">Tanggal Transaksi</label>
				<input id="tgl_transaksi" type="text" value="<?php echo date('Y-m-d');?>" data-date-format="YYYY-MM-DD" class="form-control"
					required="required" autocomplete="off" placeholder="Tanggal Transaksi">
			</div>
			<div class="form-group">
				<label class="fs-sm">Jenis Transaksi</label>
						<div class="radio radio-success">
							<input type="radio" name="radio1" id="radio1" value="option1">
							<label for="radio1">Penambahan Setoran</label>
						</div>
						<div class="radio radio-danger">
							<input type="radio" name="radio1" id="radio2" value="option2">
							<label for="radio2">Penarikan Deposito</label>
						</div>
						<div class="radio radio-primary">
							<input type="radio" name="radio1" id="radio3" value="option3">
							<label for="radio3">Perpanjangan</label>
						</div>
			</div>
			<div class="form-group mt-n-md">
				<label class="fs-mini"><span id="Judul"></span></label>
				<input type="text" name="jumlah" id="jumlah" class="form-control input-lg" disabled onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
					required="required" autocomplete="off" placeholder="Jumlah">
			</div>
			<div class="form-group">
				<input type="hidden" name="nia" id="nia" value="<?php echo $r['nia'];?>"/>
				<input type="hidden" name="id_simp_i" id="id_simp_i" value="<?php echo $r['id'];?>"/>
				<input type="hidden" name="saldo" id="saldo" value="<?php echo $saldo;?>"/>
				<input type="hidden" name="jenis_mutasi" id="jenis_mutasi" value="" >
				
				<button type="button" class="btn btn-primary btn-block btn-lg"  id="SimpanSimpananDeposito" disabled>SIMPAN <span id="JenisMutasi"></span></button>
			</div>
	</div>
	<div class="col-md-9">
		<div id="TampilDataSimpanan"></div>
	</div>
</div>
	<div class="modal-footer bg-primary">
		<ul class="tags pull-right">
			<li><span class="h4 mr"><?php echo $ketsaldo;?></li>
			<li><span class="h4 mr-lg fw-semi-bold"><?php echo number_format($saldo);?></li>
			<li><a href="#" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i> Close</span></a></li>
		</ul>
	</div>
</div>

<script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
		
	function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
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
				}else if (e.keyCode==8 || e.keycode==46){
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
		
$("#TampilDataSimpanan").load('modul/simpanan/tampil_data_simpanan_individu.php');

	$('#radio1').click(function () {
					//check if checkbox is checked
		if ($(this).is(':checked')) {
			$('#jumlah').removeAttr('disabled'); //enable input
			$('#jumlah').focus();
			$('#SimpanSimpananDeposito').removeAttr('disabled'); //enable input
			$('#jumlah').val('');
			$('#jenis_mutasi').val('setor');
			$('#JenisMutasi').html("SETORAN");
			$('#Judul').html("Jumlah Setoran (Rp.)");
		}
	});
	
	$('#radio2').click(function () {
		if ($(this).is(':checked')) {
			$('#jumlah').removeAttr('disabled'); //enable input
			$('#jumlah').focus();
			$('#SimpanSimpananDeposito').removeAttr('disabled'); //enable input
			$('#jumlah').val('<?php echo number_format($saldo,0,",",".");?>');
			$('#jenis_mutasi').val('tarik');
			$('#JenisMutasi').html("PENARIKAN");
			$('#Judul').html("Jumlah Penarikan (Rp.)");
		}
	});
	
	$('#radio3').click(function () {
					//check if checkbox is checked
		if ($(this).is(':checked')) {
			$('#jumlah').removeAttr('disabled'); //enable input
			$('#jumlah').focus();
			$('#SimpanSimpananDeposito').removeAttr('disabled'); //enable input
			$('#jumlah').val('1');
			$('#jenis_mutasi').val('perpanjangan');
			$('#JenisMutasi').html("PERPANJANGAN");
			$('#Judul').html("Penambahan Perpanjangan (Bulan)");
		}
	});
	
	$("#SimpanSimpananDeposito").click(function() {
		var tgl_transaksi		= $('#tgl_transaksi').val();
		var nia					= $('#nia').val();
		var id_simp_i			= $('#id_simp_i').val();
		var jenis_mutasi		= $('#jenis_mutasi').val();
		var jumlah				= $('#jumlah').val();
		var saldo				= $('#saldo').val();
		var jumtarik 			= document.getElementById("jumlah").value.split('.').join('');
		
		if(jumlah.length==0){ $("#jumlah").focus(); return false; }
		
		if(jenis_mutasi=="tarik" && +saldo < jumtarik){
			$("#SuksesSimpanan").load('modul/simpanan/dilarang_tarik.php'); $("#jumlah").focus(); return false;
				}
			
		var pilih = confirm('Anda akan '+jenis_mutasi+ ' sejumlah '+jumtarik+ '?');
		if (pilih==true) {			
			$.ajax({
				type: "POST",
				url: "modul/simpanan_deposito/simpan_mutasi_simpanan_deposito.php",
				data: 	"id_simp_i="+id_simp_i+
						"&tgl_transaksi="+tgl_transaksi+
						"&nia="+nia+
						"&jenis_mutasi="+jenis_mutasi+
						"&jumlah="+jumlah,
				success: function(data) {
					$("#SuksesSimpanan").load('modul/simpanan/sukses_simpanan_individu.php');
					$("#TampilDataSimpanan").load('modul/simpanan/tampil_data_simpanan_individu.php');
				}
			});
		}
	});	

});
	
</script>