<?php
include "conn.php";

$id = $_POST['id_catatan'];

class emp{}

if (empty($id)) { 
	$response = new emp();
	$response->success = 0;
	$response->message = "Error Mengambil Data"; 
	die(json_encode($response));
} else {
	$query 	= mysqli_query($con,"SELECT * FROM catatan WHERE id_catatan='".$id."'");
	$row 	= mysqli_fetch_array($query);
	
	if (!empty($row)) {
		$response = new emp();
		$response->success = 1;
		$response->id_catatan = $row["id_catatan"];
		$response->judul = $row["judul"];
		$response->isi = $row["isi"];
		die(json_encode($response));
	} else{ 
		$response = new emp();
		$response->success = 0;
		$response->message = "Error Mengambil Data";
		die(json_encode($response)); 
	}	
}

?>