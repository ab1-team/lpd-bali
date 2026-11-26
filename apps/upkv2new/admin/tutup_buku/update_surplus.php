<?php session_start(); 
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_keuangan_admin.php";
$table			="admin_rekening";

$tahunbuku		="tb$_SESSION[tahunbuku]";
$maarif			=$_POST['maarif'];
$santoso		=$_POST['santoso'];



$tgl_kondisi		="$_SESSION[tahunbuku]-12-31";

$saldo_maarifDR		=saldoR("$tgl_kondisi-311.1001")*-1;
$saldo_santosoDR	=saldoR("$tgl_kondisi-312.1001")*-1;

$sum_maarif			=$saldo_maarifDR+$maarif;
$sum_santoso		=$saldo_santosoDR+$santoso;
								
								

	$input1	= "UPDATE $table SET $tahunbuku='$sum_maarif' 		WHERE kd_rekening='311.1001' ";
	mysql_query($input1);
	
	$input2	= "UPDATE $table SET $tahunbuku='$sum_santoso' 		WHERE kd_rekening='312.1001' ";
	mysql_query($input2);
	

?>