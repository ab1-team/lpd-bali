<?php session_start();
include "../../inc/inc.koneksi.php";
$table	= "kelompok_$_SESSION[kd_kab]";
$id		= $_POST['idk'];
$sql 	= mysql_query("SELECT * FROM $table WHERE id= '$id'");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input = "DELETE FROM $table WHERE id= '$id'";
	mysql_query($input);
}
?>