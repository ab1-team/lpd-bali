<?php
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_pinjaman.php";

?>			
        <div class="row hidden-print">
            <div class="col-md-3 col-sm-6">
                <section class="widget bg-primary text-white">
                    <div class="widget-body clearfix">
                        <h5 class="mt-xs mb-sm">Kelompok</h5>
                        <div class="row">
                            <div class="col-xs-3">
                                <span class="widget-icon">
                                    <i class="fa fa-group"></i>
                                </span>
                            </div>
                            <div class="col-xs-9">
                                <p class="h2 no-margin fw-normal"><?php echo $jum_akt;?></p>
								<span class="fs-mini">kelompok aktif</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <h5 class="no-margin">SPP</h5>
                                <p class="value4"><?php echo $jum_akt_1;?></p>
                            </div>
                            <div class="col-xs-4">
                                <h5 class="no-margin">UEP</h5>
                                <p class="value4"><?php echo $jum_akt_2;?></p>
                            </div>
							<div class="col-xs-4">
                                <h5 class="no-margin">Non-aktif</h5>
                                <p class="value4"><?php echo $jum_kel-$jum_akt;?></p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
           	
            <div class="col-md-3 col-sm-6">
                <section class="widget bg-primary text-white">
                    <div class="widget-body clearfix">
                        <h5 class="mt-xs mb-sm">Pemanfaat</h5>
                        <div class="row">
                            <div class="col-xs-3">
                                <span class="widget-icon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                            </div>
                            <div class="col-xs-9">
                                <p class="h2 no-margin fw-normal"><?php echo $jum_angg_a;?></p>
								<span class="fs-mini">pemanfaat aktif</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <h5 class="no-margin">SPP</h5>
                                <p class="value4"><?php echo $jum_angg_1;?></p>
                            </div>
                            <div class="col-xs-4">
                                <h5 class="no-margin">UEP</h5>
                                <p class="value4"><?php echo $jum_angg_2;?></p>
                            </div>
							<div class="col-xs-4">
                                <h5 class="no-margin">Non-aktif</h5>
                                <p class="value4"><?php echo $jum_angg-$jum_angg_a;?></p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
			
				<div class="col-md-3 col-sm-6">
                <section class="widget bg-primary text-white">
                    <div class="widget-body clearfix">
                        <h5 class="mt-xs mb-sm">Pinjaman</h5>
                        <div class="row">
                            <div class="col-xs-3">
                                <span class="widget-icon">
                                    <i class="fa fa-bar-chart-o"></i>
                                </span>
                            </div>
                            <div class="col-xs-9">
                                <p class="h2 no-margin fw-normal"><?php echo $jum_akt;?></p>
								<span class="fs-mini">pinjaman aktif</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <h5 class="no-margin">Proposal</h5>
                                <p class="value4"><?php echo $jum_prop;?></p>
                            </div>
                            <div class="col-xs-4">
                                <h5 class="no-margin">Verified</h5>
                                <p class="value4"><?php echo $jum_ver;?></p>
                            </div>
							<div class="col-xs-4">
                                <h5 class="no-margin">Waiting</h5>
                                <p class="value4"><?php echo $jum_wait;?></p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
	
            <div class="col-md-3 col-sm-6">
                <section class="widget bg-primary text-white">
                    <div class="widget-body clearfix">
                        <h5 class="mt-xs mb-sm">Pengguna</h5>
                        <div class="row">
                            <div class="col-xs-3">
                                <span class="widget-icon">
                                    <i class="fa fa-bank"></i>
                                </span>
                            </div>
                            <div class="col-xs-9">
                                <p class="h2 no-margin fw-normal"><?php echo $jum_kec;?></p>
								<span class="fs-mini">Kecamatan</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                &nbsp;
                            </div>
							<div class="col-xs-4">
                                <h5 class="no-margin">Aktif</h5>
                                <p class="value4"><?php echo $jum_kec;?></p>
                            </div>
                            <div class="col-xs-4">
                                <h5 class="no-margin">Non-aktif</h5>
                                <p class="value4">0</p>
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