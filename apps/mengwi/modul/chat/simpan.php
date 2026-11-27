<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="chat";

$id_sender=$_SESSION[id];
$tanggal=date('Y-m-d H:i:s');
$id_receiver=$_SESSION['idu'];
$isi=$_POST['content_txt'];


	$input = "INSERT INTO $table (id_sender,id_receiver,tanggal,isi)
				VALUES('$id_sender','$id_receiver','$tanggal','$isi')";
	mysql_query($input);
	
?>