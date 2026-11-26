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
			<i class="fa fa-book"></i> DETAIL SIMPANAN [<?php echo $ids; ?>] <?php echo strtoupper($r['namadepan']);?>
			<ul class="tags pull-right">
				<li><a href="modul/pelaporan/pdf/s_PT.php?&ids=<?php echo $r['id'];?>" target="_blank"> <span class="fs-mini"><i class="glyphicon glyphicon-book"></i> Permohonan Tabungan</span></a></li>
				<li><a href="modul/pelaporan/pdf/RKU.php?&ids=<?php echo $r['id'];?>" target="_blank"> <span class="fs-mini"><i class="glyphicon glyphicon-print"></i> Generate to PDF</span></a></li>
				<li><a href="#" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i> Close</span></a></li>
			</ul>
		</h5>
	</div>

<div class="modal-body">
	<div class="col-md-3">
			<div id="SuksesSimpanan"></div>
			<div class="form-group">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="80%"><label class="fs-sm">Nomor Rekening</label><br>
						<span class="h4 fw-normal"><?php echo $r['nomor_rekening'];?></span>
					</td>
					<td><label class="fs-sm">CIF</label><br>
						<span class="h4 fw-normal"><?php echo $r['id'];?></span>
					</td>
				</tr>
				<tr>
					<td colspan="2"><label class="fs-sm"><br>Nama Debitur</label><br>
						<span class="h4 fw-bold"><?php echo strtoupper($r['namadepan']);?></span>
					</td>
				</tr>
				<tr>
					<td colspan="2"><label class="fs-sm"><br>Nomor Induk Kependudukan (NIK)</label><br>
						<span class="h4 fw-normal"><?php echo $r['nik'];?></span>
					</td>
				</tr>
			</table>
			</div>
			<br>
			<label class="">FROM TRANSAKSI SIMPANAN</label>
			<div class="form-group">
				<label class="fs-mini">Tanggal Transaksi</label>
				<input id="tgl_transaksi" type="text" value="<?php echo date('Y-m-d');?>" data-date-format="YYYY-MM-DD" class="form-control"
					required="required" autocomplete="off" placeholder="Tanggal Transaksi">
			</div>
			<div class="form-group">
				<label class="fs-sm">Jenis Mutasi</label>
				<div>
					<div class="col-xs-6">
						<div class="radio radio-success">
							<input type="radio" name="radio1" id="radio1" value="option1">
							<label for="radio1">Setor Tunai</label>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="radio radio-danger">
							<input type="radio" name="radio1" id="radio2" value="option2">
							<label for="radio2">Tarik Tunai</label>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="fs-mini">Jumlah (Rp.)</label>
				<input type="text" name="jumlah" id="jumlah" class="form-control input-lg" disabled onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"
					required="required" autocomplete="off" placeholder="Jumlah (Rp.)">
			</div>
			<div class="form-group">
				<input type="hidden" name="nia" id="nia" value="<?php echo $r['nia'];?>"/>
				<input type="hidden" name="id_simp_i" id="id_simp_i" value="<?php echo $r['id'];?>"/>
				<input type="hidden" name="saldo" id="saldo" value="<?php echo $saldoo;?>"/>
				<input type="hidden" name="jenis_mutasi" id="jenis_mutasi" value="" >
				
				<button type="button" class="btn btn-primary btn-block btn-lg"  id="SimpanSimpananUmum" disabled><span id="JenisMutasi"></span></button>
			</div>
	</div>
	<div class="col-md-9" style="overflow: scroll; height: 530px;">
		<div id="TampilDataSimpanan"></div>
	</div>
</div>
	<div class="modal-footer">
		<ul class="tags pull-right">
			<li><span class="h4 mr"><?php echo $ketsaldo;?></li>
			<li><span class="h4 mr-lg fw-semi-bold"><?php echo number_format($saldo);?></span></li>
			<li><a href="modul/pelaporan/pdf/BT.php?&idf=<?php echo $r['id'];?>" target="_blank"> <span class="fs-mini"><i class="glyphicon glyphicon-print"></i> Generate to PDF</span></a></li>
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
			$('#SimpanSimpananUmum').removeAttr('disabled'); //enable input
			$('#jenis_mutasi').val('setor');
			$('#JenisMutasi').html("SETOR TUNAI");
		}
	});
	
	$('#radio2').click(function () {
		if ($(this).is(':checked')) {
			$('#jumlah').removeAttr('disabled'); //enable input
			$('#jumlah').focus();
			$('#SimpanSimpananUmum').removeAttr('disabled'); //enable input
			$('#jenis_mutasi').val('tarik');
			$('#JenisMutasi').html("TARIK TUNAI");
		}
	});
	
	$("#SimpanSimpananUmum").click(function() {
		var tgl_transaksi		= $('#tgl_transaksi').val();
		var nia					= $('#nia').val();
		var id_simp_i			= $('#id_simp_i').val();
		var jenis_mutasi		= $('#jenis_mutasi').val();
		var jumlah				= $('#jumlah').val();
		var saldo				= $('#saldo').val();
		var jumtarik 			= document.getElementById("jumlah").value.split('.').join('');
		
		if(jumlah.length==0 || jumlah==0){ $("#jumlah").focus(); return false; }
		
		if(jenis_mutasi=="tarik" && +saldo < jumtarik){
			$("#SuksesSimpanan").load('modul/simpanan/dilarang_tarik.php'); $("#jumlah").focus(); return false;
				}
			
		var pilih = confirm('Anda akan '+jenis_mutasi+ ' sejumlah '+jumlah+ ' ?');
		if (pilih==true) {			
			$.ajax({
				type: "POST",
				url: "modul/simpanan/simpan_mutasi_simpanan.php",
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