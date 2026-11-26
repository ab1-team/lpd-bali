<?php
include "inc/koneksi_payment.php";
$mod = $_GET['p'];


//PAYMENT
if ($mod=='up_home'){
    include "payment/home.php";
}


elseif ($mod=='produk'){
			include "payment/halaman_produk.php";
			}


elseif ($mod=='x'){
    echo"
		<div class='alert alert-danger mt animated fadeInDown h4'>
			Maaf, masih dalam pengembangan!
		</div>
		";
}

else{
echo "<h2>Maaf $pk[menu], halaman belum tersedia! </h2>";
}
?>