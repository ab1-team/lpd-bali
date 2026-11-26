<?php
include "conn.php";

$judul 	= $_POST['judul'];
$isi = $_POST['isi'];

class emp{}

if (empty($judul) || empty($isi)) { 
	$response = new emp();
	$response->success = 0;
	$response->message = "jangan kosong"; 
	die(json_encode($response));
} else {
	$query = mysqli_query($con,"INSERT INTO catatan (id_catatan, judul, isi) VALUES(0,'".$judul."','".$isi."')");
	
	if ($query) {
		$response = new emp();
		$response->success = 1;
		$response->message = "Data berhasil di simpan";
		die(json_encode($response));
	} else{ 
		$response = new emp();
		$response->success = 0;
		$response->message = "Data tidak berhasil di simpan";
		die(json_encode($response)); 
	}	
}

?>