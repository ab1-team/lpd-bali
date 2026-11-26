<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";

ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$table	= "transaksi_$_SESSION[lokasi]";
$id_trx		= $_POST['id_trx'];

$sql 	= mysql_query("SELECT * FROM $table WHERE idt='$id_trx' ");
$row	= mysql_num_rows($sql);
if ($row > 0){
	$r=mysql_fetch_array($sql);
	
?>

<script type="text/javascript">

function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
		
	$(document).ready(function() {
	
				
			$("#SimpanEditJurnal").click(function() {
                    var tgl_transaksi			= $('#tgl_transaksi_edit').val();
                    var keterangan_transaksi	= $('#keterangan_transaksi_edit').val();
                    var nominal					= $('#nominal_edit').val();
                    var urutan					= $('#urutan_edit').val();
                    var idt						= $('#idtr').val();
                    var pin						= $('#pin').val();
                    var pin2					= $('#pin2').val();
					
					if(pin2.length==0) { $("#pin2").focus();return false; }
					
					if(pin!=pin2){ alert('PIN Anda Salah!'); $("#pin2").focus(); return false; }
					
			
                    $.ajax({
                        type: "POST",
                        url: "modul/jurnal/simpan_jurnal.php",
                        data: 	"tgl_transaksi="+tgl_transaksi+
								"&keterangan_transaksi="+keterangan_transaksi+
								"&nominal="+nominal+
								"&urutan="+urutan+
								"&idt="+idt,
                        
						success: function(data) {
							$("#Berhasil").load('modul/jurnal/sukses_ubah.php');
							
                        }
                    });

                });	
				
				
		$("#HapusTransaksi").click(function() {
                    var idt		= $('#idtr').val();
                    var pin		= $('#pin').val();
                    var pin2	= $('#pin2').val();
					
					if(pin2.length==0) { $("#pin2").focus();return false; }
					
					if(pin!=pin2){ alert('PIN Anda Salah!'); $("#pin2").focus(); return false; }
					
					var pilih = confirm('Dengan menghapus jurnal '+idt+ ' secara otomatis jurnal yang berkaitan juga akan terhapus?');
					if (pilih==true) {
							
                    $.ajax({
                        type	: "POST",
						url		: "modul/jurnal/hapus.php",
						data	: "idt="+idt,
						success	: function(data){
							alert('Transaksi Berhasil dihapus!');
						}
                    });
					
					}

                });
				
				
            });
        </script>

								<div class="col-md-5">
									<div class="form-group">
										<span><i class="glyphicon glyphicon-calendar"></i></span>
										<label class="fs-sm">Tanggal Transaksi</label>
										<input type="text" name="tgl_transaksi_edit" id="tgl_transaksi_edit" class="form-control" value="<?php echo $r['tgl_transaksi'];?>"
											required="required" autocomplete="off" placeholder="-- Tanggal Transaksi --">
									</div>
									<div class="form-group">
										<span><i class="glyphicon glyphicon-comment"></i></span>
										<label class="fs-sm">Keterangan Transaksi</label>
										<textarea rows="3" class="autogrow form-control transition-height" name="keterangan_transaksi_edit" id="keterangan_transaksi_edit" 
											required="required" autocomplete="off" placeholder="-- Keterangan Transaksi --"><?php echo $r['keterangan_transaksi'];?></textarea>
									</div>
									<div class="form-group">
										<span><i class="glyphicon glyphicon-tags"></i></span>
										<label class="fs-sm"> Nominal</label>
										<input type="text" name="nominal_edit" id="nominal_edit" class="form-control" value="<?php echo $r['jumlah'];?>"
											required="required" autocomplete="off" placeholder="-- Nominal Transaksi --">
									</div>
									<div class="form-group">
										<span><i class="glyphicon glyphicon-list-alt"></i></span>
										<label class="fs-sm"> Baris ke-</label>
										<input type="text" name="urutan_edit" id="urutan_edit" class="form-control" value="<?php echo $r['urutan'];?>"
											required="required" autocomplete="off" placeholder="-- Baris Ke? --">
									</div>
								</div>
								<div class="col-md-7">
									<div class='alert alert-info'>
										<i class='fa fa-info-circle'></i> <strong>Data Rekening :<span class="pull-right">ID.Trx: <?php echo $r['idt'];?></span></strong>
										<hr>
															
									<?php
									echo "				
										<table width='100%' class='fs-mini'>
											<tr><td width='35%'>Rekening Debet</td><td width='1%'>:</td><td width='59%'> <strong>[$r[rekening_debit]] ".namarek($r['rekening_debit'])."</strong></td></tr>
											<tr><td>Rekening Kredit</td><td>:</td><td> <strong>[$r[rekening_kredit]] ".namarek($r['rekening_kredit'])."</strong></td></tr>
										</table>
									</div>	";
									?>
									
									<div class="form-group">
										<span><i class="glyphicon glyphicon-lock"></i></span>
										<label class="fs-sm"> Untuk Edit atau Delete, masukkan PIN Kepala LPD</label>
										<input type="password" name="pin2" id="pin2" class="form-control"
											required="required" autocomplete="off" placeholder="-- Masukkan PIN atau Password Ketua/Direktur --">
									</div>
									<div class="form-group text-align-center">
									<?php
									$ket 	= mysql_fetch_array(mysql_query("SELECT * FROM users WHERE level='1' AND jabatan='1' AND lokasi='$_SESSION[lokasi]' "));
									?>
										<input type="hidden" name="pin" id="pin" value="<?php echo $ket['pass'];?>"/>
										<input type="hidden" name="idtr" id="idtr" value="<?php echo $r['idt'];?>"/>
										
										<a class="btn btn-default width-100" href="javascript:;" data-toggle='tooltip' data-placement='bottom' title='Kwitansi Printer Diskjet/Laser' onclick="MM_openBrWindow('modul/jurnal/c_kw.php?idt=<?php echo $r['idt'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )">
											<h1><i class="glyphicon glyphicon-print hidden-print"></i></h1>
											<span class="fs-mini fw-semi-bold">Cetak<br>Kwitansi</span>
										</a>
										
										<button class="btn btn-default width-100" id="SimpanEditJurnal" >
											<h1><i class="glyphicon glyphicon-qrcode"></i></h1>
											<span class="fs-mini fw-semi-bold">Simpan<br>Perubahan</span>
										</button>
										
										<button class="btn btn-default width-100" id="HapusTransaksi" >
											<h1><i class="glyphicon glyphicon-remove"></i></h1>
											<span class="fs-mini fw-semi-bold">Hapus<br>Transaksi</span>
										</button>
										
										
									</div>
																	
									
								</div>
								<div class="col-md-12">
									<div id="Berhasil"></div>
									<div class="alert alert-warning fs-sm">
										<ul>
											<li>Fitur ini dapat anda gunakan untuk mencari, mencetak, merubah, dan menghapus transaksi.</li>
											<li>Data yang dapat dirubah meliputi Tanggal, Keterangan, Nominal, dan Urutan baris ke</li>
											<li>KeteranganNilai value untuk Urutan Ke- yaitu : 0=Posisi Awal, 1=Pindah ke posisi terbawah ditanggal yang sama, -1=Pindah ke posisi teratas ditanggal yang sama.</li>
											<li>Fitur ubah dan hapus data hanya dapat dilakukan oleh Ketua/Direktur/setingkatnya dengan memasukkan PIN/Password yang digunakan untuk login.</li>
											<li>Hati-hati dalam penggunaan fitur ini, terutama HAPUS, karena data yang telah dihapus tidak dapat dikembalikan lagi (Hapus Permanen).</li>
										</ul>
									
										
									</div>
								</div>
								
<?php
}else{
	echo "
	<h5>ID Transaksi <strong>$id_trx</strong> tidak ditemukan
	</h5>
	";
}
?>


