<?php session_start(); ?>

<script type="text/javascript">
	function deleteProposal(ID) {
		var id_a = ID;
		var pilih = confirm('Apakah anda yakin akan menghapus Loan ID ' + id_a + '?');
		if (pilih == true) {
			$.ajax({
				type: "POST",
				url: "modul/pinjaman/register/hapus_pemanfaat.php",
				data: "id_a=" + id_a,
				success: function (data) {
					window.location.href =
						'2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ_i&sT=P';
					$("#TampilPemanfaat").load('modul/pinjaman/register/tampil_pemanfaat.php');
				}
			});
		}
	}

	function VerifikasiUlangIndividu(ID) {
		var idl = ID;
		var pilih = confirm('Apakah anda yakin akan men-Verifikasi Ulang Loan ID ' + idl + '?');
		if (pilih == true) {
			$.ajax({
				type: "POST",
				url: "modul/pinjaman/verified/simpan_verifikasi_ulang_individu.php",
				data: "idl=" + idl,
				success: function (data) {
					window.location.href =
						'2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ_i&sT=W&s=suksesVU';
				}
			});
		}
	}





	$(document).ready(function () {

		$("#proposali").keypress(function (data) {
			if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
				return false;
			}
		});

		$("#DataProposal").load('modul/pinjaman/proposal/data_proposal_individu.php');
		$("#TampilPemanfaat").load('modul/pinjaman/register/tampil_pemanfaat.php');
		$("#TampilDataPemanfaat").load('modul/penduduk/detail/tampil_data.php');
		$("#EditDataKelompok").load('modul/kelompok/edit_data_kelompok.php');
		$("#CetakProposal").load('modul/pinjaman/proposal/cetak_proposal_individu.php');
		$("#CetakPencairan").load('modul/pinjaman/proposal/cetak_pencairan_individu.php');
		$("#RiwayatTransaksiIndividu").load('modul/jurnal_angsuran/tampil_buku_angsuran_individu.php');
		$("#ValidasiPelunasanIndividu").load('modul/pinjaman/validasi_lunas/validasi_individu.php');

		$("#NomorSPK").load('modul/pinjaman/proposal/spk_no_individu.php');


		$("#SimpanEditAngg").click(function () {
			var nik = $('#nika').val();
			var namadepan = $('#namadepana').val();
			var jk = $('#jka').val();
			var tempat_lahir = $('#tempat_lahira').val();
			var tgl_lahir = $('#tgl_lahira').val();
			var alamat = $('#alamata').val();
			var hp = $('#hpa').val();
			var kk = $('#kka').val();
			var penjamin = $('#penjamina').val();
			var hubungan = $('#hubungana').val();
			var usaha = $('#usahaa').val();

			if (nik.length == 0) {
				alert('Silahkan isikan nik baru Anda!');
				$("#nika").focus();
				return false;
			}
			$.ajax({
				type: "POST",
				url: "modul/penduduk/detail/simpan_data.php",
				data: "nik=" + nik +
					"&namadepan=" + namadepan +
					"&jk=" + jk +
					"&tempat_lahir=" + tempat_lahir +
					"&tgl_lahir=" + tgl_lahir +
					"&alamat=" + alamat +
					"&hp=" + hp +
					"&kk=" + kk +
					"&penjamin=" + penjamin +
					"&hubungan=" + hubungan +
					"&usaha=" + usaha,

				success: function (data) {
					$("#TampilDataPemanfaat").load('modul/penduduk/detail/tampil_data.php');
				}
			});
		});

		$("#SimpanEditProposalIndividu").click(function () {
			var nia = $('#nia').val();
			var id_pinj = $('#id_pinj').val();
			var tgl_proposal = $('#tgl_proposal').val();
			var proposali = $('#proposali').val();
			var pros_jasa = $('#pros_jasa').val();
			var jenis_jasa = $('#jenis_jasa').val();
			var jangka = $('#jangka').val();
			var sistem = $('#sistem').val();
			var jenis_pp = $('#jenis_pp').val();

			$.ajax({
				type: "POST",
				url: "modul/pinjaman/register/simpan_proposal_individu.php",
				data: "nia=" + nia +
					"&id_pinj=" + id_pinj +
					"&tgl_proposal=" + tgl_proposal +
					"&proposali=" + proposali +
					"&pros_jasa=" + pros_jasa +
					"&jenis_jasa=" + jenis_jasa +
					"&jangka=" + jangka +
					"&sistem=" + sistem +
					"&jenis_pp=" + jenis_pp,
				success: function (data) {
					$("#EditBerhasil").load('modul/pinjaman/proposal/sukses_edit.php');
					$("#DataProposal").load(
						'modul/pinjaman/proposal/data_proposal_individu.php');

				}
			});

		});

		var data_id = $('#wlClick').attr('data-id');
		$.ajax({
			type: "POST",
			url: "modul/pinjaman/verifikasi/detail_verifikasi_individu.php",
			data: "id=" + data_id,
			success: function (data) {
				$('#tabWL').html(data)
			}
		});

		$("#PilihPemanfaatProposal").click(function () {
			var cari = $("#PilihPemanfaatProposal").val();
			caridatapemanfaat(cari);
		})

		function caridatapemanfaat(e) {
			var cari = e;
			$.ajax({
				type: "POST",
				url: "modul/pinjaman/proposal/pilih_pemanfaat.php",
				data: "cari=" + cari,
				success: function (data) {
					$("#PilihPemanfaat").html(data);
				}
			});
		}


		$("#GoWaitingIndividu").click(function () {
			var id_pinj = $('#id_pinj').val();
			var tgl_cair = $('#tgl_cair').val();

			var pilih = confirm('Masukkan ke Daftar Tunggu dengan Tanggal Cair ' + tgl_cair + '?');
			if (pilih == true) {
				$.ajax({
					type: "POST",
					url: "modul/pinjaman/verified/simpan_tgl_cair_individu.php",
					data: "id_pinj=" + id_pinj +
						"&tgl_cair=" + tgl_cair,
					success: function (data) {
						window.location.href =
							'2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ_i&sT=W&s=suksesWL';
					}
				});
			}
		});

		$("#CairkanIndividu").click(function () {
			var cari = $("#CairkanIndividu").val();
			cariformcair(cari);
		})

		function cariformcair(e) {
			var cari = e;
			$.ajax({
				type: "POST",
				url: "modul/pinjaman/waiting/form_cair_individu.php",
				data: "cari=" + cari,
				success: function (data) {
					$("#FormPencairanIndividu").html(data);
				}
			});
		}

		$("#SimpanRescedulingIndividu").click(function () {
			var niares = $('#niares').val();
			var idpinjres = $('#idpinjres').val();
			var jenis_ppres = $('#jenis_ppres').val();
			var jenis_ppasli = $('#jenis_ppasli').val();
			var tglres = $('#tglres').val();
			var alokasires = $('#alokasires').val();
			var saldopinjamanres = $('#saldopinjamanres').val();
			var pros_jasares = $('#pros_jasares').val();
			var jenis_jasares = $('#jenis_jasares').val();
			var jangkares = $('#jangkares').val();
			var sistemres = $('#sistemres').val();
			var sistemjres = $('#sistemjres').val();
			var pilih = confirm('Apakah yakin akan rescedulling Pinjaman Individu ini?');
			if (pilih == true) {
				$.ajax({

					type: "POST",
					url: "modul/pinjaman/proposal/simpan_resceduling_individu.php",
					data: "niares=" + niares +
						"&idpinjres=" + idpinjres +
						"&jenis_ppres=" + jenis_ppres +
						"&jenis_ppasli=" + jenis_ppasli +
						"&tglres=" + tglres +
						"&alokasires=" + alokasires +
						"&saldopinjamanres=" + saldopinjamanres +
						"&pros_jasares=" + pros_jasares +
						"&jenis_jasares=" + jenis_jasares +
						"&jangkares=" + jangkares +
						"&sistemres=" + sistemres +
						"&sistemjres=" + sistemjres,
					success: function (data) {
						window.location.href =
							'2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ_i&sT=A&s=suksesRC';
					}
				});
			}
		});

		$("#SimpanSPKNOIndividu").click(function () {
			var spk_no = $('#spk_no').val();
			var idpinj = $('#idpinj').val();

			if (spk_no.length == 0) {
				$("#spk_no").focus();
				return false;
			}

			$.ajax({
				type: "POST",
				url: "modul/pinjaman/proposal/simpan_spk_no_individu.php",
				data: "spk_no=" + spk_no +
					"&idpinj=" + idpinj,

				success: function (data) {
					$("#SuksesSPKNO").load(
						'modul/pinjaman/proposal/cetak_pencairan_individu.php');
					$("#SelamatSukses").load('modul/pinjaman/proposal/SelamatSukses.php');
					$("#NomorSPK").load('modul/pinjaman/proposal/spk_no_individu.php');
				}
			});
		});


	});
</script>

<?php 
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/fungsi_thumb.php";
include "../../../inc/fungsi_pinjaman_individu.php";
$id	= $_POST['id'];
$postId = $_POST['id'];
$_SESSION['idprop']	= $id;
$_SESSION['id_pinkel']	= $id;
$_SESSION['id_pinj']	= $id;
$row=mysql_fetch_array(mysql_query("select * from kecamatan kc, desa d, jenis_produk_pinjaman jpp, sistem_angsuran sa, jenis_jasa jj, 
													keluarga k, usaha u, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pi
																WHERE
																kc.id=a.lokasi AND d.id=a.desa AND jpp.id=pi.jenis_pp AND
																sa.id=pi.sistem_angsuran AND jj.id=pi.jenis_jasa AND pi.jenis_pinjaman='I' AND
																u.id=a.usaha AND k.id=a.hubungan AND a.id=pi.nia AND pi.id='$id'"));	

$_SESSION['ida']		=$row['nia']; //Dikirim ke penduduk/detail/tampil_data.php
$_SESSION['proposal']	=$row['proposal'];		
$sts					=$row['status'];
$spk_no					=$row['spk_no'];
$_SESSION['sts']		=$sts;	
$nia					=$row['nia'];
$idpinj					=$row['id'];
$jenis_pp				=$row['jenis_pp'];
$tgl_now				=date('Y-m-d');
$saldopinjaman			=saldopinjaman("$tgl_now-$idpinj");
?>
<div class="animated fadeInDown">
	<h4 class="page-title hidden-print"><span class="fw-semi-bold"> <?php echo strtoupper($row['namadepan']);?></span>
		Loan ID. <?php echo "$row[id]";?>
		<span class="fw-semi-bold pull-right"><a href="#tabk12" data-toggle="tab"><i
					class="glyphicon glyphicon-chevron-left"></i><i class="glyphicon glyphicon-chevron-left"></i>
				back</a></span></h4>
	<p class="mt-n-md"> Alamat : <?php echo "$row[alamat] $row[nama_desa] Telp.$row[telpon]";?></p>

	<div class="row">
		<div class="col-md-12">
			<div class="tabbable tabs-left mb-lg">
				<ul id="tabs2" class="nav nav-tabs hidden-print">
					<li class="active"><a href="#tab14" data-toggle="tab"><i class="fa fa-building"></i> Data
							Pinjaman</a></li>
					<li class=""><a href="#tab24" data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Identitas
							Pemanfaat</a></li>
					<?php if ($sts=="P") { ?>
					<li class=""><a href="#tab34" data-toggle="tab"><i class="glyphicon glyphicon-print"></i> Cetak Doc
							Proposal</a></li>
					<li class=""><a href="#tabX" data-toggle="tab"><i class="fa fa-times"></i> Hapus Proposal</a></li>
					<?php } elseif ($sts=="V" AND $_SESSION['lokasi']!="1" AND $_SESSION['lokasi']!="319") {?>
					<li class=""><a href="#tab34" data-toggle="tab"><i class="glyphicon glyphicon-print"></i> Cetak Doc
							Verifikasi</a></li>
					<li class=""><a href="#tab64" data-toggle="tab"><i class="fa fa-wheelchair"></i> ke Daftar
							Tunggu</a></li>
					<li class=""><a href="#tab54" data-toggle="tab"><i class="glyphicon glyphicon-repeat"></i>
							Verifikasi Ulang</a></li>
					<?php } elseif ($sts=="D") { ?>
					<li class=""><a href="#tab54" data-toggle="tab"><i class="glyphicon glyphicon-repeat"></i>
							Kembalikan ke Proposal</a></li>
					<li class=""><a href="#tab64" data-toggle="tab"><i class="fa fa-wheelchair"></i> ke Daftar
							Tunggu</a></li>
					<?php } elseif ($sts=="W") {?>
					<li class=""><a href="#tab54" data-toggle="tab"><i class="glyphicon glyphicon-repeat"></i>
							Kembalikan ke Proposal</a></li>
					<li class=""><a href="#tab44" data-toggle="tab"><i class="glyphicon glyphicon-print"></i> Dokumen
							Pencairan</a></li>
					<?php } elseif ($sts=="A" AND $saldopinjaman!=0) {?>
					<li class=""><a href="#tab44" data-toggle="tab"><i class="glyphicon glyphicon-print"></i> Dokumen
							Pencairan</a></li>
					<li class=""><a href="#tab74" data-toggle="tab"><i class="fa fa-history"></i> Riwayat Transaksi</a>
					</li>
					<li class=""><a href="#tabR" data-toggle="tab"><i class="fa fa-history"></i> Resceduling</a></li>
					<?php } elseif ($sts=="A" AND $saldopinjaman==0) {?>
					<li class=""><a href="#tab44" data-toggle="tab"><i class="glyphicon glyphicon-print"></i> Dokumen
							Pencairan</a></li>
					<li class=""><a href="#tab74" data-toggle="tab"><i class="fa fa-history"></i> Riwayat Transaksi</a>
					</li>
					<li class=""><a href="#tab84" data-toggle="tab"><i class="fa fa-gavel"></i> Validasi Pelunasan</a>
					</li>
					<?php } ?>
				</ul>
				<div id="tabs3c" class="tab-content">

					<div class="tab-pane active" id="tab14">
						<legend>
							<i class="fa fa-building"></i> Data Pinjaman
							<?php if ($sts=="P") { ?>
							<span class="pull-right <?= ($can['proposal'] > 20000000) ? 'hidden':''; ?>"
								style="margin-left: .5em;">
								<a href="#tabWL" id="wlClick" data-id="<?= $postId ?>" data-toggle="tab"
									class="btn btn-success mt-n-md"><i class="fa fa-recycle"></i> Waiting List</a>
							</span>
							<span class="pull-right">
								<a href="#tab114" data-toggle="tab" class="btn btn-inverse mt-n-md"><i
										class="fa fa-recycle"></i> Ubah Proposal</a>
							</span>
							<?php } elseif ($sts=="V") {?>
							<span class="pull-right" style="display: inline-block;  margin-top: -15px;">
								<a href="#tab64" data-toggle="tab" class="btn btn-warning mt-n-md" disabled
									style="color:#000; "><i class="fa fa-warning"></i> Pendanaan Belum Ditetapkan
									<br><span style="font-size:70%; padding-top:-10px">(silakan lapor ke Tim
										Pendanaan)</span></a>
							</span>
							<?php } elseif ($sts=="D") {?>
							<span class="pull-right">
								<a href="#tab64" data-toggle="tab" class="btn btn-danger mt-n-md"><i
										class="fa fa-wheelchair"></i> Masukkan ke Daftar Tunggu</a>
							</span>
							<?php } elseif ($sts=="W") { ?>
							<span class="pull-right">
								<button type="button" class="btn btn-danger mt-n-md" data-toggle="collapse"
									data-parent="#accordionCairIndividu" href="#collapseCairIndividu"
									value="<?php echo $row['id']; ?>" id="CairkanIndividu"><i class="fa fa-money"></i>
									Form Pencairan</button>
							</span>
							<?php } elseif ($sts=="A" AND $saldopinjaman==0) {?>
							<span class="pull-right">
								<a href="#tab84" data-toggle="tab" class="btn btn-danger mt-n-md"><i
										class="fa fa-gavel"></i> Validasi Pelunasan</a>
							</span>
							<?php } ?>
						</legend>
						<div class="panel-group mb-lg" id="accordionCairIndividu" data-toggle="collapse">
							<div class="panel panel-default">
								<div id="collapseCairIndividu" class="panel-collapse collapse">
									<div class="panel-body">
										<div id="FormPencairanIndividu"></div>
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
							<?php if ($sts=="P") { ?>
							<span class="pull-right">
								<button type="button" class="btn btn-danger mt-n-md" data-toggle="collapse"
									data-parent="#accordion" href="#collapseOne" value="<?php echo $row['id']; ?>"
									id="PilihPemanfaatProposal"><i class="glyphicon glyphicon-user"></i><i
										class="fa fa-plus"></i> Tambah Pemanfaat</button>
							</span>
							<?php } elseif ($sts=="V") {?>
							<span class="pull-right">
								<a href="#tab64" data-toggle="tab" class="btn btn-danger mt-n-md"><i
										class="fa fa-wheelchair"></i> Masukkan ke Daftar Tunggu</a>
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
							<legend><i class="glyphicon glyphicon-user"></i> Identitas Pemanfaat

								<span class="pull-right">
									<?php
										echo "<a href='#tab94' onclick='javascript:EditPemanfaat(\"{$row[nia]}\")' data-toggle='tab' class='btn btn-inverse mt-n-md'><i class='fa fa-recycle'></i> Ubah Data Pemanfaat</a>";
									?>
								</span>
							</legend>
						</header>
						<div id="TampilDataPemanfaat"></div>
					</div>


					<div class="tab-pane" id="tab94">
						<header>
							<legend><i class="fa fa-edit"></i> Edit Identitas penduduk</legend>
						</header>
						<div id="validation-form" class="form-horizontal form-label-left"
							data-parsley-priority-enabled="false" novalidate="novalidate">
							<fieldset>
								<div class="form-group">
									<label class="control-label col-sm-4">N I K / J K</label>
									<div class="col-sm-8">
										<div class="input-group col-sm-12">
											<input type="text" value="<?php echo $row['nik'];?>" name="nika" id="nika"
												class="form-control" maxlength="16" required="required"
												autocomplete="off" placeholder="Nomor Induk Kependudukan" />
											<select id="jka" name="jka" class="selectpicker" data-style="btn-gray"
												data-width="auto">
												<option value="<?php echo $row['jk'];?>"><?php echo $row['jk'];?>
												</option>
												<option value="L">L</option>
												<option value="P">P</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-4">Nama Lengkap</label>
									<div class="col-sm-8"><input type="text" name="namadepana" id="namadepana"
											class="form-control" value="<?php echo $row['namadepan'];?>"
											required="required" autocomplete="off" placeholder="Nama Depan"> </div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-4">Tempat, Tgl Lahir</label>
									<div class="col-sm-4"><input value="<?php echo $row['tempat_lahir'];?>"
											id="tempat_lahira" name="tempat_lahira" type="text" class="form-control"
											required="required" autocomplete="off" placeholder="Tempat Lahir"> </div>
									<div class="col-sm-4"><input value="<?php echo $row['tgl_lahir'];?>" id="tgl_lahira"
											name="tgl_lahira" type="text" class="form-control" required="required"
											autocomplete="off" placeholder="Tanggal Lahir"> </div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-4">Alamat</label>
									<div class="col-sm-8"><input value="<?php echo $row['alamat'];?>" id="alamata"
											name="alamata" type="text" class="form-control" required="required"
											autocomplete="off" placeholder="Alamat"> </div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-4">Phone</label>
									<div class="col-sm-8"><input value="<?php echo $row['hp'];?>" id="hpa" name="hpa"
											type="text" class="form-control" required="required" autocomplete="off"
											placeholder="Nomor Telpon"> </div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-4">Nomor KK</label>
									<div class="col-sm-8"><input value="<?php echo $row['kk'];?>" id="kka" name="kka"
											type="text" class="form-control" required="required" autocomplete="off"
											placeholder="Nomor KK"> </div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-4">Penjamin</label>
									<div class="col-sm-8"><input value="<?php echo $row['penjamin'];?>" id="penjamina"
											name="penjamina" type="text" class="form-control" required="required"
											autocomplete="off" placeholder="Penjamin"> </div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-4">Kekeluargaan</label>
									<div class="col-sm-8">
										<select id="hubungana" name="hubungana" class="selectpicker"
											data-style="btn-gray" data-width="auto">

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
										<select id="usahaa" name="usahaa" class="selectpicker" data-style="btn-gray"
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
								<button href="#tab24" data-toggle="tab" class="btn btn-inverse btn-rounded pull-right"
									id="SimpanEditAngg"><i class="fa fa-recycle"></i> Ubah Data</button>
								<a href="#tab24" data-toggle="tab" class="btn btn-default btn-rounded">Cancel</a>
							</div>
						</div>
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
									<label class="fs-sm mb-0">Untuk membuat Dokumen Pencairan, silahkan masukkan nomor
										SPK pada form dibawah ini :</label>
									<input type="text" name="spk_no" id="spk_no" class="form-control input-lg"
										required="required" autocomplete="off"
										placeholder="Masukkan Nomor SPK disini..." />
									<input type="hidden" name="idpinj" id="idpinj" value="<?php echo $idpinj; ?>" />
								</div>
								<div class="form-actions col-sm-8 mt-n-xs">
									<button class="btn btn-inverse btn-rounded pull-right" id="SimpanSPKNOIndividu"><i
											class="glyphicon glyphicon-edit"></i> Buat Dokumen Pencairan</button>
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
						<a class="pull-right mt-n-lg" data-toggle="collapse" data-parent="#accordionSPKNO"
							href="#collapseSPKNO"><i class="glyphicon glyphicon-edit"></i> Ubah Nomor SPK</a>
						<div class="panel-group mb-lg" id="accordionSPKNO" data-toggle="collapse">
							<div class="panel panel-default">
								<div id="collapseSPKNO" class="panel-collapse collapse">
									<div class="panel-body">
										<div class="form-group">
											<div class="input-group col-sm-8">
												<label class="fs-sm mb-0">Ubah nomor SPK dibawah ini :</label>
												<input type="text" name="spk_no" id="spk_no"
													class="form-control input-lg" value="<?php echo $spk_no; ?>"
													required="required" autocomplete="off"
													placeholder="Masukkan Nomor SPK disini..." />
												<input type="hidden" name="idpinj" id="idpinj"
													value="<?php echo $idpinj; ?>" />
											</div>
											<div class="form-actions col-sm-8 mt-n-xs">
												<button class="btn btn-inverse btn-rounded pull-right"
													id="SimpanSPKNOIndividu"><i class="glyphicon glyphicon-edit"></i>
													Ubah Nomor SPK</button>
												<a data-toggle="collapse" data-parent="#accordionSPKNO"
													href="#collapseSPKNO" class="btn btn-default btn-rounded">Tutup</a>
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
								Fitur ini dapat Anda gunakan jika setelah dilakukan verifikasi, ternyata ada kesalahan
								baik proposal maupun data
								verifikasinya.<br>
								Dengan klik tombol "YA" maka pinjaman ini akan kembali ke status PROPOSAL (P), dan
								terkirim kembali ke
								Tim Verifikasi untuk diVerifikasi ulang.<br>
								Apakah anda akan men-Verifikasi ulang pinjaman ini?
							</p>
							<a href="#tab14" data-toggle="tab"
								class="btn btn-default btn-rounded pull-right">Kembali</a>
							<?php echo "<a href='javascript:VerifikasiUlangIndividu(\"{$row['id']}\")' class='btn btn-inverse btn-rounded'><i class='fa fa-recycle'></i>  Ya, Verifikasi Ulang</a>"; ?>
						</div>
						<div class="col-sm-3">
						</div>
					</div>

					<div class="tab-pane" id="tab64">
						<legend>
							<i class="fa fa-wheelchair"></i> Konfirmasi Pindah ke Daftar Tunggu
						</legend>
						<div class="col-sm-3">
						</div>
						<?php
		$q_akt  =mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE 
		nia='$row[nia]' AND status='A' ORDER BY id DESC");
											
		$cari_akt=mysql_num_rows($q_akt);
		
		/*
		if($_SESSION['lokasi']=="0"){//lokasi 257
			if ($cari_akt>0) {
		?>
						<div class="form-actions bg-danger col-sm-6 mt-n-md">
							<p class="text-justify text-white">
								<div class='alert alert-danger mt animated fadeInDown'>
									<span class='create-server-name'></span><i class='fa fa-warning'></i>
									<strong>Perhatian</strong>
									<br>Pemanfaat ini masih terdeteksi memiliki pinjaman aktif, <br>
									Apakah anda yakin ingin memasuknya ke daftar tunggu?
								</div>
							</p>
							<p class="text-justify text-white">
								Untuk memasukkan proposal ke daftar tunggu, <br>silahkan masukkan Rencana Tanggal cair
							</p>
							<div class="form-group">
								<span class="fs-mini text-white">Rencana Tanggal Cair</span>
								<input name="tgl_cair" id="tgl_cair" type="text" class="form-control"
									value="<?php echo date('Y-m-d');?>" required="required" autocomplete="off"
									placeholder="Tanggal Cair" />
								<input name="id_pinj" id="id_pinj" type="hidden" class="form-control"
									value="<?php echo $id;?>" />
							</div>
							<a href="#tab14" data-toggle="tab"
								class="btn btn-default btn-rounded pull-right">Kembali</a>
							<button class="btn btn-inverse btn-rounded" id="GoWaitingIndividu"><i
									class="fa fa-wheelchair"></i> Masukkan ke Daftar Tunggu</button>
						</div>
						<?php }else{ ?>
						<div class="form-actions col-sm-6 mt-n-md">
							<p class="text-justify">
								Untuk memasukkan proposal ke daftar tunggu, silahkan masukkan Rencana Tanggal cair
							</p>
							<div class="form-group">
								<span class="fs-mini text-muted">Rencana Tanggal Cair</span>
								<input name="tgl_cair" id="tgl_cair" type="text" class="form-control"
									value="<?php echo date('Y-m-d');?>" required="required" autocomplete="off"
									placeholder="Tanggal Cair" />
								<input name="id_pinj" id="id_pinj" type="hidden" class="form-control"
									value="<?php echo $id;?>" />
							</div>
							<a href="#tab14" data-toggle="tab"
								class="btn btn-default btn-rounded pull-right">Kembali</a>
							<button class="btn btn-inverse btn-rounded" id="GoWaitingIndividu"><i
									class="fa fa-wheelchair"></i> Masukkan ke Daftar Tunggu</button>
						</div>
						<?php }}else{*/
		
		if ($cari_akt>0) {
		$t_akt	=mysql_fetch_array($q_akt);
		?>
						<div class="form-actions bg-danger col-sm-6 mt-n-md">
							<p class="text-justify text-white">
								Maaf, Anda tidak dapat memasukkan pinjaman ini ke daftar tunggu,<br>
								Pemanfaat ini masih terdeteksi memiliki pinjaman aktif dengan loan id anggota
								<b><?php echo $t_akt['id'];?></b>.<br>
							</p>
							<a href="#tab14" data-toggle="tab" class="btn btn-danger btn-rounded"><i
									class="glyphicon glyphicon-chevron-left"></i> Kembali</a>
						</div>
						<?php }else{ ?>
						<div class="form-actions col-sm-6 mt-n-md">
							<p class="text-justify">
								Untuk memasukkan proposal ke daftar tunggu, silahkan masukkan Rencana Tanggal cair
							</p>
							<div class="form-group">
								<span class="fs-mini text-muted">Rencana Tanggal Cair</span>
								<input name="tgl_cair" id="tgl_cair" type="text" class="form-control"
									value="<?php echo date('Y-m-d');?>" required="required" autocomplete="off"
									placeholder="Tanggal Cair" />
								<input name="id_pinj" id="id_pinj" type="hidden" class="form-control"
									value="<?php echo $id;?>" />
							</div>
							<a href="#tab14" data-toggle="tab"
								class="btn btn-default btn-rounded pull-right">Kembali</a>
							<button class="btn btn-inverse btn-rounded" id="GoWaitingIndividu"><i
									class="fa fa-wheelchair"></i> Masukkan ke Daftar Tunggu</button>
						</div>
						<?php } ?>
						<div class="col-sm-3">
						</div>
					</div>

					<div class="tab-pane" id="tab74">
						<legend>
							<i class="fa fa-history"></i> Riwayat Transaksi
						</legend>
						<div id="RiwayatTransaksiIndividu"></div>
					</div>

					<div class="tab-pane" id="tab84">
						<div id="ValidasiPelunasanIndividu"></div>
					</div>

					<div class="tab-pane" id="tabX">
						<legend>
							<i class="fa fa-times"></i> Konfirmasi Hapus Proposal
						</legend>
						<div class="col-sm-3">
						</div>
						<div class="form-actions col-sm-6 mt-n-md">
							<p class="text-justify">
								Fitur ini dapat Anda gunakan jika Anda akan menghapus data proposal Individu<br>
								Dengan klik tombol "YA" maka proposal akan hilang, namun data penduduk YBS masih
								ada.<br>
								Apakah anda akan menghapus proposal ini?
							</p>
							<a href="#tab14" data-toggle="tab"
								class="btn btn-default btn-rounded pull-right">Kembali</a>
							<?php echo "<a href='javascript:deleteProposal(\"{$row['id']}\")' class='btn btn-inverse btn-rounded'><i class='fa fa-times'></i>  Ya, Hapus Proposal</a>"; ?>
						</div>
						<div class="col-sm-3">
						</div>
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
								Dengan klik tombol "YA" maka pinjaman ini akan berstatus R, dan akan membuat pinjaman
								baru dengan Alokasi sebesar saldo yang ada, yaitu
								Rp. <?php echo number_format($saldopinjaman);?><br>
							</p>
							<input type="hidden" value="<?php echo $nia;?>" id="niares" />
							<input type="hidden" value="<?php echo $idpinj;?>" id="idpinjres" />
							<div class="form-group mb-xs">
								<label class="fs-sm mb-0">Tanggal</label>
								<input type="text" class="form-control" value="<?php echo date('Y-m-d');?>"
									name="tglres" id="tglres" autocomplete="off" placeholder="Tanggal">
							</div>
							<div class="form-group mb-xs">
								<label class="fs-sm mb-0">Alokasi</label>
								<input type="text" class="form-control" value="<?php echo $saldopinjaman;?>"
									name="alokasires" id="alokasires" autocomplete="off" placeholder="Alokasi">
								<input type="hidden" value="<?php echo $saldopinjaman;?>" name="saldopinjamanres"
									id="saldopinjamanres">
							</div>
							<div class="form-group mb-xs">
								<label class="fs-sm mb-0">Prosentase Jasa</label>
								<input type="text" class="form-control" value="<?php echo $row['pros_jasa'];?>"
									name="pros_jasares" id="pros_jasares" autocomplete="off" placeholder="Jasa">
							</div>
							<div class="form-group mb-xs">
								<label class="fs-sm mb-0">Jenis Jasa</label>
								<select id="jenis_jasares" name="jenis_jasares" class="select2 form-control"
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
								<input type="text" class="form-control" value="<?php echo $row['jangka'];?>"
									name="jangkares" id="jangkares" autocomplete="off" placeholder="Jangka">
							</div>
							<div class="form-group mb-xs">
								<label class="fs-sm mb-0">Sistem Angsuran Pokok</label>
								<select id="sistemres" name="sistemres" class="select2 form-control" tabindex="-1">
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
								<select id="sistemjres" name="sistemjres" class="select2 form-control" tabindex="-1">
									<?php 
																echo "<option value='$row[sistem_angsuran]'>$row[nama_sistem]</option>";
																$views=mysql_query("select * from sistem_angsuran");
																	while($rowjres=mysql_fetch_array($views)){
																	echo "<option value='$rowjres[id]'>$rowjres[nama_sistem]</option>";
																	} ?>
								</select>
							</div>
							<div class="form-group mb-xs">
								<label class="fs-sm mb-0">Jenis Pinajaman</label>
								<input type="hidden" value="<?php echo $jenis_pp;?>" name="jenis_ppasli"
									id="jenis_ppasli">
								<select id="jenis_ppres" name="jenis_ppres" class="select2 form-control" tabindex="-1">
									<?php 
																echo "<option value='$jenis_pp'>$row[deskripsi_jpp] ($row[nama_jpp])</option>";
																$viewjpp=mysql_query("select * from jenis_produk_pinjaman Where
																	lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
																	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%'");
																	while($rowjpp=mysql_fetch_array($viewjpp)){
																	echo "<option value='$rowjpp[id]'>$rowjpp[deskripsi_jpp] ($rowjpp[nama_jpp])</option>";
																	} ?>
								</select>
							</div>
							<div id="RescedulingBerhasil"></div>
							<a href="#tab14" data-toggle="tab"
								class="btn btn-default btn-rounded pull-right">Kembali</a>
							<a href="" class='btn btn-inverse btn-rounded' id="SimpanRescedulingIndividu"><i
									class='fa fa-times'></i> Ya, Resceduling pinjaman ini</a>
						</div>
						<div class="col-sm-3">
						</div>
					</div>

					<div class="tab-pane" id="tabWL">
						<header>
							<legend><i class="fa fa-edit"></i> Witing List</legend>
						</header>
						<div id="validation-form" class="form-horizontal form-label-left"
							data-parsley-priority-enabled="false" novalidate="novalidate">
							<fieldset id="fieldWL">
							</fieldset>

						</div>
					</div>

					<div class="tab-pane" id="tab114">
						<header>
							<legend><i class="fa fa-edit"></i> Ubah Proposal</legend>
						</header>
						<div id="validation-form" class="form-horizontal form-label-left"
							data-parsley-priority-enabled="false" novalidate="novalidate">
							<fieldset>
								<div class="row">
									<div class="col-md-1">
									</div>
									<div class="col-md-5">

										<div class="form-group mb-xs">
											<label class="fs-sm mb-0">Tanggal Proposal</label>
											<input type="text" class="form-control"
												value="<?php echo $row['tgl_proposal'];?>" name="tgl_proposal"
												id="tgl_proposal" autocomplete="off" placeholder="Tanggal Proposal">
										</div>

										<div class="form-group mb-xs">
											<label class="fs-sm mb-0">Alokasi Pengajuan</label>
											<input type="text" class="form-control"
												value="<?php echo $row['proposal'];?>" name="proposali" id="proposali"
												autocomplete="off" placeholder="Alokasi Pengajuan">
										</div>

										<div class="form-group mb-xs">
											<label class="fs-sm mb-0">Prosentase Jasa (%)</label>
											<input type="text" class="form-control"
												value="<?php echo $row['pros_jasa'];?>" name="pros_jasa" id="pros_jasa"
												autocomplete="off" placeholder="Prosentase Jasa">
										</div>

										<div class="form-group mb-xs">
											<label class="fs-sm mb-0">Jenis Jasa</label>
											<select id="jenis_jasa" name="jenis_jasa" class="select2 form-control"
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
											<input type="text" class="form-control" value="<?php echo $row['jangka'];?>"
												name="jangka" id="jangka" autocomplete="off" placeholder="Jangka">
										</div>

										<div class="form-group mb-xs">
											<label class="fs-sm mb-0">Sistem Angsuran</label>
											<select id="sistem" name="sistem" class="select2 form-control"
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
											<select id="jenis_pp" name="jenis_pp" class="select2 form-control"
												tabindex="-1">
												<?php 
																echo "<option value='$row[jenis_pp]'>$row[nama_jpp] ($row[deskripsi_jpp])</option>";
																$view=mysql_query("select * from jenis_produk_pinjaman Where
																	lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%' OR 
																	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi]%'");
																	while($rows=mysql_fetch_array($view)){
																	echo "<option value='$rows[id]'>$rows[nama_jpp] ($rows[deskripsi_jpp])</option>";
																	} ?>
											</select>
										</div>

										<input type="hidden" value="<?php echo $idpinj;?>" name="id_pinj"
											id="id_pinj" />
										<input type="hidden" value="<?php echo $row['nia'];?>" name="nia" id="nia" />
									</div>
									<div class="col-md-5">
										<div class="form-actions">
											<p><strong>Konfirmasi</strong><br>
												Apakah anda akan merubah data pinjaman tersebut?
											</p>

											<a href="#tab14" data-toggle="tab"
												class="btn btn-default btn-rounded pull-right">Kembali</a>
											<button href="#tab14" data-toggle="tab" class="btn btn-inverse btn-rounded"
												id="SimpanEditProposalIndividu"><i class="fa fa-recycle"></i> Ya, Ubah
												Data</button>
										</div>
									</div>

								</div>
							</fieldset>

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