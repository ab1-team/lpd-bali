<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$kd_rekening	= $_POST['cari'];
$tgl_transaksi	= $_POST['tgl_transaksi'];
$urutan			= $_POST['urutan'];

$table_transaksi="transaksi_".$_SESSION['lokasi'];
$table_rekening="rekening_".$_SESSION['lokasi'];

$rek=mysql_fetch_array(mysql_query("SELECT * FROM $table_rekening WHERE kd_rekening='$kd_rekening' "));
$jm=$rek['jenis_mutasi'];
	if($jm=='debit'){
		$rekening_debit=$rek['kd_rekening'];
		$rekening_kredit=$rek['pasangan'];
		}elseif($jm=='kredit'){
		$rekening_debit=$rek['pasangan'];
		$rekening_kredit=$rek['kd_rekening'];
		}
		
$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
?>
<script type="text/javascript">
				function kalkulatorKali(unit,harsat){
					var hasil = eval(unit) * eval(harsat);
						document.getElementById("result").value=tandaPemisahTitik(hasil);
					}
			$(document).ready(function() {
									
				$("#unit").keypress(function (data)  { if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){return false;}	});
				$("#harsat").keypress(function (data)  { if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){return false;}	});
				$("#umur_ekonomis").keypress(function (data)  { if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){return false;}	});
				
				$("#harsat").keyup(function(){
						var cari = $("#harsat").val();
						carinominal(cari);
					})
					function carinominal(e){
						var cari = e;
						$.ajax({
							type	: "POST",
							url		: "modul/jurnal/nominal_inventaris.php",
							data	: "cari="+cari,
							success	: function(data){
								$("#TampilNominal").html(data);
							}
						});
					}
					
				//SIMPAN JURNAL	
				$("#SimpanInventaris").click(function() {
                    var tgl_transaksi		= $('#tgl_transaksi').val();
                    var urutan				= $('#urutan').val();
                    var tgl_pakai			= $('#tgl_pakai').val();
                    var rekening_debit		= $('#rekening_debit').val();
                    var rekening_kredit		= $('#rekening_kredit').val();
					var keterangan_transaksi= $('#keterangan_transaksi').val();
                    var unit				= $('#unit').val();
                    var harsat				= $('#harsat').val();
                    var kategori			= $('#kategori').val();
                    var umur_ekonomis		= $('#umur_ekonomis').val();

					if(tgl_transaksi < tgl_pakai){
						$("#DilarangTransaksi").load('modul/jurnal_angsuran/dilarang_angsuran.php');
						return false;
							}
					
					if(keterangan_transaksi.length==0){$("#Dilarang").load('modul/jurnal/dilarang.php');$("#keterangan_transaksi").focus();return false;}
					if(unit.length==0){$("#Dilarang").load('modul/jurnal/dilarang.php');$("#unit").focus();return false;}
					if(harsat.length==0){$("#Dilarang").load('modul/jurnal/dilarang.php');$("#harsat").focus();return false;}
					if(umur_ekonomis.length==0){$("#Dilarang").load('modul/jurnal/dilarang.php');$("#umur_ekonomis").focus();return false;}
												
                    $.ajax({
                        type: "POST",
                        url: "modul/jurnal/simpan_jurnal_inventaris.php",
                        data: 	"tgl_transaksi="+tgl_transaksi+
								"&urutan="+urutan+
								"&rekening_debit="+rekening_debit+
								"&rekening_kredit="+rekening_kredit+
								"&keterangan_transaksi="+keterangan_transaksi+
								"&unit="+unit+
								"&harsat="+harsat+
								"&kategori="+kategori+
								"&umur_ekonomis="+umur_ekonomis,
						success: function(data) {
							$("#TampilJurnal").load('modul/jurnal/tampil_jurnal.php');
							$("#TampilBuku").load('modul/jurnal/tampil_buku.php');

                        }
                    });

                });
				
				
				$("#keterangan_transaksi").focus();
				
            });
        </script> 
							
							<div class="form-group">
                                <label class="control-label col-sm-4">Nama Barang</label>
                                <div class="col-sm-8"><input type="text" name="keterangan_transaksi" id="keterangan_transaksi" class="form-control"
									required="required" autocomplete="off" placeholder="Keterangan Transaksi / Nama Barang"> </div>
                            </div>
								<div class="form-group">
                                    <label class="col-sm-4 control-label" for="default-select">Kategori</label>
                                    <div class="col-sm-8">
                                        <select id="kategori"  name="kategori"
                                                data-placeholder="-- Kategori --"
                                                data-width="auto"
                                                data-minimum-results-for-search="10"
                                                tabindex="-1"
												class="select2 form-control">
												<option value="3">Umum</option>
												<option value="2">Kendaraan Dan Alat Berat</option>
												<option value="1">Gedung Dan Bangunan</option>
										</select>
									</div>
                                </div>
							<div class="form-group">
                                <label class="control-label col-sm-4">Jumlah Barang</label>
                                <div class="col-sm-4"><input type="text" onkeyup="kalkulatorKali(this.value,getElementById('harsat').value);" name="unit" id="unit" class="form-control" 
									required="required" autocomplete="off" placeholder="Jumlah Barang"> </div>
								<label class="control-label col-sm-4 ml-n-lg">Unit</label>
                            </div>
							<div class="form-group">
                                <label class="control-label col-sm-4">Harga Satuan</label>
                                <div class="col-sm-4"><input type="text" onkeyup="kalkulatorKali(this.value,getElementById('unit').value);" name="harsat" id="harsat" class="form-control" 
									required="required" autocomplete="off" placeholder="Harga Satuan"> </div>
                                <label class="control-label col-sm-4 ml-n-lg"><div id="TampilNominal"></div></label>
                            </div>
							<div class="form-group">
                                <label class="control-label col-sm-4">Umur Ekonomis</label>
                                <div class="col-sm-4"><input type="text" name="umur_ekonomis" id="umur_ekonomis" class="form-control" 
									required="required" autocomplete="off" placeholder="Umur Ekonomis"> </div>
								<label class="control-label col-sm-4 ml-n-lg">Bulan</label>
                            </div>
							<div class="form-group">
                                <label class="control-label col-sm-4">Harga Perolehan</label>
                                <div class="col-sm-8"><input disabled="disabled" type="text" name="result" id="result" class="form-control" onkeyup="javascript:tandaPemisahTitik(this);"> </div>
                            </div>
							<input type="hidden" name="tgl_transaksi" id="tgl_transaksi" value="<?php echo $tgl_transaksi;?>"/>
							<input type="hidden" name="rekening_debit" id="rekening_debit" value="<?php echo $rekening_debit;?>"/>
							<input type="hidden" name="rekening_kredit" id="rekening_kredit" value="<?php echo $rekening_kredit;?>"/>
							<input type="hidden" name="tgl_pakai" id="tgl_pakai" value="<?php echo $tgl_pakai;?>"/>
							<div id="Dilarang"></div>
							<div id="DilarangTransaksi"></div>
							<button class="btn btn-primary btn-rounded pull-right" id="SimpanInventaris"><i class="fa fa-paper-plane"></i> POSTING</button>
							