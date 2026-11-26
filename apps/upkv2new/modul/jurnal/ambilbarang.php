<?php session_start();
include "../../inc/inc.koneksi.php";
$barang = $_POST['barang'];

$row=mysql_fetch_array(mysql_query("select * from inventaris_$_SESSION[kd_kab] WHERE id='$barang' "));

echo "$row[unit]";

?>
