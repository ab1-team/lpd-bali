<?php session_start(); 	?>

<script type="text/javascript">

function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
					
	$(document).ready(function() {
		
$("#TampilSimpanan").load('modul/simpanan/tampil_simpanan.php');
		
		//apabila terjadi event onchange terhadap object <select id=jenis_kegiatan>
  $("#jenis_kegiatan").change(function(){
    var jenis_kegiatan = $("#jenis_kegiatan").val();
    $.ajax({
        url: "modul/simpanan/register/ambil_nama_usaha.php",
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
                    var nik			= $('#nik').val();
					var namadepan	= $('#namadepan').val();
					var jk			= $('#jk').val();
					var tempat_lahir= $('#tempat_lahir').val();
					var tgl_lahir	= $('#tgl_lahir').val();
					var desaa		= $('#desaa').val();
					var alamat		= $('#alamat').val();
					var hp			= $('#hp').val();
					var kk			= $('#kk').val();
					var usaha		= $('#usaha').val();
					var foto		= $('#foto').val();
					
					var nick		= $('#nick').val();
					var agama		= $('#agama').val();
					var pernikahan	= $('#pernikahan').val();
					var pendidikan	= $('#pendidikan').val();
					var npwp		= $('#npwp').val();
					var penghasilan	= $('#penghasilan').val();
					var sumber		= $('#sumber').val();
					var pengampu	= $('#pengampu').val();
					var hubungan	= $('#hubungan').val();
					var ibu		    = $('#ibu').val();
					
						if(nik.length==0){ $("#konfirmasi").load('modul/simpanan/register/dilarang_nik_kosong.php');
						$("#nik").focus();
						return false;
							}

						if(nik.length<16){ $("#konfirmasi").load('modul/simpanan/register/dilarang_nik.php');
						$("#nik").focus();
						return false;
							}
						if(namadepan.length==0){ $("#konfirmasi").load('modul/simpanan/register/dilarang_kosong.php');
						$("#namadepan").focus();
						return false;
							}
						
						if(desaa.length==0){ $("#konfirmasi").load('modul/simpanan/register/dilarang_kosong.php');
						$("#desaa").focus();
						return false;
							}	
							
                    $.ajax({
                        type: "POST",
                        url: "modul/simpanan/register/simpan.php",
                        data: 	"nik="+nik+
								"&namadepan="+namadepan+
								"&jk="+jk+
								"&tempat_lahir="+tempat_lahir+
								"&tgl_lahir="+tgl_lahir+
								"&desaa="+desaa+
								"&alamat="+alamat+
								"&hp="+hp+
								"&kk="+kk+
								"&usaha="+usaha+
								"&nick="+nick+
								"&agama="+agama+
								"&pernikahan="+pernikahan+
								"&pendidikan="+pendidikan+
								"&npwp="+npwp+
								"&penghasilan="+penghasilan+
								"&sumber="+sumber+
								"&pengampu="+pengampu+
								"&hubungan="+hubungan+
								"&ibu="+ibu+
								"&foto="+foto,
                        
						success: function(data) {
							
							//$("#form_register").load('modul/simpanan/register/cari_penduduk.php');
							
							$("#konfirmasi").load('modul/simpanan/register/sukses_registrasi.php');
							
							$("#nik").keyup();
								//return false;
									

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
					
			$("#SimpanNewAnggota").click(function() {
                    var nik				= $('#nik').val();
                    var tgl_transaksi	= $('#tgl_transaksi').val();
                    var rek_anggota		= $('#rek_anggota').val();
                    var simpok			= $('#simpok').val();
                    var simjib			= $('#simjib').val();
                    var simsuka			= $('#simsuka').val();
							
                    $.ajax({
                        type: "POST",
                        url: "modul/simpanan/register/simpan_new_anggota.php",
                        data: 	"nik="+nik+
								"&tgl_transaksi="+tgl_transaksi+
								"&rek_anggota="+rek_anggota+
								"&simpok="+simpok+
								"&simjib="+simjib+
								"&simsuka="+simsuka,
                        
						success: function(data) {
							$("#suksessna").load('modul/simpanan/register/sukses_anggota.php');
							
                        }
                    });

                });
				
				
				$("#MutasiAntarKec").click(function(){
						var cari = $("#MutasiAntarKec").val();
						
						$.ajax({
							type	: "POST",
							url		: "modul/simpanan/register/form_mutasi.php",
							data	: "cari="+cari,
							success	: function(data){
								$("#FormMutasi").html(data);
							}
						});
					});
					
				$("#ProposalPeternakan").click(function(){
						var nik = $("#ProposalPeternakan").val();
						
						$.ajax({
							type	: "POST",
							url		: "modul/pinjaman/register/input_pinjaman_peternakan.php",
							data	: "nik="+nik,
							success	: function(data){
								$("#FormProposalPeternakan").html(data);
							}
						});
					});
				
				$("#ProposalIndividu").click(function(){
						var nik = $("#ProposalIndividu").val();
						
						$.ajax({
							type	: "POST",
							url		: "modul/simpanan/register/input_simpanan_individu.php",
							data	: "nik="+nik,
							success	: function(data){
								$("#FormProposalIndividu").html(data);
							}
						});
					});
					
				$("#ProposalIndividu3").click(function(){
						var nik = $("#ProposalIndividu3").val();
						
						$.ajax({
							type	: "POST",
							url		: "modul/simpanan/register/input_simpanan_individu3.php",
							data	: "nik="+nik,
							success	: function(data){
								$("#FormProposalIndividu3").html(data);
							}
						});
					});
					
				$("#ProposalIndividuD").click(function(){
						var nik = $("#ProposalIndividuD").val();
						
						$.ajax({
							type	: "POST",
							url		: "modul/simpanan/register/input_simpanan_individuD.php",
							data	: "nik="+nik,
							success	: function(data){
								$("#FormProposalIndividuD").html(data);
							}
						});
					});
					
					
				$("#ProposalKelompok").click(function(){
						var nik = $("#ProposalIndividu").val();
						
						$.ajax({
							type	: "POST",
							url		: "modul/pinjaman/register/input_pinjaman_ke_kelompok.php",
							data	: "nik="+nik,
							success	: function(data){
								$("#FormProposalKelompok").html(data);
							}
						});
					});
					
				
				
            });
        </script>
		
<?php
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
$table	= "anggota_$_SESSION[kd_kab]";
$id	= $_POST['nik'];
$text	= "SELECT *
			FROM $table WHERE nik= '$id'";
$sql 	= mysql_query($text);
$row	= mysql_num_rows($sql);
if ($row>0 AND $id>=16){
	$r=mysql_fetch_array($sql);
	$_SESSION['nia'] = $r['id'];
	$desa=mysql_fetch_array(mysql_query("select * from kecamatan c, desa d WHERE c.kd_kec=d.kd_kec AND d.id='$r[desa]' ")); 
	$pek=mysql_fetch_array(mysql_query("select * from jenis_kegiatan k, usaha u WHERE k.id=u.jenis_kegiatan AND u.id='$r[usaha]' order by u.nama_usaha "));
	$hub=mysql_fetch_array(mysql_query("select * from keluarga WHERE id='$r[hubungan]' ")); 
	$jaminan 		= explode(",", $r['jaminan']);
	$jj=mysql_fetch_array(mysql_query("select * from jenis_jaminan WHERE id='$jaminan[0]' ")); 
	$r2=mysql_fetch_array(mysql_query("select * from anggota_s_$_SESSION[kd_kab] WHERE nik='$id' ")); 
													
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
	
	$nick           =$r2['nick'];
	$agama          =$r2['agama'];
	$pernikahan     =$r2['pernikahan'];
	$pen             =$r2['pendidikan'];
	$viewpen        =mysql_fetch_array(mysql_query("select * from pendidikan WHERE id=$pen"));
	$pendidikan     =$viewpen['id'];
	$npwp           =$r2['npwp'];
	$penghasilan    =$r2['penghasilan'];
	$sumber         =$r2['sumber'];
	$ibu            =$r2['ibu'];
	
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
	
	$nick           ="";
	$agama          ="";
	$pernikahan     ="";
	$pendidikan     ="";
	$npwp           ="";
	$penghasilan    ="";
	$sumber         ="";
	$ibu            ="";
}
$jumsim = mysql_num_rows(mysql_query("SELECT * FROM simpanan_anggota_$_SESSION[kd_kab] WHERE nia= '$nianggota' AND jenis_simpanan='1'"));
if($jumsim<=0){$disabdepo="disabled";}else{$disabdepo="";}
?>
	<div class="col-sm-7">
		<?php echo "<div class='text-danger'>$ket</div>";?>
	
							
		<!-- FORM SIMPANAN -->		
			<div class="panel-group" id="accordionIndividu" data-toggle="collapse">
								<div class="panel panel-default">
									<div id="collapseIndividu" class="panel-collapse collapse">
										<div class="panel-body">
											<?php
														echo "<div id='FormProposalIndividu'></div>";
														echo "<div id='FormProposalIndividu3'></div>";
														echo "<div id='FormProposalIndividuD'></div>";
					?>
										</div>
									</div>
								</div>
							</div>
							
		
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
                                <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne2" style="text-decoration:none; font-weight: bold">
                                    1. IDENTITAS PENDUDUK
                                    <i class="fa fa-angle-down pull-right"></i>
                                </a>
                            </h5>
                        </div>
                        <div id="collapseOne2" class="panel-collapse collapse in">
                            <div class="panel-body" style='background-color:#f8f8f8;'>
                                <input type="hidden" name="nik" id="nik" value="<?php echo $nik; ?>"/>
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
												<input type="text" name="namadepan" value="<?php echo $namadepan;?>" id="namadepan" class="form-control" 
														required="required" autocomplete="off" placeholder="Nama Lengkap"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">Nama Alias</label>
										<div class="col-sm-8">
												<input type="text" name="nick" value="<?php echo $nick;?>" id="nick" class="form-control" 
														required="required" autocomplete="off" placeholder="nama alias"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">Jenis Kelamin</label>
										<div class="col-sm-3">
												<select class="select2 form-control" tabindex="-1" data-width="auto"
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
                                        <div class="col-sm-4"><input type="text" value="<?php echo $tempat_lahir;?>" name="tempat_lahir" id="tempat_lahir" class="form-control" 
										required="required" autocomplete="off" placeholder="Tempat Lahir"></div>
										
										<div class="col-sm-4"><input type="text" value="<?php echo $tgl_lahir;?>"  name="tgl_lahir" id="tgl_lahir" class="form-control" 
										required="required" autocomplete="off" placeholder="Tgl (YYYY-MM-DD)"> </div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Alamat KTP</label>
                                        <div class="col-sm-8"><input type="text" value="<?php echo $alamat;?>" name="alamat" id="alamat" maxlength="50" class="form-control" 
										required="required" autocomplete="off" placeholder="Dusun/Jalan/Kampung/RT/RW"> </div>
                                    </div>
									
														<div class="form-group">
															<label class="col-sm-4 control-label">Desa/Kelurahan</label>
															<div class="col-sm-8">
																<select name="desaa" id="desaa" class="select2 form-control">
																	<?php 
																	echo "<option value='$desa[id]'>$desaa</option>";
																	$view=mysql_query("select * from desa where kd_kec='$kd_kec' order by kd_desa asc"); //DESA
																		while($row=mysql_fetch_array($view)){
																		echo "<option value='$row[id]'>$row[nama_desa]</option>";
																		}
																	?>
																</select>
															</div>
														</div>
									 
									<div class="form-group">
                                        <label class="control-label col-sm-4">Nomor HP</label>
                                        <div class="col-sm-8"><input type="text" value="<?php echo $hp;?>" name="hp"  maxlength="14" class="form-control" id="hp"
										required="required" autocomplete="off" placeholder="Nomor Handphone"> </div>
                                    </div>
									<div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">Agama</label>
										<div class="col-sm-3">
												<select class="select2 form-control" tabindex="-1" data-width="auto"
                                                data-minimum-results-for-search="10"
															 name="agama" id="agama">
                                                        <option value="<?php echo $agama;?>"><?php echo $agama;?></option>
                                                        <option value="Islam">Islam</option>
                                                        <option value="Kristen">Kristen</option>
                                                        <option value="Protestan">Protestan</option>
                                                        <option value="Hindu">Hindu</option>
                                                        <option value="Budha">Budha</option>
                                                        <option value="Konghucu">Konghucu</option>
                                                        <option value="Kepercayaan">Kepercayaan</option>
													</select>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">Status Pernikahan</label>
										<div class="col-sm-3">
												<select class="select2 form-control" tabindex="-1" data-width="auto"
                                                data-minimum-results-for-search="10"
															 name="pernikahan" id="pernikahan">
                                                        <option value="<?php echo $pernikahan;?>"><?php echo $pernikahan;?></option>
                                                        <option value="Lajang">Lajang</option>
                                                        <option value="Menikah">Menikah</option>
                                                        <option value="Ex">Duda / Janda</option>
													</select>
										</div>
									</div>
									
														<div class="form-group">
															<label class="col-sm-4 control-label">Pendidikan Terakhir</label>
															<div class="col-sm-8">
																<select name="pendidikan" id="pendidikan" class="select2 form-control">
																	<?php 
																	echo "<option value='$pendidikan'>$viewpen[tingkat] ($viewpen[deskripsi_p])</option>";
																	$viewpend=mysql_query("select * from pendidikan"); //DESA
																		while($rowpend=mysql_fetch_array($viewpend)){
																		echo "<option value='$rowpend[id]'>$rowpend[tingkat] ($rowpend[deskripsi_p])</option>";
																		}
																	?>
																</select>
															</div>
														</div>
									 
									<div class="form-group">
                                        <label class="control-label col-sm-4">Nomor KK</label>
                                        <div class="col-sm-8"><input type="text" value="<?php echo $kk;?>" name="kk"  maxlength="16" class="form-control" id="kk"
										required="required" autocomplete="off" placeholder="Nomor Kartu Keluarga"> </div>
                                    </div>
									<div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">Jenis Kegiatan / Usaha</label>
										<div class="col-sm-4">
											<select id="jenis_kegiatan"  name="jenis_kegiatan"
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
											<select id="usaha" name="usaha" class="form-control" data-placeholder="-- Pilh Nama Usaha --"
                                                            data-width="auto">
                                                        <?php 
														echo "<option value='$id_usaha'>$usaha</option>";
													 ?>
													</select>
										</div>
									</div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">NPWP</label>
                                        <div class="col-sm-8"><input type="text" value="<?php echo $npwp;?>" name="npwp"  maxlength="16" class="form-control" id="npwp"
										required="required" autocomplete="off" placeholder="NPWP"> </div>
                                    </div>
                                    
									<div class="form-group">
										<label class="col-sm-4 control-label" for="appended-input">Penghasilan Per Bulan</label>
										<div class="col-sm-3">
												<select class="select2 form-control" tabindex="-1" data-width="auto"
                                                data-minimum-results-for-search="10"
															 name="penghasilan" id="penghasilan">
                                                        <option value="<?php echo $penghasilan;?>"><?php echo $penghasilan;?></option>
                                                        <option value="1">1. < 5 jt</option>
                                                        <option value="2">2. 5 - 15 jt</option>
                                                        <option value="3">3. 15 - 25 jt</option>
                                                        <option value="4">4. > 25 jt</option>
													</select>
										</div>
                                    
									</div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Sumber Dana</label>
                                        <div class="col-sm-8"><input type="text" name="sumber" class="form-control" id="sumber" value="<?php echo $sumber;?>"
										required="required" autocomplete="off" placeholder="Sumber dana (Gaji / Usaha / Lainnya)"></div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Pengampu</label>
                                        <div class="col-sm-8"><input type="text" name="pengampu" class="form-control" id="pengampu" value="<?php echo $pengampu;?>"
										required="required" autocomplete="off" placeholder="Di isi jika penyimpan butuh pengampu"></div>
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
									<div class="form-group">
                                        <label class="control-label col-sm-4">Nama Gadis Ibu Kandung</label>
                                        <div class="col-sm-8"><input type="text" name="ibu" class="form-control" id="ibu" value="<?php echo $ibu;?>"
										required="required" autocomplete="off" placeholder="Nama Gadis Ibu Kandung"></div>
                                    </div>
									<div class="form-group">
                                        <label class="control-label col-sm-4">Link Foto</label>
                                        <div class="col-sm-8"><input type="text" name="foto" class="form-control" id="foto" value="<?php echo $foto;?>"
										required="required" autocomplete="off" placeholder="-- Gunakan link dari Google Foto, Facebook, Google Drive, dll --"> <br>Klik kanan foto, kemudian Copy Image Location</div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
									
									
</div> 

<div class="col-md-5 mt-n-md">
	<section class="widget" style="border: 1px solid #5d8fc2; margin-top:-50px;">
		<div class="widget-body clearfix">
			<div class="widget-top-overflow windget-padding-md clearfix bg-primary">
				<span class="h4 text-white"><i class="glyphicon glyphicon-th-large"></i> Simpanan
				</span>
			</div>
		<div id="TampilSimpanan"></div>	
		</div>		
	</section>		
</div>
 
<div class="col-md-5 mt-n-md">
<section class="widget" style="background-color:#dddeee; min-height:750px;">
                    <div class="widget-body clearfix">
						<div class="widget-top-overflow windget-padding-md clearfix bg-primary">
                            <span class="h5 fw-bold text-white"><i class="glyphicon glyphicon-user"></i> <?php echo "$namadepan | $nik";?></span>
                        </div>
			
			
			<legend class="text-align-center">
			<span class="thumb-sm avatar img-user mt-sm text-align-center" style="width:200px;">
							<?php
										$foto=$r['foto'];
										if (empty($foto)) {
											echo "<img  src='images/avatar.png' alt='...'>";
											}else{
											echo "<img  alt='' src='$foto'>";
											}
										?>
                        </span>
			<br>&nbsp;</legend>
			<div id="konfirmasi"></div><center>
			<button class="btn btn-primary btn-rounded mb-sm ml-xs width-100" id="SimpanPenduduk"><h3><i class="glyphicon glyphicon-saved"></i></h3>S I M P A N<br>D A T A<br>&nbsp;</button>
	<?php if($_SESSION['unt']==1) { ?>		
			<button class="btn btn-default btn-rounded mb-sm ml-xs width-100" data-toggle="collapse" data-parent="#accordionIndividu" href="#collapseIndividu" value="<?php echo $nik; ?>" id="ProposalIndividu"><h3><i class="glyphicon glyphicon-floppy-disk"></i></h3>[+]<BR>Simpanan<BR> Umum</button>
			<button class="btn btn-default btn-rounded mb-sm ml-xs width-100" data-toggle="collapse" data-parent="#accordionIndividu" href="#collapseIndividu" value="<?php echo $nik; ?>" id="ProposalIndividu3"><h3><i class="glyphicon glyphicon-floppy-save"></i></h3>[+]<BR>Simpanan<BR> Program</button>
			<button class="btn btn-default btn-rounded mb-sm ml-xs width-100" data-toggle="collapse" data-parent="#accordionIndividu" href="#collapseIndividu" value="<?php echo $nik; ?>" id="ProposalIndividuD" <?php echo $disabdepo; ?>><h3><i class="glyphicon glyphicon-floppy-saved"></i></h3>[+]<BR>Simpanan<BR> Deposito</button>
			<a href=modul/simpanan/cs/i_PPPA.php?&ida=<?php echo $nianggota?> target="_blank"><button class="btn btn-default btn-rounded mb-sm ml-xs width-100" ><h3><i class="glyphicon glyphicon-print"></i></h3> Cetak<BR>Formulir<br>&nbsp;</button></a>
	<?php } ?>
				</center>
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
															<button type='button' class='btn btn-danger' id='BlackList'>Ya</button>
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
