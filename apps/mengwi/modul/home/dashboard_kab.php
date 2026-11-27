<?php
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_pinjaman.php";

?>
<style>
    .position {
      aspect-ratio: 1 / 1;
      position: absolute;
      inset: 0.5em;
      margin: auto;
    }
    .bigbox {
      position: relative;
      width: 30rem;
    }
    .clock-ctn {
      box-shadow: inset -2px -2px 6px rgba(255, 255, 255, .7),
              inset -2px -2px 4px rgba(255, 255, 255, .5),
              inset 2px 2px 2px rgba(255, 255, 255, .075),
              inset 2px 2px 4px rgba(0, 0, 0, .15);
      background: #efefef;
      width: 90%;
      border-radius: 50%;
    }
    .markers {
      width: 2%;
      aspect-ratio: 1 / 45;
      border-radius: 30%;
      background: #ffffff90;
    }
    .cardinal {
      background: #FF5733;
      width: 4%;
      aspect-ratio: 2 / 45;
    }
    #m-3-9 {
      transform: rotate(90deg);
    }
    #m-1-7 {
      background: blue;
      transform: rotate(30deg);
    }
    #m-2-8 {
      background: blue;
      transform: rotate(60deg);
    }
    #m-4-10 {
      background: blue;
      transform: rotate(-30deg);
    }
    #m-5-11 {
      background: blue;
      transform: rotate(-60deg);
    }
    .clock-face {
      background: #efefef;
      width: 75%;
      border-radius: 50%;
    }
    .clock-hand {
      border-radius: 2em;
      background: linear-gradient(#FF5733 50%, transparent 50%);
    }
    .hour {
      width: 3%;
      aspect-ratio: 1 / 25;
    }
    .minute {
      width: 2%;
      aspect-ratio: 1 / 45;
    }
    .second {
      width: .5%;
      aspect-ratio: 1 / 192;
      background: linear-gradient(red 50%, transparent 50%);
    }
    .dot {
      width: 7%;
      border-radius: 50%;
      background: #fff;
    }
    .ref {
      font-size: 0.7em;
      bottom: 4%;
      color: #ffffff89;
    }
</style>
<div class="row hidden-print">
    <div class="col-md-3 col-sm-6">
        <section class="widget">
            <div class="widget-body mb-lg">
                <div class="widget-top-overflow windget-padding-md clearfix mb-lg bg-success">
                    <span class="h5 text-white">
                        &nbsp; Simpanan
					</span>
                </div>
                
                <div class="row mt">
                    <ul class="map-controls nav nav-pills nav-justified bg-primary-light" style="border: 1px solid #5d8fc2;">
                        <li><a href="#">
                            <div class="h1 no-margin fw-normal text-align-center"><?php echo (!$jum_simp) ? '0':$jum_simp;?></div> <span class="badge bg-primary">Aktif</span>
                        </a></li>
                        <li><a href="#">
                            <div class="h1 no-margin fw-normal text-align-center"><?php echo (!$jum_simp_1) ? '0':$jum_simp_1;?></div> <span class="badge bg-primary">Individu</span>
                        </a></li>
                        <li><a href="#">
                            <div class="h1 no-margin fw-normal text-align-center"><?php echo (!$jum_simp_2) ? '0':$jum_simp_2;?></div> <span class="badge bg-primary">Anggota</span>
                        </a></li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-3 col-sm-6">
        <section class="widget">
            <div class="widget-body mb-lg">
                <div class="widget-top-overflow windget-padding-md clearfix mb-lg bg-danger">
                    <span class="h5 text-white">
                        &nbsp; Pengguna
					</span>
                </div>
                
                <div class="row mt">
                    <ul class="map-controls nav nav-pills nav-justified bg-danger-light" style="border: 1px solid #dd5826;">
                        <li><a href="#">
                            <div class="h1 no-margin fw-normal text-align-center"><?php echo (!$jum_peng_1) ? '0':$jum_peng_1;?></div> <span class="badge bg-primary">Pusat</span>
                        </a></li>
                        <li><a href="#">
                            <div class="h1 no-margin fw-normal text-align-center"><?php echo (!$jum_peng_2) ? '0':$jum_peng_2;?></div> <span class="badge bg-primary">Cab 1</span>
                        </a></li>
                        <li><a href="#">
                            <div class="h1 no-margin fw-normal text-align-center"><?php echo (!$jum_peng_3) ? '0':$jum_peng_3;?></div> <span class="badge bg-primary">Cab 2</span>
                        </a></li>
                        <li><a href="#">
                            <div class="h1 no-margin fw-normal text-align-center"><?php echo (!$jum_peng_3) ? '0':$jum_peng_3;?></div> <span class="badge bg-primary">Cab 3</span>
                        </a></li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-3 col-sm-6">
        <section class="widget">
            <div class="widget-body mb-lg">
                <div class="widget-top-overflow windget-padding-md clearfix mb-lg bg-info">
                    <span class="h5 text-white">
                        &nbsp; Pinjaman
					</span>
                </div>
                
                <div class="row mt">
                    <ul class="map-controls nav nav-pills nav-justified bg-info-light" style="border: 1px solid #5dc4bf;">
                        <li><a href="#">
                            <div class="h1 no-margin fw-normal text-align-center"><?php echo (!$jum_prop) ? '0':$jum_prop;?></div> <span class="badge bg-primary">Proposal</span>
                        </a></li>
                        <li><a href="#">
                            <div class="h1 no-margin fw-normal text-align-center"><?php echo (!$jum_wait) ? '0':$jum_wait;?></div> <span class="badge bg-primary">Waiting</span>
                        </a></li>
                        <li><a href="#">
                            <div class="h1 no-margin fw-normal text-align-center"><?php echo (!$jum_akt) ? '0':$jum_akt;?></div> <span class="badge bg-primary">Aktif</span>
                        </a></li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-3 col-sm-6">
        <section class="widget">
            <div class="widget-body mb-lg">
                <div class="widget-top-overflow windget-padding-md clearfix mb-lg bg-primary">
                    <span class="h5 text-white">
                        &nbsp; Kecamatan
					</span>
                </div>
                
                <div class="row mt">
                    <ul class="map-controls nav nav-pills nav-justified bg-primary-light" style="border: 1px solid #5d8fc2;">
                        <li><a href="#">
                            <div class="h1 no-margin fw-normal text-align-center"><?php echo (!$jum_kec) ? '0':$jum_kec;?></div> <span class="badge bg-primary">Total</span>
                        </a></li>
                        <li><a href="#">
                            <div class="h1 no-margin fw-normal text-align-center"><?php echo (!$jum_kec) ? '0':$jum_kec;?></div> <span class="badge bg-primary">Aktif</span>
                        </a></li>
                        <li><a href="#">
                            <div class="h1 no-margin fw-normal text-align-center"><?php echo '0';?></div> <span class="badge bg-primary">Nonaktif</span>
                        </a></li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
    <!--<div class="col-lg-3 col-md-6">-->
    <!--    <section class="widget bg-primary text-white">-->
    <!--        <div class="widget-body clearfix">-->
    <!--            <h5 class="mt-xs mb-sm">Simpanan</h5>-->
    <!--            <div class="row">-->
    <!--                <div class="col-xs-3">-->
    <!--                    <span class="widget-icon">-->
    <!--                        <i class="fa fa-group"></i>-->
    <!--                    </span>-->
    <!--                </div>-->
    <!--                <div class="col-xs-4">-->
    <!--                    <span class="fs-mini">Aktif</span>-->
    <!--                    <p class="h2 no-margin fw-normal"><?php echo (!$jum_simp) ? '0':$jum_simp;?></p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="row">-->
    <!--                <div class="col-xs-4">-->
    <!--                    <h5 class="no-margin">Anggota</h5>-->
    <!--                    <p class="value4"><?php echo (!$jum_simp_2) ? '0':$jum_simp_2; ?></p>-->
    <!--                </div>-->
    <!--                <div class="col-xs-4">-->
    <!--                    <h5 class="no-margin">Individu</h5>-->
    <!--                    <p class="value4"><?php echo (!$jum_simp_1) ? '0':$jum_simp_1; ?></p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->
    <!--</div>-->

    <!--<div class="col-lg-3 col-md-6">-->
    <!--    <section class="widget bg-warning text-dark">-->
    <!--        <div class="widget-body clearfix">-->
    <!--            <h5 class="mt-xs mb-sm">Pengguna</h5>-->
    <!--            <div class="row">-->
    <!--                <div class="col-xs-3">-->
    <!--                    <span class="widget-icon">-->
    <!--                        <i class="glyphicon glyphicon-user"></i>-->
    <!--                    </span>-->
    <!--                </div>-->
    <!--                <div class="col-xs-4">-->
    <!--                    <span class="fs-mini">Pusat</span>-->
    <!--                    <p class="h2 no-margin fw-normal"><?php echo (!$jum_peng_1) ? '0':$jum_peng_1;?></p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="row">-->
    <!--                <div class="col-xs-4">-->
    <!--                    <h5 class="no-margin">Kec 1</h5>-->
    <!--                    <p class="value4"><?php echo (!$jum_peng_2) ? '0':$jum_peng_2;?></p>-->
    <!--                </div>-->
    <!--                <div class="col-xs-4">-->
    <!--                    <h5 class="no-margin">Kec 2</h5>-->
    <!--                    <p class="value4"><?php echo (!$jum_peng_3) ? '0':$jum_peng_3;?></p>-->
    <!--                </div>-->
    <!--                <div class="col-xs-4">-->
    <!--                    <h5 class="no-margin">Kec 3</h5>-->
    <!--                    <p class="value4"><?php echo (!$jum_peng_4) ? '0':$jum_peng_4;?></p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->
    <!--</div>-->

    <!--<div class="col-lg-3 col-md-6">-->
    <!--    <section class="widget bg-success text-white">-->
    <!--        <div class="widget-body clearfix">-->
    <!--            <h5 class="mt-xs mb-sm">Pinjaman</h5>-->
    <!--            <div class="row">-->
    <!--                <div class="col-xs-3">-->
    <!--                    <span class="widget-icon">-->
    <!--                        <i class="fa fa-bar-chart-o"></i>-->
    <!--                    </span>-->
    <!--                </div>-->
    <!--                <div class="col-xs-4">-->
    <!--                    <span class="fs-mini">Aktif</span>-->
    <!--                    <p class="h2 no-margin fw-normal"><?php echo (!$jum_akt) ? '0':$jum_akt;?></p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="row">-->
    <!--                <div class="col-xs-4">-->
    <!--                    <h5 class="no-margin">Proposal</h5>-->
    <!--                    <p class="value4"><?php echo (!$jum_prop) ? '0':$jum_prop;?></p>-->
    <!--                </div>-->
    <!--                <div class="col-xs-4">-->
    <!--                    <h5 class="no-margin">Verified</h5>-->
    <!--                    <p class="value4"><?php echo (!$jum_ver) ? '0':$jum_ver;?></p>-->
    <!--                </div>-->
    <!--                <div class="col-xs-4">-->
    <!--                    <h5 class="no-margin">Waiting</h5>-->
    <!--                    <p class="value4"><?php echo (!$jum_wait) ? '0':$jum_wait;?></p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->
    <!--</div>-->

    <!--<div class="col-lg-3 col-md-6">-->
    <!--    <section class="widget bg-danger text-white">-->
    <!--        <div class="widget-body clearfix">-->
    <!--            <h5 class="mt-xs mb-sm">Pengguna</h5>-->
    <!--            <div class="row">-->
    <!--                <div class="col-xs-3">-->
    <!--                    <span class="widget-icon">-->
    <!--                        <i class="fa fa-bank"></i>-->
    <!--                    </span>-->
    <!--                </div>-->
    <!--                <div class="col-xs-9">-->
    <!--                    <span class="fs-mini">Kecamatan</span>-->
    <!--                    <p class="h2 no-margin fw-normal"><?php echo (!$jum_kec) ? '0':$jum_kec;?></p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="row">-->
    <!--                <div class="col-xs-4">-->
    <!--                    <h5 class="no-margin">Aktif</h5>-->
    <!--                    <p class="value4"><?php echo (!$jum_kec) ? '0':$jum_kec;?></p>-->
    <!--                </div>-->
    <!--                <div class="col-xs-4">-->
    <!--                    <h5 class="no-margin">Nonaktif</h5>-->
    <!--                    <p class="value4">0</p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->
    <!--</div>-->

    <div class="row">
        <div class="col-lg-7">
            <section class="widget">
                <header>
                    <h4>
                        Diagram <span class="fw-semi-bold">Aset Bulan ini</span>
                    </h4>
                    <p class="fs-mini text-muted">
                        Status: <?php echo date('d M Y H:i:s A');?>
                    </p>
                </header>
                <div class="widget-body">
                    <div id="nvd32" data-id="<?= $_SESSION['id']; ?>">
                        <svg></svg>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-5">
            <section class="widget">
                <header>
                    <h4>
                        <span class="fw-semi-bold">Waktu</span>
                    </h4>
                </header>
                <div class="widget-body" style="background: #efefef; border-radius: 8px; display: flex; justify-content: center;">
                    <div class="bigbox position">
                      <div class="clock-ctn position">
                        <div class="markers position cardinal" id="m-12-6"></div>
                        <div class="markers position" id="m-1-7"></div>
                        <div class="markers position" id="m-2-8"></div>
                        <div class="markers position cardinal" id="m-3-9"></div>
                        <div class="markers position" id="m-4-10"></div>
                        <div class="markers position" id="m-5-11"></div>
                        <div class="clock-face position">
                          <div class="clock-hand position hour"></div>
                          <div class="clock-hand position minute"></div>
                          <div class="clock-hand position second"></div>
                          <div class="dot position"></div>
                        </div>
                      </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script>
        var date = new Date();
        var currentHour = date.getHours();
        var currentMinute = date.getMinutes();
        var currentSecond = date.getSeconds();
        var secondHand = document.querySelector(".second");
        var minuteHand = document.querySelector(".minute");
        var hourHand = document.querySelector(".hour");
        var x = currentSecond * 6;
        var y = currentMinute * 6 + ((6/60)*currentSecond);
        var z = currentHour * 30 + ((30/60)*currentMinute + (((30/60)/60)*currentSecond));
        // 'x' is the degree value of the secondHand 'Transform[Rotate]'
        // 'y' is the degree value of the minuteHand 'Transform[Rotate]'
        // 'z' is the degree value of the hourHand 'Transform[Rotate]'
        setInterval(function () {
          x += 6/100;
          y += (6/100/60);
          z += (6/100/60/12);
          secondHand.style.transform = "rotate(" + x + "deg)";
          minuteHand.style.transform = "rotate(" + y + "deg)";
          hourHand.style.transform = "rotate(" + z + "deg)";
        }, 10);
    </script>
</div>