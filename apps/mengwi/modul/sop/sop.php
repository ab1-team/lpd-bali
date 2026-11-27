<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
$row=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
$tgl_pakai=$row['tgl_pakai'];
$bulan_pakai	=substr($tgl_pakai,5,2);
$tahun_pakai	=substr($tgl_pakai,0,4);
?>

        <script type="text/javascript">
			$(document).ready(function() {
				
				$("#SimpanIDUPK").click(function() {
                    var kd_kec = $('#kd_kec').val();
                    var nama_kec = $('#nama_kec').val();
                    var nomor_bh = $('#nomor_bh').val();
                    var alamat_kec = $('#alamat_kec').val();
                    var telpon_kec = $('#telpon_kec').val();
                    var email_kec = $('#email_kec').val();
                    var web_kec = $('#web_kec').val();
                    var visi_misi = $('#visi_misi').val();
						
                    $.ajax({
                        type: "POST",
                        url: "modul/sop/simpan_idk.php",
                        data:"kd_kec="+kd_kec+
								"&nama_kec="+nama_kec+
								"&nomor_bh="+nomor_bh+
								"&alamat_kec="+alamat_kec+
								"&telpon_kec="+telpon_kec+
								"&email_kec="+email_kec+
								"&web_kec="+web_kec+
								"&visi_misi="+visi_misi,
                        
						success: function(data) {
                            $("#Sukses").load('modul/sop/sukses.php');
                        }
                    });
                });
				
				$("#SimpanJamKerja").click(function() {
                    var jam_masuk = $('#jam_masuk').val();
                    var jam_pulang = $('#jam_pulang').val();
						
                    $.ajax({
                        type: "POST",
                        url: "modul/sop/simpan_jamkerja.php",
                        data:"jam_masuk="+jam_masuk+
								"&jam_pulang="+jam_pulang,
                        
						success: function(data) {
                            $("#SuksesJM").load('modul/sop/sukses.php');
                        }
                    });
                });
				
				$("#SimpanPB").click(function() {
                    var tgl_open = $('#tgl_open').val();
                    var tgl_close = $('#tgl_close').val();
						
                    $.ajax({
                        type: "POST",
                        url: "modul/sop/simpan_pb.php",
                        data:"tgl_open="+tgl_open+
								"&tgl_close="+tgl_close,
                        
						success: function(data) {
                            $("#SuksesPB").load('modul/sop/sukses.php');
                        }
                    });
                });
				
				$("#SimpanSP").click(function() {
                    var def_jasa = $('#def_jasa').val();
                    var def_jangka = $('#def_jangka').val();
                    var pembulatan = $('#pembulatan').val();
                    var iptw        = $('#iptw').val();
                    var tgl_toleransi = $('#tgl_toleransi').val();
						
                    $.ajax({
                        type: "POST",
                        url: "modul/sop/simpan_sp.php",
                        data:"def_jasa="+def_jasa+
								"&def_jangka="+def_jangka+
								"&pembulatan="+pembulatan+
								"&iptw="+iptw+
								"&tgl_toleransi="+tgl_toleransi,
                        
						success: function(data) {
                            $("#SuksesSP").load('modul/sop/sukses.php');
                        }
                    });
                });
				
				$("#SimpanSJ").click(function() {
                    var sebutan_level_1 = $('#sebutan_level_1').val();
                    var sebutan_level_2 = $('#sebutan_level_2').val();
                    var sebutan_level_3 = $('#sebutan_level_3').val();
						
                    $.ajax({
                        type: "POST",
                        url: "modul/sop/simpan_sj.php",
                        data:"sebutan_level_1="+sebutan_level_1+
								"&sebutan_level_2="+sebutan_level_2+
								"&sebutan_level_3="+sebutan_level_3,
                        
						success: function(data) {
                            $("#SuksesSJ").load('modul/sop/sukses.php');
                        }
                    });
                });
				
				
				
				
				
				
				
				
				
				$("#SimpanNA").click(function() {
                    var n_asur 	= $('#n_asur').val();
                    var a_premi = $('#a_premi').val();
                    var j_a = $('#j_a').val();
					var u_max = $('#u_max').val();
						
                    $.ajax({
                        type: "POST",
                        url: "modul/sop/simpan_na.php",
                        data:"n_asur="+n_asur+
								"&a_premi="+a_premi+
								"&u_max="+u_max+
								"&j_a="+j_a,
							//	"$j_a="+j_a,
                        
						success: function(data) {
                            $("#SuksesNA").load('modul/sop/sukses.php');
                        }
                    });
                });
				
				
				
				
				
				
				
				
				
				
				
				$("#SimpanSL").click(function() {
                    var nama_lembaga_sort = $('#nama_lembaga_sort').val();
                    var nama_lembaga_long = $('#nama_lembaga_long').val();
                    var nama_bkad_sort = $('#nama_bkad_sort').val();
                    var nama_bkad_long = $('#nama_bkad_long').val();
                    var nama_bp_sort = $('#nama_bp_sort').val();
                    var nama_bp_long = $('#nama_bp_long').val();
                    var nama_tv_sort = $('#nama_tv_sort').val();
                    var nama_tv_long = $('#nama_tv_long').val();
						
                    $.ajax({
                        type: "POST",
                        url: "modul/sop/simpan_sl.php",
                        data:"nama_lembaga_sort="+nama_lembaga_sort+
								"&nama_lembaga_long="+nama_lembaga_long+
								"&nama_bkad_sort="+nama_bkad_sort+
								"&nama_bkad_long="+nama_bkad_long+
								"&nama_bp_sort="+nama_bp_sort+
								"&nama_bp_long="+nama_bp_long+
								"&nama_tv_sort="+nama_tv_sort+
								"&nama_tv_long="+nama_tv_long,
                        
						success: function(data) {
                            $("#SuksesSL").load('modul/sop/sukses.php');
                        }
                    });
                });
				
				$("#SimpanPS").click(function() {
                    var asu_kelembagaan = $('#asu_kelembagaan').val();
                    var asu_dansos = $('#asu_dansos').val();
                    var asu_bonus_upk = $('#asu_bonus_upk').val();
                    var asu_lainnya = $('#asu_lainnya').val();
                    var asu_ditahan = $('#asu_ditahan').val();

				//	if(asu_kelembagaan, asu_dansos < 100){
				//		$("#SuksesPS").load('modul/sop/dilarang.php');
				//		return false;
				//			}
						
                    $.ajax({
                        type: "POST",
                        url: "modul/sop/simpan_ps.php",
                        data:"asu_kelembagaan="+asu_kelembagaan+
								"&asu_dansos="+asu_dansos+
								"&asu_bonus_upk="+asu_bonus_upk+
								"&asu_lainnya="+asu_lainnya+
								"&asu_ditahan="+asu_ditahan,
                        
						success: function(data) {
                            $("#SuksesPS").load('modul/sop/sukses.php');
                        }
                    });
                });
				
				
				$("#SimpanSPK").click(function() {
                    var redaksi_spk = $('#wysiwyg').val();
						
                    $.ajax({
                        type: "POST",
                        url: "modul/sop/simpan_spk.php",
                        data:"redaksi_spk="+redaksi_spk,
                        
						success: function(data) {
                            $("#SuksesSPK").load('modul/sop/sukses.php');
                        }
                    });
                });
				
				
				$("#SimpanTTD").click(function() {
                    var ttd_pelapor = $('#ttd_pelapor').val();
                    var ttd_bp = $('#ttd_bp').val();
                    var ttd_mengetahui_lap = $('#ttd_mengetahui_lap').val();
                    var ttd_pdua = $('#ttd_pdua').val();
                    var ttd_saksi = $('#ttd_saksi').val();
                    var ttd_mengetahui = $('#ttd_mengetahui').val();
						
                    $.ajax({
                        type: "POST",
                        url: "modul/sop/simpan_ttd.php",
                        data:"ttd_pelapor="+ttd_pelapor+
								"&ttd_bp="+ttd_bp+ 
                                "&ttd_mengetahui_lap="+ttd_mengetahui_lap+ 
								"&ttd_pdua="+ttd_pdua+ 
								"&ttd_saksi="+ttd_saksi+ 
								"&ttd_mengetahui="+ttd_mengetahui,
                        
						success: function(data) {
                            $("#SuksesTTD").load('modul/sop/sukses.php');
                        }
                    });
                });

				
            });
			

        </script>

	<h4 class="page-title hidden-print"><i class="glyphicon glyphicon-cog"></i> Personalisasi<span class="fw-semi-bold"> SOP Lembaga</span></h4>
	
		<div class="row">
			<div class="col-md-12">
                <div class="tabbable tabs-left mb-lg">
                    <ul id="tabs2" class="nav nav-tabs hidden-print">
                        <li class="active"><a href="#tab18" data-toggle="tab"><i class="fa fa-book"></i> Welcome !</a></li>
                        <li class=""><a href="#tab28" data-toggle="tab"><i class="fa fa-bank"></i> Identitas Lembaga</a></li>
                        <li class=""><a href="#tab118" data-toggle="tab"><i class="fa fa-gears"></i> Sebutan Lembaga</a></li>
                        <li class=""><a href="#tab98" data-toggle="tab"><i class="fa fa-gears"></i> Sebutan Jabatan</a></li>
                        <li class=""><a href="#tab38" data-toggle="tab"><i class="fa fa-history"></i> Awal Penggunaan</a></li>
                        <li class=""><a href="#tab48" data-toggle="tab"><i class="fa fa-clock-o"></i> Jam Kerja</a></li>
                        <li class=""><a href="#tab58" data-toggle="tab"><i class="fa fa-calendar"></i> Periode Pembukuan</a></li>
                        <li class=""><a href="#tab68" data-toggle="tab"><i class="fa fa-gears"></i> Sistem Pinjaman</a></li>
                        <li class=""><a href="#tab78" data-toggle="tab"><i class="fa fa-copy"></i> Redaksi Dokumen SPK</a></li>
                        <li class=""><a href="#tab88" data-toggle="tab"><i class="fa fa-heart"></i> Prosentase Surplus</a></li>
                        <li class=""><a href="#tab108" data-toggle="tab"><i class="fa fa-legal"></i> Legalisasi Dokumen</a></li>
						<li class=""><a href="#tab666" data-toggle="tab"><i class="fa fa-cubes"></i> Pengaturan Asuransi</a></li>
                    </ul>
                    <div id="tabs5c" class="tab-content">
						<div class="active tab-pane" id="tab18">
							<div class="alert alert-info animated fadeInDown mt">
								<h3 class="text-align-center mb-n-xlg">
									<i class="glyphicon glyphicon-road"></i> Standar Operasional Prosedur (SOP)<br>
									Penggunaan Sistem Informasi Manajemen UPK Online<br>
									<?php echo "$row[nama_lembaga_sort] $row[nama_kec]";?><br>
									<span class="h5">Sebagai dasar penggunaan SI UPK Online ini<br>
									Isilah sesuai dengan prosedur yang berlaku di UPK/Lembaga Anda,<br> Klik sidebar di samping kanan saya untuk mengatur SOP<br>
									Gunakanlah secara bijak sesuai dengan wewenang Anda, semoga bermanfaat!<br>Salam, Mr. Uphe</span>
								</h3>
								<span class="ml-lg"><img src="images/upe.png" class="mt-n-xlg" width="187"></span>
							</div>
						</div>
						
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
														required="required" autocomplete="off" placeholder="ID Kecamatan" disabled="disabled"/>
										</div>
										<label class="control-label col-sm-2">Kode Kecamatan</label>
										<div class="col-sm-4">
												<input type="text" name="kd_kec" id="kd_kec" class="form-control" value="<?php echo $row['kd_kec'];?>" maxlength="16"
														required="required" autocomplete="off" placeholder="Kode Kecamatan" disabled="disabled"/>
										</div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Nama Kecamatan</label>
                                        <div class="col-sm-8"><input type="text" name="nama_kec" id="nama_kec" class="form-control" value="<?php echo $row['nama_kec'];?>"
										required="required" autocomplete="off" placeholder="Nama Kecamatan"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Badan Hukum Nomor</label>
                                        <div class="col-sm-8"><input type="text" name="nomor_bh" id="nomor_bh" class="form-control" value="<?php echo $row['nomor_bh'];?>"
										required="required" autocomplete="off" placeholder="Badan Hukum Nomor"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Alamat Lembaga</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['alamat_kec'];?>" id="alamat_kec" name="alamat_kec" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Alamat"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Telpon</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['telpon_kec'];?>" id="telpon_kec" name="telpon_kec" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Telpon"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">E-mail</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['email_kec'];?>" id="email_kec" name="email_kec" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="E-mail"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Website Utama</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['web_kec'];?>" id="web_kec" name="web_kec" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Website" disabled="disabled"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Website Alternatif</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['web_alternatif'];?>" type="text" class="form-control" disabled="disabled"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Visi Misi</label>
                                        <div class="col-sm-8"><input value="<?php echo $row['visi_misi'];?>" id="visi_misi" name="visi_misi" type="text" class="form-control" 
										required="required" autocomplete="off" placeholder="Visi Misi"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Username Camat</label>
                                        <div class="col-sm-2">
												<input type="text" class="form-control" value="<?php echo $row['uname'];?>"
														required="required" autocomplete="off" disabled="disabled"/>
										</div>
										<label class="control-label col-sm-2">Password Camat</label>
										<div class="col-sm-4">
												<input type="text" class="form-control" value="<?php echo $row['pass'];?>"
														required="required" autocomplete="off" disabled="disabled"/>
										</div>
                                    </div>
									<div id="Sukses"></div>
									
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanIDUPK"><i class="fa fa-recycle"></i> Ubah Data</button>
                                <a href="#" class="btn btn-default btn-rounded" disabled="disabled">Reset</a>
                            </div>
							</div>
                        </div>
						
						<div class="tab-pane" id="tab38">
							<header>
								<legend><i class="fa fa-history"></i> Awal Penggunaan</legend>
							</header>
							<p>Awal Penggunaan Sistem Informasi Manajemen Koperasi Berbasis Online di <?php echo $row['nama_kec'];?> ditetapkan sejak tanggal :
							
							<div class="col-sm-4"><input value="<?php echo tgl_indo($tgl_pakai);?>" type="text" class="form-control" disabled="disabled"/></div>
							<br><br>Dengan backup dan kondisi laporan keuangan sesuai dengan yang tertera pada menu laporan Awal, yaitu meliputi :<p>
							<ul class="text-list">
								<li>Jurnal Awal status <?php echo getBulan($bulan_pakai-1);?> <?php echo $tahun_pakai;?></li>
								<li>Rekapitulasi Saldo Buku Besar Awal Tahun <?php echo $tahun_pakai;?> ditambah Saldo sampai dengan <?php echo getBulan($bulan_pakai-1);?> <?php echo $tahun_pakai;?></li>
								<li>Laporan Rugi Laba Status <?php echo getBulan($bulan_pakai-1);?> <?php echo $tahun_pakai;?></li>
								<li>Neraca Status <?php echo getBulan($bulan_pakai-1);?> <?php echo $tahun_pakai;?></li>
								<li>Khusus Jurnal Angsuran baik pokok maupun jasa, telah diinputkan dengan jumlah komulatif per kelompok sampai dengan bulan <?php echo getBulan($bulan_pakai-1);?> <?php echo $tahun_pakai; ?></li>
							</ul>
							<p>
							Selanjutnya Pihak Lembaga akan melanjutkan transaksi dengan menggunakan Sistem ini mulai dari transaksi pada tanggal <?php echo tgl_indo($tgl_pakai);?>.<br>
							Demikian keterangan ini dibuat sebagai bukti legal atas migrasi data dari format excel ke Sistem ini, apabila dikemudian hari diminta keterangan dari pihak
							yang berkepentingan maupun auditor kami siap memberikan penjelasan lebih lanjut.<br><br>
							</p>
							<p class="fw-semi-bold pull-right">
							<?php echo $row['nama_kec'];?>, <?php echo tgl_indo($tgl_pakai);?><br>
							Tim Migrasi Data<br>
							SIM Koperasi
							</p>
                        </div>
						
						<div class="tab-pane" id="tab48">
							<header>
								<legend><i class="fa fa-clock-o"></i> Jam Kerja</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="form-group">
                                        <div class="col-sm-2">
										<label class="control-label">Jam Masuk</label>
											<input type="text" name="jam_masuk" id="jam_masuk" class="form-control" value="<?php echo $row['jam_masuk'];?>"
											required="required" autocomplete="off" placeholder="Jam Masuk"> 
										</div>
										<label class="control-label col-sm-1 mt-md">S.D.</label>
                                        <div class="col-sm-2">
										<label class="control-label">Jam Pulang</label>
											<input type="text" name="jam_pulang" id="jam_pulang" class="form-control" value="<?php echo $row['jam_pulang'];?>"
											required="required" autocomplete="off" placeholder="Jam Pulang"> 
										</div>
                                    </div>
									<div id="SuksesJM"></div>
									
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanJamKerja"><i class="fa fa-recycle"></i> Ubah Data</button>
                                <a href="#" class="btn btn-default btn-rounded" disabled="disabled">Reset</a>
                            </div>
							</div>
                        </div>
						
						<div class="tab-pane" id="tab58">
							<header>
								<legend><i class="fa fa-calendar"></i> Periode Pembukuan</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="form-group">
                                        <label class="control-label col-sm-3">Tanggal Open</label>
                                        <div class="col-sm-3"><input type="text" value="<?php echo $row['tgl_open'];?>" name="tgl_open" id="tgl_open" class="form-control" 
										required="required" autocomplete="off" placeholder="Tanggal Open"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-3">Tanggal Closing</label>
                                        <div class="col-sm-3"><input type="text" value="<?php echo $row['tgl_close'];?>" name="tgl_close" id="tgl_close" class="form-control" 
										required="required" autocomplete="off" placeholder="Tanggal Closing"> </div>
                                    </div>

									<div id="SuksesPB"></div>
									
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanPB"><i class="fa fa-recycle"></i> Ubah Data</button>
                                <a href="#" class="btn btn-default btn-rounded" disabled="disabled">Reset</a>
                            </div>
							</div>
                        </div>
						
						<div class="tab-pane" id="tab98">
							<header>
								<legend><i class="fa fa-gears"></i> Sebutan Jabatan</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="form-group">
                                        <label class="control-label col-sm-3">Pejabat Level 1 (Ket)</label>
                                        <div class="col-sm-3"><input type="text" value="<?php echo $row['sebutan_level_1'];?>" name="sebutan_level_1" id="sebutan_level_1" class="form-control" 
										required="required" autocomplete="off" placeholder="Pejabat Level 1 (Setara Ketua)"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-3">Pejabat Level 2 (Sek)</label>
                                        <div class="col-sm-3"><input type="text" value="<?php echo $row['sebutan_level_2'];?>" name="sebutan_level_2" id="sebutan_level_2" class="form-control" 
										required="required" autocomplete="off" placeholder="Pejabat Level 1 (Setara Sekretaris)"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-3">Pejabat Level 3 (Ben)</label>
                                        <div class="col-sm-3"><input type="text" value="<?php echo $row['sebutan_level_3'];?>" name="sebutan_level_3" id="sebutan_level_3" class="form-control" 
										required="required" autocomplete="off" placeholder="Pejabat Level 1 (Setara Bendahara)"> </div>
                                    </div>

									<div id="SuksesSJ"></div>
									
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanSJ"><i class="fa fa-recycle"></i> Ubah Data</button>
                                <a href="#" class="btn btn-default btn-rounded" disabled="disabled">Reset</a>
                            </div>
							</div>
                        </div>
						
						<div class="tab-pane" id="tab118">
							<header>
								<legend><i class="fa fa-gears"></i> Sebutan Lembaga</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="form-group">
                                        <label class="control-label col-sm-12 fw-semi-bold">Sebutan Lembaga</label>
                                        <label class="control-label col-sm-2">Long Name</label>
                                        <div class="col-sm-4"><input type="text" value="<?php echo $row['nama_lembaga_long'];?>" name="nama_lembaga_long" id="nama_lembaga_long" class="form-control" 
										required="required" autocomplete="off" placeholder="Sebutan Lembaga setingkat UPK (long)"> </div>
                                    </div>
									<div class="form-group">
										<label class="control-label col-sm-2">Sort Name</label>
                                        <div class="col-sm-4"><input type="text" value="<?php echo $row['nama_lembaga_sort'];?>" name="nama_lembaga_sort" id="nama_lembaga_sort" class="form-control" 
										required="required" autocomplete="off" placeholder="Sebutan Lembaga setingkat UPK (sort)"> </div>
                                    </div>
									
									<!--<div class="form-group">-->
         <!--                               <label class="control-label col-sm-12 fw-semi-bold">Sebutan Lembaga setingkat BKAD</label>-->
         <!--                               <label class="control-label col-sm-2">Long Name</label>-->
         <!--                               <div class="col-sm-4"><input type="text" value="<?php echo $row['nama_bkad_long'];?>" name="nama_bkad_long" id="nama_bkad_long" class="form-control" -->
									<!--	required="required" autocomplete="off" placeholder="Sebutan Lembaga setingkat BKAD (long)"> </div>-->
         <!--                           </div>-->
									<!--<div class="form-group">-->
									<!--	<label class="control-label col-sm-2">Sort Name</label>-->
         <!--                               <div class="col-sm-4"><input type="text" value="<?php echo $row['nama_bkad_sort'];?>" name="nama_bkad_sort" id="nama_bkad_sort" class="form-control" -->
									<!--	required="required" autocomplete="off" placeholder="Sebutan Lembaga setingkat BKAD (sort)"> </div>-->
         <!--                           </div>-->
									
									<div class="form-group">
                                        <label class="control-label col-sm-12 fw-semi-bold">Sebutan Pengawas</label>
                                        <label class="control-label col-sm-2">Long Name</label>
                                        <div class="col-sm-4"><input type="text" value="<?php echo $row['nama_bp_long'];?>" name="nama_bp_long" id="nama_bp_long" class="form-control" 
										required="required" autocomplete="off" placeholder="Sebutan Lembaga setingkat Pengawas (long)"> </div>
                                    </div>
									<div class="form-group">
										<label class="control-label col-sm-2">Sort Name</label>
                                        <div class="col-sm-4"><input type="text" value="<?php echo $row['nama_bp_sort'];?>" name="nama_bp_sort" id="nama_bp_sort" class="form-control" 
										required="required" autocomplete="off" placeholder="Sebutan Lembaga setingkat Pengawas (sort)"> </div>
                                    </div>
									
									<div class="form-group">
                                        <label class="control-label col-sm-12 fw-semi-bold">Sebutan Analis Kredit</label>
                                        <label class="control-label col-sm-2">Long Name</label>
                                        <div class="col-sm-4"><input type="text" value="<?php echo $row['nama_tv_long'];?>" name="nama_tv_long" id="nama_tv_long" class="form-control" 
										required="required" autocomplete="off" placeholder="Sebutan Lembaga setingkat Analis Kredit (long)"> </div>
                                    </div>
									<div class="form-group">
										<label class="control-label col-sm-2">Sort Name</label>
                                        <div class="col-sm-4"><input type="text" value="<?php echo $row['nama_tv_sort'];?>" name="nama_tv_sort" id="nama_tv_sort" class="form-control" 
										required="required" autocomplete="off" placeholder="Sebutan Lembaga setingkat Analis Kredit (sort)"> </div>
                                    </div>


									<div id="SuksesSL"></div>
									
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanSL"><i class="fa fa-recycle"></i> Ubah Data</button>
                                <a href="#" class="btn btn-default btn-rounded" disabled="disabled">Reset</a>
                            </div>
							</div>
                        </div>
						
						<div class="tab-pane" id="tab68">
							<header>
								<legend><i class="fa fa-gears"></i> Sistem Pinjaman</legend>
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
                                        <label class="control-label col-sm-3">IPTW (%)</label>
                                        <div class="col-sm-3"><input type="text" value="<?php echo $row['iptw'];?>" name="iptw" id="iptw" class="form-control" 
										required="required" autocomplete="off" placeholder="Default IPTW"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-3">Toleransi Tanggal Tagihan</label>
                                        <div class="col-sm-6">
											<select id="tgl_toleransi"  name="tgl_toleransi"
														data-placeholder="Toleransi Tanggal Tagihan"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															$kec1=mysql_fetch_array(mysql_query("select * from kecamatan c, jenis_toleransi jt WHERE c.tgl_toleransi=jt.id_toleransi AND c.id='$_SESSION[lokasi]' "));
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
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanSP"><i class="fa fa-recycle"></i> Ubah Data</button>
                                <a href="#" class="btn btn-default btn-rounded" disabled="disabled">Reset</a>
                            </div>
							</div>
                        </div>
						
						<div class="tab-pane" id="tab78">
							<header>
								<legend><i class="fa fa-copy"></i> Redaksi Dokumen SPK</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
									<div class="alert alert-info animated fadeInDown">
										<legend><strong>Petunjuk</strong></legend>
										<ol>
											<li>Fitur ini dapat anda gunakan untuk merubah, menambah dan menghapus redaksi SPK;</li>
											<li>Redaksi yang dapat anda ubah, tambah dan hapus yaitu mulai dari Pasal 2 ayat 5, sedangkan selain itu merupakan redaksi standar dalam perjanjian yang memuat data pinjaman</li>
											<li>Gunakan papan ketik dan icon yang tersedia selayaknya mengetik pada Microsoft Word;</li>
											<li>Untuk membuat ayat baru, cukup tekan enter saja, tanpa menuliskan nomor karena akan otomatis membuat nomor sendiri pada dokumen SPK;</li>
											<li>Redaksi tersebut disamping akan atomatis tercopy pada seluruh SPK pinjaman yang anda buat;</li>
											<li>Klik tombol ubah data jika Anda telah yakin dengan data tersebut</li>
										</ol>
									</div>
									<p><strong>Pasal 2.</strong></p>
									<textarea rows="12"  class="form-control" id="wysiwyg" name="redaksi_spk" ><?php echo $row['redaksi_spk'];?></textarea>
									<div id="SuksesSPK"></div>
									<div class="form-actions">
										<button class="btn btn-inverse btn-rounded pull-right" id="SimpanSPK"><i class="fa fa-recycle"></i> Ubah Data</button>
										<a href="#" class="btn btn-default btn-rounded" disabled="disabled">Reset</a>
									</div>
                   
									
							</fieldset>
							
							</div>
                        </div>
						
						<div class="tab-pane" id="tab88">
							<header>
								<legend><i class="fa fa-calendar"></i> Rencana Prosentase Surplus</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
								<div class="col-sm-6">
									<div class="form-group">
                                        <label class="control-label col-sm-4">SHU Anggota</label>
                                        <div class="col-sm-6">
										<div class="input-group">
											<input type="text" value="<?php echo $row['asu_kelembagaan'];?>" name="asu_kelembagaan" id="asu_kelembagaan" class="form-control" 
											required="required" autocomplete="off" placeholder="SHU Anggota">
											<span class="input-group-addon">%</span>
										</div>
										</div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">SHU Penyertaan</label>
                                        <div class="col-sm-6">
											<div class="input-group">
											<input type="text" value="<?php echo $row['asu_dansos'];?>" name="asu_dansos" id="asu_dansos" class="form-control" 
										required="required" autocomplete="off" placeholder="SHU Penyertaan"> 
											<span class="input-group-addon">%</span>
											</div>
										</div>
                                    </div>
									<div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">Bonus Pengurus/Pengelola</label>
										<div class="col-sm-6">
											<div class="input-group">
												<input type="text" value="<?php echo $row['asu_bonus_upk'];?>" name="asu_bonus_upk" id="asu_bonus_upk" class="form-control" 
												required="required" autocomplete="off" placeholder="Bonus Pengurus">
												<span class="input-group-addon">%</span>
											</div>
										</div>
									</div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">SHU Lainnya</label>
                                        <div class="col-sm-6">
										<div class="input-group">
											<input type="text" value="<?php echo $row['asu_lainnya'];?>" name="asu_lainnya" id="asu_lainnya" class="form-control" 
											required="required" autocomplete="off" placeholder="SHU Lainnya">
											<span class="input-group-addon">%</span>
										</div>
										</div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Surplus Ditahan</label>
                                        <div class="col-sm-6">
										<div class="input-group">
											<input type="text" value="<?php echo $row['asu_ditahan'];?>" name="asu_ditahan" id="asu_ditahan" class="form-control" 
											required="required" autocomplete="off" placeholder="Surplus Ditahan">
											<span class="input-group-addon">%</span>
										</div>
										</div>
                                    </div>
									<div id="SuksesPS"></div>
                                </div>
									
								<div class="col-md-6">
		<div class="alert alert-info animated fadeInDown">
			<legend><strong>Petunjuk</strong></legend>
			<ol>
				<li>Isikan prosentase pembagian surplus dalam bentuk prosentase sesuai dengan Alokasinya</li>
				<li>Gunakan titik (.) untuk mempresentasikan angka desimal, contoh yang salah: 2,5 | contoh yang benar: 2.5</li>
				<li>Angka tersebut disamping hanyalah rencana saja, anda dapat merubahnya dilain waktu</li>
				<li>Angka tersebut disamping akan menjadi dasar perhitungan alokasi surplus pada saat tutup buku</li>
				<li>Klik tombol ubah data jika Anda telah yakin dengan data tersebut</li>
			</ol>
		</div>
	</div>
									
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanPS"><i class="fa fa-recycle"></i> Ubah Data</button>
                                <a href="#" class="btn btn-default btn-rounded" disabled="disabled">Reset</a>
                            </div>
							</div>
                        </div>
						
						
						<div class="tab-pane" id="tab108">
							<header>
								<legend><i class="fa fa-legal"></i> Legalisasi Dokumen</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
								<div class="col-sm-6">
							
									<div class="form-group">
										<h5 class="fw-semi-bold">Legalitas Dokumen Laporan</h5>
													<label class="fs-sm mb-0">Siapakah yang bertanda tangan pada setiap jenis laporan?</label>
                                                    <select id="ttd_pelapor"  name="ttd_pelapor"
														data-placeholder="Tanda Tangan Pelapor"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															$datap=mysql_fetch_array(mysql_query("select * from kecamatan c, tanda_tangan t WHERE c.ttd_pelapor=t.idu and c.id='$row[id]' and t.level='1' "));
															echo "<option value='$datap[idu]'>$datap[penandatangan]</option>";
															$view1=mysql_query("select * from tanda_tangan WHERE level=1");
																while($rows=mysql_fetch_array($view1)){
																echo "<option value='$rows[idu]'>$rows[penandatangan]</option>";
																} ?>
													</select>
													</div>
									<div class="form-group">
													<label class="fs-sm mb-0">Siapakah yang bertanda tangan pada pemeriksaan laporan?</label>
                                                    <select id="ttd_bp"  name="ttd_bp"
														data-placeholder="Tanda Tangan Pemeriksa"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															$databp=mysql_fetch_array(mysql_query("select * from kecamatan c, tanda_tangan t WHERE c.ttd_bp=t.idu and c.id='$row[id]' and t.level='3' "));
															echo "<option value='$databp[idu]'>$databp[penandatangan]</option>";
															$view=mysql_query("select * from tanda_tangan WHERE level=3");
																while($rows=mysql_fetch_array($view)){
																echo "<option value='$rows[idu]'>$rows[penandatangan]</option>";
																} ?>
													</select>
													</div>
									
									<div class="form-group">
                                                    <label class="fs-sm mb-0">Siapakah yang bertanda tangan Mengetahui?</label>
                                                    <select id="ttd_mengetahui_lap"  name="ttd_mengetahui_lap"
                                                        data-placeholder="Tanda Tangan Mengetahui"
                                                        class="select2 form-control"
                                                        tabindex="-1">
                                                            <?php 
                                                            $databkad=mysql_fetch_array(mysql_query("select * from kecamatan c, tanda_tangan t WHERE c.ttd_mengetahui_lap=t.idu and c.id='$row[id]' and t.level='2' "));
                                                            echo "<option value='$databkad[idu]'>$databkad[penandatangan]</option>";
                                                            $view=mysql_query("select * from tanda_tangan WHERE level=2");
                                                                while($rows=mysql_fetch_array($view)){
                                                                echo "<option value='$rows[idu]'>$rows[penandatangan]</option>";
                                                                } ?>
                                                    </select>
                                                    </div>

									<div class="form-group">
											<h5 class="fw-semi-bold">Legalitas Dokumen SPK</h5>
												<?php /*	<label class="fs-sm mb-0">Siapakah yang bertanda tangan mewakili pihak kedua pada Dokumen SPK?</label>
                                                    <select id="ttd_pdua"  name="ttd_pdua"
														data-placeholder="Tanda Tangan Pihak Kedua"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															$data2=mysql_fetch_array(mysql_query("select * from kecamatan c, tanda_tangan t WHERE c.ttd_pdua=t.idu and c.id='$row[id]' and t.level='5' "));
															echo "<option value='$data2[idu]'>$data2[penandatangan]</option>";
															$view2=mysql_query("select * from tanda_tangan WHERE level=5");
																while($rows=mysql_fetch_array($view2)){
																echo "<option value='$rows[idu]'>$rows[penandatangan]</option>";
																} ?>
													</select>  */?>
													</div>
									
									<div class="form-group">
													<label class="fs-sm mb-0">Siapakah yang bertanda tangan menjadi Saksi pada Dokumen SPK?</label>
                                                    <select id="ttd_saksi"  name="ttd_saksi"
														data-placeholder="Tanda Tangan Saksi"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															$data3=mysql_fetch_array(mysql_query("select * from kecamatan c, tanda_tangan t WHERE c.ttd_saksi=t.idu and c.id='$row[id]' and t.level='6' "));
															echo "<option value='$data3[idu]'>$data3[penandatangan]</option>";
															$view2=mysql_query("select * from tanda_tangan WHERE level=6 ORDER BY idu");
																while($rows=mysql_fetch_array($view2)){
																echo "<option value='$rows[idu]'>$rows[penandatangan]</option>";
																} ?>
													</select>
													</div>
													
									<div class="form-group">
													<label class="fs-sm mb-0">Siapakah yang bertanda tangan untuk Mengetahui pada Dokumen SPK?</label>
                                                    <select id="ttd_mengetahui"  name="ttd_mengetahui"
														data-placeholder="Tanda Tangan Saksi"
														class="select2 form-control"
														tabindex="-1">
															<?php 
															$data4=mysql_fetch_array(mysql_query("select * from kecamatan c, tanda_tangan t WHERE c.ttd_mengetahui=t.idu and c.id='$row[id]' and t.level='7' "));
															echo "<option value='$data4[idu]'>$data4[penandatangan]</option>";
															$view2=mysql_query("select * from tanda_tangan WHERE level=7");
																while($rows=mysql_fetch_array($view2)){
																echo "<option value='$rows[idu]'>$rows[penandatangan]</option>";
																} ?>
													</select>
													</div>
									
									<div id="SuksesTTD"></div>
                                </div>
									
								<div class="col-md-6">
		<div class="alert alert-info animated fadeInDown">
			<legend><strong>Petunjuk</strong></legend>
			<ol>
				<li>Pilihlah option pihak penandatangan disamping sesuai dengan SOP</li>
				<li>Klik tombol Ubah Data untuk menyimpan</li>
				<li>Hubungi Technical Support jika belum sesuai dengan SOP yang berlaku</li>
			</ol>
		</div>
	</div>
									
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanTTD"><i class="fa fa-recycle"></i> Ubah Data</button>
                                <a href="#" class="btn btn-default btn-rounded" disabled="disabled">Reset</a>
                            </div>
							</div>
                        </div>
						
						
						
						
						
		<!-----               perubahan dimulai dr sini                       ----->				
						
						<div class="tab-pane" id="tab666">
							<header>
								<legend><i class="fa fa-cubes"></i> Nama Asuransi</legend>
							</header>
							<div id="validation-form" class="form-horizontal form-label-left"
                              data-parsley-priority-enabled="false"
                              novalidate="novalidate">
                            <fieldset>
								<div class="col-sm-6">
							
									<div class="form-group">
                                        <label class="control-label col-sm-5">Nama Asuransi</label>
                                        <div class="col-sm-6"><input type="text" value="<?php echo $row['nama_asuransi_p'];?>" name="n_asur" id="n_asur" class="form-control" required="required" autocomplete="off" placeholder="Nama Asuransi"> </div>
                                    </div>
													<input type='hidden' value='1' id="j_a"  name="j_a">
									<div class="form-group">
                                        <label class="control-label col-sm-5">Usia Maksimal</label>
                                        <div class="col-sm-6">
										<div class="input-group">
											<input type="text" value="<?php echo $row['usia_mak'];?>" name="u_max" id="u_max" class="form-control" required="required" autocomplete="off" placeholder="Usia">
											<span class="input-group-addon">Tahun</span>
										</div>
										</div>
                                    </div>
									
									<div class="form-group">
                                        <label class="control-label col-sm-5">Persentase Premi</label>
                                        <div class="col-sm-6">
										<div class="input-group">
											<input type="text" value="<?php echo $row['besar_premi'];?>" name="a_premi" id="a_premi" class="form-control" required="required" autocomplete="off" placeholder="Premi">
											<span class="input-group-addon">%</span>
										</div>
										</div>
                                    </div>
									
									<div id="SuksesNA"></div>
                                </div>
									
								<div class="col-md-6">
		<div class="alert alert-info animated fadeInDown">
			<legend><strong>Petunjuk</strong></legend>
			<ol>
				<li>Kosongkan jika tidak mengasuransikan pinjaman</li>
				<li>Ketik Nama Asuransi yang menjadi mitra asuransi pinjaman </li>
				<li>Ketik Usia Maksimal Nasabah yang bisa menjadi peserta asuransi</li>
				<li>Ketik Nilai Prosentase Premi terhadap pagu pinjaman</li>
				
			</ol>
		</div>
	</div>
									
							</fieldset>
							<div class="form-actions">
                                <button class="btn btn-inverse btn-rounded pull-right" id="SimpanNA"><i class="fa fa-recycle"></i> Ubah Data</button>
                                <a href="#" class="btn btn-default btn-rounded" disabled="disabled">Reset</a>
                            </div>
							</div>
                        </div>
			
			<!-------------sampai sini--------------->
						
                    </div>
                </div>
            </div>
        </div>