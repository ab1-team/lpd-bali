<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_pinjaman.php";


$_SESSION['jum_kel']=$jum_kel;
$_SESSION['jum_akt']=$jum_akt;
$_SESSION['jum_prop']=$jum_prop;
$_SESSION['jum_ver']=$jum_ver;
$_SESSION['jum_wait']=$jum_wait;


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
									yang belum dibayar senilai Rp. <?php echo number_format($sumSaldo); ?>, silahkan segera lakukan pembayaran.
									<a class="btn btn-default btn-xs pull-right mr" href="javascript:;" onclick="MM_openBrWindow('modul/pelaporan/<?php echo hash("sha512",'bismillahirohmanirrokhim'); ?>/INVOICE.php?idv=<?php echo $rows['idv'];?>' )" >Cetak</a>
									<a class="btn btn-danger btn-xs pull-right mr-xs" href="?p=invoice">Lihat Invoice</a>
								</div>
								
								<?php	
								} //END NOTIVIKASI INVOICE
								?>
				
            <div class="col-md-3 col-sm-6">
                <section class="widget bg-primary text-white">
                    <div class="widget-body clearfix">
						<div class="widget-top-overflow windget-padding-md clearfix" style="background-color:#00008B;">
                            <span class="h5 text-white">Groups Statistic
								<ul class="tags text-white pull-right">
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=A','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><span class="fs-mini"><?php echo $jum_akt;?> Groups</span></a></li>
								</ul>
							</span>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-3">
                                <span class="widget-icon">
                                    <i class="fa fa-group"></i>
                                </span>
                            </div>
                            <div class="col-xs-9">
                                <div class="h1 no-margin fw-normal"><?php echo $jum_akt;?><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=A','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="badge bg-danger" data-toggle="tooltip" data-placement="top" title="Kelompok Aktif"><span class="fs-mini">Active</span></a></div>
								<span class="fs-mini"><?php echo $jum_kel;?> registered</span>
                            </div>
                        </div>
                        <div class="btn-group btn-group-sm mt-sm">
                            <a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=P','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-warning btn-rounded" data-toggle="tooltip" data-placement="bottom" title="Proposal Menunggu Verifikasi"><b><?php echo $jum_prop;?></b> <span class="fs-mini">Props</span></a>
                            <a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=V','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-info btn-rounded" data-toggle="tooltip" data-placement="bottom" title="Proposal Telah diVerifikasi"><b><?php echo $jum_ver;?></b> <span class="fs-mini">Verified</span></a>
                            <a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=W','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"   class="btn btn-success btn-rounded" data-toggle="tooltip" data-placement="bottom" title="Daftar Tunggu Pencairan"><b><?php echo $jum_wait;?></b> <span class="fs-mini">Waiting</span></a>
                        </div>
                    </div>
                </section>
            </div>
           
		   <?php
		$tgl=date('d');
		$tgl_kondisi=date('Y-m-d');
		$data=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' AND substring(tgl_cair,9,2)='$tgl' ORDER BY pk.tgl_cair ASC ");
		$data2=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' AND substring(tgl_cair,9,2)='$tgl' ORDER BY pk.tgl_cair ASC ");
		$data3=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' AND substring(tgl_cair,9,2)='$tgl' ORDER BY pk.tgl_cair ASC ");
		?>	
            <div class="col-md-3 col-sm-6">
                <section class="widget bg-info text-white">
                    <div class="widget-body clearfix">
						<div class="widget-top-overflow windget-padding-md clearfix" style="background-color:#245269;">
							<span class="h5 text-white"><i class="fa fa-bank"></i> Tagihan Hari Ini
								<ul class="tags text-white pull-right">
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LTA.php','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" ><b><?php echo mysql_num_rows($data);?></b> <span class="fs-mini">Group</span></a></li>
								</ul>
							</span>
						</div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="live-tile" data-mode="carousel" data-speed="750" data-delay="3000" data-height="57">
                                    <?php
									while($row=mysql_fetch_array($data)){
									$tgl_cair=$row['tgl_cair'];
									
										echo "
										<div class='text-align-center'>
											<h6 class='no-margin'>&nbsp;</h6>
											<p class='h6 no-margin fw-normal'>".tgl_indo($tgl_cair)."</p>
											<p class='h4 no-margin fw-normal'>$row[nama_kelompok] $row[nama_desa]</p>
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
			$tung0=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' ORDER BY pk.id ASC ");			
			$tung1=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' ORDER BY pk.id ASC ");			
			$tung2=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' ORDER BY pk.id ASC ");			
			$tung3=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='A' AND k.lokasi='$_SESSION[lokasi]' ORDER BY pk.id ASC ");			

			?>
				<div class="col-md-3 col-sm-6">
                <section class="widget bg-danger text-white">
                    <div class="widget-body clearfix">
						<div class="widget-top-overflow windget-padding-md clearfix" style="background-color:#843534;">
							<span class="h5 text-white"><i class="fa fa-warning"></i> Tunggakan 
								<ul class="tags text-white pull-right">
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LTU.php','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )" ><b>
									<?php
							
							while($r=mysql_fetch_array($tung0)){
								
										$idpinj			=$r['id'];
										$tgl_now		=date('Y-m-d');
										$nunggakpokok		=nunggakpokok("$tgl_now-$idpinj");
										$nunggakjasa		=nunggakjasa("$tgl_now-$idpinj");
										if ($nunggakpokok > 0 or $nunggakjasa > 0) {
											$no=1;
											$noo=$noo+$no;
									}
									
									}
									
									echo $noo;
							?>
									</b> <span class="fs-mini">Group</span></a></li>
								</ul>
							</span>
						</div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="live-tile" data-mode="carousel" data-speed="750" data-delay="3000" data-height="57">
                                    <?php
									while($row=mysql_fetch_array($tung1)){
										$idpinj			=$row['id'];
										$tgl_cair			=$row['tgl_cair'];
										$tgl_now		=date('Y-m-d');
										$nunggakpokok		=nunggakpokok("$tgl_now-$idpinj");
										$nunggakjasa		=nunggakjasa("$tgl_now-$idpinj");
										if ($nunggakpokok > 0 or $nunggakjasa > 0) {
										echo "
										<div class='text-align-center'>
											<h6 class='no-margin'>&nbsp;</h6>
											<p class='h6 no-margin fw-normal'>".tgl_indo($tgl_cair)."</p>
											<p class='h4 no-margin fw-normal'>$row[nama_kelompok] $row[nama_desa]</p>
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
		$dpk1=mysql_query("SELECT * FROM desa d, $table_kelompok k, $table_pk pk WHERE d.id=k.desa AND k.id=pk.id_kel AND pk.status='W' AND k.lokasi='$_SESSION[lokasi]' ORDER BY pk.tgl_cair ASC ");
		$dpk2=mysql_query("SELECT * FROM $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND pk.status='W' AND k.lokasi='$_SESSION[lokasi]' ORDER BY pk.tgl_cair ASC ");
		$dpk3=mysql_query("SELECT * FROM $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND pk.status='W' AND k.lokasi='$_SESSION[lokasi]' ORDER BY pk.tgl_cair ASC ");
		?>	
            <div class="col-md-3 col-sm-6">
                <section class="widget bg-success text-white">
                    <div class="widget-body clearfix">
						<div class="widget-top-overflow windget-padding-md clearfix" style="background-color:#006400;">
							<span class="h5 text-white"><i class="glyphicon glyphicon-calendar"></i> Agenda Pencairan
								<ul class="tags text-white pull-right">
									<li><a href="javascript:;" onclick="MM_openBrWindow('modul/pinjaman/cp/LP.php?&sT=W','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=1200,left=180,top=0,titlebar=0' )"><b><?php echo $jum_wait;?></b> <span class="fs-mini">Group</span></a></li>
								</ul>
							</span>
						</div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="live-tile" data-mode="carousel" data-speed="750" data-delay="3000" data-height="57">
                                    <?php
									if($jum_wait>0) {
									
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
											<h6 class='no-margin'>&nbsp;</h6>
											<h6 class='no-margin'>$namahari $pasaran[$mod], ".tgl_indo($tgl_cair)."</h6>
											<p class='h4 no-margin fw-normal'>$pk1[nama_kelompok] $pk1[nama_desa]</p>
										</div>
										";
										}
										
										}else{
										echo "
										<div class='text-align-center'>
											<p class='h4 no-margin fw-normal'><br>Tidak ada Agenda Pencairan</p>
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
    </div>
		
		<div class="row">
            <div class="col-md-7 col-lg-12">
                
					<?php include "modul/home/charts.php"; ?>
						<table class="columns">
						  <tr>
							<td><div id="Anthony_chart_div"></div></td>
							<td><div id="Sarah_chart_div"></div>
								<div id="Rafi_chart_div"></div></td>
						  </tr>
						  <tr>
							<td colspan="2"><div id="SPP_chart_div"></div></td>
						  </tr>
						  <tr>
							<td colspan="2"><div id="UEP_chart_div"></div></td>
						  </tr>
						</table>
                    
            </div>

        </div>