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
 
    <!-- header and footer bar go here-->
    <div id="footer-bar" class="footer-bar-5">
        <a href="index-components.html"><i data-feather="slack" data-feather-line="2" data-feather-size="21" data-feather-color="brown1-dark" data-feather-bg="red2-fade-light"></i><span>Bayar</span></a>
        <a href="index-media.html"><i data-feather="speaker" data-feather-line="2" data-feather-size="21" data-feather-color="green1-dark" data-feather-bg="green1-fade-light"></i><span>Keagenan</span></a>
        <a href="index.php" class="active-nav"><i data-feather="home" data-feather-line="2" data-feather-size="21" data-feather-color="blue2-dark" data-feather-bg="blue2-fade-light"></i><span>Home</span></a>
        <a href="index-pages.html"><i data-feather="trending-up" data-feather-line="2" data-feather-size="21" data-feather-color="red2-dark" data-feather-bg="red2-fade-light"></i><span>Transaksi</span></a>
        <a href="index-settings.html"><i data-feather="user-check" data-feather-line="2" data-feather-size="21" data-feather-color="gray2-dark" data-feather-bg="gray2-fade-light"></i><span>Akun</span></a>
    </div>
    
    <div class="page-content" style="min-height:60vh!important">
        <div class="page-title page-title-small">
            <h2><a href="index_home.php" data-back-button><i class="fa fa-arrow-left"></i></a>Beli Paket Data</h2>
        </div>
        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="images/selular.png"></div>
        </div>
        
        <div class="card card-style">
            <div class="content">
                <div class="input-style input-style-2 input-required">
                    <span class="color-highlight">Nomor HP</span>
                    <em>(required)</em>
                    <input class="form-control font-24" id="nomor_hp" type="tel" placeholder="">
                </div>
				<img src="images/selular.png" width="330px" height="40px">
  
				<div id="beli_pulsa_list"></div>
            </div>
        </div>
		

<script type="text/javascript">
	$("#nomor_hp").focus();
	
$(document).ready(function() {

			$("#nomor_hp").keyup(function(){
						var cari = $("#nomor_hp").val();
						cariAnggota(cari);
					})
					function cariAnggota(e){
						var cari = e;
						
					if(cari.length>=10){
						
						$.ajax({
							type	: "POST",
							url		: "beli_pulsa_list.php",
							data	: "nomor_hp="+cari,
							success	: function(data){
								$("#beli_pulsa_list").html(data);
								$("#nomortujuan").html(cari);
								
							}
						});
					}
					
					}
				
            });
</script>


    </div>    
    <!-- end of page content-->
    
    <div id="list_harga" class="menu menu-box-modal rounded-m" 
         data-menu-height="200" 
         data-menu-width="330">
        <h1 class="text-center font-700 mt-3 pb-1"><div id="nomortujuan"></div></h1>
        
		<script type="text/javascript">	
	
			function konfirmasi(id){
				// membuat objek elemen
				var hasil = document.getElementById("KonfirmasiNominal");
				// menampilkan output ke elemen hasil
				hasil.innerHTML = "<p class='boxed-text-l'>Anda akan membeli Voucher "+id+"</p>";
				
				$("#kode_produk").val(id);
				
				}
				
		
		$("#SimpanBeliPulsa").click(function() {
					var nomor_hp		= $('#nomor_hp').val();
                    var kode_produk		= $('#kode_produk').val();	
							
                    $.ajax({
                        type: "POST",
                        url: "php/beli_pulsa_simpan.php",
                        data: 	"nomor_pelanggan="+nomor_hp+
								"&kode_produk="+kode_produk,
								
						success: function(data) {
							// Simulate a mouse click:
							 window.location.href = "index.php";

							// Simulate an HTTP redirect:
							// window.location.replace("index.php");
							
                        }
                    });

                });
				
		</script>
			
		<div id="KonfirmasiNominal"></div>
        <input id="kode_produk" type="hidden">
		
        <div class="row mr-3 ml-3 mb-0">
            <div class="col-6">
                <a href="#" id="SimpanBeliPulsa" class="btn btn-sm btn-full button-s shadow-l rounded-s text-uppercase font-900 bg-green1-dark">Lanjut</a>
            </div>
            <div class="col-6">
                <a href="#" class="close-menu btn btn-sm btn-full button-s shadow-l rounded-s text-uppercase font-900 bg-red1-dark">Batal</a>
            </div>
        </div>
    </div> 
    
    
</div>    



<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</body>
