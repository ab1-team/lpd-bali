<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_keuangan.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$kd_rekening	= $_POST['cari'];
$tgl_transaksi	= $_POST['tgl_transaksi'];

$table_transaksi="admin_transaksi";
$table_rekening="admin_rekening";
$jenis_buku	=$_SESSION['jenis_buku'];
$tgl=date('Y-m-d');
$saldo_buku	=saldo("$tgl-$jenis_buku");

$rek=mysql_fetch_array(mysql_query("SELECT * FROM $table_rekening WHERE kd_rekening='$kd_rekening' "));
$jm=$rek['jenis_mutasi'];
	if($jm=='debit'){
		$rekening_debit=$rek['kd_rekening'];
		$rekening_kredit=$rek['pasangan'];
		$mutasi=1;
		}elseif($jm=='kredit'){
		$rekening_debit=$rek['pasangan'];
		$rekening_kredit=$rek['kd_rekening'];
		$mutasi=0;
		}
		
			

?>
<script type="text/javascript">
<![CDATA[
var htmlobjek;

			$(document).ready(function() {
				//$("#nominal").keypress(function (data)  { 
				//		if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
				//			  return false;
				//		}	
				//	});
				
				$("#nominal").focus();
				
				$("#nominal").keyup(function(){
						var cari = $("#nominal").val();
						carinominal(cari);
					})
					function carinominal(e){
						var cari = e;
						$.ajax({
							type	: "POST",
							url		: "admin/transaksi/nominal.php",
							data	: "cari="+cari,
							success	: function(data){
								$("#TampilNominal").html(data);
							}
						});
					}
					
				//SIMPAN JURNAL	
				$("#SimpanJurnal").click(function() {
                    var tgl_transaksi	= $('#tgl_transaksi').val();
                    var rekening_debit		= $('#rekening_debit').val();
                    var rekening_kredit		= $('#rekening_kredit').val();
					var keterangan_transaksi= $('#keterangan_transaksi').val();
                    var nominal				= $('#nominal').val();
                    var saldo_buku			= $('#saldo_buku').val();
                    var jenis_mutasi		= $('#jenis_mutasi').val();
					

					//if(jenis_mutasi=="kredit" && saldo_buku-nominal < 0){
					//	$("#Dilarang").load('admin/transaksi/dilarang_saldo.php');
					//	return false;
					//		}
					
					
					if(nominal.length==0 || nominal==0){
						$("#Dilarang").load('admin/transaksi/dilarang.php');
						$("#nominal").focus();
						return false;
							}
							
					if(rekening_debit.length==0 || rekening_kredit.length==0){
						$("#Dilarang").load('admin/transaksi/dilarang.php');
						$("#rekening").focus();
						return false;
							}
					
					if(keterangan_transaksi.length==0 || keterangan_transaksi==0){
						$("#Dilarang").load('admin/transaksi/dilarang.php');
						$("#keterangan_transaksi").focus();
						return false;
							}
							
					
			
                    $.ajax({
                        type: "POST",
                        url: "admin/transaksi/simpan_jurnal.php",
                        data: 	"tgl_transaksi="+tgl_transaksi+
								"&rekening_debit="+rekening_debit+
								"&rekening_kredit="+rekening_kredit+
								"&keterangan_transaksi="+keterangan_transaksi+
								"&nominal="+nominal,
						success: function(data) {
							$("#TampilJurnal").load('admin/transaksi/tampil_jurnal.php');
							$("#TampilBuku").load('admin/transaksi/tampil_buku.php');
							$("#TampilSaldo").load('admin/transaksi/tampil_saldo.php');

                        }
                    });
					
					
					
  

                });
				
				
				
				
            });
	]]>
        </script> 
							
							
							
							<div class="form-group">
                                <label class="control-label col-sm-4">Keterangan</label>
                                <div class="col-sm-8"><input type="text" name="keterangan_transaksi" id="keterangan_transaksi" class="form-control" value="<?php echo $rek['nama_rekening'];?>"
									required="required" autocomplete="off" placeholder="-- Keterangan Transaksi --"> </div>
                            </div>
							
							<div class="form-group">
                                <label class="control-label col-sm-4">Nominal <span class="pull-right">Rp.</span></label>
                                <div class="col-sm-8"><input type="text" name="nominal" id="nominal" class="form-control" 
									required="required" autocomplete="off" placeholder="-- Nominal Transaksi --"> </div>
                            </div>
							<div id="DilarangTransaksi"></div>
							<div id="Dilarang"></div>
								<br>
							<div class="col-sm-8"><div id="TampilNominal"></div></div>
							<input type="hidden" name="tgl_transaksi" id="tgl_transaksi" value="<?php echo $tgl_transaksi;?>"/>
							<input type="hidden" name="jenis_mutasi" id="jenis_mutasi" value="<?php echo $jm;?>"/>
							<input type="hidden" name="saldo_buku" id="saldo_buku" value="<?php echo $saldo_buku;?>"/>
							<input type="hidden" name="rekening_debit" id="rekening_debit" value="<?php echo $rekening_debit;?>"/>
							<input type="hidden" name="rekening_kredit" id="rekening_kredit" value="<?php echo $rekening_kredit;?>"/>

							<button class="btn btn-inverse btn-rounded pull-right" id="SimpanJurnal"><i class="fa fa-paper-plane"></i> POSTING</button>
							