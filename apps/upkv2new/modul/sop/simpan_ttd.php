<?php session_start();
include "../../inc/inc.koneksi.php";
$table		="kecamatan";
$id_kec		=$_SESSION['lokasi'];

$ttd_pelapor	=$_POST['ttd_pelapor'] ?: '0';
$ttd_bp			=$_POST['ttd_bp'] ?: '0';
$ttd_mengetahui_lap	=$_POST['ttd_mengetahui_lap'] ?: '0';
$ttd_pdua			=$_POST['ttd_pdua'] ?: '0';
$ttd_saksi			=$_POST['ttd_saksi'] ?: '0';
$ttd_mengetahui			=$_POST['ttd_mengetahui'] ?: '0';
$ttd_psatu			=$_POST['ttd_psatu'] ?: '0';

	$input	= "UPDATE $table SET 	ttd_pelapor='$ttd_pelapor',
									ttd_bp='$ttd_bp',
									ttd_mengetahui_lap='$ttd_mengetahui_lap',
									ttd_pdua='$ttd_pdua',
									ttd_saksi='$ttd_saksi',
									ttd_mengetahui='$ttd_mengetahui',
									ttd_psatu='$ttd_psatu'
					WHERE id= '$id_kec'";
	mysql_query($input);								
	
?>