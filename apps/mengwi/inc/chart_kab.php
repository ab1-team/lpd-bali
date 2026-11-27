<?php session_start();
include "./inc.koneksi.php";
include "./fungsi_indotgl.php";
include "./fungsi_keuangan.php";
include "./fungsi_pinjaman.php";

$idf	= $_GET['idf'];
$m		= ($_GET['m']) ? $_GET['m']:date('m');
$y		= $_GET['y'] ? $_GET['m']:date('Y');

$now	=date('Y-m')."-31";
$tgl_kondisi= $y . "-" . $m . "-" . "15";
$kec = mysql_query("SELECT * FROM kecamatan WHERE kd_kab = $_SESSION[kd_kab]");
while($row = mysql_fetch_array($kec)) {
    $ap=asetproduktif("$tgl_kondisi", $row['kd_kec']);
    
    $data[] = array(
        array(
            "ap" => $ap,
            "kec" => $row['nama_kec']
        )
    );
}

echo json_encode($data);
?>