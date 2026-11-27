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
	<div class="header header-fixed">
        <div class="page-title page-title-large mt-3">
            <h2 data-username="" class="greeting-text"></h2>
            <h2 id="NamaPengguna" class="greeting-text"></h2>
			<script type="text/javascript">
				$("#NamaPengguna").load('php/cek_nama_pengguna.php');
			</script>
            <a href="#" data-menu="menu-main" class="bg-fade-gray1-dark shadow-xl preload-img" data-src="../foto_users/<?php echo $row['id']; ?>.png"></a>
		</div>
        <div class="card header-card shape-rounded" data-card-height="150">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
			<div class="card-bg preload-img mt-n3" data-src="../images/logo_bumdes.png?v=20261127"></div>
			
        </div>
		
		<!-- Search-->
		<div class="content mt-n3">
            <div class="search-box rounded-xl bottom-0 bg-white color-blue2-dark">
                <i class="fa fa-search"></i>
                <input type="text" class="border-0" placeholder="Search... (ketikkan nama, nik, atau hp)" data-search>
            </div>			
            
                
					<div id="CariAnggota"></div>
						<script type="text/javascript">
							$("#CariAnggota").load('php/anggota_cari.php');
						</script>

        </div>
			
	</div>

    <div id="footer-bar" class="footer-bar-5">
        <a href="index_transaksi.php"><i data-feather="trending-up" data-feather-line="2" data-feather-size="21" data-feather-color="brown1-dark" data-feather-bg="red2-fade-light"></i><span>Transaksi</span></a>
        <a href="index_jurnal.php"><i data-feather="repeat" data-feather-line="2" data-feather-size="21" data-feather-color="red2-dark" data-feather-bg="red2-fade-light"></i><span>Jurnal</span></a>
        <a href="index_home.php" class="active-nav"><i data-feather="home" data-feather-line="2" data-feather-size="21" data-feather-color="blue2-dark" data-feather-bg="blue2-fade-light"></i><span>Home</span></a>
        <a href="index_manajemen.php"><i data-feather="server" data-feather-line="2" data-feather-size="21" data-feather-color="green1-dark" data-feather-bg="green1-fade-light"></i><span>Manajemen</span></a>
        <a href="#" data-menu="menu-main"><i data-feather="user-check" data-feather-line="2" data-feather-size="21" data-feather-color="gray2-dark" data-feather-bg="gray2-fade-light"></i><span>Akun</span></a>
    </div>
    
    <div class="page-content mt-0">
		   <!-- Icon-->
		   <div class="card-body mt-5">&nbsp;</div>
		   <div class="card card-style">
				<div class="content mt-5 mb-n5">
					<div class="row">
						<div class="chart-container col-6" style="width:50%; height:175px;">
							<canvas class="chart" id="ChartFinance"/></canvas>
						</div>
						<div class="chart-container col-6" style="width:50%; height:160px;">
							<canvas class="chart" id="ChartLabaRugi"/>
						</div>
						<script type="text/javascript">
							$("#ChartFinance").load('php/chart_finance.php');
							$("#ChartLabaRugi").load('php/chart_finance.php');
						</script>
						
					</div>
				</div>
			</div>
		   <div class="card card-style">
            <div class="content mb-0">
                    <div class="row mb-3">
                        <div class="col-7">
                            <i class="float-left mr-1" 
                               data-feather="globe" 
                               data-feather-line="1" 
                               data-feather-size="35" 
                               data-feather-color="blue2-dark" 
                               data-feather-bg="blue2-fade-light">
                            </i>
                            <h5 class="color-black float-left font-13 font-400 line-height-s pb-3 mb-3">
								<div class="font-15 font-500" id="Asset">
										<script type="text/javascript">
											$("#Asset").load('php/cek_asset.php');
										</script>
									</div>
								Assets
							</h5>
                        </div>
                        <div class="col-5">
                            <i class="float-left mr-1" 
                               data-feather="user-plus" 
                               data-feather-line="1" 
                               data-feather-size="35" 
                               data-feather-color="green2-dark" 
                               data-feather-bg="green2-fade-light">
                            </i>
                            <h5 class="color-black float-left font-13 font-400 line-height-s pb-3 mb-3">
								<div class="font-15 font-500 text-center" id="Debitur">
									<script type="text/javascript">
										$("#Debitur").load('php/cek_debitur.php');
									</script>
								</div>
								Debitur
							</h5>
                        </div>
                        <div class="col-7">
                            <i class="float-left mr-1" 
                               data-feather="box" 
                               data-feather-line="1" 
                               data-feather-size="35" 
                               data-feather-color="brown2-dark" 
                               data-feather-bg="brown2-fade-light">
                            </i>
                            <h5 class="color-black float-left font-13 font-300 line-height-s">
								<div class="font-15 font-500" id="Surplus">
									<script type="text/javascript">
										$("#Surplus").load('php/cek_surplus.php');
									</script>
								</div>
								Surplus
							</h5>
                        </div>
                        <div class="col-5">
                            <i class="float-left mr-1" 
                               data-feather="user-minus" 
                               data-feather-line="1" 
                               data-feather-size="35" 
                               data-feather-color="red2-dark" 
                               data-feather-bg="red2-fade-light">
                            </i>
                            <h5 class="color-black float-left font-13 font-300 line-height-s">
								<div class="font-15 font-500 text-center" id="Kreditur">
									<script type="text/javascript">
										$("#Kreditur").load('php/cek_kreditur.php');
									</script>
								</div>
								Kreditur
							</h5>
                        </div>
                    
                    </div>
                </div>
			</div>
			<div class="content mt-n2 mb-n3 ml-4 mr-4">
            <h5 class="float-left color-gray2-dark font-14 font-400">Proposal Dalam Proses</h5>
            <a class="float-right font-12 color-highlight mt-n1" href="#"><-- Geser --></a>
            <div class="clearfix"></div>
		   </div>
		   <div class="card-body double-slider text-center owl-carousel owl-no-dots">
				<div class="item bg-theme rounded-m shadow-m">
					<i class="mt-3" data-feather="users" data-feather-line="1" data-feather-size="30" data-feather-color="green2-dark" data-feather-bg="green2-fade-light"></i>
						<span class="font-16" id="CekDPR">
							<script type="text/javascript">
								$("#CekDPR").load('php/cek_dpr.php');
							</script>
						</span>
					<p class="line-height-s font-12 mb-3">
						Pengajuan<br>Permohonan
					</p>
				</div>
				<div class="item bg-theme rounded-m shadow-m">
					<i class="mt-3" data-feather="edit" data-feather-line="1" data-feather-size="30" data-feather-color="red2-dark" data-feather-bg="red2-fade-light"></i>
						<span class="font-16" id="CekRekomendasiAnalis">
							<script type="text/javascript">
								$("#CekRekomendasiAnalis").load('php/cek_rekomendasi_analis.php');
							</script>
						</span>
					<p class="line-height-s font-12 mb-3">
						Rekomendasi<br>Analis
					</p>
				</div>
				<div class="item bg-theme rounded-m shadow-m">
					<i class="mt-3" data-feather="check-circle" data-feather-line="1" data-feather-size="30" data-feather-color="blue2-dark"  data-feather-bg="blue2-fade-light"></i>
						<span class="font-16" id="CekRekomendasiKepala">
							<script type="text/javascript">
								$("#CekRekomendasiKepala").load('php/cek_rekomendasi_kepala.php');
							</script>
						</span>
					<p class="line-height-s font-12 mb-3">
						Approved<br>Kepala <?php echo LEMBAGA_SORT; ?>
					</p>
				</div>
				<div class="item bg-theme rounded-m shadow-m">
					<i class="mt-3" data-feather="check-square" data-feather-line="1" data-feather-size="30" data-feather-color="yellow1-dark" data-feather-bg="yellow1-fade-light"></i>
						<span class="font-16" id="CekRekomendasiBawas">
							<script type="text/javascript">
								$("#CekRekomendasiBawas").load('php/cek_rekomendasi_bawas.php');
							</script>
						</span>
					<p class="line-height-s font-12 mb-3">
						Approved<br>Bawas
					</p>
				</div>
				<div class="item bg-theme rounded-m shadow-m">
					<i class="mt-3" data-feather="log-in" data-feather-line="1" data-feather-size="30" data-feather-color="brown2-dark" data-feather-bg="brown2-fade-light"></i>
						<span class="font-16" id="CekWaitingList">
							<script type="text/javascript">
								$("#CekWaitingList").load('php/cek_waiting_list.php');
							</script>
						</span>
					<p class="line-height-s font-12 mb-3">
						Waiting<br>List
					</p>
				</div>
			</div>
			
			<div class="content mt-0 mb-n3 ml-4 mr-4">
            <h5 class="float-left color-gray2-dark font-14 font-400">Jatuh Tempo</h5>
            <div class="clearfix"></div>
		   </div>
		   <div class="card-body ml-3 mr-3">
				<div class="row text-center">
                    <div class="col-4 pl-1 pr-1">
						<a href="index_tagihan.php" class="btn btn-border btn-m btn-full mb-2 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
							<i data-feather="target" 
							   data-feather-line="2" 
							   data-feather-size="30" 
							   data-feather-color="mint-dark" 
							   data-feather-bg="mint-fade-light">
							</i>
						</p>
						Tagihan</a>
                    </div>
					<div class="col-4 pl-1 pr-1">
                        <a href="#" data-menu="menu-warning-1" class="btn btn-border btn-m btn-full mb-2 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
                        <i data-feather="trending-down" 
                           data-feather-line="2" 
                           data-feather-size="30" 
                           data-feather-color="red1-dark" 
                           data-feather-bg="red1-fade-light">
                        </i>
                    </p>
						Menunggak</a>
                    </div>
					<div class="col-4 pl-1 pr-1">
                        <a href="#" data-menu="menu-warning-1" class="btn btn-border btn-m btn-full mb-2 text-center rounded-sm font-400 border-gray2-dark">
						<p class="center-text mb-1">
                        <i data-feather="alert-triangle" 
                           data-feather-line="2" 
                           data-feather-size="30" 
                           data-feather-color="orange-dark" 
                           data-feather-bg="orange-fade-light">
                        </i>
                    </p>
						Reminder</a>
                    </div>
				</div>
			</div>
		<!--	
			<div class="content mt-n5 mb-n3 ml-4 mr-4">
				<h5 class="float-left color-gray2-dark font-14 font-400">Tugas Anda</h5>
				<a class="float-right font-12 color-highlight mt-n1" href="#"><-- Geser --</a>
				<div class="clearfix"></div>
		   </div>
				<div id="TugasAnda"></div>
				<script type="text/javascript">
					$("#TugasAnda").load('php/tugas_anda.php');
				</script>
				
		   -->
			
        

        
    </div>    
    <!-- end of page content-->
	
    <div id="menu-share" 
         class="menu menu-box-bottom menu-box-detached rounded-m" 
         data-menu-load="menu-share.html"
         data-menu-height="450" 
         data-menu-effect="menu-over">
    </div>    
    
    <div id="menu-highlights" 
         class="menu menu-box-bottom menu-box-detached rounded-m" 
         data-menu-load="menu-colors.html"
         data-menu-height="510" 
         data-menu-effect="menu-over">        
    </div>
    
    <div id="menu-main"
         class="menu menu-box-right menu-box-detached rounded-m"
         data-menu-width="260"
         data-menu-load="menu-main.html"
         data-menu-active="nav-welcome"
         data-menu-effect="menu-over">  
    </div>
		

<div id="menu-warning-1" class="menu menu-box-bottom menu-box-detached rounded-m" 
         data-menu-height="305"
         data-menu-effect="menu-over">
        <h1 class="text-center mt-4"><i class="fa fa-3x fa-times color-red2-dark"></i></h1>
        <h1 class="text-center mt-3 text-uppercase font-700">Maaf!</h1>
        <p class="boxed-text-l">
             Fitur ini masih dalam pengembangan, silahkan gunakan beberapa saat lagi.
        </p>
        <a href="#" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-red1-light">OK</a>
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