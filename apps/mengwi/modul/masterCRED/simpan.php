<?php
include "../../inc/inc.koneksi.php";
$table		="jenis_kas";
$kd_kas=$_POST['kd_kas'];
$nama_kas=$_POST['nama_kas'];
$deskripsi=$_POST['deskripsi'];

$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE kd_kas= '$kd_kas'");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table SET kd_kas	='$kd_kas',
								nama_kas='$nama_kas',
								deskripsi='$deskripsi'
					WHERE kd_kas= '$kd_kas'";
	mysql_query($input);								
}else{
	$input = "INSERT INTO $table (kd_kas,nama_kas,deskripsi)
				VALUES('$kd_kas', '$nama_kas', '$deskripsi')";
	mysql_query($input);
}	
?>