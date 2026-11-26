<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";	

	$now	=date('Y-m')."-31";
	$akt	=aktiva("$now");
		
	echo number_format($akt,0,',','.')." IDR";

?>