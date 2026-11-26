<?php
include "../inc/inc.koneksi.php";
include "../inc/terbilang.php";
include "../inc/fungsi_indotgl.php";


$r=mysql_fetch_array(mysql_query("SELECT u.id,c.id as id_kecamatan,c.kd_kab FROM kecamatan c join users u ON (c.id=u.lokasi) WHERE u.id=".$_GET['id']));
$lapData=mysql_query("select * from jenis_laporan where nama_laporan='".str_replace("|"," ",$_GET['laporan'])."'");
$laporan=mysql_fetch_array($lapData);

$bulan = array(
	'JANUARI' => '01',
	'FEBRUARI' => '02',
	'MARET' => '03',
	'APRIL' => '04',
	'MEI' => '05',
	'JUNI' => '06',
	'JULI' => '07',
	'AGUSTUS' => '08',
	'SEPTEMBER' => '09',
	'OKTOBER' => '10',
	'NOVEMBER' => '11',
	'DESEMBER' => '12');

$efile = $laporan['file'];
$idf = null;



if (isset($_GET['sub']) and $_GET['sub'] != "0") {
	$s = explode(" - ",str_replace("|"," ",$_GET['sub']));
	$esub = explode('-',$s[0]);
	$efile = $esub[0];
	$idf = $esub[1];
}

$id_lokasi = $r['id_kecamatan'];
$id_user = $r['id'];
$lokasi				=$id_lokasi;
$table_transaksi	="transaksi_".$id_lokasi;
// $d					=($_GET['d']==NULL or $_GET['d']=="-")?null:$_GET['d'];
// $m					=($_GET['m']==NULL or $_GET['m']=="-")?date('m'):$bulan[$_GET['m']];
// $y					=($_GET['y']==NULL or $_GET['y']=="-")?date('Y'):$_GET['y'];
// $tgl				="$y-$m-$d";

$tgl = $_GET['tanggal'];

$d=date('d', strtotime($tgl));
$m=date('m', strtotime($tgl));
$y=date('Y', strtotime($tgl));

session_start();
$_SESSION['id'] = $id_user;
$_SESSION['lokasi'] = $lokasi;
$_SESSION['kd_kab'] = $r['kd_kab'];

// header("Location: ../modul/pelaporan/p/".$efile.".php?idf=".$idf."&y=".$y."&m=".$m."&d=".$d);

echo json_encode([$efile, $idf, $tgl, $_SESSION['id'], $_SESSION['lokasi'],$_SESSION['kd_kab']]);


?>