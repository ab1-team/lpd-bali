<?php 
include "inc/inc.koneksi.php";
$kd_kab = $_POST['kd_kab'];
$kec = mysql_fetch_array(mysql_query("SELECT * FROM kecamatan WHERE kd_kab=$kd_kab"));

?>