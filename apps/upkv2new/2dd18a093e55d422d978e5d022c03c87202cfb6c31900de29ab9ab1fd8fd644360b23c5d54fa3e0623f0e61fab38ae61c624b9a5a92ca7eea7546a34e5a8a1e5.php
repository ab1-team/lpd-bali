<?php session_start(); 
if(isset($_SESSION['id'])){
	$id_user=ucfirst($_SESSION['id']);

include "inc/inc.koneksi.php";
	
 $kec=mysql_fetch_array(mysql_query("select * from kecamatan where id='$_SESSION[lokasi]' ")); 
	$kd_kab=$kec['kd_kab'];
	$nama_kec=$kec['nama_kec'];
	
date_default_timezone_set('Asia/Jakarta')			
?>
<!DOCTYPE html>
<html>
<head>

    <link rel="shortcut icon" href="images/fav.png" type="image/x-icon">
	<title>SI UPK Online <?php echo $nama_kec;?> - V.2.0</title>
    <link href="css/application.min.css" rel="stylesheet">
    <!-- as of IE9 cannot parse css files with more that 4K classes separating in two files -->
    <!--[if IE 9]>
        <link href="css/application-ie9-part2.css" rel="stylesheet">
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
         chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
         https://code.google.com/p/chromium/issues/detail?id=332189
         */
    </script>
	
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">

    <style>
        #ajax-table_filter label input[type=search] {
            padding: 0.375rem 24px;
            font-size: 12px;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        
        #ajax-table_filter label input[type=search]:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>

</head>
<body>

<?php
$table_kelompok="kelompok_$kd_kab";
$table_anggota="anggota_$kd_kab";
$table_pk="pinjaman_kelompok_$kd_kab";
$table_pa="pinjaman_anggota_$kd_kab";
	
$jum_kel=mysql_num_rows(mysql_query("select * from $table_kelompok WHERE lokasi='$_SESSION[lokasi]' "));
$jum_prop=mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='P' "));
$jum_ver=mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='V' "));
$jum_dana=mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='D'"));
$jum_wait=mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='W'"));
$jum_akt=mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' AND pk.status='A' "));
$jum_aakt=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' AND pa.status='A' "));
$jum_pinj=mysql_num_rows(mysql_query("select * from $table_kelompok k, $table_pk pk WHERE k.id=pk.id_kel AND k.lokasi='$_SESSION[lokasi]' "));



$_SESSION['jum_kel']=$jum_kel;
$_SESSION['jum_prop']=$jum_prop;
$_SESSION['jum_ver']=$jum_ver;
$_SESSION['jum_dana']=$jum_dana;
$_SESSION['jum_wait']=$jum_wait;
$_SESSION['jum_akt']=$jum_akt;
$_SESSION['jum_aakt']=$jum_aakt;
$_SESSION['jum_pinj']=$jum_pinj;


//PINJAMAN INDIVIDU
$table_anggota="anggota_$kd_kab";
$table_pa="pinjaman_anggota_$kd_kab";
	
$jum_prop_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' AND pa.jenis_pinjaman='I' AND pa.status='P' "));
$jum_ver_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' AND pa.jenis_pinjaman='I' AND pa.status='V' "));
$jum_dana_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' AND pa.jenis_pinjaman='I' AND pa.status='D' "));
$jum_wait_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' AND pa.jenis_pinjaman='I' AND pa.status='W'"));
$jum_akt_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' AND pa.jenis_pinjaman='I' AND pa.status='A' "));
$jum_pinj_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.lokasi='$_SESSION[lokasi]' AND pa.jenis_pinjaman='I' "));



$_SESSION['jum_prop_i']=$jum_prop_i;
$_SESSION['jum_ver_i']=$jum_ver_i;
$_SESSION['jum_dana_i']=$jum_dana_i;
$_SESSION['jum_wait_i']=$jum_wait_i;
$_SESSION['jum_akt_i']=$jum_akt_i;
//$_SESSION['jum_lns']=$jum_lns;
$_SESSION['jum_pinj_i']=$jum_pinj_i;

 ?>

<nav id="sidebar" class="sidebar" role="navigation">
    <!-- need this .js class to initiate slimscroll -->
    <div class="js-sidebar-content">
        <header class="logo hidden-xs mb-n-sm">
            <a href="?p=home">
			<span class="thumb-sm avatar">
							<?php
											 $kec=mysql_fetch_array(mysql_query("select * from kecamatan where id='$_SESSION[lokasi]' ")); 
											 $logo=$kec['logo'];
											if (empty($logo)) {
											echo "<img class='' alt='...' src='images/upk.png'>";
											}else{
											echo "<img class='' alt='...' src='images/logo/$logo'>";
											}
										?>
                        </span>
			</a>
        </header>
			<div class="sidebar-alerts text-align-center">
				<div class="alert fade in">
					<b>  <?php  echo strtoupper($_SESSION['nama_lembaga_sort']); //LENCANA?> <?php  echo strtoupper($_SESSION['unit']); //LENCANA?></b>
					<br>
					<small><?php  echo substr($kec['alamat_kec'],0,24); //LENCANA?></small>
				</div>
			</div>
 
        
			<?php 
			if ($_SESSION['level']=='1'){			//UPK
				include "modul/menu/menu_upk.php";
			}elseif ($_SESSION['level']=='2') {			//BKAD
				include "modul/menu/menu_bkad.php";
			}elseif ($_SESSION['level']=='3' OR $_SESSION['level']=="camat"){			//BP, CAMAT
				include "modul/menu/menu_bp.php";
			}elseif ($_SESSION['level']=='4'){			//TV
				include "modul/menu/menu_tv.php";
			}
			?>
		
		<div class="sidebar-alerts text-align-center">
            <div class="alert fade in">
                <small>www.siupkonline.com<br>V.2.0</small>
            </div>
        </div>
		
    </div>
</nav>



<?php include "header.php"; ?>


<div class="content-wrap">
    <main id="content" class="content" role="main">
	    <?php include "content.php"; ?>
    </main>

	<div class="panel-footer">
		<div class="mb-md fs-mini text-muted">
			<div class="pull-right">
				Dev : PT. Asta Brata Teknologi &nbsp;
				<a href="https://web.facebook.com/maarif.arrafi" target="_blank"><i class="fa fa-facebook-square"></i></a> &nbsp;
				<a href="https://twitter.com/maarif_nurhamim" target="_blank"><i class="fa fa-twitter"></i></a> &nbsp;
				<a href="https://id.linkedin.com/in/maarif-nurhamim-ar-rafi-67350b106" target="_blank"><i class="fa fa-linkedin-square"></i></a> &nbsp; 
				Ma'arif - all rights reserved.
			</div>
		</div>
	</div>

</div>

<!-- The Loader. Is shown when pjax happens -->
<div class="loader-wrap hiding hide">
    <i class="fa fa-spinner fa-spin-fast"></i>
</div>

<!-- common libraries. required for every page-->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-pjax/jquery.pjax.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/transition.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/collapse.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/dropdown.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/button.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js"></script>
<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/alert.js"></script>
<script src="vendor/jQuery-slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/widgster/widgster.js"></script>
<script src="vendor/pace.js/pace.min.js"></script>
<script src="vendor/jquery-touchswipe/jquery.touchSwipe.js"></script>


<!-- common app js -->
<script src="js/settings.js"></script>
<script src="js/app.js"></script>

<!-- MODAL -->
	<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/popover.js"></script>
	<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/modal.js"></script>
	<script src="js/ui-components.js"></script>
	
<!-- TABLE -->	
	<script src="vendor/underscore/underscore-min.js"></script>
	<script src="vendor/backbone/backbone.js"></script>
	<script src="vendor/backbone.paginator/lib/backbone.paginator.min.js"></script>
	<script src="vendor/backgrid/lib/backgrid.js"></script>
	<script src="vendor/backgrid-paginator/backgrid-paginator.js"></script>
	<script src="vendor/datatables/media/js/jquery.dataTables.js"></script>
	<script src="vendor/bootstrap-select/bootstrap-select.min.js"></script>
	<script src="js/tables-dynamic.js"></script>

<!-- WIDGET -->
<script src="vendor/underscore/underscore.js"></script>
<script src="vendor/jquery.sparkline/dist/jquery.sparkline.js"></script>

<script src="vendor/raphael/raphael-min.js"></script>
<script src="vendor/jQuery-Mapael/js/jquery.mapael.js"></script>
<script src="vendor/flot/jquery.flot.js"></script>
<script src="vendor/MetroJS/release/MetroJs.Full/MetroJs.js"></script>
<script src="vendor/skycons/skycons.js"></script>
<script src="demo/js/_fake-world-data.js"></script>
<script src="js/widgets.js"></script>

<!-- page specific libs -->
<script src="vendor/flot.animator/jquery.flot.animator.min.js"></script>
<script src="vendor/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="vendor/flot/jquery.flot.selection.js"></script>
<script src="vendor/flot/jquery.flot.time.js"></script>


<!-- page specific libs -->
<script src="vendor/parsleyjs/dist/parsley.min.js"></script>

<!-- page specific libs -->
<script src="vendor/jquery-autosize/jquery.autosize.min.js"></script>
<script src="vendor/bootstrap3-wysihtml5/lib/js/wysihtml5-0.3.0.min.js"></script>
<script src="vendor/bootstrap3-wysihtml5/src/bootstrap3-wysihtml5.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/switchery/dist/switchery.min.js"></script>
<script src="vendor/moment/min/moment.min.js"></script>
<script src="vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="vendor/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="vendor/jasny-bootstrap/js/inputmask.js"></script>
<script src="vendor/jasny-bootstrap/js/fileinput.js"></script>
<script src="vendor/holderjs/holder.js"></script>
<script src="vendor/dropzone/downloads/dropzone.min.js"></script>
<script src="vendor/markdown/lib/markdown.js"></script>
<script src="vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script src="vendor/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js"></script>

<script src="js/form-elements.js"></script>

<script src="vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/tab.js"></script>

<!-- page specific libs -->
<script src="vendor/shufflejs/dist/jquery.shuffle.modernizr.min.js"></script>
<script src="vendor/magnific-popup/dist/jquery.magnific-popup.min.js"></script>

<script src="vendor/jquery-animateNumber/jquery.animateNumber.min.js"></script>

<!-- page specific js -->
<script src="js/index.js"></script>
<?php 
    // Cek apakah $_SESSION['check'] belum ada atau kurang dari 1
    if (!isset($_SESSION['check']) || $_SESSION['check'] < 1) {
        echo "
        <script>
            alert('Website ini berfungsi sebagai backup data untuk versi aplikasi sebelumnya setelah proses peralihan ke versi terbaru.');
        </script>";
        // Set $_SESSION['check'] menjadi 1
        $_SESSION['check'] = 1;
    }

?>
<!-- AUTO COMPLATE -->
<script src="js/jquery-ui.min.js"></script>

<script>
    $('#datetimepicker1').datetimepicker()
</script>
	
</body>
</html>

<?php
}else{
	session_destroy();
	header('Location:index.php?st=1');
	
}
?>	