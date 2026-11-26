 <script type="text/javascript" src="js/jquery-1.2.3.min.js"></script>
        <script type="text/javascript">
			$(document).ready(function() {

			$("#nik").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
					
				$("#TampilData").load('modul/account/tampil_data.php');
				$("#TampilUname").load('modul/account/tampil_uname.php');
				
				
				$("#SimpanQuote").click(function() {
                    var mutiara = $('#mutiara').val();
						if(unamenew.length==0){
						alert('Silahkan isikan Kata Motivasi Kerja Anda');
						$("#mutiara").focus();
						return false;
							}
                    $.ajax({
                        type: "POST",
                        url: "modul/account/simpan_quote.php",
                        data: "mutiara="+mutiara,
                        success: function(data) {
                            alert('Quote berhasil disimpan');
                        }
                    });
                });	
				
                
				$("#SimpanUsername").click(function() {
                    var unamenew = $('#unamenew').val();
						if(unamenew.length==0){
						alert('Silahkan isikan Username baru Anda!');
						$("#unamenew").focus();
						return false;
							}
                    $.ajax({
                        type: "POST",
                        url: "modul/account/simpan_uname.php",
                        data: "unamenew="+unamenew,
                        success: function(data) {
                            $("#TampilUname").load('modul/account/tampil_uname.php');
                        }
                    });
                });	
				
				$("#SimpanPassword").click(function() {
                    var passnew1 = $('#passnew1').val();
                    var passnew2 = $('#passnew2').val();
					
						if(passnew1.length==0){
						alert('Silahkan isikan Password baru Anda!');
						$("#passnew1").focus();
						return false;
							}
						if(passnew1!=passnew2){
						alert('Konfirmasi Password Anda tidak Cocok!');
						$("#passnew2").focus();
						return false;
							}
							
							
                    $.ajax({
                        type: "POST",
                        url: "modul/account/simpan_password.php",
                        data:  "passnew2="+passnew2,
                        success: function(data) {
                            alert('Password berhasil diubah!');
                        }
                    });
                });	
				
				$("#SimpanEditData").click(function() {
                    var nik = $('#nik').val();
                    var namadepan = $('#namadepan').val();
                    var namabelakang = $('#namabelakang').val();
                    var ins = $('#ins').val();
                    var jk = $('#jk').val();
                    var tempat_lahir = $('#tempat_lahir').val();
                    var tgl_lahir = $('#tgl_lahir').val();
                    var alamat = $('#alamat').val();
                    var hp = $('#hp').val();
                    var pendidikan = $('#pendidikan').val();
                    var sejak = $('#sejak').val();
						
                    $.ajax({
                        type: "POST",
                        url: "modul/account/simpan_data.php",
                        data:"nik="+nik+
								"&namadepan="+namadepan+
								"&namabelakang="+namabelakang+
								"&ins="+ins+
								"&jk="+jk+
								"&tempat_lahir="+tempat_lahir+
								"&tgl_lahir="+tgl_lahir+
								"&alamat="+alamat+
								"&hp="+hp+
								"&pendidikan="+pendidikan+
								"&sejak="+sejak,
                        
						success: function(data) {
                            $("#TampilData").load('modul/account/tampil_data.php');
                        }
                    });
                });
				
				$("#UploadFoto").click(function() {
                    var foto = $('#foto').val();
						
                    $.ajax({
                        type: "POST",
                        data:"foto="+foto,
                        
						success: function(data) {
                           $("#tab62").html(data);
                        }
                    });
                });
				
            });
			

        </script>

<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_thumb.php";
$kec=mysql_fetch_array(mysql_query("select * from kecamatan where id='$_SESSION[lokasi]'"));
$row=mysql_fetch_array(mysql_query("select * from users where id='$_SESSION[id]'"));
$nik=$row['nik'];
$jab=mysql_fetch_array(mysql_query("select * from jabatan j, level l, kecamatan k, pendidikan p WHERE p.id=$row[pendidikan] and j.id=$row[jabatan] and l.id=$row[level] and k.id=$row[lokasi]"));
	$onl=$row['online']; if ($onl=="Y") { $ston="Online"; $lbon="label-success";}else{ $ston="Offline"; $lbon="label-default";}
	$nl=$row['nilai']; if ($nl=="1") { $nil="Up"; $lbl="fa-thumbs-up";}else{ $nil="Down"; $lbl="fa-thumbs-down";}
	
	
?>
	<h4 class="page-title"><span class="fw-semi-bold">My</span> Account</h4>
		<div class="row">
			<div class="col-md-8">
                <div class="tabbable tabs-left mb-lg">
                    <ul id="tabs2" class="nav nav-tabs">
                        <li class="active"><a href="#tab12" data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Personal Data</a></li>
						<li class=""><a href="#tab62" data-toggle="tab"><i class="fa fa-camera"></i> Foto</a></li>
                        <li class=""><a href="#tab22" data-toggle="tab"><i class="fa fa-globe"></i> Data Online</a></li>
                        <li class=""><a href="#tab82" data-toggle="tab"><i class="fa fa-quote-left"></i> Quote / Kata Motivasi</a></li>
                        <li class=""><a href="#tab32"  data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Username</a></li>
                        <li class=""><a href="#tab42"  data-toggle="tab"><i class="fa fa-key"></i> Password</a></li>
                    </ul>
                    <div id="tabs2c" class="tab-content">
						
						<div class="tab-pane" id="tab62">
							<header>
								<legend><i class="fa fa-camera"></i> Foto</legend>
							</header>
							
							<div class="row">
							<div class="col-md-12 col-md-offset">
							<body>
							<span class="thumb-sm avatar img-user mt-sm text-align-center" style="width:180px;">
											
								
								<div id="camera">
								<?php
														$foto="../../foto_users/$_SESSION[id].png";
														if(file_exists($foto)){
															echo "<img  alt='' src='foto_users/$_SESSION[id].png'>";
														}else{
															echo "<img  src='img/avatar.png'>";
														}
														?>
								</div>
								<div id="ambil">
									<button type="button" onClick="foto()" class="btn btn-sm btn-block bg-white" <?php echo $disabled; ?>><i class="glyphicon glyphicon-camera"></i> AMBIL FOTO</button>
								</div>
								<div id="webcam" style="display:none">
									<button type="button" onClick="preview()" class="btn btn-sm btn-block"><i class="glyphicon glyphicon-camera"></i> TANGKAP</button>
								</div>
								<div id="simpanfoto" style="display:none">
									<div class="btn-group">
											<button type="button" class="btn btn-sm" onClick="batal()"><i class="glyphicon glyphicon-remove"></i> REMOVE </button>
											<button type="button" class="btn btn-sm" onClick="simpanfoto()" style="font-weight:bold;"> &nbsp; <i class="glyphicon glyphicon-qrcode"></i> SIMPAN</button>
										</div>
								</div>
							</span>
				 
							<script src="modul/penduduk/js/webcam.min.js"></script>
							<script language="Javascript">
								// konfigursi webcam
								Webcam.set({
									width: 240,
									height: 180,

									// device capture size
									dest_width: 240,
									dest_height: 180,

									// final cropped size
									crop_width: 180,
									crop_height: 180,
									image_format: 'jpg',
									jpeg_quality: 100
								});
								
								function foto() {
									Webcam.attach('#camera');
									document.getElementById('webcam').style.display = '';
									document.getElementById('ambil').style.display = 'none';
								}
							
								function preview() {
									// untuk preview gambar sebelum di upload
									Webcam.freeze();
									// ganti display webcam menjadi none dan simpan menjadi terlihat
									document.getElementById('webcam').style.display = 'none';
									document.getElementById('simpanfoto').style.display = '';
								}
								
								function batal() {
									// batal preview
									Webcam.unfreeze();
									
									// ganti display webcam dan simpan seperti semula
									document.getElementById('webcam').style.display = '';
									document.getElementById('simpanfoto').style.display = 'none';
									document.getElementById('ambil').style.display = 'none';
								}
								
								function simpanfoto() {
									// ambil foto
									Webcam.snap(function(data_uri) {

										// upload foto
										Webcam.upload(data_uri, 'modul/account/upload_foto.php?id=<?php echo $_SESSION['id'];?>', function(code, text) {});

										// tampilkan hasil gambar yang telah di ambil                
										Webcam.unfreeze();
										//Webcam.reset();
										document.getElementById('camera').innerHTML =
											'<img src="' + data_uri + '"/>';
										document.getElementById('ambil').style.display = '';
										document.getElementById('webcam').style.display = 'none';
										document.getElementById('simpanfoto').style.display = 'none';

									});
								}
								
							</script>
							
						</body>
						
							</div>
						</div>
                        </div>
						
						<div class="tab-pane active" id="tab12">
							<header>
								<legend><i class="fa fa-credit-card"></i> Personal Data</legend>
								<div class="widget-controls">
									<a title="Edit Data" href="#tab52"  data-toggle="tab"><i class="fa fa-edit"></i></a>
								</div>
							</header>
                            <div id="TampilData"></div>
                        </div>
						
                        <div class="tab-pane" id="tab22">
                            <header>
								<legend><i class="fa fa-globe"></i> Data Online</legend>
							</header>
							<div><div class="col-sm-4">Status Online</div><label class="col-sm-8">: <?php echo "<span class='label $lbon'>$ston</span>";?></label></div>
                            <div><div class="col-sm-4">Last Login</div><label class="col-sm-8">: <?php echo $row['lo'];?></label></div>
                            <div><div class="col-sm-4">Jumlah Kunjungan</div><label class="col-sm-8">: <?php echo number_format($row['kunjungan']);?> kali</label></div>
                            <div><div class="col-sm-4">Penilaian Sistem</div><label class="col-sm-8">: <?php echo "<i class='fa $lbl'></i> $nil";?></label></div>
                            <div><div class="col-sm-4">IP User</div><label class="col-sm-8">: <?php echo $_SERVER['REMOTE_ADDR'];?></label></div>
                            <div><div class="col-sm-4">Browser</div><label class="col-sm-8">: <?php echo $_SERVER['HTTP_USER_AGENT'];?></label></div>
                            <div><div class="col-sm-4">URL</div><label class="col-sm-8">: <?php echo $_SERVER['HTTP_HOST'];?></label></div>
                            <div><div class="col-sm-4">Sistem Operasi</div><label class="col-sm-8">: -</label></div>
                        </div>
						
						<div class="tab-pane" id="tab82">
							<header>
								<legend><i class="fa fa-quote-left"></i> Quote/Kata Motivasi Kerja <i class="fa fa-quote-right"></i></legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="form-group">
                                        <div class="col-sm-12"><textarea type="text" name="mutiara" class="form-control" id="mutiara"
										required="required" autocomplete="off" placeholder="Quote/Kata Motivasi Kerja"></textarea> </div>
                                    </div>
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanQuote"><i class="fa fa-recycle"></i> Simpan Quote</button>
                                <label></label>
                            </div>
							</div>
                        </div>
						
                        <div class="tab-pane" id="tab32">
							<header>
								<legend><i class="glyphicon glyphicon-user"></i> Username</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>

                                    <div id="TampilUname"></div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Username Baru</label>
                                        <div class="col-sm-8"><input type="text" name="unamenew" class="form-control" id="unamenew"
										required="required" autocomplete="off" placeholder="Username baru"> </div>
                                    </div>
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanUsername"><i class="fa fa-recycle"></i> Ubah Username</button>
                                <label></label>
                            </div>
							</div>
                        </div>
						
						<div class="tab-pane" id="tab42">
							<header>
								<legend><i class="fa fa-key"></i> Password</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Password Lama</label>
                                        <div class="col-sm-8"><input type="text" name="passold" class="form-control" id="passold"
										required="required" autocomplete="off" placeholder="***********" disabled="disabled"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Password Baru</label>
                                        <div class="col-sm-8"><input type="text" name="passnew1" class="form-control" id="passnew1"
										required="required" autocomplete="off" placeholder="Password Baru"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Konfirmasi Password *</label>
                                        <div class="col-sm-8"><input type="text" name="passnew2" class="form-control" id="passnew2"
										required="required" autocomplete="off" placeholder="Konfirmasi Password Baru"> </div>
                                    </div>
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanPassword"><i class="fa fa-recycle"></i> Ubah Password</button>
                                <label></label>
                            </div>
							</div>
                        </div>
						
						<div class="tab-pane" id="tab52">
							<header>
								<legend><i class="fa fa-edit"></i> Edit Personal Data</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="form-group">
                                        <label class="control-label col-sm-4">N I K / J K</label>
                                        <div class="col-sm-8">
											<div class="input-group col-sm-12">
												<input type="text" name="nik" id="nik" class="form-control" value="<?php echo $row['nik'];?>" maxlength="16"
														required="required" autocomplete="off" placeholder="Nomor Induk Kependudukan"/>
												<select id="jk" name="jk" class="selectpicker"
                                                            data-style="btn-gray"
                                                            data-width="auto">
                                                        <option value="<?php echo $row['jk'];?>"><?php echo $row['jk'];?></option>
                                                        <option value="L">L</option>
                                                        <option value="P">P</option>
													</select>
											</div>
										</div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Nama Lengkap</label>
                                        <div class="col-sm-4"><input type="text" name="namadepan" id="namadepan" class="form-control" value="<?php echo $row['namadepan'];?>"
										required="required" autocomplete="off" placeholder="Nama Depan"> </div>
										<div class="col-sm-4"><input value="<?php echo $row['namabelakang'];?>" id="namabelakang" name="namabelakang" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Nama Belakang"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Inisial</label>
                                        <div class="col-sm-2"><input type="text" name="ins" id="ins" class="form-control" value="<?php echo $row['ins'];?>" maxlength="2"
										required="required" autocomplete="off" placeholder="Inisial"> </div>
										<div class="col-sm-6 fs-sm">Inisial sebagai kode penanggungjawab transaksi ataupun input data, gunakan 2 karakter, bisa huruf bisa angka.</div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Tempat, Tanggal Lahir</label>
                                        <div class="col-sm-4"><input value="<?php echo $row['tempat_lahir'];?>" id="tempat_lahir" name="tempat_lahir" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Tempat Lahir"> </div>
										<div class="col-sm-4"><input value="<?php echo $row['tgl_lahir'];?>" id="tgl_lahir" name="tgl_lahir" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Tanggal Lahir"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Alamat</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['alamat'];?>" id="alamat" name="alamat" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Alamat"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Phone</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['hp'];?>" id="hp" name="hp" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Nomor Telpon"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Pendidikan</label>
										<div class="col-sm-8">
                                        <select data-placeholder="Pendidikan" id="pendidikan" name="pendidikan"
                                                data-width="auto"
                                                data-minimum-results-for-search="10"
                                                tabindex="-1"
                                                class="select2 form-control" id="default-select">
                                            <option value="<?php echo $row['pendidikan'];?>"><?php echo "$jab[deskripsi_p] ($jab[tingkat])";?></option>
                                            <?php
											$data=mysql_query("select * from pendidikan");
												while($dat=mysql_fetch_array($data)){
											echo "
											<option value='$dat[id]'>$dat[deskripsi_p] ($dat[tingkat])</option> ";
                                            } ?>
                                        </select>
                                    </div>
									</div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Menjabat Sejak</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['sejak'];?>" id="sejak" name="sejak" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Menjabat Sejak"> </div>
                                    </div>
									
							</fieldset>
							<div class="form-actions">
                                <button href="#tab12"  data-toggle="tab" class="btn btn-inverse btn-rounded pull-right" id="SimpanEditData"><i class="fa fa-recycle"></i> Ubah Data</button>
                                <a href="#tab12"  data-toggle="tab" class="btn btn-default btn-rounded">Cancel</a>
                            </div>
							</div>
                        </div>
						
                    </div>
                </div>
            </div>
        </div>