<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$idk	= $_POST['kelompok'];

if($idk>0) {
$kel	= mysql_query("SELECT * FROM desa d, kelompok_$_SESSION[kd_kab] k WHERE d.id=k.desa AND k.id= '$idk' ");
}

$r 	= mysql_fetch_array($kel);
	$kec=mysql_fetch_array(mysql_query("select * from kecamatan where id='$_SESSION[lokasi]'"));
	$st=mysql_query("select * from pinjaman_kelompok_$_SESSION[kd_kab] WHERE id_kel='$r[id]' ORDER BY id DESC ");
		$rows	= mysql_num_rows($st);
		$row=mysql_fetch_array($st);
		$status=$row['status'];
		$desk=mysql_fetch_array(mysql_query("select * from status_pinjaman WHERE kd_status='$status' "));
		
		$jj=mysql_fetch_array(mysql_query("select * from jenis_jasa where id='$row[jenis_jasa]'"));//JENIS JASA
		$sa=mysql_fetch_array(mysql_query("select * from sistem_angsuran where id='$row[sistem_angsuran]'"));//ANGSURAN POKOK 
		$sj=mysql_fetch_array(mysql_query("select * from sistem_angsuran where id='$row[sa_jasa]'"));//ANGSURAN JASA 
		$jpp=mysql_fetch_array(mysql_query("select * from jenis_produk_pinjaman where id='$r[jenis_produk_pinjaman]'"));//JENIS PRODUK PINJAMAN

if ($rows<=0 or $rows>0 and $status=="L" or $rows>0 and $status=="A" ){
	$tgl		=date('Y-m-d');
	$idp		="";
	$proposal	="";
	$pros_jasa	=$kec['def_jasa'];
	$jangka		=$kec['def_jangka'];
	$jenis_jasa	="";
	$sistem	="";
	$sa_jasa	="";
	$disabled	="";
	$tombol		="Simpan";
}else if ($rows>0 and $status=="P"){
	$tgl		=$row['tgl_proposal'];
	$idp		=$row['id'];
	$proposal	=$row['proposal'];
	$pros_jasa	=$row['pros_jasa'];
	$jangka		=$row['jangka'];
	$jenis_jasa	="<option value=$jj[id]>$jj[nama_jj] ($jj[deskripsi_jj])</option>";
	$sistem		="<option value=$sa[id]>$sa[nama_sistem] ($sa[deskripsi_sistem])</option>";
	$sa_jasa	="<option value=$sj[id]>$sj[nama_sistem] ($sj[deskripsi_sistem])</option>";
	$disabled	="";
	
	$_SESSION['id_kel']=$r['id'];
	$_SESSION['id_pinkel']=$row['id'];
	$_SESSION['proposal']=$row['proposal'];
	$_SESSION['sts']=$row['status'];
	$tombol		="Ubah";
	
}else if ($rows>0 and $status=="V" or $rows>0 and $status=="W" ){
	$tgl		=$row['tgl_proposal'];
	$idp		=$row['id'];
	$proposal	=$row['proposal'];
	$pros_jasa	=$row['pros_jasa'];
	$jangka		=$row['jangka'];
	$jenis_jasa	="<option value=$jj[id]>$jj[nama_jj] ($jj[deskripsi_jj])</option>";
	$sistem		="<option value=$sa[id]>$sa[nama_sistem] ($sa[deskripsi_sistem])</option>";
	$sa_jasa	="<option value=$sj[id]>$sj[nama_sistem] ($sj[deskripsi_sistem])</option>";
	$disabled	="disabled";
	$tombol		="Simpan";
	
	$_SESSION['id_kel']=$r['id'];
	$_SESSION['id_pinkel']=$row['id'];
	$_SESSION['proposal']=$row['proposal'];
	$_SESSION['sts']=$row['status'];
}
	
	?>
	
	
<script type="text/javascript"> 
			

			$(document).ready(function() {
				
				$("#proposal").focus();
				
				$("#TampilPemanfaat").load('modul/pinjaman/register/tampil_pemanfaat.php');
				$("#ImportAnggota").load('modul/pinjaman/register/import_pemanfaat.php');
				$("#CetakProposal").load('modul/pinjaman/proposal/cetak_proposal.php');
			
				$("#proposal").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
					
				$("#jangka").keypress(function (data)  { 
						if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)){
							  return false;
						}	
					});
					
				
				$("#SimpanProposal").click(function() {
                    var id_pinj			= $('#id_pinj').val();
                    var id_kel			= $('#id_kel').val();
                    var tgl_proposal	= $('#tgl_proposal').val();
                    var jenis_pp		= $('#jenis_pp').val();
                    var proposal		= $('#proposal').val();
                    var pros_jasa		= $('#pros_jasa').val();
                    var jenis_jasa		= $('#jenis_jasa').val();
                    var jangka			= $('#jangka').val();
                    var sistem			= $('#sistem').val();
                    var sa_jasa			= $('#sa_jasa').val();
					
					if(tgl_proposal.length==0){ $("#konfirmasi").load('modul/penduduk/dilarang_kosong.php');
						$("#tgl_proposal").focus();
						return false;
							}
							
					if(proposal.length==0){ $("#konfirmasi").load('modul/penduduk/dilarang_kosong.php');
						$("#proposal").focus();
						return false;
							}
							
					if(pros_jasa.length==0){ $("#konfirmasi").load('modul/penduduk/dilarang_kosong.php');
						$("#pros_jasa").focus();
						return false;
							}
					
					if(jangka.length==0){ $("#konfirmasi").load('modul/penduduk/dilarang_kosong.php');
						$("#jangka").focus();
						return false;
							}
								
                    $.ajax({
                        type: "POST",
                        url: "modul/pinjaman/register/simpan_proposal.php",
                        data: 	"id_pinj="+id_pinj+
								"&id_kel="+id_kel+
								"&tgl_proposal="+tgl_proposal+
								"&jenis_pp="+jenis_pp+
								"&proposal="+proposal+
								"&pros_jasa="+pros_jasa+
								"&jenis_jasa="+jenis_jasa+
								"&jangka="+jangka+
								"&sistem="+sistem+
								"&sa_jasa="+sa_jasa,
								
						success: function(data) {
                           $("#DaftarPemanfaat").load('modul/pinjaman/register/daftar_pemanfaat.php');
						   $("#TampilPemanfaat").load('modul/pinjaman/register/tampil_pemanfaat.php');

                        }

                    });

                });
				
				
				$("#PilihPemanfaatProposal").click(function(){
						var cari = $("#PilihPemanfaatProposal").val();
						$.ajax({
							type	: "POST",
							url		: "modul/pinjaman/proposal/pilih_pemanfaat.php",
							data	: "cari="+cari,
							success	: function(data){
								$("#PilihPemanfaat").html(data);
							}
						});
					});
				
				$("#ImportPemanfaatProposal").click(function(){
						var id_kel = $("#ImportPemanfaatProposal").val();
						var id_pinj = $("#PilihPemanfaatProposal").val();
						$.ajax({
							type	: "POST",
							url		: "modul/pinjaman/register/import_pemanfaat.php",
							data	: "id_kel="+id_kel+
										"&id_pinj="+id_pinj,
							success	: function(data){
								$("#ImportPemanfaat").html(data);
							}
						});
					});
					
					
					
			});
</script>	


<legend>&nbsp;
</legend>
	
<?php	

	echo"
<div class='row'>
<div class='col-sm-12'>
<section class='widget' style='background-color:#ddddee;'>
                    <div class='widget-body clearfix'>
						<div class='widget-top-overflow windget-padding-md clearfix bg-primary mb'>
                            <span class='h5 text-white fw-bold'><i class='fa fa-book'></i> Proposal Kelompok <span class='pull-right'>Loan ID. $idp</span></span>
                        </div>
	<div class='col-sm-6'>
									<div class='form-group'>
                                        <label class='control-label col-sm-4'>Nama Kelompok</label>
                                        <label class='control-label col-sm-8'>: <b>$r[nama_kelompok] ($r[ketua])</b> <span class='badge bg-$desk[warna_status]'>$desk[kd_status]</span></label>
                                    </div>
									<div class='form-group'>
                                        <label class='control-label col-sm-4'>Alamat</label>
                                        <label class='control-label col-sm-8'>: <b>$r[alamat] $r[nama_desa]</b></label>
                                    </div>
									
									<div class='form-group'>
                                        <label class='control-label col-sm-4'>Tanggal Proposal</label>
                                        <div class='col-sm-8'><input type='text' name='tgl_proposal' class='form-control' id='tgl_proposal' value='$tgl' $disabled
										required='required' autocomplete='off' placeholder='Tanggal Proposal'> </div>
                                    </div>
									
									<div class='form-group'>
                                        <label class='control-label col-sm-4'>Pengajuan Rp.</label>
                                        <div class='col-sm-8'><input type='text' name='proposal' class='form-control' id='proposal' value='$proposal' $disabled
										required='required' autocomplete='off' placeholder='-- Alokasi Pengajuan Pinjaman Kelompok --'> </div>
                                    </div>

									<div class='form-group'>
                                        <label class='control-label col-sm-4'>Prosentase Jasa</label>
                                        <div class='col-sm-2'><input type='text' name='pros_jasa' class='form-control' id='pros_jasa' value='$pros_jasa' $disabled
										required='required' autocomplete='off' placeholder='Prosentase Jasa (%)'> </div>
										
										<label class='control-label col-sm-3'>%  / &nbsp Jangka :</label>
										<div class='col-sm-2'><input type='text' name='jangka' class='form-control' id='jangka' value='$jangka' $disabled
											required='required' autocomplete='off' placeholder='Jangka Waktu'> </div>
										<label class='control-label col-sm-1'>bln</label>
                                    </div>                                
	</div>
	<div class='col-sm-6'>
									<div class='form-group'>
										<label class='control-label col-sm-4'>Jenis Jasa</label>
										<div class='col-sm-8'>
											<select id='jenis_jasa'  name='jenis_jasa' $disabled
												class='select form-control'
												tabindex='-1'> 
													";
													echo "$jenis_jasa";
														$data=mysql_query('select * from jenis_jasa'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_jj] ($row[deskripsi_jj])</option>";
															}
												echo "
											</select>
										</div>
                                    </div>
									
									<div class='form-group'>
										<label class='control-label col-sm-4'>Sistem Angs. Pokok</label>
										<div class='col-sm-8'>
											<select id='sistem'  name='sistem' $disabled
												class='select form-control'
												tabindex='-1'> ";
												echo "$sistem";
														$data=mysql_query('select * from sistem_angsuran'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_sistem] ($row[deskripsi_sistem])</option>";
															}
												echo "
											</select>
										</div>
                                    </div>
									
									<div class='form-group'>
										<label class='control-label col-sm-4'>Sistem Angs. Jasa</label>
										<div class='col-sm-8'>
											<select id='sa_jasa'  name='sa_jasa' $disabled
												class='select form-control'
												tabindex='-1'> ";
												echo "$sa_jasa";
														$data=mysql_query('select * from sistem_angsuran'); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_sistem] ($row[deskripsi_sistem])</option>";
															}
												echo "
											</select>
										</div>
                                    </div>
									
									<div class='form-group'>
										<label class='control-label col-sm-4'>Jenis Produk Pinj.</label>
										<div class='col-sm-8'>
											<select id='jenis_pp'  name='jenis_pp' $disabled
												class='select form-control'
												tabindex='-1'> ";
												echo "<option value=$jpp[id]>$jpp[nama_jpp] ($jpp[deskripsi_jpp])</option>";
														$data=mysql_query("select * from jenis_produk_pinjaman Where
																	lokasi='0' AND kecuali NOT LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%' OR 
																	lokasi LIKE '%$_SESSION[kd_kab]-$_SESSION[lokasi],%'"); 
															while($row=mysql_fetch_array($data)){
															echo "<option value=$row[id]>$row[nama_jpp] ($row[deskripsi_jpp])</option>";
															}
												echo "
											</select>
										</div>
                                    </div>
									
                                    <div id='konfirmasi'></div>
									
									<input type='hidden' name='id_pinj' id='id_pinj' value='$idp'>
									<input type='hidden' name='id_kel' id='id_kel' value='$idk'>
                                    
									<button type='button' class='btn btn-primary pull-right mb-lg' id='SimpanProposal' $disabled><i class='fa fa-send'></i> $tombol Proposal Kelompok</button>
                                    
	</div>
</div>
				
</section>		
					
</div>
</div>
"; 

if ($rows<=0 or $rows>0 and $status=="L" or $rows>0 and $status=="A" ){
	
	echo "
	<div class='row'>
	<div class='col-sm-12'>
		<div id='DaftarPemanfaat'></div>
	</div>
	</div>
	";
	
}else if ($rows>0 and $status=="P" OR $rows>0 and $status=="V" OR $rows>0 and $status=="W"){
	

?>
<style>
<!--
.binder{
	background: url('images/binder.png') repeat-x;
	height:100px; 
	margin-top:-65px;
}
-->
</style>

<div class="row">
<div class="col-sm-12">
<section class="widget mt-n-sm" style="background-color:#dddeee;">
<div class="binder"></div>
                    <div class="widget-body clearfix">
					
						<div class="widget-top-overflow windget-padding-md clearfix bg-primary">
                            <span class="h5 text-white fw-bold"><i class="glyphicon glyphicon-user"></i> Daftar Pemanfaat
                            <span class="pull-right">
								<button <?php echo $disabled; ?> type="button" class="btn btn-sm bg-danger" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" value="<?php echo $idp; ?>" id="PilihPemanfaatProposal" title='Tambah Pemanfaat'><i class="fa fa-plus"></i></button>
								<button <?php echo $disabled; ?> type="button" class="btn btn-sm bg-warning" data-toggle="collapse" data-parent="#accordionImport" href="#collapseImport" value="<?php echo $r['id']; ?>" id="ImportPemanfaatProposal" title="Import dari Pemanfaat Sebelumnya"><i class="glyphicon glyphicon-arrow-down"></i></i></button>
								<button type="button" class="btn btn-sm bg-success" data-toggle="collapse" data-parent="#accordionCetakProposal" href="#collapseCetakProposal" id="FormCetakProposal" title="Cetak Proposal"><i class="glyphicon glyphicon-print"></i></button>
							</span>
							</span>
                        </div>
                        <div class="pull-right">
                        </div>
						
						<!--INPUT PEMANFAAT -->
						<div class="panel-group" id="accordion" data-toggle="collapse">
								<div class="panel panel-default">
									<div id="collapseOne" class="panel-collapse collapse">
										<div class="panel-body">
											<div id="PilihPemanfaat"></div>
										</div>
									</div>
								</div>
						</div>
						<!--IMPORT PEMANFAAT SEBELUMNYA -->
						<div class="panel-group" id="accordionImport" data-toggle="collapse">
														<div class="panel panel-default">
															<div id="collapseImport" class="panel-collapse collapse">
																<div class="panel-body">
																	<div id="ImportPemanfaat"></div>
																</div>
															</div>
														</div>
													</div> 
						<!--FROM CETAK PROPOSAL -->
						<div class="panel-group" id="accordionCetakProposal" data-toggle="collapse">
														<div class="panel panel-default">
															<div id="collapseCetakProposal" class="panel-collapse collapse">
																<div class="panel-body">
																	<legend>Cetak Proposal</legend>
																	<div id="CetakProposal"></div>
																</div>
															</div>
														</div>
													</div> 
													
						<div id="TampilPemanfaat"></div>
						
					
						
</div>
				
</section>		
					
</div>
</div>

<?php
}
?>	