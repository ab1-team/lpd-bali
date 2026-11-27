<?php session_start();
include "../../../inc/inc.koneksi.php";
$table		="pinjaman_anggota_$_SESSION[kd_kab]";

$jenis_pinjaman	= "K";
$id_kel			= $_POST['id_kel'];
$id_pinkel		= $_POST['id_pinkel'];
$kelompok		= mysql_fetch_array(mysql_query("SELECT * FROM pinjaman_kelompok_$_SESSION[kd_kab] WHERE id=$id_pinkel "));
$nia			= $_POST['nia'];
$jenis_pp		= $_POST['jenis_pp'];
$tgl_proposal	= $kelompok['tgl_proposal'];
$tgl_verifikasi	= $kelompok['tgl_verifikasi'];
$tgl_dana		= $kelompok['tgl_dana'];
$tgl_tunggu		= $kelompok['tgl_tunggu'];
$tgl_cair		= $kelompok['tgl_cair'];
$proposal		= $_POST['alokasi_anggota'];
$alokasi		= $_POST['alokasi_anggota'];
$spk_no			= $kelompok['spk_no'];
$sumber			= $kelompok['sumber'];
$pros_jasa		= $kelompok['pros_jasa'];
$jenis_jasa		= $kelompok['jenis_jasa'];
$jangka			= $kelompok['jangka'];
$sistem_angsuran= $kelompok['sistem_angsuran'];
$sa_jasa		= $kelompok['sa_jasa'];
$lu				= date('Y-m-d H:i:s');
$user_id		= $_SESSION['id'];
$status			= $kelompok['status'];

$sql = mysql_query("SELECT *
				   FROM $table 
				   WHERE nia= '$nia' AND `status`='$status' OR nia= '$nia' AND `status`='P' ");
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
	tgl_dana,
	tgl_tunggu,
	tgl_cair,
	proposal,
	verifikasi,
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
				'$tgl_dana',
				'$tgl_tunggu',
				'$tgl_cair',
				'$proposal',
				'$alokasi',
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
}
?>