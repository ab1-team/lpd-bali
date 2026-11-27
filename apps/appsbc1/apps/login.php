<?php session_start(); include "../inc/inc.koneksi.php"; ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>IZI PAY</title>
<link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="fonts/css/fontawesome-all.min.css">    
<link rel="manifest" href="_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
<link rel="apple-touch-icon" sizes="180x180" href="app/icons/icon-192x192.png">
</head>
    
<body class="theme-light" data-highlight="blue2">
    
<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>
    
<div id="page">
    
	<div id="footer-bar" class="footer-bar-1">
		<p class="w-100 font-11 mt-3 color-theme opacity-60 text-center"><?php echo LEMBAGA_SORT; ?> Bali Apps &copy;PT. Asta Brata Teknologi</p>
	</div>
	
	
    <div class="page-content">
        
        <div class="page-title page-title-small">
            <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Masuk</h2>
        </div>
        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="../images/logo_bumdes.png"></div>
        </div>
        
        <div class="card card-style">
            <div class="content mt-2 mb-0">
				<p class="font-22 mt-3"></p>

                <div class="input-style has-icon input-style-1 input-required pb-1">
                    <i class="input-icon fa fa-address-book color-theme"></i>
                    <span>Nomor HP</span>
                    <em>(required)</em>
                    <input class="font-22" id="nomorhp" name="nomorhp" type="tel" placeholder="Nomor HP"/>
                </div>			
                <div class="input-style has-icon input-style-1 input-required pb-1">
                    <i class="input-icon fa fa-lock color-theme"></i>
                    <span>PIN</span>
                    <em>(required)</em>
                    <input type="password" id="pin" name="pin" class="font-22" placeholder="PIN">
                </div>

				<script type="text/javascript">
				$("#nomorhp").focus();
				$("#TombolLogin").click(function() {
								var nomorhp		= $("#nomorhp").val();
								var pin 		= $("#pin").val();
								
								if(nomorhp.length==0){ $("#Konfirmasii").html("<p class='text-center color-red2-dark mt-5'>NOMOR HP TIDAK BOLEH KOSONG</p>"); $("#nomorhp").focus(); return false; }
								if(pin.length==0){ $("#Konfirmasii").html("<p class='text-center color-red2-dark mt-5'>PIN TIDAK BOLEH KOSONG</p>"); $("#pin").focus(); return false; }
								
								$.ajax({
								type: "POST",
								url: "php/cek_login.php",
								data: 	"nomorhp="+nomorhp+
										"&pin="+pin,
								success	: function(data){
										$("#menu-success-1").html(data);
									}
								
							});

							});
				</script>
				
				
				
					
                    <a href="#" id="TombolLogin" data-menu="menu-success-1" class="btn btn-m btn-full rounded-sm shadow-l bg-blue2-dark text-uppercase font-900">Login</a>
                    
					<div class="mt-4 mb-3"></div>
            </div>
        </div>

        
    </div>    
    <!-- end of page content-->
    
	
	<!---------------->
    <!---------------->
    <!--Menu Success-->
    <!---------------->
    <!---------------->
    <div id="menu-success-1" class="menu menu-box-bottom menu-box-detached rounded-m" 
         data-menu-height="305" 
         data-menu-effect="menu-over">
		 <div id="Konfirmasii"></div>
	</div>  
	
    
</div> 


<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</body>
