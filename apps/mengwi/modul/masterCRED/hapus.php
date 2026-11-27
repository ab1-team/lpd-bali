<?php
include "../../inc/inc.koneksi.php";
$table	= 'jenis_kas';
$id		= $_POST['kd_kas'];
$sql 	= mysql_query("SELECT * FROM $table WHERE kd_kas= '$id'");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input = "DELETE FROM $table WHERE kd_kas= '$id'";
	mysql_query($input);
}
?>