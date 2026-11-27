<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";

$jenis_pinjaman	= "T";
$id_kel			= "0";
$id_pinkel		= "0";
$id_pinj		= "0";
$nia			= $_POST['nia'];
$jenis_pp		= "0";
$proposal		= $_POST['proposali'];
$tgl_proposal	= $_POST['tgl_proposal'];
$usaha			= $_POST['usaha'];
$pros_jasa		= $_POST['pros_jasa'];
$jenis_jasa		= "0";
$jangka			= $_POST['jangka'];
$sistem			= "0";
$sa_jasa		= "0";
$lu				= date('Y-m-d H:i:s');
$user_id		= $_SESSION['id'];
$status			= "P";


$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE nia= '$nia' AND `status`='$status' ");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table			SET tgl_proposal		='$tgl_proposal',
											proposal			='$proposal',
											alokasi				='$proposal',
											pros_jasa			='$pros_jasa',
											jenis_jasa			='$usaha',
											jangka				='$jangka',
											lu					='$lu',
											user_id				='$user_id'
						WHERE nia= '$nia' AND `status`='$status'";
	mysql_query($input);							
}else{
	
	$input = "INSERT INTO $table (jenis_pinjaman,id_kel,id_pinkel,jenis_pp,nia,tgl_proposal,proposal,alokasi,pros_jasa,jenis_jasa,jangka,sistem_angsuran,sa_jasa,status,lu,user_id)
				VALUES('$jenis_pinjaman','$id_kel', '$id_pinkel', '$jenis_pp','$nia','$tgl_proposal','$proposal','$proposal','$pros_jasa','$usaha','$jangka','$sistem','$sa_jasa','$status','$lu','$user_id')";
	mysql_query($input);
	
	
	$update	= "UPDATE anggota_$_SESSION[kd_kab] SET usaha='$usaha' WHERE id= '$nia' ";
	mysql_query($update);
}
?>