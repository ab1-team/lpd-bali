<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";
include "../../inc/fungsi_keuangan.php";
$table_rekening		="rekening_".$_SESSION['lokasi'];

$tahun_anggaran		="$_SESSION[tahunanggaran]";
?>

<script type="text/javascript">

	function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
		window.open(theURL,winName,features);
			}
			
	$("#ControlRP").load('modul/e_bud/control_rp.php');
	$("#ControlRP1").load('modul/e_bud/control_rp.php');
	$("#ControlRB").load('modul/e_bud/control_rb.php');
	$("#ControlRB1").load('modul/e_bud/control_rb.php');
	$("#ControlSP").load('modul/e_bud/control_sp.php');
											
</script>
 
 
<legend class="h4"><strong> Step 2 :</strong>  Input/Edit Data E-Budgeting <?php echo $tahun_anggaran;?>
	<span class="pull-right">
		<a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/pdf/EBR.php?y=<?php echo $tahun_anggaran;?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" type="button" class="label label-danger" ><i class="glyphicon glyphicon-print text-white"></i> Cetak E-Budgeting <?php echo $tahun_anggaran;?></a>
		<a href="modul/pelaporan/pdf/EB.php?y=<?php echo $tahun_anggaran;?>" target="_blank" type="button" class="label label-success" ><i class="glyphicon glyphicon-print text-white"></i> Cetak Realisasi TA <?php echo $tahun_anggaran;?></a>
	</span>
</legend>
<div class="row">
	<div class="col-md-6">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="bg-primary text-white">
					<tr>
						<th>Rencana Pendapatan</th>
					</tr>
				</thead>
				<tbody>
																		
				<?php
				$view=mysql_query("select * from jenis_akun WHERE posisi='4' ORDER by id ASC ");
					while($row=mysql_fetch_array($view)){
				$data=mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] WHERE id_akun='$row[id]' ORDER by kd_rekening ASC ");
					echo "
					<tr>
						<td><strong>$row[nama_akun]</strong><br><br> ";
						$no=0;
							while($r=mysql_fetch_array($data)){
								$no=$no+1;
								$urut="$r[kd_rekening]$no";
								$s=mysql_fetch_array(mysql_query("SELECT ra_$tahun_anggaran as ra FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$r[kd_rekening]' "));
									$angkarencana=$s['ra'];
									
									$kd_rekening=$r['kd_rekening'];
																							
							echo	"$r[kd_rekening]. $r[nama_rekening] <span class='pull-right'>
										<input type='hidden' id='tahun_anggaran$urut' name='tahun_anggaran$urut' value='$tahun_anggaran' >
										<input type='hidden' id='kd_rekening$urut' name='kd_rekening$urut' value='$r[kd_rekening]' >
										<input type='text' id='baris$urut' name='baris$urut'  class='form-control' value='$angkarencana' required='required' autocomplete='off' placeholder='$r[nama_rekening]' title='$r[nama_rekening]'></span><span id='SuksesEdit$urut'></span><br><br> ";
																						
							?>

							<script type="text/javascript">
							<![CDATA[
							var htmlobjek;
								$(document).ready(function() {
									
											$("#baris<?php echo $urut; ?>").keyup(function() {
												var tahun_anggaran = $('#tahun_anggaran<?php echo $urut; ?>').val();
												var kd_rekening = $('#kd_rekening<?php echo $urut; ?>').val();
												var baris = $('#baris<?php echo $urut; ?>').val();
												$.ajax({
													type: "POST",
													url: "modul/e_bud/update_kolom.php",
													data:"tahun_anggaran="+tahun_anggaran+
														"&kd_rekening="+kd_rekening+
														"&baris="+baris,
													
													success: function(data) {
														$("#SuksesEdit<?php echo $urut; ?>").load('modul/e_bud/sukses_edit.php');
														$("#ControlRP").load('modul/e_bud/control_rp.php');
														$("#ControlRP1").load('modul/e_bud/control_rp.php');
														$("#ControlSP").load('modul/e_bud/control_sp.php');
													}
												});
											});
											
		
										});
								]]>	
							 </script>
							
							
							<?php
							
							
							
							}
																					
						echo "
						</td>
					</tr> 
				";					
				}
				?>
																		
				</tbody>
				<tfoot class="bg-info-light">
					<tr>
						<th class="text-align-center bg-primary-light">Total Rencana Pendapatan<span class="pull-right"><div id="ControlRP"></div></span></th>
					</tr>
				</tfoot>
			</table>
			<br>
			<br>
			<br>
			<table class="table table-hover">
				<thead class="bg-primary text-white">
					<tr>
						<th>Rencana Rugi Laba</th>
					</tr>
				</thead>
				<tbody>
					<tr><td>Total Rencana Pendapatan<span class="pull-right"><div id="ControlRP1"></div></span></td></tr>
					<tr><td>Total Rencana Biaya<span class="pull-right"><div id="ControlRB1"></div></span></td></tr>
				</tbody>
				<tfoot class="bg-info-light">
					<tr>
						<th class="text-align-center bg-primary-light">Rencana Surplus<span class="pull-right"><div id="ControlSP"></div></span></th>
					</tr>
				</tfoot>
			</table>
				
				
		</div>									
	</div>

	<div class="col-md-6">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="bg-primary text-white">
					<tr>
						<th>Rencana Biaya</th>
					</tr>
				</thead>
				<tbody>
																		
				<?php
				$view=mysql_query("select * from jenis_akun WHERE posisi='5' ORDER by id ASC ");
					while($row=mysql_fetch_array($view)){
				$data=mysql_query("SELECT * FROM rekening_$_SESSION[lokasi] WHERE id_akun='$row[id]'  ORDER by kd_rekening ASC ");
					echo "
					<tr>
						<td><strong>$row[nama_akun]</strong><br><br> ";
						$no=0;
							while($r=mysql_fetch_array($data)){
								$no=$no+1;
								$urut="$r[kd_rekening]$no";
								$s=mysql_fetch_array(mysql_query("SELECT ra_$tahun_anggaran as ra FROM rekening_$_SESSION[lokasi] WHERE kd_rekening='$r[kd_rekening]' "));
									$angkarencana=$s['ra'];
									
									$kd_rekening=$r['kd_rekening'];
																							
							echo	"$r[kd_rekening]. $r[nama_rekening] <span class='pull-right'>
										<input type='hidden' id='tahun_anggaran$urut' name='tahun_anggaran$urut' value='$tahun_anggaran' >
										<input type='hidden' id='kd_rekening$urut' name='kd_rekening$urut' value='$r[kd_rekening]' >
										<input type='text' id='baris$urut' name='baris$urut'  class='form-control' value='$angkarencana' required='required' autocomplete='off' placeholder='$r[nama_rekening]' title='$r[nama_rekening]'></span><span id='SuksesEdit$urut'></span><br><br> ";
																						
							?>

							<script type="text/javascript">
							<![CDATA[
							var htmlobjek;
								$(document).ready(function() {
									
											$("#baris<?php echo $urut; ?>").keyup(function() {
												var tahun_anggaran = $('#tahun_anggaran<?php echo $urut; ?>').val();
												var kd_rekening = $('#kd_rekening<?php echo $urut; ?>').val();
												var baris = $('#baris<?php echo $urut; ?>').val();
												$.ajax({
													type: "POST",
													url: "modul/e_bud/update_kolom.php",
													data:"tahun_anggaran="+tahun_anggaran+
														"&kd_rekening="+kd_rekening+
														"&baris="+baris,
													
													success: function(data) {
														$("#SuksesEdit<?php echo $urut; ?>").load('modul/e_bud/sukses_edit.php');
														$("#ControlRB").load('modul/e_bud/control_rb.php');
														$("#ControlRB1").load('modul/e_bud/control_rb.php');
														$("#ControlSP").load('modul/e_bud/control_sp.php');
													}
												});
											});
											
		
										});
								]]>	
							 </script>
							
							
							<?php
							
							
							
							}
																					
						echo "
						</td>
					</tr> 
				";					
				}
				?>
																		
				</tbody>
				<tfoot class="bg-info-light">
					<tr>
						<th class="text-align-center bg-primary-light">Total Rencana Biaya<span class="pull-right"><div id="ControlRB"></div></span></th>
					</tr>
				</tfoot>
			</table>
		</div>
		
	</div>
	
</div>

