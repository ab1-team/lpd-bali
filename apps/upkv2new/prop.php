<?php session_start(); 
if(isset($_SESSION['id'])){
	$id_user=ucfirst($_SESSION['id']);

include "inc/inc.koneksi.php";
//include "inc/fungsi_pinjaman.php";
	
$kd_kab=$_SESSION['id'];
	
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
         chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
         https://code.google.com/p/chromium/issues/detail?id=332189
         */
    </script>
</head>
<body>
<?php


//$jum_kec=mysql_num_rows(mysql_query("select * from kecamatan WHERE kd_kab='$kd_kab' "));


 ?>

<nav id="sidebar" class="sidebar" role="navigation">
    <!-- need this .js class to initiate slimscroll -->
    <div class="js-sidebar-content">
        <header class="logo hidden-xs">
            <a href="?p=home">
			PROP
			</a>
        </header>
		
 
        
			<?php 
				include "modul/menu/menu_prop.php";
			?>
		
		<div class="sidebar-alerts text-align-center">
            <div class="alert fade in">
                <small>www.siupkonline.com<br>V.2.0</small>
            </div>
        </div>
		
    </div>
</nav>



<?php include "header_kab.php"; ?>

<div class="chat-sidebar" id="chat">
    <?php include "modul/chat/chat.php";?>
</div>

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
<script src="vendor/d3/d3.min.js"></script>
<script src="vendor/rickshaw/rickshaw.min.js"></script>
<script src="vendor/raphael/raphael-min.js"></script>
<script src="vendor/jQuery-Mapael/js/jquery.mapael.js"></script>
<script src="vendor/jQuery-Mapael/js/maps/usa_states.js"></script>
<script src="vendor/jQuery-Mapael/js/maps/world_countries.js"></script>
<script src="vendor/flot/jquery.flot.js"></script>
<script src="vendor/MetroJS/release/MetroJs.Full/MetroJs.js"></script>
<script src="vendor/skycons/skycons.js"></script>
<script src="demo/js/_fake-world-data.js"></script>
<script src="js/widgets.js"></script>

<!-- page specific libs -->
<script src="vendor/jquery.sparkline/dist/jquery.sparkline.js"></script>
<script src="vendor/d3/d3.min.js"></script>
<script src="vendor/rickshaw/rickshaw.min.js"></script>
<script src="vendor/raphael/raphael-min.js"></script>
<script src="vendor/flot.animator/jquery.flot.animator.min.js"></script>
<script src="vendor/flot/jquery.flot.js"></script>
<script src="vendor/flot-orderBars/js/jquery.flot.orderBars.js"></script>
<script src="vendor/flot/jquery.flot.selection.js"></script>
<script src="vendor/flot/jquery.flot.time.js"></script>

<script src="vendor/nvd3/nv.d3.min.js"></script>
<script src="vendor/morris.js/morris.min.js"></script>
<script src="vendor/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>

<!-- page specific js -->
<script src="js/charts.js"></script>

<!-- page specific libs -->
<script src="vendor/parsleyjs/dist/parsley.min.js"></script>
<!-- page specific js -->
<script src="js/form-validation.js"></script>

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
<script src="js/invoice.js"></script>

<!-- page specific libs -->
<script src="vendor/shufflejs/dist/jquery.shuffle.modernizr.min.js"></script>
<script src="vendor/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<!-- page specific js -->
<script src="js/gallery.js"></script>


	
</body>
</html>

<?php
}else{
	session_destroy();
	header('Location:kab/index.php?st=1');
	
}
?>