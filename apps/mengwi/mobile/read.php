<?php
include "conn.php";
$query = mysqli_query($con,"SELECT * FROM catatan ORDER BY judul ASC");	
$json = array();	
while($row = mysqli_fetch_assoc($query)){
	$json[] = $row;
}	
die(json_encode($json));	
mysqli_close($connect);	
?>