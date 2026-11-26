<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";

$jenis_pinjaman	= "I" ?: '0';
$id_kel			= "0" ?: '0';
$id_pinkel		= "0" ?: '0';
$id_pinj		= $_POST['id_pinj'] ?: '0';
$nia			= $_POST['nia'] ?: '0';
$jenis_pp		= $_POST['jenis_pp'] ?: '0';
$nama_barang	= $_POST['nama_barang'] ?: '0';
$proposal		= $_POST['proposali'] ?: '0';
$tgl_proposal	= $_POST['tgl_proposal'] ?: '0';
$pros_jasa		= $_POST['pros_jasa'] ?: '0';
$jenis_jasa		= $_POST['jenis_jasa'] ?: '0';
$jangka			= $_POST['jangka'] ?: '0';
$sistem			= $_POST['sistem'] ?: '0';
$sa_jasa		= $_POST['sa_jasa'] ?: '0';
$lu				= date('Y-m-d H:i:s') ?: '0';
$user_id		= $_SESSION['id'] ?: '0';
$status			= "P";


$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE nia= '$nia' AND `status`='$status' ");
$row	= mysql_num_rows($sql);
if($_SESSION['kd_kab']==11 or $_SESSION['kd_kab']==23 or  $_SESSION['kd_kab']==2 ){
    if ($row>0){
	    $input	= "UPDATE $table			SET jenis_pp		='$jenis_pp',
											nama_barang			='$nama_barang',
											tgl_proposal		='$tgl_proposal',
											proposal			='$proposal',
											alokasi				='$proposal',
											pros_jasa			='$pros_jasa',
											jenis_jasa			='$jenis_jasa',
											jangka				='$jangka',
											sistem_angsuran		='$sistem',
											sa_jasa				='$sa_jasa',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id= '$id_pinj' AND nia= '$nia' AND `status`='$status'";
	mysql_query($input);							
}else{
	
	$input = "INSERT INTO $table (jenis_pinjaman,id_kel,id_pinkel,jenis_pp,nama_barang,nia,tgl_proposal,proposal,alokasi,pros_jasa,jenis_jasa,jangka,sistem_angsuran,sa_jasa,status,lu,user_id)
				VALUES('$jenis_pinjaman','$id_kel', '$id_pinkel', '$jenis_pp', '$nama_barang','$nia','$tgl_proposal','$proposal','$proposal','$pros_jasa','$jenis_jasa','$jangka','$sistem','$sa_jasa','$status','$lu','$user_id')";
	mysql_query($input);
}}else{
    if ($row>0){
	$input	= "UPDATE $table			SET jenis_pp			='$jenis_pp',
											tgl_proposal		='$tgl_proposal',
											proposal			='$proposal',
											alokasi				='$proposal',
											pros_jasa			='$pros_jasa',
											jenis_jasa			='$jenis_jasa',
											jangka				='$jangka',
											sistem_angsuran		='$sistem',
											sa_jasa				='$sa_jasa',
											lu					='$lu',
											user_id				='$user_id'
						WHERE id= '$id_pinj' AND nia= '$nia' AND `status`='$status'";
	mysql_query($input);							
}else{
	
	$input = "INSERT INTO $table (jenis_pinjaman,id_kel,id_pinkel,jenis_pp,nia,tgl_proposal,proposal,alokasi,pros_jasa,jenis_jasa,jangka,sistem_angsuran,sa_jasa,status,lu,user_id)
				VALUES('$jenis_pinjaman','$id_kel', '$id_pinkel', '$jenis_pp','$nia','$tgl_proposal','$proposal','$proposal','$pros_jasa','$jenis_jasa','$jangka','$sistem','$sa_jasa','$status','$lu','$user_id')";
	mysql_query($input);
}}
?>