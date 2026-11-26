<?php
include "conn.php";

$id 	= $_POST['id'];

class emp{}

if (empty($id)) { 
	$response = new emp();
	$response->success = 0;
	$response->message = "data tidak terhapus"; 
	die(json_encode($response));
} else {
	$query = mysqli_query($con,"DELETE FROM catatan WHERE id_catatan='".$id."'");
	
	if ($query) {
		$response = new emp();
		$response->success = 1;
		$response->message = "Data terhapus";
		die(json_encode($response));
	} else{ 
		$response = new emp();
		$response->success = 0;
		$response->message = "Data tidak terhapus";
		die(json_encode($response)); 
	}	
}

?>