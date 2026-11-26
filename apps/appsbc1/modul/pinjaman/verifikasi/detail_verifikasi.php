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

</script>

<?php 
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
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
<section class="widget">
 <div class="widget-body">
<legend>
	<h4 class="page-title"><span class="fw-semi-bold"> KELOMPOK <?php echo strtoupper($row['nama_kelompok']);?></span> Loan ID. <?php echo "$row[id]";?>
	<span class="fw-semi-bold pull-right"><a href="#tabk12" data-toggle="tab"><i class="glyphicon glyphicon-arrow-left"></i> back</a></span></h4>
	<p class="mt-n-md"> Alamat : <?php echo "$row[alamat_kelompok] $row[nama_desa] Telp.$row[telpon]";?></p> 
</legend>	
		
	<span class='fw-semi-bold'>FORM INPUT HASIL VERIFIKASI ANGGOTA</span>
	<div class="table-responsive">
                    <table id="datatable-table" class="table table-hover">
                        <thead class="bg-gray text-white">
                        <tr>
                            <th>No</th>
                            <th class="hidden-xs">Nama Calon Pemanfaat</th>
                            <th class="hidden-xs">Proposal</th>
                            <th class="hidden-xs">Rekomendasi</th>
                            <th class="hidden-xs">Catatan Verifikasi</th>
                            <th class="no-sort">Save</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

						$data=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa where pa.nia=a.id AND pa.id_pinkel='$id' order by pa.id");
								$no=0;
								while($r=mysql_fetch_array($data)){
								$no=$no+1;
								$idpa				=$r['id'];
								$idpinj				=$r['id_pinkel'];
								$_SESSION['idpinj']	=$idpinj;
								$proposala			=$r['proposal'];
								$alokasia			=$r['alokasi'];
								$catatan_verifikasi	=$r['catatan_verifikasi'];
						echo "
						<tr>
                            <td>$no</td>
							<td>$r[nik] - $r[namadepan] <span class='text-muted mt mb'>($r[alamat])</span></td>
							<td class='text-align-right'>".number_format($proposala)."</td>
							<td><input type='text' name='alokasia$idpa' id='alokasia$idpa' class='form-control input-sm text-align-right'
								value='$alokasia' required='required' autocomplete='off' placeholder='Alokasi Anggota'></td>
							<td><input type='text' name='catatan_anggota$idpa' id='catatan_anggota$idpa' class='form-control input-sm'
								value='$catatan_verifikasi' autocomplete='off' placeholder='Catatan untuk $r[namadepan]'>
							</td>
							<td><div id='SuksesEditVA$idpa'></div></td>
						</tr> "; ?>
						
						<script type="text/javascript">
						
						$("#alokasia<?php echo $idpa; ?>").keypress(function (data)  { 
								if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
									  return false;
								}	
							});
												$("#Alokasi").load('modul/pinjaman/verifikasi/total_alokasi.php');
												
													$("#alokasia<?php echo $idpa; ?>").keyup(function() {
														var idpa			= <?php echo $idpa; ?>;
														var idpinj			= <?php echo $idpinj; ?>;
														var alokasia		= $('#alokasia<?php echo $idpa; ?>').val();
														var catatan_anggota	= $('#catatan_anggota<?php echo $idpa; ?>').val();

																	$.ajax({
																		type	: "POST",
																		url		: "modul/pinjaman/verifikasi/simpan_verified_a.php",
																		data	: "idpa="+idpa+
																					"&idpinj="+idpinj+
																					"&alokasia="+alokasia+
																					"&catatan_anggota="+catatan_anggota,
																		success: function(data) {
																			$("#SuksesEditVA<?php echo $idpa; ?>").load('modul/pinjaman/verifikasi/sukses_edit_va.php');
																			$("#Alokasi").load('modul/pinjaman/verifikasi/total_alokasi.php');
																			$("#AlokasiKelompok").load('modul/pinjaman/verifikasi/alokasi.php');

																		}
																	});
																});
																
																
														$("#catatan_anggota<?php echo $idpa; ?>").keyup(function() {
														var idpa			= <?php echo $idpa; ?>;
														var idpinj			= <?php echo $idpinj; ?>;
														var alokasia		= $('#alokasia<?php echo $idpa; ?>').val();
														var catatan_anggota	= $('#catatan_anggota<?php echo $idpa; ?>').val();

																	$.ajax({
																		type	: "POST",
																		url		: "modul/pinjaman/verifikasi/simpan_verified_a.php",
																		data	: "idpa="+idpa+
																					"&idpinj="+idpinj+
																					"&alokasia="+alokasia+
																					"&catatan_anggota="+catatan_anggota,
																		success: function(data) {
																			$("#SuksesEditVA<?php echo $idpa; ?>").load('modul/pinjaman/verifikasi/sukses_edit_va.php');
																			$("#Alokasi").load('modul/pinjaman/verifikasi/total_alokasi.php');
																			$("#AlokasiKelompok").load('modul/pinjaman/verifikasi/alokasi.php');

																		}
																	});
																});
	
												</script>
						<?php
						 
						 $sumproposala=$sumproposala+$proposala;
						 
						 }
						 
						echo "
						<tr>
							<td class='text-align-right fw-semi-bold' colspan='3'>".number_format($sumproposala)."</td>
							<td class='text-align-right fw-semi-bold'><div id='Alokasi'></div></td>
                        </tr> 
						</table>
				</div>
						";
						
						//INPUT PROPOSAL KELOMPOK
						echo "					<hr>
											
										<div class='col-md-8'>
											<span class='fw-semi-bold'>FORM INPUT HASIL VERIFIKASI KELOMPOK</span>
											<table width='100%' class='table table-hover'>
												<tr class='bg-body'>
												  <th width='20%'>Loan ID. $id </th>
											      <th width='20%'>Tanggal</th>
											      <th width='20%'>Alokasi</th>
											      <th width='10%'>Jasa</th>
										          <th width='10%'>Jangka</th>
									              <th width='15%'>Sistem</th>
												</tr>
												<tr>
												  <th>Data Proposal</th>
												  <td>$tgl_proposal</td>
												  <td>".number_format($proposal)."</td>
												  <td>$pros_jasa %</td>
												  <td>$jangka kali</td>
												  <td>$sistem_angsuran</td>
												</tr>
												<tr>
												  <th>Data Verifikasi</th>
												  <input type='hidden' name='id_pinj' id='id_pinj' value='$id'/>
												  <td><input type='text' name='tgl_verifikasi' id='tgl_verifikasi' class='form-control input-sm text-align-center'
														value='$tgl_now' required='required' autocomplete='off' placeholder='Tanggal Verifikasi'></td>
												  <td><div id='AlokasiKelompok'></div></td>
												  <td><input type='text' name='pros_jasa' id='pros_jasa' class='form-control input-sm text-align-center'
														value='$pros_jasa' required='required' autocomplete='off' placeholder='Prosentase Jasa'></td>
												  <td><input type='text' name='jangka' id='jangka' class='form-control input-sm text-align-center'
														value='$jangka' required='required' autocomplete='off' placeholder='Jangka Waktu'></td>
												  <td>
														<select id='sistem'  name='sistem'
															class='select form-control'
															tabindex='-1'> ";
															echo "<option value=$row[sistem_angsuran]>$row[nama_sistem]</option>";
																	$datas=mysql_query('select * from sistem_angsuran'); 
																		while($rows=mysql_fetch_array($datas)){
																		echo "<option value=$rows[id]>$rows[nama_sistem]</option>";
																		}
															echo "
														</select>
													</td>
												</tr>
											</table>
											<p class='fs-sm text-justify mt-n-sm'>
											<span class='fw-semi-bold'> Verified Sign:</span><br>
													Dengan menekan tombol 'VERIFIKASI' dengan ini Tim Verifikasi Unit Pengelola Kegiatan Kecamatan $row[nama_kec] menyatakan dengan sebenar-benarnya sesuai dengan hasil survey 
													lapangan bahwa kelompok dengan identitas tersebut diatas ADA keberadaannya dan dapat dipertanggungjawabkan sesuai dengan peraturan yang 
													berlaku. Serta LAYAK untuk diberikan pinjaman sesuai dengan hasil rekomendari Verifikasi diatas.
											</p>
										</div>
										<div class='col-md-4'>
											<div class='form-group'>
												<i class='fa fa-pencil'></i> Catatan Verifikasi :
												<textarea rows='4' class='form-control' value='$catatan_verifikasik' name='catatan_verifikasi' id='catatan_verifikasi' placeholder='Catatan Verifikasi untuk Kelompok $row[nama_kelompok]'></textarea>
											</div>
											<div class='text-center'>
												<button href='' type='button' class='btn btn-danger btn-rounded width-200 mt-md' id='GoVerified'><i class='fa fa-check'></i> VERIFIKASI</button>
											</div>
										</div>
										";
						 ?>
                        </tbody>
                    </table>
                </div>
            
        
</div>
</section>
</div>



