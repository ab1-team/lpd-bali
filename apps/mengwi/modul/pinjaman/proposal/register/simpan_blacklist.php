<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";

$jenis_pinjaman	= "I";
$id_kel			= "0";
$id_pinkel		= "0";
$nik			= $_POST['nik'];
$jenis_pp       = "0";
$proposal       = "0";
$pros_jasa      = "0";
$jenis_jasa     = "0";
$jangka         = "0";
$sistem         = "0";
$sa_jasa        = "0";
$tgl_sekarang   = date('Y-m-d');
$lu				= date('Y-m-d H:i:s');
$user_id		= $_SESSION['id'];
$status			= "B";

$sql1 = mysql_fetch_array(mysql_query("SELECT id FROM anggota_$_SESSION[kd_kab] WHERE nik=$nik "));
$nia = $sql1['id'];

$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE nia= '$nia' AND `status`='$status' ");
$row	= mysql_num_rows($sql);

	
	$input = "INSERT INTO $table ( jenis_pinjaman,
	                               id_kel,
	                               id_pinkel,
	                               jenis_pp,
	                               nia,
	                               tgl_proposal,
	                               tgl_verifikasi,
	                               tgl_dana,
	                               tgl_tunggu,
	                               tgl_cair,
	                               proposal,
	                               verifikasi,
	                               alokasi,
	                               pros_jasa,
	                               jenis_jasa,
	                               jangka,
	                               sistem_angsuran,
	                               sa_jasa,
	                               status,
	                               lu,
	                               user_id )
        				VALUES  ( '$jenis_pinjaman',
        				        '$id_kel', 
        				        '$id_pinkel', 
        				        '$jenis_pp',
        				        '$nia',
        				        '$tgl_sekarang',
        				        '$tgl_sekarang',
        				        '$tgl_sekarang',
        				        '$tgl_sekarang',
        				        '$tgl_sekarang',
        				        '$proposal',
        				        '$proposal',
        				        '$proposal',
        				        '$pros_jasa',
        				        '$jenis_jasa',
        				        '$jangka',
        				        '$sistem',
        				        '$sa_jasa',
        				        '$status',
        				        '$lu',
        				        '$user_id' )";
	mysql_query($input);
?>