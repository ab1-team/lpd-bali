<?php
include "../../inc/inc.koneksi.php";
$nama_file = $_GET['id'].'.png';
$direktori = '../../foto_anggota/';
$target = $direktori.$nama_file;

move_uploaded_file($_FILES['webcam']['tmp_name'], $target);
?>