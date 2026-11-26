<?php
include "conn.php";

$id 	= $_POST['id'];
$judul 	= $_POST['judul'];
$isi = $_POST['isi'];

class emp{}

if (empty($id) || empty($judul) || empty($isi)) { 
	$response = new emp();
	$response->success = 0;
	$response->message = "Jangan kosong"; 
	die(json_encode($response));
} else {
	$query = mysqli_query($con,"UPDATE catatan SET judul='".$judul."', isi='".$isi."' WHERE id_catatan='".$id."'");
	
	if ($query) {
		$response = new emp();
		$response->success = 1;
		$response->message = "Data berhasil di update";
		die(json_encode($response));
	} else{ 
		$response = new emp();
		$response->success = 0;
		$response->message = "Error update Data";
		die(json_encode($response)); 
	}	
}

?>