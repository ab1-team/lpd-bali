<?php session_start(); 
$sts=$_SESSION['sts'];
?>

<script type="text/javascript">	
	$(function(){
			function pageLoad(){
				$('[data-toggle=tooltip]').tooltip();
			}
			pageLoad();
			SingApp.onPageLoad(pageLoad);
		});
		
	function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
	

	function deleteRow(ID) {
		var id_a	= ID;
	   var pilih = confirm('Anda akan hapus data '+id_a+ '?');
		if (pilih==true) {
			$.ajax({
				type	: "POST",
				url		: "modul/pinjaman/register/hapus_pemanfaat.php",
				data	: "id_a="+id_a,
				success	: function(data){
					$("#TampilPemanfaat").load('modul/pinjaman/register/tampil_pemanfaat.php');
				}
			});
		}
	}
	
	
</script>

 <div class="widget-body mb-xlg">
                <div class="table-responsive">
                    <table id="datatable-table" class="table table-hover">
                        <thead class="bg-gray text-white">
                        <tr>
                            <th width="5%" >No</th>
                            <th class="hidden-xs">Nama Calon Pemanfaat</th>
                            <th width="15%" class="hidden-xs">Proposal</th>
							<?php if($sts=="P"){ echo ""; }else if($sts=="V"){?>
							<th width="15%" class="hidden-xs">Hasil Verifikasi</th>
							<?php }else{?>
							<th width="15%" class="hidden-xs">Hasil Pendanaan</th>
							<?php } ?>
                            <th width="15%" class="no-sort">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
						ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);
						include "../../../inc/inc.koneksi.php";
						$view=mysql_query("select * from anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa where pa.nia=a.id AND id_pinkel='$_SESSION[id_pinkel]' order by pa.id");
								$no=0;
								while($row=mysql_fetch_array($view)){
								$no=$no+1;
								$id			=$row['id'];
								$proposal	=$row['proposal'];
								$alokasi	=$row['alokasi'];
								$sts		=$row['status'];
								if($sts=="P"){
									$isi_kolom	="";
									}else{
									$isi_kolom	="<td class='hidden-xs text-right'><span class='fw-semi-bold'>".number_format($alokasi)."</span><br>$row[catatan_verifikasi]</td>";
									}
						echo "
						<tr>
                            <td class='text-align-center fw-semi-bold text-white'><span class='circle bg-gray'>$no</span></td>
							<td class='hidden-xs'>$row[nik] <br> <b>".strtoupper($row['namadepan'])."</b> <span class='text-muted mt mb'>($row[alamat])</span>
							"?>
							
							<script type="text/javascript">	
							
							
								$(document).ready(function() {
					
								$("#AmnestyAnggota<?php echo $id; ?>").click(function(){
													var cari = $("#AmnestyAnggota<?php echo $id; ?>").val();
													cariformamnesty(cari);
												})
												function cariformamnesty(e){
													var cari = e;
													$.ajax({
														type	: "POST",
														url		: "modul/pinjaman/register/amnesty_anggota.php",
														data	: "cari="+cari,
														success	: function(data){
															$("#FormAmnesty<?php echo $id; ?>").html(data);
														}
													});
												}
												
								});
								
							</script>
							
							<div class="panel-group mb-n-0" id="accordion<?php echo $id; ?>" data-toggle="collapse">
									<div class="panel panel-default">
										<div id="collapse<?php echo $id; ?>" class="panel-collapse collapse">
											<legend>&nbsp;</legend>
												<h5 class="mb-n-sm fw-semi-bold">Penghapusan Pinjaman Anggota <span class="pull-right"><a data-toggle="collapse" data-parent="#accordion<?php echo $id; ?>" href="#collapse<?php echo $id; ?>"><span class="circle bg-danger text-white"><i class='fa fa-times'></i></span></a></span></h5>
											<div id="FormAmnesty<?php echo $id; ?>"></div>
										</div>
									</div>
								</div>
							<?php
							
							echo "
							
							</td>
							<td class='hidden-xs text-right'>".number_format($proposal)."</td>
							$isi_kolom
							";
						
						?>
							<td>		
						<div class="btn-group">
                                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" data-original-title="" title="">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right animated fadeInDown">
                                    <li><div class="text-align-center fw-semi-bold"><?php echo $row['namadepan'] ?></div></li>
                                    <li class="divider"></li>
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/PPPA.php?&rcp=<?php echo $row['nia'];?>&id_pinkel=<?php echo $row['id_pinkel'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class='glyphicon glyphicon-print'></i> Form Penilaian Kelayakan</a></li>
                                    <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/PPP.php?&rcp=<?php echo $row['nia'];?>&id_pinkel=<?php echo $row['id_pinkel'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class='glyphicon glyphicon-print'></i> Pernyataan Peminjam</a></li>
                                    <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/AW.php?&rcp=<?php echo $row['nia'];?>&id_pinkel=<?php echo $row['id_pinkel'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class='glyphicon glyphicon-print'></i> Surat Ahli Waris</a></li>
                                    <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/SPPJ.php?&rcp=<?php echo $row['nia'];?>&id_pinkel=<?php echo $row['id_pinkel'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class='glyphicon glyphicon-print'></i> Pernyataan Penjamin 1</a></li>
                                    <li class="divider"></li>
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/KWA.php?&rcp=<?php echo $row['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" ><i class='glyphicon glyphicon-print'></i> Kwitansi Pencairan</a></li>
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/KAA.php?&rcp=<?php echo $row['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" ><i class='glyphicon glyphicon-print'></i> Kartu Angsuran</a></li>
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/SPKA.php?&rcp=<?php echo $row['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class='glyphicon glyphicon-print'></i> Surat Perjanjian Kredit</a></li>
									<?php if($_SESSION['lokasi']=='176') { ?> 	
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/SPS.php?&rcp=<?php echo $row['id'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><i class='glyphicon glyphicon-print'></i> Surat Pernyataan Suami</a></li>
									<?php }?>
									<li class="divider"></li>
									<li><button <?php if($sts!="A"){ echo "disabled"; } ?> class="btn bg-white" type="button" data-toggle="collapse" data-parent="#accordion<?php echo $id; ?>" href="#collapse<?php echo $id; ?>" value="<?php echo $id; ?>" id="AmnestyAnggota<?php echo $id; ?>"><i class='fa fa-times'></i> Hapus Pinjaman <i>(Amnesty)</i></button></li>
                                </ul>
						</div>
						
						<?php
						if($sts=="P"){ 
							echo "
								<a href='javascript:deleteRow(\"{$row[id]}\")' data-toggle='tooltip' data-placement='top' title='Hapus Data $row[namadepan]'><span class='btn btn-danger'><i class='fa fa-times'></i></span></a>
							";
							
						} 
						
						$stt=mysql_fetch_array(mysql_query("SELECT * FROM status_pinjaman WHERE kd_status='$row[status]' "));
						if($row['status']=="L" and $alokasi<=0){
						echo "<span class='toggle badge bg-danger pull-right'>TL</span>";
						}else{
						echo "<span class='toggle badge bg-$stt[warna_status] pull-right'>$row[status]</span>";
						}
						?>
						
							</td>	
						</tr>
							
						
						<?php
						 $sumproposal=$sumproposal+$proposal;
						 $sumalokasi=$sumalokasi+$alokasi;
						 
						 }
						if($sts=="P"){ 
						echo "
						<tr>
							<td class='h4 text-align-center fw-semi-bold active' colspan='4'><br><br><span class='h5'>Terserap</span> Rp. ".number_format($sumproposal)." <span class='h5'>dari</span> Rp. ".number_format($_SESSION['proposal'])."<br><span class='h5 text-muted'>*Jika jumlah diatas tidak sesuai silahkan segera menghubungi kami via WA Technical Support</span><br>&nbsp;<br>&nbsp;</td>
                        </tr> ";
						}else{
						echo "
						<tr>
							<td class='active text-align-center h4' colspan='2'><br><br>Jumlah</td><td class='active text-align-right fw-semi-bold h4'><br><br>".number_format($sumproposal)."</td><td class='active text-align-right fw-semi-bold h4'><br><br>".number_format($sumalokasi)."<br><br><br><br></td><td class='active'>&nbsp;</td>
						</tr>
						<tr>
							<td class='active text-align-center' colspan='5'><span class='h5 text-muted'>*Jika jumlah diatas tidak sesuai silahkan segera menghubungi kami via WA Technical Support</span><br>&nbsp;<br>&nbsp;</td>
						</tr>						";
						}
						 ?>
                        </tbody>
                    </table>
                </div>
            </div>