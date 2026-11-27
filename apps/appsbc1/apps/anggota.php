<?php session_start();
include "../inc/inc.koneksi.php";
include "../inc/fungsi_simpanan_individu.php";
include "../inc/fungsi_pinjaman_individu.php";
if(isset($_SESSION['id'])){
$nia	= $_GET['nia'];
$row=mysql_fetch_array(mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] WHERE id='$nia' "));
$nik	=$row['nik'];
$id=$row['id'];
if($id<9){$cif="000$id";}else if($id<99){$cif="00$id";}else if($id<999){$cif="0$id";}else{$cif="$id";}
$tgl =date('Y-m-d');

$file="../foto_anggota/$row[id].png";
				if(file_exists($file)){
					$foto="../foto_anggota/$row[id].png";
				}else{
					$foto="../img/avatar.png";
				}
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
    <div id="footer-bar" class="footer-bar-1">
		<a href="index_home.php" class="btn btn-m btn-full rounded-0 shadow-l bg-blue2-dark text-uppercase"><span class="font-16 mt-1">Kembali</span></a>
	</div>
    
    <div class="page-content" style="min-height:60vh!important">

        <div class="card header-card shape-rounded" data-card-height="120">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="../images/logo_bumdes.png?v=20261127"></div>
        </div>

<?php

echo '		

	<div data-card-height="200" class="card card-style bg-14 mt-2">
            <div class="card-center ml-3">
                <h1 class="color-white mb-0">'.$row['namadepan'].'</h1>
                <p class="color-white opacity-50 mb-0 font-12">'.substr($nik,0,4).' '.substr($nik,4,4).' '.substr($nik,8,4).' '.substr($nik,12,4).' / '.$cif.'</p>
                <p class="color-white opacity-50 mb-0 font-12">'.$row['alamat'].', '.$row['hp'].'</p>
            </div>
            <div class="card-center">
                <h1 class="text-right color-white font-40 bolder pr-3">
					<img src="'.$foto.'" width="50" class="mr-3 mt-1 bg-black opacity-70 rounded-xl">
				</h1>
            </div>
            <div class="card-bottom pl-3">
                <p class="mb-3 font-8 font-500 opacity-50 color-white">Exp: 10/22</p>
            </div>       
            <div class="card-bottom pr-3 pb-3 ">
                <i class="float-right fa fa-wifi font-10 rotate-90"></i>
            </div>
            <div class="card-overlay bg-black opacity-70"></div>
        </div>
		   
';

$cek_su	=mysql_query("SELECT * FROM simpanan_anggota_$_SESSION[kd_kab] WHERE nia='$nia' AND jenis_simpanan='1' ");
$ada_su	=mysql_num_rows($cek_su);
	
	if ($ada_su > 0){
		
		while($r=mysql_fetch_array($cek_su)) {

echo '		   
		<div class="card card-style">
            <div class="content mb-2 mt-1">
                <div class="list-custom-large">
                    <a href="#">
                        <i class="fa fa-wallet rounded-xl shadow-s bg-green2-dark"></i>
                        <span>'.$r['nomor_rekening'].'</span>
                        <strong>Simpanan Umum</strong>
                        <span class="badge bg-green2-light font-11">'.number_format(saldosimpanan("$tgl-$r[id]"),0,',','.').' IDR</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
';
		}
	}
	
$cek_sd	=mysql_query("SELECT * FROM simpanan_anggota_$_SESSION[kd_kab] WHERE nia='$nia' AND jenis_simpanan='2' ");
$ada_sd	=mysql_num_rows($cek_sd);
	
	if ($ada_sd > 0){
		
		while($r=mysql_fetch_array($cek_sd)) {

echo '		   
		<div class="card card-style">
            <div class="content mb-2 mt-1">
                <div class="list-custom-large">
                    <a href="#">
                        <i class="fa fa-wallet rounded-xl shadow-s bg-blue2-dark"></i>
                        <span>'.$r['nomor_rekening'].'</span>
                        <strong>Simpanan Berjangka</strong>
                        <span class="badge bg-blue2-light font-11">'.number_format(saldosimpanan("$tgl-$r[id]"),0,',','.').' IDR</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
';
		}
	}
	
$cek_pu	=mysql_query("SELECT * FROM pinjaman_anggota_$_SESSION[kd_kab] WHERE nia='$nia' ");
$ada_pu	=mysql_num_rows($cek_pu);
	
	if ($ada_pu > 0){
		
		while($r=mysql_fetch_array($cek_pu)) {

echo '		   
		<div class="card card-style">
            <div class="content mb-2 mt-1">
                <div class="list-custom-large">
                    <a href="#">
                        <i class="fa fa-wallet rounded-xl shadow-s bg-red2-dark"></i>
                        <span>'.$r['no_rekening'].'</span>
                        <strong>Pinjaman</strong>
                        <span class="badge bg-red2-light font-11">'.number_format(saldopinjaman("$tgl-$r[id]"),0,',','.').' IDR</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
';
		}
	}
?>


    
</div>    


<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</body>

<?php }else{
	
	include "landing.php";
}

?>