<?php session_start(); ?>
 <script type="text/javascript" src="js/jquery-1.2.3.min.js"></script>
        <script type="text/javascript">
	
			
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
				$("#EditDataKelompok").load('modul/kelompok/edit_data_kelompok.php');
               
				
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
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_thumb.php";
$id	= $_SESSION['id'];
$row=mysql_fetch_array(mysql_query("select * from kecamatan kc, desa d, jenis_produk_pinjaman jpp, jenis_usaha ju, jenis_kegiatan jk, tingkat_kelompok tk,
																fungsi_kelompok fgs, users u, sistem_angsuran sa, kelompok_$_SESSION[kd_kab] k
																WHERE
																kc.id=k.lokasi AND d.id=k.desa AND jpp.id=k.jenis_produk_pinjaman AND ju.id=k.jenis_usaha AND 			
																jk.id=k.jenis_kegiatan AND tk.id=k.tingkat_kelompok AND fgs.id=k.fungsi_kelompok AND u.id=k.id_user AND 
																k.id='$id'"));
$_SESSION['ida']=$row['id'];
	$onl=$row['online']; if ($onl=="Y") { $ston="Online"; $lbon="label-success";}else{ $ston="Offline"; $lbon="label-default";}
	$nl=$row['nilai']; if ($nl=="1") { $nil="Up"; $lbl="fa-thumbs-up";}else{ $nil="Down"; $lbl="fa-thumbs-down";}

//Untuk memanggil tampil_pinjaman	
$jum_pinj=mysql_num_rows(mysql_query("select * from kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk WHERE k.id=pk.id_kel AND k.id='$id' "));
$_SESSION['jum_pinj']=$jum_pinj;	
?>
<div class="animated fadeInDown">
		<div class="row">
			<div class="col-md-12">
                <div class="tabbable tabs-left mb-lg">
                    <ul id="tabs2" class="nav nav-tabs hidden-print">
                        <li class="active"><a href="#tab14" data-toggle="tab"><i class="fa fa-credit-card"></i> Kartu Kelompok~</a></li>
                        <li class=""><a href="#tab24" data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Identitas Kelompok</a></li>
                        <li class=""><a href="#tab104" data-toggle="tab"><i class="glyphicon glyphicon-pencil"></i> Catatan Bimbingan</a></li>
                        <li class=""><a href="#tab34" data-toggle="tab"><i class="fa fa-download"></i> Simpanan</a></li>
                        <li class=""><a href="#tab44" data-toggle="tab"><i class="fa fa-history"></i> Riwayat Pinjaman</a></li>
                        <li class=""><a href="#tab64" data-toggle="tab"><i class="fa fa-globe"></i> Data Online</a></li>
                        <li class=""><a href="#tab74"  data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Username</a></li>
                        <li class=""><a href="#tab84"  data-toggle="tab"><i class="fa fa-key"></i> Password</a></li>
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
								<a class="btn btn-danger mt-xlg pull-right hidden-print" id="print"><i class="glyphicon glyphicon-print"></i> Cetak Kartu</a>
								<a href="#tab94"  data-toggle="tab" class="btn btn-danger mt-xlg hidden-print"><i class="fa fa-recycle"></i> Ubah Data</a>
							</section>
							</div></div>
							
                        </div>

						<div class="tab-pane" id="tab24">
							<header>
								<legend><i class="fa fa-users"></i> Identitas Kelompok
								<span class="pull-right">
									
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
							<div id="TampilBimbingan"></div>
							</div>
                        </div>
						
                    </div>
                </div>
            </div>
        </div>
</div>