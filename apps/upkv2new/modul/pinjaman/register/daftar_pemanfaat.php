<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$pk=mysql_fetch_array(mysql_query("select * from pinjaman_kelompok_$_SESSION[kd_kab] WHERE id_kel='$_SESSION[id_kel]' AND user_id='$_SESSION[id]' order by id DESC limit 1"));
$maksid=$pk['id'];
$idp=$pk['id'];

$_SESSION['id_pinkel']=$pk['id'];
$_SESSION['sts']="P";
?>

<script type="text/javascript"> 
			
$(document).ready(function() {
	
$("#TampilPemanfaat").load('modul/pinjaman/register/tampil_pemanfaat.php');
$("#CetakProposal").load('modul/pinjaman/proposal/cetak_proposal.php');
				
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
					
					
$("#ImportPemanfaat").load('modul/pinjaman/register/import_pemanfaat.php');

					
			});
</script>

<style>
<!--
.binder{
	background: url('images/binder.png') repeat-x;
	height:100px; 
	margin-top:-65px;
}
-->
</style>

<section class="widget mt-n-sm" style="background-color:#dddeee;">
	<div class="binder"></div>
                    <div class="widget-body clearfix">
						<div class="widget-top-overflow windget-padding-md clearfix bg-primary">
                            <span class="h5 text-white fw-bold"><i class="glyphicon glyphicon-user"></i> Daftar Pemanfaat
                            <span class="pull-right">
								<button <?php echo $disabled; ?> type="button" class="btn btn-sm bg-danger" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" value="<?php echo $idp; ?>" id="PilihPemanfaatProposal" title='Tambah Pemanfaat'><i class="fa fa-plus"></i></button>
								<button <?php echo $disabled; ?> type="button" class="btn btn-sm bg-warning" data-toggle="collapse" data-parent="#accordionImport" href="#collapseImport" value="<?php echo $_SESSION['id_kel']; ?>" id="ImportPemanfaatProposal" title="Import dari Pemanfaat Sebelumnya"><i class="glyphicon glyphicon-arrow-down"></i></button>
								<button type="button" class="btn btn-sm bg-success" data-toggle="collapse" data-parent="#accordionCetakProposal" href="#collapseCetakProposal" id="FormCetakProposal" title="Cetak Proposal"><i class="glyphicon glyphicon-print"></i></button>
							</span>
							</span>
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