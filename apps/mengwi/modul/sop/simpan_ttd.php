<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="kecamatan";
$id_kec		=$_SESSION['lokasi'];

$ttd_pelapor	=$_POST['ttd_pelapor'];
$ttd_bp			=$_POST['ttd_bp'];
$ttd_mengetahui_lap	=$_POST['ttd_mengetahui_lap'];
$ttd_pdua			=$_POST['ttd_pdua'];
$ttd_saksi			=$_POST['ttd_saksi'];
$ttd_mengetahui			=$_POST['ttd_mengetahui'];

	$input	= "UPDATE $table SET 	ttd_pelapor='$ttd_pelapor',
									ttd_bp='$ttd_bp',
									ttd_mengetahui_lap='$ttd_mengetahui_lap',
									ttd_pdua='$ttd_pdua',
									ttd_saksi='$ttd_saksi',
									ttd_mengetahui='$ttd_mengetahui'
					WHERE id= '$id_kec'";
	mysql_query($input);								
	
?>