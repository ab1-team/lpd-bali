<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$id_kel		=$_POST['id_kel'];
$id_pinj	=$_POST['id_pinj'];

$_SESSION['id_pinkel']=$id_pinj;

$data=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE a.id=pa.nia AND pa.id_kel='$id_kel' AND pa.`status`!='P' ");

$rows=mysql_num_rows($data);

if($rows<=0) {
	
	echo "
<div class='alert alert-danger fs-mini'>
	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
	<i class='glyphicon glyphicon-info-sign'></i> <strong>Informasi!</strong><br>
	Tidak ada data pemanfaat pada pinjaman sebelumnya, <br>silahkan klik menu Tambah Pemanfaat.
</div>
	";
	
}else{
	
?>


<div class='alert alert-success fs-mini'>
	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'><i class='fa fa-times-circle'></i></button>
	<i class="glyphicon glyphicon-info-sign"></i> <strong>Petunjuk!</strong><br>
	Silahkan klik Icon <i class="fa fa-plus"></i> untuk import, <br>jika YBS tidak mengajukan kembali jangan klik Iconnya.
</div>
																	<table>
																			<tr>
																				<td class="col-sm-7">Pemanfaat Sebelumnya</td>
																				<td class="col-sm-5">Alokasi</td>
																			</tr>
																			<tr><td colspan="2">&nbsp;</td></tr>
																		<?php
																		
																			while($pa=mysql_fetch_array($data)){
																				$nia=$pa['nia'];
																				
																				$pk=mysql_fetch_array(mysql_query("select * from pinjaman_kelompok_$_SESSION[kd_kab] WHERE id='$id_pinj' "));
																				
																				$cek=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE nia='$nia' AND `status`='P' AND id_pinkel!='$id_pinj' OR nia='$nia' AND `status`='V' AND id_pinkel!='$id_pinj' OR nia='$nia' AND `status`='W' AND id_pinkel!='$id_pinj' OR nia='$nia' AND `status`='M' AND id_pinkel!='$id_pinj' ");
																				
																				$cek_nia=mysql_num_rows($cek);
																				$kel=mysql_fetch_array($cek);
																				
																				$cek_kel=$kel['id_pinkel'];

																		?>
																		
																		
																			<script type="text/javascript">
																					$(document).ready(function() {
																			//SIMPAN ALOKASI ANGGOTA				
																							 $("#SimpanAlokasiAnggota<?php echo $nia; ?>").click(function() {
																								var id_kel			= $('#id_kel<?php echo $nia; ?>').val();
																								var id_pinkel		= $('#id_pinkel<?php echo $nia; ?>').val();
																								var nia				= $('#nia<?php echo $nia; ?>').val();
																								var jenis_pp		= $('#jenis_pp<?php echo $nia; ?>').val();
																								var alokasi_anggota	= $('#alokasi_anggota<?php echo $nia; ?>').val();
																								var cek_nia			= $('#cek_nia<?php echo $nia; ?>').val();
																								var cek_kel			= $('#cek_kel<?php echo $nia; ?>').val();
																								
																								if(alokasi_anggota.length==0){ alert('Silahkan isi pengajuan Anggota!');
																									$("#alokasi_anggota<?php echo $nia; ?>").focus();
																									return false;
																										}
																										
																								if(cek_nia > 0){ //Jika punya proposal lain
																								
																											$.ajax({
																												type: "POST",
																												url: "modul/pinjaman/register/cek_nia.php",
																												data: 	"nia="+nia+
																														"&cek_kel="+cek_kel,
																												
																												success: function(data) {
																													$("#CekNia<?php echo $nia; ?>").html(data);

																												}
																											});
							
																										}
																											
																								$.ajax({ //Jika tidak punya proosal lain
																									type: "POST",
																									url: "modul/pinjaman/register/simpan_proposal_a.php",
																									data: 	"id_kel="+id_kel+
																											"&id_pinkel="+id_pinkel+
																											"&nia="+nia+
																											"&jenis_pp="+jenis_pp+
																											"&alokasi_anggota="+alokasi_anggota,
																									
																									success: function(data) {
																										$("#TampilPemanfaat").load('modul/pinjaman/register/tampil_pemanfaat.php');

																									}
																								});

																							});
																					});
																			</script>
																			
																			
																			<tr>
																				<td class="col-sm-7"><?php echo "<b>$pa[namadepan]</b><br>$pa[nik]";?></td>
																				<td class="col-sm-5">
																					<div class="input-group">
																						<input type="text" class="form-control" name="alokasi_anggota<?php echo $nia; ?>" id="alokasi_anggota<?php echo $nia; ?>" required="required" autocomplete="off" value="<?php echo $pa['alokasi'];?>">
																						<input type="hidden" name="id_kel<?php echo $nia; ?>" id="id_kel<?php echo $nia; ?>" value="<?php echo $id_kel;?>"/>
																						<input type="hidden" name="id_pinkel<?php echo $nia; ?>" id="id_pinkel<?php echo $nia; ?>" value="<?php echo $id_pinj;?>"/>
																						<input type="hidden" name="nia<?php echo $nia; ?>" id="nia<?php echo $nia; ?>" value="<?php echo $nia;?>"/>
																						<input type="hidden" name="jenis_pp<?php echo $nia; ?>" id="jenis_pp<?php echo $nia; ?>" value="<?php echo $pk['jenis_pp'];?>"/>
																						<input type="hidden" name="cek_nia<?php echo $nia; ?>" id="cek_nia<?php echo $nia; ?>" value="<?php echo $cek_nia;?>"/>
																						<input type="hidden" name="cek_kel<?php echo $nia; ?>" id="cek_kel<?php echo $nia; ?>" value="<?php echo $cek_kel;?>"/>
																						
																							<div class="input-group-btn">
																								<button type="button" class="btn btn-primary" id="SimpanAlokasiAnggota<?php echo $nia; ?>"><i class="fa fa-plus"></i></button>
																							</div>
																					</div>
																				</td>
																			</tr>
																			<tr><td colspan="2">&nbsp;</td></tr>
																			<tr><td colspan="2"><div id="CekNia<?php echo $nia; ?>"></div></td></tr>
																		<?php
																		}
																		?>
																			
																	</table>

<?php
}
?>