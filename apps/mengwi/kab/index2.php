<?php
include "../inc/inc.koneksi.php";
include "../inc/fungsi_indotgl.php";

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>SIM Koperasi &mdash; Artha mari</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Favicon icon -->
        <!-- <link rel="shortcut icon" href="vendor/img/favicon2.png" type="image/x-icon"> -->
        <!-- fontawesome icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- animation css -->
        <link rel="stylesheet"
            href="https://codedthemes.com/demos/admin-templates/datta-able/bootstrap/stage/assets/css/plugins/animate.min.css">
        <!-- vendor css -->
        <link rel="stylesheet"
            href="https://codedthemes.com/demos/admin-templates/datta-able/bootstrap/stage/assets/css/style.css">
        <!-- <link rel="stylesheet"
            href="https://codedthemes.com/demos/admin-templates/datta-able/bootstrap/stage/assets/css/layouts/dark.css"> -->
        <link rel="stylesheet" href="..//css/style.css">
        <link href='http://fonts.googleapis.com/css?family=Poppins:400,600,700,500,300' rel='stylesheet'
            type='text/css'>
        <link
            href='http://fonts.googleapis.com/css?family=Roboto:400,900italic,900,700italic,700,400italic,500,500italic,300,100italic,100,300italic'
            rel='stylesheet' type='text/css'>

    </head>

    <body>
        <div class="auth-wrapper relative aut-bg-img" style="background-image: url('../img/bg_pusat.jpg');">
            <div class="backdrop"></div>
            <div class="auth-content z-10">
                <div class="text-white">
                    <form action="" method="post">
                        <div class="card-body text-center backdrop-blur">
                            <div class="mb-4">
                                <img src="./img/Tocode.jpg" alt="" width="82">
                            </div>
                            <h3 class="mb-4 text-white">Login<br> SIM Koperasi</h3>
                            <div class="input-group mb-3">
                                <input type="text" name="uname" id="uname" class="form-control text-light"
                                    placeholder="Username">
                            </div>
                            <div class="input-group mb-4">
                                <input type="password" name="pass" id="pass" class="form-control text-light"
                                    placeholder="password">
                            </div>
                            <button class="btn btn-primary shadow-2 mb-4" name="SubmitLogin" id="SubmitLogin"
                                type="submit">Login</button>
                            <div id="Konfirmasi"></div>
                            <?php 
                                $st=$_GET['st'];
                                if($st==1){
                            ?>
                            <div class="alert alert-danger alert-sm">
                                <span class="fw-semi-bold">Petunjuk:</span><br>Anda tidak memiliki otoritas akses,
                                Silahkan Login !
                            </div>
                            <?php }else if($st==3){ ?>
                            <div class="alert alert-danger alert-sm">
                                <span class="fw-semi-bold">Petunjuk:</span><br>Username dan Password anda tidak
                                dikenal<br>Silahkan Login kembali !
                            </div>
                            <?php }else if($st==4){ ?>
                            <div class="alert alert-info alert-sm">
                                <span class="fw-semi-bold">Informasi:</span><br>Anda berhasil Log Out, sampai jumpa
                                kembali<br>Terimaksih ! <i class="fa fa-smile-o"></i>
                            </div>
                            <?php } ?>
                            <p>Oleh <span><a href="https://arthamari.com">arthamari.com</a></span></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Required Js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"
            integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script
            src="https://codedthemes.com/demos/admin-templates/datta-able/bootstrap/stage/assets/js/plugins/popper.min.js">
        </script>
        <script
            src="https://codedthemes.com/demos/admin-templates/datta-able/bootstrap/stage/assets/js/plugins/bootstrap.min.js">
        </script>

        <script type="text/javascript" src="../js/jquery.countTo.js"></script>
        <script type="text/javascript" src="../js/jquery.waypoints.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js"></script>
        <script src="../js/lightbox.min.js"></script>
        <script>
            function initialize() {
                var mapCanvas = document.getElementById('map-canvas');
                var mapOptions = {
                    center: new google.maps.LatLng(26.802100, 75.822739),
                    zoom: 8,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                var map = new google.maps.Map(mapCanvas, mapOptions)
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
        <script>
            $(document).ready(function () {
                $(document).on("scroll", onScroll);

                $('a[href^="#"]').on('click', function (e) {
                    e.preventDefault();
                    $(document).off("scroll");

                    $('a').each(function () {
                        $(this).removeClass('active');
                    })
                    $(this).addClass('active');

                    var target = this.hash;
                    $target = $(target);
                    $('html, body').stop().animate({
                        'scrollTop': $target.offset().top
                    }, 500, 'swing', function () {
                        window.location.hash = target;
                        $(document).on("scroll", onScroll);
                    });
                });
            });

            function onScroll(event) {
                var scrollPosition = $(document).scrollTop();
                $('nav a').each(function () {
                    var currentLink = $(this);
                    var refElement = $(currentLink.attr("href"));
                    if (refElement.position().top <= scrollPosition && refElement.position().top + refElement
                        .height() > scrollPosition) {
                        $('nav ul li a').removeClass("active");
                        currentLink.addClass("active");
                    } else {
                        currentLink.removeClass("active");
                    }
                });
            }
        </script>
        <script type="text/javascript">
            jQuery(function ($) {
                // custom formatting example
                $('.timer').data('countToOptions', {
                    formatter: function (value, options) {
                        return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g,
                            ',');
                    }
                });

                // start all the timers
                $('#starts').waypoint(function () {
                    $('.timer').each(count);
                });

                function count(options) {
                    var $this = $(this);
                    options = $.extend({}, options || {}, $this.data('countToOptions') || {});
                    $this.countTo(options);
                }
            });
        </script>
        <script type="text/javascript">
	        window.onload = function() {
    		    var input = document.getElementById("uname").focus();
    		}
		
    	    $(document).ready(function() {
    			$("#SubmitLogin").click(function() {
                        var uname			= $('#uname').val();
                        var pass			= $('#pass').val();
    					
    					if(uname.length==0){ $("#Konfirmasi").load('../modul/login/dilarang_uname.php'); $("#uname").focus(); return false; }
    					if(pass.length==0){ $("#Konfirmasi").load('../modul/login/dilarang_pass.php'); $("#pass").focus(); return false; }
    							
                        $.ajax({
                            type: "POST",
                            url: "cek_login.php",
                            data: 	"uname="+uname+
    								"&pass="+pass,
    								
    						success: function(data) {
    							window.location.href='../k.php?p=1';
    
                            }
                        });
    
                    });	
    	        });
        </script>
    </body>

</html>