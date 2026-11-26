<?php session_start(); 
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";

			$sqla=mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] where nia='$_SESSION[nia]' ");
			$lacak	= mysql_num_rows($sqla);
				if ($lacak>0){
					include "../../../inc/fungsi_pinjaman_individu.php";
					$tgl_kondisi	=date('Y-m-d');
					echo '
					<div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr class="fw-semi-bold">
                                    <td>L-ID</td>
                                    <td>Tanggal</td>
                                    <td>Alokasi</td>
                                    <td>Saldo</td>
                                    <td>Status</td>
                                </tr>
                                </thead>
								<tbody>';
				while($row=mysql_fetch_array($sqla)) {
					$st=mysql_fetch_array(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] pa, status_pinjaman s where s.kd_status=pa.status AND s.kd_status='$row[status]' "));
					$tg="$st[kolom]";
					$tgl=$row["$st[kolom]"];
					echo '
                                
                                <tr class="fw-normal" style="cursor: pointer;" href="" data-toggle="modal" data-target="#myModalDetailProposalIndividu" id="DetailProposalIndividu'.$row['id'].'">
                                    <td>'.$row['id'].'</td>
                                    <td>'.tgl_ind(substr($tgl,0,10)).'</td>
                                    <td>'.number_format($row['alokasi']).'</td>
                                    <td>'.number_format(saldopinjaman("$tgl_kondisi-$row[id]")).'</td>
                                    <td><span class="badge bg-'.$st['warna_status'].' text-white">'.$st['nama_status'].'</span></td>
                                </tr>
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
					echo '
								<tr><td colspan="5"><i>* Klik untuk detail</i></td></tr>
                                </tbody>
							</table>
                        </div>
					';
				
			}else{
				echo "<p class='text-danger'><br>YBS Tidak memiliki pinjaman</p>";
			}
			
			
			?>

			
<div class="modal fade" id="myModalDetailProposalIndividu" tabindex="" role="dialog" aria-labelledby="LabelDetailProposalIndividu" aria-hidden="true">
	 <div class="modal-backdrop">
		<div class="modal-content">
			<div id="TampilDetailProposalIndividu"></div>
		</div>
	</div>
</div>		