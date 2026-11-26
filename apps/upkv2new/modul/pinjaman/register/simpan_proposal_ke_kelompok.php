<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";

$id_pinj		= $_POST['kelompoke'] ?: '0';
$proposal		= $_POST['alokasi'] ?: '0';

$nia			= $_POST['nia'] ?: '0';

$kel=mysql_fetch_array(mysql_query("select * from pinjaman_kelompok_$_SESSION[kd_kab] where id='$id_pinj'"));


$jenis_pinjaman	= "K";
$id_kel			= $kel['id_kel'];
$id_pinkel		= $kel['id'];
$jenis_pp		= $kel['jenis_pp'];
$tgl_proposal	= $kel['tgl_proposal'];
$pros_jasa		= $kel['pros_jasa'];
$jenis_jasa		= $kel['jenis_jasa'];
$jangka			= $kel['jangka'];
$sistem			= $kel['sistem_angsuran'];
$lu				= date('Y-m-d H:i:s');
$user_id		= $_SESSION['id'];
$status			= "P";

$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE nia= '$nia' AND `status`='$status' ");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table			SET jenis_pp			='$jenis_pp',
											tgl_proposal		='$tgl_proposal',
											proposal			='$proposal',
											alokasi				='$proposal',
											pros_jasa			='$pros_jasa',
											jenis_jasa			='$jenis_jasa',
											jangka				='$jangka',
											sistem_angsuran		='$sistem',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id= '$id_pinj' AND nia= '$nia' AND `status`='$status'";
	mysql_query($input);							
}else{
	
	$input = "INSERT INTO $table (jenis_pinjaman,id_kel,id_pinkel,jenis_pp,nia,tgl_proposal,proposal,alokasi,pros_jasa,jenis_jasa,jangka,sistem_angsuran,status,lu,user_id)
				VALUES('$jenis_pinjaman','$id_kel', '$id_pinkel', '$jenis_pp','$nia','$tgl_proposal','$proposal','$proposal','$pros_jasa','$jenis_jasa','$jangka','$sistem','$status','$lu','$user_id')";
	mysql_query($input);
}
?>