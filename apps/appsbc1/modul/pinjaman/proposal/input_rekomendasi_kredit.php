<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$table	= "pinjaman_anggota_$_SESSION[kd_kab]";

$id_pinj_i		=$_SESSION['id_pinj_i'];

$row=mysql_fetch_array(mysql_query("select * FROM $table WHERE id= '$id_pinj_i' "));
	
	$status			=$row['status'];
	$tgl			=date('Y-m-d');
	
	
	$dpr 		= explode("#", $row['data_proposal']);
	$dva 		= explode("#", $row['data_verifikasi_analis']);
	$dvk 		= explode("#", $row['data_verifikasi_kepala']);
	$dvb 		= explode("#", $row['data_verifikasi_bawas']);
	$dwt 		= explode("#", $row['data_waiting']);
	
		
	$proposali		=$row['alokasi'];
	$jangka			=$row['jangka'];
	$pros_jasa		=$row['pros_jasa'];
	$jenis_jasa		=$row['jenis_jasa'];
	$sistem			=$row['sistem_angsuran'];
	$sa_jasa		=$row['sa_jasa'];
	$tujuan_permohonan	=$dpr[7];
	
	$jam 		= explode("#", $row['jaminan']);
	$nilai_jaminan=$jam[0]/2;
	
	$jj=mysql_fetch_array(mysql_query("select * FROM jenis_jasa WHERE id='$jenis_jasa'"));			
	$sp=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$sistem'"));			
	$sj=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$sa_jasa'"));			
	$tp=mysql_fetch_array(mysql_query("select * FROM tujuan_pinjaman WHERE id='$tujuan_permohonan'"));
	$u=mysql_fetch_array(mysql_query("select * FROM users WHERE id='$row[user_id]'"));
	
	?>

		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr class="fw-semi-bold">
						<td>Sumber Data/Status</td>
						<td>Tanggal</td>
						<td>Alokasi</td>
						<td>Jangka</td>
						<td>%</td>
						<td>Bunga</td>
						<td>SA. Pokok</td>
						<td>SA. Bunga</td>
						<td>Tujuan Kredit</td>
						<td>CEV</td>
						<td><i class="glyphicon glyphicon-user"></i></td>
					</tr>
				</thead>
				<tbody class="fs-mini fw-normal">
				<?php
				if($status=="P" OR $status=="V1" OR $status=="V2" OR $status=="V3" OR $status=="W" OR $status=="A") {
					$dpr4=mysql_fetch_array(mysql_query("select * FROM jenis_jasa WHERE id='$dpr[4]'"));			
					$dpr5=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$dpr[5]'"));			
					$dpr6=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$dpr[6]'"));			
					$dpr7=mysql_fetch_array(mysql_query("select * FROM tujuan_pinjaman WHERE id='$dpr[7]'"));
					$dpr8=mysql_fetch_array(mysql_query("select * FROM users WHERE id='$dpr[8]'"));
				echo "
					<tr>
						<td class='text-align-center'><span class='badge'>PENGAJUAN PEMOHON</span></td>
						<td>".tgl_ind($dpr[0])."</td>
						<td>".number_format($dpr[1],0,",",".")."</td>
						<td>$dpr[2] bulan</td>
						<td>$dpr[3] %</td>
						<td>$dpr4[nama_jj]</td>
						<td>$dpr5[nama_sistem]</td>
						<td>$dpr6[nama_sistem]</td>
						<td>$dpr7[nama_tujuan]</td>
						<td>".number_format($jam[0],0,",",".")."</td>
						<td>$dpr8[ins]</td>
					</tr>
				";
				}
				if($status=="V1" OR $status=="V2" OR $status=="V3" OR $status=="W" OR $status=="A") {
					$dva4=mysql_fetch_array(mysql_query("select * FROM jenis_jasa WHERE id='$dva[4]'"));			
					$dva5=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$dva[5]'"));			
					$dva6=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$dva[6]'"));			
					$dva7=mysql_fetch_array(mysql_query("select * FROM tujuan_pinjaman WHERE id='$dva[7]'"));
					$dva8=mysql_fetch_array(mysql_query("select * FROM users WHERE id='$dva[8]'"));
				echo "
					<tr>
						<td class='text-align-center'><span class='badge bg-info'>REKOMENDASI ANALIS</span></td>
						<td>".tgl_ind($dva[0])."</td>
						<td>".number_format($dva[1],0,",",".")."</td>
						<td>$dva[2] bulan</td>
						<td>$dva[3] %</td>
						<td>$dva4[nama_jj]</td>
						<td>$dva5[nama_sistem]</td>
						<td>$dva6[nama_sistem]</td>
						<td>$dva7[nama_tujuan]</td>
						<td>".number_format($dva[9],0,",",".")."</td>
						<td>$dva8[ins]</td>
					</tr>
					<tr>
						<td class='text-align-right'><i class='fa fa-edit'></i></td>
						<td colspan='10'>$dva[10]</td>
					</tr>
				";
				}
				if($status=="V2" OR $status=="V3" OR $status=="W" OR $status=="A") {
					$dvk4=mysql_fetch_array(mysql_query("select * FROM jenis_jasa WHERE id='$dvk[4]'"));			
					$dvk5=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$dvk[5]'"));			
					$dvk6=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$dvk[6]'"));			
					$dvk7=mysql_fetch_array(mysql_query("select * FROM tujuan_pinjaman WHERE id='$dvk[7]'"));
					$dvk8=mysql_fetch_array(mysql_query("select * FROM users WHERE id='$dvk[8]'"));
				echo "
					<tr>
						<td class='text-align-center'><span class='badge bg-primary'>APPROVED KEPALA</span></td>
						<td>".tgl_ind($dvk[0])."</td>
						<td>".number_format($dvk[1],0,",",".")."</td>
						<td>$dvk[2] bulan</td>
						<td>$dvk[3] %</td>
						<td>$dvk4[nama_jj]</td>
						<td>$dvk5[nama_sistem]</td>
						<td>$dvk6[nama_sistem]</td>
						<td>$dvk7[nama_tujuan]</td>
						<td>".number_format($dvk[9],0,",",".")."</td>
						<td>$dvk8[ins]</td>
					</tr>
					<tr>
						<td class='text-align-right'><i class='fa fa-edit'></i></td>
						<td colspan='10'>$dvk[10]</td>
					</tr>
				";
				}
				if($status=="V3" OR $status=="W" OR $status=="A") {
					$dvb4=mysql_fetch_array(mysql_query("select * FROM jenis_jasa WHERE id='$dvb[4]'"));			
					$dvb5=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$dvb[5]'"));			
					$dvb6=mysql_fetch_array(mysql_query("select * FROM sistem_angsuran WHERE id='$dvb[6]'"));			
					$dvb7=mysql_fetch_array(mysql_query("select * FROM tujuan_pinjaman WHERE id='$dvb[7]'"));
					$dvb8=mysql_fetch_array(mysql_query("select * FROM users WHERE id='$dvb[8]'"));
				echo "
					<tr>
						<td class='text-align-center'><span class='badge bg-success'>APPROVED BAWAS</span></td>
						<td>".tgl_ind($dvb[0])."</td>
						<td>".number_format($dvb[1],0,",",".")."</td>
						<td>$dvb[2] bulan</td>
						<td>$dvb[3] %</td>
						<td>$dvb4[nama_jj]</td>
						<td>$dvb5[nama_sistem]</td>
						<td>$dvb6[nama_sistem]</td>
						<td>$dvb7[nama_tujuan]</td>
						<td>".number_format($dvb[9],0,",",".")."</td>
						<td>$dvb8[ins]</td>
					</tr>
					<tr>
						<td class='text-align-right'><i class='fa fa-edit'></i></td>
						<td colspan='10'>$dvb[10]</td>
					</tr>
				";
				}
				if($status=="W" OR $status=="A") {
					$r=mysql_fetch_array(mysql_query("select * FROM users WHERE id='$dwt[1]'"));
				echo "
					<tr>
						<td class='text-align-center'><span class='badge bg-danger'>WAITING LIST</span></td>
						<td>".tgl_ind($dwt[0])."</td>
						<td colspan='8'></td>
						<td>$r[ins]</td>
					</tr>
				";
				}
				if($status=="A") {
				echo "
					<tr>
						<td class='text-align-center'><span class='badge bg-primary'>AKTIF</span></td>
						<td>".tgl_ind($row['tgl_cair'])."</td>
						<td>".number_format($row['alokasi'],0,",",".")."</td>
						<td>$row[jangka] bulan</td>
						<td>$row[pros_jasa] %</td>
						<td>$jj[nama_jj]</td>
						<td>$sp[nama_sistem]</td>
						<td>$sj[nama_sistem]</td>
						<td>$tp[nama_tujuan]</td>
						<td>".number_format($dvb[9],0,",",".")."</td>
						<td>$u[ins]</td>
					</tr>
				";
				}
				?>
					
				</tbody>
			</table>
		</div>			

		
<style>
@keyframes blink{
0%{color:red}
50%{color:white}
100%{color:red}
}
@-webkit-keyframes blink{
0%{color:red}
50%{color:white}
100%{color:red}
}
.blink{
-webkit-animation:blink 1s linear infinite;
-moz-animation:blink 1s linear infinite;
animation:blink 1s linear infinite
}
</style>

<?php 
$stt=mysql_fetch_array(mysql_query("select * FROM status_pinjaman WHERE kd_status='$status'"));
 
echo '
<blockquote class="blockquote-md fw-normal">
	<span class="blink"><i class="fa fa-circle"></i></span> ' .$stt['selanjutnya'].'
</blockquote>
';
?>


<?php
if ($status=="P" AND $_SESSION['level']=="1" AND $_SESSION['jabatan']=="4" OR 	//Analis
	$status=="V1" AND $_SESSION['level']=="1" AND $_SESSION['jabatan']=="1" OR	//Kepala LPD
	$status=="V2" AND $_SESSION['level']=="3" AND $_SESSION['jabatan']=="1" ) {  //Ketua Bawas
?>	<span class="h5 fw-normal">Silahkan masukkan rekomendasi anda pada form dibawah ini, kemudian beri centang dan klik tombol 'SIMPAN'</span>

	<div class='row'>
		
		<div class='col-sm-4'>
			<section class='widget' style='background-color:#f8f8f8;'>
                    <div class='widget-body clearfix'>
						<div id='validation-form' class='form-horizontal form-label-left'
								data-parsley-priority-enabled='false'
								novalidate='novalidate'>
								<fieldset>
								
									<input type="hidden" name="nia" id="nia" value="<?php echo $row['nia']?>" >
									<input type="hidden" name="id_pinj_i" id="id_pinj_i" value="<?php echo $id_pinj_i;?>" >
									<input type="hidden" name="status" id="status" value="<?php echo $status;?>" >
										    
										<label class='fs-sm'>Tanggal Rekomendasi</label>
										<input type='text' value="<?php echo $tgl ?>" name='tgl_rekomendasi' class='form-control' id='tgl_rekomendasi' <?php echo $disabled ?>
										required='required' autocomplete='off' placeholder='Tanggal Rekomendasi'>
									<br>
                                        <label class="fs-sm">Alokasi Kredit Rp.</label><br>
										<input type="text" value="<?php echo number_format($proposali,0,",",".") ?>" name="maksimum_kredit" class="form-control" id="maksimum_kredit"  <?php echo $disabled ?> onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" 
											required="required" autocomplete="off" placeholder="Maksimum Kredit Rp." >
                                    <br>
										<label class='fs-sm'>Jangka Waktu (Bulan)</label>
										<input type='text' name="jangka_waktu" class="form-control" id="jangka_waktu" value="<?php echo $jangka ?>"  <?php echo $disabled ?>
											required='required' autocomplete='off' placeholder='Jangka Waktu (Bulan)'>
									<br>    
										<label class="fs-sm">Prosentase Jasa (Persen)</label>
                                        <input type="text" name="prosentase_jasa" class="form-control" id="prosentase_jasa" value="<?php echo $pros_jasa ?>"  <?php echo $disabled ?>
										required="required" autocomplete="off" placeholder="Prosentase Jasa (%)">
									<br>
								</fieldset>
						</div>
					</div>
			</section>
		</div>
		<div class="col-sm-4">
			<section class='widget' style='background-color:#f8f8f8;'>
                    <div class='widget-body clearfix'>
						<div id='validation-form' class='form-horizontal form-label-left'
								data-parsley-priority-enabled='false'
								novalidate='novalidate'>
								<fieldset>
                                    
										<label class="fs-sm">Metode Perhitungan Bunga</label>
											<select id='jenis_bunga'  name='jenis_bunga' <?php echo $disabled ?>
												class='select form-control'
												tabindex='-1'> <?php
												if($action!="tambah") {
														echo "<option value='$jenis_jasa'>$jj[nama_jj]</option>";
												}
														$data=mysql_query('select * from jenis_jasa'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_jj] ($row[deskripsi_jj])</option>";
															}
															?>
											</select>
                                    <br>
										<label class='fs-sm'>Sistem Angsuran Pokok</label>
											<select id='sa_pokok'  name='sa_pokok' <?php echo $disabled ?>
												class='select form-control'
												tabindex='-1'> <?php
												if($action!="tambah") {
														echo "<option value='$sistem'>$sp[nama_sistem]</option>";
												}
														$data=mysql_query('select * from sistem_angsuran'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_sistem] ($row[deskripsi_sistem])</option>";
															}
															?>
											</select>
                                    <br>
										<label class='fs-sm'>Sistem Angsuran Bunga</label>
											<select id='sa_bunga'  name='sa_bunga' <?php echo $disabled ?>
												class='select form-control'
												tabindex='-1'> <?php
												if($action!="tambah") {
														echo "<option value='$sa_jasa'>$sj[nama_sistem]</option>";
												}
														$data=mysql_query('select * from sistem_angsuran'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_sistem] ($row[deskripsi_sistem])</option>";
															}
															?>
											</select>
                                    <br>    
										<label class="fs-sm">Tujuan Penggunaan Kredit</label>
										<select id='tujuan_penggunaan'  name='tujuan_penggunaan' <?php echo $disabled ?>
												class='select form-control'
												tabindex='-1'> <?php
												if($action!="tambah") {
														echo "<option value='$tujuan_permohonan'>$tp[nama_tujuan]</option>";
												}
														$data=mysql_query('select * from tujuan_pinjaman'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_tujuan]</option>";
															}
															?>
											</select>
									<br>
										
								</fieldset>
						</div>
					</div>
			</section>
		</div>
		<div class='col-sm-4'>
			<section class='widget' style='background-color:#f8f8f8;'>
				<div class='widget-body clearfix'>
					<div id='validation-form' class='form-horizontal form-label-left'
					data-parsley-priority-enabled='false' novalidate='novalidate'>
						<fieldset>    
							<label class='fs-sm'>Nilai Jaminan (CEV)</label>
                            <input type='text' value="<?php echo number_format($nilai_jaminan,0,",",".") ?>" name='nilai_jaminan' class='form-control' id='nilai_jaminan' <?php echo $disabled ?>
								required='required' autocomplete='off' placeholder='Nilai Jaminan (CEV)'>
                        <br>
							<label class="fs-sm">Catatan Rekomendasi</label>
							<textarea type="text" name="catatan_rekomendasi" id="catatan_rekomendasi"  class="form-control" rows="2" <?php echo $disabled ?>
							required="required" autocomplete="off" placeholder="Catatan Rekomendasi Anda"></textarea>
						<br>
							<label class="fs-sm">Rekomendasi Keputusan</label>
							<div class="checkbox checkbox-success">
								<input id="checkbox1" type="checkbox" value="setuju" <?php echo $disabled ?>>
									<label for="checkbox1" class="fs-mini">Saya setuju dan dapat diproses lebih lanjut</label>
							</div>
							<div class="checkbox checkbox-warning">
								<input id="checkbox2" type="checkbox" value="kembali" <?php echo $disabled ?>>
									<label for="checkbox2" class="fs-mini">Kembalikan ke Proses Sebelumnya</label>
							</div>
							<div class="checkbox checkbox-danger">
								<input id="checkbox3" type="checkbox" value="tidak_setuju" <?php echo $disabled ?>>
									<label for="checkbox3" class="fs-mini">Saya tidak setuju, dan tidak layak</label>
							</div>

						</fieldset>
					</div>
				</div>
			</section>
		</div>
			
			
	</div>
	<input type="hidden" name="keputusan" id="keputusan" value="" >
	<button class="btn btn-primary btn-block btn-lg fw-normal" id="SimpanRekomendasiKredit" disabled>SIMPAN REKOMENDASI ANDA <span id="KeputusanQ"></span></button>

					


<script type="text/javascript"> 

function tandaPemisahTitik(b){
				var _minus = false;
				if (b<0) _minus = true;
				b = b.toString();
				b=b.replace(".","");
				
				c = "";
				panjang = b.length;
				j = 0;
				for (i = panjang; i > 0; i--){
					 j = j + 1;
					 if (((j % 3) == 1) && (j != 1)){
					   c = b.substr(i-1,1) + "." + c;
					 } else {
					   c = b.substr(i-1,1) + c;
					 }
				}
				if (_minus) c = "-" + c ;
				return c;
			}

			function numbersonly(ini, e){
				if (e.keyCode>=48){
					if(e.keyCode<=57){
					a = ini.value.toString().replace(".","");
					b = a.replace(/[^\d]/g,"");
					b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
					ini.value = tandaPemisahTitik(b);
					return false;
					}
					else if(e.keyCode<=105){
						if(e.keyCode>=96){
							//e.keycode = e.keycode - 47;
							a = ini.value.toString().replace(".","");
							b = a.replace(/[^\d]/g,"");
							b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
							ini.value = tandaPemisahTitik(b);
							//alert(e.keycode);
							return false;
							}
						else {return false;}
					}
					else {
						return false; }
				}else if (e.keyCode==95){
					a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
					b = a.replace(/[^\d]/g,"");
					if (parseFloat(b)!=0){
						ini.value = tandaPemisahTitik(b);
						return false;
					} else {
						return false;
					}
				}else if (e.keyCode==8 || e.keycode==46){
					a = ini.value.replace(".","");
					b = a.replace(/[^\d]/g,"");
					b = b.substr(0,b.length -1);
					if (tandaPemisahTitik(b)!=""){
						ini.value = tandaPemisahTitik(b);
					} else {
						ini.value = "";
					}
					
					return false;
				} else if (e.keyCode==9){ //Tab
					return true;
				} else if (e.keyCode==17){ //Ctrl
					return true;
				} else {
					//alert (e.keyCode);
					return false;
				}

			}

			$(document).ready(function() {
				
				$('#checkbox1').click(function () {
					//check if checkbox is checked
					if ($(this).is(':checked')) {

						$('#SimpanRekomendasiKredit').removeAttr('disabled'); //enable input
						$('#keputusan').val('setuju');
						$('#KeputusanQ').html("(SETUJU)");

					} else {
						$('#SimpanRekomendasiKredit').attr('disabled', true); //disable input
					}
				});
				
				$('#checkbox2').click(function () {
					//check if checkbox is checked
					if ($(this).is(':checked')) {

						$('#SimpanRekomendasiKredit').removeAttr('disabled'); //enable input
						$('#keputusan').val('kembali');
						$('#KeputusanQ').html("(KEMBALIKAN)");

					} else {
						$('#SimpanRekomendasiKredit').attr('disabled', true); //disable input
					}
				});
				
				$('#checkbox3').click(function () {
					//check if checkbox is checked
					if ($(this).is(':checked')) {

						$('#SimpanRekomendasiKredit').removeAttr('disabled'); //enable input
						$('#keputusan').val('tidak_setuju');
						$('#KeputusanQ').html("(TIDAK SETUJU)");

					} else {
						$('#SimpanRekomendasiKredit').attr('disabled', true); //disable input
						
					}
				});

			
				$("#maksimum_kredit").focus();
				$("#maksimum_kredit").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
					
				$("#jangka_waktu").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
					
					
				$("#SimpanRekomendasiKredit").click(function() {
                    var keputusan		= $('#keputusan').val();
                    var nia				= $('#nia').val();
					//Data Pinjaman
					var id_pinj_i			= $('#id_pinj_i').val();
					var status				= $('#status').val();
					var tgl_rekomendasi		= $('#tgl_rekomendasi').val();
					var maksimum_kredit		= $('#maksimum_kredit').val();
					var jangka_waktu		= $('#jangka_waktu').val();
					var prosentase_jasa		= $('#prosentase_jasa').val();
					var jenis_bunga			= $('#jenis_bunga').val();
					var sa_pokok			= $('#sa_pokok').val();
					var sa_bunga			= $('#sa_bunga').val();
					var nilai_jaminan		= $('#nilai_jaminan').val();
					var tujuan_penggunaan	= $('#tujuan_penggunaan').val();
					var catatan_rekomendasi	= $('#catatan_rekomendasi').val();
					
					if(proposali.length==0){ alert('Alokasi Pengajuan tidak boleh kosong!');
						$("#maksimum_kredit").focus();
						return false;
							}
						
						if(prosentase_jasa.length==0){ alert('Prosentase Jasa tidak boleh kosong!');
						$("#prosentase_jasa").focus();
						return false;
							}
						
						if(jangka_waktu.length==0){ alert('Jangka waktu tidak boleh kosong!');
						$("#jangka_waktu").focus();
						return false;
							}
								
                    $.ajax({
                        type: "POST",
                        url: "modul/pinjaman/proposal/simpan_rekomendasi_individu.php",
                        data: 	"id_pinj_i="+id_pinj_i+
								"&keputusan="+keputusan+
								"&status="+status+
								"&nia="+nia+
								"&tgl_rekomendasi="+tgl_rekomendasi+
								"&maksimum_kredit="+maksimum_kredit+
								"&jangka_waktu="+jangka_waktu+
								"&prosentase_jasa="+prosentase_jasa+
								"&jenis_bunga="+jenis_bunga+
								"&sa_pokok="+sa_pokok+
								"&sa_bunga="+sa_bunga+
								"&nilai_jaminan="+nilai_jaminan+
								"&tujuan_penggunaan="+tujuan_penggunaan+
								"&catatan_rekomendasi="+catatan_rekomendasi,
								
						success: function(data) {
                           //$("#Sukses").load('modul/pinjaman/register/sukses.php');
						   window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ_i&sT=<?php echo $status; ?>&s=ok';
                        }

                    });

                });
					
			});
			
</script>

<?php
}else if ($status=="V3") {
?>

		<?php
		$cari_akt=mysql_num_rows(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE 
		nia='$row[nia]' AND status='A' "));
		if ($cari_akt>0) {
		?>
							<div class="form-actions bg-danger col-sm-6 mt-n-md">
								<p class="text-justify text-white">
								Namun mohon maaf, proposal ini tidak dapat masuk ke daftar tunggu,<br>
								Pemanfaat masih terdeteksi memiliki pinjaman aktif.<br>
								Jika Pemanfaat ini telah lunas, mungkin anda belum melakukan Validasi Lunas.<br>
								Silahkan klik tombol Validasi untuk cek pinjaman tersebut.<br><br>
								</p>
								<a class="btn btn-default btn-rounded pull-right" href="?p=vL_i"><i class="fa fa-gavel"></i> Lihat Validasi Pelunasan</a>
							</div>
		<?php }else{ ?>					
							<div class="form-actions col-sm-12 mt-n-md">
									<div class="col-sm-4">
										<p class="text-justify fs-mini">
										Untuk memasukkan proposal ke daftar tunggu, silahkan masukkan Rencana Tanggal cair kemudian klik tombol 'Masukkan ke Daftar Tunggu'
										</p>
									</div>
									<div class="form-group col-sm-3">
										<span class="fs-mini text-muted">Rencana Tanggal Cair</span>
										<input name="tgl_cair" id="tgl_cair" type="text" class="form-control" value="<?php echo date('Y-m-d');?>"
										required="required" autocomplete="off" placeholder="Tanggal Cair"/>
										<input name="id_pinj_i_dt" id="id_pinj_i_dt" type="hidden" class="form-control" value="<?php echo $id_pinj_i;?>" />
									</div>
									<div class="form-group col-sm-5">
										<span class="fs-mini text-muted">Action</span><br>
										<button class="btn btn-inverse btn-rounded" id="GoWaitingIndividu"><i class="fa fa-wheelchair"></i> Masukkan ke Daftar Tunggu</button>
									</div>
							</div>
							
							<script type="text/javascript"> 

								$(document).ready(function() {

									$("#tgl_cair").focus();
									$("#GoWaitingIndividu").click(function() {
										var id_pinj_i_dt	= $('#id_pinj_i_dt').val();
										var tgl_cair	= $('#tgl_cair').val();
										
										if(tgl_cair.length==0){ alert('Tanggal Cair tidak boleh kosong!');
											$("#tgl_cair").focus();
											return false;
												}
									
									var pilih = confirm('Masukkan ke Daftar Tunggu dengan Tanggal Cair '+tgl_cair+ '?');
									if (pilih==true) {	
												$.ajax({
													type: "POST",
													url: "modul/pinjaman/verified/simpan_tgl_cair_individu.php",
													data: 	"id_pinj_i_dt="+id_pinj_i_dt+
															"&tgl_cair="+tgl_cair,
													success: function(data) {
														window.location.href='2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=pJ_i&sT=V3&s=suksesWL';
													}
												});
											}
											});
										
								});
								
							</script>
		
		<?php } ?>
<?php
}else if ($status=="W" OR $status=="A" OR $status=="L") {
?>


							<div class="form-actions col-sm-12 mt-n-md">
									<p class="fs-mini mt-n-sm">
										<?php if (empty($row['spk_no'])) { 
											echo "Untuk membuat Dokumen Pencairan, silahkan masukkan nomor SPK kemudian klik tombol 'Buat Dokumen Pencairan'"; 
										}else{
											echo "Silahkan cetak Dokumen Pencairan dengan klik link list dibawah ini, untuk merubah nomor SPK klik tombol 'Ubah Nomor SPK' "; 
										} ?>
									</p>
									<div class="form-group col-sm-4">
										<span class="fs-mini text-muted">Nomor SPK</span>
										<input type="text" name="spk_no" id="spk_no" class="form-control" value="<?php echo $row['spk_no'];?>"
											required="required" autocomplete="off" placeholder="Masukkan Nomor SPK disini..."/>
										<input name="id_pinj_i_dp" id="id_pinj_i_dp" type="hidden" class="form-control" value="<?php echo $id_pinj_i;?>" />
										<button class="btn btn-inverse btn-block" id="SimpanSPKNOIndividu"><i class="glyphicon glyphicon-edit"></i> <?php if (empty($row['spk_no'])) { echo "Buat Dokumen Pencairan"; }else{ echo "Ubah Nomor SPK"; } ?></button>
									</div>
									<div class="form-group col-sm-1">
									</div>
									<div class="form-group col-sm-7">
									<?php
									if (empty($row['spk_no'])) {
										echo '<div id="SuksesSPKNO"></div>';
									}else{
										echo '<div id="CetakPencairan"></div>';
									}
									?>
									</div>
							</div>
							
							<script type="text/javascript"> 
							
							$("#CetakPencairan").load('modul/pinjaman/proposal/cetak_pencairan_individu.php');

								$(document).ready(function() {

									$("#spk_no").focus();
									$("#SimpanSPKNOIndividu").click(function() {
										var spk_no = $('#spk_no').val();
										var id_pinj_i_dp = $('#id_pinj_i_dp').val();
										
										if(spk_no.length==0){ $("#spk_no").focus(); return false; }
											
										$.ajax({
											type: "POST",
											url: "modul/pinjaman/proposal/simpan_spk_no_individu.php",
											data:"spk_no="+spk_no+
												"&idpinj="+id_pinj_i_dp,
											
											success: function(data) {
												$("#SuksesSPKNO").load('modul/pinjaman/proposal/cetak_pencairan_individu.php');
												$("#CetakPencairan").load('modul/pinjaman/proposal/cetak_pencairan_individu.php');
												//$("#SelamatSukses").load('modul/pinjaman/proposal/SelamatSukses.php');
												//$("#NomorSPK").load('modul/pinjaman/proposal/spk_no_individu.php');
											}
										});
									});
										
								});
								
							</script>

<?php
}
?>	