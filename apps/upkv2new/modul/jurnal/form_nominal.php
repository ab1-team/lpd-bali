<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_keuangan.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$kd_rekening	= $_POST['cari'];
$jenis_buku		= $_SESSION['jenis_buku'];
$tgl_transaksi	= $_POST['tgl_transaksi'];
$urutan			= $_POST['urutan'];

$table_transaksi="transaksi_".$_SESSION['lokasi'];
$table_rekening="rekening_".$_SESSION['lokasi'];
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
		
$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
			

?>
<script type="text/javascript">
<![CDATA[
var htmlobjek;

function myFunction() {
    var x = document.getElementById("SimpanJurnal");
    x.disabled = true;
}

			$(document).ready(function() {
				//$("#nominal").keypress(function (data)  { 
				//		if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
				//			  return false;
				//		}	
				//	});
				
					
				//SIMPAN JURNAL	
				$("#SimpanJurnal").click(function() {
                    var tgl_transaksi	= $('#tgl_transaksi').val();
                    var urutan	= $('#urutan').val();
                    var tgl_pakai		= $('#tgl_pakai').val();
                    var rekening_debit		= $('#rekening_debit').val();
                    var rekening_kredit		= $('#rekening_kredit').val();
					var keterangan_transaksi= $('#keterangan_transaksi').val();
                    var nominal				= $('#nominal').val();
                    var saldo_buku			= $('#saldo_buku').val();
                    var jenis_mutasi		= $('#jenis_mutasi').val();
                    var rupiah              = $('#rupiah').val();
					

					//if(jenis_mutasi=="kredit" && saldo_buku-nominal < 0){
					//	$("#Dilarang").load('modul/jurnal/dilarang_saldo.php');
					//	return false;
					//		}
					
					var i = 0
					while(i <= nominal.length) {
					    nominal = nominal.toString().replace('.','')
					    i++
					}
					
					if(tgl_transaksi < tgl_pakai){
						$("#DilarangTransaksi").load('modul/jurnal_angsuran/dilarang_angsuran.php');
						document.getElementById("SimpanJurnal").disabled = false;
						$("#tgl_transaksi").focus();
						return false;
							}
					
					if(nominal.length==0 || nominal==0){
						$("#Dilarang").load('modul/jurnal/dilarang.php');
						document.getElementById("SimpanJurnal").disabled = false;
						$("#nominal").focus();
						return false;
							}
							
					if(rekening_debit.length==0 || rekening_kredit.length==0){
						$("#Dilarang").load('modul/jurnal/dilarang.php');
						document.getElementById("SimpanJurnal").disabled = false;
						$("#rekening").focus();
						return false;
							}
					
					if(keterangan_transaksi.length==0 || keterangan_transaksi==0){
						$("#Dilarang").load('modul/jurnal/dilarang.php');
						document.getElementById("SimpanJurnal").disabled = false;
						$("#keterangan_transaksi").focus();
						return false;
							}
							
					
			
                    $.ajax({
                        type: "POST",
                        url: "modul/jurnal/simpan_jurnal.php",
                        data: 	"tgl_transaksi="+tgl_transaksi+
								"&rekening_debit="+rekening_debit+
								"&rekening_kredit="+rekening_kredit+
								"&keterangan_transaksi="+keterangan_transaksi+
								"&urutan="+urutan+
								"&nominal="+nominal+
								"&rupiah="+rupiah,
						success: function(data) {
							$("#TampilJurnal").load('modul/jurnal/tampil_jurnal.php');
							$("#TampilBuku").load('modul/jurnal/tampil_buku.php');
							$("#TampilSaldo").load('modul/jurnal/tampil_saldo.php');
							document.getElementById("SimpanJurnal").disabled = false;

                        }
                    });
					
					
					
  

                });
				
				
				
				
            });
	]]>
        </script>
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

			function numbersonly(ini, e){
				if (e.keyCode>=49){
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
				}else if (e.keyCode==48){
					a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
					b = a.replace(/[^\d]/g,"");
					if (parseFloat(b)!=0){
						ini.value = tandaPemisahTitik(b);
						return false;
					} else {
						return false;
					}
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
				} else if (e.keyCode==9){
					return true;
				} else if (e.keyCode==17){
					return true;
				} else {
					//alert (e.keyCode);
					return false;
				}

			}


        </script> 
							
							
							
							<div class="form-group">
                                <label class="control-label col-sm-4">Keterangan</label>
                                <?php if($_SESSION['lokasi']==1){ ?>
                                <div class="col-sm-8"><input type="text" name="keterangan_transaksi" id="keterangan_transaksi" class="form-control" value="<?php echo htmlentities($rek['nama_rekening'],ENT_QUOTES);?>"
									required="required" autocomplete="off" placeholder="-- Lokasi 1 --"> </div>
                            </div>
                            <?php }else{?>
                                <div class="col-sm-8"><input type="text" name="keterangan_transaksi" id="keterangan_transaksi" class="form-control" value="<?php echo $rek['nama_rekening'];?>"
									required="required" autocomplete="off" placeholder="-- Keterangan Transaksi --"> </div>
                            </div>
							<?php } ?>
							<div class="form-group">
                                <label class="control-label col-sm-4">Nominal <span class="pull-right">Rp.</span></label>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <input type="text" name="nominal" id="nominal" class="form-control input-lg" 
    									required="required" autocomplete="off" placeholder="-- Nominal Transaksi --" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                                        </div>
                                        <div class="col-sm-5">
    								        <input type="number" name="rupiah" id="rupiah" class="form-control input-lg" max="99" min="00" value="00">
                                        </div>
                                        <div class="col-sm-12">00 adalah angka dibelakang koma</div>
                                    </div>
         <!--                           <input type="text" name="nominal" id="nominal" class="form-control input-lg" -->
									<!--required="required" autocomplete="off" placeholder="-- Nominal Transaksi --" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">-->
								</div>
                            </div>
							<div id="DilarangTransaksi"></div>
							<div id="Dilarang"></div>
							<div id="TampilJurnal"></div>
								<br>
							
							
							<input type="hidden" name="tgl_transaksi" id="tgl_transaksi" value="<?php echo $tgl_transaksi;?>"/>
							<input type="hidden" name="urutan" id="urutan" value="<?php echo $urutan;?>"/>
							<input type="hidden" name="jenis_mutasi" id="jenis_mutasi" value="<?php echo $jm;?>"/>
							<input type="hidden" name="saldo_buku" id="saldo_buku" value="<?php echo $saldo_buku;?>"/>
							<input type="hidden" name="rekening_debit" id="rekening_debit" value="<?php echo $rekening_debit;?>"/>
							<input type="hidden" name="rekening_kredit" id="rekening_kredit" value="<?php echo $rekening_kredit;?>"/>
							<input type="hidden" name="tgl_pakai" id="tgl_pakai" value="<?php echo $tgl_pakai;?>"/>
							<input type="hidden" name="tgl_transaksi" id="tgl_transaksi" value="<?php echo $tgl_transaksi;?>"/>
						
							<button class="btn btn-primary mb btn-block btn-lg" id="SimpanJurnal"><i class="fa fa-paper-plane"></i> POSTING TRANSAKSI</button>
							