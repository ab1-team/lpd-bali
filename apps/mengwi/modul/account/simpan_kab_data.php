<?php session_start();
include "../../inc/inc.koneksi.php";
$id = $_SESSION['id'];

$nama_prov = $_POST['nama_prov'];
$nama_kab = $_POST['nama_kab'];
$nama_lembaga = $_POST['nama_lembaga'];
$alamat_kab = $_POST['alamat_kab'];
$telpon_kab = $_POST['telpon_kab'];
$no_bh = $_POST['no_bh'];
$email_kab = $_POST['email_kab'];

$input	= "UPDATE kabupaten SET nama_prov='$nama_prov',
                                nama_kab='$nama_kab',
                                nama_lembaga='$nama_lembaga',
                                alamat_kab='$alamat_kab',
                                telpon_kab='$telpon_kab',
                                no_bh='$no_bh',
                                email_kab='$email_kab'
                            WHERE id = '$id'";
$query = mysql_query($input);
?>