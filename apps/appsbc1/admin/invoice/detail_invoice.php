<?php session_start(); ?>

        <script type="text/javascript">
		
		function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
			$(document).ready(function() {	


                $("#SimpanBayar").click(function() {
                    var idv						= $('#idv').val();
                    var tgl_transaksi			= $('#tgl_transaksi').val();
					var jumlah					= $('#jumlah').val();
					var jenis_pembayaran		= $('#jenis_pembayaran').val();
					var keterangan_transaksi	= $('#keterangan_transaksi').val();
					
						if(jumlah.length==0) { $("#jumlah").focus(); return false; }
							
							
                    $.ajax({
                        type: "POST",
                        url: "admin/invoice/simpan_bayar.php",
                        data: 	"idv="+idv+
								"&tgl_transaksi="+tgl_transaksi+
								"&jumlah="+jumlah+
								"&jenis_pembayaran="+jenis_pembayaran+
								"&keterangan_transaksi="+keterangan_transaksi,
                        
						success: function(data) {
							$("#InvoiceBerhasil").load('admin/invoice/sukses_bayar.php');

                        }
                    });

                });
				
            });
        </script>    

<?php 
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_keuangan_admin.php";

$idv	= $_POST['id'];

$row=mysql_fetch_array(mysql_query("select * from kecamatan c, admin_jenis_pembayaran j, admin_invoice i WHERE j.id=i.jenis_pembayaran AND c.id=i.lokasi AND i.idv='$idv'"));	

$nomor=$row['idv'];
										
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
?>
<div class="animated fadeInDown">
	
	<?php
	if($_SESSION['level']=="pusat" AND $row['status']=="UNPAID") {
	?>
		<div class="row">
			<div class="col-md-12">
							<legend>
								<h2 class="text-align-center">Form Pembayaran Invoice <b>#<?php echo $nomor_invoice;?></b><span class="fw-semi-bold pull-right"><a href="#tab1" data-toggle="tab"><i class="fa fa-times"></i></a></span></h4></h2>
							</legend>

							<div class="col-sm-3">
							</div>
							<div class="form-actions col-sm-6 mt-n-md">
									<input type="hidden" class="form-control" value="<?php echo $nomor;?>" name="idv" id="idv" >
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Telah Diterima pada Tanggal</label>
                                            <input type="text" class="form-control" value="<?php echo date('Y-m-d');?>" name="tgl_transaksi" id="tgl_transaksi" 
                                                autocomplete="off" placeholder="Telah diterima pada tanggal">
                                    </div>
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Uang Sebesar</label>
                                            <input type="text" class="form-control" value="<?php echo sumSaldo($nomor);?>" name="jumlah" id="jumlah" 
                                                autocomplete="off" placeholder="Uang sebesar">
                                    </div>
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Untuk Pembayaran</label>
                                            <input type="text" class="form-control" value="<?php echo "$row[nama_jp] Kec.$row[nama_kec]";?>" name="keterangan_transaksi" id="keterangan_transaksi" 
                                                autocomplete="off" placeholder="Untuk pembayaran">
                                    </div>
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Metode Pembayaran</label>
                                            <select id="jenis_pembayaran"  name="jenis_pembayaran"
                                                data-placeholder="-- Pilih Jenis Pembayaran --"
                                                class="select2 form-control"
                                                tabindex="-1">
													<?php 
													$kec=mysql_query("select * from admin_rekening WHERE kd_rekening='111.1001' OR kd_rekening='121.1001' ORDER BY kd_rekening DESC"); 
														while($row=mysql_fetch_array($kec)){
														echo "<option value='$row[kd_rekening]'>$row[nama_rekening]</option>";
														} ?>
											</select>
                                    </div>

								<div class="form-actions">
									<div id="InvoiceBerhasil"></div>
									<a href="" class='btn btn-primary btn-rounded pull-right' id="SimpanBayar"><i class='glyphicon glyphicon-th-large'></i>  SIMPAN PEMBAYARAN</a>
									<a href="#tab1" data-toggle="tab" class="btn btn-default btn-rounded">Kembali</a>
								</div>
							</div>
							<div class="col-sm-3  text-align-center">
								<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/INVOICE.php?idv=<?php echo $idv;?>' )"  class="btn btn-default width-100 height-100 mb-xs text-danger" role="button">
									<h1>
										<i class="glyphicon glyphicon-print"></i>
									</h1>
									<p>I N V O I C E</p>
								</a>
							</div>

            </div>
        </div>
		
	<?php }else{ ?>
	
		<div class="row">
			<div class="col-md-12">
							<legend>
								<h2 class="text-align-center">CETAK INVOICE <b>#<?php echo $nomor_invoice;?></b><span class="fw-semi-bold pull-right"><a href="#tab1" data-toggle="tab"><i class="fa fa-times"></i></a></span></h4></h2>
							</legend>

							<div class="col-sm-3">
							</div>
							<div class="form-actions col-sm-6 mt-n-md text-align-center">
								<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/INVOICE.php?idv=<?php echo $idv;?>' )"  class="btn btn-default width-100 height-100 mb-xs text-danger" role="button">
									<h1>
										<i class="glyphicon glyphicon-print"></i>
									</h1>
									<p>I N V O I C E</p>
								</a>	
							</div>
							<div class="col-sm-3">
								
							</div>

            </div>
        </div>
	<?php } ?>
</div>