<?php session_start(); 
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";

$level		=$_SESSION['level'];
$jabatan	=$_SESSION['jabatan'];
$levjab		="$level.$jabatan";

if($levjab=="1.4") {$statuse="P";}elseif($levjab=="1.1") {$statuse="V1";}elseif($level=="3") {$statuse="V2";}elseif($levjab=="1.2") {$statuse="V3";}elseif($levjab=="1.3") {$statuse="W";}
	
			$sqla=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa where a.id=pa.nia AND pa.status='$statuse' AND pa.lokasi='$_SESSION[lokasi]' ");
			$lacak	= mysql_num_rows($sqla);
				if ($lacak>0){
					include "../../../inc/fungsi_pinjaman_individu.php";
					$tgl_kondisi	=date('Y-m-d');

				while($row=mysql_fetch_array($sqla)) {
					$st=mysql_fetch_array(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] pa, status_pinjaman s where s.kd_status=pa.status AND s.kd_status='$row[status]' "));
					
					$dpr=explode("#", $row["$st[kolom]"]);
					$data=$dpr[1];
					echo '
                                
								<a class="list-group-item" href="" data-toggle="modal" data-target="#myModalDetailProposalIndividu" id="DetailProposalIndividu'.$row['id'].'">
									<span class="thumb-sm pull-left mr">';
											$foto="../../../foto_anggota/$row[nia].png";
											if(file_exists($foto)){
												echo "<img  class='img-circle' alt='' src='foto_anggota/$row[nia].png'>";
											}else{
												echo "<img  class='img-circle' src='img/avatar.png'>";
											}
										echo '
										<i class="status status-bottom bg-'.$st['warna_status'].'"></i>
									</span>
									<h5 class="no-margin fw-semi-bold">'.strtoupper($row['namadepan']).'</h5>
									<span class="label label-'.$st['warna_status'].'">'.$st['nama_status'].'</span><span class="pull-right">'.number_format($data,0,",",".").'</span>
								</a>
								';
				 ?>
				<script type="text/javascript">
							$(document).ready(function() {
									
								$("#DetailProposalIndividu<?php echo $row['id'];?>").click(function() {
									var idpe		= <?php echo $row['id'];?>
											
									$.ajax({
										type:"POST",
										url	:"modul/pinjaman/proposal/detail_proposal_individu.php",
										data:"idp="+idpe,
												
										success: function(data) {
											$("#TampilDetailProposalIndividu").html(data);
										}
									});

								});	
								
							});
						</script>
				
				<?php
				
				}

				
			}else{
				echo "<p class='text-align-center text-muted'><br>Anda Tidak memiliki Tugas</p>";
			}
			
			
			?>

			
<div class="modal fade" id="myModalDetailProposalIndividu" tabindex="" role="dialog" aria-labelledby="LabelDetailProposalIndividu" aria-hidden="true">
	 <div class="modal-backdrop">
		<div class="modal-content">
			<div id="TampilDetailProposalIndividu"></div>
		</div>
	</div>
</div>		