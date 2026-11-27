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
    <div id="footer-bar" class="footer-bar-1">
		<a href="#" id="TombolTransfer" class="btn btn-m btn-full rounded-0 shadow-l bg-blue2-dark text-uppercase"><span class="font-16 mt-1">Transfer</span></a>
	</div>
    
    <div class="page-content" style="min-height:60vh!important">
        <div class="page-title page-title-small">
            <h2><a href="#" data-back-button><i class="fa fa-arrow-left"></i></a>Transaksi Umum</h2>
        </div>
        <div class="card header-card shape-rounded" data-card-height="120">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="../images/logo_bumdes.png"></div>
        </div>
		
		<!-- Saldo dan Tombol Top UP-->
			<div class="card-body">
				<div class="card card-style mt-n4 ml-0 mr-0 bg-white">
				<div class="content mt-n2">
                  <div class="row mt-4 pt-1 mb-3">
					<div class="col-12">
					<div class="input-style input-style-2 input-required">
						<span>Jenis Transaksi</span>
						<em><i class="fa fa-angle-down"></i></em>
						<select class="form-control" id="jenis_transaksi"  name="jenis_transaksi">
							<option value="">-- Pilih Jenis Transaksi --</option>
											<?php 
												$view=mysql_query("select * from jenis_transaksi"); //Buku Kecil
												while($row=mysql_fetch_array($view)){
													echo "<option value='$row[id]'>$row[nama_jt]</option>";
											} ?>
						</select>
					</div>
					
					<div class="input-style input-style-2 input-required">
						<span>Sumber Dana</span>
						<em><i class="fa fa-angle-down"></i></em>
						<select class="form-control" id="rekening_1"  name="rekening_1">
							<option value=""></option>
						</select>
					</div>
					
					<div class="input-style input-style-2 input-required">
						<span><div id="InfoTrx"></div></span>
						<em><i class="fa fa-angle-down"></i></em>
						<select class="form-control" id="rekening_2"  name="rekening_2">
							<option value=""></option>
						</select>
					</div>
					
					<div id="FormNominal"></div>
								<div id="konfirmasi"></div>
                       
					
<script type="text/javascript">

$(document).ready(function(){
  //apabila terjadi event onchange terhadap object <select id=jenis_rekening>
$("#InfoTrx").html('Disimpan ke');

  $("#jenis_transaksi").change(function(){
    var jenis_transaksi = $("#jenis_transaksi").val();
	
		 if(jenis_transaksi==1){$("#InfoTrx").html('Disimpan ke');}
	else if(jenis_transaksi==2){$("#InfoTrx").html('Untuk Keperluan');}
	else if(jenis_transaksi==3){$("#InfoTrx").html('Rekening Tujuan');}
	
    $.ajax({
        url: "../modul/jurnal/ambil_rekening_1.php",
        data: "jenis_transaksi="+jenis_transaksi,
        cache: false,
        success: function(msg){
            $("#rekening_1").html(msg);
        }
    });
	
	$.ajax({
        url: "../modul/jurnal/ambil_rekening_2.php",
        data: "jenis_transaksi="+jenis_transaksi,
        cache: false,
        success: function(msg){
            $("#rekening_2").html(msg);
        }
    });
	
  });
  
  
					  
				
//$("#TampilJurnal").load('modul/jurnal/tampil_jurnal.php');
$("#FormNominal").load('../modul/jurnal/form_nominal.php');
//$("#TampilSaldo").load('modul/jurnal/tampil_saldo.php');
				
					
					
	$("#rekening_1").change(function(){
		var rekening_1 = $("#rekening_1").val();
		var rekening_2 = $("#rekening_2").val();
		var jenis_transaksi = $("#jenis_transaksi").val();
		
		$.ajax({
			type	: "POST",
			url		: "../modul/jurnal/form_nominal.php",
			data	: "rekening_1="+rekening_1+
						"&rekening_2="+rekening_2+
						"&jenis_transaksi="+jenis_transaksi,
			success: function(data){
				$("#TampilSaldo").load('../modul/jurnal/tampil_saldo.php');
				$("#FormNominal").html(data);
			}
		});
		
	  });
	  
	  
	  
	  $("#rekening_2").change(function(){
		var rekening_1 = $("#rekening_1").val();
		var rekening_2 = $("#rekening_2").val();
		var jenis_transaksi = $("#jenis_transaksi").val();
		
		$.ajax({
			type	: "POST",
			url		: "../modul/jurnal/form_nominal.php",
			data	: "rekening_1="+rekening_1+
						"&rekening_2="+rekening_2+
						"&jenis_transaksi="+jenis_transaksi,
			success: function(data){
				$("#FormNominal").html(data);
			}
		});
		
	  });
					
				

				
});

</script>
					
					
				 </div> 
                    </div>
                </div>
                </div>
           </div>

           
    </div> 
    <!-- end of page content-->
	

    
</div>    


<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</body>

<?php }else{
	
	include "landing.php";
}

?>