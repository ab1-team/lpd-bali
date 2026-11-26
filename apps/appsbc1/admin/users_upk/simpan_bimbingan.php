<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="bimbingan";
$tanggal	=$_POST['tgl_kunjungan'];
$isi		=$_POST['hasil_kunjungan'];

$kd_kab	=$_SESSION['kd_kab'];
$id_receiver	=$_SESSION['ida'];
$id_sender	=$_SESSION['id'];


	$input = "INSERT INTO $table (id,kd_kab,id_receiver,tanggal,isi,id_sender)
				VALUES('', '$kd_kab', '$id_receiver','$tanggal','$isi','$id_sender')";
	mysql_query($input);
	
?>