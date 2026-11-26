<?php session_start();
include "../../../inc/inc.koneksi.php";
$table1	= "pinjaman_kelompok_$_SESSION[kd_kab]";
$table2	= "pinjaman_anggota_$_SESSION[kd_kab]";

$idl	= $_POST['idl'];
$sql 	= mysql_query("SELECT * FROM $table1 WHERE id= '$idl'");
$row	= mysql_num_rows($sql);

if ($row>0){
	$input1 = "DELETE FROM $table1 WHERE id= '$idl'";
	mysql_query($input1);
	
	$input2 = "DELETE FROM $table2 WHERE id_pinkel= '$idl'";
	mysql_query($input2);
}
?>