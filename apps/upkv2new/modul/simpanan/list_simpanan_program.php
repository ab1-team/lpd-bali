<?php 
if (!isset($_SESSION)) session_start();
include '../../inc/inc.koneksi.php';
include "../../inc/fungsi_simpanan_individu.php";

$limit = $_GET['length'];
$start = $_GET['start'];
$search = $_GET['search']['value'];
$order = $_GET['order'][0]['column'];
$type = $_GET['order'][0]['dir'];

$ordering = ($order != 'no') ? $order . ' ' . $type:'si.id';

$view = mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, status_simpanan ss, jenis_simpanan js, simpanan_anggota_$_SESSION[kd_kab] si
					WHERE a.id=si.nia AND si.jenis_simpanan=js.id AND ss.kd_status=si.status AND si.lokasi='$_SESSION[lokasi]'
					AND si.jenis_simpanan='3' AND (si.id LIKE '%$search%' OR si.tgl_buka LIKE '%$search%' OR si.nomor_rekening LIKE '%$search%' OR
					a.namadepan LIKE '%$search%') order by $ordering LIMIT $start, $limit");

$rows = mysql_num_rows($view);
$total_rows = mysql_num_rows(mysql_query("SELECT * FROM anggota_$_SESSION[kd_kab] a, status_simpanan ss, jenis_simpanan js, simpanan_anggota_$_SESSION[kd_kab] si
					WHERE a.id=si.nia AND si.jenis_simpanan=js.id AND ss.kd_status=si.status AND si.lokasi='$_SESSION[lokasi]'
					AND si.jenis_simpanan='3' AND (si.id LIKE '%$search%' OR si.tgl_buka LIKE '%$search%' OR si.nomor_rekening LIKE '%$search%' OR
					a.namadepan LIKE '%$search%') order by $ordering"));

$no = $start;
$status = "AKTIF";
$nama = "pencairan";
$data = [];
while ($row = mysql_fetch_array($view)) {
	$no = $no+1;
	$idsimp			= $row['id'];
	$tgl_now		= date('Y-m-d');
	$sumambil		= sumambil("$tgl_now-$idsimp");
	$sumnabung		= sumnabung("$tgl_now-$idsimp");
	$saldosimpanan	= saldosimpanan("$tgl_now-$idsimp");
	$sts			= $row['status'];
	if ($row['lembaga'] == NULL or $row['lembaga'] == '') {
	    $nama			= $row['namadepan'];
	} else {
	    $nama			= "$row[namadepan] QQ $row[lembaga]" ;	
	}
	
	$data[] = [
	    "no" => $no,
	    "cif" => $row['id'],
	    "tgl_buka" => $row['tgl_buka'],
	    "norek" => $row['nomor_rekening'],
	    "nama" => $nama,
	    "debit" => number_format($sumambil),
	    "kredit" => number_format($sumnabung),
	    "saldo" => number_format($saldosimpanan),
	    "status" => $status
	];
}



if ($total_rows < 1) {
    $output = [
        "draw"              =>  intval($_POST["draw"]),
        "recordsTotal"      =>  0,
        "recordsFiltered"   =>  0,
        "data"              =>  ['' => '']
    ];
} else {
    $output = [
        "draw"              =>  intval($_POST["draw"]),
        "recordsTotal"      =>  $rows,
        "recordsFiltered"   =>  $total_rows,
        "data"              =>  $data
    ];
}

echo json_encode($output);
?>