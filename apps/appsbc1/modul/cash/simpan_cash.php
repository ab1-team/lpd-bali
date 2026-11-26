<?php session_start();
include "../../inc/inc.koneksi.php";


$lokasi 	= $_SESSION['lokasi'];
$tanggal 	= $_POST['tanggal'];
$k100K 		= $_POST['k100K'];
$k50K 		= $_POST['k50K'];
$k20K 		= $_POST['k20K'];
$k10K 		= $_POST['k10K'];
$k5K 		= $_POST['k5K'];
$k2K 		= $_POST['k2K'];
$k1K 		= $_POST['k1K'];
$k500 		= $_POST['k500'];
$k100 		= $_POST['k100'];
							
$L1K 		= $_POST['L1K'];
$L500 		= $_POST['L500'];
$L200 		= $_POST['L200'];
$L100 		= $_POST['L100'];
$L50 		= $_POST['L50'];
$L25 		= $_POST['L25'];
$L5 		= $_POST['L5'];
$L1 		= $_POST['L1'];

$id_user	=$_SESSION['id'];

				
mysql_query("INSERT INTO cashopname (id,lokasi,tanggal,k100K,k50K,k20K,k10K,k5K,k2K,k1K,k500,k100,L1K,L500,L200,L100,L50,L25,L5,L1,id_user)
				VALUES('','$lokasi','$tanggal','$k100K','$k50K','$k20K','$k10K','$k5K','$k2K','$k1K','$k500','$k100','$L1K','$L500','$L200','$L100','$L50','$L25','$L5','$L1','$id_user')");

				

?>