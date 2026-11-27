<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_keuangan_admin.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$nomor				= $_GET['nomora'];
$tgl_invoice		= $_GET['tgl_invoicea'];
$lokasi				= $_GET['lokasia'];
$jenis_pembayaran	= $_GET['jenis_pembayarana'];

$r=mysql_fetch_array(mysql_query("select * FROM kecamatan WHERE id='$lokasi' ")); //Deklarasi Jumlah Tagihan by Kecamatan
$tglawal=$r['tgl_pakai'];
if($jenis_pembayaran==1) {
	$jumlah_tagihan="10000000";
}else if($jenis_pembayaran==2) {
	$jumlah_tagihan=$r['biaya_tahunan'];
}else if($jenis_pembayaran==4) {
	$jumlah_tagihan="500000";
}else{
	$jumlah_tagihan="";
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
				
				$("#jumlah").focus();
				
				 $("#SimpanInvoice").click(function() {
                    var nomor			= $('#nomor').val();
					var tgl_invoice		= $('#tgl_invoice').val();
					var lokasi			= $('#lokasi').val();
					var jenis_pembayaran= $('#jenis_pembayaran').val();
					var jumlah			= $('#jumlah').val();
					
						if(jumlah.length==0) { $("#jumlah").focus(); return false; }
							
							
                    $.ajax({
                        type: "POST",
                        url: "admin/invoice/simpan_invoice.php",
                        data: 	"nomor="+nomor+
								"&tgl_invoice="+tgl_invoice+
								"&lokasi="+lokasi+
								"&jenis_pembayaran="+jenis_pembayaran+
								"&jumlah="+jumlah,
                        
						success: function(data) {
							$("#info_invoice").load('admin/invoice/sukses.php');

                        }
                    });

                });
					
				
				
				
				
				
            });
	]]>
        </script> 
							
							
							<div class="form-group">
                                        <label class="control-label col-sm-4">Tanggal Awal Pakai</label>
                                        <div class="col-sm-8"><input type="text" class="form-control"  name="tglawal" id="tglawal" value="<?php echo $tglawal; ?>" disabled
										required="required" autocomplete="off" placeholder="-- Tanggal Awal Pakai --"> </div>
                                    </div>
									
							<div class="form-group">
                                <label class="control-label col-sm-4">Jumlah Tagihan</label>
                                    <div class="col-sm-8"><input type="text" name="jumlah"  class="form-control" id="jumlah" value="<?php echo $jumlah_tagihan; ?>"
										required="required" autocomplete="off" placeholder="-- Jumlah Tagihan --"> </div>
                            </div>
							
							<div id="info_invoice"></div>
							
							<?php
								$data=mysql_query("select * FROM kecamatan c, admin_invoice i WHERE c.id=i.lokasi AND i.lokasi='$lokasi' "); //Cari Invoice dengan kode jenis pembayaran 1
									$rows	= mysql_num_rows($data);

										if ($jenis_pembayaran==1 AND $rows>0) {
											$row=mysql_fetch_array($data);
											$idv		=$row['idv'];
											$nomor		=$row['idv'];
											$sts		=$row['status'];
											
											
											
											if($nomor<10) {
												$nomor_invoice="00000$nomor";
											}else if($nomor>=10 AND $nomor<100) {
												$nomor_invoice="0000$nomor";
											}else if($nomor>=100 AND $nomor<1000) {
												$nomor_invoice="000$nomor";
											}else if($nomor>=1000 AND $nomor<10000) {
												$nomor_invoice="00$nomor";
											}else if($nomor>=10000 AND $nomor<100000) {
												$nomor_invoice="0$nomor";
											}else if($nomor>100000) {
												$nomor_invoice="$nomor";
											}

											$sumtagihan	=sumTagihan($idv);
											$sumSaldo	=sumSaldo($idv);
											
											if($sts=="UNPAID") {
												$status	=", DENGAN SISA TAGIHAN SEBESAR IDR.".number_format($sumSaldo).",- ";
											}else if($sts=="PAID") {
												$status	=".";
											}
											
											echo "
											<div class='alert alert-danger mt animated fadeInDown'>
												<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
												<strong>KECAMATAN ".strtoupper($row['nama_kec'])." PERNAH MEMILIKI INVOICE BIAYA LISENSI INSTALASI
												DENGAN NOMOR INVOICE #$nomor_invoice SENILAI IDR.".number_format($sumtagihan).",- DENGAN STATUS $sts$status </strong>
											</div>
											";

										}
							?>

							<input type="hidden" name="nomor" id="nomor" value="<?php echo $nomor;?>"/>
							<input type="hidden" name="tgl_invoice" id="tgl_invoice" value="<?php echo $tgl_invoice;?>"/>
							<input type="hidden" name="lokasi" id="lokasi" value="<?php echo $lokasi;?>"/>
							<input type="hidden" name="jenis_pembayaran" id="jenis_pembayaran" value="<?php echo $jenis_pembayaran;?>"/>

							<div class="form-actions">
                                <button class="btn btn-primary width-200 btn-rounded pull-right" id="SimpanInvoice"><i class="fa fa-edit"></i> BUAT INVOICE</button>
                                <button type="button" class="btn btn-default btn-rounded">Cancel</button>
                            </div>
							