<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";

$jenis_pinjaman	= "I" ?: '0';
$id_kel			= "0" ?: '0';
$id_pinkel		= "0" ?: '0';
$jenis_pp       = "0" ?: '0';
$proposal       = "0" ?: '0';
$pros_jasa      = "0" ?: '0';
$jenis_jasa     = "0" ?: '0';
$jangka         = "0" ?: '0';
$sistem         = "0" ?: '0';
$sa_jasa        = "0" ?: '0';
$nik            = $_POST['nik'] ?: '0';
$tgl_sekarang   = date('Y-m-d') ?: '0';
$lu				= date('Y-m-d H:i:s') ?: '0';
$user_id		= $_SESSION['id'] ?: '0';
$status			= "B" ?: '0';

$sql1 = mysql_fetch_array(mysql_query("SELECT id FROM anggota_$_SESSION[kd_kab] WHERE nik=$nik"));
$nia = $sql1['id'];

$input = "INSERT INTO $table (  jenis_pinjaman,
                                id_kel,
                                id_pinkel,
                                jenis_pp,
                                nia,
                                tgl_proposal,
                                tgl_verifikasi,
                                tgl_tunggu,
                                tgl_cair,
                                proposal,
                                alokasi,
                                pros_jasa,
                                jenis_jasa,
                                jangka,
                                sistem_angsuran,
                                sa_jasa,
                                status,
                                lu,
                                user_id)
				    VALUES(     '$jenis_pinjaman',
				                '$id_kel', 
				                '$id_pinkel', 
				                '$jenis_pp',
				                '$nia',
				                '$tgl_sekarang',
				                '$tgl_sekarang',
				                '$tgl_sekarang',
				                '$tgl_sekarang',
				                '$proposal',
				                '$proposal',
				                '$pros_jasa',
				                '$jenis_jasa',
				                '$jangka',
				                '$sistem',
				                '$sa_jasa',
				                '$status',
				                '$lu',
				                '$user_id')";
	mysql_query($input);

?>