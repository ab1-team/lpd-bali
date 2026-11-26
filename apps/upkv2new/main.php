<?php session_start(); 
if(isset($_SESSION['id'])){
	$id_user=ucfirst($_SESSION['id']);

include "inc/inc.koneksi.php";
//include "inc/fungsi_pinjaman.php";
	
 $kec=mysql_fetch_array(mysql_query("select * from kecamatan where id='$_SESSION[lokasi]' ")); 
	$kd_kab=$kec['kd_kab'];
	$nama_kec=$kec['nama_kec'];
	
date_default_timezone_set('Asia/Jakarta')			
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
	
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
         chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
         https://code.google.com/p/chromium/issues/detail?id=332189
         */
    </script>
	
	

</head>
<body>

<div class="widget-body">
<div class="table-responsive">
<table id="datatable-table" class="table table-hover">
                        <thead class="bg-gray text-white">
                        <tr>
							<th class="no-sort">&nbsp;</th>
                        </tr>
                        </thead>
</table>
</div>
	
	<h3 class="mb-lg text-align-center">
			Sistem Informasi Managemen<br>
			<b><?php echo "$kec[nama_lembaga_long] $kec[nama_kec]"; ?></b><br>
			<span class="h5 mb-0"><?php echo "$kec[alamat_kec] $kec[nama_kec] Telp. $kec[telpon_kec]"; ?><br>
			<legend></legend></span>
		</h3>
		
	<div class="col-sm-3">
	</div>
	<div class="col-sm-6">
		<a href="2dd18a093e55d422d978e5d022c03c87202cfb6c31900de29ab9ab1fd8fd644360b23c5d54fa3e0623f0e61fab38ae61c624b9a5a92ca7eea7546a34e5a8a1e5.php?p=1" class="btn btn-default width-200 mb-xs" role="button">
			<br><img src="images/unit_1.png" width="100px"/><br><br>
			<p><b>UNIT DANA BERGULIR</b><br>(SPP, UEP, DKU)</p>
		</a>
		<a href="p4.php?p=home" class="btn btn-default width-200 mb-xs" role="button">
			<br><img src="images/unit_4.png" width="100px"/><br><br>
			<p><b>UNIT SEKTOR RIIL</b><br>(Bagi Hasil)</p>
		</a>
		<a href="#" class="btn btn-default width-200 mb-xs" role="button" disabled>
			<br><img src="images/unit_5.png" width="100px"/><br><br>
			<p><b>UNIT PENJAMINAN</b><br>(Pinjaman)</p>
		</a>
		<a href="payment.php?p=up_home" class="btn btn-default width-200 mb-xs" role="button" <?php if($_SESSION['id']!='3433') echo"disabled"; //243?> >
			<br><img src="images/unit_6.png" width="100px"/><br><br>
			<p><b>UPK PAY</b><br>(Asiknya Bayar-bayar)</p>
		</a>
		<a href="#" class="btn btn-default width-200 mb-xs" role="button" disabled>
			<br><img src="images/unit_2.png" width="100px"/><br><br>
			<p><b>UNIT MINIMARKET</b><br>(Point of Sale)</p>
		</a>
		<a href="#" class="btn btn-default width-200 mb-xs" role="button" disabled>
			<br><img src="images/unit_3.png" width="100px"/><br><br>
			<p><b>UNIT APOTEK</b><br>(Point of Sale</p>
		</a>
		
	</div>
	<div class="col-sm-3">
	</div>
</div>

</body>
</html>

<?php
}else{
	session_destroy();
	header('Location:index.php?st=1');
	
}
?>