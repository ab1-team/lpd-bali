<?php
include "../inc/inc.koneksi.php";

$r=mysql_fetch_array(mysql_query("SELECT u.id,c.id as id_kecamatan,c.kd_kab FROM kecamatan c join users u ON (c.id=u.lokasi) WHERE u.id=".$_GET['id']));

session_start();
$_SESSION['id'] = $r['id'];
$_SESSION['lokasi'] = $r['id_kecamatan'];
$_SESSION['kd_kab'] = $r['kd_kab'];

$efile = $_GET['tipe'];
$sub = (isset($_GET['sT']) and $_GET['sT'] != NULL) ? "?sT=".$_GET['sT'] : null;

header("Location: ../modul/pinjaman/cp/".$efile.".php".$sub);
?>