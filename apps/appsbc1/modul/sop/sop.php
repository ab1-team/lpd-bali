<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
$row=mysql_fetch_array(mysql_query("SELECT * FROM sebutan_desa sd, desa d WHERE sd.id=d.sebutan AND d.id='$_SESSION[lokasi]' "));
$tgl_pakai=$row['tgl_pakai'];
$bulan_pakai	=substr($tgl_pakai,5,2);
$tahun_pakai	=substr($tgl_pakai,0,4);
?>

        <script type="text/javascript">
			$(document).ready(function() {
				
				$("#SimpanIDLPD").click(function() {
                    var kd_desa = $('#kd_desa').val();
                    var nama_desa = $('#nama_desa').val();
                    var nomor_bh = $('#nomor_bh').val();
                    var alamat_desa = $('#alamat_desa').val();
                    var telpon_desa = $('#telpon_desa').val();
                    var email_desa = $('#email_desa').val();
                    var tagline = $('#tagline').val();
						
                    $.ajax({
                        type: "POST",
                        url: "modul/sop/simpan_idk.php",
                        data:"kd_desa="+kd_desa+
								"&nama_desa="+nama_desa+
								"&nomor_bh="+nomor_bh+
								"&alamat_desa="+alamat_desa+
								"&telpon_desa="+telpon_desa+
								"&email_desa="+email_desa+
								"&tagline="+tagline,
                        
						success: function(data) {
                            $("#Sukses").load('modul/sop/sukses.php');
                        }
                    });
                });
				
				
				$("#SimpanSP").click(function() {
                    var def_jasa = $('#def_jasa').val();
                    var def_jangka = $('#def_jangka').val();
                    var pembulatan = $('#pembulatan').val();
                    var tgl_toleransi = $('#tgl_toleransi').val();
						
                    $.ajax({
                        type: "POST",
                        url: "modul/sop/simpan_sp.php",
                        data:"def_jasa="+def_jasa+
								"&def_jangka="+def_jangka+
								"&pembulatan="+pembulatan+
								"&tgl_toleransi="+tgl_toleransi,
                        
						success: function(data) {
                            $("#SuksesSP").load('modul/sop/sukses.php');
                        }
                    });
                });
				
				
				$("#SimpanSS").click(function() {
                    var def_jasa_tabungan = $('#def_jasa_tabungan').val();
                    var def_jasa_deposito = $('#def_jasa_deposito').val();
						
                    $.ajax({
                        type: "POST",
                        url: "modul/sop/simpan_ss.php",
                        data:"def_jasa_tabungan="+def_jasa_tabungan+
								"&def_jasa_deposito="+def_jasa_deposito,
                        
						success: function(data) {
                            $("#SuksesSS").load('modul/sop/sukses.php');
                        }
                    });
                });

				
            });
			

        </script>

<div class="row">
	<div class="col-md-12 col-md-offset hidden-print">
                <section class="widget" style="border: 1px solid #5d8fc2;">
                    <div class="widget-body">
						<div class="widget-top-overflow windget-padding-md clearfix bg-primary mb">
							<div class="row">
							<div class="col-md-12">
								<span class="h4 fw-bold text-white pull-right">
								<span class="fw-normal">PERSONALISASI </span>  &nbsp; S O P <i class="glyphicon glyphicon-cog"></i> </span>
							</div>
							</div>
						</div>

		<div class="row">
			<div class="col-md-12">
                <div class="tabbable tabs-left mb-lg">
                    <ul id="tabs2" class="nav nav-tabs hidden-print">
                        <li class="active"><a href="#tab38" data-toggle="tab"><i class="fa fa-history"></i> Awal Penggunaan</a></li>
                        <li class=""><a href="#tab28" data-toggle="tab"><i class="fa fa-bank"></i> Identitas Lembaga</a></li>
                        <li class=""><a href="#tab48" data-toggle="tab"><i class="fa fa-gears"></i> Pengaturan Simpanan</a></li>
                        <li class=""><a href="#tab68" data-toggle="tab"><i class="fa fa-gears"></i> Pengaturan Pinjaman</a></li>
                     </ul>
                    <div id="tabs5c" class="tab-content">
						
						<div class="tab-pane" id="tab28">
							<header>
								<legend><i class="fa fa-bank"></i> Identitas Lembaga</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="form-group">
                                        <label class="control-label col-sm-4">ID Server</label>
                                        <div class="col-sm-2">
												<input type="text" name="id" id="id" class="form-control" value="#<?php echo $row['id'];?>"
														required="required" autocomplete="off" placeholder="ID Desa" disabled="disabled"/>
										</div>
										<label class="control-label col-sm-2">Kode Desa</label>
										<div class="col-sm-4">
												<input type="text" name="kd_desa" id="kd_desa" class="form-control" value="<?php echo $row['kd_desa'];?>" maxlength="16"
														required="required" autocomplete="off" placeholder="Kode Desa" disabled="disabled"/>
										</div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Nama Desa</label>
                                        <div class="col-sm-8"><input type="text" name="nama_desa" id="nama_desa" class="form-control" value="<?php echo $row['nama_desa'];?>"
										required="required" autocomplete="off" placeholder="Nama Desa"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Badan Hukum Nomor</label>
                                        <div class="col-sm-8"><input type="text" name="nomor_bh" id="nomor_bh" class="form-control" value="<?php echo $row['nomor_bh'];?>"
										required="required" autocomplete="off" placeholder="Badan Hukum Nomor"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Alamat Lembaga</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['alamat_desa'];?>" id="alamat_desa" name="alamat_desa" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Alamat"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Telpon</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['telpon_desa'];?>" id="telpon_desa" name="telpon_desa" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Telpon"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">E-mail</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['email_desa'];?>" id="email_desa" name="email_desa" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="E-mail"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Tagline</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['tagline'];?>" id="tagline" name="tagline" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Tag Line"> </div>
                                    </div>

									<div id="Sukses"></div>
									
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanIDLPD"><i class="fa fa-recycle"></i> Ubah Data</button>
                                <a href="#" class="btn btn-default btn-rounded" disabled="disabled">Reset</a>
                            </div>
							</div>
                        </div>
						
						<div class="active tab-pane text-align-center" id="tab38">
							<header>
								<legend><p class="h3">Awal Penggunaan</p></legend>
							</header>
							<p>Awal Penggunaan Sistem Informasi Manajemen (SIM) <?php echo LEMBAGA_LONG; ?><br><br>
							<span class="fw-normal h2"><?php echo LEMBAGA_SORT; ?> <?php echo $row['sebutan_desa'];?> <?php echo $row['nama_desa'];?> </span><br>
							<hr>
							ditetapkan sejak tanggal :
							
							<input value="<?php echo tgl_indo($tgl_pakai);?>" type="text" class="form-control text-align-center" disabled="disabled"/>
							<br>Dengan backup dan kondisi laporan keuangan sesuai dengan yang tertera pada menu laporan Awal, yaitu meliputi :<p>
							<ul class="text-list">
								<li>Jurnal Awal status <?php echo getBulan($bulan_pakai-1);?> <?php echo $tahun_pakai;?></li>
								<li>Rekapitulasi Saldo Buku Besar Awal Tahun <?php echo $tahun_pakai;?> ditambah Saldo sampai dengan <?php echo getBulan($bulan_pakai-1);?> <?php echo $tahun_pakai;?></li>
								<li>Laporan Rugi Laba Status <?php echo getBulan($bulan_pakai-1);?> <?php echo $tahun_pakai;?></li>
								<li>Neraca Status <?php echo getBulan($bulan_pakai-1);?> <?php echo $tahun_pakai;?></li>
								<li>Khusus Jurnal Angsuran baik pokok maupun jasa, telah diinputkan dengan jumlah komulatif per kelompok sampai dengan bulan <?php echo getBulan($bulan_pakai-1);?> <?php echo $tahun_pakai; ?></li>
							</ul>
							<p>
							Selanjutnya Pihak <?php echo LEMBAGA_SORT; ?> akan melanjutkan transaksi dengan menggunakan Sistem ini mulai dari transaksi pada tanggal <?php echo tgl_indo($tgl_pakai);?>.<br>
							Demikian keterangan ini dibuat sebagai bukti legal atas migrasi data dari format excel ke Sistem ini, apabila dikemudian hari diminta keterangan dari pihak
							yang berkepentingan maupun auditor kami siap memberikan penjelasan lebih lanjut.<br><br>
							</p>
							<p class="fw-semi-bold pull-right">
							<?php echo $row['nama_desa'];?>, <?php echo tgl_indo($tgl_pakai);?><br>
							Tim Migrasi Data<br>
							<?php echo LEMBAGA_SORT; ?>-Bali
							</p>
                        </div>
						
						<div class="tab-pane" id="tab48">
							<header>
								<legend><i class="fa fa-gears"></i> Pengaturan Simpanan</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="form-group">
                                        <label class="control-label col-sm-3">Default Bunga Simpanan Umum (%)</label>
                                        <div class="col-sm-3"><input type="text" value="<?php echo $row['def_jasa_tabungan'];?>" name="def_jasa_tabungan" id="def_jasa_tabungan" class="form-control" 
										required="required" autocomplete="off" placeholder="Default Bunga Simpanan Umum (%)"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-3">Default Bunga Simpanan Deposito (%)</label>
                                        <div class="col-sm-3"><input type="text" value="<?php echo $row['def_jasa_deposito'];?>" name="def_jasa_deposito" id="def_jasa_deposito" class="form-control" 
										required="required" autocomplete="off" placeholder="Default Bunga Simpanan Deposito (%)"> </div>
                                    </div>

									<div id="SuksesSS"></div>
									
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanSS"><i class="fa fa-recycle"></i> Simpan Data</button>
                                <a href="#" class="btn btn-default btn-rounded" disabled="disabled">Reset</a>
                            </div>
							</div>
                        </div>
						
						<div class="tab-pane" id="tab68">
							<header>
								<legend><i class="fa fa-gears"></i> Pengaturan Pinjaman</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="form-group">
                                        <label class="control-label col-sm-3">Default Jasa (%)</label>
                                        <div class="col-sm-3"><input type="text" value="<?php echo $row['def_jasa'];?>" name="def_jasa" id="def_jasa" class="form-control" 
										required="required" autocomplete="off" placeholder="Prosentase Jasa (%)"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-3">Default Jangka Waktu</label>
                                        <div class="col-sm-3"><input type="text" value="<?php echo $row['def_jangka'];?>" name="def_jangka" id="def_jangka" class="form-control" 
										required="required" autocomplete="off" placeholder="Default Jangka Waktu"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-3">Default Pembulatan</label>
                                        <div class="col-sm-3"><input type="text" value="<?php echo $row['pembulatan'];?>" name="pembulatan" id="pembulatan" class="form-control" 
										required="required" autocomplete="off" placeholder="Default Pembulatan"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-3">Toleransi Tanggal Tagihan</label>
                                        <div class="col-sm-6">
											<select id="tgl_toleransi"  name="tgl_toleransi"
														data-placeholder="Toleransi Tanggal Tagihan"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															$kec1=mysql_fetch_array(mysql_query("select * from desa d, jenis_toleransi jt WHERE d.tgl_toleransi=jt.id_toleransi AND d.id='$_SESSION[lokasi]' "));
															echo "<option value='$kec1[tgl_toleransi]'>-- $kec1[nama_toleransi] --</option>";
															$view2=mysql_query("select * from jenis_toleransi ORDER BY id_toleransi");
																while($rows=mysql_fetch_array($view2)){
																echo "<option value='$rows[id_toleransi]'>$rows[nama_toleransi]</option>";
																} ?>
													</select> 
										</div>
                                    </div>

									<div id="SuksesSP"></div>
									
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanSP"><i class="fa fa-recycle"></i> Simpan Data</button>
                                <a href="#" class="btn btn-default btn-rounded" disabled="disabled">Reset</a>
                            </div>
							</div>
                        </div>
						
			</div>
		</div>
           
		
                    </div>
</div>
                    </div>
                </section>
            </div>
</div>