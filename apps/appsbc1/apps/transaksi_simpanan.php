<?php session_start();
include "../inc/inc.koneksi.php";
if(isset($_SESSION['id'])){
$user_id	= $_SESSION['id'];
$row=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='$user_id' "));

$lokasi	= $_SESSION['lokasi'];
if($lokasi<9){$cif="000$lokasi";}else if($lokasi<99){$cif="00$lokasi";}else if($lokasi<999){$cif="0$lokasi";}else{$cif="$lokasi";}
$norek	="$cif.3.11.";
 ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>SIM LPD BALI</title>
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
		<a href="#" id="SimpanSimpananUmum" data-menu="menu-success-1" class="btn btn-m btn-full rounded-0 shadow-l bg-blue2-dark text-uppercase" disabled="disabled"><span class="font-16 mt-1">Simpan <span id="JenisMutasi"></span></span></a>
	</div>
    
    <div class="page-content"  style="min-height:60vh!important">
		<div class="page-title page-title-small">
            <h2><a href="index_transaksi.php"><i class="fa fa-arrow-left"></i></a>Transaksi Simpanan</h2>
        </div>
        <div class="card header-card shape-rounded" data-card-height="120">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="../images/logo_lpd.png"></div>
        </div>
		
		<!-- Saldo dan Tombol Top UP-->
			<div class="card-body">
				<div class="card card-style mt-n4 ml-0 mr-0 bg-white">
                    <div class="row mt-3 pt-1 mb-3">
                        <div class="col-5">
							<span class="ml-4">No.Rekening</span>
							<div class="input-style input-style-1 input-required ml-4">
								<input id="norek0" value="<?php echo $norek;?>" class="font-18" disabled="disabled">
							</div>
                        </div>
						<div class="col-4 ml-n5">
							<span>&nbsp;</span>
							<div class="input-style input-style-1 input-required">
								<input id="norek" type="tel" placeholder="--4 Digit Terakhir--" class="font-18">
								<input id="nomor_rekening" type="hidden" >
							</div>
                        </div>
                        <div class="col-3">
							<span>&nbsp;</span>
							<a href="#" id="CekNorek" class="btn btn-border btn-sm rounded-s btn-full shadow-l color-highlight border-highlight text-uppercase font-500">Cek</a>
						</div>
                    </div>
                </div>
           </div>
		   
		   <div id="TransaksiAngsuranCek"></div>
		   
		   <script type="text/javascript">
			$("#norek").focus();
			
			$(document).ready(function() {
				
				$("#norek").keyup(function() {
					var norek0		= $('#norek0').val();	
					var norek		= $('#norek').val();	
					document.getElementById("nomor_rekening").value=norek0+norek;		

                });

				$("#CekNorek").click(function() {
					var nomor_rekening		= $('#nomor_rekening').val();	
							
                    $.ajax({
                        type: "POST",
                        url: "php/transaksi_simpanan_cek.php",
                        data: 	"nomor_rekening="+nomor_rekening,
								
						success: function(data) {
							$("#TransaksiAngsuranCek").html(data);
							$("#norek").focus();
							
                        }
                    });

                });
				
				
			$("#SimpanSimpananUmum").click(function() {
				var tgl_transaksi		= $('#tgl_transaksi').val();
				var nia					= $('#nia').val();
				var id_simp_i			= $('#id_simp_i').val();
				var jenis_mutasi		= $('#jenis_mutasi').val();
				var jumlah				= $('#jumlah').val();
				var saldo				= $('#saldo').val();
				var jumtarik 			= document.getElementById("jumlah").value.split('.').join('');
				
				if(jumlah.length==0 || jumlah==0){ $("#Notifikasi").html("<p class='text-center color-red2-dark mt-5'>NOMINAL TIDAK BOLEH KOSONG</p>"); return false; }
				
				if(jenis_mutasi=="tarik" && +saldo < jumtarik){
					$("#Notifikasi").html("<p class='text-center color-red2-dark mt-5'>SALDO TIDAK MENCUKUPI</p>"); return false;
						}
					
					$.ajax({
						type: "POST",
						url: "php/transaksi_simpanan_simpan.php",
						data: 	"id_simp_i="+id_simp_i+
								"&tgl_transaksi="+tgl_transaksi+
								"&nia="+nia+
								"&jenis_mutasi="+jenis_mutasi+
								"&jumlah="+jumlah,
						success: function(data) {
							$("#menu-success-1").html(data);
						}
					});
				
			});	
							
			});
			</script>
		   
		     
    </div>    
    <!-- end of page content-->
	
	<div id="menu-success-1" class="menu menu-box-bottom menu-box-detached rounded-m" 
         data-menu-height="420" 
         data-menu-effect="menu-over">
		 <div id="Notifikasi"></div>
	</div>
	
   
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
         data-menu-width="350"
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