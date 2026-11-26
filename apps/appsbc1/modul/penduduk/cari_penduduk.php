<?php session_start(); 	?>

<script type="text/javascript">

function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
					
	$(document).ready(function() {
		

$("#TampilSimpanan").load('modul/simpanan/tampil_simpanan.php');
$("#TampilPinjaman").load('modul/pinjaman/register/tampil_pinjaman.php');
		
		
		//apabila terjadi event onchange terhadap object <select id=jenis_kegiatan>
  $("#jenis_kegiatan").change(function(){
    var jenis_kegiatan = $("#jenis_kegiatan").val();
    $.ajax({
        url: "modul/penduduk/ambil_nama_usaha.php",
        data: "jenis_kegiatan="+jenis_kegiatan,
        cache: false,
        success: function(msg){
            //jika data sukses diambil dari server kita tampilkan
            //di <select id=jenis_buku>
            $("#usaha").html(msg);
        }
    });
  });
  
  
  <?php
  if ($_POST['nik']>=16){
  ?>
  $("#namadepan").focus();
  <?php } ?>
				
		$("#hp").keypress(function (data)  { if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){ return false; } });
		$("#kk").keypress(function (data)  { if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){ return false; } });

                $("#SimpanPenduduk").click(function() {
                    var niaa		= $('#niaa').val();
                    var nik			= $('#nik2').val();
					var namadepan	= $('#namadepan').val();
					var jk			= $('#jk').val();
					var tempat_lahir= $('#tempat_lahir').val();
					var tgl_lahir	= $('#tgl_lahir').val();
					var desaa		= $('#desaa').val();
					var alamat		= $('#alamat').val();
					var hp			= $('#hp').val();
					var kk			= $('#kk').val();
					var nik_penjamin= $('#nik_penjamin').val();
					var penjamin	= $('#penjamin').val();
					var hubungan	= $('#hubungan').val();
					var usaha		= $('#usaha').val();
					var uname		= $('#uname').val();
					var pass		= $('#pass').val();
					
						if(nik.length==0){ $("#konfirmasi").load('modul/penduduk/dilarang_nik_kosong.php');
						$("#nik").focus();
						return false;
							}

						if(nik.length<16){ $("#konfirmasi").load('modul/penduduk/dilarang_nik.php');
						$("#nik").focus();
						return false;
							}
						if(namadepan.length==0){ $("#konfirmasi").load('modul/penduduk/dilarang_kosong.php');
						$("#namadepan").focus();
						return false;
							}
							
						if(hp.length==0){ $("#konfirmasi").load('modul/penduduk/dilarang_hp_kosong.php');
						$("#hp").focus();
						return false;
							}
						
							
						if(desaa.length==0){ $("#konfirmasi").load('modul/penduduk/dilarang_kosong.php');
						$("#desaa").focus();
						return false;
							}	
							
                    $.ajax({
                        type: "POST",
                        url: "modul/penduduk/simpan.php",
                        data: 	"niaa="+niaa+
								"&nik="+nik+
								"&namadepan="+namadepan+
								"&jk="+jk+
								"&tempat_lahir="+tempat_lahir+
								"&tgl_lahir="+tgl_lahir+
								"&desaa="+desaa+
								"&alamat="+alamat+
								"&hp="+hp+
								"&kk="+kk+
								"&nik_penjamin="+nik_penjamin+
								"&penjamin="+penjamin+
								"&hubungan="+hubungan+
								"&usaha="+usaha+
								"&uname="+uname+
								"&pass="+pass,
                        
						success: function(data) {
							
							document.getElementById("nik").value=nik;
							$("#konfirmasi").load('modul/penduduk/sukses_registrasi.php');
							$("#nik").keyup();
									

                        }
                    });

                });
			
				
				
				$("#MutasiAntarKec").click(function(){
						var cari = $("#MutasiAntarKec").val();
						
						$.ajax({
							type	: "POST",
							url		: "modul/penduduk/form_mutasi.php",
							data	: "cari="+cari,
							success	: function(data){
								$("#FormMutasi").html(data);
							}
						});
					});
					
					
				$("#MySimpananUmum").click(function(){
						var nik = $("#MySimpananUmum").val();
						var ids = 1;
						
						$.ajax({
							type	: "POST",
							url		: "modul/simpanan/input_simpanan_individu.php",
							data	: "ids="+ids+
										"&nik="+nik,
							success	: function(data){
								$("#FormSimpananUmum").html(data);
							}
						});
					});
					
				$("#MySimpananDepo").click(function(){
						var nik = $("#MySimpananDepo").val();
						var ids = 2;
						
						$.ajax({
							type	: "POST",
							url		: "modul/simpanan/input_simpanan_individu.php",
							data	: "ids="+ids+
										"&nik="+nik,
							success	: function(data){
								$("#FormSimpananDepo").html(data);
							}
						});
					});
				
				$("#MyProposal").click(function(){
						var action = $("#MyProposal").val();
						var nik = $("#nik").val();
						$.ajax({
							type	: "POST",
							url		: "modul/pinjaman/register/input_pinjaman_individu.php",
							data	: "nik="+nik+
										"&action="+action,
							success	: function(data){
								$("#FormProposal").html(data);
							}
						});
					});
					
					
				$("#DetailAngsuranIndividu").click(function() {
					var id_pinj		= <?php echo $row['id'];?>
							
                    $.ajax({
                        type: "POST",
                        url: "modul/jurnal_angsuran/tampil_buku_angsuran_individu.php",
                        data: 	"id_pinj="+id_pinj,
								
						success: function(data) {
							$("#TampilBuku").html(data);
                        }
                    });

                });	
					
				
				
            });
        </script>
		
<?php
//modul/pelaporan/pdf/p_FormulirPinjaman.phpmodul/pelaporan/pdf/p_FormulirPinjaman.php
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
	$pinj=mysql_fetch_array(mysql_query("select * from pinjaman_anggota_$_SESSION[lokasi] WHERE nia='$r[id]' Order by id Desc "));
	$desa=mysql_fetch_array(mysql_query("select * from kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND d.id='$r[desa]' ")); 
	$pek=mysql_fetch_array(mysql_query("select * from jenis_kegiatan k, usaha u WHERE k.id=u.jenis_kegiatan AND u.id='$r[usaha]' order by u.nama_usaha "));
	$hub=mysql_fetch_array(mysql_query("select * from keluarga WHERE id='$r[hubungan]' ")); 
	
	$idp            =$pinj['id'];
	$nia			=$r['id'];
	$nik			=$r['nik'];
	$_SESSION['nia']=$r['id'];
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
	$nik_penjamin	=$r['nik_penjamin'];
	$penjamin		=$r['penjamin'];
	$id_hubungan	=$hub['id'];
	$hubungan		=$hub['kekeluargaan'];
	
	$uname			=$r['uname'];
	$pass			=$r['pass'];
	$ket			="<div class='text-primary'>* Data ditemukan :</div>";
	$disabled		="";
	$form           ="formisi";
	
}else if ($row<=0 AND $id>=16){
	$desa=mysql_fetch_array(mysql_query("select * from kabupaten b, kecamatan c, desa d WHERE b.id=c.kd_kab AND c.kd_kec=d.kd_kec AND d.id='$_SESSION[lokasi]' ")); 
	$tgl	=substr($id,6,2);
	$bln	=substr($id,8,2);
	$thn	=substr($id,10,2);
        if ($bln > 40) {
            $bln = $bln - 40; // Perempuan
        }

	if($tgl>=40){
		$tag	=$tgl-40;
		if($tag<10) {
				$tg="0$tag"; $jk="P";
			}else{
				$tg=$tag;} $jk="P";
		}else{
			$tg=$tgl; $jk="L";}
	
	$nia			="";
	$nik			=$id;
	$_SESSION['nia']="";
	$namadepan		="";
	$tempat_lahir	=$desa['nama_kab'];
	if ($thn < 40) {
        $tgl_lahir = "20$thn-$bln-$tg";
    } else {
        $tgl_lahir = "19$thn-$bln-$tg";
    }

	$alamat			="";
	$desaa			=$desa['nama_desa'];
	$kd_kec			=$desa['kd_kec'];
	$hp				="08";
	$kk				="";
	$id_kegiatan	="4";
	$jenis_kegiatan	="Pertanian";
	$id_usaha		="22";
	$usaha			="Tani";
	$nik_penjamin	="";
	$penjamin		="";
	$id_hubungan	="1";
	$hubungan		="Suami";
	$uname			=$id;
	$pass			=date('Y').substr($id,14,2);
	$ket			="<div class='text-danger'>* Silahkan lengkapi Data Dibawah ini, kemudian klik tombol SIMPAN DATA :</div>";
	$disabled		="";
	$form           ="formkosong";
?>	
<?php 
}else{
	$_SESSION['nia']="";
	$ket			="<div class='text-danger'>* Silahkan ketik/Scan NIK</div>";
	$disabled		="disabled";
	$form           ="formkosong";
?>	
<?php }
?>
	<div class="col-sm-7">
		<?php echo "$ket";?>			
		
<form action="modul/pelaporan/pdf/p_AnalisaKredit.php?&idp=<?php echo $idp;?>" target="_blank" id="formisi" name="formisi">
    <input type="Hidden" id="idp" name="idp" value="<?php echo $idp;?>">
</form>
<form action="modul/pelaporan/pdf/p_FormulirPinjaman.php" target="_blank" id="formkosong" name="formkosong"></form>
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
							

							<!-- BLACK LIST -->
			<div class="panel-group" id="accordionBlackList" data-toggle="collapse">
								<div class="panel panel-default">
									<div id="collapseBlackList" class="panel-collapse collapse">
										<div class="panel-body">
											<?php
												
														echo "
														<div class='alert alert-danger mt animated fadeInDown'>
															<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
															<span class='create-server-name'></span><i class='fa fa-warning'></i> <strong>Perhatian</strong> 
															<br>Apakah Yakin anda akan melakukan Black List?
															<button type='button' class='btn btn-danger' id='BlackList'>Ya</button>
														</div>
														";
												
					?>
										</div>
									</div>
								</div>
							</div>
							
							
							
	<div class="panel-group mb-lg" id="accordion2" data-toggle="collapse">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" style="text-decoration:none; font-weight: bold">
                                    1. IDENTITAS NASABAH
                                    <i class="fa fa-angle-down pull-right"></i>
                                </a>
                            </h5>
                        </div>
                        <div id="collapseOne2" class="panel-collapse collapse in">
                            <div class="panel-body" style='background-color:#f8f8f8;'>
									<input type="hidden" name="niaa" value="<?php echo $nia;?>" id="niaa" />
									<div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">N I K</label>
										<div class="col-sm-8">
												<input type="text" name="nik2" value="<?php echo $nik;?>" id="nik2" class="form-control" <?php echo $disabled; ?>
														required="required" autocomplete="off" placeholder="N I K"/>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">Nama Lengkap</label>
										<div class="col-sm-8">
												<input type="text" name="namadepan" value="<?php echo $namadepan;?>" id="namadepan" class="form-control" <?php echo $disabled; ?>
														required="required" autocomplete="off" placeholder="Nama Lengkap"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">Jenis Kelamin</label>
										<div class="col-sm-3">
												<select class="select2 form-control" tabindex="-1" data-width="auto" <?php echo $disabled; ?>
                                                data-minimum-results-for-search="10"
															 name="jk" id="jk">
                                                        <option value="<?php echo $jk;?>"><?php echo $jk;?></option>
                                                        <option value="P">Perempuan</option>
                                                        <option value="L">Laki-laki</option>
													</select>
										</div>
										
									</div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Tempat / Tgl Lahir</label>
                                        <div class="col-sm-4"><input type="text" value="<?php echo $tempat_lahir;?>" name="tempat_lahir" id="tempat_lahir" class="form-control" <?php echo $disabled; ?>
										required="required" autocomplete="off" placeholder="Tempat Lahir"></div>
										
										<div class="col-sm-4"><input type="text" value="<?php echo $tgl_lahir;?>"  name="tgl_lahir" id="tgl_lahir" class="form-control" <?php echo $disabled; ?>
										required="required" autocomplete="off" placeholder="Tgl (YYYY-MM-DD)"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Alamat KTP</label>
                                        <div class="col-sm-8"><input type="text" value="<?php echo $alamat;?>" name="alamat" id="alamat" maxlength="50" class="form-control" <?php echo $disabled; ?>
										required="required" autocomplete="off" placeholder="Dusun/Jalan/Kampung/RT/RW"> </div>
                                    </div>
									
														<div class="form-group">
															<label class="col-sm-4 control-label">Desa/Kelurahan</label>
															<div class="col-sm-8">
																<select name="desaa" id="desaa" class="select2 form-control" <?php echo $disabled; ?>>
																	<?php 
																	echo "<option value='$desa[id]'>$desaa</option>";
																	?>
																</select>
															</div>
														</div>
									 
									<div class="form-group">
                                        <label class="control-label col-sm-4">Nomor HP</label>
                                        <div class="col-sm-8"><input type="text" value="<?php echo $hp;?>" name="hp"  maxlength="14" class="form-control" id="hp" <?php echo $disabled; ?>
										required="required" autocomplete="off" placeholder="Nomor Handphone"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Nomor KK</label>
                                        <div class="col-sm-8"><input type="text" value="<?php echo $kk;?>" name="kk"  maxlength="16" class="form-control" id="kk" <?php echo $disabled; ?>
										required="required" autocomplete="off" placeholder="Nomor Kartu Keluarga"> </div>
                                    </div>
									<div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">Jenis Kegiatan / Usaha</label>
										<div class="col-sm-4">
											<select id="jenis_kegiatan"  name="jenis_kegiatan" <?php echo $disabled; ?>
												data-placeholder="-- Pilih Jenis Kegiatan --"
												data-width="auto"
												data-minimum-results-for-search="10"
												tabindex="-1"
												class="select2 form-control">
												<?php 
												echo "<option value='$id_kegiatan'>$jenis_kegiatan</option>";
												$view=mysql_query("select * from jenis_kegiatan ORDER BY id"); //jenis kegiatan
												while($row=mysql_fetch_array($view)){
												echo "<option value='$row[id]'>$row[deskripsi_jk]</option>";
												} ?>
											</select>
										</div>
										<div class="col-sm-4">
											<select id="usaha" name="usaha" class="form-control" data-placeholder="-- Pilh Nama Usaha --" <?php echo $disabled; ?>
                                                            data-width="auto">
                                                        <?php 
														echo "<option value='$id_usaha'>$usaha</option>";
													 ?>
													</select>
										</div>
									</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading collapsed">
                            <h5 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo2" style="text-decoration:none; font-weight: bold">
                                    2. IDENTITAS KELUARGA PENJAMIN
                                    <i class="fa fa-angle-down pull-right"></i>
                                </a>
                            </h5>
                        </div>
                        <div id="collapseTwo2" class="panel-collapse collapse">
                            <div class="panel-body" style='background-color:#f8f8f8;'>
                                <div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">NIK Penjamin</label>
										<div class="col-sm-8">
												<input type="text" value="<?php echo $nik_penjamin;?>" name="nik_penjamin" id="nik_penjamin" class="form-control" 
														required="required" autocomplete="off" placeholder="NIK Penjamin">
										</div>
								</div>
								<div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">Nama Lengkap</label>
										<div class="col-sm-8">
												<input type="text" value="<?php echo $penjamin;?>" name="penjamin" id="penjamin" class="form-control" 
														required="required" autocomplete="off" placeholder="Nama Keluarga Penjamin">
										</div>
								</div>
								<div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">Hubungan</label>
										<div class="col-sm-8">
											<select id="hubungan" name="hubungan" class="form-control"
                                                            data-width="auto">
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
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour2" style="text-decoration:none; font-weight: bold">
                                    3. AKUN LOGIN
                                    <i class="fa fa-angle-down pull-right"></i>
                                </a>
                            </h5>
                        </div>
                        <div id="collapseFour2" class="panel-collapse collapse">
                            <div class="panel-body" style='background-color:#f8f8f8;'>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Username</label>
                                        <div class="col-sm-8"><input type="text" name="uname" class="form-control" id="uname" value="<?php echo $uname;?>"
										required="required" autocomplete="off" placeholder="Username"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Password</label>
                                        <div class="col-sm-8"><input type="text" name="pass" class="form-control" id="pass" value="<?php echo $pass;?>"
										required="required" autocomplete="off" placeholder="Password"> </div>
                                    </div>
							</div>
                        </div>
                    </div>
                </div>
									
									
</div> 

<div class="col-md-5" style="margin-top:-65px;">
<section class="widget" style="background-color:#dddeee; border: 1px solid #5d8fc2;">
                    <div class="widget-body clearfix">
						<div class="widget-top-overflow windget-padding-md clearfix bg-primary">
                            <span class="h5 fw-normal text-white"><i class="glyphicon glyphicon-user"></i> <?php echo "$nik | <b>".strtoupper($namadepan)."</b>";?></span>
                        </div>
			
			
		<div class="row">
            <div class="col-md-5 col-md-offset">
			<body>
			<span class="thumb-sm avatar img-user mt-sm text-align-center" style="width:180px;">
							
				
				<div id="camera">
				<?php
										$foto="../../foto_anggota/$r[id].png";
										if(file_exists($foto)){
											echo "<img  alt='' src='foto_anggota/$r[id].png'>";
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
				Webcam.upload(data_uri, 'modul/penduduk/upload_foto.php?id=<?php echo $r['id'];?>', function(code, text) {});

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
			
			<div class="col-md-7 col-md-offset">
				<div id="konfirmasi"></div>
				<button <?php echo $disabled; ?> class="btn btn-primary mt-sm ml-sm width-100 fs-mini" id="SimpanPenduduk"><h4><i class="fa fa-floppy-o"></i></h4>S I M P A N<br>D A T A</button>	
				<button <?php echo $disabled; ?> class="btn btn-default mt-sm ml-sm width-100 fs-mini" href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/c_ka.php?rcp=<?php echo $nik; ?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><h4><i class="glyphicon glyphicon-qrcode"></i></h4>Cetak Kartu<BR>Anggota</button>
				<button <?php echo $disabled; ?> class="btn btn-default mt-sm ml-sm width-100 fs-mini" data-toggle="collapse" data-parent="#accordionMutasi" href="#collapseMutasi" value="<?php echo $nik; ?>" id="MutasiAntarKec"><h4><i class="fa fa-refresh"></i></h4> Mutasi Antar<BR>Kecamatan</button>
				<button <?php echo $disabled; ?> class="btn btn-default mt-sm ml-sm width-100 fs-mini" data-toggle="collapse" data-parent="#accordionBlackList" href="#collapseBlackList" value="<?php echo $nik; ?>" id="MutasiAntarKec"><h4><i class="glyphicon glyphicon-remove-sign"></i></h4>Black List<BR>N I K</button>
			</div>
		</div>
		
	
</div>		
</section>		
					
</div>	

<div class="col-md-5">
	<section class="widget" style="border: 1px solid #5d8fc2;">
		<div class="widget-body clearfix">
			<div class="widget-top-overflow windget-padding-md clearfix bg-primary">
				<span class="h4 text-white"><i class="glyphicon glyphicon-th-large"></i> Simpanan
					<span class="pull-right">
						<button class="btn btn-xs btn-default" href="" data-toggle="modal" data-target="#myModalSimpananUmum" value="<?php echo $nik; ?>" id="MySimpananUmum"><span class="fs-mini">[+] Simp. Umum</span></button>
						<button class="btn btn-xs btn-default" href="" data-toggle="modal" data-target="#myModalSimpananDepo" value="<?php echo $nik; ?>" id="MySimpananDepo"><span class="fs-mini">[+] Simp. Deposito</span></button>
					</span>
				</span>
			</div>
		<div id="TampilSimpanan"></div>	
		</div>		
	</section>		
</div>

<div class="col-md-5">
	<section class="widget" style="border: 1px solid #5d8fc2;">
		<div class="widget-body clearfix">
			<div class="widget-top-overflow windget-padding-md clearfix bg-primary">
				<span class="h4 text-white"><i class="glyphicon glyphicon-th-large"></i> Pinjaman
					<span class="pull-right">
						<input type="hidden" name="nik" id="nik" value="<?php echo $nik; ?>" >
						<button class="btn btn-xs btn-default" href="" data-toggle="modal" data-target="#myModalProposal" value="tambah" id="MyProposal"><span class="fs-mini">Tambah Pinjaman</span></button>
						<button class="btn btn-xs btn-default" form="<?php echo $form?>" type="submit">  <span class="fs-mini"> Form Pinjaman</button>
					</span>
				</span>
			</div>
		<div id="TampilPinjaman"></div>	
		</div>		
	</section>		
</div>	





<!-- MODAL TAMBAH SIMPANAN UMUM -->
						<div class="modal fade" id="myModalSimpananUmum" tabindex="" role="dialog" aria-labelledby="LabelSimpananUmum" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h4 class="modal-title" id="LabelSimpananUmum">
											<i class='glyphicon glyphicon-user'></i> Formulir Pembukaan Simpanan Umum
											<ul class="tags pull-right">
												<li><a href="#" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i></span></a></li>
											</ul>
										</h4>
                                    </div>
                                    <div class="modal-body">
										<div id="FormSimpananUmum"></div>
									</div>
                                </div>
                            </div>
                        </div>	
						
						
<!-- MODAL TAMBAH SIMPANAN DEPOSITO -->
						<div class="modal fade" id="myModalSimpananDepo" tabindex="" role="dialog" aria-labelledby="LabelSimpananDepo" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h4 class="modal-title" id="LabelSimpananDepo">
											<i class='glyphicon glyphicon-user'></i> Formulir Pembukaan Simpanan Deposito
											<ul class="tags pull-right">
												<li><a href="#" type="button" data-dismiss="modal" aria-hidden="true" > <span class="fs-mini"><i class="glyphicon glyphicon-remove"></i></span></a></li>
											</ul>
										</h4>
                                    </div>
                                    <div class="modal-body">
										<div id="FormSimpananDepo"></div>
									</div>
                                </div>
                            </div>
                        </div>	
						
						
<!-- MODAL PROPOSAL backdrop -->
						<div class="modal fade" id="myModalProposal" tabindex="" role="dialog" aria-labelledby="LabelProposal" aria-hidden="true">
                            <div class="modal-dialog" style="width:900px;">
                                <div class="modal-content">
                                    <div id="FormProposal"></div>
                                </div>
                            </div>
                        </div>	

					
