<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="catatan_bp";
$tahun		=$_POST['tahun'];
$bulan		=$_POST['bulan'];
$isi		=$_POST['isi'];
$lokasi		=$_SESSION['lokasi'];
$kd_kab		=$_SESSION['kd_kab'];
$id_sender	=$_SESSION['id'];

$bulap	="$tahun-$bulan";

$tanggal=date('Y-m-d H:i:s');

$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE bulan_laporan= '$bulap' AND lokasi= '$lokasi'");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table SET 
								isi='$isi'
					WHERE bulan_laporan= '$bulap' AND lokasi= '$lokasi'";
	mysql_query($input);								
}else{
	$input = "INSERT INTO $table (tanggal,kd_kab,lokasi,bulan_laporan,isi,id_sender)
				VALUES('$tanggal', '$_SESSION[kd_kab]', '$_SESSION[lokasi]','$bulap','$isi','$_SESSION[id]')";
	mysql_query($input);
}	
?>