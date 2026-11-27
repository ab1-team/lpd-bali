<?php session_start(); ?>

        <script type="text/javascript">
		function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
				
			$(document).ready(function() {
			
			$(function(){ //PRINT
				function pageLoad(){
					$('#print').click(function(){
						window.print();
					})
				}
				pageLoad();
				SingApp.onPageLoad(pageLoad);
			});

			$("#nik").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
					
				$("#TampilDataAnggota").load('modul/penduduk/detail/tampil_data.php');
				$("#TampilUname").load('modul/penduduk/detail/tampil_uname.php');
				$("#TampilDataPinjaman").load('modul/penduduk/detail/tampil_pinjaman.php');
				$("#TampilPass").load('modul/penduduk/detail/tampil_password.php');
				$("#TampilDomisili").load('modul/penduduk/detail/tampil_domisili.php');
                
				$("#SimpanDomisili").click(function() {
                    var alamatnew = $('#alamatnew').val();
                    var desanew = $('#desanew').val();
						if(alamatnew.length==0){
						alert('Silahkan isikan alamat baru Anda!');
						$("#alamatnew").focus();
						return false;
							}
                    $.ajax({
                        type: "POST",
                        url: "modul/penduduk/detail/simpan_domisili.php",
                        data: "alamatnew="+alamatnew+
								"&desanew="+desanew,
                        success: function(data) {
                            $("#TampilDomisili").load('modul/penduduk/detail/tampil_domisili.php');
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
                        url: "modul/penduduk/detail/simpan_uname.php",
                        data: "unamenew="+unamenew,
                        success: function(data) {
                            $("#TampilUname").load('modul/penduduk/detail/tampil_uname.php');
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
                        url: "modul/penduduk/detail/simpan_password.php",
                        data:  "passnew2="+passnew2,
                        success: function(data) {
                            $("#TampilPass").load('modul/penduduk/detail/tampil_password.php');
                        }
                    });
                });	
				
				$("#SimpanEditAngg").click(function() {
					var nik 		= $('#nika').val();
                    var namadepan	= $('#namadepana').val();
                    var jk			= $('#jka').val();
                    var tempat_lahir = $('#tempat_lahira').val();
                    var tgl_lahir 	= $('#tgl_lahira').val();
                    var alamat 		= $('#alamata').val();
                    var hp 			= $('#hpa').val();
                    var kk 			= $('#kka').val();
                    var penjamin	= $('#penjamina').val();
                    var hubungan	= $('#hubungana').val();
                    var usaha		= $('#usahaa').val();
			
					if(nik.length==0){
						alert('Silahkan isikan nik baru Anda!');
						$("#nika").focus();
						return false;
							}
                    $.ajax({
                        type: "POST",
                        url: "modul/penduduk/detail/simpan_data.php",
                        data:"nik="+nik+
								"&namadepan="+namadepan+
								"&jk="+jk+
								"&tempat_lahir="+tempat_lahir+
								"&tgl_lahir="+tgl_lahir+
								"&alamat="+alamat+
								"&hp="+hp+
								"&kk="+kk+
								"&penjamin="+penjamin+
								"&hubungan="+hubungan+
								"&usaha="+usaha,
                        
						success: function(data) {
                            $("#TampilDataAnggota").load('modul/penduduk/detail/tampil_data.php');
                        }
                    });
                });
				
				$("#UploadFoto").click(function() {
                    var foto = $('#foto').val();
						
                    $.ajax({
                        type: "POST",
                        data:"foto="+foto,
                        
						success: function(data) {
                            alert('berhasil!');
                        }
                    });
                });
				
            });
			

        </script>

<?php 
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_thumb.php";
$id	= $_POST['id'];
$row=mysql_fetch_array(mysql_query("select * from kecamatan c, keluarga k, usaha u, anggota_$_SESSION[kd_kab] a where u.id=a.usaha AND k.id=a.hubungan AND c.id=a.lokasi AND a.id='$id'"));
$_SESSION['ida']=$row['id'];
	$onl=$row['online']; if ($onl=="Y") { $ston="Online"; $lbon="label-success";}else{ $ston="Offline"; $lbon="label-default";}
	$nl=$row['nilai']; if ($nl=="1") { $nil="Up"; $lbl="fa-thumbs-up";}else{ $nil="Down"; $lbl="fa-thumbs-down";}
	

//UPLOAD FOTO

$table	="penduduk";
$ida	= $_SESSION['ida'];

$nama_file = $_FILES['fotoa']['name'];
$file_ext = substr($nama_file, strripos($nama_file, '.')); // strip name
$newfilename = $ida . $file_ext;
$status = FALSE;

	if(!empty($_FILES['fotoa']['tmp_name']) && ($file_ext == ".jpg" || $file_ext == ".png"))
	{
		$upload = move_uploaded_file($_FILES['fotoa']['tmp_name'], 'foto_anggota/'.$newfilename);
		if($upload)
		{
			UploadImage_anggota($newfilename);
			$input	= "UPDATE $table SET 	foto='$newfilename'
					WHERE id= '$ida'";
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
	<h4 class="page-title hidden-print">#<?php echo $row['nik'];?><span class="fw-semi-bold"> <?php echo $row['namadepan'];?></span>
	<span class="fw-semi-bold pull-right"><a href="#tab1" data-toggle="tab"><i class="glyphicon glyphicon-arrow-left"></i> back</a></span></h4>
	<p class="mt-n-md"> Alamat : <?php echo "$row[alamat] Telp.$row[telpon]";?></p> 
	
		<div class="row">
			<div class="col-md">
                <div class="tabbable tabs-left mb-lg">
                    <ul id="tabs2" class="nav nav-tabs hidden-print">
                        <li class="active"><a href="#tab13" data-toggle="tab"><i class="fa fa-credit-card"></i> Kartu penduduk</a></li>
                        <li class=""><a href="#tab23" data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Identitas penduduk</a></li>
                        <li class=""><a href="#tab43" data-toggle="tab"><i class="fa fa-download"></i> Simpanan</a></li>
                        <li class=""><a href="#tab53" data-toggle="tab"><i class="fa fa-upload"></i> Riwayat Pinjaman</a></li>
                        <li class=""><a href="#tab03" data-toggle="tab"><i class="fa fa-recycle"></i> Mutasi Domisili</a></li>
                        <!--<li class=""><a href="#tab63" data-toggle="tab"><i class="fa fa-globe"></i> Data Online</a></li>-->
                        <!--<li class=""><a href="#tab73"  data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Username</a></li>-->
                        <!--<li class=""><a href="#tab83"  data-toggle="tab"><i class="fa fa-key"></i> Password</a></li>-->
                    </ul>
                    <div id="tabs3c" class="tab-content">
					
						<div class="tab-pane active" id="tab13">
							<section class="widget">
								<div class="widget-body">
									<div class="widget-top-overflow windget-padding-md clearfix bg-primary text-white">
												<h3 class="mt-n-xs"><span class="fw-semi-bold">Kartu penduduk</span> (Member Card)</h3>
												<p class="mt-n-sm mb-n-xs"><span class="fw-semi-bold">NIK. <?php echo $row[nik];?></span></p>
											</div>
									
										<p class="post-links mb-sm">
										<table class="fw-semi-bold">
											<tr>
												<td rowspan="6">
													<div class="fileinput-new thumbnail mr-md" style="width: 130px; height:130px;">
														<?php
														$foto=$row['foto'];
														if (empty($foto)) {
															echo "<img src='images/user.png' alt='...'>";
															}else{
															echo "<img alt='...' src='foto_anggota/$foto'>";
															}
														?>
													</div>
												</td>
												<td width="15%">Nama</td><td> : </td><td><?php echo $row['namadepan'];?></td></tr>
											<tr><td>TTL</td><td> : </td><td><?php echo $row['tempat_lahir'];?>, <?php echo tgl_ind($row['tgl_lahir']);?></td></tr>
											<tr><td>Alamat</td><td> : </td><td><?php echo $row['alamat'];?></td></tr>
											<tr><td>Reg.</td><td> : </td><td><?php echo tgl_indo($row['terdaftar']);?></td></tr>
											<tr><td colspan="3"><img src="images/barcode.png"></td></tr>
											<tr><td colspan="3">&nbsp;</td></tr>
										</table>
										</p>
										<div class="post-user mt-n-xlg mb-n-lg ml-n-sm text-align-left">
											<span class="thumb-lg">
												<?php
													 $kec=mysql_fetch_array(mysql_query("select * from kecamatan where id='$_SESSION[lokasi]' ")); 
													 $logo=$kec['logo'];
													if (empty($logo)) {
													echo "<img class='img-circle' alt='...' src='images/fav.png' >";
													}else{
													echo "<img class='img-circle' alt='...' src='images/logo/$logo' >";
													}
												?>
											</span>
										</div>
								</div>
								<footer class="widget-bottom-overflow bg-primary" style="border-top: 8px #999 solid !important; margin-top:-20px;">
									<p class="post-links mt-n-sm text-center">Diterbitkan oleh: UPK Kecamatan <?php echo $row['nama_kec'];?>
									</p>
								</footer>
								<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/KAngg.php?rcp=<?php echo $row['nik'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" class="btn btn-danger mt-xlg pull-right hidden-print"><i class="glyphicon glyphicon-print"></i> Cetak Kartu</a>
							</section>
                        </div>

						<div class="tab-pane" id="tab23">
							<header>
								<legend><i class="glyphicon glyphicon-user"></i> Identitas penduduk</legend>
							</header>
                            <div id="TampilDataAnggota"></div>
                        </div>
						
						
						
						<div class="tab-pane" id="tab43">
							<header>
								<legend><i class="fa fa-download"></i> Simpanan</legend>
							</header>
                            <p>Modul Simpanan Belum Tersedia!</p>
                        </div>
						
						<div class="tab-pane" id="tab53">
						<header>
								<legend><i class="fa fa-history"></i> Riwayat Pinjaman
								</legend>
							</header>
                            <div id="TampilDataPinjaman"></div>
                        </div>
						
						<div class="tab-pane" id="tab03">
							<header>
								<legend><i class="fa fa-recycle"></i> Mutasi Domisili</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>

                                    <div id="TampilDomisili"></div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Domisili Baru</label>
                                        <div class="col-sm-8"><input type="text" name="alamatnew" class="form-control" id="alamatnew" value="<?php echo $row['alamat'];?>"
										required="required" autocomplete="off" placeholder="Alamat / Domisili Baru (Dusun/RT/RW)"> </div>
                                    </div>
									<div class="form-group">
                                    <label class="col-sm-4 control-label" for="desanew"></label>
                                    <div class="col-sm-8">
											<select id="desanew"  name="desanew"
                                                data-placeholder="Desa/Kelurahan"
                                                class="select2 form-control"
                                                tabindex="-1">
													<?php 
													$des=mysql_fetch_array(mysql_query("select * from desa where id='$row[desa]'"));
														echo "<option value='$row[desa]'>$des[nama_desa]</option>";
													
													$kec=mysql_fetch_array(mysql_query("select * from users u, kecamatan k where u.lokasi=k.id and u.lokasi='$row[lokasi]'"));
													$view=mysql_query("select * from desa where kd_kec='$kec[kd_kec]' order by kd_desa asc"); //DESA
														while($rows=mysql_fetch_array($view)){
														echo "<option value='$rows[id]'>$rows[nama_desa]</option>";
														} ?>
											</select>
										</div>
									</div>
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanDomisili"><i class="fa fa-recycle"></i> Ubah Domisili</button>
                                <label></label>
                            </div>
							</div>
                        </div>
						
                        <div class="tab-pane" id="tab63">
                            <header>
								<legend><i class="fa fa-globe"></i> Data Online</legend>
							</header>
							<div><div class="col-sm-4">Status Online</div><label class="col-sm-8">: <?php echo "<span class='label $lbon'>$ston</span>";?></label></div>
                            <div><div class="col-sm-4">Last Login</div><label class="col-sm-8">: <?php echo $row['lo'];?></label></div>
                            <div><div class="col-sm-4">Jumlah Kunjungan</div><label class="col-sm-8">: <?php echo number_format($row['kunjungan']);?> kali</label></div>
                            <div><div class="col-sm-4">Penilaian Sistem</div><label class="col-sm-8">: <?php echo "<i class='fa $lbl'></i> $nil";?></label></div>
                        </div>
						
                        <div class="tab-pane" id="tab73">
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
						
						<div class="tab-pane" id="tab83">
							<header>
								<legend><i class="fa fa-key"></i> Password</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div id="TampilPass"></div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Password Baru</label>
                                        <div class="col-sm-8"><input type="text" name="passnew1" class="form-control" id="passnew1"
										required="required" autocomplete="off" placeholder="Password Baru"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Password Baru*</label>
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
						
						<div class="tab-pane" id="tab93">
							<header>
								<legend><i class="fa fa-edit"></i> Edit Identitas penduduk</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="form-group">
                                        <label class="control-label col-sm-4">N I K / J K</label>
                                        <div class="col-sm-8">
											<div class="input-group col-sm-12">
												<input type="text" value="<?php echo $row['nik'];?>" name="nika" id="nika" class="form-control"  maxlength="16"
														required="required" autocomplete="off" placeholder="Nomor Induk Kependudukan"/>
												<select id="jka" name="jka" class="selectpicker"
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
                                        <div class="col-sm-8"><input type="text" name="namadepana" id="namadepana" class="form-control" value="<?php echo $row['namadepan'];?>"
										required="required" autocomplete="off" placeholder="Nama Depan"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Tempat, Tgl Lahir</label>
                                        <div class="col-sm-4"><input value="<?php echo $row['tempat_lahir'];?>" id="tempat_lahira" name="tempat_lahira" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Tempat Lahir"> </div>
										<div class="col-sm-4"><input value="<?php echo $row['tgl_lahir'];?>" id="tgl_lahira" name="tgl_lahira" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Tanggal Lahir"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Alamat</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['alamat'];?>" id="alamata" name="alamata" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Alamat"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Phone</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['hp'];?>" id="hpa" name="hpa" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Nomor Telpon"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Nomor KK</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['kk'];?>" id="kka" name="kka" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Nomor KK"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Penjamin</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['penjamin'];?>" id="penjamina" name="penjamina" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Penjamin"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Kekeluargaan</label>
                                        <div class="col-sm-8">
										<select id="hubungana" name="hubungana" class="selectpicker"
                                                            data-style="btn-gray"
                                                            data-width="auto">
		
                                                        <?php 
														echo "<option value='$row[hubungan]'>$row[kekeluargaan]</option>";
													$data=mysql_query("select * from keluarga order by id asc"); //KELUARGA
														while($rows=mysql_fetch_array($data)){
														echo "<option value='$rows[id]'>$rows[kekeluargaan]</option>";
														} ?>
													</select>
										</div>
                                    </div>
									
									<div class="form-group">
                                        <label class="control-label col-sm-4">Nama/Jenis Usaha</label>
                                        <div class="col-sm-8">
										<select id="usahaa" name="usahaa" class="selectpicker"
                                                            data-style="btn-gray"
                                                            data-width="auto">
		
                                                        <?php 
														echo "<option value='$row[usaha]'>$row[nama_usaha]</option>";
													$data=mysql_query("select * from usaha order by nama_usaha asc"); //KELUARGA
														while($rows=mysql_fetch_array($data)){
														echo "<option value='$rows[id]'>$rows[nama_usaha]</option>";
														} ?>
													</select>
										</div>
                                    </div>
							</fieldset>
							<div class="form-actions">
                                <button href="#tab23"  data-toggle="tab" class="btn btn-inverse btn-rounded pull-right" id="SimpanEditAngg"><i class="fa fa-recycle"></i> Ubah Data</button>
                                <a href="#tab23"  data-toggle="tab" class="btn btn-default btn-rounded">Cancel</a>
                            </div>
							</div>
                        </div>
						
                    </div>
                </div>
            </div>
        </div>