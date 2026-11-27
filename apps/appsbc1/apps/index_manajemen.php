<?php session_start();
include "../inc/inc.koneksi.php";
if(isset($_SESSION['id'])){
$user_id	= $_SESSION['id'];
$row=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$user_id' "));
 ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>SIM <?php echo LEMBAGA_SORT; ?> Bali</title>
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

    <div id="footer-bar" class="footer-bar-5">
        <a href="index_transaksi.php"><i data-feather="trending-up" data-feather-line="2" data-feather-size="21" data-feather-color="brown1-dark" data-feather-bg="red2-fade-light"></i><span>Transaksi</span></a>
        <a href="index_jurnal.php"><i data-feather="repeat" data-feather-line="2" data-feather-size="21" data-feather-color="red2-dark" data-feather-bg="red2-fade-light"></i><span>Jurnal</span></a>
        <a href="index_home.php"><i data-feather="home" data-feather-line="2" data-feather-size="21" data-feather-color="blue2-dark" data-feather-bg="blue2-fade-light"></i><span>Home</span></a>
        <a href="index_manajemen.php" class="active-nav"><i data-feather="server" data-feather-line="2" data-feather-size="21" data-feather-color="green1-dark" data-feather-bg="green1-fade-light"></i><span>Manajemen</span></a>
        <a href="#" data-menu="menu-main"><i data-feather="user-check" data-feather-line="2" data-feather-size="21" data-feather-color="gray2-dark" data-feather-bg="gray2-fade-light"></i><span>Akun</span></a>
    </div>
    
    <div class="page-content"  style="min-height:60vh!important">
		<div class="page-title page-title-small">
            <h2><a href="index_home.php"><i class="fa fa-arrow-left"></i></a>Manajemen</h2>
        </div>
        <div class="card header-card shape-rounded" data-card-height="75">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="../images/logo_bumdes.png"></div>
        </div>
		
		   
		   <div class="card-body ml-3 mr-3">
		   
		   <p class="text-center">SEDANG DALAM PENGEMBANGAN, SILAHKAN KUNJUNGI BEBERAPA SAAT LAGI</p>
		   <!--
		   
				<div class="row text-center">
                    <div class="col-4 pl-1 pr-1">
						<a href="#" data-menu="menu-warning-1" class="btn btn-border btn-m btn-full mb-2 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
							<i data-feather="archive" 
							   data-feather-line="2" 
							   data-feather-size="30" 
							   data-feather-color="mint-dark" 
							   data-feather-bg="mint-fade-light">
							</i>
						</p>
						DEPOSIT</a>
                    </div>
					<div class="col-4 pl-1 pr-1">
                        <a href="index_transfer.php" class="btn btn-border btn-m btn-full mb-2 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
                        <i data-feather="external-link" 
                           data-feather-line="2" 
                           data-feather-size="30" 
                           data-feather-color="orange-dark" 
                           data-feather-bg="orange-fade-light">
                        </i>
                    </p>
						TRANSFER</a>
                    </div>
					<div class="col-4 pl-1 pr-1">
                        <a href="#" data-menu="menu-warning-1" class="btn btn-border btn-m btn-full mb-2 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
                        <i data-feather="shopping-bag" 
                           data-feather-line="2" 
                           data-feather-size="30" 
                           data-feather-color="green1-dark" 
                           data-feather-bg="green1-fade-light">
                        </i>
                    </p>
						PRODUK</a>
                    </div>
					
					<div class="col-4 pl-1 pr-1">
                        <a href="#" data-menu="menu-warning-1" class="btn btn-border btn-m btn-full mb-3 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
							<i data-feather="user-plus" 
							   data-feather-line="2" 
							   data-feather-size="30" 
							   data-feather-color="pink2-dark" 
							   data-feather-bg="pink2-fade-light">
							</i>
						</p>
						DAFTARKAN AGEN</a>
                    </div>
					
					<div class="col-4 pl-1 pr-1">
                        <a href="#" data-menu="menu-warning-1" class="btn btn-border btn-m btn-full mb-3 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
                        <i data-feather="sliders" 
                           data-feather-line="2" 
                           data-feather-size="30" 
                           data-feather-color="yellow2-dark" 
                           data-feather-bg="yellow2-fade-light">
                        </i>
                    </p>
						LIST DOWNLINE</a>
                    </div>
					
					<div class="col-4 pl-1 pr-1">
                        <a href="#" data-menu="menu-warning-1" class="btn btn-border btn-m btn-full mb-3 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
                        <i data-feather="bar-chart-2" 
                           data-feather-line="2" 
                           data-feather-size="30" 
                           data-feather-color="blue2-dark" 
                           data-feather-bg="blue2-fade-light">
                        </i>
                    </p>
						TRANSAKSI DOWNLINE</a>
                    </div>
					
					<div class="col-4 pl-1 pr-1">
                        <a href="#" data-menu="menu-warning-1" class="btn btn-border btn-m btn-full mb-3 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
                        <i data-feather="printer" 
                           data-feather-line="2" 
                           data-feather-size="30" 
                           data-feather-color="green2-dark" 
                           data-feather-bg="green2-fade-light">
                        </i>
                    </p>
						STRUK</a>
                    </div>
					<div class="col-4 pl-1 pr-1">
                        <a href="#" data-menu="menu-warning-1" class="btn btn-border btn-m btn-full mb-3 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
                        <i data-feather="radio" 
                           data-feather-line="2" 
                           data-feather-size="30" 
                           data-feather-color="brown2-dark" 
                           data-feather-bg="brown2-fade-light">
                        </i>
                    </p>
						INFORMASI</a>
                    </div>
					
					<div class="col-4 pl-1 pr-1">
                        <a href="#" data-menu="menu-warning-1" class="btn btn-border btn-m btn-full mb-2 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
                        <i data-feather="user-check" 
                           data-feather-line="2" 
                           data-feather-size="30" 
                           data-feather-color="magenta1-dark" 
                           data-feather-bg="magenta1-fade-light">
                        </i>
                    </p>
						AKUN</a>
                    </div>
					
					<div class="col-4 pl-1 pr-1">
                        <a href="#" data-menu="menu-warning-1" class="btn btn-border btn-m btn-full mb-3 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
                        <i data-feather="headphones" 
                           data-feather-line="2" 
                           data-feather-size="30" 
                           data-feather-color="teal-dark" 
                           data-feather-bg="teal-fade-light">
                        </i>
                    </p>
						CS</a>
                    </div>
					<div class="col-4 pl-1 pr-1">
                        <a href="#" data-menu="menu-warning-1" class="btn btn-border btn-m btn-full mb-3 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
                        <i data-feather="mail" 
                           data-feather-line="2" 
                           data-feather-size="30" 
                           data-feather-color="yellow1-dark" 
                           data-feather-bg="yellow1-fade-light">
                        </i>
                    </p>
						PESAN</a>
                    </div>
					
					<div class="col-4 pl-1 pr-1">
                        <a href="#" data-menu="menu-warning-1" class="btn btn-border btn-m btn-full mb-3 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
							<i data-feather="message-square" 
							   data-feather-line="2" 
							   data-feather-size="30" 
							   data-feather-color="brown1-dark" 
							   data-feather-bg="brown1-fade-light">
							</i>
						</p>
						CHAT</a>
                    </div>
					
				</div>
			</div>  
			
			-->
    </div>    
    <!-- end of page content-->
   
    <div id="menu-warning-1" class="menu menu-box-bottom menu-box-detached rounded-m" 
         data-menu-height="305"
         data-menu-effect="menu-over">
        <h1 class="text-center mt-4"><i class="fa fa-3x fa-times color-red2-dark"></i></h1>
        <h1 class="text-center mt-3 text-uppercase font-700">Maaf!</h1>
        <p class="boxed-text-l">
             Untuk sementara anda tidak dapat mengakses fitur ini, silahkan hubungi Customer Service kami.
        </p>
        <a href="#" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-red1-light">OK</a>
    </div>
	
    <div id="menu-main"
         class="menu menu-box-right menu-box-detached rounded-m"
         data-menu-width="260"
         data-menu-load="menu-main.html"
         data-menu-active="nav-welcome"
         data-menu-effect="menu-over">  
    </div>

    
</div>    


<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</body>

<?php }else{
	
	include "landing.php";
}

?>