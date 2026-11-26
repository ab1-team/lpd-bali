<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";

$jenis_pinjaman	= "K";
$id_kel			= $_POST['id_kel'];
$id_pinkel		= $_POST['id_pinkel'];
$nia			= $_POST['nia'];
$jenis_pp		= $_POST['jenis_pp'];
$proposal		= $_POST['alokasi_anggota'];
$tgl_proposal	= date('Y-m-d');
$lu				= date('Y-m-d H:i:s');
$user_id		= $_SESSION['id'];
$status			= "P";

$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE nia= '$nia' AND `status`='$status' ");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table			SET proposal			='$proposal',
											alokasi				='$proposal',
											lu					='$lu',
											user_id				='$user_id'
						WHERE nia= '$nia' AND `status`='$status'";
	mysql_query($input);							
}else{
	
	$input = "INSERT INTO $table (jenis_pinjaman,id_kel,id_pinkel,nia,jenis_pp,tgl_proposal,proposal,alokasi,status,lu,user_id)
				VALUES('$jenis_pinjaman','$id_kel', '$id_pinkel', '$nia', '$jenis_pp','$tgl_proposal','$proposal','$proposal','$status','$lu','$user_id')";
	mysql_query($input);
}
?>