<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_simpanan_individu.php";
include "inc/fungsi_indotgl.php";

ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$tgl_now =  date('Y-m-d');
$tgl_kondisi_lalu = date('Y-m-d', strtotime('-1 month', strtotime($tgl_now))); //
$bulan_kondisi = date('Y-m-01', strtotime('-1 month', strtotime($tgl_now))); //
$tgl_awal = date('Y-m-01', strtotime('-1 month', strtotime($tgl_now))); //
$tgl_akhir = date('Y-m-t', strtotime('-1 month', strtotime($tgl_now))); //
$tahun = substr($tgl_awal,0,4);
$bulan = substr($tgl_awal,5,2);

$tgl_kondisi=$tgl_akhir;
			
$kec=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));

//Ketentuan Pemberian Bunga :
//1. Jika usia tabungan minimal 1 periode
//2. Bunga yang dihitung adalah saldo terendah di periode berikutnya
?>
<head>
    
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
				
</script>
<div class="modal-content">
	<div class="modal-header bg-primary">
		<h5 class="modal-title fw-normal" id="LabelHitungBungaSimpananUmum">
			<i class="fa fa-book"></i> PERHITUNGAN BUNGA SIMPANAN UMUM BULAN <?php echo strtoupper(bln_indo("$bulan_kondisi"))." "; echo $tahun;
			echo " <strong>(PERIODE ".tgl_ind($tgl_awal)." s.d. ".tgl_ind($tgl_akhir).") </strong>";
			?>
			<ul class="tags pull-right">
				<li><a  href="javascript:window.open('','_self').close();" onclick="window.open('', '_self', ''); window.close();" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i> Close</span></a></li>
			</ul>
		</h5>
	</div>

<div class="modal-body" style="overflow: scroll; height: 500px;">				
	
                <div class="table-responsive fs-mini">
						<table id="" class="table table-hover">
							<thead class="bg-primary text-white">
								<tr>
									<th width="1%">#</th>
									<th width="2%">CIF</th>
									<th width="5%">NOREK</th>
									<th width="21%" class="hidden-xs">Nama Kreditur</th>
									<th width="4%" class="hidden-xs">Tgl Buka</th>
									<th width="10%" class="hidden-xs">Saldo Akhir</th>
									<th width="10%" class="hidden-xs">Sld Rata-Rata</th>
									<th class="hidden-xs">Bunga</th>
									<th class="hidden-xs">Pajak</th>
									<th class="hidden-xs">Admin</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
							<?php
						include "../../inc/inc.koneksi.php";
						include "../../inc/fungsi_simpanan_individu.php";
						$view=mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, status_simpanan ss, simpanan_anggota_$_SESSION[kd_kab] si
																WHERE
																a.id=si.nia AND ss.kd_status=si.status AND si.lokasi='$_SESSION[lokasi]' AND si.jenis_simpanan='1' AND si.tgl_buka<='$tgl_akhir'
																AND si.status='A' AND si.id>1000 order by si.nomor_rekening asc");  //Akan mendapat bunga jika nabungnya mulai bulan lalu
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$idsimp			=$row['id'];
								$sumnabung		=sumnabung("$tgl_now-$idsimp");
								$sumambil		=sumambil("$tgl_now-$idsimp");
								$saldosimpanan	=saldosimpananb("$tgl_now-$idsimp");
								$saldoratarata	=saldoratarata("$tgl_now-$idsimp");
								if($kec['min_bunga']<=$saldosimpanan){
								$bungasimpananumum	= $saldoratarata*$row['bunga']/100;
								}
								if($kec['min_pajak']<=$saldosimpanan){
								$pajaksimpananumum	= $bungasimpananumum*$row['pajak']/100;
								}
								$adminsimpananumum =$row['admin'];
								
								$cari=mysql_num_rows(mysql_query("select * from transaksi_$_SESSION[lokasi] where rekening_debit='221.03' AND id_simp_i='$idsimp'  AND tgl_transaksi>='$tgl_awal' AND tgl_transaksi<='$tgl_akhir' "));
								
								if($cari>0) {$status="P A I D"; $warna_status="success"; $disabled="disabled";}else{$status="UNPAID"; $warna_status="danger"; $disabled="";}
								
								if($row['tgl_buka']>$tgl_awal OR $saldoratarata<=0) {$def_jasa_tabungan="0.0"; $warna="danger";}else{$def_jasa_tabungan	=$kec['def_jasa_tabungan']; $warna="success";}
									?>
									
						<tr class="fw-normal">
							<td><span class="toggle badge bg-default"><?php echo $no;?></span></td>
							<td class="subject hidden-xs"><?php echo $row['id'];?></td>
							<td class="subject hidden-xs"><?php echo $row['nomor_rekening'];?></td>
							<td class="name hidden-xs"><?php echo strtoupper($row['namadepan']);?></td>
							<td class="name hidden-xs"><?php echo tgl_ind($row['tgl_buka']);?></td>
							<td class="name hidden-xs text-align-right"><?php echo number_format($saldosimpanan,0,",",".");?></td>
							<td class="name hidden-xs text-align-right"><?php echo number_format($saldoratarata,0,",",".");?></td>
							<td class="name hidden-xs text-align-right">
								<div class="input-group">
									<input type="hidden" name="id_simp_i<?php echo $idsimp;?>" id="id_simp_i<?php echo $idsimp;?>" value="<?php echo $idsimp;?>" />
									<input type="hidden" name="tgl_awal<?php echo $idsimp;?>" id="tgl_awal<?php echo $idsimp;?>" value="<?php echo $tgl_awal;?>" />
									<input type="hidden" name="tgl_akhir<?php echo $idsimp;?>" id="tgl_akhir<?php echo $idsimp;?>" value="<?php echo $tgl_akhir;?>" />
                                    <input type="text" name="bungasimpananumum<?php echo $idsimp;?>" id="bungasimpananumum<?php echo $idsimp;?>" value="<?php echo number_format($bungasimpananumum,0,",",".");?>" class="form-control input-sm text-align-right"
									<?php echo $disabled;?> required="required" autocomplete="off" placeholder="Bunga Simpanan Umum" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"/>
								</div>
							</td>
							<td class="name hidden-xs text-align-right">
								<div class="input-group">
									<input type="text" name="pajaksimpananumum<?php echo $idsimp;?>" id="pajaksimpananumum<?php echo $idsimp;?>" value="<?php echo number_format($pajaksimpananumum,0,",",".");?>" class="form-control input-sm text-align-right"
									<?php echo $disabled;?> required="required" autocomplete="off" placeholder="Pajak Simpanan Umum" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"/>
								</div>
							</td>
							<td class="name hidden-xs text-align-right">
								<div class="input-group">
									<input type="text" name="adminsimpananumum<?php echo $idsimp;?>" id="adminsimpananumum<?php echo $idsimp;?>" value="<?php echo number_format($adminsimpananumum,0,",",".");?>" class="form-control input-sm text-align-right"
									<?php echo $disabled;?> required="required" autocomplete="off" placeholder="Admin Simpanan Umum" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"/>
								</div>
							</td>
							<td class="text-align-center"><span class="label label-<?php echo $warna_status;?>"><?php echo $status;?></span></td>
                        </tr>
						
<script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>						
<script type="text/javascript">

$(document).ready(function() {

$("#SimpanBayarBunga").click(function() {
                    var id_simp_i			= $('#id_simp_i<?php echo $idsimp;?>').val();
                    var bungasimpananumum	= $('#bungasimpananumum<?php echo $idsimp;?>').val();
                    var pajaksimpananumum	= $('#pajaksimpananumum<?php echo $idsimp;?>').val();
                    var adminsimpananumum	= $('#adminsimpananumum<?php echo $idsimp;?>').val();
                    var tgl_awal			= $('#tgl_awal<?php echo $idsimp;?>').val();
                    var tgl_akhir			= $('#tgl_akhir<?php echo $idsimp;?>').val();
					
								
                    $.ajax({
                        type: "POST",
                        url: "modul/simpanan/simpan_bunga_umum.php",
                        data: 	"id_simp_i="+id_simp_i+
								"&bungasimpananumum="+bungasimpananumum+
								"&pajaksimpananumum="+pajaksimpananumum+
								"&adminsimpananumum="+adminsimpananumum+
								"&tgl_awal="+tgl_awal+
								"&tgl_akhir="+tgl_akhir,
								
						success: function(data) {
                           $("#SimpanBayarBunga").load('modul/simpanan/sukses_data.php');
						   document.getElementById("SimpanBayarBunga").disabled = true;

                        }

                    });

                });

});
</script>								
								<?php 
								$sumbunga+=$bungasimpananumum;
								$sumpajak+=$pajaksimpananumum;
								$sumadmin+=$adminsimpananumum;
								
								} ?>
								
							</tbody>
						</table>
					</div>
         

	</div>
	<div class="modal-footer" style="background-color:#eeeeee;">
		<div class="col-sm-3">
			<div class="input-group">
				<label class="control-label fs-sm col-md-5">Total Bunga</label>
				<div class="col-md-7">
					<input type="text" name="total_bunga" id="total_bunga" value="<?php echo number_format($sumbunga);?>" disabled
					class="form-control fw-bold text-align-right"/>
				</div>
			</div>
			<div class="input-group">
				<label class="control-label fs-sm col-md-5">Total Pajak</label>
				<div class="col-md-7">
					<input type="text" name="total_pajak" id="total_pajak" value="<?php echo number_format($sumpajak);?>" disabled
					class="form-control fw-bold text-align-right"/>
				</div>
			</div>
			<div class="input-group">
				<label class="control-label fs-sm col-md-5">Total Admin</label>
				<div class="col-md-7">
					<input type="text" name="total_admin" id="total_admin" value="<?php echo number_format($sumadmin);?>" disabled
					class="form-control fw-bold text-align-right"/>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="input-group">
				<label class="control-label fs-sm col-md-5">Dibukukan pada Tanggal</label>
				<div class="col-md-7">
					<input type="text" name="tgl_transaksi" id="tgl_transaksi" value="<?php echo $tgl_akhir;?>" disabled 
					class="form-control" required="required" autocomplete="off" placeholder="Dibukukan Tanggal"/>
				</div>
			</div>
		</div>
		<a href=modul/simpanan/cs/cek_saldo.php>aaa</a>
		<div class="col-sm-3">
			<div class="checkbox checkbox-primary">
				<input id="checkbox1" type="checkbox">
				<label for="checkbox1">Saya setuju atas pembayaran ini</label>
			</div>
		</div>
		<div class="col-sm-3">
			<button class="btn btn-primary btn-block btn-lg" id="SimpanBayarBunga" disabled>
				<i class="fa fa-paper-plane"></i> POSTING PEMBAYARAN <br> BUNGA
			</button>												
		</div>										
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
				
				
$('#checkbox1').click(function () {
					//check if checkbox is checked
					if ($(this).is(':checked')) {
						$('#SimpanBayarBunga').removeAttr('disabled'); //enable input
					} else {
						$('#SimpanBayarBunga').attr('disabled', true); //disable input
					}
				});


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
	
</script>	