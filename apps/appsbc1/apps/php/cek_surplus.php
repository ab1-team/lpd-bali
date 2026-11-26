<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";	

	$now	=date('Y-m-d');
	$surplus	=surplus("$now");
		
	echo number_format($surplus,0,',','.')." IDR";

?>