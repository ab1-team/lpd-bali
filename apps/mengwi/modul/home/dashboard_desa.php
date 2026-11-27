<?php
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_pinjaman.php";

$_SESSION['jum_kel_desa']=$jum_kel_desa;
$_SESSION['jum_akt_desa']=$jum_akt_desa;
$_SESSION['jum_prop_desa']=$jum_prop_desa;
$_SESSION['jum_ver_desa']=$jum_ver_desa;
$_SESSION['jum_wait_desa']=$jum_wait_desa;

 $des=mysql_fetch_array(mysql_query("select * from kecamatan c, desa d where c.kd_kec=d.kd_kec AND d.id='$_SESSION[id]' ")); 
	$kd_kab=$des['kd_kab'];
	$nama_desa=$des['nama_desa'];
	
$table_kelompok="kelompok_$kd_kab";
$table_pk="pinjaman_kelompok_$kd_kab";
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
	
</script>
						
        <div class="row hidden-print">
            <div class="col-md-3 col-sm-6">
                <section class="widget bg-primary text-white">
                    <div class="widget-body clearfix">
                        <h5 class="mt-xs mb-sm">Groups Statistic</h5>
                        <div class="row">
                            <div class="col-xs-3">
                                <span class="widget-icon">
                                    <i class="fa fa-group"></i>
                                </span>
                            </div>
                            <div class="col-xs-9">
                                <div class="h2 no-margin fw-normal"><?php echo $jum_akt_desa;?><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LPD.php?&sT=A','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="badge bg-danger" data-toggle="tooltip" data-placement="top" title="Kelompok Aktif"><span class="fs-mini">Active</span></a></div>
								<span class="fs-mini"><?php echo $jum_kel_desa;?> registered</span>
                            </div>
                        </div>
                        <div class="row">
                            <a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LPD.php?&sT=P','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded" data-toggle="tooltip" data-placement="bottom" title="Proposal Menunggu Verifikasi"><b><?php echo $jum_prop_desa;?></b> <span class="fs-mini">Proposal</span></a>
                            <a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LPD.php?&sT=V','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded" data-toggle="tooltip" data-placement="bottom" title="Proposal Telah diVerifikasi"><b><?php echo $jum_ver_desa;?></b> <span class="fs-mini">Verified</span></a>
                            <a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LPD.php?&sT=W','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-primary btn-rounded" data-toggle="tooltip" data-placement="bottom" title="Daftar Tunggu Pencairan"><b><?php echo $jum_wait_desa;?></b> <span class="fs-mini">Waiting</span></a>
                        </div>
                    </div>
                </section>
            </div>
           
		   <?php
		$tgl=date('d');
		$tgl_kondisi=date('Y-m-d');
		$data=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.desa='$_SESSION[id]' AND substring(tgl_cair,9,2)='$tgl' ORDER BY pk.tgl_cair ASC ");
		$data2=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.desa='$_SESSION[id]' AND substring(tgl_cair,9,2)='$tgl' ORDER BY pk.tgl_cair ASC ");
		$data3=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.desa='$_SESSION[id]' AND substring(tgl_cair,9,2)='$tgl' ORDER BY pk.tgl_cair ASC ");
		?>	
            <div class="col-md-3 col-sm-6">
                <section class="widget bg-info text-white">
                    <div class="widget-body clearfix">
					<h5 class="mt-xs mb-sm"><i class="fa fa-bank"></i> Tagihan Hari Ini <span class="pull-right mt-n-sm"><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LTAd.php','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-info btn-rounded" ><b><?php echo mysql_num_rows($data);?></b> <span class="fs-mini">Group</span></a></span></h5>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="live-tile" data-mode="carousel" data-speed="750" data-delay="3000" data-height="57">
                                    <?php
									while($row=mysql_fetch_array($data)){
									$tgl_cair=$row['tgl_cair'];
									
										echo "
										<div class='text-align-center'>
											<h6 class='no-margin'>".tgl_indo($tgl_cair)."</h6>
											<p class='h3 no-margin fw-normal'>$row[nama_kelompok]</p>
											<p class='h6 no-margin fw-normal'>$row[nama_desa]</p>
										</div>
										";
										}
									?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7">
                                <h6 class="no-margin">Pokok</h6>
                                <div class="live-tile" data-mode="carousel" data-speed="750" data-delay="3000" data-height="25">
                                    <?php
									while($r=mysql_fetch_array($data2)){
									$id_pinj=$r['id'];
									$nunggakpokok		=nunggakpokok($tgl_kondisi."-".$id_pinj);
										echo "
										<div>
											<p class='value4'>".number_format($nunggakpokok)."</p>
										</div>
										";
										}
									?>
                                </div>
                            </div>
                            <div class="col-xs-5 text-align-right">
                                <h6 class="no-margin">Jasa</h6>
                                <div class="live-tile" data-mode="carousel" data-speed="750" data-delay="3000" data-height="26">
                                    <?php
								while($r=mysql_fetch_array($data3)){
									$id_pinj=$r['id'];
									$nunggakjasa		=nunggakjasa($tgl_kondisi."-".$id_pinj);
										echo "
										<div>
											<p class='value4'>".number_format($nunggakjasa)."</p>
										</div>
										";
										}
									?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
        </div>
			
		<?php
			$bln=date('Y-m');
			$table_transaksi	="transaksi_".$_SESSION['lokasi'];
			$tung1=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.desa='$_SESSION[id]' ORDER BY pk.id ASC ");			
			$tung2=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.desa='$_SESSION[id]' ORDER BY pk.id ASC ");			
			$tung3=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.desa='$_SESSION[id]' ORDER BY pk.id ASC ");			

			?>
				<div class="col-md-3 col-sm-6">
                <section class="widget bg-danger text-white">
                    <div class="widget-body clearfix">
					<h5 class="mt-xs mb-sm"><i class="fa fa-warning"></i> Tunggakan <span class="pull-right mt-n-sm"><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LTUd.php','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-danger btn-rounded" ><b><?php echo mysql_num_rows($tung1);?></b> <span class="fs-mini">Group</span></a></span></h5>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="live-tile" data-mode="carousel" data-speed="750" data-delay="3000" data-height="57">
                                    <?php
									while($row=mysql_fetch_array($tung1)){
										$idpinj			=$row['id'];
										$tgl_now		=date('Y-m-d');
										$nunggakpokok		=nunggakpokok("$tgl_now-$idpinj");
										$nunggakjasa		=nunggakjasa("$tgl_now-$idpinj");
										if ($nunggakpokok > 0 or $nunggakjasa > 0) {
										echo "
										<div class='text-align-center'>
											<p class='h3 no-margin fw-normal'>$row[nama_kelompok]</p>
											<p class='h6 no-margin fw-normal'>$row[nama_desa]</p>
										</div>
										";
									} }
									?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7">
                                <h6 class="no-margin">Pokok</h6>
                                <div class="live-tile" data-mode="carousel" data-speed="750" data-delay="3000" data-height="25">
                                    <?php
									while($row=mysql_fetch_array($tung2)){
										$idpinj			=$row['id'];
										$tgl_now		=date('Y-m-d');
										$nunggakpokok		=nunggakpokok("$tgl_now-$idpinj");
										$nunggakjasa		=nunggakjasa("$tgl_now-$idpinj");
										if ($nunggakpokok > 0 or $nunggakjasa > 0) {
										echo "
										<div>
											<p class='value4'>".number_format($nunggakpokok)."</p>
										</div>
										";
									} }
									?>
                                </div>
                            </div>
                            <div class="col-xs-5 text-align-right">
                                <h6 class="no-margin">Jasa</h6>
                                <div class="live-tile" data-mode="carousel" data-speed="750" data-delay="3000" data-height="26">
                                    <?php
								while($row=mysql_fetch_array($tung3)){
										
										$idpinj			=$row['id'];
										$tgl_now		=date('Y-m-d');
										$nunggakpokok		=nunggakpokok("$tgl_now-$idpinj");
										$nunggakjasa		=nunggakjasa("$tgl_now-$idpinj");
										if ($nunggakpokok > 0 or $nunggakjasa > 0) {
										echo "
										<div>
											<p class='value4'>".number_format($nunggakjasa)."</p>
										</div>
										";
								} }
									?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
        </div>
			
		<?php
		$dpk1=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='W' AND k.desa='$_SESSION[id]' ORDER BY pk.tgl_cair ASC ");
		$dpk2=mysql_query("SELECT * FROM $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND pk.status='W' AND k.desa='$_SESSION[id]' ORDER BY pk.tgl_cair ASC ");
		$dpk3=mysql_query("SELECT * FROM $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND pk.status='W' AND k.desa='$_SESSION[id]' ORDER BY pk.tgl_cair ASC ");
		?>	
            <div class="col-md-3 col-sm-6">
                <section class="widget bg-success text-white">
                    <div class="widget-body clearfix">
					<h5 class="mt-xs mb-sm"><i class="glyphicon glyphicon-calendar"></i> Agenda Pencairan <span class="pull-right mt-n-sm"><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LPD.php?&sT=W','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded" ><b><?php echo $jum_wait;?></b> <span class="fs-mini">Group</span></a></span></h5>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="live-tile" data-mode="carousel" data-speed="750" data-delay="3000" data-height="57">
                                    <?php
									if($jum_wait_desa>0) {
									
									while($pk1=mysql_fetch_array($dpk1)){
									$tgl_cair=$pk1['tgl_cair'];
									
									//MENCARI TANGGAL CAIR ITU HARI APA
									$query = "SELECT datediff('$tgl_cair', CURDATE()) as selisih";
									$hasil = mysql_query($query);
									$data  = mysql_fetch_array($hasil);

									$selisih = $data['selisih'];
									 
									$x  = mktime(0, 0, 0, date("m"), date("d")+$selisih, date("Y"));
									$namahari = date("l", $x);
									 
									if ($namahari == "Sunday") $namahari = "Minggu";
									else if ($namahari == "Monday") $namahari = "Senin";
									else if ($namahari == "Tuesday") $namahari = "Selasa";
									else if ($namahari == "Wednesday") $namahari = "Rabu";
									else if ($namahari == "Thursday") $namahari = "Kamis";
									else if ($namahari == "Friday") $namahari = "Jumat";
									else if ($namahari == "Saturday") $namahari = "Sabtu";
									
									// dipilih tanggal 1 Maret 2010 sebagai acuan  
									// hari pasaran tanggal 1 Maret 2010 adalah 'Pon'  
									$tgl1 = "2010-03-01";    

									// array urutan nama hari pasaran dimulai dari 'Pon'  
									$pasaran = array('Pon', 'Wage', 'Kliwon', 'Legi', 'Pahing');  
									  
									// proses mencari selisih hari antara kedua tanggal  
									$pecah1 = explode("-", $tgl1);  
									$date1 = $pecah1[2];  
									$month1 = $pecah1[1];  
									$year1 = $pecah1[0];  
									  
									$pecah2 = explode("-", $tgl_cair);  
									$date2 = $pecah2[2];  
									$month2 = $pecah2[1];  
									$year2 =  $pecah2[0];  
									  
									$jd1 = GregorianToJD($month1, $date1, $year1);  
									$jd2 = GregorianToJD($month2, $date2, $year2);  
									  
									$selisih = $jd2 - $jd1;  
									  
									// hitung modulo 5 dari selisih harinya  
									$mod = $selisih % 5;  
									
										echo "
										<div class='text-align-center'>
											<h6 class='no-margin'>$namahari $pasaran[$mod], ".tgl_indo($tgl_cair)."</h6>
											<p class='h3 no-margin fw-normal'>$pk1[nama_kelompok]</p>
											<p class='h6 no-margin fw-normal'>$pk1[nama_desa]</p>
										</div>
										";
										}
										
										}else{
										echo "
										<div class='text-align-center'>
											<p class='h4 no-margin fw-normal'>Tidak ada Agenda Pencairan</p>
										</div>
									";
									}
									?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7">
                                <h6 class="no-margin">Alokasi</h6>
                                <div class="live-tile" data-mode="carousel" data-speed="750" data-delay="3000" data-height="25">
                                    <?php
									while($pk2=mysql_fetch_array($dpk2)){
										echo "
										<div>
											<p class='value4'>".number_format($pk2[alokasi])."</p>
										</div>
										";
										}
									?>
                                </div>
                            </div>
                            <div class="col-xs-5 text-align-right">
                                <h6 class="no-margin">Pemanfaat</h6>
                                <div class="live-tile" data-mode="carousel" data-speed="750" data-delay="3000" data-height="26">
                                    <?php
									while($pk3=mysql_fetch_array($dpk3)){
									$jumpem=mysql_num_rows(mysql_query("select * from pinjaman_anggota_$_SESSION[kd_kab] WHERE id_pinkel='$pk3[id]' "));
							
										echo "
										<div>
											<p class='value4'>$jumpem <span class='fs-mini'> orang</span></p>
										</div>
										";
										}
									?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
        </div>
		
		<div class="row">
            <div class="col-md-7 col-lg-12">
                <section class="widget">
                    <header>
                        <h4>
                            Diagram <span class="fw-semi-bold">Perkembangan Pinjaman</span>
                        </h4>
                        <div class="widget-controls hidden-print">
                            <a href="#" id="print"><i class="glyphicon glyphicon-print"></i></a>
                            <a href="#" data-widgster="close"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
						<p class="fs-mini text-muted">
                            Status: <?php echo date('d M Y H:i:s A');?>
                        </p>
                    </header>
                    <div class="widget-body">
                        <div id="nvd32">
                            <svg></svg>
                        </div>
                    </div>
                </section>
            </div>

        </div>