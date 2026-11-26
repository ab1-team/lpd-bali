<?php session_start();
include "../../inc/inc.koneksi.php";
include "../../inc/fungsi_indotgl.php";

$tp=mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE id='$_SESSION[lokasi]' "));
			$tgl_pakai		=$tp['tgl_pakai'];
?>


<div class="alert alert-danger mt animated fadeInDown">
    <span class="create-server-name"></span><i class="fa fa-warning"></i> <strong>Perhatian!</strong><br>
	Silahkan Lengkapi data transaksi Anda!
</div>