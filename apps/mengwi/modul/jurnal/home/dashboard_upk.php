<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_keuangan.php";
include "inc/fungsi_pinjaman.php";


$now	=date('Y-m')."-31";
$akt	=aktiva("$now");
$ak1	=substr($akt,0,-6);
$ak2	=substr($akt,-6);

$ma=modalawal("$now");
$ap=asetproduktif("$now");
$pd=$ap-$ma;
$pr=@(floor($pd/$ma*100));


if($_SESSION['id']!="4726"){
	
?>

<script type="text/javascript">	


		
function MM_openBrWindow(theURL,winName,features) { //membuka window untuk print
				window.open(theURL,winName,features);
				}
	
</script>
						
    <div class="row hidden-print">
		
		<?php //NOTIVIKASI INVOICE
						$inv=mysql_query("select * from admin_invoice WHERE status='UNPAID' AND lokasi='$_SESSION[lokasi]' "); 
							$jumpaid=mysql_num_rows($inv);
								if($jumpaid>0 AND $_SESSION['level']=="1"){
									$kc=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan where id='$_SESSION[lokasi]' "));
									
									$rows=mysql_fetch_array(mysql_query("select * from admin_invoice WHERE status='UNPAID' AND lokasi='$_SESSION[lokasi]' "));
									
									//INVOICE
									function sumBayar($idv) { //Jumlah Bayar

												$table_transaksi	="admin_transaksi";
												$row=mysql_fetch_array(mysql_query("select *, sum(jumlah) as sumjumlah FROM $table_transaksi WHERE idv='$idv' ")); //Deklarasi Jumlah Pembayaran Sebelumnya
												$sumBayar		=$row['sumjumlah'];

												return $sumBayar;
									}


									function sumTagihan($idv) { //Jumlah Tagihan

												$tag=mysql_fetch_array(mysql_query("select * FROM admin_invoice WHERE idv='$idv' ")); //Deklarasi Jumlah Tagihan
												$tagihan	=$tag['jumlah'];

												return $tagihan;
									}

									function sumSaldo($idv) { //Jumlah Saldo

												$sumBayar	=sumBayar($idv);
												$tagihan	=sumTagihan($idv);
												
												$saldo=$tagihan-$sumBayar;

												return $saldo;
									}

									while($row=mysql_fetch_array($inv)) {
										$Saldo=sumSaldo($row['idv']);
										
										$sumSaldo=$sumSaldo+$Saldo;
									}
									
									
									
									?>
								<div class="alert alert-danger alert-sm">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<span class="fw-semi-bold"><?php echo "$kc[nama_lembaga_sort] $kc[nama_kec]"; ?></span>  yang Terhormat, Anda memiliki <?php echo $jumpaid; ?> tagihan 
									yang belum dibayar senilai Rp. <?php echo number_format($sumSaldo); ?>, silakan segera lakukan pembayaran.
									<a class="btn btn-default btn-xs pull-right mr" href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/<?php echo hash("sha512",'bismillahirohmanirrokhim'); ?>/INVOICE.php?idv=<?php echo $rows['idv'];?>' )" >Cetak</a>
									<a class="btn btn-danger btn-xs pull-right mr-xs" href="?p=invoice">Lihat Invoice</a>
								</div>
								
								<?php	
								} //END NOTIVIKASI INVOICE
								?>
		

		
		<div class="row  mt-n-md">	
            <div class="col-md-3 col-sm-6">
                <section class="widget">
                    <div class="widget-body mb-lg">
                        <div class="widget-top-overflow windget-padding-md clearfix mb-lg bg-success">
                            <span class="h5 text-white"><i class="glyphicon glyphicon-user"></i> DEBITUR</span>
                        </div>
                        
                        <div class="row mt">
                            <ul class="map-controls nav nav-pills nav-justified bg-primary-light" style="border: 1px solid #5d8fc2;">
                                <li><a href="" onclick="MM_openBrWindow('modul/simpanan/cs/s_CetakSimpanan.php?&js=2')"> <div class="h1 no-margin fw-normal text-align-center"><?php echo $anggota_i;?></div> <span class="badge bg-primary">Anggota</span></a></li>
                                <li><a href="" onclick="MM_openBrWindow('modul/simpanan/cs/s_CetakSimpanan.php?&js=1')"> <div class="h1 no-margin fw-normal text-align-center"><?php echo $umum_i;?></div> <span class="badge bg-primary">Umum</span></a></li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
			
			<div class="col-md-3 col-sm-6">
                <section class="widget">
                    <div class="widget-body mb-lg">
                        <div class="widget-top-overflow windget-padding-md clearfix mb-lg bg-primary">
                            <span class="h5 text-white"><i class="glyphicon glyphicon-th-list"></i> KREDITUR</span>
                        </div>
                        
                        <div class="row mt">
                            <ul class="map-controls nav nav-pills nav-justified bg-primary-light" style="border: 1px solid #5d8fc2;">
                                <li><a href="" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=P')"> <div class="h1 no-margin fw-normal text-align-center"><?php echo $jum_prop_i;?></div> <span class="badge bg-primary">P</span></a></li>
                                <li><a href="" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=W')"> <div class="h1 no-margin fw-normal text-align-center"><?php echo $jum_wait_i;?></div> <span class="badge bg-primary">W</span></a></li>
                                <li><a href="" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=A')"> <div class="h1 no-margin fw-normal text-align-center"><?php echo $jum_akt_i;?></div> <span class="badge bg-primary">A</span></a></li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
			
			
			<?php
			$tgl=date('d');
			$data=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE 
			d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND  k.lokasi='$_SESSION[lokasi]' AND substring(tgl_cair,9,2)='$tgl' OR
			d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND  k.lokasi='$_SESSION[lokasi]' AND d.jadwal_angsuran_desa='$tgl'
			ORDER BY pk.tgl_cair ASC ");
// 			$hitung= mysql_num_rows($data);
			?>

			<?php
			$tgl_i=date('d');
			$data_i=mysql_query("SELECT * FROM desa d, anggota_$_SESSION[kd_kab] a, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE d.id=a.desa AND a.id=pa.nia AND pa.status='A' AND pa.jenis_pinjaman='I' AND  a.lokasi='$_SESSION[lokasi]' AND substring(tgl_cair,9,2)='$tgl_i' ORDER BY pa.tgl_cair 	 ASC ");
			$hitung_i= mysql_num_rows($data_i);
			?>
		
			<div class="col-md-3 col-sm-6">
                <section class="widget">
                    <div class="widget-body mb-lg">
                        <div class="widget-top-overflow windget-padding-md clearfix mb-lg bg-danger">
                            <span class="h5 text-white"><i class="glyphicon glyphicon-tags"></i> &nbsp;JATUH TEMPO
								<!--<ul class="tags text-white pull-right">-->
								<!--	<li><a href="" data-toggle="modal" data-target="#myModalSMS"><span class="fs-mini">S M S</span></a></li>-->
								<!--</ul>-->
							</span>
                        </div>
                        
                        <div class="row mt">
                            <ul class="map-controls nav nav-pills nav-justified bg-danger-light" style="border: 1px solid #dd5826;">
                                 <li><a href="" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LTA.php')"> <div class="h1 no-margin fw-normal text-align-center"><?php echo $hitung+$hitung_i;?></div> <span class="badge bg-danger">TAGIHAN</span></a></li>
                                <li><a href="" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LTU.php')"> <div class="h1 no-margin fw-thin text-align-center text-danger"><i class="fa fa-warning"></i> </div> <span class="badge bg-danger">MENUNGGAK</span></a></li>
								<li><a href="" onclick="MM_openBrWindow('modul/pinjaman/cp/i_RPY.php')"> <div class="h1 no-margin fw-thin text-align-center text-danger"><i class="fa fa-bell-o"></i></div> <span class="badge bg-danger">REMINDER</span></a></li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
			
			<div class="col-md-3 col-sm-6">
                <section class="widget">
                    <div class="widget-body mb-lg">
                        <div class="widget-top-overflow windget-padding-md clearfix mb-lg bg-info">
                            <span class="h5 text-white"><i class="glyphicon glyphicon-bookmark"></i> TOTAL ASET
							<ul class="tags text-white pull-right">
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/PM.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><span class="fs-mini">Modal</span></a></li>
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/RL.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><span class="fs-mini">L - R</span></a></li>
								</ul>
							</span>
                        </div>
                        
                        <div class="row mt">
                            <ul class="map-controls nav nav-pills nav-justified bg-info-light" style="border: 1px solid #5dc4bf;">
                                <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/NC.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><div class="h1 no-margin fw-normal text-align-center text-info">&nbsp;<span id="geo-locations-number"><?php echo $ak1;?></span> <span class="h4" id="geo-locations-number"><?php echo $ak2;?></span></div><span class="badge bg-info">DETAIL NERACA</span></a></li>
                                <li><a href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/p/NC.php?idf=&y=<?php echo date('Y');?>&m=<?php echo date('m');?>&d=','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><div class="h1 ml-n-lg mr-n-lg mt-0 mb fw-normal text-align-center"><span class="h3 text-success"><i class="fa fa-sort-up"></i></span><?php echo $pr;?><span class="h4">%</span></div></a></li>
							</ul>
                        </div>
                    </div>
                </section>
            </div>
		</div>
		
		<div class="row hidden">
			<div class="col-md-12 col-lg-12">
				<section class="widget no-padding mt-n-md mb">
					<div class="row no-margin">
                        <div class="col-xs-1 bg-danger btlr bblr text-align-center">
                            <h5 class="text-white display-inline-block fw-normal"><?php echo strtoupper(date('D'));?></h5>
                        </div>
						<div class="col-xs-11 opacity-60">
							<div class="live-tile" data-mode="carousel" data-speed="750" data-delay="5000" data-height="30">
								<?php 
								$data=mysql_query("select * from sms_backup WHERE CreatorID='$_SESSION[lokasi]' order by id desc LIMIT 10");
									$sms=mysql_num_rows($data);
									if($sms<=0) {
										echo "SMS Gateway is running...";
									}else{
									while($rows=mysql_fetch_array($data)){
										
									 echo '
									<div>
										<h5 class="display-inline-block fw-normal"><strong>'.$rows['DestinationNumber'].'</strong> <i class="fa fa-play"></i> '.substr($rows['TextDecoded'],0,130).'</h5>
									</div>
									'; 
									}
									}
									?>
								
							</div>
						</div>
					</div>
                </section>
            </div>
		</div>
	
<div class="row">
            <div class="col-md-12 col-lg-12">
               <div id="pendapatandanbiaya" style="min-width: 310px; height: 360px; margin: 0 auto"></div> 
			</div>
			
		</div>
		
</div>

<!-- MODAL SMS TAGIHAN -->
						<div class="modal fade" id="myModalSMS" tabindex="" role="dialog" aria-labelledby="myModalLabel19" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
								<form method="POST" target='_blank' action='modul/pinjaman/cp/SMSTag.php'>
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title text-align-center fw-bold mt" id="myModalLabel19"><i class="glyphicon glyphicon-envelope"></i> SMS Tagihan</h4>
                                    </div>
                                    <div class="modal-body">
										<div id="validation-form" class="form-horizontal form-label-left" method="post"
											  data-parsley-priority-enabled="false"
											  novalidate="novalidate">
											<fieldset>
											
												<div class="form-group">
													<label class="control-label col-md-8 text-muted fs-mini">Kirim SMS Tagihan berdasarkan tanggal jatuh tempo angsuran sesuai dengan yang anda inginkan mendasar pada SOP yang berlaku.<br><br>
													Pastikan nomor HP kelompok penerima SMS telah terisi dan valid (dapat menerima SMS).<br><br>
													Mohon untuk disampaikan kepada penerima SMS untuk tidak membalas SMS ke nomor pengirim.<br><br>
													SMS ini tidak dikenakan pulsa, baik pengirim maupun penerima, gunakanlah secara bijak.</label>
													<div class="col-md-4 text-align-center">Tanggal Jatuh Tempo :<br><input name="tgl_tagihan" id="datetimepicker1" type="text" value="<?php echo date('Y-m-d');?>" data-date-format="YYYY-MM-DD" class="form-control input-lg" /><br><br>
														<button type="submit" name="perintah" value="preview" class="badge bg-danger" role="button">
															<span class="fs-sm"><i class="glyphicon glyphicon-print"></i> Preview Dulu Aja</span>
														</button>
															<br><br>
														<button type="submit" name="perintah" value="terkirim" class="badge bg-success" role="button">
															<span class="fs-sm"><i class="glyphicon glyphicon-envelope"></i> Cek SMS Terkirim</span>
														</button>
													</div>
												</div>
											
											</fieldset>
										</div>
									</div>
									<div class="modal-footer text-align-center bg-primary">
										<button type="submit" name="perintah" value="kirim" class="btn btn-primary btn-block" >KIRIMKAN SMS TAGIHAN UNTUK JATUH TEMPO DIATAS</button>
									</div>
								</form>
                                </div>
                            </div>
                        </div>
						
<!-- MODAL Anggota -->
						<div class="modal fade" id="myModalAnggota" tabindex="" role="dialog" aria-labelledby="LabelProposal" aria-hidden="true">
                            <div class="modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 class="modal-title text-align-center fw-bold" id="LabelProposal">Simpanan Anggota</h5>
                                    </div>
                                    <div class="modal-body">
										<div id="validation-form" class="form-horizontal form-label-left" method="post"
											  data-parsley-priority-enabled="false"
											  novalidate="novalidate">
											<fieldset>
												<div class="col-md-6 text-align-center">
													<button href="javascript:;" onclick="MM_openBrWindow('modul/simpanan/cs/s_CetakSimpanan.php?&js=2')" target="_blank" class="btn btn-default width-100 mb-xs text-primary" role="button">
														<h1><?php echo $anggota_i;?></h1>
														<span class="fs-sm"><i class="glyphicon glyphicon-user"></i> INDIVIDU</span>
													</button>
												</div>
											</fieldset>
										</div>
									</div>
								
                                </div>
                            </div>
                        </div>
                        
<!-- MODAL Umum -->
						<div class="modal fade" id="myModalUmum" tabindex="" role="dialog" aria-labelledby="LabelProposal" aria-hidden="true">
                            <div class="modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 class="modal-title text-align-center fw-bold" id="LabelProposal">Simpanan Umum</h5>
                                    </div>
                                    <div class="modal-body">
										<div id="validation-form" class="form-horizontal form-label-left" method="post"
											  data-parsley-priority-enabled="false"
											  novalidate="novalidate">
											<fieldset>
												<div class="col-md-6 text-align-center">
													<button href="javascript:;" onclick="MM_openBrWindow('modul/simpanan/cs/s_CetakSimpanan.php?&js=1')" target="_blank" class="btn btn-default width-100 mb-xs text-primary" role="button">
														<h1><?php echo $umum_i;?></h1>
														<span class="fs-sm"><i class="glyphicon glyphicon-user"></i> INDIVIDU</span>
													</button>
												</div>
											</fieldset>
										</div>
									</div>
								
                                </div>
                            </div>
                        </div>
                        
<!-- MODAL PROPOSAL -->
						<div class="modal fade" id="myModalProposal" tabindex="" role="dialog" aria-labelledby="LabelProposal" aria-hidden="true">
                            <div class="modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 class="modal-title text-align-center fw-bold" id="LabelProposal">Register Proposal</h5>
                                    </div>
                                    <div class="modal-body">
										<div id="validation-form" class="form-horizontal form-label-left" method="post"
											  data-parsley-priority-enabled="false"
											  novalidate="novalidate">
											<fieldset>
												<!--<div class="col-md-6 text-align-center">-->
													<!--<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=P')" target="_blank" class="btn btn-default width-100 mb-xs text-primary" role="button">-->
													<!--	<h1><?php echo $jum_prop;?></h1>-->
													<!--	<span class="fs-sm"><i class="fa fa-users"></i> KELOMPOK</span>-->
													<!--</button>-->
												<!--</div>-->
												<div class="col-md-6 text-align-center">
													<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=P')" target="_blank" class="btn btn-default width-100 mb-xs text-primary" role="button">
														<h1><?php echo $jum_prop_i;?></h1>
														<span class="fs-sm"><i class="glyphicon glyphicon-user"></i> INDIVIDU</span>
													</button>
												</div>
											</fieldset>
										</div>
									</div>
								
                                </div>
                            </div>
                        </div>
						
<!-- MODAL VERIFIED -->
						<div class="modal fade" id="myModalVerified" tabindex="" role="dialog" aria-labelledby="LabelVerified" aria-hidden="true">
                            <div class="modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 class="modal-title text-align-center fw-bold" id="LabelVerified">Verified</h5>
                                    </div>
                                    <div class="modal-body">
										<div id="validation-form" class="form-horizontal form-label-left" method="post"
											  data-parsley-priority-enabled="false"
											  novalidate="novalidate">
											<fieldset>
												<!--<div class="col-md-6 text-align-center">-->
												<!--	<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=V')" target="_blank" class="btn btn-default width-100 mb-xs text-primary" role="button">-->
												<!--		<h1><?php echo $jum_ver;?></h1>-->
												<!--		<span class="fs-sm"><i class="fa fa-users"></i> KELOMPOK</span>-->
												<!--	</button>-->
												<!--</div>-->
												<div class="col-md-6 text-align-center">
													<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=V')" target="_blank" class="btn btn-default width-100 mb-xs text-primary" role="button">
														<h1><?php echo $jum_ver_i;?></h1>
														<span class="fs-sm"><i class="glyphicon glyphicon-user"></i> INDIVIDU</span>
													</button>
												</div>
											</fieldset>
										</div>
									</div>
								
                                </div>
                            </div>
                        </div>

<!-- MODAL MENUNGGAK -->
						<div class="modal fade" id="myModalMenunggak" tabindex="" role="dialog" aria-labelledby="LabelMenunggak" aria-hidden="true">
                            <div class="modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 class="modal-title text-align-center fw-bold text-white" id="LabelProposal">MENUNGGAK</h5>
                                    </div>
                                    <div class="modal-body">
										<div id="validation-form" class="form-horizontal form-label-left" method="post"
											  data-parsley-priority-enabled="false"
											  novalidate="novalidate">
											<fieldset>
												<!--<div class="col-md-6 text-align-center">-->
												<!--	<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LTU.php')" target="_blank" class="btn btn-default width-100 mb-xs text-danger" role="button">-->
												<!--		<h1><i class="fa fa-users"></i></h1>-->
												<!--		<span class="fs-sm"> KELOMPOK</span>-->
												<!--	</button>-->
												<!--</div>-->
												<div class="col-md-6 text-align-center">
													<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LTU.php')" target="_blank" class="btn btn-default width-100 mb-xs text-danger" role="button">
														<h1><i class="glyphicon glyphicon-user"></i></h1>
														<span class="fs-sm"> INDIVIDU</span>
													</button>
												</div>
											</fieldset>
										</div>
									</div>
								
                                </div>
                            </div>
                        </div>

<!-- MODAL REMINDER -->
						<div class="modal fade" id="myModalReminder" tabindex="" role="dialog" aria-labelledby="LabelReminder" aria-hidden="true">
                            <div class="modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 class="modal-title text-align-center fw-bold text-white" id="LabelProposal">REMINDER</h5>
                                    </div>
                                    <div class="modal-body">
										<div id="validation-form" class="form-horizontal form-label-left" method="post"
											  data-parsley-priority-enabled="false"
											  novalidate="novalidate">
											<fieldset>
												<!--<div class="col-md-6 text-align-center">-->
												<!--	<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/RPY.php')" target="_blank" class="btn btn-default width-100 mb-xs text-danger" role="button">-->
												<!--		<h1><i class="fa fa-users"></i></h1>-->
												<!--		<span class="fs-sm"> KELOMPOK</span>-->
												<!--	</button>-->
												<!--</div>-->
												<div class="col-md-6 text-align-center">
													<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_RPY.php')" target="_blank" class="btn btn-default width-100 mb-xs text-danger" role="button">
														<h1><i class="glyphicon glyphicon-user"></i></h1>
														<span class="fs-sm"> INDIVIDU</span>
													</button>
												</div>
											</fieldset>
										</div>
									</div>
								
                                </div>
                            </div>
                        </div>
                        
<!-- MODAL TAGIHAN -->
						<div class="modal fade" id="myModalTagihan" tabindex="" role="dialog" aria-labelledby="LabelTagihan" aria-hidden="true">
                            <div class="modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 class="modal-title text-align-center fw-bold text-white" id="LabelProposal">TAGIHAN</h5>
                                    </div>
                                    <div class="modal-body">
										<div id="validation-form" class="form-horizontal form-label-left" method="post"
											  data-parsley-priority-enabled="false"
											  novalidate="novalidate">
											<fieldset>
												<!--<div class="col-md-6 text-align-center">-->
												<!--	<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LTA.php')" target="_blank" class="btn btn-default width-100 mb-xs text-danger" role="button">-->
												<!--		<h1><?php echo $hitung;?></h1>-->
												<!--		<span class="fs-sm"><i class="fa fa-users"></i> KELOMPOK</span>-->
												<!--	</button>-->
												<!--</div>-->
												<div class="col-md-6 text-align-center">
													<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LTA.php')" target="_blank" class="btn btn-default width-100 mb-xs text-danger" role="button">
														<h1><?php echo mysql_num_rows($data_i);?></h1>
														<span class="fs-sm"><i class="glyphicon glyphicon-user"></i> INDIVIDU</span>
													</button>
												</div>
											</fieldset>
										</div>
									</div>
								
                                </div>
                            </div>
                        </div>
                        
<!-- MODAL VERIFIED -->
						<div class="modal fade" id="myModalWaiting" tabindex="" role="dialog" aria-labelledby="LabelWaiting" aria-hidden="true">
                            <div class="modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 class="modal-title text-align-center fw-bold" id="LabelWaiting">Waiting List</h5>
                                    </div>
                                    <div class="modal-body">
										<div id="validation-form" class="form-horizontal form-label-left" method="post"
											  data-parsley-priority-enabled="false"
											  novalidate="novalidate">
											<fieldset>
												<!--<div class="col-md-6 text-align-center">-->
												<!--	<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=W')" target="_blank" class="btn btn-default width-100 mb-xs text-primary" role="button">-->
												<!--		<h1><?php echo $jum_wait;?></h1>-->
												<!--		<span class="fs-sm"><i class="fa fa-users"></i> KELOMPOK</span>-->
												<!--	</button>-->
												<!--</div>-->
												<div class="col-md-6 text-align-center">
													<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=W')" target="_blank" class="btn btn-default width-100 mb-xs text-primary" role="button">
														<h1><?php echo $jum_wait_i;?></h1>
														<span class="fs-sm"><i class="glyphicon glyphicon-user"></i> INDIVIDU</span>
													</button>
												</div>
											</fieldset>
										</div>
									</div>
								
                                </div>
                            </div>
                        </div>
						
<!-- MODAL VERIFIED -->
						<div class="modal fade" id="myModalActive" tabindex="" role="dialog" aria-labelledby="LabelDana" aria-hidden="true">
                            <div class="modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 class="modal-title text-align-center fw-bold" id="LabelDana">Pinjaman Aktif</h5>
                                    </div>
                                    <div class="modal-body">
										<div id="validation-form" class="form-horizontal form-label-left" method="post"
											  data-parsley-priority-enabled="false"
											  novalidate="novalidate">
											<fieldset>
												<!--<div class="col-md-6 text-align-center">-->
												<!--	<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=D')" target="_blank" class="btn btn-default width-100 mb-xs text-primary" role="button">-->
												<!--		<h1><?php echo $jum_dana;?></h1>-->
												<!--		<span class="fs-sm"><i class="fa fa-users"></i> KELOMPOK</span>-->
												<!--	</button>-->
												<!--</div>-->
												<div class="col-md-6 text-align-center">
													<button href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/i_LP.php?&sT=A')" target="_blank" class="btn btn-default width-100 mb-xs text-primary" role="button">
														<h1><?php echo $jum_akt_i;?></h1>
														<span class="fs-sm"><i class="glyphicon glyphicon-user"></i> INDIVIDU</span>
													</button>
												</div>
											</fieldset>
										</div>
									</div>
								
                                </div>
                            </div>
                        </div>

<?php
		include "user.php"; }
?>