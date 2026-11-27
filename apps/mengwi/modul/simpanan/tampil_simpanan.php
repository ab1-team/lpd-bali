<?php session_start(); 
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";

			$sql=mysql_query("select * from jenis_simpanan js, simpanan_anggota_$_SESSION[kd_kab] sa where js.id=sa.jenis_simpanan AND sa.nia='$_SESSION[nia]' ");
			$lacak	= mysql_num_rows($sql);
				if ($lacak>0){
					include "../../inc/fungsi_simpanan_individu.php";
					$tgl_kondisi	=date('Y-m-d');
					echo '
					<div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr class="fw-semi-bold">
                                    <td>No.Rek/Jenis Simpanan</td>
                                    <td>Saldo</td>
                                    <td>Status</td>
                                </tr>
                                </thead>
								<tbody>';
				while($row=mysql_fetch_array($sql)) {
				    if($row['catatan_simpanan']==""){$nama_js = $row['nama_js'];}else{$nama_js = "$row[catatan_simpanan] (".tgl_ind($row['tgl_tutup']).")";}
						 if($row['jenis_simpanan']==1){$file="modul/simpanan/detail_simpanan_individu.php";}
					else if($row['jenis_simpanan']==2){$file="modul/simpanan_deposito/detail_simpanan_deposito.php";}
					$st=mysql_fetch_array(mysql_query("select * from status_simpanan where kd_status='$row[status]' "));
					$id = $row['id'];
					echo '
                                <tr class="fw-normal detail_click" href="#tabp2" style="cursor: pointer;" data-id="' . $id . '" data-toggle="tab" >
                                    <td>'.$row['nomor_rekening'].' '.($nama_js).'</td>
                                    <td>'.number_format(saldosimpananb("$tgl_kondisi-$row[id]")).'</td>
                                    <td><span class="badge bg-'.$st['warna_status'].' text-white">'.$st['nama_status'].'</span></td>
                                </tr>
								';
				 ?>
				<script type="text/javascript">
					
				$(document).ready(function() {
				    
				    $('.detail_click').click(function() {
				        var id = $(this).attr('data-id')
				        DetailProposal(id)
				    })
				    
				    function DetailProposal(ID){
                		var ids = ID;
                		$.ajax({
                			type	: "POST",
                			url		: "modul/simpanan/detail_simpanan_anggota.php",
                			data	: "ids="+ids,			  
                			success	: function(data){
                				$('#tabp2').html(data);
                				
                			}
                		});
                		
                	}
							
				// 		$("#DetailSimpananIndividu<?php echo $row['id'];?>").click(function() {
				// 			var ids		= <?php echo $row['id'];?>
									
				// 			$.ajax({
				// 				type: "POST",
				// 				url: "<?php echo $file;?>",
				// 				data: 	"ids="+ids,
										
				// 				success: function(data) {
				// 					$("#TampilDetailSimpanan").html(data);
				// 				}
				// 			});

				// 		});	
						
					});
				</script>
				
				<?php
				
				}
					echo '
								<tr><td colspan="5"><i>* Cek data simpanan untuk detail</i></td></tr>
                                </tbody>
							</table>
                        </div>
					';
				
			}else{
				echo "<p class='text-danger'><br>YBS Tidak memiliki simpanan</p>";
			}
			
			
			?>

						<div class="modal fade" id="myModalDetailSimpananIndividu" tabindex="" role="dialog" aria-labelledby="LabelDetailSimpananIndividu" aria-hidden="true">
                            <div class="modal-backdrop">
                                <div id="TampilDetailSimpanan"></div>
                            </div>
                        </div>	