<?php
include "../inc/inc.koneksi.php";

$r=mysql_fetch_array(mysql_query("SELECT u.id,u.namabelakang, u.namadepan,c.id as id_kecamatan,c.kd_kab FROM kecamatan c join users u ON (c.id=u.lokasi) WHERE u.id=".$_GET['id']));

session_start();
$_SESSION['id'] = $r['id'];
$_SESSION['lokasi'] = $r['id_kecamatan'];
$_SESSION['kd_kab'] = $r['kd_kab'];
$_SESSION['namadepan'] = $r['namadepan'];
$_SESSION['namabelakang'] = $r['namabelakang'];

header("Location: ../modul/jurnal_angsuran/c_RK.php?&idp=".$_GET['idp']);
?>