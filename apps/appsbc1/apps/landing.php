<?php session_destroy(); include "../inc/inc.koneksi.php"; ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title><?php echo strtoupper(LEMBAGA_SORT); ?> BALI</title>
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
    
    <div class="page-content pb-0">
        
        <div class="card" data-card-height="cover">
            <div class="card-top mt-5 pt-3 text-center">
                <img src="../images/logo_bumdes.png" width="100px">
            </div>
            <div class="card-center">
                <p class="boxed-text-xl pt-4 color-white font-16 line-height-sm font-400">
                    Om swastyastu,<br>
					Selamat datang di <?php echo LEMBAGA_SORT; ?> Apps<br>
					kemudahan pengelolaan <?php echo LEMBAGA_LONG; ?> dalam satu genggaman.
                </p>
            </div>
            <div class="card-bottom">
                <div class="row">
                    <div class="col-12">
                        <a href="login.php" class="btn btn-center-m btn-m btn-border border-gray1-dark color-white rounded-sm font-900 text-uppercase">Masuk</a>
                    </div>
                </div>
            </div>
            <div class="card-overlay bg-highlight"></div>
            <div class="card-overlay bg-theme opacity-20"></div>
        </div>
        
    </div>    
    <!-- end of page content-->

    
</div>    


<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>
</body>
