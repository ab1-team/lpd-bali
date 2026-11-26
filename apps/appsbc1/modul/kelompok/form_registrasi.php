<script type="text/javascript">	

function myFunction() {
    var x = document.getElementById("SimpanRegistrasiKelompok");
    x.disabled = true;
}
	
$(document).ready(function(){
	
	$("#desa").click(function(){
		var cari = $("#desa").val();

		$.ajax({
			type	: "POST",
			url		: "modul/kelompok/buat_kode_kelompok.php",
			data	: "cari="+cari,
			dataType: "json",
			success	: function(data){
				$("#kd_kelompok").val(data.kd_kelompok);
				$("#nama_kelompok").focus();
			}
		});
	});
	
	
	$("#telpon").keypress(function (data)  {
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
	
	
				$("#SimpanRegistrasiKelompok").click(function() {
                    var desa = $('#desa').val();
                    var kd_kelompok = $('#kd_kelompok').val();
                    var nama_kelompok = $('#nama_kelompok').val();
                    var alamat_kelompok = $('#alamat_kelompok').val();
                    var telpon = $('#telpon').val();
                    var tgl_berdiri = $('#tgl_berdiri').val();
                    var jenis_produk_pinjaman = $('#jenis_produk_pinjaman').val();
                    var jenis_usaha = $('#jenis_usaha').val();
                    var jenis_kegiatan = $('#jenis_kegiatan').val();
                    var tingkat_kelompok = $('#tingkat_kelompok').val();
                    var fungsi_kelompok = $('#fungsi_kelompok').val();
                    var ketua = $('#ketua').val();
                    var sekretaris = $('#sekretaris').val();
                    var bendahara = $('#bendahara').val();
                    var lokasi = $('#lokasi').val();
                    var id_user = $('#id_user').val();
						
						if(desa.length==0){ $("#Dilarang").load('modul/kelompok/dilarang.php'); document.getElementById("SimpanRegistrasiKelompok").disabled = false; $("#desa").focus(); return false; }
						if(nama_kelompok.length==0){ $("#Dilarang").load('modul/kelompok/dilarang.php'); document.getElementById("SimpanRegistrasiKelompok").disabled = false; $("#nama_kelompok").focus(); return false; }
						if(alamat_kelompok.length==0){ $("#Dilarang").load('modul/kelompok/dilarang.php'); document.getElementById("SimpanRegistrasiKelompok").disabled = false; $("#alamat_kelompok").focus(); return false; }
						if(telpon.length==0){ $("#Dilarang").load('modul/kelompok/dilarang.php'); document.getElementById("SimpanRegistrasiKelompok").disabled = false; $("#telpon").focus(); return false; }
						if(ketua.length==0){ $("#Dilarang").load('modul/kelompok/dilarang.php'); document.getElementById("SimpanRegistrasiKelompok").disabled = false; $("#ketua").focus(); return false; }
						if(sekretaris.length==0){ $("#Dilarang").load('modul/kelompok/dilarang.php'); document.getElementById("SimpanRegistrasiKelompok").disabled = false; $("#sekretaris").focus(); return false; }
							

                    $.ajax({
                        type: "POST",
                        url: "modul/kelompok/simpan_registrasi.php",
                        data: 	"desa="+desa+
								"&kd_kelompok="+kd_kelompok+
								"&nama_kelompok="+nama_kelompok+
								"&alamat_kelompok="+alamat_kelompok+
								"&telpon="+telpon+
								"&tgl_berdiri="+tgl_berdiri+
								"&jenis_produk_pinjaman="+jenis_produk_pinjaman+
								"&jenis_usaha="+jenis_usaha+
								"&jenis_kegiatan="+jenis_kegiatan+
								"&tingkat_kelompok="+tingkat_kelompok+
								"&fungsi_kelompok="+fungsi_kelompok+
								"&ketua="+ketua+
								"&sekretaris="+sekretaris+
								"&bendahara="+bendahara+
								"&lokasi="+lokasi+
								"&id_user="+id_user,
                        success: function(data) {
							$("#Berhasil").load('modul/kelompok/berhasil.php');
							$("#kelompok").load('modul/pinjaman/register/pilih_kelompok.php');
							document.getElementById("SimpanRegistrasiKelompok").disabled = false; 

                        }
                    });

                });
	
});	
	
</script>

<div class="modal fade" id="FormInputKelompok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
                            <div class="modal-dialog" style="width:900px;">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title fw-bold mt mb text-align-right mr-lg" id="myModalLabel18">
											<span class="fw-normal">FORMULIR REGISTRASI</span> KELOMPOK BARU <i class="glyphicon glyphicon-th-large"></i>
										</h4>
										
                                    </div>
                                    
									
									
									<div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
													 <div class="form-group">
													<label class="fs-sm mb-0">Desa/Kelurahan</label>
                                                    <select id="desa"  name="desa"
														data-placeholder="Desa/Kelurahan"
														class="select2 form-control"
														tabindex="-1">
														<option value=''></option>
															<?php 
															$kec=mysql_fetch_array(mysql_query("select * from kecamatan where id='$_SESSION[lokasi]'"));
															$view=mysql_query("select * from desa where kd_kec='$kec[kd_kec]' order by kd_desa asc"); //DESA
																while($rows=mysql_fetch_array($view)){
																echo "<option value='$rows[id]'>$rows[nama_desa]</option>";
																} ?>
													</select>
													 </div>
                                                
                                                    <div class="form-group">
														<label class="fs-sm mb-0">Nama Kelompok</label>
                                                        <input type="text" class="form-control" name="nama_kelompok" id="nama_kelompok"
                                                               autocomplete="off" placeholder="Nama Kelompok"/>
                                                    </div>
													
                                                    <div class="form-group">
														<label class="fs-sm mb-0">Alamat Kelompok</label>
                                                        <input type="text" class="form-control" name="alamat_kelompok" id="alamat_kelompok"
                                                               autocomplete="off" placeholder="Alamat Kelompok"/>
                                                    </div>
													
													<div class="form-group">
														<label class="fs-sm mb-0">No. Telpon (untuk menerima SMS)</label>
                                                        <input type="text" class="form-control" name="telpon" id="telpon" value="08"
                                                               autocomplete="off" placeholder="Telpon"/>
                                                    </div>
													
													<div class="form-group">
														<label class="fs-sm mb-0">Tanggal Berdiri</label>
                                                        <input type="text" class="form-control" name="tgl_berdiri" id="tgl_berdiri"
                                                               autocomplete="off" placeholder="Tanggal Berdiri" value="<?php echo date('Y')-1 ."-".date('m-d');?>"/>
                                                    </div>
												
												</div>
												
                                                <div class="col-md-4">
													
                                                    <div class="form-group">
														<label class="fs-sm mb-0">KD. Kelompok</label>
                                                        <input type="text" class="form-control" name="kd_kelompok" id="kd_kelompok" disabled="disabled" placeholder="Kode Kelompok"/>
                                                    </div>
													
													<div class="form-group">
													<label class="fs-sm mb-0">Jenis Produk Pinjaman</label>
                                                    <select id="jenis_produk_pinjaman"  name="jenis_produk_pinjaman"
														data-placeholder="Jenis Produk Pinjaman"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															$view=mysql_query("select * from jenis_produk_pinjaman");
																while($rows=mysql_fetch_array($view)){
																echo "<option value='$rows[id]'>$rows[nama_jpp]</option>";
																} ?>
													</select>
													</div>
													
													<div class="form-group">
														<label class="fs-sm mb-0">Nama Ketua</label>
                                                        <input type="text" class="form-control" name="ketua" id="ketua"
                                                               autocomplete="off" placeholder="Nama Ketua"/>
                                                    </div>
													
													<div class="form-group">
														<label class="fs-sm mb-0">Nama Sekretaris</label>
                                                        <input type="text" class="form-control" name="sekretaris" id="sekretaris"
                                                               autocomplete="off" placeholder="Nama Sekretaris"/>
                                                    </div>
													
													<div class="form-group">
														<label class="fs-sm mb-0">Nama Bendahara</label>
                                                        <input type="text" class="form-control" name="bendahara" id="bendahara"
                                                               autocomplete="off" placeholder="Nama Bendahara"/>
														<input type="hidden" name="lokasi" id="lokasi" value="<?php echo $_SESSION['lokasi']; ?>"/>
														<input type="hidden" name="id_user" id="id_user" value="<?php echo $_SESSION['id']; ?>"/>
                                                    </div>

													
												</div>
												
												<div class="col-md-4">
												
													<div class="form-group">
													<label class="fs-sm mb-0">Jenis Usaha</label>
                                                    <select id="jenis_usaha"  name="jenis_usaha"
														data-placeholder="Jenis Usaha"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															$view=mysql_query("select * from jenis_usaha");
																while($rows=mysql_fetch_array($view)){
																echo "<option value='$rows[id]'>$rows[nama_ju]</option>";
																} ?>
													</select>
													</div>
													
													<div class="form-group">
													<label class="fs-sm mb-0">Jenis Kegiatan</label>
                                                    <select id="jenis_kegiatan"  name="jenis_kegiatan"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															$view=mysql_query("select * from jenis_kegiatan");
																while($rows=mysql_fetch_array($view)){
																echo "<option value='$rows[id]'>$rows[nama_jk]</option>";
																} ?>
													</select>
													</div>
													
													<div class="form-group">
													<label class="fs-sm mb-0">Tingkat Kelompok</label>
                                                    <select id="tingkat_kelompok"  name="tingkat_kelompok"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															$view=mysql_query("select * from tingkat_kelompok");
																while($rows=mysql_fetch_array($view)){
																echo "<option value='$rows[id]'>$rows[nama_tk]</option>";
																} ?>
													</select>
													</div>
													
													<div class="form-group">
													<label class="fs-sm mb-0">Fungsi Kelompok</label>
                                                    <select id="fungsi_kelompok"  name="fungsi_kelompok"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															$view=mysql_query("select * from fungsi_kelompok");
																while($rows=mysql_fetch_array($view)){
																echo "<option value='$rows[id]'>$rows[nama_fgs]</option>";
																} ?>
													</select>
													</div>
													
													<div class="form-group text-align-center">
														<div id="Dilarang"> </div>
														<div id="Berhasil"> </div>
														<label class="fs-sm mb-0">Pastikan data anda telah lengkap!</label>
														<button class="btn btn-primary width-150" id="SimpanRegistrasiKelompok" onclick="myFunction()">Registrasi</button>
														<button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
													</div>
													
												</div>

                                            </div>
                                    </div>
                                    <div class="modal-footer text-align-center">
										<label class="fs-sm mb-0 text-align-center">www.siupkonline.com</label>
									</div>
							
                                </div>
                            </div>
                        </div>