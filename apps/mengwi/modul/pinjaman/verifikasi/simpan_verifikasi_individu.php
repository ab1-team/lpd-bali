<?php session_start();
include "../../../inc/inc.koneksi.php";

$id_pinj			= $_POST['id_pinj'];
$tgl_verifikasi		= $_POST['tgl_verifikasi'];
$alokasi			= $_POST['alokasi'];
$pros_jasa			= $_POST['pros_jasa'];
$jangka				= $_POST['jangka'];
$sistem				= $_POST['sistem'];
$catatan_verifikasi	= $_POST['catatan_verifikasi'];
$lu					= date('Y-m-d H:i:s');
$user_id			= $_SESSION['id'];

$data = "";
$status = "W";
$tgl_tunggu = $tgl_verifikasi;
$tgl_lunas = '0000-00-00';
$tgl_dana = '0000-00-00';
$tgl_cair = '0000-00-00';
if ($alokasi == null || !$alokasi || $alokasi < 1 || $alokasi == '0') {
    $status = 'T';
    $tgl_lunas = date('Y-m-d');
    $tgl_verifikasi = date('Y-m-d');
    $tgl_dana = date('Y-m-d');
    $tgl_tunggu = date('Y-m-d');
    $tgl_cair = date('Y-m-d');
}
	$input2	= "UPDATE pinjaman_anggota_$_SESSION[kd_kab] SET tgl_verifikasi	='$tgl_verifikasi',
	                                        tgl_tunggu		='$tgl_tunggu',
	                                        tgl_lunas		='$tgl_lunas',
	                                        tgl_cair		='$tgl_cair',
											alokasi			='$alokasi',
											pros_jasa			='$pros_jasa',
											jangka				='$jangka',
											sistem_angsuran		='$sistem',
											catatan_verifikasi		='$catatan_verifikasi',
											status				='$status',
											lu					='$lu',
											user_id				='$user_id' WHERE id= '$id_pinj' ";
	$query = mysql_query($input2);
    echo $query;

?>