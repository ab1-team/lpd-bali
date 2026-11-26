<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="beli_pulsa";
$tanggal		=date('Y-m-d H:i:s');
$nomor_pelanggan	=$_POST['nomor_pelanggan'];
$kode_produk		=$_POST['kode_produk'];
$harga		=$_POST['kode_produk'];

$id_pengirim	=$_SESSION['id'];


	$input = "INSERT INTO $table (id,tanggal,nomor_pelanggan,kode_produk,harga,id_pengirim,status)
				VALUES('', '$tanggal','$nomor_pelanggan','$kode_produk','$harga','$id_pengirim','Waiting')";
	mysql_query($input);
	
?>