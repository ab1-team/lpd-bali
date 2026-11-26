<?php
// Mengaktifkan tampilan kesalahan

include "inc/inc.koneksi.php";

$actual_link = "$_SERVER[HTTP_HOST]";
$kec	=mysql_query("SELECT * FROM kecamatan WHERE web_kec='$actual_link' OR web_alternatif='$actual_link' ");
$kab	=mysql_query("SELECT * FROM kabupaten WHERE web_kab='$actual_link' OR web_kab_alternatif='$actual_link' ");
$pus	=mysql_query("SELECT * FROM pusat WHERE web='$actual_link' OR web_alternatif='$actual_link' ");

$tampilkec  = mysql_fetch_array ($kec);
$ok_kec	=mysql_num_rows($kec);
$ok_kab	=mysql_num_rows($kab);
$ok_pus	=mysql_num_rows($pus);
if ($ok_kec > 0){
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" href="images/<?php 
	$logo=$tampilkec['logo'];
					if (empty($logo)) {
						echo "upeka.png";
						}else{
						echo "logo/$logo";
						}
	?>" type="image/x-icon">
    <title><?php echo "$tampilkec[nama_lembaga_sort] $tampilkec[nama_kec]";?></title>
    <link href="css/application.min.css" rel="stylesheet">
    <!-- as of IE9 cannot parse css files with more that 4K classes separating in two files -->
    <!--[if IE 9]>
        <link href="css/application-ie9-part2.css" rel="stylesheet">
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
         chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
         https://code.google.com/p/chromium/issues/detail?id=332189
         */
    </script>
	
	<script type="text/javascript" src="js/jquery-1.2.3.min.js"></script>
<script type="text/javascript">
	window.onload = function() {
		var input = document.getElementById("uname").focus();
		}
		
	$(document).ready(function() {
	
			$("#login").click(function() {
                    var uname			= $('#uname').val();
                    var pass			= $('#pass').val();
					
					if(uname.length==0){ $("#Konfirmasi").load('modul/login/dilarang_uname.php'); $("#uname").focus(); return false; }
					if(pass.length==0){ $("#Konfirmasi").load('modul/login/dilarang_pass.php'); $("#pass").focus(); return false; }
							


                });	
	
	});	
</script>
</head>
<body class="login-page mt-n-lg">

<div class="container">
    <main id="content" class="widget-login-container" role="main">
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-xs-10 col-lg-offset-4 col-sm-offset-3 col-xs-offset-1">
                <section class="widget widget-login animated fadeInUp">
                    <header><center>
					<img src="images/<?php 
							$logo=$tampilkec['logo'];
											if (empty($logo)) {
												echo "upeka.png";
												}else{
												echo "logo/$logo";
												}
							?>" width="150px"/></center><br>
                        <h3><?php echo "$tampilkec[nama_lembaga_sort] $tampilkec[nama_kec]";?></h3>
						<p class="widget-login-info">
                            <?php echo "$tampilkec[alamat_kec] $tampilkec[telpon_kec]";?>
                        </p>
                    </header>
                    <div class="widget-body">
                        <form class="login-form mt-lg" action="modul/login/cek_login.php" method="POST" onSubmit="return validasicontact(this)">
                            <div class="form-group">
                                <input type="text" class="form-control input-lg" autocomplete="off"  name="uname" id="uname" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input class="form-control input-lg" autocomplete="off"  name="pass" id="pass" type="password" placeholder="Password">
                            </div>
                            <div class="clearfix">
                                <div class="btn-toolbar pull-right">
                                    <button class="btn btn-danger btn-lg width-100" name="login" type="submit" id="login">Login</button>
                                </div>
                            </div>
                            <div id="Konfirmasi"></div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- Tambahkan div info di sini -->
        <div class="alert alert-warning text-center" role="alert">
            <strong>Info:</strong> Website ini berfungsi sebagai backup data untuk versi aplikasi sebelumnya setelah proses peralihan ke versi terbaru.
        </div>

        <!-- Akhir div info -->
    </main>
    <footer class="page-footer">
        <?php echo date('Y');?> &copy; PT. Asta Brata Teknologi [<?php echo $database;?>]
    </footer>
</div>
<!-- The Loader. Is shown when pjax happens -->
<div class="loader-wrap hiding hide">
    <i class="fa fa-circle-o-notch fa-spin-fast"></i>
</div>

<!-- common libraries. required for every page-->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-pjax/jquery.pjax.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/transition.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/collapse.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/dropdown.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/button.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/alert.js"></script>
<script src="vendor/jQuery-slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/widgster/widgster.js"></script>

<!-- common app js -->

<!-- page specific libs -->
<!-- page specific js -->
</body>
</html>

<?php

}else if ($ok_kab > 0){

header('location:kab');

}else if ($ok_pus > 0){

header('location:admin');

}else{
  echo "$actual_link belum masuk ke database, silakan hubungi Technical Support";  
}
?>