<?php
if (!isset($_SESSION)) session_start();

include "../../inc/inc.koneksi.php";

$limit = $_GET['length'];
$start = $_GET['start'];
$search = $_GET['search']['value'];

$order = $_GET['order'][0]['column'];
$type = $_GET['order'][0]['dir'];

$ordering = $order . ' ' . $type;

$view = mysql_query("select * from desa d, anggota_$_SESSION[kd_kab] a WHERE d.id=a.desa AND lokasi='$_SESSION[lokasi]' AND (
                    a.nik LIKE '%$search%' OR a.namadepan LIKE '%$search%' OR a.alamat LIKE '%$search%' OR a.hp LIKE '%$search%') order by $ordering LIMIT $start, $limit");
$no = $start;

$rows = mysql_num_rows($view);
$total_rows = mysql_num_rows(mysql_query("select * from desa d, anggota_$_SESSION[kd_kab] a WHERE d.id=a.desa AND lokasi='$_SESSION[lokasi]'"));
$data = [];
while($row = mysql_fetch_array($view)) { 
	$no = $no+1;
	
	$dpa = mysql_query("select * from status_pinjaman s, pinjaman_anggota_$_SESSION[kd_kab] pa WHERE s.kd_status=pa.status AND pa.nia='$row[id]'");
	$pa	= mysql_num_rows($dpa);
	
	if ($pa > 0) {
		$r = mysql_fetch_array($dpa);
		$status = $r['kd_status']; 
		$bg = $r['warna_status'];
	} else {
	    $status = "N";
	    $bg = "default";
	}
	
	$jk = $row['jk'];
	if ($jk == "L") {
	    $gb = "male";
	} else {
	    $gb = "female";
	}
	
	$data[] = [
	    'no' => $no,
	    'nik' => $row['nik'],
	    'nama' => $row['namadepan'],
	    'alamat' => preg_replace('/[\x00-\x1F\x80-\xFF]/', ' ', $row['alamat'] . ' ' . $row['nama_desa']),
	    'hp'     => $row['hp'],
	    'status' => $status
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