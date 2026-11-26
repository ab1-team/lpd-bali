<?php session_start();
include "inc/inc.koneksi.php";
include "inc/fungsi_indotgl.php";
include "inc/fungsi_keuangan.php";
include "inc/fungsi_pinjaman.php";

$now    = date('Y-m-t');
$akt    = aktiva("$now");
$ak1    = substr($akt, 0, -6);
$ak2    = substr($akt, -6);

$ma = modalawal("$now");
$ap = asetproduktif("$now");
$pd = $ap - $ma;
$pr = @(floor($pd / $ma * 100));

?>

<script type="text/javascript">
    function MM_openBrWindow(theURL, winName, features) { //membuka window untuk print
        window.open(theURL, winName, features);
    }
</script>

<style>
.loader {
  color: #0dc5c1;
  font-size: 90px;
  text-indent: -9999em;
  overflow: hidden;
  width: 1em;
  height: 1em;
  border-radius: 50%;
  margin: 72px auto;
  position: relative;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation: load6 1.7s infinite ease, round 1.7s infinite ease;
  animation: load6 1.7s infinite ease, round 1.7s infinite ease;
}
@-webkit-keyframes load6 {
  0% {
    box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
  5%,
  95% {
    box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
  10%,
  59% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.087em -0.825em 0 -0.42em, -0.173em -0.812em 0 -0.44em, -0.256em -0.789em 0 -0.46em, -0.297em -0.775em 0 -0.477em;
  }
  20% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.338em -0.758em 0 -0.42em, -0.555em -0.617em 0 -0.44em, -0.671em -0.488em 0 -0.46em, -0.749em -0.34em 0 -0.477em;
  }
  38% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.377em -0.74em 0 -0.42em, -0.645em -0.522em 0 -0.44em, -0.775em -0.297em 0 -0.46em, -0.82em -0.09em 0 -0.477em;
  }
  100% {
    box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
}
@keyframes load6 {
  0% {
    box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
  5%,
  95% {
    box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
  10%,
  59% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.087em -0.825em 0 -0.42em, -0.173em -0.812em 0 -0.44em, -0.256em -0.789em 0 -0.46em, -0.297em -0.775em 0 -0.477em;
  }
  20% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.338em -0.758em 0 -0.42em, -0.555em -0.617em 0 -0.44em, -0.671em -0.488em 0 -0.46em, -0.749em -0.34em 0 -0.477em;
  }
  38% {
    box-shadow: 0 -0.83em 0 -0.4em, -0.377em -0.74em 0 -0.42em, -0.645em -0.522em 0 -0.44em, -0.775em -0.297em 0 -0.46em, -0.82em -0.09em 0 -0.477em;
  }
  100% {
    box-shadow: 0 -0.83em 0 -0.4em, 0 -0.83em 0 -0.42em, 0 -0.83em 0 -0.44em, 0 -0.83em 0 -0.46em, 0 -0.83em 0 -0.477em;
  }
}
@-webkit-keyframes round {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes round {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>

<!--<div class="row hidden-print">-->
<!--    <div id="message"></div>-->
<!--    <div class="widget mt-3">-->
<!--        <div class="widget-body">-->
<!--            Yth. Mitra PT. Asta Brata Teknologi <br>-->
<!--            <br>-->
<!--            For Your Information <br>-->
<!--            <br>-->
<!--            Untuk sementara  seluruh aktivitas layanan Technical Support Apps  dialihkan ke Nomor :  <br>-->
<!--            <b style="font-size: 16px">+62 882-0066-44656</b> <br>-->
<!--            <br>-->
<!--            Silakan Registrasikan Ulang Nomor Anda ke Nomor Technical Support Baru dengan cara di bawah ini : <br>-->
<!--            Nama Lengkap : <br>-->
<!--            Unit UPK Kec : <br>-->
<!--            Request : <br>-->
<!--            <br>-->
<!--            Terimakasih. <br>-->
<!--        </div>-->
<!--    </div>-->
    <div class="row mt-3">	
        
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div id="chartJS">
                <div class="loader">Loading...</div>
            </div> 
		</div>
    </div>
</div>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script>
    setTimeout(() => {
        $('.row.mt-3').load('modul/home/data/row_dashboard.php')
        setTimeout(() => {
            $('#message').load('modul/home/data/message.php')
            setTimeout(() => {
                $('#chartJS').load('modul/home/dashboard_chart.php')
            }, 500)
        }, 500)
    }, 500)
</script>