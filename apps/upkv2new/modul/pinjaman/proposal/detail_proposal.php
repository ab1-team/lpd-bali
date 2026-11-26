<?php session_start(); ?>

        <script type="text/javascript">
        	$(document).ready(function() {
					
	$("#AlokasiKelompok").load('modul/pinjaman/verifikasi/alokasi.php');
	
	
	$("#GoVerified").click(function() {
		var id_pinj				= $('#id_pinj').val();
		var tgl_verifikasi		= $('#tgl_verifikasi').val();
		var alokasi				= $('#alokasi').val();
		var pros_jasa			= $('#pros_jasa').val();
		var jangka				= $('#jangka').val();
		var sistem				= $('#sistem').val();
		var catatan_verifikasi	= $('#catatan_verifikasi').val();

		var pilih = confirm('Anda menentukan pinjaman dengan Alokasi '+alokasi+ '?');
			if (pilih==true) {			
				$.ajax({
				type: "POST",
				url: "modul/pinjaman/verifikasi/simpan_verifikasi.php",
				data: 	"id_pinj="+id_pinj+
						"&tgl_verifikasi="+tgl_verifikasi+
						"&alokasi="+alokasi+
						"&pros_jasa="+pros_jasa+
						"&jangka="+jangka+
						"&sistem="+sistem+
						"&catatan_verifikasi="+catatan_verifikasi,
				success: function(data) {
					window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ&sT=P&s=ok';

				}
				});
			}
		});
	
	});	

			
			function deleteProposal(ID) {
				var idl	= ID;
			   var pilih = confirm('Apakah anda yakin akan menghapus Loan ID '+idl+ '?');
				if (pilih==true) {
					$.ajax({
						type	: "POST",
						url		: "modul/pinjaman/proposal/hapus_proposal.php",
						data	: "idl="+idl,
						success	: function(data){
							window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ&sT=P';
							$("#TampilPemanfaat").load('modul/pinjaman/register/tampil_pemanfaat.php');
						}
					});
				}
			}
			
			function VerifikasiUlang(ID) {
				var idl	= ID;
			   var pilih = confirm('Apakah anda yakin akan men-Verifikasi Ulang Loan ID '+idl+ '?');
				if (pilih==true) {
					$.ajax({
						type	: "POST",
						url		: "modul/pinjaman/verified/simpan_verifikasi_ulang.php",
						data	: "idl="+idl,
						success	: function(data){
							window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ&sT=V&s=suksesVU';
						}
					});
				}
			}
			
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
	
	$(document).ready(function() {

			$("#proposal").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
					
				$("#DataProposal").load('modul/pinjaman/proposal/data_proposal.php');
				$("#TampilPemanfaat").load('modul/pinjaman/register/tampil_pemanfaat.php');
				$("#TampilDataKelompok").load('modul/kelompok/tampil_data.php');
				$("#EditDataKelompok").load('modul/kelompok/edit_data_kelompok.php');
				$("#CetakProposal").load('modul/pinjaman/proposal/cetak_proposal.php');
				$("#CetakPencairan").load('modul/pinjaman/proposal/cetak_pencairan.php');
				$("#RiwayatTransaksi").load('modul/jurnal_angsuran/tampil_buku_angsuran.php');
				$("#ValidasiPelunasan").load('modul/pinjaman/validasi_lunas/validasi.php');
				
				$("#NomorSPK").load('modul/pinjaman/proposal/spk_no.php');
                
				
			$("#SimpanEditProposal").click(function() {
				var id_pinj				= $('#id_pinj').val();
				var tgl_proposal		= $('#tgl_proposal').val();
				var proposal			= $('#proposal').val();
				var pros_jasa			= $('#pros_jasa').val();
				var jenis_jasa			= $('#jenis_jasa').val();
				var jangka				= $('#jangka').val();
				var sistem				= $('#sistem').val();
				var jenis_pp			= $('#jenis_pp').val();
				var sa_jasa			    = $('#sa_jasa').val();

						$.ajax({
						type: "POST",
						url: "modul/pinjaman/register/simpan_proposal.php",
						data: 	"id_pinj="+id_pinj+
						"&tgl_proposal="+tgl_proposal+
						"&proposal="+proposal+
						"&pros_jasa="+pros_jasa+
						"&jenis_jasa="+jenis_jasa+
						"&jangka="+jangka+
						"&sistem="+sistem+
						"&jenis_pp="+jenis_pp+
						"&sa_jasa="+sa_jasa,
							success: function(data) {
							$("#EditBerhasil").load('modul/pinjaman/proposal/sukses_edit.php');
							$("#DataProposal").load('modul/pinjaman/proposal/data_proposal.php');

							}
						});
					
			});
					
			$("#PilihPemanfaatProposal").click(function(){
						var cari = $("#PilihPemanfaatProposal").val();
						caridatapemanfaat(cari);
					})
					function caridatapemanfaat(e){
						var cari = e;
						$.ajax({
							type	: "POST",
							url		: "modul/pinjaman/proposal/pilih_pemanfaat.php",
							data	: "cari="+cari,
							success	: function(data){
								$("#PilihPemanfaat").html(data);
							}
						});
					}
				
					
            $("#GoWaiting").click(function() {
				var id_pinj		= $('#id_pinj').val();
				var tgl_tunggu		= $('#tgl_tunggu').val();
				var tgl_cair	= $('#tgl_cair').val();
				
				var pilih = confirm('Masukkan ke Daftar Tunggu dengan Tanggal Cair '+tgl_cair+ '?');
				if (pilih==true) {			
							$.ajax({
								type: "POST",
								url: "modul/pinjaman/verified/simpan_tgl_cair.php",
								data: 	"id_pinj="+id_pinj+
										"&tgl_tunggu="+tgl_tunggu+
										"&tgl_cair="+tgl_cair,
								success: function(data) {
									window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ&sT=V&s=suksesWL';
								}
							});
						}
						});
						
			$("#Cairkan").click(function(){
						var cari = $("#Cairkan").val();
						cariformcair(cari);
					})
					function cariformcair(e){
						var cari = e;
						$.ajax({
							type	: "POST",
							url		: "modul/pinjaman/waiting/form_cair.php",
							data	: "cari="+cari,
							success	: function(data){
								$("#FormPencairan").html(data);
							}
						});
					}
					
			$("#SimpanResceduling").click(function(e) {
			    e.preventDefault();
			    
				var id_kelres				= $('#id_kelres').val();
				var idpinjres			= $('#idpinjres').val();
				var jenis_ppres			= $('#jenis_ppres').val();
				var jenis_ppasli		= $('#jenis_ppasli').val();
				var tglres				= $('#tglres').val();
				var alokasires			= $('#alokasires').val();
				var saldopinjamanres	= $('#saldopinjamanres').val();
				var pros_jasares		= $('#pros_jasares').val();
				var jenis_jasares		= $('#jenis_jasares').val();
				var jangkares			= $('#jangkares').val();
				var sistemres			= $('#sistemres').val();
				var sistemjres			= $('#sistemjres').val();
					var pilih = confirm('Apakah yakin akan rescedulling Pinjaman ini?');
					if (pilih==true) {
						$.ajax({
						
						type: "POST",
						url: "modul/pinjaman/proposal/simpan_resceduling.php",
						data: 	"id_kelres="+id_kelres+
						"&idpinjres="+idpinjres+
						"&jenis_ppres="+jenis_ppres+
						"&jenis_ppasli="+jenis_ppasli+
						"&tglres="+tglres+
						"&alokasires="+alokasires+
						"&saldopinjamanres="+saldopinjamanres+
						"&pros_jasares="+pros_jasares+
						"&jenis_jasares="+jenis_jasares+
						"&jangkares="+jangkares+
						"&sistemres="+sistemres+
						"&sistemjres="+sistemjres,
							success: function(data) {
									window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ&sT=A&s=suksesRC';
								}
						});
					}
			});
			
			$("#SimpanPenghapusan").click(function() {
				var id_kelhapus			= $('#id_kelhapus').val();
				var idpinjhapus			= $('#idpinjhapus').val();
				var tglhapus			= $('#tglhapus').val();
				var totalhapus			= $('#totalhapus').val();
				var catatanhapus	= $('#catatanhapus').val();
				var sumber_biaya		= $('#sumber_biaya').val();
					var pilih = confirm('Apakah yakin akan melakukan Penghapusan Pinjaman ini?');
					if (pilih==true) {
						$.ajax({
						
						type: "POST",
						url: "modul/pinjaman/proposal/simpan_penghapusan.php",
						data: 	"id_kelhapus="+id_kelhapus+
						"&idpinjhapus="+idpinjhapus+
						"&tglhapus="+tglhapus+
						"&totalhapus="+totalhapus+
						"&catatanhapus="+catatanhapus+
						"&sumber_biaya="+sumber_biaya,
							success: function(data) {
									window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ&sT=A&s=suksesPH';
								}
						});
					}
			});
			
			$("#SimpanSPKNO").click(function() {
                    var spk_no = $('#spk_no').val();
                    var idpinj = $('#idpinj').val();
                    var waktu = $('#waktu').val();
                    var tempat = $('#tempat').val();
					
					if(spk_no.length==0){ $("#spk_no").focus(); return false; }
						
                    $.ajax({
                        type: "POST",
                        url: "modul/pinjaman/proposal/simpan_spk_no.php",
                        data:"spk_no="+spk_no+
							"&waktu="+waktu+
							"&tempat="+tempat+
							"&idpinj="+idpinj,
                        
						success: function(data) {
                            $("#SuksesSPKNO").load('modul/pinjaman/proposal/cetak_pencairan.php');
                            $("#SelamatSukses").load('modul/pinjaman/proposal/SelamatSukses.php');
							$("#NomorSPK").load('modul/pinjaman/proposal/spk_no.php');
                        }
                    });
                });
			
			
			});
			
		
        </script>

<?php 
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_thumb.php";
include "../../../inc/fungsi_pinjaman.php";
$id	= $_POST['id'];
$_SESSION['idprop']	= $id;
$_SESSION['id_pinkel']	= $id;
$_SESSION['id_pinj']	= $id;
$row=mysql_fetch_array(mysql_query("select * from kecamatan kc, desa d, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj,
													kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
																WHERE
																kc.id=k.lokasi AND d.id=k.desa AND jpp.id=pk.jenis_pp AND
																sa.id=pk.sistem_angsuran AND jj.id=pk.jenis_jasa AND
																k.id=pk.id_kel AND pk.id='$id'"));	

$_SESSION['ida']		=$row['id_kel']; //Dikirim ke kelompok/tampil_data.php
$_SESSION['proposal']	=$row['proposal'];		
$sts					=$row['status'];
$spk_no					=$row['spk_no'];
$_SESSION['sts']		=$sts;	
$id_kel					=$row['id_kel'];
$idpinj					=$row['id'];
$nama_kec					=$row['nama_kec'];
$waktu					=substr($row['wt_cair'],0,5);
$tempat					=substr($row['wt_cair'],6);
$jenis_pp				=$row['jenis_pp'];
$tgl_now				=date('Y-m-d');
$saldopinjaman			=saldopinjaman("$tgl_now-$idpinj");
?>
<?php 
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$id	= $_POST['id'];
$row=mysql_fetch_array(mysql_query("select * from kecamatan kc, desa d, jenis_produk_pinjaman jpp, sistem_angsuran sa, 
													kelompok_$_SESSION[kd_kab] k, pinjaman_kelompok_$_SESSION[kd_kab] pk
																WHERE
																kc.id=k.lokasi AND d.id=k.desa AND jpp.id=pk.jenis_pp AND
																sa.id=pk.sistem_angsuran AND 
																k.id=pk.id_kel AND pk.id='$id'"));
																
$tgl_proposal		=$row['tgl_proposal'];
$proposal			=$row['proposal'];
$tgl_verifikasi		=$row['tgl_verifikasi'];
$alokasi			=$row['alokasi'];
$pros_jasa			=$row['pros_jasa'];
$jangka				=$row['jangka'];
$sistem_angsuran	=$row['nama_sistem'];
$tgl_now			=date('Y-m-d');	
$catatan_verifikasik	=$row['catatan_verifikasi'];															
?>

<div class="animated fadeInDown">
	<h4 class="page-title hidden-print"><span class="fw-semi-bold"> KELOMPOK <?php echo strtoupper($row['nama_kelompok']);?></span> Loan ID. <?php echo "$row[id]";?>
	<span class="fw-semi-bold pull-right"><a href="#tabk12" data-toggle="tab"><i class="glyphicon glyphicon-chevron-left"></i><i class="glyphicon glyphicon-chevron-left"></i> back</a></span></h4>
	<p class="mt-n-md"> Alamat : <?php echo "$row[alamat_kelompok] $row[nama_desa] Telp.$row[telpon]";?></p> 
	
		<div class="row">
			<div class="col-md-12">
                <div class="tabbable tabs-left mb-lg">
                    <ul id="tabs2" class="nav nav-tabs hidden-print">
                        <li class="active"><a href="#tab14" data-toggle="tab"><i class="fa fa-building"></i> Data Pinjaman</a></li>
                        <li class=""><a href="#tab25" data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Data Pemanfaat</a></li>
						<li class=""><a href="#tab24" data-toggle="tab"><i class="fa fa-users"></i> Identitas Kelompok</a></li>
						<?php if ($sts=="P") { ?>
                        <li class=""><a href="#tab34" data-toggle="tab"><i class="glyphicon glyphicon-print"></i> Cetak Doc Proposal</a></li>
                        <li class=""><a href="#tabUbahProp" data-toggle="tab"><i class="fa fa-recycle"></i> Ubah Proposal</a></li>
                        <li class=""><a href="#veri" data-toggle="tab"><i class="fa fa-times"></i> Verifikasi </a></li>
						<li class=""><a href="#tabXProp" data-toggle="tab"><i class="fa fa-times"></i> Hapus Proposal</a></li>
						<?php } elseif ($sts=="V") {?>
						<li class=""><a href="#tab34" data-toggle="tab"><i class="glyphicon glyphicon-print"></i> Cetak Doc Verifikasi</a></li>
                        <li class=""><a href="#tab64" data-toggle="tab"><i class="fa fa-wheelchair"></i> ke Daftar Tunggu</a></li>
                        <li class=""><a href="#tab54" data-toggle="tab"><i class="glyphicon glyphicon-repeat"></i> Verifikasi Ulang</a></li>
						<?php } elseif ($sts=="W") {?>
						<li class=""><a href="#tab54" data-toggle="tab"><i class="glyphicon glyphicon-repeat"></i> Kembalikan ke Proposal</a></li>
                        <li class=""><a href="#tab44" data-toggle="tab"><i class="glyphicon glyphicon-print"></i> Dokumen Pencairan</a></li>
                        <?php } elseif ($sts=="A" AND $saldopinjaman!=0) {?>
                        <li class=""><a href="#tab44" data-toggle="tab"><i class="glyphicon glyphicon-print"></i> Dokumen Pencairan</a></li>
						<li class=""><a href="#tab74" data-toggle="tab"><i class="fa fa-history"></i> Riwayat Transaksi</a></li>
						<li class=""><a href="#tabR" data-toggle="tab"><i class="fa fa-recycle"></i> Rescedulling</a></li>
						<li class=""><a href="#tabH" data-toggle="tab"><i class="glyphicon glyphicon-remove"></i> Penghapusan</a></li>
						<?php } elseif ($sts=="A" AND $saldopinjaman==0) {?>
						<li class=""><a href="#tab44" data-toggle="tab"><i class="glyphicon glyphicon-print"></i> Dokumen Pencairan</a></li>
						<li class=""><a href="#tab74" data-toggle="tab"><i class="fa fa-history"></i> Riwayat Transaksi</a></li>
						<li class=""><a href="#tab84" data-toggle="tab"><i class="fa fa-gavel"></i> Validasi Pelunasan</a></li>
						<?php } ?>
                    </ul>
                    <div id="tabs3c" class="tab-content">
                    	
					
						<div class="tab-pane" id="tabXProp">
							<legend>
								<i class="fa fa-times"></i> Konfirmasi Hapus Proposal
							</legend>
							<div class="col-sm-3">
							</div>
							<div class="form-actions col-sm-6 mt-n-md">
								<p class="text-justify">
								Fitur ini dapat Anda gunakan jika Anda akan menghapus data proposal baik proposal kelompok maupun proposal 
								Anggota.<br>
								Dengan klik tombol "YA" maka proposal akan hilang, namun data kelompok masih ada.<br>
								Apakah anda akan menghapus proposal ini?
								</p>
								<a href="#tab14" data-toggle="tab" class="btn btn-default btn-rounded pull-right">Kembali</a>
								<?php echo "<a href='javascript:deleteProposal(\"{$row['id']}\")' class='btn btn-inverse btn-rounded'><i class='fa fa-times'></i>  Ya, Hapus Proposal</a>"; ?>
							</div>
							<div class="col-sm-3">
							</div>
						</div>
					
						<div class="tab-pane" id="tabUbahProp">
							<header>
								<legend><i class="fa fa-recycle"></i> Ubah Data Proposal
								</legend>
							</header>
								<fieldset>
									<div class="row">
                                                <div class="col-md-1">
                                                </div>
                                                <div class="col-md-5">
                                                
                                                    <div class="form-group mb-xs">
														<label class="fs-sm mb-0">Tanggal Proposal</label>
                                                        <input type="text" class="form-control" value="<?php echo $row['tgl_proposal'];?>" name="tgl_proposal" id="tgl_proposal" 
                                                               autocomplete="off" placeholder="Tanggal Proposal">
                                                    </div>
													
                                                    <div class="form-group mb-xs">
														<label class="fs-sm mb-0">Alokasi Pengajuan</label>
                                                        <input type="text" class="form-control"  value="<?php echo $row['proposal'];?>" name="proposal" id="proposal"
                                                               autocomplete="off" placeholder="Alokasi Pengajuan">
                                                    </div>
													
													<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Prosentase Jasa (%)</label>
                                                        <input type="text" class="form-control"  value="<?php echo $row['pros_jasa'];?>" name="pros_jasa" id="pros_jasa"
                                                               autocomplete="off" placeholder="Prosentase Jasa">
                                                    </div>
													
													<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Jenis Jasa</label>
														<select id="jenis_jasa"  name="jenis_jasa"
															class="select2 form-control"
															tabindex="-1">
																<?php 
																echo "<option value='$row[jenis_jasa]'>$row[nama_jj]</option>";
																$view=mysql_query("select * from jenis_jasa");
																	while($rows=mysql_fetch_array($view)){
																	echo "<option value='$rows[id]'>$rows[nama_jj]</option>";
																	} ?>
														</select>
													</div>
													
													<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Jangka (bulan)</label>
                                                        <input type="text" class="form-control"  value="<?php echo $row['jangka'];?>" name="jangka" id="jangka"
                                                               autocomplete="off" placeholder="Jangka">
                                                    </div>
													
													<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Sistem Angsuran Pokok</label>
														<select id="sistem"  name="sistem"
															class="select2 form-control"
															tabindex="-1">
																<?php 
																echo "<option value='$row[sistem_angsuran]'>$row[nama_sistem]</option>";
																$view=mysql_query("select * from sistem_angsuran");
																	while($rows=mysql_fetch_array($view)){
																	echo "<option value='$rows[id]'>$rows[nama_sistem]</option>";
																	} ?>
														</select>
													</div>
													
													<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Sistem Angsuran Jasa</label>
														<select id="sa_jasa"  name="sa_jasa"
															class="select2 form-control"
															tabindex="-1">
																<?php 
																echo "<option value='$row[sistem_angsuran]'>$row[nama_sistem]</option>";
																$view=mysql_query("select * from sistem_angsuran");
																	while($rows=mysql_fetch_array($view)){
																	echo "<option value='$rows[id]'>$rows[nama_sistem]</option>";
																	} ?>
														</select>
													</div>

													<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Jenis Pinjaman</label>
														<select id="jenis_pp"  name="jenis_pp"
															class="select2 form-control"
															tabindex="-1">
																<?php 
																echo "<option value='$row[jenis_pp]'>$row[nama_jpp] ($row[deskripsi_jpp])</option>";
																$view=mysql_query("select * from jenis_produk_pinjaman Where
																	lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR 
																	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%'");
																	while($rows=mysql_fetch_array($view)){
																	echo "<option value='$rows[id]'>$rows[nama_jpp] ($rows[deskripsi_jpp])</option>";
																	} ?>
														</select>
													</div>
													
													<input type="hidden"  value="<?php echo $row['id'];?>" name="id_pinj" id="id_pinj"/>
												</div>
												<div class="col-md-5">
													<div class="form-actions">
														<p><strong>Konfirmasi</strong><br>
														Apakah anda akan merubah data pinjaman tersebut?
														</p>
														
														<a href="#tab14" data-toggle="tab" class="btn btn-default btn-rounded pull-right">Kembali</a>
														<button href="#tab14" data-toggle="tab" class="btn btn-inverse btn-rounded" id="SimpanEditProposal"><i class="fa fa-recycle"></i> Ya, Ubah Data</button>
													</div>
                                                </div>

                                            </div>
							</fieldset>
                        </div>
						
						<div class="tab-pane active" id="tab14">
							<legend>
								<i class="fa fa-building"></i> Data Pinjaman
								<?php if ($sts=="P") { ?>
								<span class="pull-right">
									<a href="#tabUbahProp"  data-toggle="tab" class="btn btn-danger mt-n-md"><i class="fa fa-recycle"></i> Ubah Proposal</a>
								</span>
								<?php } elseif ($sts=="V") {?>
								<span class="pull-right">
									<a href="#tab64"  data-toggle="tab" class="btn btn-danger mt-n-md"><i class="fa fa-wheelchair"></i> Masukkan ke Daftar Tunggu</a>
								</span>
								<?php } elseif ($sts=="W") {?>
								<span class="pull-right">
									<button type="button" class="btn btn-danger mt-n-md" data-toggle="collapse" data-parent="#accordionCair" href="#collapseCair" value="<?php echo $row['id']; ?>" id="Cairkan"><i class="fa fa-money"></i> Form Pencairan</button>
								</span>
								<?php } elseif ($sts=="A" AND $saldopinjaman==0) {?>
								<span class="pull-right">
									<a href="#tab84"  data-toggle="tab" class="btn btn-danger mt-n-md"><i class="fa fa-gavel"></i> Validasi Pelunasan</a>
								</span>
								<?php } ?>
							</legend>
							<div class="panel-group mb-lg" id="accordionCair" data-toggle="collapse">
								<div class="panel panel-default">
									<div id="collapseCair" class="panel-collapse collapse">
										<div class="panel-body">
											<div id="FormPencairan"></div>
										</div>
									</div>
								</div>
							</div>
							
							<div id="DataProposal"></div>
							<div id="EditBerhasil"></div>	
                        </div>
						
						<div class="tab-pane" id="tab25">
							<legend>
								<i class="glyphicon glyphicon-user"></i> Data Pemanfaat 
								<?php if ($sts=="P" OR $sts=="A") { ?>
								<span class="pull-right">
									<button type="button" class="btn btn-danger mt-n-md" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" value="<?php echo $row['id']; ?>" id="PilihPemanfaatProposal"><i class="glyphicon glyphicon-user"></i><i class="fa fa-plus"></i> Tambah Pemanfaat</button>
								</span>
								<?php } elseif ($sts=="V") {?>
								<span class="pull-right">
									<a href="#tab64"  data-toggle="tab" class="btn btn-danger mt-n-md"><i class="fa fa-wheelchair"></i> Masukkan ke Daftar Tunggu</a>
								</span>
								<?php } ?>
							</legend>
							<div class="panel-group mb-lg" id="accordion" data-toggle="collapse">
								<div class="panel panel-default">
									<div id="collapseOne" class="panel-collapse collapse">
										<div class="panel-body">
											<div id="PilihPemanfaat"></div>
										</div>
									</div>
								</div>
							</div>
							<div id="TampilPemanfaat"></div>
							<div id="EditBerhasil"></div>
                        </div>
						
						<div class="tab-pane" id="tab24">
							<header>
								<legend><i class="fa fa-users"></i> Identitas Kelompok
								
								<span class="pull-right">
									<?php
										echo "<a href='#tab94' onclick='javascript:EditKelompok(\"{$row[id_kel]}\")' data-toggle='tab' class='btn btn-danger mt-n-md'><i class='fa fa-recycle'></i> Ubah Data Kelompok</a>";
									?>
								</span>
								</legend>
							</header>
								<div id="TampilDataKelompok"></div>
                        </div>
						
						<div class="tab-pane" id="tab94">
							<header>
								<legend><i class="fa fa-edit"></i> Edit Identitas Kelompok</legend>
							</header>
								<div id="EditDataKelompok"></div>
                        </div>
						
						<div class="tab-pane" id="tab34">
							<legend>
								<i class="glyphicon glyphicon-print"></i> Cetak Dokumen Proposal
							</legend>
							<div id="CetakProposal"></div>
						</div>
						
						<div class="tab-pane" id="tab44">
						<?php if ($sts=="W" AND empty($spk_no) ) {?>
							<legend>
								<i class="glyphicon glyphicon-edit"></i> Buat Dokumen Pencairan
							</legend>
							<fieldset>
							<div class="form-group">
											<div class="input-group col-sm-8">
												<div class="col-sm-12">
												<label class="fs-sm mb-0">Untuk membuat Dokumen Pencairan, silahkan masukkan data dibawah ini :<br>
												<br>Nomor SPK (<i>disesuaikan dengan nomor urut arsip SPK, contoh: 1234/UPK/XI/2017</i>)</label>
												<input type="text" name="spk_no" id="spk_no" class="form-control input-lg" 
														required="required" autocomplete="off" placeholder="Masukkan Nomor SPK disini..."/>
												<input type="hidden" name="idpinj" id="idpinj" value="<?php echo $idpinj; ?>" />
												</div>
											</div>
											<div class="input-group col-sm-8">
												<div class="col-sm-4">
													<label class="fs-sm mb-0"><br>Rencana Waktu</label>
													<input type="text" name="waktu" id="waktu" class="form-control" value="<?php echo $waktu; ?>"
															required="required" autocomplete="off" placeholder="Waktu Rencana Pencairan"/>
												</div>
												<div class="col-sm-8">
													<label class="fs-sm mb-0"><br>Rencana Tempat</label>
													<input type="text" name="tempat" id="tempat" class="form-control" value="<?php echo "$tempat $nama_kec"; ?>"
															required="required" autocomplete="off" placeholder="Tempat Rencana Pencairan"/>
												</div>
											</div>
											<div class="form-actions col-sm-8 mt-n-xs">
												<button class="btn btn-inverse btn-rounded pull-right" id="SimpanSPKNO"><i class="glyphicon glyphicon-edit"></i> Buat Dokumen Pencairan</button>
												<a href="#" class="btn btn-default btn-rounded" disabled="disabled"></a>
											</div>
									</div>
								<br><br><br>
								<div id="SelamatSukses"></div>
								<div id="SuksesSPKNO"></div>
							 </fieldset>
						<?php } else {?>
							<legend>
								<i class="glyphicon glyphicon-print"></i> Cetak Dokumen Pencairan
							</legend>
							<div id="NomorSPK"></div>
							<a class="pull-right mt-n-lg" data-toggle="collapse" data-parent="#accordionSPKNO" href="#collapseSPKNO"><i class="glyphicon glyphicon-edit"></i> Ubah Nomor SPK</a>
							<div class="panel-group mb-lg" id="accordionSPKNO" data-toggle="collapse">
								<div class="panel panel-default">
									<div id="collapseSPKNO" class="panel-collapse collapse">
										<div class="panel-body">
											<div class="form-group">
												<div class="input-group col-sm-8">
													<div class="col-sm-12">
														<label class="fs-sm mb-0">Ubah Timestamp rencana pencairan dibawah ini :<br>
													<br>Nomor SPK (<i>disesuaikan dengan nomor urut arsip SPK, contoh: 1234/UPK/XI/2017</i>)</label>
														<input type="text" name="spk_no" id="spk_no" class="form-control input-lg" value="<?php echo $spk_no; ?>"
																required="required" autocomplete="off" placeholder="Masukkan Nomor SPK disini..."/>
														<input type="hidden" name="idpinj" id="idpinj" value="<?php echo $idpinj; ?>" />
													</div>
												</div>
												<div class="input-group col-sm-8">
													<div class="col-sm-4">
														<label class="fs-sm mb-0"><br>Rencana Waktu</label>
														<input type="text" name="waktu" id="waktu" class="form-control" value="<?php echo $waktu; ?>"
																required="required" autocomplete="off" placeholder="Waktu Rencana Pencairan"/>
													</div>
													<div class="col-sm-8">
														<label class="fs-sm mb-0"><br>Rencana Tempat</label>
														<input type="text" name="tempat" id="tempat" class="form-control" value="<?php echo $tempat; ?>"
																required="required" autocomplete="off" placeholder="Tempat Rencana Pencairan"/>
													</div>
												</div>
												<div class="form-actions col-sm-8 mt-n-xs">
													<button class="btn btn-inverse btn-rounded pull-right" id="SimpanSPKNO"><i class="glyphicon glyphicon-edit"></i> Ubah Nomor SPK</button>
													<a data-toggle="collapse" data-parent="#accordionSPKNO" href="#collapseSPKNO" class="btn btn-default btn-rounded">Tutup</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div id="CetakPencairan"></div>
						<?php } ?>
						
						</div>
						
						<div class="tab-pane" id="tab54">
							<legend>
								<i class="glyphicon glyphicon-refresh"></i> Konfirmasi Verifikasi Ulang
							</legend>
							<div class="col-sm-3">
							</div>
							<div class="form-actions col-sm-6 mt-n-md">
								<p class="text-justify">
								Fitur ini dapat Anda gunakan jika setelah dilakukan verifikasi, ternyata ada kesalahan baik proposal maupun data
								verifikasinya.<br>
								Dengan klik tombol "YA" maka pinjaman ini akan kembali ke status PROPOSAL (P), dan terkirim kembali ke 
								Tim Verifikasi untuk diVerifikasi ulang.<br>
								Apakah anda akan men-Verifikasi ulang pinjaman ini?
								</p>
								<a href="#tab14" data-toggle="tab" class="btn btn-default btn-rounded pull-right">Kembali</a>
								<?php echo "<a href='javascript:VerifikasiUlang(\"{$row['id']}\")' class='btn btn-inverse btn-rounded'><i class='fa fa-recycle'></i>  Ya, Verifikasi Ulang</a>"; ?>
							</div>
							<div class="col-sm-3">
							</div>
						</div>
						
						<div class="tab-pane" id="tab64">
							<legend>
								<i class="fa fa-wheelchair"></i> Konfirmasi Pindah ke Daftar Tunggu
							</legend>
							
		
			
		<?php
		$datapinjK=mysql_query("select * from pinjaman_kelompok_$_SESSION[kd_kab] WHERE id_kel='$row[id_kel]' AND status='A' ");
		$cari_akt=mysql_num_rows($datapinjK);
		
		$datapinjI=mysql_query("SELECT * FROM (SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] WHERE id_pinkel='$idpinj') AS tb2 INNER JOIN (SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab]) AS tb1  ON tb1.nia=tb2.nia AND tb1.`status`='A' ");
		$cari_akt_I=mysql_num_rows($datapinjI);
		
		
		if ($cari_akt>0 OR $cari_akt_I>0) {
			$rowK=mysql_fetch_array($datapinjK);
			
			$idpK=$rowK['id'];
			$saldopinjaman=saldopinjaman("$tgl_now-$idpK");
		?>
			<div class="col-sm-12">
								<div class="alert alert-danger alert-sm">
									<button href="#tab14" data-toggle="tab" type="button" class="close" aria-hidden="true">×</button>
									<span class="fw-semi-bold">Maaf, Anda tidak dapat memasukkan pinjaman ini ke daftar tunggu !<br></span><br>
									
								<?php if ($cari_akt>0) { ?>	
									<ul><li>Kelompok ini masih terdeteksi memiliki pinjaman aktif Loan ID. <?php echo "$idpK Saldo Rp. ".number_format($saldopinjaman); ?></li></ul>
									
									<a class="btn btn-danger btn-xs pull-right mr-xs" href="?p=vL">Lihat Validasi Pelunasan</a>
								<?php } if ($cari_akt_I>0) {
									
									echo "<ul><li>$cari_akt_I orang dalam kelompok ini masih terdeteksi memiliki pinjaman aktif</li></ul>";
										
										echo "<table width='100%'>";
										echo "<tr>
										<th width='5%'></th>
										<th width='15%'>NIA</th>
										<th width='20%'>Nama Pemanfaat</th>
										<th width='30%'>Jenis Pinjaman-L.ID</th>
										<th width='20%'>Alokasi</th>
										<th width='15%'>Tgl Cair</th>
										</tr>";
											while($r=mysql_fetch_array($datapinjI)){
												
												if($r['jenis_pinjaman']=='K') {
													$jenis_pinjaman="Kelompok";
												} else {
													$jenis_pinjaman="Individu";
												}
										
												$rs=mysql_fetch_array(mysql_query("select * from anggota_$_SESSION[kd_kab] WHERE id='$r[nia]'"));
												$ks=mysql_fetch_array(mysql_query("select * from kelompok_$_SESSION[kd_kab] WHERE id='$r[id_kel]'"));
																
										echo "<tr>
												<td></td>
												<td>$rs[id]</td>
												<td>$rs[namadepan]</td>
												<td>$jenis_pinjaman - $ks[nama_kelompok] - $r[id_pinkel]</td>
												<td>".number_format($r['alokasi'])."</td>
												<td>".$r['tgl_cair']."</td>
											</tr>";
										
									}
									echo "</table>";
								 } ?>
								
								</div>
	
								
			</div>
		<?php }else{ ?>					
							<div class="col-sm-3">
							</div>
							<div class="form-actions col-sm-6 mt-n-md">
							<p class="text-justify">
								Untuk memasukkan proposal ke daftar tunggu, silahkan masukkan Rencana Tanggal cair
								</p>
									<div class="form-group">
										<span class="fs-mini text-muted">Tanggal Penetapan</span>
										<input name="tgl_tunggu" id="tgl_tunggu" type="text" class="form-control" value="<?php echo date('Y-m-d');?>"
										required="required" autocomplete="off" placeholder="Tanggal tunggu"/>
										<span class="fs-mini text-muted">Rencana Tanggal Cair</span>
										<input name="tgl_cair" id="tgl_cair" type="text" class="form-control" value="<?php echo date('Y-m-d');?>"
										required="required" autocomplete="off" placeholder="Tanggal Cair"/>
										<input name="id_pinj" id="id_pinj" type="hidden" class="form-control" value="<?php echo $id;?>" />
									</div>
								<a href="#tab14" data-toggle="tab" class="btn btn-default btn-rounded pull-right">Kembali</a>
								<button class="btn btn-inverse btn-rounded" id="GoWaiting"><i class="fa fa-wheelchair"></i> Masukkan ke Daftar Tunggu</button>
							</div>
							<div class="col-sm-3">
							</div>
		<?php } ?>
							
						</div>
						
						<div class="tab-pane" id="tab74">
							<legend>
								<i class="fa fa-history"></i> Riwayat Transaksi
							</legend>
							<div id="RiwayatTransaksi"></div>
						</div>
						
						<div class="tab-pane" id="tab84">
							<div id="ValidasiPelunasan"></div>
						</div>
						
						
						
						<div class="tab-pane" id="tabR">
							<legend>
								<i class="fa fa-times"></i> Konfirmasi Resceduling Pinjaman
							</legend>
							<div class="col-sm-3">
							</div>
							<div class="form-actions col-sm-6 mt-n-md">
								<p class="text-justify">
								Fitur ini dapat Anda gunakan jika Anda akan menjadwal ulang (Resceduling) Pinjaman<br>
								Dengan klik tombol "YA" maka pinjaman ini akan berstatus R, dan akan membuat pinjaman baru dengan Alokasi sebesar saldo yang ada, yaitu
								Rp. <?php echo number_format($saldopinjaman);?><br>
								</p>
									<input type="hidden"  value="<?php echo $id_kel;?>" id="id_kelres" />
									<input type="hidden"  value="<?php echo $idpinj;?>" id="idpinjres" />
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Tanggal</label>
                                            <input type="text" class="form-control" value="<?php echo date('Y-m-d');?>" name="tglres" id="tglres" 
                                                autocomplete="off" placeholder="Tanggal">
                                    </div>
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Alokasi</label>
                                            <input type="text" class="form-control" value="<?php echo $saldopinjaman;?>" name="alokasires" id="alokasires" 
                                                autocomplete="off" placeholder="Alokasi">
											<input type="hidden" value="<?php echo $saldopinjaman;?>" name="saldopinjamanres" id="saldopinjamanres" >
                                    </div>
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Prosentase Jasa</label>
                                            <input type="text" class="form-control" value="<?php echo $row['pros_jasa'];?>" name="pros_jasares" id="pros_jasares" 
                                                autocomplete="off" placeholder="Jasa">
                                    </div>
									<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Jenis Jasa</label>
														<select id="jenis_jasares"  name="jenis_jasares"
															class="select2 form-control"
															tabindex="-1">
																<?php 
																echo "<option value='$row[jenis_jasa]'>$row[nama_jj]</option>";
																$views=mysql_query("select * from jenis_jasa");
																	while($rowres=mysql_fetch_array($views)){
																	echo "<option value='$rowres[id]'>$rowres[nama_jj]</option>";
																	} ?>
														</select>
													</div>
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Jangka</label>
                                            <input type="text" class="form-control" value="<?php echo $row['jangka'];?>" name="jangkares" id="jangkares" 
                                                autocomplete="off" placeholder="Jangka">
                                    </div>
									<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Sistem Angsuran Pokok</label>
														<select id="sistemres"  name="sistemres"
															class="select2 form-control"
															tabindex="-1">
																<?php 
																echo "<option value='$row[sistem_angsuran]'>$row[nama_sistem]</option>";
																$views=mysql_query("select * from sistem_angsuran");
																	while($rowres=mysql_fetch_array($views)){
																	echo "<option value='$rowres[id]'>$rowres[nama_sistem]</option>";
																	} ?>
														</select>
													</div>
									<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Sistem Angsuran Jasa</label>
														<select id="sistemjres"  name="sistemjres"
															class="select2 form-control"
															tabindex="-1">
																<?php 
																echo "<option value='$row[sistem_angsuran]'>$row[nama_sistem]</option>";
																$views=mysql_query("select * from sistem_angsuran");
																	while($rowjres=mysql_fetch_array($views)){
																	echo "<option value='$rowjres[id]'>$rowjres[nama_sistem]</option>";
																	} ?>
														</select>
													</div>
									<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Jenis Pinjaman</label>
														<input type="hidden" value="<?php echo $jenis_pp;?>" name="jenis_ppasli" id="jenis_ppasli" >
														<select id="jenis_ppres"  name="jenis_ppres"
															class="select2 form-control"
															tabindex="-1">
																<?php 
																echo "<option value='$jenis_pp'>$row[deskripsi_jpp] ($row[nama_jpp])</option>";
																$viewjpp=mysql_query("select * from jenis_produk_pinjaman Where
																	lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR 
																	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%'");
																	while($rowjpp=mysql_fetch_array($viewjpp)){
																	echo "<option value='$rowjpp[id]'>$rowjpp[deskripsi_jpp] ($rowjpp[nama_jpp])</option>";
																	} ?>
														</select>
													</div>
								<div id="RescedulingBerhasil"></div>	
								<a href="#tab14" data-toggle="tab" class="btn btn-default btn-rounded pull-right">Kembali</a>
								<a href="" class='btn btn-inverse btn-rounded' id="SimpanResceduling"><i class='fa fa-times'></i>  Ya, Resceduling pinjaman ini</a>
							</div>
							<div class="col-sm-3">
							</div>
						</div>
						
						<div class="tab-pane" id="tabH">
							<legend>
								<i class="fa fa-times"></i> Konfirmasi Penghapusan Pinjaman
							</legend>
							<div class="col-sm-3">
							</div>
							<div class="form-actions col-sm-6 mt-n-md">
								<p class="text-justify">
								Fitur ini dapat Anda gunakan jika Anda akan melakukan Penghapusan Pinjaman<br>
								Dengan klik tombol PROSES maka pinjaman ini akan berstatus H, dan akan membuat transaksi penghapusan sebesar saldo pinjaman
								Rp. <?php echo number_format($saldopinjaman);?><br>
								</p>
									<input type="hidden"  value="<?php echo $id_kel;?>" id="id_kelhapus" />
									<input type="hidden"  value="<?php echo $idpinj;?>" id="idpinjhapus" />
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Tanggal Transaksi Penghapusan</label>
                                            <input type="text" class="form-control" value="<?php echo date('Y-m-d');?>" name="tglhapus" id="tglhapus" 
                                                autocomplete="off" placeholder="Tanggal">
                                    </div>
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Total Penghapusan</label>
                                            <input type="text" class="form-control" value="<?php echo $saldopinjaman;?>" name="totalhapus" id="totalhapus" 
                                                autocomplete="off" placeholder="Total Penghapusan">
											<input type="hidden" value="<?php echo $saldopinjaman;?>" name="saldopinjamanhapus" id="saldopinjamanhapus" >
                                    </div>
									<div class="form-group mb-xs">
														<label class="fs-sm mb-0">Sumber Biaya</label>
														<select id="sumber_biaya"  name="sumber_biaya"
															class="select2 form-control"
															tabindex="-1">
																<option value='1'>Alokasi Cadangan Resiko</option>
																<option value='2'>Biaya Penghapusan Pinjaman (Surplus Berjalan)</option>
														</select>
													</div>
									<div class="form-group mb-xs">
										<label class="fs-sm mb-0">Catatan</label>
                                            <textarea rows="4" class="form-control" name="catatanhapus" id="catatanhapus"
											autocomplete="off" placeholder="Tuliskan catatan/Alasan mengapa pinjaman ini dihapus dan dasar hukumnya..."></textarea>
                                    </div>
									
								<div id="PenghapusanBerhasil"></div>	
								<a href="#tab14" data-toggle="tab" class="btn btn-default btn-rounded pull-right">Kembali</a>
								<a href="" class='btn btn-inverse btn-rounded' id="SimpanPenghapusan"><i class='fa fa-times'></i>  PROSES PENGHAPUSAN PINJAMAN INI</a>
							</div>
							<div class="col-sm-3">
							</div>
						</div>

						
                    </div>
                </div>
            </div>
        </div>
</div>
<style type="text/css">
<!--

-->
</style>
