<?php
$ipAddress 	=$_SERVER['REMOTE_ADDR']; // menangkap ip pengunjung

$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ipAddress));
if($query && $query['status'] == 'success') {
  $lokasi="$query[country] $query[regionName] $query[city]";
  $kodepos="$query[zip] $query[timezone]";
} else {
  $lokasi="Lokasi tidak dikenal";
  $kodepos="Kode POS dan timezone tidak terdeteksi";
}
?>               
				<section class="widget">
                    <div class="widget-image text-white">
                        <img src="images/desa.jpg">
                        <h3 class="title">
                            <span class="fw-normal">UPK <?php echo $kec['nama_kec'];?></span>, <?php echo $kec['nama_kab'];?>
							<br><br><br><br><br><br><br><br><br><br><br><br><br>
							<i class="fa fa-quote-left opacity-50"></i>
							<?php echo $kec['visi_misi'];?>
							<i class="fa fa-quote-right opacity-50"></i>
                        </h3>
                        <div class="info text-align-right">
                            <i class="fa fa-map-marker h1 no-margin mr-xs"></i>
                            <h6 class="no-margin mt-xs"><?php echo $lokasi;?></h6>
                            <p class="fs-sm"><?php echo $kodepos;?> <?php echo date('H:i A');?></p>
                        </div>
                        <div class="forecast">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4">
                                    <div class="row mt-xs">
                                        <div class="col-xs-6 no-padding">
                                            <canvas id="clear-day" width="40" height="40"></canvas>
                                            <p class="no-margin fw-normal mt-n-xs">sunny</p>
                                        </div>
                                        <div class="col-xs-6 no-padding">
                                            <h5 class="fw-semi-bold no-margin"><?php echo strtoupper($hari);?></h5>
                                            <p class="value1 ">29&deg;</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3 col-sm-2 no-padding">
                                    <h6 class="no-margin">TOMMOROW</h6>
                                    <canvas class="mt-xs" id="partly-cloudy-day" width="28" height="28"></canvas>
                                    <p class="no-margin fw-semi-bold">32&deg;</p>
                                </div>
                                <div class="col-xs-3 col-sm-2 no-padding">
                                    <h6 class="no-margin">TUE</h6>
                                    <canvas class="mt-xs" id="rain" width="28" height="28"></canvas>
                                    <p class="no-margin fw-semi-bold">25&deg;</p>
                                </div>
                                <div class="col-xs-3 col-sm-2 no-padding">
                                    <h6 class="no-margin">WED</h6>
                                    <canvas class="mt-xs" id="clear-day-3" width="28" height="28"></canvas>
                                    <p class="no-margin fw-semi-bold">28&deg;</p>
                                </div>
                                <div class="col-xs-3 col-sm-2 no-padding">
                                    <h6 class="no-margin">THU</h6>
									<canvas class="mt-xs" id="wind-1" width="28" height="28"></canvas>
                                    <p class="no-margin fw-semi-bold">17 MPS</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
  
			
           