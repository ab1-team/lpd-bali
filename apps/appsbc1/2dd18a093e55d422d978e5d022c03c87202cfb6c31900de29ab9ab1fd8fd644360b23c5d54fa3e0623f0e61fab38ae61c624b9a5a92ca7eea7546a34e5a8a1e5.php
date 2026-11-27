<?php session_start(); 
if(isset($_SESSION['id'])){
	$id_user=ucfirst($_SESSION['id']);

include "inc/inc.koneksi.php";
	
 $des=mysql_fetch_array(mysql_query("select * from kecamatan c, desa d where c.id=d.kd_kec AND d.id='$_SESSION[lokasi]' "));
 
	$kd_kab		=$des['kd_kab'];
	$nama_kec	=$des['nama_kec'];
	$nama_desa	=$des['nama_desa'];
	
date_default_timezone_set('Asia/Jakarta')			
?>
<!DOCTYPE html>
<html>
<head>
	<script src="js/jquery-2.2.1.min.js"></script>
	<!-- <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script> -->
	<script>
		$(document).ready(function(){
		  $(".preloader").fadeOut();
		})
	</script>
    <link rel="shortcut icon" href="images/logo_bumdes.png?v=20261127" type="image/x-icon">
	<title>SIM <?php echo LEMBAGA_SORT; ?> <?php echo "$nama_desa Kecamatan $nama_kec";?> - V.2.0</title>
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



</head>
<body>
<div class="preloader">
	<div class="loading">
		<img src="images/animation.gif" width="280"/><br>
		<span class="h4 text-muted">Silahkan Tunggu,<br>
		Kami sedang mempersiapkan data anda...</span>
	</div>
</div>
<?php
$table_anggota="anggota_$kd_kab";
$table_pa="pinjaman_anggota_$kd_kab";
$table_sa="simpanan_anggota_$kd_kab";
	
$jum_debitur=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.desa='$_SESSION[lokasi]' AND pa.status='A' ")); //Peminjam
$jum_kreditur=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_sa sa WHERE a.id=sa.nia AND a.desa='$_SESSION[lokasi]' AND sa.status='A' ")); //Penabung

$jum_umum=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_sa sa WHERE a.id=sa.nia AND a.desa='$_SESSION[lokasi]' AND sa.jenis_simpanan='1' AND sa.status='A' ")); //Penabung
$jum_depo=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_sa sa WHERE a.id=sa.nia AND a.desa='$_SESSION[lokasi]' AND sa.jenis_simpanan='2' AND sa.status='A' ")); //Penabung
	
$jum_prop_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.desa='$_SESSION[lokasi]' AND pa.status='P' "));
$jum_ver_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.desa='$_SESSION[lokasi]' AND pa.status='V' "));
$jum_ver1_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.desa='$_SESSION[lokasi]' AND pa.status='V1' "));
$jum_ver2_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.desa='$_SESSION[lokasi]' AND pa.status='V2' "));
$jum_ver3_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.desa='$_SESSION[lokasi]' AND pa.status='V3' "));
$jum_wait_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.desa='$_SESSION[lokasi]' AND pa.status='W' "));
$jum_akt_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.desa='$_SESSION[lokasi]' AND pa.status='A' "));
$jum_pinj_i=mysql_num_rows(mysql_query("select * from $table_anggota a, $table_pa pa WHERE a.id=pa.nia AND a.desa='$_SESSION[lokasi]' "));



$_SESSION['jum_umum']=$jum_umum;
$_SESSION['jum_depo']=$jum_depo;

$_SESSION['jum_prop_i']=$jum_prop_i;
$_SESSION['jum_ver_i']=$jum_ver_i;
$_SESSION['jum_ver1_i']=$jum_ver1_i;
$_SESSION['jum_ver2_i']=$jum_ver2_i;
$_SESSION['jum_ver3_i']=$jum_ver3_i;
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
				<img class='' alt='...' src='images/logo_bumdes.png?v=20261127'>
			</span>
			</a>
        </header>
			<div class="sidebar-alerts text-align-center">
				<div class="alert fade in">
					<b>  <?php echo strtoupper(LEMBAGA_SORT); ?> <?php  echo strtoupper($des['nama_desa']); //LENCANA?></b>
					<br>
					<small><?php  echo substr($des['alamat_desa'],0,24); //LENCANA?></small>
				</div>
			</div>
 
        
			<?php 
				include "modul/menu/menu_lpd.php";

			?>
		
		<div class="sidebar-alerts text-align-center">
            <div class="alert fade in">
                <small>www.lpd-bali.id<br>V.2.0</small>
            </div>
        </div>
		
    </div>
</nav>



<?php include "header.php"; ?>


<div class="content-wrap">
    <main id="content" class="content" role="main">
	<?php 
	include "content.php";

	?>

		
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

<!-- AUTO COMPLATE -->
<script src="js/jquery-ui.min.js"></script>


	
</body>
</html>

<?php
}else{
	session_destroy();
	header('Location:index.php?st=1');
	
}
?>	