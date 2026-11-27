<?php session_start(); ?>

        <script type="text/javascript">

	function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
		
			function deleteKelompok(ID) {
				var idk	= ID;
			   var pilih = confirm('Apakah anda yakin akan menghapus Kelompok '+idk+ '?');
				if (pilih==true) {
					$.ajax({
						type	: "POST",
						url		: "modul/kelompok/hapus.php",
						data	: "idk="+idk,
						success	: function(data){
							window.location.href='m.php?p=k';
						}
					});
				}
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
					
				$("#TampilBimbingan").load('modul/kelompok/tampil_bimbingan.php');
				$("#TampilDataPinjaman").load('modul/kelompok/tampil_pinjaman.php');
				$("#TampilDataKelompok").load('modul/kelompok/tampil_data.php');
				$("#TampilUname").load('modul/kelompok/tampil_uname.php');
				$("#TampilDomisili").load('modul/kelompok/tampil_domisili.php');
				$("#EditDataKelompok").load('modul/kelompok/edit_data_kelompok.php');
                
				$("#SimpanBimbingan").click(function() {
                    var tgl_kunjungan = $('#tgl_kunjungan').val();
                    var hasil_kunjungan = $('#hasil_kunjungan').val();
					
					if(hasil_kunjungan.length==0){ $("#DilarangKosong").load('modul/kelompok/dilarang.php'); $("#hasil_kunjungan").focus(); return false; }
					
                    $.ajax({
                        type: "POST",
                        url: "modul/kelompok/simpan_bimbingan.php",
                        data: "tgl_kunjungan="+tgl_kunjungan+
								"&hasil_kunjungan="+hasil_kunjungan,
                        success: function(data) {
                            $("#TampilBimbingan").load('modul/kelompok/tampil_bimbingan.php');
                        }
                    });
                });
				
				$("#SimpanDomisiliKelompok").click(function() {
                    var alamatnew = $('#alamatnew').val();
                    var desanew = $('#desanew').val();
						if(alamatnew.length==0){
						alert('Silahkan isikan alamat baru Anda!');
						$("#alamatnew").focus();
						return false;
							}
                    $.ajax({
                        type: "POST",
                        url: "modul/kelompok/simpan_domisili.php",
                        data: "alamatnew="+alamatnew+
								"&desanew="+desanew,
                        success: function(data) {
                            $("#TampilDomisili").load('modul/kelompok/tampil_domisili.php');
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
                        url: "modul/kelompok/simpan_uname.php",
                        data: "unamenew="+unamenew,
                        success: function(data) {
                            $("#TampilUname").load('modul/kelompok/tampil_uname.php');
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
                        url: "modul/kelompok/simpan_password.php",
                        data:  "passnew2="+passnew2,
                        success: function(data) {
                            alert('Password berhasil diubah!');
                        }
                    });
                });	
				
				
            });
		
		
		function EditKelompok(ID){
			var id = ID;
			$.ajax({
				type	: "POST",
				url		: "modul/kelompok/edit_data_kelompok.php",
				data	: "id="+id,			  
				success	: function(data){
					$('#EditDataKelompok').html(data);
					
				}
			});
			
		}
	
        </script>

<?php 
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
$_SESSION['ida']=$row['id'];
	$onl=$row['online']; if ($onl=="Y") { $ston="Online"; $lbon="label-success";}else{ $ston="Offline"; $lbon="label-default";}
	$nl=$row['nilai']; if ($nl=="1") { $nil="Up"; $lbl="fa-thumbs-up";}else{ $nil="Down"; $lbl="fa-thumbs-down";}
	
	
?>
<div class="animated fadeInDown">
	<h4 class="page-title hidden-print">#<?php echo $row['kd_kelompok'];?><span class="fw-semi-bold"> <?php echo strtoupper($row['nama_kelompok']);?></span> 
	<span class="fw-semi-bold pull-right"><a href="#tabk12" data-toggle="tab"><i class="glyphicon glyphicon-arrow-left"></i> back</a></span></h4>
	<p class="mt-n-md"> Alamat : <?php echo "$row[alamat_kelompok] $row[nama_desa] Telp.$row[telpon]";?></p> 
	
		<div class="row">
			<div class="col-md-12">
                <div class="tabbable tabs-left mb-lg">
                    <ul id="tabs2" class="nav nav-tabs hidden-print">
                        <li class="active"><a href="#tab14" data-toggle="tab"><i class="fa fa-credit-card"></i> Kartu Kelompok</a></li>
                        <li class=""><a href="#tab24" data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Identitas Kelompok</a></li>
                        <li class=""><a href="#tab104" data-toggle="tab"><i class="glyphicon glyphicon-pencil"></i> Catatan Bimbingan</a></li>
                        <li class=""><a href="#tab34" data-toggle="tab"><i class="fa fa-download"></i> Simpanan</a></li>
                        <li class=""><a href="#tab44" data-toggle="tab"><i class="fa fa-history"></i> Riwayat Pinjaman</a></li>
                        <li class=""><a href="#tab54" data-toggle="tab"><i class="fa fa-recycle"></i> Mutasi Domisili</a></li>
                        <li class=""><a href="#tab64" data-toggle="tab"><i class="fa fa-globe"></i> Data Online</a></li>
                        <li class=""><a href="#tab74"  data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Username</a></li>
                        <li class=""><a href="#tab84"  data-toggle="tab"><i class="fa fa-key"></i> Password</a></li>
                        <li class=""><a href="#tabX"  data-toggle="tab"><i class="fa fa-times"></i> Hapus</a></li>
                    </ul>
                    <div id="tabs3c" class="tab-content">
					
						<div class="tab-pane active" id="tab14">
							<div class="row">
									<div class="col-md-7">
							<section class="widget">
								
								<div class="widget-body">
									<div class="widget-top-overflow windget-padding-md clearfix bg-primary text-white">
												<h3 class="mt-n-xs"><span class="fw-semi-bold">Kartu Kelompok</span></h3>
												<p class="mt-n-sm mb-n-xs"><span class="fw-semi-bold">ID. <?php echo $row['kd_kelompok'];?></span></p>
											</div>
									
										<p class="post-links mb-sm">
										<table>
											<tr><td width="45%">Kelompok</td><td> : </td><td width="50%"><?php echo $row['nama_kelompok'];?></td></tr>
											<tr><td>Nama Ketua</td><td> : </td><td><?php echo $row['ketua'];?></td></tr>
											<tr><td>Tgl Berdiri</td><td> : </td><td><?php echo tgl_indo($row['tgl_berdiri']);?></td></tr>
											<tr><td>Alamat</td><td> : </td><td><?php echo $row['alamat_kelompok'];?></td></tr>
											<tr><td>Desa</td><td> : </td><td><?php echo $row['nama_desa'];?></td></tr>
											<tr><td colspan="3"><img src="images/barcode.png"></td></tr>
											<tr><td colspan="3">&nbsp;</td></tr>
										</table>
										</p>
										<div class="post-user mt-n-xlg mb-n-lg ml-n-sm text-align-left">
											<span class="thumb-lg">
												<img class="img-circle" src="images/fav.png" alt="...">
											</span>
										</div>
								</div>
								<footer class="widget-bottom-overflow bg-primary" style="border-top: 8px #999 solid !important; margin-top:-20px;">
									<p class="post-links mt-n-sm text-center">Diterbitkan oleh: UPK Kecamatan <?php echo $row['nama_kec'];?>
									</p>
								</footer>
								<a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/KKel.php?rcp=<?php echo $row['kd_kelompok'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" class="btn btn-danger mt-xlg pull-right hidden-print"><i class="glyphicon glyphicon-print"></i> Cetak Kartu</a>
								<a href="#tab94"  data-toggle="tab" class="btn btn-danger mt-xlg hidden-print"><i class="fa fa-recycle"></i> Ubah Data</a>
							</section>
							</div></div>
							
                        </div>

						<div class="tab-pane" id="tab24">
							<header>
								<legend><i class="fa fa-users"></i> Identitas Kelompok
								<span class="pull-right">
									<?php
									echo "<a href='#tab94' onclick='javascript:EditKelompok($row[id])' data-toggle='tab' class='btn btn-danger mt-n-md'><i class='fa fa-recycle'></i> Ubah Data Kelompok</a>";
									?>
								</span>
								</legend>
							</header>
								<div id="TampilDataKelompok"></div>
                        </div>
						
						
						<div class="tab-pane" id="tab34">
							<header>
								<legend><i class="fa fa-download"></i> Simpanan</legend>
							</header>
                            
							<p>Modul Simpanan belum tersedia!
							</p>
                        </div>
						
						<div class="tab-pane" id="tab44">
							<header>
								<legend><i class="fa fa-history"></i> Riwayat Pinjaman
									<span class="fs-mini text-muted pull-right">Klik untuk detail Pinjaman &nbsp;
									<?php
									$dpp=mysql_query("select * from jenis_produk_pinjaman Where
																	lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
																	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%'");
										while($pp=mysql_fetch_array($dpp)){
										echo "<i class='fa fa-square text-$pp[warna_jpp]'></i> $pp[nama_jpp] &nbsp&nbsp";
										}
									?>
									</span>
								</legend>
							</header>
                            <div id="TampilDataPinjaman"></div>
                        </div>
						
						<div class="tab-pane" id="tab54">
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
                                        <div class="col-sm-8"><input type="text" name="alamatnew" class="form-control" id="alamatnew" value="<?php echo $row['alamat_kelompok'];?>"
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
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanDomisiliKelompok"><i class="fa fa-recycle"></i> Ubah Domisili</button>
                                <label></label>
                            </div>
							</div>
                        </div>
						
                        <div class="tab-pane" id="tab64">
                            <header>
								<legend><i class="fa fa-globe"></i> Data Online</legend>
							</header>
							<div><div class="col-sm-5">Status Online</div><label class="col-sm-7">: <?php echo "<span class='label $lbon'>$ston</span>";?></label></div>
                            <div><div class="col-sm-5">Last Login</div><label class="col-sm-7">: <?php echo $row['lo'];?></label></div>
                            <div><div class="col-sm-5">Jumlah Kunjungan</div><label class="col-sm-7">: <?php echo number_format($row['kunjungan']);?> kali</label></div>
                            <div><div class="col-sm-5">Penilaian Sistem</div><label class="col-sm-7">: <?php echo "<i class='fa $lbl'></i> $nil";?></label></div>
                        </div>
						
                        <div class="tab-pane" id="tab74">
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
						
						<div class="tab-pane" id="tab84">
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
						
						<div class="tab-pane" id="tabX">
							<legend>
								<i class="fa fa-times"></i> Konfirmasi Hapus Kelompok
							</legend>
							<div class="col-sm-3">
							</div>
							<div class="form-actions col-sm-6 mt-n-md">
								
								<?php
								$gr=mysql_query("select * from pinjaman_kelompok_$_SESSION[kd_kab] WHERE id_kel='$row[id]'");
									$group	=mysql_num_rows($gr);
									if ($group > 0){
										
										echo "Maaf anda tidak dapat menghapus kelompok ini, kelompok terdeteksi memiliki riwayat pinjaman<br>";
										
										while($rpk=mysql_fetch_array($gr)){ 
											echo "$rpk[id] | ".number_format($rpk['alokasi'])." | $rpk[status]<br>";
										}
										
								 }else{ ?>
								<p class="text-justify">
								Fitur ini dapat Anda gunakan jika Anda akan menghapus data Kelompok<br>
								Dengan klik tombol "YA" maka Kelompok akan hilang dari data base<br>
								Apakah anda akan menghapus Kelompok ini?
								</p>
								<a href="#tab14" data-toggle="tab" class="btn btn-default btn-rounded pull-right">Kembali</a>
								<?php echo "<a href='javascript:deleteKelompok(\"{$row['id']}\")' class='btn btn-inverse btn-rounded'><i class='fa fa-times'></i>  Ya, Hapus Kelompok</a>"; ?>
								<?php } ?>
							</div>
							<div class="col-sm-3">
							</div>
						</div>
						
						<div class="tab-pane" id="tab94">
							<header>
								<legend><i class="fa fa-edit"></i> Edit Identitas Kelompok</legend>
							</header>
								<div id="EditDataKelompok"></div>
                        </div>
						
						<div class="tab-pane" id="tab104">
							<header>
								<legend><i class="glyphicon glyphicon-pencil"></i> Catatan Bimbingan</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
								<div class="col-md-8">
									<div class="form-group">
										<label class="fs-sm mb-0">Catatan Hasil Kunjungan/Bimbingan</label>
											<textarea rows="4" class="form-control" name="hasil_kunjungan" id="hasil_kunjungan"
											autocomplete="off" placeholder="Tuliskan Hasil Kunjungan/Bimbingan anda untuk kelompok <?php echo $row['nama_kelompok'];?>..."></textarea>
									</div>
								</div>
								<div class="col-md-1">
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="fs-sm mb-0">Tanggal Kunjungan/Bimbingan</label>
											<input type="text" class="form-control" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo date('Y-m-d');?>"
											autocomplete="off" placeholder="Tanggal Kunjungan"/>
										<label class="fs-sm">Visitors: <?php $kel=$_SESSION['jk']; 
											if($kel=="L") { $jk="Mr."; }else{ $jk="Mrs."; } echo "$jk";?>
											<strong> <?php echo "$_SESSION[namadepan]";?></strong> <?php echo "$_SESSION[namabelakang]";?></label>
									</div>
									<div id="DilarangKosong"></div>
									<button class="btn btn-inverse btn-rounded" id="SimpanBimbingan"><i class="glyphicon glyphicon-cloud"></i> Simpan</button>
									<a href="javascript:;" onclick="MM_openBrWindow('modul/kelompok/c_CB.php?id=<?php echo $row['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" class="btn btn-danger pull-right"><i class="glyphicon glyphicon-print"></i> Cetak</a>
								</div>
							</fieldset>
							<div id="TampilBimbingan"></div>
							</div>
                        </div>
						
                    </div>
                </div>
            </div>
        </div>
</div>