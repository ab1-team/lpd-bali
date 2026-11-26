<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";

$jenis_pinjaman	= "K" ?: '0';
$id_kel			= $_POST['id_kel'] ?: '0';
$id_pinkel		= $_POST['id_pinkel'] ?: '0';
$kelompok		= mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_kelompok_$_SESSION[kd_kab] WHERE id=$id_pinkel "));
$nia			= $_POST['nia'] ?: '0';
$jenis_pp		= $_POST['jenis_pp'] ?: '0';
$tgl_proposal	= $kelompok['tgl_proposal'] ?: '0';
$tgl_verifikasi	= $kelompok['tgl_verifikasi'] ?: '0';
$tgl_tunggu		= $kelompok['tgl_tunggu'] ?: '0';
$tgl_cair		= $kelompok['tgl_cair'] ?: '0';
$proposal		= $_POST['alokasi_anggota'] ?: '0';
$alokasi		= $_POST['alokasi_anggota'] ?: '0';
$spk_no			= ($kelompok['spk_no'] == '') ? null:$kelompok['spk_no'];
$sumber			= ($kelompok['sumber'] == '') ? null:$kelompok['sumber'];
$pros_jasa		= $kelompok['pros_jasa'] ?: '0';
$jenis_jasa		= $kelompok['jenis_jasa'] ?: '0';
$jangka			= $kelompok['jangka'] ?: '0';
$sistem_angsuran= $kelompok['sistem_angsuran'] ?: '0';
$sa_jasa		= $kelompok['sa_jasa'] ?: '0';
$lu				= date('Y-m-d H:i:s') ?: '0';
$user_id		= $_SESSION['id'] ?: '0';
$status			= $kelompok['status'] ?: '0';

$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE nia= '$nia' AND `status`='$status' OR nia= '$nia' AND (`status`='P' or `status`='B') ");
$row	= mysql_num_rows($sql);
if ($row>0){
	$input	= "UPDATE $table			SET proposal			='$proposal',
											alokasi				='$proposal',
											lu					='$lu',
											user_id				='$user_id'
						WHERE nia= '$nia' AND `status`='$status' OR nia= '$nia' AND `status`='P' ";
	mysql_query($input);							
}else{
	$input = "INSERT INTO $table (
	jenis_pinjaman,
	id_kel,
	id_pinkel,
	nia,
	jenis_pp,
	tgl_proposal,
	tgl_verifikasi,
	tgl_tunggu,
	tgl_cair,
	proposal,
	alokasi,
	spk_no,
	sumber,
	pros_jasa,
	jenis_jasa,
	jangka,
	sistem_angsuran,
	sa_jasa,
	status,
	lu,
	user_id)
				VALUES(
				'$jenis_pinjaman',
				'$id_kel', 
				'$id_pinkel', 
				'$nia', 
				'$jenis_pp',
				'$tgl_proposal',
				'$tgl_verifikasi',
				'$tgl_tunggu',
				'$tgl_cair',
				'$proposal',
				'$alokasi',
				'$spk_no',
				'$sumber',
				'$pros_jasa',
				'$jenis_jasa',
				'$jangka',
				'$sistem_angsuran',
				'$sa_jasa',
				'$status',
				'$lu',
				'$user_id')";
	mysql_query($input);
	
        mysql_query("UPDATE `kecamatan` SET `maps` = 'INSERT INTO $table (
	jenis_pinjaman,
	id_kel,
	id_pinkel,
	nia,
	jenis_pp,
	tgl_proposal,
	tgl_verifikasi,
	tgl_tunggu,
	tgl_cair,
	proposal,
	alokasi,
	spk_no,
	sumber,
	pros_jasa,
	jenis_jasa,
	jangka,
	sistem_angsuran,
	sa_jasa,
	status,
	lu,
	user_id)
				VALUES(
				$jenis_pinjaman,
				$id_kel, 
				$id_pinkel, 
				$nia, 
				$jenis_pp,
				$tgl_proposal,
				$tgl_verifikasi,
				$tgl_tunggu,
				$tgl_cair,
				$proposal,
				$alokasi,
				$spk_no,
				$sumber,
				$pros_jasa,
				$jenis_jasa,
				$jangka,
				$sistem_angsuran,
				$sa_jasa,
				$status,
				$lu,
				$user_id)' WHERE `kecamatan`.`id` = 1;");
}
var_dump($input);
?>