<?php session_start();
include "../../../inc/inc.koneksi.php";
include "../../../inc/fungsi_indotgl.php";
include "../../../inc/terbilang.php";
ini_set('display_errors', 1); ini_set('error_reporting', E_ERROR);

$pemanfaat	= $_POST['pemanfaat'];

echo "Kata kunci pencarian : <strong>$pemanfaat</strong>";

?>