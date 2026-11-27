<?php session_start(); 
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_thumb.php";
$id	= $_POST['id'];
$row=mysql_fetch_array(mysql_query("select * from kecamatan kc, desa d, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
																fungsi_kelompok fgs, users u, sistem_angsuran sa, kelompok_$_SESSION[kd_kab] k
																WHERE
																kc.id=k.lokasi AND d.id=k.desa AND jpp.id=k.jenis_produk_pinjaman AND ju.id=k.jenis_usaha AND 			
																jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND 
																k.id='$id'"));	

?>

        <script type="text/javascript">
			$(document).ready(function() {
				
				$("#SimpanEditKelompok").click(function() {
                    var id = $('#id').val();
                    var namakelompok = $('#namakelompok').val();
                    var alamatkelompok = $('#alamatkelompok').val();
                    var telepon = $('#telepon').val();
                    var tglberdiri = $('#tglberdiri').val();
                    var jenis_produk_pinjaman2 = $('#jenis_produk_pinjaman2').val();
                    var jenis_usaha2 = $('#jenis_usaha2').val();
                    var jenis_kegiatan2 = $('#jenis_kegiatan2').val();
                    var tingkat_kelompok2 = $('#tingkat_kelompok2').val();
                    var fungsi_kelompok2 = $('#fungsi_kelompok2').val();
                    var namaketua = $('#namaketua').val();
                    var namasek = $('#namasek').val();
                    var namaben = $('#namaben').val();
					
					if(namakelompok.length==0){ $("#DilarangKosong").load('modul/kelompok/dilarang.php'); $("#namakelompok").focus(); return false; }
					
                    $.ajax({
                        type: "POST",
                        url: "modul/kelompok/simpan_edit.php",
                        data: 	"id="+id+
								"&namakelompok="+namakelompok+
								"&alamatkelompok="+alamatkelompok+
								"&telepon="+telepon+
								"&tglberdiri="+tglberdiri+
								"&jenis_produk_pinjaman2="+jenis_produk_pinjaman2+
								"&jenis_usaha2="+jenis_usaha2+
								"&jenis_kegiatan2="+jenis_kegiatan2+
								"&tingkat_kelompok2="+tingkat_kelompok2+
								"&fungsi_kelompok2="+fungsi_kelompok2+
								"&namaketua="+namaketua+
								"&namasek="+namasek+
								"&namaben="+namaben,
						success: function(data) {
                            $("#TampilDataKelompok").load('modul/kelompok/tampil_data.php');
                        }

                    });

                });
				
				
            });
			

        </script>


<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="row">
												<div class="col-md-1">
												 <input type="hidden" value="<?php echo $id;?>" name="id" id="id">
												</div>
                                                <div class="col-md-5">
													 <div class="form-group">
													<label class="fs-sm mb-0">Desa/Kelurahan</label>
                                                    <input type="text" class="form-control" value="<?php echo $row['nama_desa'];?>"
                                                              disabled="disabled" autocomplete="off" placeholder="Nama Desa">
													 </div>
                                                
                                                    <div class="form-group">
														<label class="fs-sm mb-0">Nama Kelompok</label>
                                                        <input type="text" class="form-control" value="<?php echo $row['nama_kelompok'];?>" name="namakelompok" id="namakelompok" 
                                                               autocomplete="off" placeholder="Nama Kelompok">
                                                    </div>
													
                                                    <div class="form-group">
														<label class="fs-sm mb-0">Alamat Kelompok</label>
                                                        <input type="text" class="form-control"  value="<?php echo $row['alamat_kelompok'];?>" name="alamatkelompok" id="alamatkelompok"
                                                               autocomplete="off" placeholder="Alamat Kelompok">
                                                    </div>
													
													<div class="form-group">
														<label class="fs-sm mb-0"><i class="fa fa-phone"></i> Telpon</label>
                                                        <input type="text" class="form-control"  value="<?php echo $row['telpon'];?>" name="telepon" id="telepon"
                                                               autocomplete="off" placeholder="Telpon">
                                                    </div>
													
													<div class="form-group">
														<label class="fs-sm mb-0">Tanggal Berdiri</label>
                                                        <input type="text" class="form-control"  value="<?php echo $row['tgl_berdiri'];?>" name="tglberdiri" id="tglberdiri"
                                                               autocomplete="off" placeholder="Tanggal Berdiri">
                                                    </div>
													
													<div class="form-group">
														<label class="fs-sm mb-0">Nama Ketua</label>
                                                        <input type="text" class="form-control"  value="<?php echo $row['ketua'];?>" name="namaketua" id="namaketua"
                                                               autocomplete="off" placeholder="Nama Ketua">
                                                    </div>
													
													<div class="form-group">
														<label class="fs-sm mb-0">Nama Sekretaris</label>
                                                        <input type="text" class="form-control"  value="<?php echo $row['sekretaris'];?>" name="namasek" id="namasek"
                                                               autocomplete="off" placeholder="Nama Sekretaris"/>
                                                    </div>
													
													<div class="form-group">
														<label class="fs-sm mb-0">Nama Bendahara</label>
                                                        <input type="text" class="form-control"  value="<?php echo $row['bendahara'];?>" name="namaben" id="namaben"
                                                               autocomplete="off" placeholder="Nama Bendahara"/>
                                                    </div>
												
												</div>
												<div class="col-md-1">
												</div>
                                                <div class="col-md-5">
													
                                                    <div class="form-group">
														<label class="fs-sm mb-0">KD. Kelompok</label>
                                                        <input type="text" class="form-control"  value="<?php echo $row['kd_kelompok'];?>" name="kd_kelompok" id="kd_kelompok" disabled="disabled">
                                                    </div>
													
													<div class="form-group">
													<label class="fs-sm mb-0">Jenis Produk Pinjaman</label>
                                                    <select id="jenis_produk_pinjaman2"  name="jenis_produk_pinjaman2" <?php if($_SESSION['level']!=1) echo "disabled='disabled'"; ?>
														data-placeholder="Jenis Produk Pinjaman"
														class="select2 form-control"
														tabindex="-1">
															<?php
															echo "<option value='$row[jenis_produk_pinjaman]'>$row[nama_jpp]</option>";
															$jpp=mysql_query("select * from jenis_produk_pinjaman Where
																	lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
																	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%'");
																while($r1=mysql_fetch_array($jpp)){
																echo "<option value='$r1[id]'>$r1[nama_jpp]</option>";
																} ?>
													</select>
													</div>
													
													<div class="form-group">
													<label class="fs-sm mb-0">Jenis Usaha</label>
                                                    <select id="jenis_usaha2"  name="jenis_usaha2"
														data-placeholder="Jenis Usaha"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															echo "<option value='$row[jenis_usaha]'>$row[nama_ju]</option>";
															$view=mysql_query("select * from jenis_usaha");
																while($rows=mysql_fetch_array($view)){
																echo "<option value='$rows[id]'>$rows[nama_ju]</option>";
																} ?>
													</select>
													</div>
													
													<div class="form-group">
													<label class="fs-sm mb-0">Jenis Kegiatan</label>
                                                    <select id="jenis_kegiatan2"  name="jenis_kegiatan2"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															echo "<option value='$row[jenis_kegiatan]'>$row[nama_jk]</option>";
															$view=mysql_query("select * from jenis_kegiatan");
																while($rows=mysql_fetch_array($view)){
																echo "<option value='$rows[id]'>$rows[nama_jk]</option>";
																} ?>
													</select>
													</div>
													
													<div class="form-group">
													<label class="fs-sm mb-0">Tingkat Kelompok</label>
                                                    <select id="tingkat_kelompok2"  name="tingkat_kelompok2" <?php if($_SESSION['level']!=1) echo "disabled='disabled'"; ?>
														class="select2 form-control"
														tabindex="-1">
															<?php 
															echo "<option value='$row[tingkat_kelompok]'>$row[nama_tk]</option>";
															$view=mysql_query("select * from tingkat_kelompok");
																while($rows=mysql_fetch_array($view)){
																echo "<option value='$rows[id]'>$rows[nama_tk]</option>";
																} ?>
													</select>
													</div>
													
													<div class="form-group">
													<label class="fs-sm mb-0">Fungsi Kelompok</label>
                                                    <select id="fungsi_kelompok2"  name="fungsi_kelompok2" <?php if($_SESSION['level']!=1) echo "disabled='disabled'"; ?>
														class="select2 form-control"
														tabindex="-1">
															<?php 
															echo "<option value='$row[fungsi_kelompok]'>$row[nama_fgs]</option>";
															$view=mysql_query("select * from fungsi_kelompok");
																while($rows=mysql_fetch_array($view)){
																echo "<option value='$rows[id]'>$rows[nama_fgs]</option>";
																} ?>
													</select>
													</div>
													
													<div class="form-group">
													<div id="DilarangKosong"></div>
													<div class="form-actions">
														<button href="#tab24" data-toggle="tab" class="btn btn-inverse btn-rounded pull-right" id="SimpanEditKelompok"><i class="fa fa-recycle"></i> Simpan Perubahan Data</button>
														<a href="#tab24" data-toggle="tab" class="btn btn-default btn-rounded">Cancel</a>
													</div>
													</div>
													

													
												</div>

                                            </div>
							</fieldset>
							
							</div>