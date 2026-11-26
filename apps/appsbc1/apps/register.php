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
		<p class="w-100 font-11 mt-3 color-theme opacity-60 text-center">IZI PAY &copy;PT. IZI Bayar Indonesia</p>
	</div>
    
    <div class="page-content">
        
        <div class="page-title page-title-small">
            <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Pendaftaran Agen</h2>
        </div>
        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
        </div>
        
        <div class="card card-style">
            <div class="content mb-0 mt-1">
                <div class="input-style has-icon input-style-1 input-required">
                    <i class="input-icon fa fa-user color-theme"></i>
                    <span>Nama</span>
                    <em>(required)</em>
                    <input type="name" id="nama" name="nama" class="font-20" placeholder="Nama">
                </div> 
                <div class="input-style has-icon input-style-1 input-required">
                    <i class="input-icon fa fa-address-book color-theme"></i>
                    <span>Nomor HP</span>
                    <em>(required)</em>
                    <input type="tel" id="nomor_hp" class="font-20" placeholder="Nomor HP">
                </div>

				<div class="input-style has-icon input-style-1 input-required">
                    <i class="input-icon fa fa-at color-theme"></i>
                    <span>Alamat</span>
                    <em>(required)</em>
                    <input type="name" id="alamat" class="font-20" placeholder="Alamat">
                </div>
                <div class="input-style has-icon input-style-1 input-required">
                    <i class="input-icon fa fa-lock color-theme"></i>
                    <span>PIN</span>
                    <em>(required)</em>
                    <input type="password" id="pin" class="font-20" placeholder="Masukkan PIN (6 karakter)">
                </div> 
                <div class="input-style has-icon input-style-1 input-required mb-4">
                    <i class="input-icon fa fa-lock color-theme"></i>
                    <span>Konfirmasi PIN</span>
                    <em>(required)</em>
                    <input type="password" id="pin2" class="font-20" placeholder="Masukkan PIN Kembali">
                </div>
				
				<div id="Konfirmasi"></div>
				
<script type="text/javascript">
	$("#nama").focus();
	
	$("#pin").click(function() {
					var nomor_hp = $("#nomor_hp").val();

                    $.ajax({
                        type: "POST",
                        url: "php/cek_nomor.php",
                        data: 	"nomor_hp="+nomor_hp,
								
						success: function(data) {
							$("#Konfirmasi").html(data);
                        }
                    });

                });
				
				
			$("#SimpanRegister").click(function() {
					var nama		= $("#nama").val();
					var nomor_hp 		= $("#nomor_hp").val();
					var alamat 		= $("#alamat").val();
					var pin 	= $("#pin").val();
					var pin2 	= $("#pin2").val();
					
					if(nama.length==0){ $("#Konfirmasi").html("<p class='color-red1-dark'>Nama tidak boleh kosong</p>"); $("#nama").focus(); return false; }
					if(nomor_hp.length==0){ $("#Konfirmasi").html("<p class='color-red1-dark'>Nomor HP tidak boleh kosong</p>"); $("#nomor_hp").focus(); return false; }
					if(alamat.length==0){ $("#Konfirmasi").html("<p class='color-red1-dark'>Alamat tidak boleh kosong</p>"); $("#alamat").focus(); return false; }
					if(pin.length<=5){ $("#Konfirmasi").html("<p class='color-red1-dark'>PIN setidaknya 6 karakter</p>"); $("#pin").focus(); return false; }
					if(pin.length==0){ $("#Konfirmasi").html("<p class='color-red1-dark'>PIN tidak boleh kosong</p>"); $("#pin").focus(); return false; }
					if(pin!=pin2){ $("#Konfirmasi").html("<p class='color-red1-dark'>PIN tidak sama</p>"); $("#pin2").focus(); return false; }
					
                    $.ajax({
                        type: "POST",
                        url: "php/register_simpan.php",
                        data: 	"nama="+nama+
								"&nomor_hp="+nomor_hp+
								"&alamat="+alamat+
								"&pin="+pin,
								
						success: function(data) {
							$("#Konfirmasi").html(data);
                        }
                    });

                });
</script>

                <a href="#" id="SimpanRegister" class="btn btn-m btn-full rounded-sm shadow-l bg-blue2-dark text-uppercase font-900">Daftar</a>


                <p class="text-center mt-4 mb-4">
                    Sudah terdaftar? <a href="login.php" class="color-highlight opacity-80 font-12">Login disini</a>
                </p>
			

            </div>
        </div>
 
    </div>    
    <!-- end of page content-->
    
<?php
$_SESSION['id']	="0";
session_unset();
session_destroy();
?>   
    
    
</div>    



<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</body>
