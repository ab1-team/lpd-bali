<?php session_start(); 
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan.php";
$table			="rekening_$_SESSION[lokasi]";

$tahunbuku		="tb$_SESSION[tahunbuku]";
$ditahan		=$_POST['ditahan'];

	
	$input5	= "UPDATE $table SET $tahunbuku='$ditahan' 		WHERE kd_rekening='316.01' ";
	mysql_query($input5);

	

?>