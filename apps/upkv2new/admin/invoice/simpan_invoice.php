<?php session_start();
include "../../inc/inc.koneksi.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$table_invoice="admin_invoice";
		
$nomor				=$_POST['nomor'];
$lokasi				=$_POST['lokasi'];
$jenis_pembayaran	=$_POST['jenis_pembayaran'];
$tgl_invoice		=$_POST['tgl_invoice'];
$status				="UNPAID";
$jumlah				=$_POST['jumlah'];
$id_user			=$_SESSION['id'];

$sql = mysql_query("SELECT *
				   FROM $table_invoice 
				   WHERE idv= '$nomor'");
$row	= mysql_num_rows($sql);


if ($row>0){
	$update	= "UPDATE $table_invoice SET jumlah	='$jumlah'
									WHERE idv= '$nomor'";
	mysql_query($update);

}else{

	$input = "INSERT INTO $table_invoice (idv,lokasi,jenis_pembayaran,tgl_invoice,tgl_lunas,status,jumlah,id_user)
				VALUES('$nomor','$lokasi','$jenis_pembayaran','$tgl_invoice','0000-00-00','$status','$jumlah','$id_user')";
	mysql_query($input);
	
}	
?>