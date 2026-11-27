<?php session_start();
include "../../../inc/inc.koneksi.php";
$id_pinj	= $_SESSION['id_pinj'];

$row=mysql_fetch_array(mysql_query("select * from pinjaman_kelompok_$_SESSION[kd_kab]
																WHERE
																id='$id_pinj' "));	


echo "
<div class='h4'>
SPK Nomor. <span class='fw-semi-bold'>$row[spk_no]</span>
</div>

";																
?>

