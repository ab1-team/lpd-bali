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
    
    <!-- header and footer bar go here-->
    <div id="footer-bar" class="footer-bar-5">
        <a href="index_transaksi.php"><i data-feather="trending-up" data-feather-line="2" data-feather-size="21" data-feather-color="brown1-dark" data-feather-bg="red2-fade-light"></i><span>Transaksi</span></a>
        <a href="index_jurnal.php"><i data-feather="repeat" data-feather-line="2" data-feather-size="21" data-feather-color="red2-dark" data-feather-bg="red2-fade-light"></i><span>Jurnal</span></a>
        <a href="index_home.php"><i data-feather="home" data-feather-line="2" data-feather-size="21" data-feather-color="blue2-dark" data-feather-bg="blue2-fade-light"></i><span>Home</span></a>
        <a href="index_manajemen.php"><i data-feather="server" data-feather-line="2" data-feather-size="21" data-feather-color="green1-dark" data-feather-bg="green1-fade-light"></i><span>Manajemen</span></a>
        <a href="#" data-menu="menu-main"><i data-feather="user-check" data-feather-line="2" data-feather-size="21" data-feather-color="gray2-dark" data-feather-bg="gray2-fade-light"></i><span>Akun</span></a>
    </div>
    
    <div class="page-content" style="min-height:60vh!important">
        <div class="page-title page-title-small">
            <h2><a href="index_home.php"><i class="fa fa-arrow-left"></i></a>Tagihan Hari Ini</h2>
        </div>
        <div class="card header-card shape-rounded" data-card-height="120">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="../images/logo_bumdes.png?v=20261127"></div>
        </div>
		
		<!-- Saldo dan Tombol Top UP-->
			<div class="card-body">
				<div class="card card-style mt-n4 ml-0 mr-0 bg-white">
                    <div class="row mt-3 pl-3 pt-1 mb-0">
                        <div class="col-12">
								<p class="line-height-s font-11">Tagihan berdasarkan pencairan tanggal
									<span id="hasil">
										<script>
											var tanggal = new Date().getDate();
											document.getElementById("hasil").innerHTML = tanggal;
										</script>
									</span> jika <?php echo LEMBAGA_SORT; ?> memiliki toleransi angsuran, mungkin data telah masuk pada fitur menunggak
								</p>
                        </div>
                    </div>
                </div>
           </div>
		   
			
            <div class="content mt-n4">
				<div class="list-group list-boxes" id="TampilTagihan">
					<script>
						$("#TampilTagihan").load('php/tampil_tagihan.php');
					</script>   
                </div>
            </div>
           
    </div> 
    <!-- end of page content-->
	
	<div id="rekap_transaksi" class="menu menu-box-modal rounded-m" 
         data-menu-height="400" 
         data-menu-width="310">
        <div id="RekapTransaksi"></div>
			<script>
				$("#RekapTransaksi").load('php/transaksi_rekap.php');
			</script> 
	</div> 
	
    
    <div id="menu-main"
         class="menu menu-box-right menu-box-detached rounded-m"
         data-menu-width="260"
         data-menu-load="menu-main.html"
         data-menu-active="nav-welcome"
         data-menu-effect="menu-over">  
    </div>  

<div id="notifikasi_transaksi" class="menu menu-box-modal rounded-m" 
         data-menu-height="300" 
         data-menu-width="310">
        <h1 class="text-center mt-3 pt-1"><i class="fa fa-3x fa-check-circle color-green1-dark shadow-xl rounded-circle"></i></h1>
        <h1 class="text-center mt-3 font-700">Berhasil</h1>
        <p class="boxed-text-l">
			Transaksi ini telah berhasil
        </p>
        <a href="#" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-green1-light">Oke</a>
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