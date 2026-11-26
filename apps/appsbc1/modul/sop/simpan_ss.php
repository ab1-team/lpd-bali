<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="desa";
$id=$_SESSION['lokasi'];

$def_jasa_tabungan		=$_POST['def_jasa_tabungan'];
$def_jasa_deposito		=$_POST['def_jasa_deposito'];

	$input	= "UPDATE $table SET 	def_jasa_tabungan='$def_jasa_tabungan',
									def_jasa_deposito='$def_jasa_deposito'
					WHERE id= '$id'";
	mysql_query($input);								
	
?>