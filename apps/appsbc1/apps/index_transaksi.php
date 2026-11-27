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
        <a href="index_transaksi.php" class="active-nav"><i data-feather="trending-up" data-feather-line="2" data-feather-size="21" data-feather-color="brown1-dark" data-feather-bg="red2-fade-light"></i><span>Transaksi</span></a>
        <a href="index_jurnal.php"><i data-feather="repeat" data-feather-line="2" data-feather-size="21" data-feather-color="red2-dark" data-feather-bg="red2-fade-light"></i><span>Jurnal</span></a>
        <a href="index_home.php"><i data-feather="home" data-feather-line="2" data-feather-size="21" data-feather-color="blue2-dark" data-feather-bg="blue2-fade-light"></i><span>Home</span></a>
        <a href="index_manajemen.php"><i data-feather="server" data-feather-line="2" data-feather-size="21" data-feather-color="green1-dark" data-feather-bg="green1-fade-light"></i><span>Manajemen</span></a>
        <a href="#" data-menu="menu-main"><i data-feather="user-check" data-feather-line="2" data-feather-size="21" data-feather-color="gray2-dark" data-feather-bg="gray2-fade-light"></i><span>Akun</span></a>
    </div>
    
    <div class="page-content"  style="min-height:60vh!important">
		<div class="page-title page-title-small">
            <h2><a href="index_home.php"><i class="fa fa-arrow-left"></i></a>Transaksi</h2>
        </div>
        <div class="card header-card shape-rounded" data-card-height="120">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="../images/logo_bumdes.png?v=20261127"></div>
        </div>
		
		<!-- Saldo dan Tombol Top UP-->
			<div class="card-body">
				<div class="card card-style mt-n4 ml-0 mr-0 bg-white">
                    <div class="row mt-3 pt-1 mb-3">
                        <div class="col-7">
                            <i class="float-left ml-3 mr-3" 
                               data-feather="user" 
                               data-feather-line="1" 
                               data-feather-size="35" 
                               data-feather-color="blue2-dark" 
                               data-feather-bg="blue2-fade-light">
                            </i>
								<p class="line-height-s font-11">ID User:<br>
									<span class="color-black float-left font-16 font-500 line-height-s pb-3 mb-0" id="IDUser">
										<script type="text/javascript">
											$("#IDUser").load('php/id_user.php');
										</script>
									</span>
								</p>
                        </div>
                        <div class="col-5">
							<a href="index_jurnal.php" class="btn btn-border btn-sm mr-3 rounded-s btn-full shadow-l color-highlight border-highlight text-uppercase font-500">Jurnal Saya</a>
						</div>
                    </div>
                </div>
           </div>
		   
		   <div class="card-body mt-n4">
				<div class="row text-center">
                    
					<div class="col-12">
                        <a href="transaksi_angsuran.php" class="btn btn-border btn-m btn-full mb-2 text-center rounded-sm font-400 border-mint-dark shadow-l bg-white">
						<p class="center-text mb-1">
                        <i data-feather="archive" 
                           data-feather-line="2" 
                           data-feather-size="30" 
                           data-feather-color="mint-dark" 
                           data-feather-bg="mint-fade-light">
                        </i>
                    </p>
						<h5 class="font-16 font-500">Transaksi Angsuran</h5></a>
                    </div>
					
					<div class="col-12">
                        <a href="transaksi_simpanan.php" class="btn btn-border btn-m btn-full mb-2 text-center rounded-sm font-400 border-green1-dark shadow-l bg-white">
						<p class="center-text mb-1">
                        <i data-feather="archive" 
                           data-feather-line="2" 
                           data-feather-size="30" 
                           data-feather-color="green1-dark-dark" 
                           data-feather-bg="green1-fade-light">
                        </i>
                    </p>
						<h5 class="font-16 font-500">Transaksi Simpanan Umum</h5></a>
                    </div>
					
					<!--
					<div class="col-12">
						<a href="transaksi_umum.php" class="btn btn-border btn-m btn-full mb-2 text-center rounded-sm font-400 border-orange-dark shadow-l bg-white">
						<p class="center-text mb-1">
							<i data-feather="archive" 
							   data-feather-line="2" 
							   data-feather-size="30" 
							   data-feather-color="orange-dark" 
							   data-feather-bg="orange-fade-light">
							</i>
						</p>
						<h5 class="font-16 font-500">Transaksi Operasional</h5></a>
                    </div>
					-->
					
				</div>
			</div>  
    </div>    
    <!-- end of page content-->
   
    <div id="menu-warning-1" class="menu menu-box-bottom menu-box-detached rounded-m" 
         data-menu-height="305"
         data-menu-effect="menu-over">
        <h1 class="text-center mt-4"><i class="fa fa-3x fa-times color-red2-dark"></i></h1>
        <h1 class="text-center mt-3 text-uppercase font-700">Maaf!</h1>
        <p class="boxed-text-l">
             Fitur sedang dalam pengembangan, silahkan buka beberapa saat lagi.
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