<?php session_start(); 	?>

<script type="text/javascript">
	function MM_openBrWindow(theURL, winName, features) { //membuka window untuk print
		window.open(theURL, winName, features);
	}

	$(document).ready(function () {


		//apabila terjadi event onchange terhadap object <select id=jenis_kegiatan>
		// $("#jenis_kegiatan").change(function () {
		// 	var jenis_kegiatan = $("#jenis_kegiatan").val();
		// 	$.ajax({
		// 		url: "modul/penduduk/ambil_nama_usaha.php",
		// 		data: "jenis_kegiatan=" + jenis_kegiatan,
		// 		cache: false,
		// 		success: function (msg) {
		// 			//jika data sukses diambil dari server kita tampilkan
		// 			//di <select id=jenis_buku>
		// 			$("#usaha").html(msg);
		// 		}
		// 	});
		// });

		$("#usaha").change(function () {
			var usaha = $("#usaha").val();
			$.ajax({
				url: "modul/penduduk/ambil_nama_usaha.php",
				data: "id_usaha=" + usaha,
				cache: false,
				success: function (msg) {
					$("#jenis_kegiatan").val(msg);
				}
			});
		});

		<?php
		if ($_POST['nik'] >= 16) {
			?>
			$("#namadepan").focus(); <?php
		} ?>

		$("#hp").keypress(function (data) {
			if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
				return false;
			}
		});
		$("#kk").keypress(function (data) {
			if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
				return false;
			}
		});


		$("#BlackListConfirm").click(function () {
			var nik = $('#nik').val();

			$.ajax({
				type: "POST",
				url: "modul/pinjaman/register/simpan_blacklist.php",
				data: "nik=" + nik,
				success: function (data) {
					$("#konfirmasi").load('modul/penduduk/blacklist.php');

				}

			});

		});


		$("#SimpanPenduduk").click(function () {
			var nik = $('#nik').val();
			var namadepan = $('#namadepan').val();
			var jk = $('#jk').val();
			var tempat_lahir = $('#tempat_lahir').val();
			var tgl_lahir = $('#tgl_lahir').val();
			var desaa = $('#desaa').val();
			var alamat = $('#alamat').val();
			var hp = $('#hp').val();
			var kk = $('#kk').val();
			var nik_penjamin = $('#nik_penjamin').val();
			var penjamin = $('#penjamin').val();
			var hp_penjamin = $('#hp_penjamin').val();
			var hubungan = $('#hubungan').val();
			var usaha = $('#usaha').val();
			var jenis_jaminan = $('#jenis_jaminan').val();
			var nomor_milik = $('#nomor_milik').val();
			var merk = $('#merk').val();
			var alamat_jaminan = $('#alamat_jaminan').val();
			var nilai_jaminan = $('#nilai_jaminan').val();
			var uname = $('#uname').val();
			var pass = $('#pass').val();
			var foto = $('#foto').val();

			if (nik.length == 0) {
				$("#konfirmasi").load('modul/penduduk/dilarang_nik_kosong.php');
				$("#nik").focus();
				return false;
			}

			if (nik.length < 16) {
				$("#konfirmasi").load('modul/penduduk/dilarang_nik.php');
				$("#nik").focus();
				return false;
			}
			if (namadepan.length == 0) {
				$("#konfirmasi").load('modul/penduduk/dilarang_kosong.php');
				$("#namadepan").focus();
				return false;
			}

			if (hp.length == 0) {
				$("#konfirmasi").load('modul/penduduk/dilarang_hp_kosong.php');
				$("#hp").focus();
				return false;
			}


			if (desaa.length == 0) {
				$("#konfirmasi").load('modul/penduduk/dilarang_kosong.php');
				$("#desaa").focus();
				return false;
			}

			$.ajax({
				type: "POST",
				url: "modul/penduduk/simpan.php",
				data: "nik=" + nik +
					"&namadepan=" + namadepan +
					"&jk=" + jk +
					"&tempat_lahir=" + tempat_lahir +
					"&tgl_lahir=" + tgl_lahir +
					"&desaa=" + desaa +
					"&alamat=" + alamat +
					"&hp=" + hp +
					"&kk=" + kk +
					"&nik_penjamin=" + nik_penjamin +
					"&penjamin=" + penjamin +
					"&hp_penjamin=" + hp_penjamin +
					"&hubungan=" + hubungan +
					"&usaha=" + usaha +
					"&jenis_jaminan=" + jenis_jaminan +
					"&nomor_milik=" + nomor_milik +
					"&merk=" + merk +
					"&alamat_jaminan=" + alamat_jaminan +
					"&nilai_jaminan=" + nilai_jaminan +
					"&uname=" + uname +
					"&pass=" + pass +
					"&foto=" + foto,

				success: function (data) {

					//$("#form_register").load('modul/penduduk/cari_penduduk.php');

					$("#konfirmasi").load('modul/penduduk/sukses_registrasi.php');

					$("#nik").keyup();
					//return false;


				}
			});

		});

		$("#SimpanNewAnggota").click(function () {
			var nik = $('#nik').val();
			var tgl_transaksi = $('#tgl_transaksi').val();
			var rek_anggota = $('#rek_anggota').val();
			var simpok = $('#simpok').val();
			var simjib = $('#simjib').val();
			var simsuka = $('#simsuka').val();

			$.ajax({
				type: "POST",
				url: "modul/penduduk/simpan_new_anggota.php",
				data: "nik=" + nik +
					"&tgl_transaksi=" + tgl_transaksi +
					"&rek_anggota=" + rek_anggota +
					"&simpok=" + simpok +
					"&simjib=" + simjib +
					"&simsuka=" + simsuka,

				success: function (data) {
					$("#suksessna").load('modul/penduduk/sukses_anggota.php');

				}
			});

		});


		$("#MutasiAntarKec").click(function () {
			var cari = $("#MutasiAntarKec").val();

			$.ajax({
				type: "POST",
				url: "modul/penduduk/form_mutasi.php",
				data: "cari=" + cari,
				success: function (data) {
					$("#FormMutasi").html(data);
				}
			});
		});

		$("#ProposalPeternakan").click(function () {
			var nik = $("#ProposalPeternakan").val();

			$.ajax({
				type: "POST",
				url: "modul/pinjaman/register/input_pinjaman_peternakan.php",
				data: "nik=" + nik,
				success: function (data) {
					$("#FormProposalPeternakan").html(data);
				}
			});
		});

		$("#ProposalIndividu").click(function () {
			var nik = $("#ProposalIndividu").val();

			$.ajax({
				type: "POST",
				url: "modul/pinjaman/register/input_pinjaman_individu.php",
				data: "nik=" + nik,
				success: function (data) {
					$("#FormProposalIndividu").html(data);
				}
			});
		});


		$("#ProposalKelompok").click(function () {
			var nik = $("#ProposalIndividu").val();


			$.ajax({
				type: "POST",
				url: "modul/pinjaman/register/input_pinjaman_ke_kelompok.php",
				data: "nik=" + nik,
				success: function (data) {
					$("#FormProposalKelompok").html(data);
				}
			});
		});



	});
</script>

<?php
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table	= "anggota_$_SESSION[kd_kab]";
$id	= $_POST['nik'];
$text	= "SELECT *
			FROM $table WHERE nik= '$id'";
$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);
if ($row>0 AND $id>=16){
	$r=mysql_fetch_array($sql);
	
	$desa=mysql_fetch_array(mysql_query("select * from kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND d.id='$r[desa]' ")); 
	$pek=mysql_fetch_array(mysql_query("select * from jenis_kegiatan k, usaha u WHERE k.id=u.jenis_kegiatan AND u.id='$r[usaha]' order by u.nama_usaha "));
	$hub=mysql_fetch_array(mysql_query("select * from keluarga WHERE id='$r[hubungan]' ")); 
	$jaminan 		= explode(",", $r['jaminan']);
	$jj=mysql_fetch_array(mysql_query("select * from jenis_jaminan WHERE id='$jaminan[0]' ")); 
													
	$nik			=$r['nik'];
	$nianggota		=$r['id'];
	$namadepan		=$r['namadepan'];
	$jk				=$r['jk'];
	$tempat_lahir	=$r['tempat_lahir'];
	$tgl_lahir		=$r['tgl_lahir'];
	$alamat			=$r['alamat'];
	$desaa			=$desa['nama_desa'];
	$kd_kec			=$desa['kd_kec'];
	$hp				=$r['hp'];
	$kk				=$r['kk'];
	$usaha			=$pek['nama_usaha'];
	$id_usaha		=$pek['id'];
	$id_kegiatan	=$pek['id_kegiatan'];
	$jenis_kegiatan	=$pek['deskripsi_jk'];
	$foto			=$r['foto'];
	$nik_penjamin	=$r['nik_penjamin'];
	$penjamin		=$r['penjamin'];
	$hp_penjamin	=$r['hp_penjamin'];
	$id_hubungan	=$hub['id'];
	$hubungan		=$hub['kekeluargaan'];
	
	$jenis_jaminan	=$jj['nama_jaminan'];
	$nomor_milik	=$jaminan[1];
	$merk			=$jaminan[2];
	$alamat_jaminan	=$jaminan[3];
	$nilai_jaminan	=$jaminan[4];
	$uname			=$r['uname'];
	$pass			=$r['pass'];
	$ket			="&nbsp;<br>&nbsp;";
	
}else{
	$kec=mysql_fetch_array(mysql_query("select * from kabupaten b, kecamatan c WHERE b.id=c.kd_kab AND c.id='$_SESSION[lokasi]' ")); 
	$tgl	=substr($id,6,2);
	$bln	=substr($id,8,2);
	$thn	=substr($id,10,2);
	if($tgl>=40){$tg=$tgl-40;}else{$tg=$tgl;}
	$nik			="";
	$nianggota		="";
	$namadepan		="";
	$jk				="P";
	$tempat_lahir	=$kec['nama_kab'];
	$tgl_lahir		="19$thn-$bln-$tg";
	$alamat			="";
	$desaa			="-- Silahkan Pilih Desa/Kelurahan --";
	$kd_kec			=$kec['kd_kec'];
	$hp				="08";
	$kk				="";
	$id_kegiatan	="4";
	$jenis_kegiatan	="Pertanian";
	$id_usaha		="22";
	$usaha			="Tani";
	$foto			="";
	$nik_penjamin	="";
	$penjamin		="";
	$hp_penjamin	="08";
	$id_hubungan	="1";
	$hubungan		="Suami";
	$jenis_jaminan	="-- Silahkan Pilih Jenis Jaminan --";
	$nomor_milik	="";
	$merk			="";
	$alamat_jaminan	="";
	$nilai_jaminan	="";
	$uname			=$id;
	$pass			=date('Y').substr($id,14,2);
	$ket			="* Silahkan lengkapi Data Dibawah ini, kemudian klik tombol SIMPAN DATA :<br>&nbsp;";
}

$data_js = mysql_query("SELECT * FROM usaha ORDER BY nama_usaha ASC");
?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class="col-sm-7">
	<?php echo "<div class='text-danger'>$ket</div>";?>

	<!-- PROPOSAL KELOMPOK -->

	<div class="panel-group mb-lg" id="accordionKelompok" data-toggle="collapse">
		<div class="panel panel-default">
			<div id="collapseKelompok" class="panel-collapse collapse">
				<div class="panel-body">
					<?php
												$sqlmut=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where nia='$r[id]' AND `status`='P' OR nia='$r[id]' AND `status`='V' OR nia='$r[id]' AND `status`='W' OR nia='$r[id]' AND `status`='M' ");
												$lacakmut	= mysql_num_rows($sqlmut);
												$sqlkk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa where a.id=pa.nia AND a.kk='$r[kk]' AND a.kk!='0' AND a.kk!='' ");
												$lacak_kk	= mysql_num_rows($sqlkk);
													if ($lacakmut>0){
														$pa=mysql_fetch_array($sqlmut);
														echo "
														<div class='alert alert-danger mt animated fadeInDown'>
															<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
															<span class='create-server-name'></span><i class='fa fa-warning'></i> <strong>Perhatian</strong> 
															<br>YBS terdeteksi memiliki pinjaman ($pa[jenis_pinjaman]) sebesar ".number_format($pa['alokasi'])." dengan status $pa[status]
														</div>
														";
													}else if ($lacak_kk>0){
														$rkk=mysql_fetch_array($sqlkk);
														if($rkk['jenis_pinjaman']=="K"){$jp="Kelompok";}else{$jp="Individu";}
														echo "
														<div class='alert alert-danger mt animated fadeInDown'>
															<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
															<span class='create-server-name'></span><i class='fa fa-warning'></i> 
															<strong>Perhatian</strong> <br>
															Nomor KK <b>$r[kk]</b> telah memiliki Pinjaman $jp a.n. <b>".strtoupper($rkk['namadepan'])."</b> NIK. $rkk[nik] Loan ID.$rkk[id] Status $rkk[status]
														</div>";
													}else{
														echo "<div id='FormProposalKelompok'></div>";
													}
											?>

				</div>
			</div>
		</div>
	</div>


	<!-- PROPOSAL INDIVIDU -->
	<div class="panel-group" id="accordionIndividu" data-toggle="collapse">
		<div class="panel panel-default">
			<div id="collapseIndividu" class="panel-collapse collapse">
				<div class="panel-body">
					<?php
												$sqlmut=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where nia='$r[id]' AND `status`='P' OR nia='$r[id]' AND `status`='V' OR nia='$r[id]' AND `status`='W' OR nia='$r[id]' AND `status`='M' ");
												$lacakmut	= mysql_num_rows($sqlmut);
												$sqlkk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa where a.id=pa.nia AND a.kk='$r[kk]' AND a.kk!='0' AND a.kk!='' AND pa.status!='L' AND pa.status!='R' ");
												$lacak_kk	= mysql_num_rows($sqlkk);
													if ($lacakmut>0){
														$pa=mysql_fetch_array($sqlmut);
														echo "
														<div class='alert alert-danger mt animated fadeInDown'>
															<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
															<span class='create-server-name'></span><i class='fa fa-warning'></i> <strong>Perhatian</strong> 
															<br>YBS terdeteksi memiliki pinjaman ($pa[jenis_pinjaman]) sebesar ".number_format($pa['alokasi'])." dengan status $pa[status]
														</div>
														";
													}else if ($lacak_kk>0){
														$rkk=mysql_fetch_array($sqlkk);
														if($rkk['jenis_pinjaman']=="K"){$jp="Kelompok";}else{$jp="Individu";}
														echo "
														<div class='alert alert-danger mt animated fadeInDown'>
															<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
															<span class='create-server-name'></span><i class='fa fa-warning'></i> 
															<strong>Perhatian</strong> <br>
															Nomor KK <b>$r[kk]</b> telah memiliki Pinjaman $jp a.n. <b>".strtoupper($rkk['namadepan'])."</b> NIK. $rkk[nik] Loan ID.$rkk[id] Status $rkk[status]
														</div>";
													}else{
														echo "<div id='FormProposalIndividu'></div>";
													}
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- PROPOSAL PETERNAKAN -->
	<div class="panel-group" id="accordionPeternakan" data-toggle="collapse">
		<div class="panel panel-default">
			<div id="collapsePeternakan" class="panel-collapse collapse">
				<div class="panel-body">
					<?php
												$sqlmut=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where nia='$r[id]' AND `status`='P' OR nia='$r[id]' AND `status`='V' OR nia='$r[id]' AND `status`='W' OR nia='$r[id]' AND `status`='M' ");
												$lacakmut	= mysql_num_rows($sqlmut);
													if ($lacakmut>0){
														$pa=mysql_fetch_array($sqlmut);
														echo "
														<div class='alert alert-danger animated fadeInDown'>
															<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
															<span class='create-server-name'></span><i class='fa fa-warning'></i> <strong>Perhatian</strong> 
															<br>YBS terdeteksi memiliki pinjaman ($pa[jenis_pinjaman]) sebesar ".number_format($pa['alokasi'])." dengan status $pa[status]
														</div>
														";
													}else{
														echo "<div id='FormProposalPeternakan'></div>";
													}
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- MUTASI -->

	<div class="panel-group" id="accordionMutasi" data-toggle="collapse">
		<div class="panel panel-default">
			<div id="collapseMutasi" class="panel-collapse collapse">
				<div class="panel-body">
					<?php
												$sqlmut=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where nia='$r[id]' AND status!='L' ");
												$lacakmut	= mysql_num_rows($sqlmut);
													if ($lacakmut>0){
														echo "
														<div class='alert alert-info mt animated fadeInDown'>
															<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
															<span class='create-server-name'></span><i class='fa fa-warning'></i> <strong>Anda tidak dapat Mutasi</strong> 
															<br>YBS memiliki proposal/pinjaman aktif
														</div>
														";
													}else{
														echo "<div id='FormMutasi'></div>";
													}
					?>
				</div>
			</div>
		</div>
	</div>



	<div class="panel-group mb-lg" id="accordion2" data-toggle="collapse">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2"
						style="text-decoration:none; font-weight: bold">
						1. IDENTITAS PENDUDUK
						<i class="fa fa-angle-down pull-right"></i>
					</a>
				</h5>
			</div>
			<div id="collapseOne2" class="panel-collapse collapse in">
				<div class="panel-body" style='background-color:#f8f8f8;'>
					<input type="hidden" name="nik" id="nik" value="<?php echo $nik; ?>" />
					<div class="form-group">
						<label class="col-sm-4 control-label" for="appended-input">N I A</label>
						<div class="col-sm-8">
							<input type="text" name="" value="<?php echo $nianggota;?>" id="" class="form-control"
								required="required" autocomplete="off" placeholder="" disabled />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="appended-input">Nama Lengkap</label>
						<div class="col-sm-8">
							<input type="text" name="namadepan" value="<?php echo $namadepan;?>" id="namadepan"
								class="form-control" required="required" autocomplete="off"
								placeholder="Nama Lengkap" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label" for="appended-input">Jenis Kelamin</label>
						<div class="col-sm-6">
							<select class="select2 form-control" tabindex="-1" data-width="auto"
								data-minimum-results-for-search="10" name="jk" id="jk">
								<option value="<?php echo $jk;?>"><?php echo $jk;?></option>
								<option value="P">P</option>
								<option value="L">L</option>
							</select>
							<!--<label class="form-check" for="jk1">-->
							<!--                                      <input class="form-check-input" name="jk" type="radio" onClick="return false" value="P" <?= ($jk == 'P') ? 'checked':''; ?>>-->
							<!--                                      <label class="form-check-label">-->
							<!--                                        P-->
							<!--                                      </label>-->
							<!--                                    </label>-->
							<!--                                    <label class="form-check" for="jk2">-->
							<!--                                      <input class="form-check-input" name="jk" type="radio" onClick="return false" value="L" <?= ($jk == 'L') ? 'checked':''; ?>>-->
							<!--                                      <label class="form-check-label">-->
							<!--                                        L-->
							<!--                                      </label>-->
							<!--                                    </label>-->
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Tempat / Tgl Lahir</label>
						<div class="col-sm-4"><input type="text" value="<?php echo $tempat_lahir;?>" name="tempat_lahir"
								id="tempat_lahir" class="form-control" required="required" autocomplete="off"
								placeholder="Tempat Lahir"></div>

						<div class="col-sm-4"><input type="text" value="<?php echo $tgl_lahir;?>" name="tgl_lahir"
								id="tgl_lahir" class="form-control" required="required" autocomplete="off"
								placeholder="Tgl (YYYY-MM-DD)"> </div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Alamat KTP</label>
						<div class="col-sm-8"><input type="text" value="<?php echo $alamat;?>" name="alamat" id="alamat"
								maxlength="50" class="form-control" required="required" autocomplete="off"
								placeholder="Dusun/Jalan/Kampung/RT/RW"> </div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label">Desa/Kelurahan</label>
						<div class="col-sm-8">
							<select name="desaa" id="desaa" data-placeholder="-- Pilh Sub Laporan --" data-width="auto"
								data-minimum-results-for-search="10" tabindex="-1" class="select2 form-control">
								<?php 
																	echo "<option value='$desa[id]'>$desaa</option>";
$view=mysql_query("select * from desa where kd_kec='$_SESSION[lokasi]'  order by kd_desa asc"); //DESA
																		while($row=mysql_fetch_array($view)){
																		echo "<option value='$row[id]'>$row[nama_desa]</option>";
																		}
																	?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-4">Nomor HP</label>
						<div class="col-sm-8"><input type="text" value="<?php echo $hp;?>" name="hp" maxlength="14"
								class="form-control" id="hp" required="required" autocomplete="off"
								placeholder="Nomor Handphone"> </div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Nomor KK</label>
						<div class="col-sm-8"><input type="text" value="<?php echo $kk;?>" name="kk" maxlength="16"
								class="form-control" id="kk" required="required" autocomplete="off"
								placeholder="Nomor Kartu Keluarga"> </div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="appended-input">Jenis Kegiatan / Usaha</label>
						<input type="hidden" name="jenis_kegiatan" id="jenis_kegiatan">

						<div class="col-sm-8">
							<select id="usaha" name="usaha"
								data-placeholder="-- Pilih Jenis Kegiatan --" data-width="auto"
								data-minimum-results-for-search="10" tabindex="-1" class="select2 form-control">
								<?php 
									echo "<option value='$id_usaha'>$usaha</option>";
									while ($rows = mysql_fetch_array($data_js)) {
										if ($rows['id'] == $id_usaha) continue;
										echo "<option value='$rows[id]'>$rows[nama_usaha]</option>";
									}
								?>
							</select>
						</div>
					</div>
					<!--<div class="form-group">-->
					<!--                               <label class="control-label col-sm-4">Link Foto</label>-->
					<!--                               <div class="col-sm-8"><input type="text" name="foto" class="form-control" id="foto" value="<?php echo $foto;?>"-->
					<!--	required="required" autocomplete="off" placeholder="-- Gunakan link dari Google Foto, Facebook, Google Drive, dll --"> <br>Klik kanan foto, kemudian Copy Image Location</div>-->
					<!--                           </div>-->
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading collapsed">
				<h5 class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo2"
						style="text-decoration:none; font-weight: bold">
						2. IDENTITAS PENJAMIN
						<i class="fa fa-angle-down pull-right"></i>
					</a>
				</h5>
			</div>
			<div id="collapseTwo2" class="panel-collapse collapse">
				<div class="panel-body" style='background-color:#f8f8f8;'>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="appended-input">NIK Penjamin</label>
						<div class="col-sm-8">
							<input type="text" value="<?php echo $nik_penjamin;?>" name="nik_penjamin" id="nik_penjamin"
								class="form-control" required="required" autocomplete="off" placeholder="NIK Penjamin">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="appended-input">Nama Lengkap</label>
						<div class="col-sm-8">
							<input type="text" value="<?php echo $penjamin;?>" name="penjamin" id="penjamin"
								class="form-control" required="required" autocomplete="off"
								placeholder="Nama Keluarga Penjamin">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="appended-input">No HP Penjamin</label>
						<div class="col-sm-8">
							<input type="text" value="<?php echo $hp_penjamin;?>" name="hp_penjamin" id="hp_penjamin"
								class="form-control" required="required" autocomplete="off"
								placeholder="No HP Penjamin">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="appended-input">Hubungan</label>
						<div class="col-sm-8">
							<select id="hubungan" name="hubungan" class="form-control" data-width="auto">
								<?php
													echo "<option value='$id_hubungan'>$hubungan</option>";
													$data=mysql_query("select * from keluarga order by id asc"); //KELUARGA
														while($rows=mysql_fetch_array($data)){
														echo "<option value='$rows[id]'>$rows[kekeluargaan]</option>";
														} ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5 class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree2"
						style="text-decoration:none; font-weight: bold">
						3. IDENTITAS JAMINAN
						<i class="fa fa-angle-down pull-right"></i>
					</a>
				</h5>
			</div>
			<div id="collapseThree2" class="panel-collapse collapse">
				<div class="panel-body" style='background-color:#f8f8f8;'>
					<div class="form-group">
						<label class="col-sm-4 control-label" for="appended-input">Jenis Jaminan</label>
						<div class="col-sm-8">
							<select id="jenis_jaminan" name="jenis_jaminan" class="form-control" data-width="auto">
								<?php
													echo "<option value='$jj[id]'>$jenis_jaminan</option>";
													$data=mysql_query("select * from jenis_jaminan order by id asc"); //KELUARGA
														while($rows=mysql_fetch_array($data)){
														echo "<option value='$rows[id]'>$rows[nama_jaminan]</option>";
														} ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Nomor Kepemilikan</label>
						<div class="col-sm-8"><input type="text" name="nomor_milik" class="form-control"
								id="nomor_milik" value="<?php echo $nomor_milik;?>" required="required"
								autocomplete="off" placeholder="Nomor Bukti Kepemilikan"> </div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Merk / Type</label>
						<div class="col-sm-8"><input type="text" name="merk" class="form-control" id="merk"
								value="<?php echo $merk;?>" required="required" autocomplete="off"
								placeholder="Merk / Type"> </div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Alamat/Lokasi Jaminan</label>
						<div class="col-sm-8"><input type="text" name="alamat_jaminan" class="form-control"
								id="alamat_jaminan" value="<?php echo $alamat_jaminan;?>" required="required"
								autocomplete="off" placeholder="Alamat/Lokasi Jaminan"> </div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Nilai Jaminan</label>
						<div class="col-sm-8"><input type="text" name="nilai_jaminan" class="form-control"
								id="nilai_jaminan" value="<?php echo $nilai_jaminan;?>" required="required"
								autocomplete="off" placeholder="Nilai Jaminan"> </div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default hidden">
			<div class="panel-heading">
				<h5 class="panel-title">
					<a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour2"
						style="text-decoration:none; font-weight: bold">
						4. AKUN LOGIN
						<i class="fa fa-angle-down pull-right"></i>
					</a>
				</h5>
			</div>
			<div id="collapseFour2" class="panel-collapse collapse">
				<div class="panel-body" style='background-color:#f8f8f8;'>
					<div class="form-group">
						<label class="control-label col-sm-4">Username</label>
						<div class="col-sm-8"><input type="text" name="uname" class="form-control" id="uname"
								value="<?php echo $uname;?>" required="required" autocomplete="off"
								placeholder="Username"> </div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4">Password</label>
						<div class="col-sm-8"><input type="text" name="pass" class="form-control" id="pass"
								value="<?php echo $pass;?>" required="required" autocomplete="off"
								placeholder="Password"> </div>
					</div>
				</div>
			</div>
		</div>
	</div>


</div>

<div class="col-md-5" style="margin-top:-65px;">
	<section class="widget" style="background-color:#dddeee;">
		<div class="widget-body clearfix">
			<div class="widget-top-overflow windget-padding-md clearfix bg-primary">
				<span class="h5 fw-bold text-white"><i class="glyphicon glyphicon-th-large"></i> Status Pinjaman</span>
			</div>
			<div id="konfirmasi"></div>
			<br>
			<?php
			$sqla=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE nia='$r[id]' AND `status`='A' OR nia='$r[id]' AND `status`='P' OR nia='$r[id]' AND `status`='V' OR nia='$r[id]' AND `status`='W' OR nia='$r[id]' AND `status`='M' OR nia='$r[id]' AND `status`='B' ");
			$sqlkk=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa where a.id=pa.nia AND a.kk='$r[kk]' AND a.kk!='0' AND a.kk!='' AND pa.status!='L' AND pa.status!='R' ");
			$lacak	= mysql_num_rows($sqla);
			$lacak_kk	= mysql_num_rows($sqlkk);
			$blacklist = "";
				if ($lacak>0){
				$row=mysql_fetch_array($sqla);
				    if ($row['status']=="B") {
				        echo "<i class='fa fa-warning'></i> <strong>PERINGATAN</strong> <br>YBS berada pada status <strong>Black List </strong> sejak tanggal <strong>$row[tgl_proposal]</strong>, untuk mengaktifkan kembali silahkan hubungi Technical Support.";
				        $blacklist = "disabled";
				        
				    }
					 else if($row['jenis_pinjaman']=="K") {
						$ra=mysql_fetch_array(mysql_query("select * from desa d, kelompok_$_SESSION[kd_kab] k where d.id=k.desa AND k.id='$row[id_kel]'"));
						echo "YBS Memiliki Pinjaman pada Kelompok $ra[nama_kelompok] Desa $ra[nama_desa] sebesar ".number_format($row['alokasi']).",- Loan ID.$row[id_pinkel] dengan status <b>$row[status]</b>";
					    
					}else if($row['jenis_pinjaman']=="I") {
						echo "YBS Memiliki Pinjaman Individu sebesar ".number_format($row['proposal']).",- Loan ID.$row[id] dengan status <b>$row[status]</b> ";
					}
				
				}else if ($lacak_kk>0){
					$rkk=mysql_fetch_array($sqlkk);
					$r1=mysql_fetch_array(mysql_query("select * from desa d, kelompok_$_SESSION[kd_kab] k where d.id=k.desa AND k.id='$rkk[id_kel]'"));
					if($rkk['jenis_pinjaman']=="K"){$jp="Kelompok $r1[nama_kelompok] Desa $r1[nama_desa]"; $id_pin=$rkk['id_pinkel'];}else{$jp="Individu"; $id_pin=$rkk['id'];}
					echo "Nomor KK <b>$r[kk]</b> telah memiliki Pinjaman $jp a.n. <b>".strtoupper($rkk['namadepan'])."</b> NIK. $rkk[nik] Loan ID.$id_pin Status $rkk[status]";
				}else{
					echo "YBS Tidak memiliki pinjaman<br>&nbsp;";
				}
			
			
			?>


		</div>
	</section>
</div>


<div class="col-md-5 mt-n-md">
	<section class="widget" style="background-color:#dddeee; min-height:750px;">
		<div class="widget-body clearfix">
			<div class="widget-top-overflow windget-padding-md clearfix bg-primary">
				<span class="h5 fw-bold text-white"><i class="glyphicon glyphicon-user"></i>
					<?php echo "$namadepan | $nik";?></span>
			</div>


			<legend class="text-align-center">
				<span class="thumb-sm avatar img-user mt-sm text-align-center" style="width:200px;">
					<div id="camera">
						<?php
										$foto="../../foto_anggota/$_SESSION[kd_kab]-$r[id].png";
										if(file_exists($foto)){
											echo "<img  alt='' src='foto_anggota/$_SESSION[kd_kab]-$r[id].png'>";
										}else{
											echo "<img  src='img/avatar.png'>";
										}
										?>
					</div>
					<div id="ambil">
						<button type="button" onClick="foto()" class="btn btn-sm btn-block bg-white"
							<?php echo $disabled; ?>><i class="glyphicon glyphicon-camera"></i> AMBIL FOTO</button>
					</div>
					<div id="webcam" style="display:none">
						<button type="button" onClick="preview()" class="btn btn-sm btn-block"><i
								class="glyphicon glyphicon-camera"></i> TANGKAP</button>
					</div>
					<div id="simpanfoto" style="display:none">
						<div class="btn-group">
							<button type="button" class="btn btn-sm" onClick="batal()"><i
									class="glyphicon glyphicon-remove"></i> REMOVE </button>
							<button type="button" class="btn btn-sm" onClick="simpanfoto()" style="font-weight:bold;">
								&nbsp; <i class="glyphicon glyphicon-qrcode"></i> SIMPAN</button>
						</div>
					</div>


				</span>
				<br>&nbsp;</legend>



			<div id="konfirmasi"></div>
			<button class="btn btn-primary btn-rounded mb-sm ml-xs width-100" id="SimpanPenduduk">
				<h3><i class="fa fa-floppy-o"></i></h3>S I M P A N<br>D A T A
			</button>
			<?php if($_SESSION['unt']==1) { ?>
			<button <?php echo $blacklist;?> class="btn btn-default btn-rounded mb-sm ml-xs width-100"
				data-toggle="collapse" data-parent="#accordionIndividu" href="#collapseIndividu"
				value="<?php echo $nik; ?>" id="ProposalIndividu">
				<h3><i class="glyphicon glyphicon-user"></i></h3>[+] Pinjaman<BR>Umum
			</button>
			<button <?php echo $blacklist;?> class="btn btn-default btn-rounded mb-sm ml-xs width-100 hidden"
				data-toggle="collapse" data-parent="#accordionKelompok" href="#collapseKelompok"
				value="<?php echo $nik; ?>" id="ProposalKelompok">
				<h3><i class="fa fa-group"></i></h3>[+] Pinjaman<BR>Kelompok
			</button>
			<?php }else{ ?>
			<button <?php echo $blacklist;?> class="btn btn-default btn-rounded mb-sm ml-xs width-100"
				data-toggle="collapse" data-parent="#accordionPeternakan" href="#collapsePeternakan"
				value="<?php echo $nik; ?>" id="ProposalPeternakan">
				<h3><i class="fa fa-pied-piper-alt"></i></h3>[+] Proposal<BR>P 4
			</button>
			<?php } ?>
			<button <?php echo $blacklist;?> class="btn btn-default btn-rounded mb-sm ml-xs width-100"
				href="javascript:;"
				onclick="MM_openBrWindow('modul/pinjaman/cp/KAngg.php?rcp=<?php echo $nik; ?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )">
				<h3><i class="glyphicon glyphicon-print"></i></h3>Cetak Kartu<BR>Member
			</button>
			<button <?php echo $blacklist;?> class="btn btn-default btn-rounded mb-sm ml-xs width-100"
				data-toggle="collapse" data-parent="#accordionMutasi" href="#collapseMutasi" value="<?php echo $nik; ?>"
				id="MutasiAntarKec">
				<h3><i class="fa fa-refresh"></i></h3> Mutasi Antar<BR>Kecamatan
			</button>
			<button <?php echo $blacklist;?> class="btn btn-default btn-rounded mb-sm ml-xs width-100"
				data-toggle="collapse" data-parent="#accordionBlackList" href="#collapseBlackList"
				value="<?php echo $nik; ?>" id="BlackList">
				<h3><i class="glyphicon glyphicon-remove-sign"></i></h3>Black List<BR>N I K
			</button>



			<!-- BLACK LIST -->
			<div class="panel-group mb-lg" id="accordionBlackList" data-toggle="collapse">
				<div class="panel panel-default">
					<div id="collapseBlackList" class="panel-collapse collapse">
						<div class="panel-body">
							<?php
												
														echo "
														<div class='alert alert-danger mt animated fadeInDown'>
															<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
															<span class='create-server-name'></span><i class='fa fa-warning'></i> <strong>Perhatian</strong> 
															<br>Apakah Yakin anda akan melakukan Black List?
															<button type='button' class='btn btn-danger' id='BlackListConfirm'>Ya</button>
														</div>
														";
												
					?>
						</div>
					</div>
				</div>
			</div>



		</div>
	</section>

</div>


<script src="modul/penduduk/js/webcam.min.js"></script>
<script language="Javascript">
	$(document).ready(function () {
		$('.select2').select2();
	});
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
		Webcam.snap(function (data_uri) {

			// upload foto
			Webcam.upload(data_uri, 'modul/penduduk/upload_foto.php?id=<?php echo $_SESSION['
				kd_kab '];?>-<?php echo $r['
				id '];?>',
				function (code, text) {});

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

	// 		var radioButtons = document.querySelectorAll('.form-check-input')

	// 			function check() {
	// 				radioButtons.forEach((item) => {
	// 					item.removeAttribute('checked')
	// 					this.setAttribute('checked',true)
	// 				})
	// 			}

	// 			radioButtons.forEach((item) => {
	// 			item.addEventListener('click',check)
	// 		})
</script>