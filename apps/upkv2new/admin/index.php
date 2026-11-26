<?php
include "../inc/inc.koneksi.php";
include "../inc/fungsi_indotgl.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator SI UPK Online</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="../kab/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../kab/style.css" type="text/css">
	<link href="../kab/css/lightbox.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Poppins:400,600,700,500,300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,900italic,900,700italic,700,400italic,500,500italic,300,100italic,100,300italic' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<script type="text/javascript" src="../js/jquery-1.2.3.min.js"></script>
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
							window.location.href='../p.php?p=1';

                        }
                    });

                });	
	
	});	
</script>

</head>
<body>
<header class="header">
	<div class="container">
		<div class="row">
			<div class="col-md-6 ">
				<div class="navbar-header">
					    <button type="button" class="navbar-toggle menu-button" data-toggle="collapse" data-target="#myNavbar">
					        <span class="glyphicon glyphicon-align-justify"></span>
					    </button>
      					<a class="navbar-brand logo" href="#">SI UPK Online Pusat</a>
    			</div>
			</div>
			<!-- 
			<div class="col-md-6">
				<nav class="collapse navbar-collapse" id="myNavbar" role="navigation">
					<ul class="nav navbar-nav navbar-right menu">
							<li><a href="#page-top" class="page-scroll active">Home</a></li>
							<li><a href="#section2" class="page-scroll">Features</a></li>
							<li><a href="#work" class="page-scroll">Portfolio</a></li>
							<li><a href="#section4" class="page-scroll">Contact</a></li>
					</ul>
				</nav>
			</div>
			-->
		</div>
	</div>
</header>

<div class="container-fluid main" id="page-top">
	<div class="row">
		<div class="col-md-12 backg">
			<div class="col-md-4 col-md-offset-7 inner col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
				<div class="text-box">
                	<p class="intro">Login Administrator<br> SI UPK Online</p>
                    <h2>
						<input type="text" class="form-control" id="uname" placeholder="Username"/>
						<input type="text" class="form-control" id="pass" placeholder="Password"/>
					</h2>
                    <p><a href="#" class="link-button" id="SubmitLogin"><i class="glyphicon glyphicon-user"></i> &nbsp; Personal Login</a></p>
					<div id="Konfirmasi"></div>
					<?php 
									$st=$_GET['st'];
									if($st==1){
									?>
									<div class="alert alert-danger alert-sm">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
										<span class="fw-semi-bold">Petunjuk:</span><br>Anda tidak memiliki otoritas akses, Silahkan Login !
									</div>
									<?php }else if($st==3){ ?>
									<div class="alert alert-danger alert-sm">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
										<span class="fw-semi-bold">Petunjuk:</span><br>Username dan Password anda tidak dikenal<br>Silahkan Login kembali !
									</div>
									<?php }else if($st==4){ ?>
									<div class="alert alert-info alert-sm">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
										<span class="fw-semi-bold">Informasi:</span><br>Anda berhasil Log Out, sampai jumpa kembali<br>Terimaksih ! <i class="fa fa-smile-o"></i>
									</div>
									<?php } ?>

                    <p>Oleh <span><a href="http://siupkonline.com">siupkonline.com</a></span></p>
				</div>
  			</div>
		</div>
		<div class="col-md-12 some-notes">
			<div class="title">
                <h2>Administrator SI UPK Online</h2>
            </div>
            <div class="desc">
                <p>Selamat Datang di Administrator SI UPK Online</p>
            </div>
		</div>
	</div>
</div>


<div class="container-fluid footer">
	<div class="row">
		<div class="col-md-12">
			<p>Administrator SI UPK Online <a href="http://siupkonline.com/" target="_blank">siupkonline.com</a></p>
		</div>
	</div>
</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.countTo.js"></script>
    <script type="text/javascript" src="js/jquery.waypoints.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="js/lightbox.min.js"></script>
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
 
	function onScroll(event){
		var scrollPosition = $(document).scrollTop();
		$('nav a').each(function () {
			var currentLink = $(this);
			var refElement = $(currentLink.attr("href"));
			if (refElement.position().top <= scrollPosition && refElement.position().top + refElement.height() > scrollPosition) {
				$('nav ul li a').removeClass("active");
				currentLink.addClass("active");
			}
			else{
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
          return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
        }
      });
 
      // start all the timers
      $('#starts').waypoint(function() {
    $('.timer').each(count);
	});
 
      function count(options) {
        var $this = $(this);
        options = $.extend({}, options || {}, $this.data('countToOptions') || {});
        $this.countTo(options);
      }
    });
  	</script>
</body>
</html>
