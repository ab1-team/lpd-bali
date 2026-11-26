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
$nik=$row[nik];
$jab=mysql_fetch_array(mysql_query("select * from jabatan j, level l, kecamatan k, pendidikan p WHERE p.id=$row[pendidikan] and j.id=$row[jabatan] and l.id=$row[level] and k.id=$row[lokasi]"));
	$onl=$row['online']; if ($onl=="Y") { $ston="Online"; $lbon="label-success";}else{ $ston="Offline"; $lbon="label-default";}
	$nl=$row['nilai']; if ($nl=="1") { $nil="Up"; $lbl="fa-thumbs-up";}else{ $nil="Down"; $lbl="fa-thumbs-down";}
	

//UPLOAD FOTO

$table		="users";
$id_user=$_SESSION['id'];

$nama_file = $_FILES['foto']['name'];
$file_ext = substr($nama_file, strripos($nama_file, '.')); // strip name
$newfilename = $id_user . $file_ext;
$status = FALSE;

	if(!empty($_FILES['foto']['tmp_name']) && ($file_ext == ".jpg" || $file_ext == ".png"))
	{
		$upload = move_uploaded_file($_FILES['foto']['tmp_name'], 'foto_users/'.$newfilename);
		if($upload)
		{
			UploadImage_users($newfilename);
			$input	= "UPDATE $table SET 	foto='$newfilename'
					WHERE id= '$id_user'";
			mysql_query($input);

		}else{
		?>
		<script>
			alert('Tidak berhasil melakukan upload');
		</script>
		<?php
		}
	}
	
?>
	<h4 class="page-title"><span class="fw-semi-bold">My</span> Account</h4>
		<div class="row">
			<div class="col-md-8">
                <div class="tabbable tabs-left mb-lg">
                    <ul id="tabs2" class="nav nav-tabs">
                        <li class="active"><a href="#tab72" data-toggle="tab"><i class="fa fa-credit-card"></i> Kartu Pengguna</a></li>
                        <li class=""><a href="#tab12" data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Personal Data</a></li>
						<li class=""><a href="#tab62" data-toggle="tab"><i class="fa fa-camera"></i> Foto</a></li>
                        <li class=""><a href="#tab22" data-toggle="tab"><i class="fa fa-globe"></i> Data Online</a></li>
                        <li class=""><a href="#tab82" data-toggle="tab"><i class="fa fa-quote-left"></i> Quote / Kata Motivasi</a></li>
                        <li class=""><a href="#tab32"  data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Username</a></li>
                        <li class=""><a href="#tab42"  data-toggle="tab"><i class="fa fa-key"></i> Password</a></li>
                    </ul>
                    <div id="tabs2c" class="tab-content">
					
						<div class="tab-pane active" id="tab72">
							<section class="widget">
								<div class="widget-body">
									<div class="widget-top-overflow windget-padding-md clearfix bg-danger text-white">
												<h3 class="mt-sm mb-lg"><span class="fw-semi-bold">Kartu Pengguna</span> (User Card)</h3>
												<h3 class="mt-n-lg mb-md">Sistem Informasi Managemen UPK Online</h3>
											</div>
									<div class="post-user mt-n-lg text-align-right">
										<span class="thumb-lg pull-right ml">
											<img class="img-circle" src="images/fav.png" alt="...">
										</span>
											
									</div>
										<p class="post-links">
										<table>
											<tr>
												<td rowspan="6">
													<div class="fileinput-new thumbnail mr-md" style="width: 130px; height:130px;">
														<?php
														$foto=$row['foto'];
														if (empty($foto)) {
															echo "<img src='images/user.png' alt='...'>";
															}else{
															echo "<img alt='...' src='foto_users/$foto'>";
															}
														?>
													</div>
												</td>
												<td width="30%">Nama Lengkap</td><td> : </td><td><?php echo "$_SESSION[namadepan] $_SESSION[namabelakang]";?></td></tr>
											<tr><td>Jabatan</td><td> : </td><td><?php 
											$jabatan	=$row['jabatan'];
											$level	=$row['level'];
											if($jabatan=="1" AND $level=="1") {$nama_jabatan=$kec['sebutan_level_1'];}
											else if($jabatan=="2" AND $level=="1") {$nama_jabatan=$kec['sebutan_level_2'];}
											else if($jabatan=="3" AND $level=="1") {$nama_jabatan=$kec['sebutan_level_3'];}
											else  {$nama_jabatan=$jab['nama_jabatan'];}
											echo "$nama_jabatan $jab[deskripsi_level]";?></td></tr>
											<tr><td>Lokasi Tugas</td><td> : </td><td><?php echo "$jab[nama_kec]";?></td></tr>
											<tr><td>Member Since</td><td> : </td><td><?php echo tgl_indo($row['sejak']);?></td></tr>
											<tr><td colspan="3"><img src="images/barcode.png"></td></tr>
											<tr><td colspan="3">&nbsp;</td></tr>
										</table>
										</p>
								</div>
								<footer class="widget-bottom-overflow bg-danger" style="border-top: 8px #999 solid !important; margin-top:-20px;">
									<p class="post-links mt-n-sm text-center">Diterbitkan oleh: PT. Asta Brata Teknologi
									</p>
								</footer>
								
							</section>
							<button href="#tab52"  data-toggle="tab" class="btn btn-inverse btn-rounded pull-right"><i class="fa fa-edit"></i> Ubah Data</button>
                                
                        </div>
						
						<div class="tab-pane" id="tab62">
							<header>
								<legend><i class="fa fa-camera"></i> Foto</legend>
							</header>
							<form method="post" enctype="multipart/form-data">
							<div class="col-sm-5">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 200px; height:200px;">
										<?php
										$foto=$row['foto'];
										if (empty($foto)) {
											echo "<img src='images/user.png' alt='...'>";
											}else{
											echo "<img alt='...' src='foto_users/$foto'>";
											}
										?>
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200;"></div>
										<div>
											<span class="btn btn-default btn-file"><span class="fileinput-new">Pilih Foto</span><span class="fileinput-exists">Change</span><input type="file" id="foto" name="foto"></span>
											<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
										</div>
								</div>
							</div>
							<div class="col-sm-7">
								<h4 class="text-center page-title mt-xlg"><span class="fw-semi-bold"><?php echo $_SESSION[namadepan];?></span> <?php echo $_SESSION[namabelakang];?></h4>
								<p class="text-center mt-n-md"><?php echo "$nama_jabatan $jab[nama_level] $jab[nama_kec]";?></p>
								<button class="btn btn-inverse mt-xlg ml-xlg" id="UploadFoto"><i class="fa fa-upload"></i> Upload</button>
							</div>
							</form>
                        </div>
						
						<div class="tab-pane" id="tab12">
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